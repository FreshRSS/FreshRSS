import assert from 'node:assert/strict';
import { randomUUID } from 'node:crypto';
import { mkdir, readFile, readdir, stat, writeFile } from 'node:fs/promises';
import { createServer } from 'node:http';
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

test('FreshRSS rootless image contract', { timeout: 480_000 }, async t => {
	const prefix = `freshrss-rootless-contract-${randomUUID().slice(0, 8)}`;
	const containers = [];
	const volumes = [];
	const passed = new Set();
	const bindSentinels = [];
	const fixtureServers = [];
	const report = { suiteVersion: 1, image: values.image, adapter: 'rootless-contract.mjs',
		expectedEngine: values.engine, completed: false, tests: [] };
	let primary;

	async function docker(args, options) {
		const result = await command(args, options);
		assert.equal(result.code, 0, `Docker ${args[0]} failed: ${result.stderr.toString().trim()}`);
		return result.stdout.toString().trim();
	}

	async function containerLogs(name) {
		const result = await command(['logs', name]);
		assert.equal(result.code, 0, `Docker logs failed: ${result.stderr.toString().trim()}`);
		return `${result.stdout.toString()}${result.stderr.toString()}`.trim();
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

	async function launch(label, { volume, listen, port, cron = '', bindData = false, env = {}, addHostGateway = false } = {}) {
		const name = `${prefix}-${label}`;
		const args = ['run', '--detach', '--name', name, '--publish', `127.0.0.1::${port ?? 8080}`];
		if (bindData) args.push('--mount', `type=bind,source=${resolve(values['bind-data'])},target=/var/www/FreshRSS/data`);
		else if (volume) args.push('--mount', `type=volume,source=${volume},target=/var/www/FreshRSS/data`);
		if (addHostGateway) args.push('--add-host', 'host.docker.internal:host-gateway');
		if (listen) args.push('--env', `LISTEN=${listen}`);
		for (const [key, value] of Object.entries(env)) args.push('--env', `${key}=${value}`);
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
		for (const server of fixtureServers) {
			await new Promise(resolveClose => server.close(resolveClose));
		}
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

	await check('startup completes a partially initialized data directory without losing existing files', async () => {
		const volume = await freshVolume('partial-data');
		const marker = `${prefix}-partial-data-preserved`;
		await docker(['run', '--rm', '--user', '33:33', '--entrypoint', '/bin/sh',
			'--mount', `type=volume,source=${volume},target=/var/www/FreshRSS/data`, values.image,
			'-c', `mkdir -p /var/www/FreshRSS/data/users/_ && printf '%s' '${marker}' > /var/www/FreshRSS/data/users/_/.rootless-contract-marker`]);

		const partial = await launch('partial-data', { volume });
		assertInstaller(await waitForHttp(partial.url));
		const state = JSON.parse(await docker(['exec', partial.name, 'php', '-r', String.raw`$root = '/var/www/FreshRSS/data'; $dirs = ['', '/cache', '/extensions-data', '/favicons', '/fever', '/PubSubHubbub', '/PubSubHubbub/feeds', '/PubSubHubbub/keys', '/Retry-After', '/tokens', '/users', '/users/_']; $missing = []; foreach ($dirs as $dir) { $path = $root . $dir; if (!is_dir($path)) { $missing[] = $dir . ' (directory)'; continue; } if (!is_file($path . '/index.html')) $missing[] = $dir . '/index.html'; } $htaccess = @file_get_contents($root . '/.htaccess'); if ($htaccess === false || !str_contains($htaccess, 'Require all denied')) $missing[] = '.htaccess deny rule'; $marker = @file_get_contents($root . '/users/_/.rootless-contract-marker'); echo json_encode(['missing' => $missing, 'marker' => $marker, 'uid' => fileowner($root), 'gid' => filegroup($root)]);`]));
		assert.deepEqual(state.missing, [], `FreshRSS did not complete the partial data layout: ${state.missing.join(', ')}`);
		assert.equal(state.marker, marker, 'Startup changed or removed existing user data');
		assert.equal(`${state.uid}:${state.gid}`, '33:33', 'Prepared data directory is not owned by the application identity');
	}, [imageCheck, engineCheck]);

	await check('Apache and scheduler processes, plus PHP CLI, run as UID/GID 33:33', async () => {
		const id = (await docker(['exec', primary.name, '/bin/sh', '-c', 'id -u; id -g'])).split(/\s+/);
		assert.deepEqual(id, ['33', '33']);
		const cliIdentity = await docker(['exec', primary.name, 'php', '-r', String.raw`$s = file_get_contents('/proc/self/status'); preg_match('/^Uid:\s+\d+\s+(\d+)/m', $s, $u); preg_match('/^Gid:\s+\d+\s+(\d+)/m', $s, $g); echo $u[1] . ':' . $g[1];`]);
		assert.equal(cliIdentity, '33:33', 'PHP CLI does not run as UID/GID 33:33');
		const script = String.raw`$found = []; $self = getmypid(); foreach (glob("/proc/[0-9]*/status") as $file) { $pid = (int)basename(dirname($file)); if ($pid === $self) continue; $s = @file_get_contents($file); $raw = @file_get_contents(dirname($file) . "/cmdline"); if ($s === false || $raw === false) continue; $argv = explode("\0", trim($raw, "\0")); $comm = ''; preg_match("/^Name:\\s+(.*)$/m", $s, $n); if (isset($n[1])) $comm = trim($n[1]); $isCronScript = array_filter($argv, fn($arg) => preg_match("~(?:^|/)rootless-cron\\.sh$~", $arg)); $isSnooze = isset($argv[0]) && basename($argv[0]) === "snooze"; if ($comm === "apache2" || $isCronScript || $isSnooze) { preg_match("/^Uid:\\s+\\d+\\s+(\\d+)/m", $s, $u); preg_match("/^Gid:\\s+\\d+\\s+(\\d+)/m", $s, $g); if (!isset($u[1], $g[1])) continue; $found[] = ["name" => $comm, "argv" => $argv, "uid" => (int)$u[1], "gid" => (int)$g[1]]; } } echo json_encode($found);`;
		const deadline = Date.now() + 10_000;
		let processes = [];
		while (Date.now() < deadline) {
			processes = JSON.parse(await docker(['exec', primary.name, 'php', '-r', script]));
			if (processes.some(entry => entry.argv.some(argument => /(?:^|\/)rootless-cron\.sh$/.test(argument)) || entry.argv[0]?.split('/').at(-1) === 'snooze')) break;
			await delay(250);
		}
		const apache = processes.filter(entry => entry.name === 'apache2');
		const scheduler = processes.filter(entry => entry.argv.some(argument => /(?:^|\/)rootless-cron\.sh$/.test(argument)) || entry.argv[0]?.split('/').at(-1) === 'snooze');
		assert.ok(apache.length > 0, 'No Apache process found');
		assert.ok(scheduler.length > 0, 'CRON_MIN did not start the rootless scheduler');
		assert.ok(processes.every(entry => entry.uid === 33 && entry.gid === 33), `Process identities: ${JSON.stringify(processes)}`);
		const noCronVolume = await freshVolume('no-cron');
		const withoutCron = await launch('without-cron', { volume: noCronVolume });
		await waitForHttp(withoutCron.url);
		const noCronProcesses = JSON.parse(await docker(['exec', withoutCron.name, 'php', '-r', script]));
		assert.equal(noCronProcesses.some(entry => entry.argv.some(argument => /(?:^|\/)rootless-cron\.sh$/.test(argument)) || entry.argv[0]?.split('/').at(-1) === 'snooze'), false,
			'Process probe reported a scheduler when CRON_MIN is disabled');
	}, [volumeCheck]);

	await check('scheduled tick refreshes a subscribed local RSS feed', async () => {
		const fixtureRequestTimes = [];
		const fixtureServer = createServer((_request, response) => {
			fixtureRequestTimes.push(Date.now());
			response.writeHead(200, { 'content-type': 'application/rss+xml; charset=utf-8' });
			response.end(`<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0"><channel><title>Rootless scheduler test</title><link>http://localhost/</link><description>Scheduler fixture</description>
<item><guid isPermaLink="false">${prefix}-scheduled-entry</guid><title>Scheduled refresh test</title><link>http://localhost/${prefix}</link><description>Fetched by the rootless scheduler</description><pubDate>${new Date().toUTCString()}</pubDate></item>
</channel></rss>`);
		});
		fixtureServers.push(fixtureServer);
		await new Promise((resolveListen, rejectListen) => {
			fixtureServer.once('error', rejectListen);
			fixtureServer.listen(0, '0.0.0.0', resolveListen);
		});
		const fixtureAddress = fixtureServer.address();
		assert.ok(fixtureAddress && typeof fixtureAddress === 'object', 'RSS fixture did not bind to a TCP port');

		const volume = await freshVolume('scheduled-refresh');
		const nextTick = new Date();
		nextTick.setUTCMinutes(nextTick.getUTCMinutes() + 2, 0, 0);
		const scheduledMinute = nextTick.getUTCMinutes();
		const scheduled = await launch('scheduled-refresh', {
			volume,
			cron: String(scheduledMinute),
			addHostGateway: true,
			env: {
				TZ: 'UTC',
				INTERNAL_HOST_ALLOWLIST: `host.docker.internal:${fixtureAddress.port}`,
				FRESHRSS_INSTALL: '--default-user scheduler-test --api-enabled',
				FRESHRSS_USER: '--user scheduler-test --password scheduler-test --no-default-feeds --feed-ttl-default 1',
			},
		});
		await waitForHttp(scheduled.url);
		const feedUrl = `http://host.docker.internal:${fixtureAddress.port}/feed.xml`;
		const opml = `<?xml version="1.0" encoding="UTF-8"?><opml version="2.0"><head><title>Scheduler test</title></head><body><outline text="Scheduler test" title="Scheduler test" type="rss" xmlUrl="${feedUrl}" /></body></opml>`;
		const opmlPath = '/run/freshrss/tmp/scheduled-feed.opml';
		await docker(['exec', '-i', scheduled.name, '/bin/sh', '-c', `cat > '${opmlPath}'`], { input: opml });
		await docker(['exec', scheduled.name, 'php', 'cli/import-for-user.php', '--user', 'scheduler-test', '--filename', opmlPath]);
		await delay(1_500);
		assert.ok(Date.now() < nextTick.getTime(), 'Scheduled tick arrived before the RSS fixture setup completed');

		const deadline = Date.now() + 240_000;
		let logs = '';
		while (!fixtureRequestTimes.some(requestTime => requestTime >= nextTick.getTime()) && Date.now() < deadline) {
			logs = await containerLogs(scheduled.name);
			if (/FreshRSS scheduler: refresh finished .*exit status [1-9]\d*\./.test(logs)) {
				assert.fail(`Scheduled refresh failed:\n${logs}`);
			}
			await delay(1_000);
		}
		assert.ok(fixtureRequestTimes.some(requestTime => requestTime >= nextTick.getTime()), `The scheduled tick did not fetch the subscribed local RSS fixture. Container logs:\n${logs}`);
		const refreshDeadline = Date.now() + 30_000;
		while (!/FreshRSS scheduler: refresh finished .*exit status 0\./.test(logs) && Date.now() < refreshDeadline) {
			logs = await containerLogs(scheduled.name);
			if (/FreshRSS scheduler: refresh finished .*exit status [1-9]\d*\./.test(logs)) {
				assert.fail(`Scheduled refresh failed:\n${logs}`);
			}
			await delay(250);
		}
		assert.match(logs, /FreshRSS scheduler: refresh started at /, 'No scheduled refresh tick was observed');
		assert.match(logs, /FreshRSS scheduler: refresh finished .*exit status 0\./, 'Scheduled refresh did not finish successfully');
	}, [imageCheck, engineCheck]);

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
