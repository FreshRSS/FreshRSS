// @license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-3.0
'use strict';
/* globals openNotification, openPopupWithSource, xmlHttpRequestJson */

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

let timeoutHide;

function showPW_this(ev) {
	const id_passwordField = this.getAttribute('data-toggle');
	if (this.classList.contains('active')) {
		hidePW(id_passwordField);
	} else {
		if (ev.type == 'touchstart' || ev.type == 'click' || ev.buttons || ev.key == ' ' || ev.key.toUpperCase() == 'ENTER' ) {
			showPW(id_passwordField)
		}
	}
	return false;
}

function showPW(id_passwordField) {
	const passwordField = document.getElementById(id_passwordField);
	passwordField.setAttribute('type', 'text');
	passwordField.nextElementSibling.classList.add('active');
	clearTimeout(timeoutHide)
	timeoutHide = setTimeout(function () {hidePW(id_passwordField)}, 5000);
	return false;
}

function hidePW(id_passwordField) {
	clearTimeout(timeoutHide)
	const passwordField = document.getElementById(id_passwordField);
	passwordField.setAttribute('type', 'password');
	passwordField.nextElementSibling.classList.remove('active');
	return false;
}

function init_password_observers() {
	document.querySelectorAll('.toggle-password').forEach(function (btn) {
		btn.addEventListener('click', showPW_this);
	});
}

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
function init_url_observers() {
	document.querySelectorAll('.open-url').forEach(function (btn) {
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

/**
 * Allow a <select class="select-show"> to hide/show elements defined by <option data-show="elem-id"></option>
 */
function init_select_show() {
	const listener = (select) => {
		const options = select.querySelectorAll('option[data-show]');
		for (const option of options) {
			const elem = document.getElementById(option.dataset.show);
			if (elem) {
				elem.style.display = option.selected ? 'block' : 'none';
			}
		}
	};

	const selects = document.querySelectorAll('select.select-show');
	for (const select of selects) {
		select.addEventListener('change', (e) => listener(e.target));
		listener(select);
	}
}

/**
 * Automatically validate XPath textarea fields
 */
function init_valid_xpath() {
	const listener = (textarea) => {
		const evaluator = new XPathEvaluator();
		try {
			if (textarea.value === '' || evaluator.createExpression(textarea.value) != null) {
				textarea.setCustomValidity('');
			}
		} catch (ex) {
			textarea.setCustomValidity(ex);
		}
	};

	const textareas = document.querySelectorAll('textarea.valid-xpath');
	for (const textarea of textareas) {
		textarea.addEventListener('change', (e) => listener(e.target));
		listener(textarea);
	}
}

function init_extra() {
	if (!window.context) {
		if (window.console) {
			console.log('FreshRSS extra waiting for JS…');
		}
		window.setTimeout(init_extra, 50);	// Wait for all js to be loaded
		return;
	}
	init_crypto_form();
	init_password_observers();
	init_url_observers();
	init_select_observers();
	init_configuration_alert();
	fix_popup_preview_selector();
	init_select_show();
	init_valid_xpath();

	if (window.console) {
		console.log('FreshRSS extra init done.');
	}
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
