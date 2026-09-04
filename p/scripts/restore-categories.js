// @license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-3.0
'use strict';

// Restores remembered open categories as soon as this loads, before the rest of the page
// (and main.js's own, later restoration) runs — avoiding a visible collapse-then-expand jump.
// Kept as its own external file rather than inline in aside_feed.phtml: an inline <script>
// is blocked by the default `Content-Security-Policy: default-src 'self'`.
try {
	const openCategories = JSON.parse(localStorage.getItem('FreshRSS_open_categories') || '{}');
	Object.keys(openCategories).forEach(function (categoryId) {
		const category = document.getElementById(categoryId);
		const items = category?.querySelector('.tree-folder-items');
		if (!items) {
			return;
		}
		items.classList.add('active');
		const icon = category.querySelector('button.dropdown-toggle .icon');
		if (icon?.src) {
			icon.src = icon.src.replace('/icons/down.', '/icons/up.');
			icon.alt = '🔼';
		} else if (icon) {
			icon.innerHTML = '🔼';
		}
	});
} catch (e) {
	// Ignore unavailable or malformed local storage.
}
// @license-end
