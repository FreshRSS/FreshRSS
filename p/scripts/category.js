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
				'<li class="item feed disabled emptyCategory"><div class="alert-warn">' + context.i18n.category_empty + '</div></li>');
		}
	}
}

let dragFeedId = '';
let dragHtml = '';
let dragCatBox = null;
let dragCatOver = null;

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
	const catBox = '.box[data-cat-id]';
	const catHandle = '.box-title[draggable="true"]';
	const dropSection = document.querySelector('.drop-section');

	const save_category_order = function () {
		const c_ids = [];
		dropSection.querySelectorAll(catBox).forEach(function (box) {
			c_ids.push(+box.getAttribute('data-cat-id'));
		});

		const req = new XMLHttpRequest();
		req.open('POST', './?c=category&a=move', true);
		req.responseType = 'json';
		req.onload = function () {
			if (this.status !== 200) {
				badAjax(this.status === 403);
			}
		};
		req.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
		req.send(JSON.stringify({
			c_ids: c_ids,
			_csrf: context.csrf,
		}));
	};

	dropSection.ondragstart = function (ev) {
		const cat_handle = ev.target.closest ? ev.target.closest(catHandle) : null;
		if (cat_handle) {
			dragCatBox = cat_handle.closest(catBox);
			if (dragCatBox) {
				ev.dataTransfer.effectAllowed = 'move';
				ev.dataTransfer.setData('text', dragCatBox.getAttribute('data-cat-id'));
				cat_handle.classList.add('dragging');
			}
			return;
		}

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
		if (dragCatBox !== null) {
			const cat_handle = dragCatBox.querySelector(catHandle);
			if (cat_handle) {
				cat_handle.classList.remove('dragging');
			}
			if (dragCatOver !== null) {
				dragCatOver.classList.remove('drag-hover');
				dragCatOver = null;
			}
			dragCatBox = null;
			return;
		}

		const li_draggable = ev.target.closest ? ev.target.closest(draggable) : null;
		if (li_draggable) {
			dragend_process(li_draggable);
			li_draggable.classList.remove('dragging');
			const disallowDragging = document.getElementsByClassName('drag-disallowed');
			for (let i = 0; i < disallowDragging.length; i++) {
				disallowDragging[i].setAttribute('dropzone', 'move');
				disallowDragging[i].classList.remove('drag-disallowed');
			}
			li_draggable.closest('.drag-active').classList.remove('drag-active');
		}
	};

	dropSection.ondragenter = function (ev) {
		if (dragCatBox !== null) {
			return;
		}

		const ul_dropzone = ev.target.closest ? ev.target.closest(dropzone) : null;
		if (ul_dropzone) {
			ul_dropzone.classList.add('drag-hover');
			return false;
		}
	};

	dropSection.ondragleave = function (ev) {
		if (dragCatBox !== null) {
			return;
		}

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
		if (dragCatBox !== null) {
			const box = ev.target.closest ? ev.target.closest(catBox) : null;
			const target = box === dragCatBox ? null : box;
			if (target !== dragCatOver) {
				if (dragCatOver !== null) {
					dragCatOver.classList.remove('drag-hover');
				}
				dragCatOver = target;
				if (dragCatOver !== null) {
					dragCatOver.classList.add('drag-hover');
				}
			}
			if (dragCatOver !== null) {
				ev.dataTransfer.dropEffect = 'move';
				return false;
			}
			return;
		}

		const li = ev.target.closest ? ev.target.closest(dropzone) : null;
		if (li) {
			li.closest('ul').classList.remove('drag-drop');
			ev.dataTransfer.dropEffect = 'move';
			return false;
		}
	};

	dropSection.ondrop = function (ev) {
		if (dragCatBox !== null) {
			if (dragCatOver !== null) {
				if (dragCatOver.compareDocumentPosition(dragCatBox) & Node.DOCUMENT_POSITION_FOLLOWING) {
					dragCatOver.insertAdjacentElement('beforebegin', dragCatBox);
				} else {
					dragCatOver.insertAdjacentElement('afterend', dragCatBox);
				}
				dragCatOver.classList.remove('drag-hover');
				dragCatOver = null;
				save_category_order();
			}
			return false;
		}

		if (dragFeedId) {
			const ul_dropzone = ev.target.closest ? ev.target.closest(dropzone) : null;

			if (ul_dropzone) {
				loading = true;

				const req = new XMLHttpRequest();
				req.open('POST', './?c=feed&a=move', true);
				req.responseType = 'json';
				req.onload = function (e) {
					if (this.status !== 200) {
						badAjax(this.status === 403);
						return;
					}

					ul_dropzone.insertAdjacentHTML('afterbegin', dragHtml);
					ul_dropzone.firstChild.classList.add('moved');
					ul_dropzone.scrollTop = 0;
					const disabledElement = ul_dropzone.getElementsByClassName('disabled');
					if (disabledElement.length > 0) {
						disabledElement[0].remove();
					}
					dnd_successful = true;

					ul_dropzone.classList.add('drag-drop');
					setTimeout(
						() => ul_dropzone.classList.remove('drag-drop'),
						parseFloat(getComputedStyle(ul_dropzone).animationDuration) * 1000
					);
				};
				req.onloadend = function (e) {
					loading = false;
					dragFeedId = '';
					dragHtml = '';
				};
				req.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
				req.send(JSON.stringify({
					f_id: +dragFeedId,
					c_id: +ul_dropzone.getAttribute('data-cat-id'),
					_csrf: context.csrf,
				}));

				ul_dropzone.closest('ul').classList.remove('drag-hover');
				return false;
			}
		}
	};
}

if (document.readyState && document.readyState !== 'loading') {
	init_draggable();
} else if (document.addEventListener) {
	document.addEventListener('DOMContentLoaded', function () {
		init_draggable();
	}, false);
}
// @license-end
