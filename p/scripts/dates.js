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
	const SETTINGS_CACHE_KEY = 'freshrss:intl-date-settings';

	function readCachedSettings() {
		try {
			const value = localStorage.getItem(SETTINGS_CACHE_KEY);
			return value ? JSON.parse(value) : null;
		} catch (e) {
			return null;
		}
	}

	function normaliseSettings(settings, fallbackLanguage) {
		const language = (settings?.language || fallbackLanguage || 'en').replace('_', '-');
		return {
			intl_calendar: settings?.intl_calendar || '',
			timezone: settings?.timezone || undefined,
			language,
		};
	}

	function settingsSignature(settings) {
		return settings.intl_calendar + '|' + (settings.timezone || '') + '|' + settings.language;
	}

	function createFormatter(settings) {
		if (!settings.intl_calendar) {
			return null;
		}

		// Build a BCP 47 locale tag with the calendar extension, e.g. 'fa-u-ca-persian'.
		// For Gregorian, keep the language as-is (it's the default calendar).
		const localeWithCalendar = settings.intl_calendar === 'gregory'
			? settings.language
			: settings.language + '-u-ca-' + settings.intl_calendar;

		const formatterOptions = {
			year: 'numeric',
			month: 'short',
			day: 'numeric',
			hour: '2-digit',
			minute: '2-digit',
			timeZone: settings.timezone,
		};

		// Try the user's language + calendar first; if the browser rejects that
		// locale/calendar combination, fall back to a language-neutral locale so
		// at least the calendar system is applied.
		for (const loc of [localeWithCalendar, 'und-u-ca-' + settings.intl_calendar, 'en-u-ca-' + settings.intl_calendar]) {
			try {
				return new Intl.DateTimeFormat(loc, formatterOptions);
			} catch (e) {
				// Try next locale candidate.
			}
		}

		return null;
	}

	// main.js removes #jsonVars and stores its contents in the global `context`,
	// then dispatches `freshrss:globalContextLoaded`. main.js is async so it may
	// run after this defer script; listen for the event as a safe entry point.
	function init() {
		if (typeof context === 'undefined') return;

		// Always trust the server-side context for the current page load.
		let activeSettings = normaliseSettings({
			intl_calendar: context.intl_calendar,
			timezone: context.timezone,
			language: context.i18n?.language,
		}, 'en');

		// Persist or clear cached settings so bfcache-restored pages stay consistent.
		// When the calendar is disabled, clear the key so bfcache pages don't re-apply
		// a stale calendar.
		try {
			if (activeSettings.intl_calendar) {
				localStorage.setItem(SETTINGS_CACHE_KEY, JSON.stringify({
					intl_calendar: activeSettings.intl_calendar,
					timezone: activeSettings.timezone || '',
					language: activeSettings.language,
				}));
			} else {
				localStorage.removeItem(SETTINGS_CACHE_KEY);
				return; // Calendar disabled — nothing more to do.
			}
		} catch (e) {
			// Ignore localStorage errors (private mode, quota, etc.).
			if (!activeSettings.intl_calendar) return;
		}

		let formatter = createFormatter(activeSettings);
		if (!formatter) {
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

		// DOMContentLoaded for normal loads.
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', () => scheduleAll(document.body));
		} else {
			scheduleAll(document.body);
		}

		// On bfcache restore, `context` is stale (it belongs to the cached page).
		// Read the settings last saved to localStorage and reformat if they differ.
		window.addEventListener('pageshow', (event) => {
			if (!event.persisted) {
				return;
			}

			const nextCached = readCachedSettings();
			if (!nextCached) {
				return;
			}

			const nextSettings = normaliseSettings(nextCached, activeSettings.language);
			if (settingsSignature(nextSettings) === settingsSignature(activeSettings)) {
				return;
			}

			const nextFormatter = createFormatter(nextSettings);
			if (!nextFormatter) {
				return;
			}

			activeSettings = nextSettings;
			formatter = nextFormatter;

			document.querySelectorAll('time[datetime]').forEach((el) => {
				delete el.dataset.intlDone;
				scheduleElement(el);
			});
		});

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
	}

	if (typeof context !== 'undefined') {
		init();
	} else {
		document.addEventListener('freshrss:globalContextLoaded', init, { once: true });
	}
})();
