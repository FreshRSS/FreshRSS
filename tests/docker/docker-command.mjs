import { Buffer } from 'node:buffer';
import { spawn } from 'node:child_process';
import { clearTimeout, setTimeout } from 'node:timers';

export async function command(args, { input, timeout = 120_000 } = {}) {
	return await new Promise((resolve, reject) => {
		const child = spawn('docker', args, { windowsHide: true, stdio: ['pipe', 'pipe', 'pipe'] });
		const stdout = [];
		const stderr = [];
		const timer = setTimeout(() => child.kill(), timeout);
		child.stdout.on('data', chunk => stdout.push(chunk));
		child.stderr.on('data', chunk => stderr.push(chunk));
		child.stdin.on('error', () => {});
		child.on('error', error => { clearTimeout(timer); reject(error); });
		child.on('close', code => {
			clearTimeout(timer);
			resolve({ code, stdout: Buffer.concat(stdout), stderr: Buffer.concat(stderr) });
		});
		child.stdin.end(input);
	});
}
