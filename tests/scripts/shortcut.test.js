import { test } from 'node:test';
import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import { fileURLToPath } from 'node:url';
import { dirname, join } from 'node:path';
import vm from 'node:vm';

const here = dirname(fileURLToPath(import.meta.url));
const source = readFileSync(join(here, '../../p/scripts/shortcut.js'), 'utf8');

function makeFn(matching) {
	const sandbox = { context: { shortcut_matching: matching || 'physical' } };
	vm.runInNewContext(source + '\nglobalThis.__fn = shortcutKeyFromEvent;', sandbox);
	return sandbox.__fn;
}

const physicalCases = [
	['KeyJ with Cyrillic key', { code: 'KeyJ', key: 'о' }, 'J'],
	['KeyJ', { code: 'KeyJ' }, 'J'],
	['Digit3', { code: 'Digit3', key: '3' }, '3'],
	['Shift+Digit3 (# character)', { code: 'Digit3', key: '#', shiftKey: true }, '3'],
	['Numpad3', { code: 'Numpad3' }, '3'],
	['NumpadEnter', { code: 'NumpadEnter' }, 'ENTER'],
	['ArrowDown', { code: 'ArrowDown' }, 'ARROWDOWN'],
	['Space', { code: 'Space', key: ' ' }, 'SPACE'],
	['Enter', { code: 'Enter' }, 'ENTER'],
	['Escape', { code: 'Escape' }, 'ESCAPE'],
	['F1', { code: 'F1' }, 'F1'],
	['Home', { code: 'Home' }, 'HOME'],
];

const characterCases = [
	['Cyrillic key uses key', { code: 'KeyJ', key: 'о' }, 'О'],
	['Latin key', { code: 'KeyJ', key: 'j' }, 'J'],
	['Digit3', { code: 'Digit3', key: '3' }, '3'],
	['Shift+Digit3 (# character)', { code: 'Digit3', key: '#', shiftKey: true }, '#'],
	['Space', { code: 'Space', key: ' ' }, 'SPACE'],
	['Enter', { code: 'Enter', key: 'Enter' }, 'ENTER'],
	['Escape', { code: 'Escape', key: 'Escape' }, 'ESCAPE'],
];

const fallbackCases = [
	['letter j', { key: 'j' }, 'J'],
	['Cyrillic о', { key: 'о' }, 'О'],
	['Spacebar', { key: 'Spacebar' }, 'SPACE'],
	['Del', { key: 'Del' }, 'DELETE'],
	['Esc', { key: 'Esc' }, 'ESCAPE'],
	['empty event', {}, 'SPACE'],
];

for (const [name, ev, expected] of physicalCases) {
	test('physical: ' + name, () => {
		assert.equal(makeFn('physical')(ev), expected);
	});
}

for (const [name, ev, expected] of characterCases) {
	test('character: ' + name, () => {
		assert.equal(makeFn('character')(ev), expected);
	});
}

for (const [name, ev, expected] of fallbackCases) {
	test('fallback: ' + name, () => {
		const sandbox = { context: {} };
		vm.runInNewContext(source + '\nglobalThis.__fn = shortcutKeyFromEvent;', sandbox);
		assert.equal(sandbox.__fn(ev), expected);
	});
}
