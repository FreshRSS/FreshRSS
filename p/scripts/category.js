"use strict";


function init_draggable() {
	$.event.props.push('dataTransfer');

	var feeds_draggable = '.box-content > .feed',
	    box_dropzone = '.box-content';

	$('.box').on('dragstart', feeds_draggable, function(e) {
		e.dataTransfer.effectAllowed = 'move';
		e.dataTransfer.setData('html', e.target.outerHTML);
		e.dataTransfer.setData('feed-id', e.target.getAttribute('data-feed-id'));
	});
	$('.box').on('dragend', feeds_draggable, function(e) {
		var parent = e.target.parentNode;
		parent.removeChild(e.target);
		
	});

	$('.box').on('dragenter', box_dropzone, function(e) {
		$(e.target).addClass('drag-hover');
	});
	$('.box').on('dragleave', box_dropzone, function(e) {
		$(e.target).removeClass('drag-hover');
	});
	$('.box').on('dragover', box_dropzone, function(e) {
		e.dataTransfer.dropEffect = "move";

		return false;
	});
	$('.box').on('drop', box_dropzone, function(e) {
		var feed_id = e.dataTransfer.getData('feed-id'),
		    cat_id = e.target.parentNode.getAttribute('data-cat-id');

		$.ajax({
			type: 'POST',
			url: './?c=feed&a=move',
			data : {
				f_id: feed_id,
				c_id: cat_id
			}
		});

		$(e.target).after(e.dataTransfer.getData('html'));
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
