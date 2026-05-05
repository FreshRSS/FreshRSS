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
	// For Gregorian, keep the language as-is (it's the default calendar).
	const localeWithCalendar = calendar === 'gregory'
		? language
		: language + '-u-ca-' + calendar;

	const formatterOptions = {
		year: 'numeric',
		month: 'short',
		day: 'numeric',
		hour: '2-digit',
		minute: '2-digit',
		timeZone: timezone,
	};

	// Try the user's language + calendar first; if the browser rejects that
	// locale/calendar combination, fall back to a language-neutral locale so
	// at least the calendar system is applied.
	let formatter;
	for (const loc of [localeWithCalendar, 'und-u-ca-' + calendar, 'en-u-ca-' + calendar]) {
		try {
			formatter = new Intl.DateTimeFormat(loc, formatterOptions);
			break;
		} catch (e) {
			// Try next locale candidate.
		}
	}
	if (!formatter) return;

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

	// Use IntersectionObserver to defer conversion until elements are near the
	// viewport — avoids doing work for off-screen articles in long lists.
	const intersectionObserver = new IntersectionObserver((entries) => {
		for (const entry of entries) {
			if (entry.isIntersecting) {
				convertElement(entry.target);
				intersectionObserver.unobserve(entry.target);
			}
		}
	}, { rootMargin: '100px' });

	function scheduleElement(el) {
		if (!el.dataset.intlDone) {
			intersectionObserver.observe(el);
		}
	}

	function scheduleAll(root) {
		root.querySelectorAll('time[datetime]').forEach(scheduleElement);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', () => scheduleAll(document.body));
	} else {
		scheduleAll(document.body);
	}

	// Watch for <time> elements added dynamically (e.g. infinite scroll).
	const mutationObserver = new MutationObserver((mutations) => {
		for (const mutation of mutations) {
			for (const node of mutation.addedNodes) {
				if (node.nodeType !== 1) continue; // element nodes only
				if (node.matches('time[datetime]')) {
					scheduleElement(node);
				}
				node.querySelectorAll('time[datetime]').forEach(scheduleElement);
			}
		}
	});

	function connectMutationObserver() {
		mutationObserver.observe(document.body || document.documentElement, {
			childList: true,
			subtree: true,
		});
	}

	connectMutationObserver();

	// Pause observation while the tab is hidden; resume on return.
	document.addEventListener('visibilitychange', () => {
		if (document.hidden) {
			mutationObserver.disconnect();
		} else {
			connectMutationObserver();
		}
	});
})();
