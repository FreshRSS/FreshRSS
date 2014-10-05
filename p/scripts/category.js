"use strict";

var loading = false,
	dnd_successful = false;

function dragend_process(t) {
	t.style.display = 'none';

	if (loading) {
		window.setTimeout(function() {
			dragend_process(t);
		}, 50);
	}

	if (!dnd_successful) {
		t.style.display = 'block';
		t.style.opacity = 1.0;
	} else {
		var parent = $(t.parentNode);
		$(t).remove();

		if (parent.children().length <= 0) {
			parent.append('<li class="item disabled" dropzone="move">' + i18n['category_empty'] + '</li>');
		}
	}
}

function init_draggable() {
	if (!(window.$ && window.i18n)) {
		if (window.console) {
			console.log('FreshRSS waiting for JS…');
		}
		window.setTimeout(init_draggable, 50);
		return;
	}

	$.event.props.push('dataTransfer');

	var draggable = '[draggable="true"]',
	    dropzone = '[dropzone="move"]';

	$('.drop-section').on('dragstart', draggable, function(e) {
		e.dataTransfer.effectAllowed = 'move';
		e.dataTransfer.setData('text/html', e.target.outerHTML);
		e.dataTransfer.setData('text', e.target.getAttribute('data-feed-id'));
		e.target.style.opacity = 0.3;

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
		e.dataTransfer.dropEffect = "move";

		e.preventDefault();
		return false;
	});
	$('.drop-section').on('drop', dropzone, function(e) {
		var feed_id = e.dataTransfer.getData('text'),
		    cat_id = e.target.parentNode.getAttribute('data-cat-id');

		loading = true;

		$.ajax({
			type: 'POST',
			url: './?c=feed&a=move',
			data : {
				f_id: feed_id,
				c_id: cat_id
			}
		}).success(function() {
			$(e.target).after(e.dataTransfer.getData('text/html'));
			if ($(e.target).hasClass('disabled')) {
				$(e.target).remove();
			}
			dnd_successful = true;
		}).complete(function() {
			loading = false;
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
