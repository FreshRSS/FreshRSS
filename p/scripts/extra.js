// @license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-3.0
'use strict';
/* globals context, openNotification, xmlHttpRequestJson */

// <crypto form (Web login)>
function poormanSalt() {	// If crypto.getRandomValues is not available
	const base = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ.0123456789/abcdefghijklmnopqrstuvwxyz';
	let text = '$2a$04$';
	for (let i = 22; i > 0; i--) {
		text += base.charAt(Math.floor(Math.random() * 64));
	}
	return text;
}

function forgetOpenCategories() {
	localStorage.removeItem('FreshRSS_open_categories');
}

function init_crypto_form() {
	/* globals dcodeIO */
	const crypto_form = document.getElementById('crypto-form');
	if (!crypto_form) {
		return;
	}

	if (!(window.dcodeIO)) {
		if (window.console) {
			console.log('FreshRSS waiting for bcrypt.js…');
		}
		setTimeout(init_crypto_form, 100);
		return;
	}

	forgetOpenCategories();

	const submit_button = document.getElementById('loginButton');
	if (submit_button) {
		submit_button.disabled = false;
	}

	crypto_form.onsubmit = function (e) {
		if (submit_button) {
			submit_button.disabled = true;
		}
		let success = false;

		const req = new XMLHttpRequest();
		req.open('GET', './?c=javascript&a=nonce&user=' + document.getElementById('username').value, false);
		req.onerror = function () {
			openNotification('Communication error!', 'bad');
		};
		req.send();
		if (req.status == 200) {
			const json = xmlHttpRequestJson(req);
			if (!json.salt1 || !json.nonce) {
				openNotification('Invalid user!', 'bad');
			} else {
				try {
					const strong = window.Uint32Array && window.crypto && (typeof window.crypto.getRandomValues === 'function');
					const s = dcodeIO.bcrypt.hashSync(document.getElementById('passwordPlain').value, json.salt1);
					const c = dcodeIO.bcrypt.hashSync(json.nonce + s, strong ? dcodeIO.bcrypt.genSaltSync(4) : poormanSalt());
					document.getElementById('challenge').value = c;
					if (!s || !c) {
						openNotification('Crypto error!', 'bad');
					} else {
						success = true;
					}
				} catch (ex) {
					openNotification('Crypto exception! ' + ex, 'bad');
				}
			}
		} else {
			req.onerror();
		}

		if (submit_button) {
			submit_button.disabled = false;
		}
		return success;
	};
}
// </crypto form (Web login)>

// <show password>
let timeoutHide;

function showPW_this() {
	const id_passwordField = this.getAttribute('data-toggle');
	if (this.classList.contains('active')) {
		hidePW(id_passwordField);
	} else {
		showPW(id_passwordField);
	}
	return false;
}

function showPW(id_passwordField) {
	const passwordField = document.getElementById(id_passwordField);
	passwordField.setAttribute('type', 'text');
	passwordField.nextElementSibling.classList.add('active');
	clearTimeout(timeoutHide);
	timeoutHide = setTimeout(function () { hidePW(id_passwordField); }, 5000);
	return false;
}

function hidePW(id_passwordField) {
	clearTimeout(timeoutHide);
	const passwordField = document.getElementById(id_passwordField);
	passwordField.setAttribute('type', 'password');
	passwordField.nextElementSibling.classList.remove('active');
	return false;
}

function init_password_observers(parent) {
	parent.querySelectorAll('.toggle-password').forEach(function (btn) {
		btn.addEventListener('click', showPW_this);
	});
}
// </show password>

function init_archiving(parent) {
	parent.addEventListener('change', function (e) {
		if (e.target.id === 'use_default_purge_options') {
			parent.querySelectorAll('.archiving').forEach(function (element) {
				element.hidden = e.target.checked;
				if (!e.target.checked) element.style.visibility = 'visible'; 	// Help for Edge 44
			});
		}
	});
	parent.addEventListener('click', function (e) {
		if (e.target.closest('button[type=reset]')) {
			const archiving = document.getElementById('use_default_purge_options');
			if (archiving) {
				parent.querySelectorAll('.archiving').forEach(function (element) {
					element.hidden = archiving.getAttribute('data-leave-validation') == 1;
				});
			}
		}
	});
}

// <slider>
const freshrssSliderLoadEvent = new Event('freshrss:slider-load');

