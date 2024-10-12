/* globals context, quick_collapse_vars */

(function () {
	function toggleCollapse() {
		const streamElem = document.getElementById('stream');
		const toggleElem = document.getElementById('toggle-collapse');
		const wasCollapsed = streamElem.classList.contains('hide_posts');

		if (wasCollapsed) {
			streamElem.classList.remove('hide_posts');
			toggleElem.classList.remove('collapsed');
		} else {
			streamElem.classList.add('hide_posts');
			toggleElem.classList.add('collapsed');
		}

		if (context.does_lazyload && wasCollapsed) {
			const lazyloadedElements = streamElem.querySelectorAll(
				'img[data-original], iframe[data-original]'
			);
			lazyloadedElements.forEach(function (el) {
				el.src = el.getAttribute('data-original');
				el.removeAttribute('data-original');
			});
		}
	}

	function syncWithContext() {
		if (!window.context || !window.quick_collapse_vars) {
			// The variables might not be available yet, so we need to wait for them.
			return setTimeout(syncWithContext, 10);
		}

		const toggleElem = document.getElementById('toggle-collapse');
		toggleElem.title = quick_collapse_vars.i18n.toggle_collapse;
		toggleElem.innerHTML = `<img class="icon uncollapse" src="${quick_collapse_vars.icon_url_out}" alt="↕" />`;
		toggleElem.innerHTML += `<img class="icon collapse" src="${quick_collapse_vars.icon_url_in}" alt="✖" />`;

		if (context.hide_posts) {
			toggleElem.classList.add('collapsed');
		}
	}

	const streamElem = document.getElementById('stream');
	if (!streamElem || !streamElem.classList.contains('normal')) {
		// The button should be enabled only on "normal" view
		return;
	}

	// create the new button
	const toggleElem = document.createElement('button');
	toggleElem.id = 'toggle-collapse';
	toggleElem.classList.add('btn');
	toggleElem.addEventListener('click', toggleCollapse);

	// replace the "order" button by a stick containing the order and the
	// collapse buttons
	const orderElem = document.getElementById('toggle-order');

	const stickElem = document.createElement('div');
	stickElem.classList.add('stick');

	orderElem.parentNode.insertBefore(stickElem, orderElem);
	stickElem.appendChild(orderElem);
	stickElem.appendChild(toggleElem);

	// synchronizes the collapse button with dynamic vars passed via the
	// backend (async mode).
	syncWithContext();
}());
