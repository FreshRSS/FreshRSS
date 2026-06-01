// @license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-3.0
'use strict';
/* globals context, openNotification */

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
let isSorting = false;

function init_draggable() {
	if (!window.context) {
		if (window.console) {
			console.log('FreshRSS category waiting for JS…');
		}
		setTimeout(init_draggable, 50);
		return;
	}
	category_sorting_btn_setup();

	const draggable = '[draggable="true"]';
	const dropzone = '[dropzone="move"]';
	const dropSection = document.querySelector('.drop-section');

	dropSection.ondragstart = function (ev) {
		const li_draggable = ev.target.closest ? ev.target.closest(draggable) : null;
		if (li_draggable && !isSorting) {
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
		if (li_draggable && !isSorting) {
			dragend_process(li_draggable);
			li_draggable.classList.remove('dragging');
			const disallowDragging = document.getElementsByClassName('drag-disallowed');
			for (let i = 0; i < disallowDragging.length; i++) {
				disallowDragging[i].setAttribute('dropzone', 'move');
				disallowDragging[i].classList.remove('drag-disallowed');
			}
			li_draggable.closest('.drag-active').classList.remove('drag-active');
		}
		dragFeedId = '';
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
		if (dragFeedId) {
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
						if (disabledElement.length > 0) {
							disabledElement[0].remove();
						}
						dnd_successful = true;
						ul_dropzone.closest('ul').classList.add('drag-drop');
					}
				};
				req.onloadend = function (e) {
					loading = false;
					dragFeedId = '';
					dragHtml = '';
				};
				req.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
				req.send(JSON.stringify({
					f_id: dragFeedId,
					c_id: ul_dropzone.getAttribute('data-cat-id'),
					_csrf: context.csrf,
				}));

				ul_dropzone.closest('ul').classList.remove('drag-hover');
				return false;
			}
		}
	};
}

function category_sorting_btn_setup() {
	const btnsStartSort = document.querySelectorAll('.btn-sort-cat');
	const btnsSaveSort = document.querySelectorAll('.btn-save-sort');
	const btnsDefaultSort = document.querySelectorAll('.btn-sort-a-z');

	for (const element of btnsStartSort) {
		element.addEventListener('click', start_category_sorting);
	}
	for (const element of btnsSaveSort) {
		element.addEventListener('click', end_category_sorting);
	}
	for (const element of btnsDefaultSort) {
		element.addEventListener('click', end_category_sorting);
	}
}

function start_category_sorting(event) {
	if (isSorting) return;
	isSorting = true;
	const catBox = event.target.closest('.box');
	const feedsElement = catBox.querySelector('ul');

	show_feed_sort_save_icon(catBox);

	setup_category_sorting(feedsElement);
}

async function end_category_sorting(event) {
	if (!isSorting) return;
	const catBox = event.target.closest('.box');
	const feedsElement = catBox.querySelector('ul');
	const catId = feedsElement.getAttribute('data-cat-id');
	const feedsArray = Array.from(feedsElement.children);
	const isRevert = event.target.closest('a').classList.contains('btn-sort-a-z');

	const feedsOrder = isRevert ? [] : feedsArray.filter((value) => value.hasAttribute('data-feed-id')).map((value) => value.getAttribute('data-feed-id'));

	try {
		const res = await fetch('./?c=category&a=updateSort', {
			method: 'POST',
			headers: {
				'Accept': 'application/json',
				'Content-Type': 'application/json; charset=UTF-8',
			},
			body: JSON.stringify({
				id: catId,
				feedsOrder,
				_csrf: context.csrf
			})
		});

		if (res.status == 200) {
			openNotification('Order saved', 'good');
		} else {
			openNotification('Order couldn\'t be saved');
		}
	} catch (error) {
		openNotification(error.message);
	}

	const clearDnD = (element) => {
		if (!element) return;
		element.ondragstart = undefined;
		element.ondragend = undefined;
		element.ondragover = undefined;
		element.ondrop = undefined;
		show_feed_manage_icon(element);
	};

	for (const element of feedsElement.children) {
		clearDnD(element);
		const topDiv = element.getElementsByClassName('drag-top')[0] ?? null;
		const botDiv = element.getElementsByClassName('drag-bot')[0] ?? null;
		clearDnD(topDiv);
		clearDnD(botDiv);
	}

	// Without this "start sorting" was being called again immediately
	setTimeout(() => {
		isSorting = false;
	}, 100);
	show_feed_sort_save_icon(catBox, false);
}

