"use strict";
/* globals $, context */
/* jshint globalstrict: true */

var loading = false,
	dnd_successful = false;

function dragend_process(t) {
	t.setAttribute('draggable', 'false');

	if (loading) {
		window.setTimeout(function() {
			dragend_process(t);
		}, 50);
		return;
	}

	if (!dnd_successful) {
		t.style.display = '';
		t.style.opacity = '';
		t.setAttribute('draggable', 'true');
	} else {
		var parent = $(t.parentNode);
		$(t).remove();

		if (parent.children().length <= 0) {
			parent.append('<li class="item disabled" dropzone="move">' + context.i18n.category_empty + '</li>');
		}
	}
}

var dragFeedId = '',
	dragHtml = '';

function init_draggable() {
	if (!(window.$ && window.context)) {
		if (window.console) {
			console.log('FreshRSS category waiting for JS…');
		}
		window.setTimeout(init_draggable, 50);
		return;
	}

	var draggable = '[draggable="true"]',
	    dropzone = '[dropzone="move"]';

	$('.drop-section').on('dragstart', draggable, function(e) {
		var drag = $(e.target).closest('[draggable]')[0];
		e.originalEvent.dataTransfer.effectAllowed = 'move';
		dragHtml = drag.outerHTML;
		dragFeedId = drag.getAttribute('data-feed-id');
		e.originalEvent.dataTransfer.setData('text', dragFeedId);
		drag.style.opacity = 0.3;

		dnd_successful = false;
	});
	$('.drop-section').on('dragend', draggable, function(e) {
		dragend_process(e.target);
	});

	$('.drop-section').on('dragenter', dropzone, function(e) {
		$(this).addClass('drag-hover');

		e.preventDefault();
	});
	$('.drop-section').on('dragleave', dropzone, function(e) {
		var pos_this = $(this).position(),
		    scroll_top = $(document).scrollTop(),
		    top = pos_this.top,
		    left = pos_this.left,
		    right = left + $(this).width(),
		    bottom = top + $(this).height(),
		    mouse_x = e.originalEvent.screenX,
		    mouse_y = e.originalEvent.clientY + scroll_top;

		if (left <= mouse_x && mouse_x <= right &&
			top <= mouse_y && mouse_y <= bottom) {
			// HACK because dragleave is triggered when hovering children!
			return;
		}
		$(this).removeClass('drag-hover');
	});
	$('.drop-section').on('dragover', dropzone, function(e) {
		e.originalEvent.dataTransfer.dropEffect = "move";

		e.preventDefault();
		return false;
	});
	$('.drop-section').on('drop', dropzone, function(e) {
		loading = true;

		$.ajax({
			type: 'POST',
			url: './?c=feed&a=move',
			data: {
				f_id: dragFeedId,
				c_id: e.target.parentNode.getAttribute('data-cat-id'),
				_csrf: context.csrf,
			}
		}).done(function() {
			$(e.target).after(dragHtml);
			if ($(e.target).hasClass('disabled')) {
				$(e.target).remove();
			}
			dnd_successful = true;
		}).always(function() {
			loading = false;
			dragFeedId = '';
			dragHtml = '';
		});

		$(this).removeClass('drag-hover');

		e.preventDefault();
	});
}


if (document.readyState && document.readyState !== 'loading') {
	init_draggable();
} else if (document.addEventListener) {
	document.addEventListener('DOMContentLoaded', function () {
		init_draggable();
	}, false);
}
