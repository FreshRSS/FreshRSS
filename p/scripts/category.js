"use strict";

var loading = false,
	dnd_successful = false;

function dragend_process(t) {
	if (loading) {
		window.setTimeout(function() {
			dragend_process(t);
		}, 50);
	}

	if (!dnd_successful) {
		t.style.opacity = 1.0;
	} else {
		t.parentNode.removeChild(t);
	}
}


function init_draggable() {
	if (!(window.$ && window.url_freshrss)) {
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
		$(e.target).addClass('drag-hover');
	});
	$('.drop-section').on('dragleave', dropzone, function(e) {
		$(e.target).removeClass('drag-hover');
	});
	$('.drop-section').on('dragover', dropzone, function(e) {
		e.dataTransfer.dropEffect = "move";

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
			loading = false;
		}).complete(function() {
			dnd_successful = true;
		});

		$(e.target).removeClass('drag-hover');

		return false;
	});
}


if (document.readyState && document.readyState !== 'loading') {
	init_draggable();
} else if (document.addEventListener) {
	document.addEventListener('DOMContentLoaded', function () {
		init_draggable();
	}, false);
}
