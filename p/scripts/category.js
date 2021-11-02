// @license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-3.0
'use strict';
/* globals context */

let loading = false;
let dnd_successful = false;

function dragend_process(t) {
	t.setAttribute('draggable', 'false');

	if (loading) {
		setTimeout(function () {
			dragend_process(t);
		}, 50);
		return;
	}

	if (!dnd_successful) {
		t.style.display = '';
		t.style.opacity = '';
		t.setAttribute('draggable', 'true');
	} else {
		const p = t.parentElement;
		t.remove();

		if (p.childElementCount <= 1) {
			p.insertAdjacentHTML('afterbegin',
				'<li class="item feed disabled"><div class="alert-warn">' + context.i18n.category_empty + '</div></li>');
		}
	}
}

let dragFeedId = '';
let dragHtml = '';

function init_draggable() {
	if (!window.context) {
		if (window.console) {
			console.log('FreshRSS category waiting for JS…');
		}
		setTimeout(init_draggable, 50);
		return;
	}

	const draggable = '[draggable="true"]';
	const dropzone = '[dropzone="move"]';
	const dropSection = document.querySelector('.drop-section');

	dropSection.ondragstart = function (ev) {
		const li_draggable = ev.target.closest ? ev.target.closest(draggable) : null;
		if (li_draggable) {
			const ulClosest = li_draggable.closest('ul');
			ulClosest.classList.add('drag-disallowed');
			ulClosest.removeAttribute('dropzone', '');
			const drag = ev.target.closest('[draggable]');
			ev.dataTransfer.effectAllowed = 'move';
			dragHtml = drag.outerHTML;
			dragFeedId = drag.getAttribute('data-feed-id');
			ev.dataTransfer.setData('text', dragFeedId);
			drag.style.opacity = 0.5;
			drag.classList.add('dragging');
			li_draggable.closest('.drop-section').classList.add('drag-active');
			dnd_successful = false;
		}
	};

	dropSection.ondragend = function (ev) {
		const li_draggable = ev.target.closest ? ev.target.closest(draggable) : null;
		if (li_draggable) {
			dragend_process(li_draggable);
		}
		li_draggable.classList.remove('dragging');
		const disallowDragging = document.getElementsByClassName('drag-disallowed');
		for (let i = 0; i < disallowDragging.length; i++) {
			disallowDragging[i].setAttribute('dropzone', 'move');
			disallowDragging[i].classList.remove('drag-disallowed');
		}
		li_draggable.closest('.drag-active').classList.remove('drag-active');
	};

	dropSection.ondragenter = function (ev) {
		const ul_dropzone = ev.target.closest ? ev.target.closest(dropzone) : null;
		if (ul_dropzone) {
			ul_dropzone.classList.add('drag-hover');
			return false;
		}
	};

	dropSection.ondragleave = function (ev) {
		const ul_dropzone = ev.target.closest ? ev.target.closest(dropzone) : null;
		if (ul_dropzone) {
			const scroll_top = document.documentElement.scrollTop;
			const top = ul_dropzone.offsetTop;
			const left = ul_dropzone.offsetLeft;
			const right = left + ul_dropzone.clientWidth;
			const bottom = top + ul_dropzone.clientHeight;
			const mouse_x = ev.screenX;
			const mouse_y = ev.clientY + scroll_top;

			if (left <= mouse_x && mouse_x <= right &&
					top <= mouse_y && mouse_y <= bottom) {
				// HACK because dragleave is triggered when hovering children!
				return;
			}
			ul_dropzone.classList.remove('drag-hover');
		}
	};

	dropSection.ondragover = function (ev) {
		const li = ev.target.closest ? ev.target.closest(dropzone) : null;
		if (li) {
			li.closest('ul').classList.remove('drag-drop');
			ev.dataTransfer.dropEffect = 'move';
			return false;
		}
	};

	dropSection.ondrop = function (ev) {
		const ul_dropzone = ev.target.closest ? ev.target.closest(dropzone) : null;
		if (ul_dropzone) {
			loading = true;

			const req = new XMLHttpRequest();
			req.open('POST', './?c=feed&a=move', true);
			req.responseType = 'json';
			req.onload = function (e) {
				if (this.status == 200) {
					ul_dropzone.insertAdjacentHTML('afterbegin', dragHtml);
					ul_dropzone.firstChild.classList.add('moved');
					ul_dropzone.scrollTop = 0;
					const disabledElement = ul_dropzone.getElementsByClassName('disabled');
					if (ul_dropzone.childElementCount <= 3 && disabledElement.length > 0) {
						disabledElement[0].remove();
					}
					dnd_successful = true;
				}
			};
			req.onloadend = function (e) {
				loading = false;
				dragFeedId = '';
				dragHtml = '';
			};
			req.setRequestHeader('Content-Type', 'application/json');
			req.send(JSON.stringify({
				f_id: dragFeedId,
				c_id: ul_dropzone.getAttribute('data-cat-id'),
				_csrf: context.csrf,
			}));

			ul_dropzone.closest('ul').classList.add('drag-drop');
			ul_dropzone.closest('ul').classList.remove('drag-hover');
			return false;
		}
	};
}

function archiving() {
	const slider = document.getElementById('slider');
	slider.addEventListener('change', function (e) {
		if (e.target.id === 'use_default_purge_options') {
			slider.querySelectorAll('.archiving').forEach(function (element) {
				element.hidden = e.target.checked;
				if (!e.target.checked) element.style.visibility = 'visible'; 	// Help for Edge 44
			});
		}
	});
	slider.addEventListener('click', function (e) {
		if (e.target.closest('button[type=reset]')) {
			const archiving = document.getElementById('use_default_purge_options');
			if (archiving) {
				slider.querySelectorAll('.archiving').forEach(function (element) {
					element.hidden = archiving.getAttribute('data-leave-validation') == 1;
				});
			}
		}
	});
}

if (document.readyState && document.readyState !== 'loading') {
	init_draggable();
	archiving();
} else if (document.addEventListener) {
	document.addEventListener('DOMContentLoaded', function () {
		init_draggable();
		archiving();
	}, false);
}
// @license-end
