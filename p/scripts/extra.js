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

function init_crypto_forms() {
	if (!(window.bcrypt)) {
		if (window.console) {
			console.log('FreshRSS waiting for bcrypt.js…');
		}
		setTimeout(init_crypto_forms, 100);
		return;
	}

	/* globals bcrypt */
	const crypto_forms = document.querySelectorAll('.crypto-form');
	crypto_forms.forEach(crypto_form => {
		const submit_button = crypto_form.querySelector('[type="submit"]');
		if (submit_button) {
			submit_button.disabled = false;
		}

		crypto_form.onsubmit = function (e) {
			let challenge = crypto_form.querySelector('#challenge');
			if (!challenge) {
				crypto_form.querySelectorAll('[data-challenge-if-not-empty] input[type="password"]').forEach(el => {
					if (el.value !== '' && !challenge) {
						crypto_form.insertAdjacentHTML('beforeend', '<input type="hidden" id="challenge" name="challenge" />');
						challenge = crypto_form.querySelector('#challenge');
					}
				});
				if (!challenge) {
					return true;
				}
			}

			e.preventDefault();

			if (!submit_button) {
				return false;
			}
			submit_button.disabled = true;

			const req = new XMLHttpRequest();
			req.open('GET', './?c=javascript&a=nonce&user=' + crypto_form.querySelector('#username').value, true);

			req.onerror = function () {
				openNotification('Communication error!', 'bad');
				submit_button.disabled = false;
			};

			req.onload = function () {
				if (req.status == 200) {
					const json = xmlHttpRequestJson(req);
					if (!json.salt1 || !json.nonce) {
						openNotification('Invalid user!', 'bad');
					} else {
						try {
							const strong = window.Uint32Array && window.crypto && (typeof window.crypto.getRandomValues === 'function');
							const s = bcrypt.hashSync(crypto_form.querySelector('.passwordPlain').value, json.salt1);
							const c = bcrypt.hashSync(json.nonce + s, strong ? bcrypt.genSaltSync(4) : poormanSalt());
							challenge.value = c;
							if (!s || !c) {
								openNotification('Crypto error!', 'bad');
							} else {
								crypto_form.removeEventListener('submit', crypto_form.onsubmit);
								crypto_form.submit();
							}
						} catch (ex) {
							openNotification('Crypto exception! ' + ex, 'bad');
						}
					}
				} else {
					req.onerror();
				}
				submit_button.disabled = false;
			};

			req.send();
		};
	});
}
// </crypto form (Web login)>

// <show password>
function togglePW(btn) {
	if (btn.classList.contains('active')) {
		hidePW(btn);
	} else {
		showPW(btn);
	}
	return false;
}

function showPW(btn) {
	const passwordField = btn.previousElementSibling;
	passwordField.setAttribute('type', 'text');
	btn.classList.add('active');
	clearTimeout(btn.timeoutHide);
	btn.timeoutHide = setTimeout(function () { hidePW(btn); }, 5000);
	return false;
}

function hidePW(btn) {
	clearTimeout(btn.timeoutHide);
	const passwordField = btn.previousElementSibling;
	passwordField.setAttribute('type', 'password');
	passwordField.nextElementSibling.classList.remove('active');
	return false;
}

