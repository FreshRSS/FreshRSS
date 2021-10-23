// @license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-3.0
'use strict';

function init_selectInputChanger() {
	const select = document.getElementsByClassName("select-input-changer");
	
	for (var i = 0; i<select.length; i++){
		select[i].addEventListener("click", function(){onchange_selectInputChanger(this)});
		onchange_selectInputChanger(select[i]);
	}
}

function onchange_selectInputChanger(elem){
	const formGroup = document.getElementById(elem.dataset.name+"-block");
	const input = document.getElementById(elem.dataset.name+"-input");
	if (elem.selectedOptions[0].dataset.inputVisible == "false") {
		formGroup.style.display = 'none';
		input.name = "";
        elem.name = elem.dataset.name;
	} else {
		formGroup.style.display = '';
		input.name = elem.dataset.name;
        elem.name = "";
	}
}

function init_maxNumbersOfAccountsStatus() {
    const input = document.getElementById("max-registrations-input");
    if (input) {
        input.addEventListener("click", function(){onchange_maxNumbersOfAccounts(this)});
        onchange_maxNumbersOfAccounts(input);
    }
}

function onchange_maxNumbersOfAccounts(elem) {
    if (elem.value > elem.dataset.number) {
        document.getElementById("max-registrations-status-disabled").style.display = "none";
        document.getElementById("max-registrations-status-enabled").style.display = "";
    } else {
        document.getElementById("max-registrations-status-disabled").style.display = "";
        document.getElementById("max-registrations-status-enabled").style.display = "none";
    }
}

init_selectInputChanger();
init_maxNumbersOfAccountsStatus()

// @license-end
