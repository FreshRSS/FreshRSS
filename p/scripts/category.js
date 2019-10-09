"use strict";
/* globals context */
/* jshint esversion:6, strict:global */

var loading = false,
	dnd_successful = false;

function dragend_process(t) {
	t.setAttribute('draggable', 'false');

	if (loading) {
		setTimeout(function() {
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

		if (p.childElementCount <= 0) {
			p.insertAdjacentHTML('beforeend', '<li class="item disabled" dropzone="move">' + context.i18n.category_empty + '</li>');
		}
	}
}

var dragFeedId = '',
	dragHtml = '';

function init_draggable() {
	if (!window.context) {
		if (window.console) {
			console.log('FreshRSS category waiting for JS…');
		}
		setTimeout(init_draggable, 50);
		return;
	}

	const draggable = '[draggable="true"]',
		dropzone = '[dropzone="move"]',
		dropSection = document.querySelector('.drop-section');

	dropSection.ondragstart = function(ev) {
			const li = ev.target.closest ? ev.target.closest(draggable) : null;
			if (li) {
				const drag = ev.target.closest('[draggable]');
				ev.dataTransfer.effectAllowed = 'move';
				dragHtml = drag.outerHTML;
				dragFeedId = drag.getAttribute('data-feed-id');
				ev.dataTransfer.setData('text', dragFeedId);
				drag.style.opacity = 0.3;
				dnd_successful = false;
			}
		};

	dropSection.ondragend = function(ev) {
			const li = ev.target.closest ? ev.target.closest(draggable) : null;
			if (li) {
				dragend_process(li);
			}
		};

	dropSection.ondragenter = function(ev) {
			const li = ev.target.closest ? ev.target.closest(dropzone) : null;
			if (li) {
				li.classList.add('drag-hover');
				return false;
			}
		};

	dropSection.onddragleave = function(ev) {
			const li = ev.target.closest ? ev.target.closest(dropzone) : null;
			if (li) {
				const scroll_top = document.documentElement.scrollTop,
					top = li.offsetTop,
					left = li.offsetLeft,
					right = left + li.clientWidth,
					bottom = top + li.clientHeight,
					mouse_x = ev.screenX,
					mouse_y = ev.clientY + scroll_top;

				if (left <= mouse_x && mouse_x <= right &&
					top <= mouse_y && mouse_y <= bottom) {
					// HACK because dragleave is triggered when hovering children!
					return;
				}
				li.classList.remove('drag-hover');
			}
		};

	dropSection.ondragover = function(ev) {
			const li = ev.target.closest ? ev.target.closest(dropzone) : null;
			if (li) {
				ev.dataTransfer.dropEffect = "move";
				return false;
			}
		};

	dropSection.ondrop = function(ev) {
			const li = ev.target.closest ? ev.target.closest(dropzone) : null;
			if (li) {
				loading = true;

				const req = new XMLHttpRequest();
				req.open('POST', './?c=feed&a=move', true);
				req.responseType = 'json';
				req.onload = function (e) {
						if (this.status == 200) {
							li.insertAdjacentHTML('afterend', dragHtml);
							if (li.classList.contains('disabled')) {
								li.remove();
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
						c_id: li.parentElement.getAttribute('data-cat-id'),
						_csrf: context.csrf,
					}));

				li.classList.remove('drag-hover');
				return false;
			}
		};
}

function archiving() {
	document.querySelector('body').addEventListener('change', function (event) {
		if (event.target.id === 'use_default_purge_options') {
			document.querySelectorAll('.archiving').forEach(function (element) {
				element.hidden = event.target.checked;
			});
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
