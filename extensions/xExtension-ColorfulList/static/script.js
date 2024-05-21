'use strict';
window.onload = function () {
	// Initial Colorize for situation where 'no new item changes triggered later' (https://github.com/FreshRSS/Extensions/issues/183)
	colorize();
	// Insert entry monitor for autoloading list
	monitorEntry(colorize);
	function monitorEntry(monitorCallback) {
		const targetNode = document.getElementById('stream');
		const config = { attributes: false, childList: true, subtree: false };
		const callback = function (mutationsList, observer) {
			for (const mutation of mutationsList) {
				if (mutation.type === 'childList') {
					monitorCallback(mutationsList);
				}
			}
		};
		const observer = new MutationObserver(callback);
		if (targetNode) {
			observer.observe(targetNode, config);
		}
	}
};

function colorize(mList) {
	const entry = document.querySelectorAll('.flux_header');
	entry.forEach((e, i) => {
		const cl = stringToColour(e.querySelector('.website').textContent) + '12';
		e.style.background = cl;
	});
}

const stringToColour = (str) => {
	let hash = 0;
	str.split('').forEach(char => {
		hash = char.charCodeAt(0) + ((hash << 5) - hash);
	});
	let color = '#';
	for (let i = 0; i < 3; i++) {
		const value = (hash >> (i * 8)) & 0xff;
		color += value.toString(16).padStart(2, '0');
	}
	return color;
};
