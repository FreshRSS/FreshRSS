// @license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-3.0
'use strict';

const init_draggable_list = function () {
	if (!window.context) {
		if (window.console) {
			console.log('FreshRSS draggable list waiting for JS…');
		}
		setTimeout(init_draggable_list, 50);
		return;
	}

	let source;
	const draggableList = document.querySelector('.draggableList');
	const addMarker = (position, element) => {
		const hr = draggableList.querySelector('hr.drag-drop-marker');
		if (null === hr) {
			element.insertAdjacentHTML(position, '<hr class="drag-drop-marker" />');
		}
	};
	const removeMarker = () => {
		const hr = draggableList.querySelector('hr.drag-drop-marker');
		if (null !== hr) {
			hr.remove();
		}
	};

	draggableList.addEventListener('dragstart', event => {
		source = event.target.closest('[draggable="true"]');
		const dragbox = source.closest('.dragbox');
		if (dragbox) {
			source = dragbox;
		}
		event.dataTransfer.setData('text/html', source.outerHTML);
		event.dataTransfer.effectAllowed = 'move';
	});
	draggableList.addEventListener('dragover', event => {
		event.preventDefault();
		if (!event.target || !event.target.closest) {
			return;
		}

		let draggableItem = event.target.closest('[draggable="true"]');
		const dragbox = event.target.closest('.dragbox');
		if (dragbox) {
			draggableItem = dragbox;
		}
		if (null === draggableItem || source === draggableItem) {
			return;
		}

		const rect = draggableItem.getBoundingClientRect();
		if (event.clientY < (rect.top + rect.height / 2)) {
			addMarker('beforebegin', draggableItem);
		} else {
			addMarker('afterend', draggableItem);
		}
	});
	draggableList.addEventListener('dragleave', event => {
		event.preventDefault();
		removeMarker();
	});
	draggableList.addEventListener('drop', event => {
		event.preventDefault();
		event.stopPropagation();
		if (!event.target || !event.target.closest) {
			return;
		}

		var draggableItem = event.target.closest('[draggable="true"]');
		const dragbox = event.target.closest('.dragbox');
		if (dragbox) {
			draggableItem = dragbox;
		}
		if (null === draggableItem || source === draggableItem) {
			return;
		}

		const rect = draggableItem.getBoundingClientRect();
		if (event.clientY < (rect.top + rect.height / 2)) {
			draggableItem.insertAdjacentHTML('beforebegin', event.dataTransfer.getData('text/html'));
		} else {
			draggableItem.insertAdjacentHTML('afterend', event.dataTransfer.getData('text/html'));
		}
		source.remove();
		removeMarker();
		draggableList.submit();
	});

	// This is needed to work around a Firefox bug → https://bugzilla.mozilla.org/show_bug.cgi?id=800050
	draggableList.addEventListener('focusin', event => {
		if (!event.target || !event.target.closest) {
			return;
		}

		const itemName = event.target.closest('input[type="text"]');
		if (null !== itemName) {
			itemName.select();
		}
	});
};

if (document.readyState && document.readyState !== 'loading') {
	init_draggable_list();
} else if (document.addEventListener) {
	document.addEventListener('DOMContentLoaded', event => init_draggable_list(), false);
}
// @license-end
