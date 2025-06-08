'use strict';

(function () {
	const SELECTORS = {
		box: '.box[data-feed-id]',
		boxContent: '.box-content',
		categoryButton: '.category-btn',
		categoryBox: '.box.category',
		panel: '#panel',
		overlay: '#overlay',
		closeBtn: '#overlay .close',
		entryLink: '.entry_link'
	};

	let panelLoading = false;

	function buildBoxUrl(feedId) {
		const params = new URLSearchParams({
			a: 'global',
			ajax: '1',
			feed_id: feedId
		});

		const ctx = window.context || {};

		if (ctx.sort) params.set('sort', ctx.sort);
		if (ctx.order) params.set('order', ctx.order);
		if (ctx.search) params.set('search', ctx.search);
		if (ctx.get) params.set('get', ctx.get);

		return '?' + params.toString();
	}

	function loadBoxContent(box) {
		const feedId = box.dataset.feedId;
		const url = buildBoxUrl(feedId);

		console.log('🔄 Fetching feed', feedId, url);

		fetch(url)
			.then(res => {
				if (!res.ok) {
					console.error('❌ Fetch failed', res.status, res.statusText);
					throw new Error('HTTP error');
				}
				return res.text();
			})
			.then(html => {
				const wrapper = document.createElement('div');
				wrapper.innerHTML = html;

				const newContent = wrapper.querySelector(SELECTORS.boxContent);
				const currentContent = box.querySelector(SELECTORS.boxContent);

				if (newContent && currentContent) {
					newContent.style.maxHeight = 'none';
					newContent.style.overflow = 'visible';
					currentContent.replaceWith(newContent);
					initEntryClickHandlers(newContent);
					console.log('✅ Loaded content for feed', feedId);
				} else {
					console.warn('⚠️ Content not found in AJAX response for feed', feedId);
				}
			})
			.catch(err => {
				console.error('⚠️ Error loading box for feed', feedId, err);
				const content = box.querySelector('.box-content');
				if (content) {
					content.textContent = 'Error while loading.';
				}
			});
	}

	function hardRefreshFeed(feedId, box) {
		const url = `?c=feed&a=actualize&id=${feedId}`;

		fetch(url, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
				'X-Requested-With': 'XMLHttpRequest'
			},
			body: '_csrf=' + encodeURIComponent(context.csrf)
		})
			.then(res => {
				if (!res.ok) throw new Error('Failed to update feed');
				return res.text();
			})
			.then(() => {
				loadBoxContent(box);
			})
			.catch(() => {
				const content = box.querySelector('.box-content');
				if (content) content.textContent = 'Refresh failed.';
			});
	}

	function initRefreshButtons() {
		document.querySelectorAll('.refresh-feed-btn').forEach(btn => {
			btn.addEventListener('click', (e) => {
				e.stopPropagation();
				e.preventDefault();

				const feedId = btn.dataset.feedId;
				const box = document.querySelector(`.box[data-feed-id="${feedId}"]`);
				if (box) {
					const content = box.querySelector('.box-content');
					if (content) content.textContent = 'Refreshing…';

					btn.classList.add('spin');
					setTimeout(() => btn.classList.remove('spin'), 400);

					hardRefreshFeed(feedId, box);
				}
			});
		});
	}

	function loadAllBoxContents() {
		document.querySelectorAll(SELECTORS.box).forEach(loadBoxContent);
	}

	function initCategoryFilter() {
		const buttons = document.querySelectorAll(SELECTORS.categoryButton);
		if (!buttons.length) return;

		buttons.forEach(btn => {
			btn.addEventListener('click', () => {
				const selected = btn.dataset.category;
				localStorage.setItem('freshrssSelectedCategory', selected);

				buttons.forEach(b => b.classList.remove('active'));
				btn.classList.add('active');

				document.querySelectorAll(SELECTORS.categoryBox).forEach(box => {
					box.style.display = selected === 'all' || box.classList.contains(selected) ? '' : 'none';
				});
			});
		});

		const saved = localStorage.getItem('freshrssSelectedCategory');
		if (saved) {
			const savedBtn = document.querySelector(`.category-btn[data-category="${saved}"]`);
			if (savedBtn) savedBtn.click();
		}
	}

	function initOverlayClose() {
		const overlay = document.querySelector(SELECTORS.overlay);
		const panel = document.querySelector(SELECTORS.panel);
		const closeBtn = document.querySelector(SELECTORS.closeBtn);

		closeBtn.addEventListener('click', () => {
			panel.innerHTML = '';
			panel.classList.remove('visible');
			overlay.classList.remove('visible');
			document.documentElement.classList.remove('slider-active');
			return false;
		});

		document.addEventListener('keydown', e => {
			if ((e.key || e.code).toUpperCase() === 'ESCAPE') {
				closeBtn.click();
			}
		});
	}

	function loadPanel(link) {
		if (panelLoading) return;
		panelLoading = true;

		const req = new XMLHttpRequest();
		req.open('GET', link + '&ajax=1', true);
		req.responseType = 'document';
		req.onload = function () {
			if (this.status !== 200) return;

			const html = this.response;
			const panel = document.querySelector(SELECTORS.panel);
			const overlay = document.querySelector(SELECTORS.overlay);
			const foreign = html.querySelectorAll('.nav_menu, #stream .day, #stream .flux, #stream-footer, #stream.prompt');

			foreign.forEach(el => panel.appendChild(document.adoptNode(el)));
			panel.querySelectorAll('.nav_menu > :not([id="nav_menu_read_all"])').forEach(el => el.remove());

			init_posts();
			init_load_more(panel);

			overlay.classList.add('visible');
			panel.classList.add('visible');
			document.documentElement.classList.add('slider-active');

			panel.scrollTop = 0;
			document.documentElement.scrollTop = 0;

			panel.addEventListener('click', ev => {
				const btn = ev.target.closest('#nav_menu_read_all button, #bigMarkAsRead');
				if (btn) {
					const req2 = new XMLHttpRequest();
					req2.open('POST', btn.formAction, false);
					req2.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
					req2.send(JSON.stringify({ _csrf: context.csrf }));
					if (req2.status === 200) {
						location.reload(false);
						return false;
					}
				}
			});

			panelLoading = false;
		};
		req.send();
	}

	function mark_entry_as_read(entryId) {
		if (!entryId || !context || !context.csrf) return;

		const formData = new FormData();
		formData.append('id', entryId);
		formData.append('ajax', '1');
		formData.append('_csrf', context.csrf);

		const xhr = new XMLHttpRequest();
		xhr.open('POST', '?c=entry&a=read', true);
		xhr.send(formData);
	}

	function markEntryAsRead(entryId) {
		mark_entry_as_read(entryId);
	}

	function initEntryClickHandlers(scope = document) {
		scope.querySelectorAll(SELECTORS.entryLink).forEach(link => {
			link.addEventListener('click', () => {
				const li = link.closest('li[data-entry-id]');
				if (li) {
					const entryId = li.dataset.entryId;
					markEntryAsRead(entryId);
					li.classList.remove('not_read');
				}
			});
		});
	}

	function initBoxLinks() {
		document.querySelectorAll('.box a:not(.entry_link)').forEach(a => {
			a.addEventListener('click', e => {
				e.preventDefault();
				loadPanel(a.href);
			});
		});
	}

	function initSortable() {
		const stream = document.getElementById('stream');
		if (!stream) return;

		const savedOrder = JSON.parse(localStorage.getItem('freshrssFeedOrder') || '[]');

		if (savedOrder.length) {
			const boxes = [...stream.querySelectorAll('.box')];
			savedOrder.forEach(id => {
				const box = boxes.find(b => b.dataset.feedId === id);
				if (box) stream.appendChild(box);
			});
		}

		if (typeof Sortable !== 'undefined') {
			Sortable.create(stream, {
				animation: 150,
				handle: '.box-title',
				draggable: '.box',
				onEnd: () => {
					const ids = [...stream.querySelectorAll('.box')].map(b => b.dataset.feedId);
					localStorage.setItem('freshrssFeedOrder', JSON.stringify(ids));
					console.log('💾 Saved order to localStorage:', ids);
				}
			});
			console.log('✅ Sortable initialized');
		} else {
			console.warn('⚠️ Sortable.js not loaded');
		}
	}

	function initGlobalView() {
		console.log('🚀 initGlobalView');
		initBoxLinks();
		initCategoryFilter();
		loadAllBoxContents();
		initEntryClickHandlers();
		initRefreshButtons();
		initSortable();
	}

	function initAll() {
		if (!window.context) {
			console.log('FreshRSS global view waiting for context…');
			setTimeout(initAll, 50);
			return;
		}
		setTimeout(() => {
			initGlobalView();
			initOverlayClose();
		}, 0);
	}

	if (document.readyState && document.readyState !== 'loading') {
		initAll();
	} else {
		document.addEventListener('DOMContentLoaded', initAll);
	}

	document.addEventListener('pjax:end', () => {
		if (document.body.classList.contains('global')) {
			initGlobalView();
		}
	});
})();
