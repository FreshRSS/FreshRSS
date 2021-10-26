// @license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-3.0
'use strict';

function init_selectInputChanger() {
	const select = document.getElementsByClassName('select-input-changer');

	for (let i = 0; i < select.length; i++) {
		select[i].addEventListener('change', updateSelectInput);
        select[i].dispatchEvent(new Event('change', {
            bubbles: true,
            cancelable: true,
        }));
	}
}

function updateSelectInput(ev) {
    const elem = ev.target;
	const formGroup = document.getElementById(elem.dataset.name + '-block');
	const input = document.getElementById(elem.dataset.name + '-input');
	if (elem.selectedOptions[0].dataset.inputVisible == 'false') {
		formGroup.style.display = 'none';
		input.name = '';
		elem.name = elem.dataset.name;
	} else {
		formGroup.style.display = '';
		input.name = elem.dataset.name;
		elem.name = '';
	}
}

function init_maxNumbersOfAccountsStatus() {
	const input = document.getElementById('max-registrations-input');
	if (input) {
		input.addEventListener('change', onchange_maxNumbersOfAccounts);
        input.dispatchEvent(new Event('change', {
            bubbles: true,
            cancelable: true,
        }));
	}
}

function onchange_maxNumbersOfAccounts(ev) {
    const elem = ev.target;
	if (elem.value > elem.dataset.number) {
		document.getElementById('max-registrations-status-disabled').style.display = 'none';
		document.getElementById('max-registrations-status-enabled').style.display = '';
	} else {
		document.getElementById('max-registrations-status-disabled').style.display = '';
		document.getElementById('max-registrations-status-enabled').style.display = 'none';
	}
}

init_selectInputChanger();
init_maxNumbersOfAccountsStatus();

// @license-end
