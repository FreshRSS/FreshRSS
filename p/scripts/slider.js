// @license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-3.0
'use strict';

function init_slider_observers() {
	const slider = document.getElementById('slider');
	const closer = document.getElementById('close-slider');
	if (!slider) {
		return;
	}

	document.querySelector('body').onclick = open_slider_listener;

	closer.addEventListener('click', function (ev) {
		if (slider_data_leave_validation() || confirm(context.i18n.confirmation_default)) {
			slider.querySelectorAll('form').forEach(function (f) { f.reset(); });
			closer.classList.remove('active');
			slider.classList.remove('active');
			return true;
		} else {
			return false;
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
			};
			req.send();
			return false;
		}
	}
};

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

function init_slider_afterDOM() {
	init_slider_observers();

	if (window.console) {
		console.log('FreshRSS slider init done.');
	}
}

if (document.readyState && document.readyState !== 'loading') {
	init_slider_afterDOM();
} else {
	if (window.console) {
		console.log('FreshRSS slider waiting for DOMContentLoaded…');
	}
	document.addEventListener('DOMContentLoaded', init_slider_afterDOM, false);
}
// @license-end