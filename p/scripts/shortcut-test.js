// @license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-3.0
'use strict';
/* globals context, shortcutKeyFromEvent */

(function () {
	// Keep the live dropdown in sync with context so recordings match the
	// current setting even before the form is saved.
	const select = document.getElementById('shortcut_matching');
	if (select) {
		select.addEventListener('change', function () {
			context.shortcut_matching = select.value;
		});
	}

	document.addEventListener('click', function (ev) {
		const btn = ev.target.closest('.shortcut-record');
		if (!btn) return;
		const input = btn.previousElementSibling;
		if (!input || input.tagName !== 'INPUT') return;
		if (select) {
			context.shortcut_matching = select.value;
		}
		btn.classList.add('recording');
		const onKey = function (keyEv) {
			keyEv.preventDefault();
			keyEv.stopPropagation();
			const matched = shortcutKeyFromEvent(keyEv);
			input.value = matched.toLowerCase();
			btn.classList.remove('recording');
			document.removeEventListener('keydown', onKey, true);
		};
		document.addEventListener('keydown', onKey, true);
	}, { once: false });
})();
// @license-end
