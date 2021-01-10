// @license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-3.0
"use strict";
/* jshint esversion:6, strict:global */

const init_draggable = function() {
	if (!window.context) {
		if (window.console) {
			console.log('FreshRSS user query waiting for JS…');
		}
		setTimeout(init_draggable, 50);
		return;
	}
	
	let source;
	const configureQueries = document.querySelector('#configureQueries');
	const addMarker = (position, element) => {
		const hr = configureQueries.querySelector('hr.drag-drop-marker');
		if (null === hr) {
			element.insertAdjacentHTML(position, '<hr class="drag-drop-marker" />');
		}
	};
	const removeMarker = () => {
		const hr = configureQueries.querySelector('hr.drag-drop-marker');
		if (null !== hr) {
			hr.remove();
		}
	};

	configureQueries.addEventListener('dragstart', event => {
		source = event.target.closest('[draggable="true"]');
		event.dataTransfer.setData('text/html', source.outerHTML);
		event.dataTransfer.effectAllowed = 'move';
	});
	configureQueries.addEventListener('dragover', event => {
		event.preventDefault();
		if (!event.target || !event.target.closest) {
			return;
		}

		const dropQuery = event.target.closest('[draggable="true"]');
		if (null === dropQuery || source === dropQuery) {
			return;
		}

		const rect = dropQuery.getBoundingClientRect();
		if (event.clientY < (rect.top + rect.height / 2)) {
			addMarker('beforebegin', dropQuery);
		} else {
			addMarker('afterend', dropQuery);
		}
	});
	configureQueries.addEventListener('dragleave', event => {
		event.preventDefault();
		removeMarker();
	});
	configureQueries.addEventListener('drop', event => {
		event.preventDefault();
		event.stopPropagation();
		if (!event.target || !event.target.closest) {
			return;
		}

		const dropQuery = event.target.closest('[draggable="true"]');
		if (null === dropQuery || source === dropQuery) {
			return;
		}

		const rect = dropQuery.getBoundingClientRect();
		if (event.clientY < (rect.top + rect.height / 2)) {
			dropQuery.insertAdjacentHTML('beforebegin', event.dataTransfer.getData('text/html'));
		} else {
			dropQuery.insertAdjacentHTML('afterend', event.dataTransfer.getData('text/html'));
		}
		source.remove();
		removeMarker();
	});

	// This is needed to work around a Firefox bug → https://bugzilla.mozilla.org/show_bug.cgi?id=800050
	configureQueries.addEventListener('focusin', event => {
		if (!event.target || !event.target.closest) {
			return;
		}

		const queryName = event.target.closest('input[id^="queries_"][id$="_name"]');
		if (null !== queryName) {
			queryName.select();
		}
	});
};

if (document.readyState && document.readyState !== 'loading') {
	init_draggable();
} else if (document.addEventListener) {
	document.addEventListener('DOMContentLoaded', event => init_draggable(), false);
}
// @license-end
