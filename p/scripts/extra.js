// @license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-3.0
"use strict";
/* globals context, openNotification, openPopupWithSource, xmlHttpRequestJson */
/* jshint esversion:6, strict:global */

function fix_popup_preview_selector() {
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

//<crypto form (Web login)>
function poormanSalt() {	//If crypto.getRandomValues is not available
	const base = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ.0123456789/abcdefghijklmnopqrstuvwxyz';
	let text = '$2a$04$';
	for (let i = 22; i > 0; i--) {
		text += base.charAt(Math.floor(Math.random() * 64));
	}
	return text;
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

	crypto_form.onsubmit = function (e) {
		const submit_button = this.querySelector('button[type="submit"]');
		submit_button.disabled = true;
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
					const strong = window.Uint32Array && window.crypto && (typeof window.crypto.getRandomValues === 'function'),
						s = dcodeIO.bcrypt.hashSync(document.getElementById('passwordPlain').value, json.salt1),
						c = dcodeIO.bcrypt.hashSync(json.nonce + s, strong ? dcodeIO.bcrypt.genSaltSync(4) : poormanSalt());
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

		submit_button.disabled = false;
		return success;
	};
}
//</crypto form (Web login)>

function init_share_observers() {
	let shares = document.querySelectorAll('.group-share').length;
	const shareAdd = document.querySelector('.share.add');
	if (shareAdd) {
		shareAdd.onclick = function (ev) {
				const s = this.parentElement.querySelector('select'),
					opt = s.options[s.selectedIndex];
				let row = this.closest('form').getAttribute('data-' + opt.getAttribute('data-form'));
				row = row.replace(/##label##/g, opt.text);
				row = row.replace(/##type##/g, opt.value);
				row = row.replace(/##help##/g, opt.getAttribute('data-help'));
				row = row.replace(/##key##/g, shares);
				row = row.replace(/##method##/g, opt.getAttribute('data-method'));
				row = row.replace(/##field##/g, opt.getAttribute('data-field'));
				this.closest('.form-group').insertAdjacentHTML('beforebegin', row);
				shares++;
				return false;
			};
	}
}


function init_remove_observers() {
	document.querySelectorAll('.post').forEach(function (div) {
			div.onclick = function (ev) {
					const a = ev.target.closest('a.remove');
					if (a) {
						const remove_what = a.getAttribute('data-remove');
						if (remove_what !== undefined) {
							const d = document.getElementById(remove_what);
							if (d) {
								d.remove();
							}
						}
						return false;
					}
				};
		});
}

function init_password_observers() {
	document.querySelectorAll('.toggle-password').forEach(function (a) {
			a.onmousedown = function (ev) {
					const passwordField = document.getElementById(this.getAttribute('data-toggle'));
					passwordField.setAttribute('type', 'text');
					this.classList.add('active');
					return false;
				};
			a.onmouseup = function (ev) {
					const passwordField = document.getElementById(this.getAttribute('data-toggle'));
					passwordField.setAttribute('type', 'password');
					this.classList.remove('active');
					return false;
				};
		});
}

function init_select_observers() {
	document.querySelectorAll('.select-change').forEach(function (s) {
			s.onchange = function (ev) {
					const opt = s.options[s.selectedIndex],
						url = opt.getAttribute('data-url');
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

function init_slider_observers() {
	const slider = document.getElementById('slider'),
		closer = document.getElementById('close-slider');
	if (!slider) {
		return;
	}

	document.querySelector('.post').onclick = function (ev) {
			const a = ev.target.closest('.open-slider');
			if (a) {
				if (!context.ajax_loading) {
					context.ajax_loading = true;

					const req = new XMLHttpRequest();
					req.open('GET', a.href + '&ajax=1', true);
					req.responseType = 'document';
					req.onload = function (e) {
							slider.innerHTML = this.response.body.innerHTML;
							slider.classList.add('active');
							closer.classList.add('active');
							context.ajax_loading = false;
							fix_popup_preview_selector();
						};
					req.send();
					return false;
				}
			}
		};

	closer.onclick = function (ev) {
			if (data_leave_validation() || confirm(context.i18n.confirmation_default)) {
				slider.querySelectorAll('form').forEach(function (f) { f.reset(); });
				closer.classList.remove('active');
				slider.classList.remove('active');
				return true;
			} else {
				return false;
			}
		};
}

function data_leave_validation() {
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

function init_configuration_alert() {
	window.onsubmit = function (e) {
			window.hasSubmit = true;
		};
	window.onbeforeunload = function (e) {
			if (window.hasSubmit) {
				return;
			}
			if (!data_leave_validation()) {
				return false;
			}
		};
}

function init_extra() {
	if (!window.context) {
		if (window.console) {
			console.log('FreshRSS extra waiting for JS…');
		}
		window.setTimeout(init_extra, 50);	//Wait for all js to be loaded
		return;
	}
	init_crypto_form();
	init_share_observers();
	init_remove_observers();
	init_password_observers();
	init_select_observers();
	init_slider_observers();
	init_configuration_alert();
	fix_popup_preview_selector();
}

if (document.readyState && document.readyState !== 'loading') {
	init_extra();
} else {
	document.addEventListener('DOMContentLoaded', function () {
			if (window.console) {
				console.log('FreshRSS extra waiting for DOMContentLoaded…');
			}
			init_extra();
		}, false);
}
// @license-end
