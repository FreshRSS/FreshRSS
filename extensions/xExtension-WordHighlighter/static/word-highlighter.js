'use strict';

/* WordHighlighter v0.0.2 (FreshRSS Extension) */

function wordHighlighter(c /* console */, Mark, context, OPTIONS) {
	const markConf = (done, counter) => ({
		caseSensitive: OPTIONS.case_sensitive || false,
		separateWordSearch: OPTIONS.separate_word_search || false,
		ignoreJoiners: OPTIONS.ignore_joiners || false,
		exclude: [
			'mark',
			...(OPTIONS.enable_in_article ? [] : ['article *']),
		],
		done: (n) => (counter.value += n) && done(),
		noMatch: done,
	});

	const m = new Mark(context);
	const changePageListener = debounce(200, (x) => {
		OPTIONS.enable_logs && c.group('WordHighlighter: page change');
		stopObserving();
		highlightWords(m, startObserving);
	});

	const mo = new MutationObserver(changePageListener);
	mo.observe(context, { subtree: true, childList: true });

	function startObserving() {
		mo.observe(context, { subtree: true, childList: true });
	}

	function stopObserving() {
		mo.disconnect();
	}

	function highlightWords(m, done) {
		const start = performance.now();
		const hCounter = { value: 0 };

		new Promise((resolve) =>
			m.mark(OPTIONS.words || [], { ...markConf(resolve, hCounter) })
		)
			.finally(() => {
				if (OPTIONS.enable_logs) {
					c.log(`WordHighlighter: ${hCounter.value} new highlights added in ${performance.now() - start}ms.`);
					c.groupEnd();
				}
				typeof done === 'function' && done();
			});
	}

	highlightWords(m);
}

// MAIN:

(function main() {
	try {
		const confName = 'WordHighlighterConf';
		const OPTIONS = window[confName] || { };
		const onMainPage = !(new URL(window.location)).searchParams.get('c');
		if (onMainPage) {
			console.log('WordHighlighter: script load...');
			const context = document.querySelector('#stream');
			wordHighlighter(console, window.Mark || (Error('mark.js library is not loaded ❗️')), context, OPTIONS);
			console.log('WordHighlighter: script loaded.✅');
		} else {
			OPTIONS.enable_logs && console.log('WordHighlighter: ❗️ paused outside of feed page');
		}
		return Promise.resolve();
	} catch (error) {
		console.error('WordHighlighter: ❌', error);
		return Promise.reject(error);
	}
})();

// Util functions:

function debounce(duration, func) {
	let timeout;
	return function (...args) {
		const effect = () => {
			timeout = null;
			return func.apply(this, args);
		};
		clearTimeout(timeout);
		timeout = setTimeout(effect, duration);
	};
}