function open_slider_listener(ev) {
	if (ev.ctrlKey || ev.shiftKey) {
		return;
	}
	const a = ev.target.closest('.open-slider');
	if (a) {
		if (!context.ajax_loading) {
			context.ajax_loading = true;
			const slider = document.getElementById('slider');
			const slider_content = document.getElementById('slider-content');
			const req = new XMLHttpRequest();
			slider_content.innerHTML = '';
			slider.classList.add('sliding');
			const ahref = a.href + '&ajax=1#slider';
			req.open('GET', ahref, true);
			req.responseType = 'document';
			req.onload = function (e) {
				location.href = '#slider'; // close menu/dropdown
				document.documentElement.classList.add('slider-active');
				slider.classList.add('active');
				slider.scrollTop = 0;
				slider_content.innerHTML = this.response.body.innerHTML;
				slider_content.querySelectorAll('form').forEach(function (f) {
					f.insertAdjacentHTML('afterbegin', '<input type="hidden" name="slider" value="1" />');
				});
				context.ajax_loading = false;
				slider.dispatchEvent(freshrssSliderLoadEvent);
			};
			req.send();
			return false;
		}
	}
}

function init_slider(slider) {
	window.onclick = open_slider_listener;

	document.getElementById('close-slider').addEventListener('click', close_slider_listener);
	document.querySelector('#slider .toggle_aside').addEventListener('click', close_slider_listener);

	if (slider.children.length > 0) {
		slider.dispatchEvent(freshrssSliderLoadEvent);
	}
}

function close_slider_listener(ev) {
	const slider = document.getElementById('slider');
	if (data_leave_validation(slider) || confirm(context.i18n.confirmation_default)) {
		slider.querySelectorAll('form').forEach(function (f) { f.reset(); });
		document.documentElement.classList.remove('slider-active');
		return true;
	} else {
		return false;
	}
}
// </slider>

// overwrites the href attribute from the url input
function updateHref(ev) {
	const urlField = document.getElementById(this.getAttribute('data-input'));
	const url = urlField.value;
	if (url.length > 0) {
		this.href = url;
		return true;
	} else {
		urlField.focus();
		this.removeAttribute('href');
		ev.preventDefault();
		return false;
	}
}

// set event listener on "show url" buttons
function init_url_observers(parent) {
	parent.querySelectorAll('.open-url').forEach(function (btn) {
		btn.addEventListener('mouseover', updateHref);
		btn.addEventListener('click', updateHref);
	});
}

function init_select_observers() {
	document.querySelectorAll('.select-change').forEach(function (s) {
		s.onchange = function (ev) {
			const opt = s.options[s.selectedIndex];
			const url = opt.getAttribute('data-url');
			if (url) {
				s.disabled = true;
				s.value = '';
				if (s.form) {
					s.form.querySelectorAll('[type=submit]').forEach(function (b) {
						b.disabled = true;
					});
				}
				location.href = url;
			}
		};
	});
}

/**
 * Returns true when no input element is changed, false otherwise.
 * When excludeForm is defined, will only report changes outside the specified form.
 */
function data_leave_validation(parent, excludeForm = null) {
	const ds = parent.querySelectorAll('[data-leave-validation]');

	for (let i = ds.length - 1; i >= 0; i--) {
		const input = ds[i];
		if (excludeForm && excludeForm === input.form) {
			continue;
		}
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

function init_2stateButton() {
	const btns = document.getElementsByClassName('btn-state1');
	Array.prototype.forEach.call(btns, function (el) {
		el.addEventListener('click', function () {
			const btnState2 = document.getElementById(el.dataset.state2Id);
			btnState2.classList.add('show');
			this.classList.add('hide');
		});
	});
}

function init_configuration_alert() {
	window.onsubmit = function (e) {
		window.hasSubmit = data_leave_validation(document.body, e.submitter ? e.submitter.form : null);
	};
	window.onbeforeunload = function (e) {
		if (window.hasSubmit) {
			return;
		}
		if (!data_leave_validation(document.body)) {
			return false;
		}
	};
}

function init_extra_afterDOM() {
	if (!window.context) {
		if (window.console) {
			console.log('FreshRSS extra waiting for JS…');
		}
		setTimeout(init_extra_afterDOM, 50);
		return;
	}
	if (!['normal', 'global', 'reader'].includes(context.current_view)) {
		init_crypto_form();
		init_password_observers(document.body);
		init_select_observers();
		init_configuration_alert();
		init_2stateButton();

		const slider = document.getElementById('slider');
		if (slider) {
			slider.addEventListener('freshrss:slider-load', function (e) {
				init_password_observers(slider);
			});
			init_slider(slider);
			init_archiving(slider);
			init_url_observers(slider);
		} else {
			init_archiving(document.body);
			init_url_observers(document.body);
		}
	}

	if (window.console) {
		console.log('FreshRSS extra init done.');
	}
}

if (document.readyState && document.readyState !== 'loading') {
	init_extra_afterDOM();
} else {
	document.addEventListener('DOMContentLoaded', function () {
		if (window.console) {
			console.log('FreshRSS extra waiting for DOMContentLoaded…');
		}
		init_extra_afterDOM();
	}, false);
}
// @license-end
