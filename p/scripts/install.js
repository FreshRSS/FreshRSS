// @license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-3.0
"use strict";
/* jshint esversion:6, strict:global */

function show_password(ev) {
	const button = ev.currentTarget;
	const passwordField = document.getElementById(button.getAttribute('data-toggle'));
	passwordField.setAttribute('type', 'text');
	button.className += ' active';
	return false;
}
function hide_password(ev) {
	const button = ev.currentTarget;
	const passwordField = document.getElementById(button.getAttribute('data-toggle'));
	passwordField.setAttribute('type', 'password');
	button.className = button.className.replace(/(?:^|\s)active(?!\S)/g , '');
	return false;
}
const toggles = document.getElementsByClassName('toggle-password');
for (let i = 0 ; i < toggles.length ; i++) {
	toggles[i].addEventListener('mousedown', show_password);
	toggles[i].addEventListener('mouseup', hide_password);
}

const auth_type = document.getElementById('auth_type');
function auth_type_change() {
	if (auth_type) {
		const auth_value = auth_type.value,
			password_input = document.getElementById('passwordPlain');

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
for (let i = 0 ; i < confirms.length ; i++) {
	confirms[i].addEventListener('click', ask_confirmation);
}
// @license-end
