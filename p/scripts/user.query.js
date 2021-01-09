// @license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-3.0
"use strict";
/* jshint esversion:6, strict:global */

function init_draggable() {
	if (!window.context) {
		if (window.console) {
			console.log('FreshRSS user query waiting for JS…');
		}
		setTimeout(init_draggable, 50);
		return;
	}
	
	let source;
	const configureQueries = document.querySelector('#configureQueries');

	configureQueries.addEventListener('dragstart', event => {
		source = event.target.closest('[draggable="true"]');
		event.dataTransfer.setData('text/html', source.outerHTML);
		event.dataTransfer.effectAllowed = 'move';
	});
	configureQueries.addEventListener('dragover', event => event.preventDefault());
	configureQueries.addEventListener('dragleave', event => event.preventDefault());
	configureQueries.addEventListener('drop', event => {
		event.preventDefault();
		event.stopPropagation();
		const dropQuery = event.target.closest('[draggable="true"]');
		if (null === dropQuery) {
			source.remove();
			configureQueries.querySelector('legend').insertAdjacentHTML('afterend', event.dataTransfer.getData('text/html'));
		} else if (source !== dropQuery) {
			source.remove();
			dropQuery.insertAdjacentHTML('afterend', event.dataTransfer.getData('text/html'));
		}
	});

	// This is needed to work around a Firefox bug → https://bugzilla.mozilla.org/show_bug.cgi?id=800050
	configureQueries.addEventListener('focusin', event => {
		event.target.closest('input[id^="queries_"][id$="_name"]').select();
	});
}

if (document.readyState && document.readyState !== 'loading') {
	init_draggable();
} else if (document.addEventListener) {
	document.addEventListener('DOMContentLoaded', event => init_draggable(), false);
}
// @license-end
