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

	for (const el of document.querySelectorAll('div.highlight')) {
		/* eslint-disable @stylistic/max-len */
		el.insertAdjacentHTML('afterbegin', `
		<button class="copy" title="${i18n.copy_to_clipboard}">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
				<path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/>
				<path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/>
			</svg>
		</button>
		`);
		/* eslint-enable @stylistic/max-len */
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