function init_password_observers(parent) {
	parent.querySelectorAll('.toggle-password').forEach(function (btn) {
		btn.onclick = () => togglePW(btn);
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

function init_update_feed() {
	const feed_update = document.querySelector('div.post#feed_update');
	if (!feed_update) {
		return;
	}

	const faviconUpload = feed_update.querySelector('#favicon-upload');
	const resetFavicon = feed_update.querySelector('#reset-favicon');
	const faviconError = feed_update.querySelector('#favicon-error');
	const faviconExt = feed_update.querySelector('#favicon-ext');
	const extension = faviconExt.querySelector('b');
	const faviconExtBtn = feed_update.querySelector('#favicon-ext-btn');
	const favicon = feed_update.querySelector('.favicon');

	function clearUploadedIcon() {
		faviconUpload.value = '';
	}
	function discardIconChange() {
		const resetField = feed_update.querySelector('input[name="resetFavicon"]');
		if (resetField) {
			resetField.remove();
		}
		const extBtn = feed_update.querySelector('input#extBtn');
		if (extBtn) {
			extBtn.remove();
		}
		if (faviconExtBtn) {
			faviconExtBtn.disabled = false;
			extension.innerText = extension.dataset.initialExt ?? extension.innerText;
		}
		if (extension.innerText == '') {
			faviconExt.classList.add('hidden');
		}
		clearUploadedIcon();
		favicon.src = favicon.dataset.initialSrc;

		const isCustomFavicon = favicon.getAttribute('src') !== favicon.dataset.originalIcon;
		resetFavicon.disabled = !isCustomFavicon;
	}

	faviconUpload.onchange = function () {
		if (faviconUpload.files.length === 0) {
			return;
		}

		faviconExt.classList.add('hidden');
		if (faviconUpload.files[0].size > context.max_favicon_upload_size) {
			faviconError.innerHTML = context.i18n.favicon_size_exceeded;
			discardIconChange();
			return;
		}
		if (faviconExtBtn) {
			faviconExtBtn.disabled = false;
			extension.innerText = extension.dataset.initialExt ?? extension.innerText;
		}
		faviconError.innerHTML = '';

		const resetField = feed_update.querySelector('input[name="resetFavicon"]');
		if (resetField) {
			resetField.remove();
		}
		const extBtn = feed_update.querySelector('input#extBtn');
		if (extBtn) {
			extBtn.remove();
		}
		resetFavicon.disabled = false;
		favicon.src = URL.createObjectURL(faviconUpload.files[0]);
	};

	resetFavicon.onclick = function (e) {
		e.preventDefault();
		if (resetFavicon.disabled) {
			return;
		}
		if (faviconExtBtn) {
			faviconExtBtn.disabled = false;
			extension.innerText = extension.dataset.initialExt ?? extension.innerText;
		}

		faviconExt.classList.add('hidden');
		faviconError.innerHTML = '';
		clearUploadedIcon();
		resetFavicon.insertAdjacentHTML('afterend', '<input type="hidden" name="resetFavicon" value="1" data-leave-validation="" />');
		resetFavicon.disabled = true;

		favicon.src = favicon.dataset.originalIcon;
	};

	feed_update.querySelector('form').addEventListener('reset', () => {
		faviconExt.classList.remove('hidden');
		faviconError.innerHTML = '';
		discardIconChange();
	});

	if (faviconExtBtn) {
		faviconExtBtn.onclick = function (e) {
			e.preventDefault();
			faviconExtBtn.disabled = true;
			fetch(faviconExtBtn.dataset.extensionUrl, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json; charset=utf-8'
				},
				body: JSON.stringify({
					'_csrf': context.csrf,
					'extAction': 'query_icon_info',
					'id': +feed_update.dataset.feedId
				}),
			}).then(resp => {
				if (!resp.ok) {
					faviconExtBtn.disabled = false;
					return Promise.reject(resp);
				}
				return resp.json();
			}).then(json => {
				clearUploadedIcon();
				const resetField = feed_update.querySelector('input[name="resetFavicon"]');
				if (resetField) {
					resetField.remove();
				}
				faviconExtBtn.insertAdjacentHTML('afterend', '<input type="hidden" id="extBtn" value="1" data-leave-validation="" />');
				resetFavicon.disabled = false;
				faviconError.innerHTML = '';
				faviconExt.classList.remove('hidden');
				extension.dataset.initialExt = extension.innerText;
				extension.innerText = json.extName;
				favicon.src = json.iconUrl;
			});
		};
		faviconExtBtn.form.onsubmit = async function (e) {
			const extChanged = faviconExtBtn.disabled;
			const isSubmit = !e.submitter.hasAttribute('formaction');

			if (extChanged && isSubmit) {
				e.preventDefault();
				faviconExtBtn.form.querySelectorAll('[type="submit"]').forEach(el => {
					el.disabled = true;
				});
				await fetch(faviconExtBtn.dataset.extensionUrl, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json; charset=utf-8'
					},
					body: JSON.stringify({
						'_csrf': context.csrf,
						'extAction': 'update_icon',
						'id': +feed_update.dataset.feedId
					}),
				});
				faviconExtBtn.form.onsubmit = null;
				faviconExtBtn.form.submit();
			}
		};
	}
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
				if (this.status === 403) {
					// Redirect to reauth page (or fail if session expired)
					location.href = a.href;
					return;
				}
				location.href = '#slider'; // close menu/dropdown
				document.documentElement.classList.add('slider-active');
				slider.classList.add('active');
				slider.scrollTop = 0;
				slider_content.innerHTML = this.response.body.innerHTML;
				data_auto_leave_validation(slider);
				init_update_feed();
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
	if (data_leave_validation(slider) || confirm(context.i18n.confirm_exit_slider)) {
		slider.querySelectorAll('form').forEach(function (f) { f.reset(); });
		document.documentElement.classList.remove('slider-active');
		return true;
	}
	if (ev) {
		ev.preventDefault();
	}
	return false;
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

/**
 * Automatically sets the `data-leave-validation` attribute for input, textarea, select elements for a given parent, if it's not set already.
 * Ignores elements with the `data-no-leave-validation` attribute set.
 */
function data_auto_leave_validation(parent) {
	parent.querySelectorAll(`[data-auto-leave-validation] input,
													[data-auto-leave-validation] textarea,
													[data-auto-leave-validation] select`).forEach(el => {
		if (el.dataset.leaveValidation || el.dataset.noLeaveValidation) {
			return;
		}

		if (el.type === 'checkbox' || el.type === 'radio') {
			el.dataset.leaveValidation = +el.checked;
		} else if (el.type !== 'hidden') {
			el.dataset.leaveValidation = el.value;
		}
	});
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
		window.hasSubmit = data_leave_validation(document.body, e.target);
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
	const loginButton = document.querySelector('#loginButton');
	if (loginButton) {
		loginButton.addEventListener('click', forgetOpenCategories);
	}
	if (!['normal', 'global', 'reader'].includes(context.current_view)) {
		init_crypto_forms();
		init_password_observers(document.body);
		init_select_observers();
		init_configuration_alert();
		init_2stateButton();
		init_update_feed();

		data_auto_leave_validation(document.body);

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
