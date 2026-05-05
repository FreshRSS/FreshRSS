// @license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-3.0
'use strict';
/* globals context */

/**
 * Client-side date/time calendar conversion using the Intl API.
 * Reformats all <time datetime="..."> elements into the user's chosen
 * calendar system (e.g. Persian/Jalali, Chinese, Islamic, etc.).
 * A MutationObserver handles dates injected after page load (infinite scroll).
 */
(function () {
	const jsonVars = document.getElementById('jsonVars');
	if (!jsonVars) return;

	let vars;
	try {
		vars = JSON.parse(jsonVars.textContent);
	} catch (e) {
		return;
	}

	const calendar = vars?.context?.intl_calendar;
	if (!calendar) return;

	const timezone = vars?.context?.timezone || undefined;
	const language = (vars?.i18n?.language || 'en').replace('_', '-');

	// Build a BCP 47 locale tag with the calendar extension, e.g. 'fa-u-ca-persian'.
	const locale = calendar === 'gregory'
		? language
		: language + '-u-ca-' + calendar;

	let formatter;
	try {
		formatter = new Intl.DateTimeFormat(locale, {
			year: 'numeric',
			month: 'short',
			day: 'numeric',
			hour: '2-digit',
			minute: '2-digit',
			timeZone: timezone,
		});
	} catch (e) {
		// Unsupported locale/calendar combination — bail gracefully.
		return;
	}

	/** Convert a single <time> element in-place. */
	function convertElement(el) {
		if (el.dataset.intlDone) return;
		const dt = el.getAttribute('datetime');
		if (!dt) return;
		const date = new Date(dt);
		if (isNaN(date.getTime())) return;
		el.dataset.intlDone = '1';
		// Preserve original text as a tooltip for accessibility.
		if (!el.hasAttribute('title')) {
			el.setAttribute('title', el.textContent.trim());
		}
		el.textContent = formatter.format(date);
	}

	/** Convert all <time datetime> elements inside a root node. */
	function convertAll(root) {
		root.querySelectorAll('time[datetime]').forEach(convertElement);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', () => convertAll(document.body));
	} else {
		convertAll(document.body);
	}

	// Watch for <time> elements added dynamically (e.g. infinite scroll).
	const observer = new MutationObserver((mutations) => {
		for (const mutation of mutations) {
			for (const node of mutation.addedNodes) {
				if (node.nodeType !== 1) continue; // element nodes only
				if (node.matches('time[datetime]')) {
					convertElement(node);
				}
				// Descendants of the added node.
				const times = node.querySelectorAll('time[datetime]');
				if (times.length > 0) {
					times.forEach(convertElement);
				}
			}
		}
	});

	observer.observe(document.body || document.documentElement, {
		childList: true,
		subtree: true,
	});
})();
