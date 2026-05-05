'use strict';

// Resolve sidebar visibility before <body> paints so the drawer doesn't flash open/closed.
// Source of truth is `:root.aside_hidden`; main.js keeps it in sync at runtime.
(function () {
	const jsonEl = document.getElementById('jsonVars');
	if (!jsonEl) return;
	const ctx = JSON.parse(jsonEl.textContent).context;
	const view = ctx.current_view;
	const isToggleable = view === 'normal' || view === 'reader';
	const stored = isToggleable
		? sessionStorage.getItem('FreshRSS_aside-toggled_' + view)
		: null;
	// Narrow and reader force-hide regardless of stored choice: at narrow widths
	// the sidebar is an overlay that blocks content, so a wide-view "open" must
	// not leak into narrow.
	let hidden;
	if (view === 'reader') hidden = true;
	else if (window.matchMedia('(max-width: 840px)').matches) hidden = true;
	else if (stored === '1') hidden = false;
	else if (stored === '0') hidden = true;
	else if (isToggleable) hidden = !!ctx.sidebar_hidden_by_default;
	else hidden = false;
	if (hidden) document.documentElement.classList.add('aside_hidden');
})();
