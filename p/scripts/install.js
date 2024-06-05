// @license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-3.0
'use strict';

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

init_password_observers(document.body);

const auth_type = document.getElementById('auth_type');
function auth_type_change() {
	if (auth_type) {
		const auth_value = auth_type.value;
		const password_input = document.getElementById('passwordPlain');

		if (auth_value === 'form') {
			password_input.required = true;
		} else {
			password_input.required = false;
		}
	}
}
if (auth_type) {
	auth_type_change();
	auth_type.addEventListener('change', auth_type_change);
}

function mySqlShowHide() {
	const mysql = document.getElementById('mysql');
	if (mysql) {
		if (document.getElementById('type').value === 'sqlite') {
			document.getElementById('host').value = '';
			document.getElementById('user').value = '';
			document.getElementById('pass').value = '';
			document.getElementById('base').value = '';
			document.getElementById('prefix').value = '';
			mysql.style.display = 'none';
		} else {
			mysql.style.display = 'block';
		}
	}
}
const bd_type = document.getElementById('type');
if (bd_type) {
	mySqlShowHide();
	bd_type.addEventListener('change', mySqlShowHide);
}

function ask_confirmation(ev) {
	const str_confirmation = ev.target.getAttribute('data-str-confirm');
	if (!confirm(str_confirmation)) {
		ev.preventDefault();
	}
}
const confirms = document.getElementsByClassName('confirm');
for (let i = 0; i < confirms.length; i++) {
	confirms[i].addEventListener('click', ask_confirmation);
}
// @license-end