function setup_category_sorting(feedsElement) {
	let feedBeingSorted = null;
	const feedsList = feedsElement.children;
	for (let index = 0; index < feedsList.length; index++) {
		const feed = feedsList[index];
		if (!feed.hasAttribute('data-feed-id')) {
			continue;
		}
		show_feed_manage_icon(feed, false);
		feed.ondragstart = () => {
			feedBeingSorted = feed;
		};
		feed.ondragend = () => {
			feedBeingSorted = null;
		};

		const topDiv = feed.getElementsByClassName('drag-top')[0];
		const botDiv = feed.getElementsByClassName('drag-bot')[0];
		let currDiv = null;
		const ondragover = (event) => {
			if (currDiv === event.target || feedBeingSorted === null) {
				return;
			}

			const topElement = feedsList[index - 1] ?? null;
			const botElement = feedsList[index + 1] ?? null;
			clearHighlight(topElement);
			clearHighlight(botElement);
			currDiv = event.target;

			if (currDiv == topDiv) {
				feed.highlightTop();
				if (topElement && Object.prototype.hasOwnProperty.call(topElement, 'highlightBot')) {
					topElement.highlightBot();
				}
			} else {
				feed.highlightBot();
				if (botElement && Object.prototype.hasOwnProperty.call(botElement, 'highlightTop')) {
					botElement.highlightTop();
				}
			}
		};
		const ondrop = (event) => {
			const dropAfter = event.target === botDiv;
			clearHighlight();

			if (feedBeingSorted === feed) return;

			const feedsArray = Array.from(feedsList);
			const prevIdx = feedsArray.findIndex((value) => value === feedBeingSorted);
			feedsArray.splice(prevIdx, 1);
			let targetIdx = feedsArray.findIndex((value) => value === feed);
			if (dropAfter) targetIdx++;
			feedsArray.splice(targetIdx, 0, feedBeingSorted);
			feedBeingSorted = null;

			for (const element of feedsArray) {
				feedsElement.removeChild(element);
			}
			for (let index = feedsArray.length - 1; index >= 0; index--) {
				const element = feedsArray[index];
				feedsElement.prepend(element);
			}
			setup_category_sorting(feedsElement);
		};
		topDiv.ondragover = ondragover;
		topDiv.ondrop = ondrop;
		botDiv.ondragover = ondragover;
		botDiv.ondrop = ondrop;
		feed.getDragTop = () => topDiv;
		feed.getDragBot = () => botDiv;

		feed.highlightTop = () => {
			topDiv.classList.add('drag-highlight');
			botDiv.classList.remove('drag-highlight');
		};
		feed.highlightBot = () => {
			topDiv.classList.remove('drag-highlight');
			botDiv.classList.add('drag-highlight');
		};
	}
}

function show_feed_manage_icon(feed, show = true) {
	const gearIcon = feed.querySelector('a.configure');
	const slideIcon = feed.querySelector('a.drag-icon');
	if (!gearIcon || !slideIcon) return;

	if (show) {
		gearIcon.classList.remove('hidden');
		slideIcon.classList.add('hidden');
	} else {
		gearIcon.classList.add('hidden');
		slideIcon.classList.remove('hidden');
	}
}

function show_feed_sort_save_icon(catBox, show = true) {
	const sortIcon = catBox.getElementsByClassName('btn-sort-cat')[0];
	const sortAZIcon = catBox.getElementsByClassName('btn-sort-a-z')[0];
	const floppyIcon = catBox.getElementsByClassName('btn-save-sort')[0];

	if (show) {
		floppyIcon.classList.remove('hidden');
		floppyIcon.classList.add('btn');
		sortAZIcon.classList.remove('hidden');
		sortAZIcon.classList.add('btn');
		sortIcon.classList.add('hidden');
		sortIcon.classList.remove('btn');
	} else {
		floppyIcon.classList.add('hidden');
		floppyIcon.classList.remove('btn');
		sortAZIcon.classList.add('hidden');
		sortAZIcon.classList.remove('btn');
		sortIcon.classList.remove('hidden');
		sortIcon.classList.add('btn');
	}
}

function clearHighlight(element) {
	if (!element) element = document;
	for (const child of element.querySelectorAll('.drag-top, .drag-bot')) {
		child.classList.remove('drag-highlight');
	}
}

if (document.readyState && document.readyState !== 'loading') {
	init_draggable();
} else if (document.addEventListener) {
	document.addEventListener('DOMContentLoaded', function () {
		init_draggable();
	}, false);
}
// @license-end
