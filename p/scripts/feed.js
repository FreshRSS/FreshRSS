// @license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-3.0
'use strict';
/* globals context, openPopupWithSource */

function init_popup_preview_selector() {
	const link = document.getElementById('popup-preview-selector');

	if (!link) {
		return;
	}

	link.addEventListener('click', function (ev) {
		const selector_entries = document.getElementById('path_entries').value;
		const href = link.href.replace('selector-token', encodeURIComponent(selector_entries));

		openPopupWithSource(href);

		ev.preventDefault();
	});
}

function init_archiving() {
	const feed_update = document.getElementById('feed_update');
	if (!feed_update) {
		return;
	}
	feed_update.addEventListener('change', function (e) {
		if (e.target.id === 'use_default_purge_options') {
			feed_update.querySelectorAll('.archiving').forEach(function (element) {
				element.hidden = e.target.checked;
				if (!e.target.checked) element.style.visibility = 'visible'; 	// Help for Edge 44
			});
		}
	});
	feed_update.addEventListener('click', function (e) {
		if (e.target.closest('button[type=reset]')) {
			const archiving = document.getElementById('use_default_purge_options');
			if (archiving) {
				feed_update.querySelectorAll('.archiving').forEach(function (element) {
					element.hidden = archiving.getAttribute('data-leave-validation') == 1;
				});
			}
		}
	});
}

function open_slider_listener(ev) {
	const a = ev.target.closest('.open-slider');
	if (a) {
		if (!context.ajax_loading) {
			location.href = '#'; // close menu/dropdown
			context.ajax_loading = true;

			const req = new XMLHttpRequest();
			req.open('GET', a.href + '&ajax=1', true);
			req.responseType = 'document';
			req.onload = function (e) {
				const slider = document.getElementById('slider');
				const closer = document.getElementById('close-slider');
				slider.innerHTML = this.response.body.innerHTML;
				slider.classList.add('active');
				closer.classList.add('active');
				context.ajax_loading = false;
				init_archiving();
				init_popup_preview_selector();
				init_select_show(slider);
			};
			req.send();
			return false;
		}
	}
}

function slider_data_leave_validation() {
	const ds = document.querySelectorAll('[data-leave-validation]');

	for (let i = ds.length - 1; i >= 0; i--) {
		const input = ds[i];
		if (input.type === 'checkbox' || input.type === 'radio') {
			if (input.checked != input.getAttribute('data-leave-validation')) {
				return false;
			}
		} else if (input.value != input.getAttribute('data-leave-validation')) {
			return false;
		}
	}
	return true;
}

/**
 * Allow a <select class="select-show"> to hide/show elements defined by <option data-show="elem-id"></option>
 */
function init_select_show(parent) {
	// TODO: Fix for slider
	const listener = (select) => {
		const options = select.querySelectorAll('option[data-show]');
		for (const option of options) {
			const elem = document.getElementById(option.dataset.show);
			if (elem) {
				elem.style.display = option.selected ? 'block' : 'none';
			}
		}
	};

	const selects = parent.querySelectorAll('select.select-show');
	for (const select of selects) {
		select.addEventListener('change', (e) => listener(e.target));
		listener(select);
	}
}

function init_feed_afterDOM() {
	init_archiving();

	const slider = document.getElementById('slider');

	if (slider) {
		init_select_show(slider);

		window.onclick = open_slider_listener;

		const closer = document.getElementById('close-slider');
		closer.addEventListener('click', function (ev) {
			if (slider_data_leave_validation() || confirm(context.i18n.confirmation_default)) {
				slider.querySelectorAll('form').forEach(function (f) { f.reset(); });
				closer.classList.remove('active');
				slider.classList.remove('active');
				init_popup_preview_selector();
				return true;
			} else {
				return false;
			}
		});
	} else {
		init_select_show(document.body);
	}
}

if (document.readyState && document.readyState !== 'loading') {
	init_feed_afterDOM();
} else {
	document.addEventListener('DOMContentLoaded', function () {
		if (window.console) {
			console.log('FreshRSS feed waiting for DOMContentLoaded…');
		}
		init_feed_afterDOM();
	}, false);
}

// @license-end
