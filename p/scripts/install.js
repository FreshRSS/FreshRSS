"use strict";

function show_password() {
	var button = this;
	var passwordField = document.getElementById(button.getAttribute('data-toggle'));
	passwordField.setAttribute('type', 'text');
	button.className += ' active';
	return false;
}
function hide_password() {
	var button = this;
	var passwordField = document.getElementById(button.getAttribute('data-toggle'));
	passwordField.setAttribute('type', 'password');
	button.className = button.className.replace(/(?:^|\s)active(?!\S)/g , '');
	return false;
}
var toggles = document.getElementsByClassName('toggle-password');
for (var i = 0 ; i < toggles.length ; i++) {
	toggles[i].addEventListener('mousedown', show_password);
	toggles[i].addEventListener('mouseup', hide_password);
}

function auth_type_change() {
	var auth_type = document.getElementById('auth_type');
	if (auth_type) {
		var auth_value = auth_type.value,
			password_input = document.getElementById('passwordPlain'),
			mail_input = document.getElementById('mail_login');

		if (auth_value === 'form') {
			password_input.required = true;
			mail_input.required = false;
		} else if (auth_value === 'persona') {
			password_input.required = false;
			mail_input.required = true;
		} else {
			password_input.required = false;
			mail_input.required = false;
		}
	}
}
var auth_type = document.getElementById('auth_type');
if (auth_type) {
	auth_type_change();
	auth_type.addEventListener('change', auth_type_change);
}

function mySqlShowHide() {
	var mysql = document.getElementById('mysql');
	if (mysql) {
		mysql.style.display = document.getElementById('type').value === 'mysql' ? 'block' : 'none';
		if (document.getElementById('type').value !== 'mysql') {
			document.getElementById('host').value = '';
			document.getElementById('user').value = '';
			document.getElementById('pass').value = '';
			document.getElementById('base').value = '';
			document.getElementById('prefix').value = '';
		}
	}
}
var bd_type = document.getElementById('type');
if (bd_type) {
	mySqlShowHide();
	bd_type.addEventListener('change', mySqlShowHide);
}

function ask_confirmation(e) {
	var str_confirmation = this.getAttribute('data-str-confirm');
	if (!confirm(str_confirmation)) {
		e.preventDefault();
	}
}
var confirms = document.getElementsByClassName('confirm');
for (var i = 0 ; i < confirms.length ; i++) {
	confirms[i].addEventListener('click', ask_confirmation);
}
