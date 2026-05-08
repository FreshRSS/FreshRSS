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
		const localeWithCalendar = settings.language + '-u-ca-' + settings.intl_calendar;

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

	// --- Reverse calendar conversion for date: search tokens ---

	/**
	 * Approximate additive offset: calendarYear + offset ≈ Gregorian year.
	 * Used only to seed the binary-search window; ±3-year margin covers drift.
	 */
	const CALENDAR_GREG_OFFSETS = {
		persian: 621,
		'islamic-civil': 578,
		'islamic-umalqura': 578,
		hebrew: -3761,
		buddhist: -543,
		ethiopic: 7,
		roc: 1911,
		indian: 78,
		japanese: 2018,
		chinese: 0,
	};

	/** Formatter that returns numeric date parts in Latin (ASCII) numerals. */
	function makeReverseFormatter(calendarId, language) {
		for (const loc of [
			language + '-u-ca-' + calendarId + '-nu-latn',
			'und-u-ca-' + calendarId + '-nu-latn',
			'en-u-ca-' + calendarId + '-nu-latn',
		]) {
			try {
				const fmt = new Intl.DateTimeFormat(loc, {
					year: 'numeric', month: 'numeric', day: 'numeric', timeZone: 'UTC',
				});
				fmt.formatToParts(new Date(0)); // smoke-test
				return fmt;
			} catch (e) { /* try next */ }
		}
		return null;
	}

	function getCalendarParts(fmt, dayIndex) {
		const parts = {};
		fmt.formatToParts(new Date(dayIndex * 86400000)).forEach(p => {
			if (p.type !== 'literal') {
				const n = parseInt(p.value, 10);
				parts[p.type] = isNaN(n) ? 0 : n;
			}
		});
		return parts;
	}

	/** Binary search: first day index where compare() === 0. Returns -1 if not found. */
	function findFirstMatchingDay(compare, low, high) {
		let found = -1;
		while (low <= high) {
			const mid = (low + high) >> 1;
			const c = compare(mid);
			if (c < 0) { low = mid + 1; }
			else if (c > 0) { high = mid - 1; }
			else { found = mid; high = mid - 1; }
		}
		return found;
	}

	/** Binary search: last day index where compare() === 0. Returns -1 if not found. */
	function findLastMatchingDay(compare, low, high) {
		let found = -1;
		while (low <= high) {
			const mid = (low + high) >> 1;
			const c = compare(mid);
			if (c < 0) { low = mid + 1; }
			else if (c > 0) { high = mid - 1; }
			else { found = mid; low = mid + 1; }
		}
		return found;
	}

	/**
	 * Convert a single calendar date string ("1402", "1402-10", "1402-10-25") to
	 * a Gregorian ISO date for the start or end of that period.
	 * Returns null if conversion fails.
	 */
	function calendarDateToGregorian(dateStr, calendarId, language, bound) {
		const m = /^(\d+)(?:-(\d+)(?:-(\d+))?)?$/.exec(dateStr);
		if (!m) return null;

		const calYear = parseInt(m[1], 10);
		const calMonth = m[2] !== undefined ? parseInt(m[2], 10) : null;
		const calDay = m[3] !== undefined ? parseInt(m[3], 10) : null;

		const fmt = makeReverseFormatter(calendarId, language);
		if (!fmt) return null;

		function compare(dayIndex) {
			const p = getCalendarParts(fmt, dayIndex);
			if (p.year !== calYear) return p.year < calYear ? -1 : 1;
			if (calMonth !== null && p.month !== calMonth) return p.month < calMonth ? -1 : 1;
			if (calDay !== null && p.day !== calDay) return p.day < calDay ? -1 : 1;
			return 0;
		}

		const estGYear = calYear + (CALENDAR_GREG_OFFSETS[calendarId] || 0);
		const LOW = Math.floor(Date.UTC(estGYear - 3, 0, 1) / 86400000);
		const HIGH = Math.floor(Date.UTC(estGYear + 3, 11, 31) / 86400000);

		const dayIndex = bound === 'start'
			? findFirstMatchingDay(compare, LOW, HIGH)
			: findLastMatchingDay(compare, LOW, HIGH);

		return dayIndex >= 0 ? new Date(dayIndex * 86400000).toISOString().slice(0, 10) : null;
	}

	/**
	 * Convert a date token value from the user's calendar to a Gregorian ISO range.
	 * E.g. "1402-10" (Persian) → "2023-12-22/2024-01-20"
	 * Returns null if no conversion needed or possible.
	 */
	function toGregorianSearchRange(value, calendarId, language) {
		if (!value || !calendarId) return null;
		if (/^P/i.test(value)) return null; // ISO 8601 duration — leave as-is

		const slash = value.indexOf('/');
		if (slash !== -1) {
			const gLeft = calendarDateToGregorian(value.slice(0, slash), calendarId, language, 'start');
			const gRight = calendarDateToGregorian(value.slice(slash + 1), calendarId, language, 'end');
			return gLeft && gRight ? gLeft + '/' + gRight : null;
		}

		const gStart = calendarDateToGregorian(value, calendarId, language, 'start');
		const gEnd = calendarDateToGregorian(value, calendarId, language, 'end');
		if (!gStart || !gEnd) return null;
		return gStart === gEnd ? gStart : gStart + '/' + gEnd;
	}

	/**
	 * In a search query string, replace date:/pubdate:/mdate:/userdate: token values
	 * with their Gregorian ISO equivalents (handles !date: and -date: negations too,
	 * since \b fires before the keyword whether preceded by space, !, -, ( or start).
	 */
	function convertSearchDates(query, calendarId, language) {
		return query.replace(/\b(date|pubdate|mdate|userdate):(\S*)/g, (match, keyword, value) => {
			const gregorian = toGregorianSearchRange(value, calendarId, language);
			return gregorian ? keyword + ':' + gregorian : match;
		});
	}

	/** Attach a submit listener that rewrites calendar date tokens to Gregorian before the GET fires. */
	function attachSearchConversion(settings) {
		document.addEventListener('submit', (event) => {
			const input = event.target.querySelector('input[name="search"]');
			if (!input || !input.value) return;
			const converted = convertSearchDates(input.value, settings.intl_calendar, settings.language);
			if (converted !== input.value) {
				input.value = converted;
			}
		});
	}

	// --- Reverse (Gregorian → calendar) conversion for search input display ---

	/**
	 * Parse a YYYY-MM-DD ISO string to a day index (days since Unix epoch, UTC).
	 */
	function isoToDayIndex(iso) {
		const parts = iso.split('-');
		return Math.floor(Date.UTC(Number(parts[0]), Number(parts[1]) - 1, Number(parts[2])) / 86400000);
	}

	/**
	 * Convert a Gregorian ISO date token value to a calendar-system token string.
	 * Collapses whole-year and whole-month ranges to compact form (YYYY, YYYY-MM).
	 * Returns null if the value is not a convertible ISO date or range.
	 */
	function gregorianTokenToCalendarToken(value, revFmt) {
		if (!value || /^P/i.test(value)) return null; // ISO duration — leave as-is

		const slash = value.indexOf('/');
		if (slash !== -1) {
			const leftISO = value.slice(0, slash);
			const rightISO = value.slice(slash + 1);
			if (!/^\d{4}-\d{2}-\d{2}$/.test(leftISO) || !/^\d{4}-\d{2}-\d{2}$/.test(rightISO)) return null;

			const startDay = isoToDayIndex(leftISO);
			const endDay = isoToDayIndex(rightISO);
			const sp = getCalendarParts(revFmt, startDay);
			const ep = getCalendarParts(revFmt, endDay);

			if (startDay === endDay) {
				return sp.year + '-' + String(sp.month).padStart(2, '0') + '-' + String(sp.day).padStart(2, '0');
			}

			if (sp.year === ep.year) {
				// Whole calendar year?
				if (sp.month === 1 && sp.day === 1) {
					const np = getCalendarParts(revFmt, endDay + 1);
					if (np.year !== ep.year) {
						return String(sp.year);
					}
				}
				// Whole calendar month?
				if (sp.month === ep.month && sp.day === 1) {
					const np = getCalendarParts(revFmt, endDay + 1);
					if (np.month !== ep.month || np.year !== ep.year) {
						return sp.year + '-' + String(sp.month).padStart(2, '0');
					}
				}
			}

			// Generic range — show both endpoints
			return sp.year + '-' + String(sp.month).padStart(2, '0') + '-' + String(sp.day).padStart(2, '0')
				+ '/' + ep.year + '-' + String(ep.month).padStart(2, '0') + '-' + String(ep.day).padStart(2, '0');
		}

		// Single ISO date
		if (!/^\d{4}-\d{2}-\d{2}$/.test(value)) return null;
		const day = isoToDayIndex(value);
		const p = getCalendarParts(revFmt, day);
		return p.year + '-' + String(p.month).padStart(2, '0') + '-' + String(p.day).padStart(2, '0');
	}

	/**
	 * In a search query string, replace Gregorian ISO date tokens with calendar equivalents.
	 */
	function convertDisplayDates(query, calendarId, language) {
		if (!calendarId) return query;
		const revFmt = makeReverseFormatter(calendarId, language);
		if (!revFmt) return query;
		return query.replace(/\b(date|pubdate|mdate|userdate):(\S*)/g, (match, keyword, value) => {
			const calToken = gregorianTokenToCalendarToken(value, revFmt);
			return calToken ? keyword + ':' + calToken : match;
		});
	}

	/** Rewrite Gregorian date tokens in all search inputs to calendar-system equivalents. */
	function convertSearchInputs(calendarId, language) {
		document.querySelectorAll('input[name="search"]').forEach(input => {
			if (!input.value) return;
			const converted = convertDisplayDates(input.value, calendarId, language);
			if (converted !== input.value) {
				input.value = converted;
			}
		});
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
			document.addEventListener('DOMContentLoaded', () => {
				scheduleAll(document.body);
				convertSearchInputs(activeSettings.intl_calendar, activeSettings.language);
			});
		} else {
			scheduleAll(document.body);
			convertSearchInputs(activeSettings.intl_calendar, activeSettings.language);
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

		// Convert calendar date tokens in search queries to Gregorian before submission.
		attachSearchConversion(activeSettings);
	}

	if (typeof context !== 'undefined') {
		init();
	} else {
		document.addEventListener('freshrss:globalContextLoaded', init, { once: true });
	}
})();
