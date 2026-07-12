import { test } from 'node:test';
import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import { fileURLToPath } from 'node:url';
import { dirname, join } from 'node:path';
import vm from 'node:vm';

// Load the classic browser script into an isolated context and grab the global it defines.
const here = dirname(fileURLToPath(import.meta.url));
const source = readFileSync(join(here, '../../p/scripts/shortcut.js'), 'utf8');
const sandbox = {};
vm.runInNewContext(source + '\nglobalThis.__fn = shortcutKeyFromEvent;', sandbox);
const shortcutKeyFromEvent = sandbox.__fn;

const cases = [
	// event.code path (layout-independent)
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
	// fallback path (no ev.code, e.g. IE11)
	['fallback letter j', { key: 'j' }, 'J'],
	['fallback Spacebar', { key: 'Spacebar' }, 'SPACE'],
	['fallback Del', { key: 'Del' }, 'DELETE'],
	['fallback Esc', { key: 'Esc' }, 'ESCAPE'],
	['fallback empty event', {}, 'SPACE'],
];

for (const [name, ev, expected] of cases) {
	test(name, () => {
		assert.equal(shortcutKeyFromEvent(ev), expected);
	});
}
