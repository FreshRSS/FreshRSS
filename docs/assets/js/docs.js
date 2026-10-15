/* globals i18n */

if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
	document.head.insertAdjacentHTML('beforeend', `
	<meta name="darkreader-lock">
	`);
}

let asideNav;

window.addEventListener('beforeunload', () => {
	sessionStorage.setItem('sidebar_scrollTop', asideNav.scrollTop);
});

window.addEventListener('keydown', (e) => {
	if (e.key === 'Escape') {
		location.hash = 'close';
	}
});

document.addEventListener('DOMContentLoaded', () => {
	asideNav = document.querySelector('aside > nav.docs');

	const sidebar_scrollTop = sessionStorage.getItem('sidebar_scrollTop');
	if (sidebar_scrollTop) {
		asideNav.scrollTo(0, sidebar_scrollTop);
		sessionStorage.removeItem('sidebar_scrollTop');
	}

	const copyIconSvg = document.querySelector('template#copy-svg-icon').innerHTML;
	for (const el of document.querySelectorAll('div.highlight')) {
		el.insertAdjacentHTML('afterbegin', `
		<button class="copy" title="${i18n.copy_to_clipboard}">
			${copyIconSvg}
		</button>
		`);
		const copyBtn = el.querySelector('button.copy');
		copyBtn.addEventListener('click', () => {
			const snippet = el.querySelector('code').innerText;
			if (navigator.clipboard) {
				navigator.clipboard.writeText(snippet);
			} else {
				// Fallback if no HTTPS
				const input = document.createElement('textarea');
				input.innerHTML = snippet;
				document.body.append(input);
				input.select();
				document.execCommand('copy');
				input.remove();
			}
		});
	}

	for (const el of document.querySelectorAll('img')) {
		if (el.parentNode.tagName !== 'A') {
			el.outerHTML = `<a href="${el.getAttribute('src')}">${el.outerHTML}</a>`;
		}
	}
});
