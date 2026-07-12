// @license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-3.0
'use strict';

// Normalize a keydown event to an uppercase shortcut token based on the physical
// key position (event.code), so shortcuts are independent of the keyboard layout.
// Falls back to event.key for browsers that do not populate event.code (e.g. IE11).
// eslint-disable-next-line no-unused-vars -- global consumed by main.js and global_view.js
function shortcutKeyFromEvent(ev) {
	const code = ev.code || '';
	if (code) {
		if (code.startsWith('Key') && code.length === 4) return code.charAt(3);		// KeyJ   -> 'J'
		if (code.startsWith('Digit') && code.length === 6) return code.charAt(5);	// Digit3 -> '3'
		if (code.startsWith('Numpad')) {
			const rest = code.slice(6);
			if (rest >= '0' && rest <= '9') return rest;	// Numpad3     -> '3'
			if (rest === 'Enter') return 'ENTER';			// NumpadEnter -> 'ENTER'
		}
		return code.toUpperCase();	// ArrowDown -> 'ARROWDOWN', Space -> 'SPACE', Enter -> 'ENTER', F1 -> 'F1', Escape -> 'ESCAPE'
	}
	let k = ((ev.key || '').trim() || 'Space').toUpperCase();
	if (k === 'SPACEBAR') k = 'SPACE';
	else if (k === 'DEL') k = 'DELETE';
	else if (k === 'ESC') k = 'ESCAPE';
	return k;
}
// @license-end
