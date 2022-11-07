// @license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-3.0
'use strict';

const init_integration = function () {
	if (!window.context) {
		if (window.console) {
			console.log('FreshRSS integration waiting for JS…');
		}
		setTimeout(init_integration, 50);
		return;
	}

	let shares = document.querySelectorAll('.group-share').length;
	document.querySelector('.share.add').addEventListener('click', event => {
		const shareTypes = event.target.closest('.group-controls').querySelector('select');
		const shareType = shareTypes.options[shareTypes.selectedIndex];
		const template = document.getElementById(shareType.getAttribute('data-form') + '-share');
		let newShare = template.content.cloneNode(true).querySelector('formgroup').outerHTML;

		newShare = newShare.replace(/##label##/g, shareType.text);
		newShare = newShare.replace(/##type##/g, shareType.value);
		newShare = newShare.replace(/##help##/g, shareType.getAttribute('data-help'));
		newShare = newShare.replace(/##key##/g, shares);
		newShare = newShare.replace(/##method##/g, shareType.getAttribute('data-method'));
		newShare = newShare.replace(/##field##/g, shareType.getAttribute('data-field'));
		event.target.closest('formgroup').insertAdjacentHTML('beforebegin', newShare);
		shares++;
	});

	document.querySelector('.post').addEventListener('click', event => {
		if (!event.target || !event.target.closest) {
			return;
		}

		const deleteButton = event.target.closest('.remove');
		if (null === deleteButton || !deleteButton.closest) {
			return;
		}

		const share = deleteButton.closest('.group-share');
		const form = deleteButton.closest('form');
		if (!share.remove || !form.submit) {
			return;
		}
		share.remove();
		form.submit();
	});
};

if (document.readyState && document.readyState !== 'loading') {
	init_integration();
} else if (document.addEventListener) {
	document.addEventListener('DOMContentLoaded', event => init_integration(), false);
}
// @license-end
