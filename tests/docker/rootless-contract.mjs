import assert from 'node:assert/strict';
import { randomUUID } from 'node:crypto';
import { mkdir, readFile, readdir, stat, writeFile } from 'node:fs/promises';
import { dirname, resolve } from 'node:path';
import process from 'node:process';
import { test } from 'node:test';
import { setTimeout as delay } from 'node:timers/promises';
import { parseArgs } from 'node:util';
import { command } from './docker-command.mjs';

const { fetch, AbortSignal } = globalThis;
const { values } = parseArgs({ options: {
	image: { type: 'string', default: 'freshrss:rootless' },
	engine: { type: 'string', default: 'rootless' },
	'expected-image-id': { type: 'string' },
	'bind-data': { type: 'string' },
	report: { type: 'string' },
	help: { type: 'boolean', default: false },
} });

if (values.help) {
	console.log('Usage: node tests/docker/rootless-contract.mjs [--image IMAGE] [--engine rootless|rootful] [--expected-image-id ID]');
	console.log('       [--bind-data EMPTY_LINUX_DIRECTORY] [--report FILE.json]');
	process.exit(0);
}
assert.ok(['rootless', 'rootful'].includes(values.engine), '--engine must be rootless or rootful');

test('FreshRSS rootless image contract', { timeout: 300_000 }, async t => {
	const prefix = `freshrss-rootless-contract-${randomUUID().slice(0, 8)}`;
	const containers = [];
	const volumes = [];
	const passed = new Set();
	const bindSentinels = [];
	const report = { suiteVersion: 1, image: values.image, adapter: 'rootless-contract.mjs',
		expectedEngine: values.engine, completed: false, tests: [] };
	let primary;

	async function docker(args, options) {
		const result = await command(args, options);
		assert.equal(result.code, 0, `Docker ${args[0]} failed: ${result.stderr.toString().trim()}`);
		return result.stdout.toString().trim();
	}

	async function check(name, fn, dependencies = []) {
		const missing = dependencies.filter(dependency => !passed.has(dependency));
		if (missing.length) {
			report.tests.push({ name, status: 'skipped', reason: 'Prerequisite failed' });
			await t.test(name, { skip: 'Prerequisite failed' }, () => {});
			return false;
		}
		let success = false;
		await t.test(name, async () => {
			const started = Date.now();
			try {
				await fn();
				passed.add(name);
				success = true;
				report.tests.push({ name, status: 'passed', durationMs: Date.now() - started });
			} catch (error) {
				report.tests.push({ name, status: 'failed', durationMs: Date.now() - started });
				throw error;
			}
		});
		return success;
	}

	async function freshVolume(label) {
		const name = `${prefix}-${label}`;
		await docker(['volume', 'create', name]);
		volumes.push(name);
		return name;
	}

	async function launch(label, { volume, listen, port, cron = '', bindData = false } = {}) {
		const name = `${prefix}-${label}`;
		const args = ['run', '--detach', '--name', name, '--publish', `127.0.0.1::${port ?? 8080}`];
		if (bindData) args.push('--mount', `type=bind,source=${resolve(values['bind-data'])},target=/var/www/FreshRSS/data`);
		else if (volume) args.push('--mount', `type=volume,source=${volume},target=/var/www/FreshRSS/data`);
		if (listen) args.push('--env', `LISTEN=${listen}`);
		args.push('--env', `CRON_MIN=${cron}`, values.image);
		await docker(args);
		containers.push(name);
		const published = await docker(['port', name, `${port ?? 8080}/tcp`]);
		const hostPort = published.split(':').at(-1);
		return { name, url: `http://127.0.0.1:${hostPort}/` };
	}

	async function waitForHttp(url) {
		const deadline = Date.now() + 45_000;
		while (Date.now() < deadline) {
			try {
				const response = await fetch(url, { redirect: 'follow', signal: AbortSignal.timeout(2000) });
				const body = await response.text();
				if (response.status < 500) return { status: response.status, body };
			} catch {}
			await delay(250);
		}
		throw new Error(`FreshRSS did not serve HTTP at ${url}`);
	}

	function assertInstaller(response) {
		assert.ok([200, 302].includes(response.status), `Unexpected installer response: ${response.status}`);
		assert.match(response.body, /Installation.*FreshRSS|FreshRSS.*[Ii]nstall/, 'HTTP response was not the FreshRSS installer');
	}

	async function cleanup() {
		const errors = [];
		for (const { hostPath, filename } of bindSentinels) {
			const result = await command(['run', '--rm', '--user', '33:33', '--entrypoint', '/bin/rm',
				'--mount', `type=bind,source=${hostPath},target=/cleanup`, values.image, '-f', `/cleanup/${filename}`]);
			if (result.code !== 0) errors.push(`bind sentinel ${hostPath}/${filename}: ${result.stderr.toString().trim()}`);
		}
		for (const name of containers.reverse()) {
			const result = await command(['rm', '--force', name]);
			if (result.code !== 0) errors.push(`container ${name}: ${result.stderr.toString().trim()}`);
		}
		for (const name of volumes.reverse()) {
			const result = await command(['volume', 'rm', name]);
			if (result.code !== 0) errors.push(`volume ${name}: ${result.stderr.toString().trim()}`);
		}
		if (errors.length) throw new Error(`Docker test cleanup failed: ${errors.join('; ')}`);
	}

	t.after(async () => {
		try {
			await cleanup();
			report.cleanup = 'passed';
		} catch (error) {
			report.cleanup = 'failed';
			throw error;
		} finally {
			report.success = report.completed && report.tests.every(result => result.status === 'passed') && report.cleanup === 'passed';
			if (values.report) {
				await mkdir(dirname(resolve(values.report)), { recursive: true });
				await writeFile(resolve(values.report), `${JSON.stringify(report, null, 2)}\n`);
			}
		}
	});

	const imageCheck = 'image declares the fixed nonroot identity and default listener';
	const engineCheck = `selected Docker daemon is ${values.engine}`;
	const volumeCheck = 'fresh named volume works without ownership preparation and installer is reachable';

	await check(imageCheck, async () => {
		const [image] = JSON.parse(await docker(['image', 'inspect', values.image]));
		assert.equal(image.Config.User, '33:33');
		assert.ok(image.Config.ExposedPorts?.['8080/tcp'], 'Image does not expose 8080/tcp');
		assert.ok(image.Config.Env.includes('FRESHRSS_ENTRYPOINT_PROFILE=rootless'), 'Rootless entrypoint profile is missing');
		assert.ok(image.Config.Env.includes('FRESHRSS_RUNTIME_DIR=/run/freshrss'), 'Private runtime directory is missing');
		if (values['expected-image-id']) assert.equal(image.Id, values['expected-image-id'], 'Image ID differs from the expected tested image');
		report.imageId = image.Id;
		report.platform = `${image.Os}/${image.Architecture}`;
	});

	await check(engineCheck, async () => {
		const securityOptions = JSON.parse(await docker(['info', '--format', '{{json .SecurityOptions}}']));
		const isRootless = securityOptions.some(option => /(^|,)name=rootless(,|$)/.test(option));
		assert.equal(isRootless, values.engine === 'rootless', `Docker security options: ${JSON.stringify(securityOptions)}`);
		report.engine = { kind: values.engine, context: await docker(['context', 'show']), securityOptions };
	});

	await check('entrypoint rejects root and changed UID/GID overrides', async () => {
		for (const user of ['1000:1000', '0:0']) {
			const result = await command(['run', '--rm', '--user', user, values.image]);
			assert.notEqual(result.code, 0, `Image unexpectedly started with UID/GID ${user}`);
			assert.match(result.stderr.toString() + result.stdout.toString(), user === '0:0' ? /must not run as uid 0/i : /requires UID\/GID 33:33/i);
		}
	}, [imageCheck]);

	await check(volumeCheck, async () => {
		const volume = await freshVolume('named-data');
		primary = await launch('default', { volume, cron: '1' });
		const response = await waitForHttp(primary.url);
		assertInstaller(response);
		const ownership = await docker(['exec', primary.name, 'stat', '-c', '%u:%g:%a', '/var/www/FreshRSS/data']);
		assert.equal(ownership, '33:33:700', 'Fresh named volume did not inherit the image data directory ownership/mode');
	}, [imageCheck, engineCheck]);

	await check('Apache, PHP CLI, and scheduled refresh run as UID/GID 33:33', async () => {
		const id = (await docker(['exec', primary.name, '/bin/sh', '-c', 'id -u; id -g'])).split(/\s+/);
		assert.deepEqual(id, ['33', '33']);
		const script = String.raw`$found = []; foreach (glob("/proc/[0-9]*/status") as $file) { $s = file_get_contents($file); $cmd = str_replace("\0", " ", @file_get_contents(dirname($file) . "/cmdline")); if (preg_match("/^Name:\\s+apache2$/m", $s) || str_contains($cmd, "rootless-cron.sh") || str_contains($cmd, "/usr/bin/snooze")) { preg_match("/^Uid:\\s+(\\d+)\\s+(\\d+)/m", $s, $u); preg_match("/^Gid:\\s+(\\d+)\\s+(\\d+)/m", $s, $g); $found[] = ["name" => trim($cmd), "uid" => (int)$u[2], "gid" => (int)$g[2]]; } } echo json_encode($found);`;
		const deadline = Date.now() + 10_000;
		let processes = [];
		while (Date.now() < deadline) {
			processes = JSON.parse(await docker(['exec', primary.name, 'php', '-r', script]));
			if (processes.some(entry => entry.name.includes('rootless-cron.sh') || entry.name.includes('/usr/bin/snooze'))) break;
			await delay(250);
		}
		const apache = processes.filter(entry => entry.name.includes('apache2'));
		const scheduler = processes.filter(entry => entry.name.includes('rootless-cron.sh') || entry.name.includes('/usr/bin/snooze'));
		assert.ok(apache.length > 0, 'No Apache process found');
		assert.ok(scheduler.length > 0, 'CRON_MIN did not start the rootless scheduler');
		assert.ok(processes.every(entry => entry.uid === 33 && entry.gid === 33), `Process identities: ${JSON.stringify(processes)}`);
	}, [volumeCheck]);

	await check('named-volume data persists across container recreation', async () => {
		const marker = `${prefix}-persisted`;
		await docker(['exec', primary.name, '/bin/sh', '-c', `printf '%s' '${marker}' > /var/www/FreshRSS/data/.rootless-contract-marker`]);
		const oldName = primary.name;
		await docker(['rm', '--force', oldName]);
		containers.splice(containers.indexOf(oldName), 1);
		primary = await launch('recreated', { volume: volumes[0] });
		await waitForHttp(primary.url);
		assert.equal(await docker(['exec', primary.name, 'cat', '/var/www/FreshRSS/data/.rootless-contract-marker']), marker);
	}, [volumeCheck]);

	if (values['bind-data']) {
		await check('prepared host bind mount is writable and persists across container recreation', async () => {
			const hostPath = resolve(values['bind-data']);
			const info = await stat(hostPath);
			assert.ok(info.isDirectory(), '--bind-data must be an existing directory');
			assert.deepEqual(await readdir(hostPath), [], '--bind-data must be an empty disposable directory');
			const bindTarget = await launch('bind-data', { port: 8080, bindData: true });
			await waitForHttp(bindTarget.url);
			const markerFilename = '.rootless-contract-host-marker';
			const markerPath = resolve(hostPath, markerFilename);
			bindSentinels.push({ hostPath, filename: markerFilename });
			const marker = `${prefix}-host-persisted`;
			await docker(['exec', bindTarget.name, '/bin/sh', '-c', `printf '%s' '${marker}' > /var/www/FreshRSS/data/.rootless-contract-host-marker`]);
			assert.equal(await readFile(markerPath, 'utf8'), marker);
			await docker(['rm', '--force', bindTarget.name]);
			containers.splice(containers.indexOf(bindTarget.name), 1);
			const recreated = await launch('bind-data-recreated', { port: 8080, bindData: true });
			await waitForHttp(recreated.url);
			assert.equal(await docker(['exec', recreated.name, 'cat', '/var/www/FreshRSS/data/.rootless-contract-host-marker']), marker);
		}, [imageCheck, engineCheck]);
	}

	await check('LISTEN override serves the FreshRSS installer on the configured port', async () => {
		const volume = await freshVolume('listen-data');
		const override = await launch('listen-override', { volume, listen: '0.0.0.0:8081', port: 8081 });
		assertInstaller(await waitForHttp(override.url));
	}, [imageCheck, engineCheck]);

	report.completed = true;
});
