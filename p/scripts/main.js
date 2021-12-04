// @license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-3.0
'use strict';

// <Polyfills>
if (!document.scrollingElement) document.scrollingElement = document.documentElement;
if (!NodeList.prototype.forEach) NodeList.prototype.forEach = Array.prototype.forEach;
if (!Element.prototype.matches) {
	Element.prototype.matches = Element.prototype.msMatchesSelector || Element.prototype.mozMatchesSelector || Element.prototype.webkitMatchesSelector;
}
if (!Element.prototype.closest) {
	Element.prototype.closest = function (s) {
		let el = this;
		do {
			if (el.matches(s)) return el;
			el = el.parentElement;
		} while (el);
		return null;
	};
}
if (!Element.prototype.remove) Element.prototype.remove = function () { if (this.parentNode) this.parentNode.removeChild(this); };
// </Polyfills>

// <Utils>
function xmlHttpRequestJson(req) {
	let json = req.response;
	if (req.responseType !== 'json') {	// IE11
		try {
			json = JSON.parse(req.responseText);
		} catch (ex) {
			json = null;
		}
	}
	return json;
}
// </Utils>

// <Global context>
/* eslint-disable no-var */
var context;
/* eslint-enable no-var */

(function parseJsonVars() {
	const jsonVars = document.getElementById('jsonVars');
	const json = JSON.parse(jsonVars.innerHTML);
	jsonVars.outerHTML = '';
	context = json.context;
	context.ajax_loading = false;
	context.i18n = json.i18n;
	context.shortcuts = json.shortcuts;
	context.urls = json.urls;
	context.icons = json.icons;
	context.icons.read = decodeURIComponent(context.icons.read);
	context.icons.unread = decodeURIComponent(context.icons.unread);
	context.extensions = json.extensions;
}());
// </Global context>

function badAjax(reload) {
	openNotification(context.i18n.notif_request_failed, 'bad');
	if (reload) {
		setTimeout(function () { location.reload(); }, 2000);
	}
	return true;
}

function needsScroll(elem) {
	const winBottom = document.scrollingElement.scrollTop + document.scrollingElement.clientHeight;
	const elemTop = elem.offsetParent.offsetTop + elem.offsetTop;
	const elemBottom = elemTop + elem.offsetHeight;
	if (elemTop < document.scrollingElement.scrollTop || elemBottom > winBottom) {
		return elemTop - (document.scrollingElement.clientHeight / 2);
	}
	return 0;
}

function str2int(str) {
	if (!str) {
		return 0;
	}
	return parseInt(str.replace(/\D/g, ''), 10) || 0;
}

function numberFormat(nStr) {
	if (nStr < 0) {
		return 0;
	}
	// http://www.mredkj.com/javascript/numberFormat.html
	nStr += '';
	const x = nStr.split('.');
	const x2 = x.length > 1 ? '.' + x[1] : '';
	const rgx = /(\d+)(\d{3})/;
	let x1 = x[0];
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1 $2');
	}
	return x1 + x2;
}

function incLabel(p, inc, spaceAfter) {
	const i = str2int(p) + inc;
	return i > 0 ? ((spaceAfter ? '' : ' ') + '(' + numberFormat(i) + ')' + (spaceAfter ? ' ' : '')) : '';
}

function incUnreadsFeed(article, feed_id, nb) {
	// Update unread: feed
	let elem = document.getElementById(feed_id);
	let feed_unreads = elem ? str2int(elem.getAttribute('data-unread')) : 0;
	const feed_priority = elem ? str2int(elem.getAttribute('data-priority')) : 0;
	if (elem) {
		elem.setAttribute('data-unread', feed_unreads + nb);
		elem = elem.querySelector('.item-title');
		if (elem) {
			elem.setAttribute('data-unread', numberFormat(feed_unreads + nb));
		}
	}

	// Update unread: category
	elem = document.getElementById(feed_id).closest('.category');
	feed_unreads = elem ? str2int(elem.getAttribute('data-unread')) : 0;
	if (elem) {
		elem.setAttribute('data-unread', feed_unreads + nb);
		elem = elem.querySelector('.title');
		if (elem) {
			elem.setAttribute('data-unread', numberFormat(feed_unreads + nb));
		}
	}

	// Update unread: all
	if (feed_priority > 0) {
		elem = document.querySelector('#aside_feed .all .title');
		if (elem) {
			feed_unreads = elem ? str2int(elem.getAttribute('data-unread')) : 0;
			elem.setAttribute('data-unread', numberFormat(feed_unreads + nb));
		}
	}

	// Update unread: favourites
	if (article && article.closest('div').classList.contains('favorite')) {
		elem = document.querySelector('#aside_feed .favorites .title');
		if (elem) {
			feed_unreads = elem ? str2int(elem.getAttribute('data-unread')) : 0;
			elem.setAttribute('data-unread', numberFormat(feed_unreads + nb));
		}
	}

	let isCurrentView = false;
	// Update unread: title
	document.title = document.title.replace(/^((?:\([\s0-9]+\) )?)/, function (m, p1) {
		const feed = document.getElementById(feed_id);
		if (article || feed.closest('.active')) {
			isCurrentView = true;
			return incLabel(p1, nb, true);
		} else if (document.querySelector('.all.active')) {
			isCurrentView = feed_priority > 0;
			return incLabel(p1, feed_priority > 0 ? nb : 0, true);
		} else {
			return p1;
		}
	});
	return isCurrentView;
}

function incUnreadsTag(tag_id, nb) {
	let t = document.getElementById(tag_id);
	if (t) {
		const unreads = str2int(t.getAttribute('data-unread'));
		t.setAttribute('data-unread', unreads + nb);
		t.querySelector('.item-title').setAttribute('data-unread', numberFormat(unreads + nb));
	}
	t = document.querySelector('.category.tags .title');
	if (t) {
		const unreads = str2int(t.getAttribute('data-unread'));
		t.setAttribute('data-unread', numberFormat(unreads + nb));
	}
}

function removeArticle(div) {
	if (!div || div.classList.contains('not_read') || (context.auto_mark_article && div.classList.contains('active'))) {
		return;
	}
	let scrollTop = box_to_follow.scrollTop;
	let dirty = false;
	const p = div.previousElementSibling;
	const n = div.nextElementSibling;
	if (p && p.classList.contains('day') && n && n.classList.contains('day')) {
		scrollTop -= p.offsetHeight;
		dirty = true;
		p.remove();
	}
	if (div.offsetHeight > 0 && div.offsetParent.offsetTop + div.offsetTop + div.offsetHeight < scrollTop) {
		scrollTop -= div.offsetHeight;
		dirty = true;
	}
	div.remove();
	if (dirty) {
		box_to_follow.scrollTop = scrollTop;
	}
}

const pending_entries = {};
let mark_read_queue = [];

function send_mark_read_queue(queue, asRead, callback) {
	if (!queue || queue.length === 0) {
		if (callback) {
			callback();
		}
		return;
	}
	const req = new XMLHttpRequest();
	req.open('POST', '.?c=entry&a=read' + (asRead ? '' : '&is_read=0'), true);
	req.responseType = 'json';
	req.onerror = function (e) {
		for (let i = queue.length - 1; i >= 0; i--) {
			delete pending_entries['flux_' + queue[i]];
		}
		badAjax(this.status == 403);
	};
	req.onload = function (e) {
		if (this.status != 200) {
			return req.onerror(e);
		}
		const json = xmlHttpRequestJson(this);
		if (!json) {
			return req.onerror(e);
		}
		for (let i = queue.length - 1; i >= 0; i--) {
			const div = document.getElementById('flux_' + queue[i]);
			const myIcons = context.icons;
			let inc = 0;
			if (div.classList.contains('not_read')) {
				div.classList.remove('not_read');
				div.querySelectorAll('a.read').forEach(function (a) {
					a.href = a.href.replace('&is_read=0', '') + '&is_read=1';
				});
				div.querySelectorAll('a.read > .icon').forEach(function (img) { img.outerHTML = myIcons.read; });
				inc--;
				if (context.auto_remove_article) {
					removeArticle(div);
				}
			} else {
				div.classList.add('not_read');
				div.classList.add('keep_unread');	// Split for IE11
				div.querySelectorAll('a.read').forEach(function (a) {
					a.href = a.href.replace('&is_read=1', '');
				});
				div.querySelectorAll('a.read > .icon').forEach(function (img) { img.outerHTML = myIcons.unread; });
				inc++;
			}
			const feed_link = div.querySelector('.website > a, a.website');
			if (feed_link) {
				const feed_url = feed_link.href;
				const feed_id = feed_url.substr(feed_url.lastIndexOf('f_'));
				incUnreadsFeed(div, feed_id, inc);
			}
			delete pending_entries['flux_' + queue[i]];
		}
		faviconNbUnread();
		if (json.tags) {
			const tagIds = Object.keys(json.tags);
			for (let i = tagIds.length - 1; i >= 0; i--) {
				const tagId = tagIds[i];
				incUnreadsTag(tagId, (asRead ? -1 : 1) * json.tags[tagId].length);
			}
		}
		onScroll();
		if (callback) {
			callback();
		}
	};
	req.setRequestHeader('Content-Type', 'application/json');
	req.send(JSON.stringify({
		ajax: true,
		_csrf: context.csrf,
		id: queue,
	}));
}

let send_mark_read_queue_timeout = 0;

function send_mark_queue_tick(callback) {
	send_mark_read_queue_timeout = 0;
	const queue = mark_read_queue.slice(0);
	mark_read_queue = [];
	send_mark_read_queue(queue, true, callback);
}
const delayedFunction = send_mark_queue_tick;

function delayedClick(a) {
	if (a) {
		delayedFunction(function () { a.click(); });
	}
}

function mark_read(div, only_not_read, asBatch) {
	if (!div || !div.id || context.anonymous ||
		(only_not_read && !div.classList.contains('not_read'))) {
		return false;
	}
	if (pending_entries[div.id]) {
		return false;
	}
	pending_entries[div.id] = true;

	const asRead = div.classList.contains('not_read');
	const entryId = div.id.replace(/^flux_/, '');
	if (asRead && asBatch) {
		mark_read_queue.push(entryId);
		if (send_mark_read_queue_timeout == 0) {
			send_mark_read_queue_timeout = setTimeout(function () { send_mark_queue_tick(null); }, 1000);
		}
	} else {
		const queue = [entryId];
		send_mark_read_queue(queue, asRead);
	}
}

function mark_previous_read(div) {
	while (div) {
		mark_read(div, true, true);
		div = div.previousElementSibling;
	}
}

function mark_favorite(div) {
	if (!div) {
		return false;
	}

	const a = div.querySelector('a.bookmark');
	const url = a ? a.href : '';
	if (!url) {
		return false;
	}

	if (pending_entries[div.id]) {
		return false;
	}
	pending_entries[div.id] = true;

	const req = new XMLHttpRequest();
	req.open('POST', url, true);
	req.responseType = 'json';
	req.onerror = function (e) {
		delete pending_entries[div.id];
		badAjax(this.status == 403);
	};
	req.onload = function (e) {
		if (this.status != 200) {
			return req.onerror(e);
		}
		const json = xmlHttpRequestJson(this);
		if (!json) {
			return req.onerror(e);
		}
		let inc = 0;
		if (div.classList.contains('favorite')) {
			div.classList.remove('favorite');
			inc--;
		} else {
			div.classList.add('favorite');
			inc++;
		}
		div.querySelectorAll('a.bookmark').forEach(function (a) { a.href = json.url; });
		div.querySelectorAll('a.bookmark > .icon').forEach(function (img) { img.outerHTML = json.icon; });

		const favourites = document.querySelector('#aside_feed .favorites .title');
		if (favourites) {
			favourites.textContent = favourites.textContent.replace(/((?: \([\s0-9]+\))?\s*)$/, function (m, p1) {
				return incLabel(p1, inc, false);
			});
		}

		if (div.classList.contains('not_read')) {
			const elem = document.querySelector('#aside_feed .favorites .title');
			const feed_unreads = elem ? str2int(elem.getAttribute('data-unread')) : 0;
			if (elem) {
				elem.setAttribute('data-unread', numberFormat(feed_unreads + inc));
			}
		}

		delete pending_entries[div.id];
	};
	req.setRequestHeader('Content-Type', 'application/json');
	req.send(JSON.stringify({
		ajax: true,
		_csrf: context.csrf,
	}));
}

const freshrssOpenArticleEvent = document.createEvent('Event');
freshrssOpenArticleEvent.initEvent('freshrss:openArticle', true, true);

function toggleContent(new_active, old_active, skipping) {
	// If skipping, move current without activating or marking as read
	if (!new_active) {
		return;
	}

	if (context.does_lazyload && !skipping) {
		new_active.querySelectorAll('img[data-original], iframe[data-original]').forEach(function (el) {
			el.src = el.getAttribute('data-original');
			el.removeAttribute('data-original');
		});
	}

	if (old_active !== new_active) {
		if (!skipping) {
			new_active.classList.add('active');
		}
		new_active.classList.add('current');
		if (old_active) {
			old_active.classList.remove('active');
			old_active.classList.remove('current');	// Split for IE11
			if (context.auto_remove_article) {
				removeArticle(old_active);
			}
		}
	} else {
		new_active.classList.toggle('active');
	}

	const relative_move = context.current_view === 'global';
	const box_to_move = relative_move ? document.getElementById('panel') : document.scrollingElement;

	if (context.sticky_post) {	// Stick the article to the top when opened
		const prev_article = new_active.previousElementSibling;
		let new_pos = new_active.offsetParent.offsetTop + new_active.offsetTop;

		if (prev_article && new_active.offsetTop - prev_article.offsetTop <= 150) {
			new_pos = prev_article.offsetParent.offsetTop + prev_article.offsetTop;
			if (relative_move) {
				new_pos -= box_to_move.offsetTop;
			}
		}

		if (skipping) {
			// when skipping, this feels more natural if it's not so near the top
			new_pos -= document.body.clientHeight / 4;
		}
		if (relative_move) {
			new_pos += box_to_move.scrollTop;
		}
		box_to_move.scrollTop = new_pos;
	}

	if (new_active.classList.contains('active') && !skipping) {
		if (context.auto_mark_article) {
			mark_read(new_active, true, true);
		}
		new_active.dispatchEvent(freshrssOpenArticleEvent);
	}
	onScroll();
}

function prev_entry(skipping) {
	const old_active = document.querySelector('.flux.current');
	let new_active = old_active;
	if (new_active) {
		do new_active = new_active.previousElementSibling;
		while (new_active && !new_active.classList.contains('flux'));
		if (!new_active) {
			prev_feed();
		}
	} else {
		new_active = document.querySelector('.flux');
	}
	toggleContent(new_active, old_active, skipping);
}

function next_entry(skipping) {
	const old_active = document.querySelector('.flux.current');
	let new_active = old_active;
	if (new_active) {
		do new_active = new_active.nextElementSibling;
		while (new_active && !new_active.classList.contains('flux'));
		if (!new_active) {
			next_feed();
		}
	} else {
		new_active = document.querySelector('.flux');
	}
	toggleContent(new_active, old_active, skipping);
}

function next_unread_entry(skipping) {
	const old_active = document.querySelector('.flux.current');
	let new_active = old_active;
	if (new_active) {
		do new_active = new_active.nextElementSibling;
		while (new_active && !new_active.classList.contains('not_read'));
		if (!new_active) {
			next_feed();
		}
	} else {
		new_active = document.querySelector('.not_read');
	}
	toggleContent(new_active, old_active, skipping);
}

function prev_feed() {
	let found = false;
	let adjacent = null;
	const feeds = document.querySelectorAll('#aside_feed .feed');
	for (let i = feeds.length - 1; i >= 0; i--) {
		const feed = feeds[i];
		if (feed.classList.contains('active')) {
			found = true;
			continue;
		}
		if (!found) {
			continue;
		}
		if (getComputedStyle(feed).display === 'none') {
			continue;
		}
		if (feed.dataset.unread != 0) {
			return delayedClick(feed.querySelector('a.item-title'));
		} else if (adjacent === null) {
			adjacent = feed;
		}
	}
	if (found) {
		delayedClick(adjacent.querySelector('a.item-title'));
	} else {
		last_feed();
	}
}

function next_feed() {
	let found = false;
	let adjacent = null;
	const feeds = document.querySelectorAll('#aside_feed .feed');
	for (let i = 0; i < feeds.length; i++) {
		const feed = feeds[i];
		if (feed.classList.contains('active')) {
			found = true;
			continue;
		}
		if (!found) {
			continue;
		}
		if (getComputedStyle(feed).display === 'none') {
			continue;
		}
		if (feed.dataset.unread != 0) {
			return delayedClick(feed.querySelector('a.item-title'));
		} else if (adjacent === null) {
			adjacent = feed;
		}
	}
	if (found) {
		delayedClick(adjacent.querySelector('a.item-title'));
	} else {
		first_feed();
	}
}

function first_feed() {
	const a = document.querySelector('#aside_feed .category.active .feed:not([data-unread="0"]) a.item-title');
	delayedClick(a);
}

function last_feed() {
	const links = document.querySelectorAll('#aside_feed .category.active .feed:not([data-unread="0"]) a.item-title');
	if (links && links.length > 0) {
		delayedClick(links[links.length - 1]);
	}
}

function prev_category() {
	const active_cat = document.querySelector('#aside_feed .category.active');
	if (active_cat) {
		let cat = active_cat;
		do cat = cat.previousElementSibling;
		while (cat && getComputedStyle(cat).display === 'none');
		if (cat) {
			delayedClick(cat.querySelector('a.title'));
		}
	} else {
		last_category();
	}
}

function next_category() {
	const active_cat = document.querySelector('#aside_feed .category.active');
	if (active_cat) {
		let cat = active_cat;
		do cat = cat.nextElementSibling;
		while (cat && getComputedStyle(cat).display === 'none');
		if (cat) {
			delayedClick(cat.querySelector('a.title'));
		}
	} else {
		first_category();
	}
}

function next_unread_category() {
	const active_cat = document.querySelector('#aside_feed .category.active');
	if (active_cat) {
		let cat = active_cat;
		do cat = cat.nextElementSibling;
		while (cat && cat.getAttribute('data-unread') <= 0);
		if (cat) {
			delayedClick(cat.querySelector('a.title'));
		}
	} else {
		first_category();
	}
}

function first_category() {
	const a = document.querySelector('#aside_feed .category:not([data-unread="0"]) a.title');
	delayedClick(a);
}

function last_category() {
	const links = document.querySelectorAll('#aside_feed .category:not([data-unread="0"]) a.title');
	if (links && links.length > 0) {
		delayedClick(links[links.length - 1]);
	}
}

function collapse_entry() {
	const flux_current = document.querySelector('.flux.current');
	toggleContent(flux_current, flux_current, false);
}

function toggle_media() {
	const media = document.querySelector('.flux.current video,.flux.current audio');
	if (media === null) {
		return;
	}
	if (media.paused) {
		media.play();
	} else {
		media.pause();
	}
}

function user_filter(key) {
	const filter = document.getElementById('dropdown-query');
	const filters = filter.parentElement.querySelectorAll('.dropdown-menu > .query > a');
	if (typeof key === 'undefined') {
		if (!filters.length) {
			return;
		}
		// Display the filter div
		location.hash = filter.id;
		// Force scrolling to the filter div
		const scroll = needsScroll(document.querySelector('.header'));
		if (scroll !== 0) {
			document.scrollingElement.scrollTop = scroll;
		}
		// Force the key value if there is only one action, so we can trigger it automatically
		if (filters.length === 1) {
			key = 1;
		} else {
			return;
		}
	}
	// Trigger selected share action
	key = parseInt(key);
	if (key <= filters.length) {
		filters[key - 1].click();
	}
}

function auto_share(key) {
	const share = document.querySelector('.flux.current.active .dropdown-target[id^="dropdown-share"]');
	if (!share) {
		return;
	}
	const shares = share.parentElement.querySelectorAll('.dropdown-menu .item a');
	if (typeof key === 'undefined') {
		// Display the share div
		location.hash = share.id;
		// Force scrolling to the share div
		const scrollTop = needsScroll(share.closest('.bottom'));
		if (scrollTop !== 0) {
			document.scrollingElement.scrollTop = scrollTop;
		}
		// Force the key value if there is only one action, so we can trigger it automatically
		if (shares.length === 1) {
			key = 1;
		} else {
			return;
		}
	}
	// Trigger selected share action and hide the share div
	key = parseInt(key);
	if (key <= shares.length) {
		shares[key - 1].click();
		share.parentElement.querySelector('.dropdown-menu .dropdown-close a').click();
	}
}

let box_to_follow;

function onScroll() {
	if (!box_to_follow) {
		return;
	}
	if (context.auto_mark_scroll) {
		const minTop = 40 + box_to_follow.scrollTop;
		document.querySelectorAll('.not_read:not(.keep_unread)').forEach(function (div) {
			if (div.offsetHeight > 0 &&
					div.offsetParent.offsetTop + div.offsetTop + div.offsetHeight < minTop) {
				mark_read(div, true, true);
			}
		});
	}
	if (context.auto_load_more) {
		const pagination = document.getElementById('mark-read-pagination');
		if (pagination && box_to_follow.offsetHeight > 0 &&
			box_to_follow.scrollTop + box_to_follow.offsetHeight + (window.innerHeight / 2) >= pagination.offsetTop) {
			load_more_posts();
		}
	}
}

function init_posts() {
	if (context.auto_load_more || context.auto_mark_scroll || context.auto_remove_article) {
		box_to_follow = context.current_view === 'global' ? document.getElementById('panel') : document.scrollingElement;
		let lastScroll = 0;	// Throttle
		let timerId = 0;
		(box_to_follow === document.scrollingElement ? window : box_to_follow).onscroll = function () {
			clearTimeout(timerId);
			if (lastScroll + 500 < Date.now()) {
				lastScroll = Date.now();
				onScroll();
			} else {
				timerId = setTimeout(onScroll, 500);
			}
		};
		onScroll();
	}
}

function rememberOpenCategory(category_id, isOpen) {
	if (context.display_categories === 'remember') {
		const open_categories = JSON.parse(localStorage.getItem('FreshRSS_open_categories') || '{}');
		if (isOpen) {
			open_categories[category_id] = true;
		} else {
			delete open_categories[category_id];
		}
		localStorage.setItem('FreshRSS_open_categories', JSON.stringify(open_categories));
	}
}

function openCategory(category_id) {
	const category_element = document.getElementById(category_id);
	category_element.querySelector('.tree-folder-items').classList.add('active');
	const img = category_element.querySelector('a.dropdown-toggle img');
	img.src = img.src.replace('/icons/down.', '/icons/up.');
	img.alt = '△';
}

function init_column_categories() {
	if (context.current_view !== 'normal' && context.current_view !== 'reader') {
		return;
	}

	// Restore sidebar scroll position
	document.getElementById('sidebar').scrollTop = +sessionStorage.getItem('FreshRSS_sidebar_scrollTop');

	// Restore open categories
	if (context.display_categories === 'remember') {
		const open_categories = JSON.parse(localStorage.getItem('FreshRSS_open_categories') || '{}');
		Object.keys(open_categories).forEach(function (category_id) {
			openCategory(category_id);
		});
	}

	document.getElementById('aside_feed').onclick = function (ev) {
		let a = ev.target.closest('.tree-folder > .tree-folder-title > a.dropdown-toggle');
		if (a) {
			const img = a.querySelector('img');
			const category_id = a.closest('.category').id;
			if (img.alt === '▽') {
				img.src = img.src.replace('/icons/down.', '/icons/up.');
				img.alt = '△';
				rememberOpenCategory(category_id, true);
			} else {
				img.src = img.src.replace('/icons/up.', '/icons/down.');
				img.alt = '▽';
				rememberOpenCategory(category_id, false);
			}

			const ul = a.closest('li').querySelector('.tree-folder-items');
			let nbVisibleItems = 0;
			for (let i = ul.children.length - 1; i >= 0; i--) {
				if (ul.children[i].offsetHeight) {
					nbVisibleItems++;
				}
			}
			ul.classList.toggle('active');
			// CSS transition does not work on max-height:auto
			ul.style.maxHeight = ul.classList.contains('active') ? (nbVisibleItems * 4) + 'em' : 0;
			return false;
		}

		a = ev.target.closest('.tree-folder-items > .feed .dropdown-toggle');
		if (a) {
			const itemId = a.closest('.item').id;
			const templateId = itemId.substring(0, 2) === 't_' ? 'tag_config_template' : 'feed_config_template';
			const id = itemId.substr(2);
			const feed_web = a.getAttribute('data-fweb');
			const div = a.parentElement;
			const dropdownMenu = div.querySelector('.dropdown-menu');
			const template = document.getElementById(templateId)
				.innerHTML.replace(/------/g, id).replace('http://example.net/', feed_web);
			if (!dropdownMenu) {
				a.href = '#dropdown-' + id;
				div.querySelector('.dropdown-target').id = 'dropdown-' + id;
				div.insertAdjacentHTML('beforeend', template);
				const b = div.querySelector('button.confirm');
				if (b) {
					b.disabled = false;
				}
			} else if (getComputedStyle(dropdownMenu).display === 'none') {
				const id2 = div.closest('.item').id.substr(2);
				a.href = '#dropdown-' + id2;
			} else {
				a.href = '#close';
			}
			return true;
		}

		return true;
	};
}

function init_shortcuts() {
	Object.keys(context.shortcuts).forEach(function (k) {
		context.shortcuts[k] = (context.shortcuts[k] || '').toUpperCase();
	});

	document.addEventListener('keydown', ev => {
		if (ev.target.closest('input, textarea') ||
				ev.ctrlKey || ev.metaKey || (ev.altKey && ev.shiftKey)) {
			return;
		}

		const s = context.shortcuts;
		let k = (ev.key.trim() || ev.code || 'Space').toUpperCase();

		// IE11
		if (k === 'SPACEBAR') k = 'SPACE';
		else if (k === 'DEL') k = 'DELETE';
		else if (k === 'ESC') k = 'ESCAPE';

		if (location.hash.match(/^#dropdown-/)) {
			const n = parseInt(k);
			if (n) {
				if (location.hash === '#dropdown-query') {
					user_filter(n);
				} else {
					auto_share(n);
				}
				ev.preventDefault();
				return;
			}
		}
		if (k === s.actualize) {
			const btn = document.getElementById('actualize');
			if (btn) {
				btn.click();
			}
			ev.preventDefault();
			return;
		}
		if (k === s.next_entry) {
			if (ev.altKey) {
				next_category();
			} else if (ev.shiftKey) {
				next_feed();
			} else {
				next_entry(false);
			}
			ev.preventDefault();
			return;
		}
		if (k === s.next_unread_entry) {
			if (ev.altKey) {
				next_unread_category();
			} else if (ev.shiftKey) {
				next_feed();
			} else {
				next_unread_entry(false);
			}
			ev.preventDefault();
			return;
		}
		if (k === s.prev_entry) {
			if (ev.altKey) {
				prev_category();
			} else if (ev.shiftKey) {
				prev_feed();
			} else {
				prev_entry(false);
			}
			ev.preventDefault();
			return;
		}
		if (k === s.mark_read) {
			if (ev.altKey) {
				mark_previous_read(document.querySelector('.flux.current'));
			} else if (ev.shiftKey) {
				document.querySelector('.nav_menu .read_all').click();
			} else {	// Toggle the read state
				mark_read(document.querySelector('.flux.current'), false, false);
			}
			ev.preventDefault();
			return;
		}
		if (k === s.first_entry) {
			if (ev.altKey) {
				first_category();
			} else if (ev.shiftKey) {
				first_feed();
			} else {
				const old_active = document.querySelector('.flux.current');
				const first = document.querySelector('.flux');
				if (first.classList.contains('flux')) {
					toggleContent(first, old_active, false);
				}
			}
			ev.preventDefault();
			return;
		}
		if (k === s.last_entry) {
			if (ev.altKey) {
				last_category();
			} else if (ev.shiftKey) {
				last_feed();
			} else {
				const old_active = document.querySelector('.flux.current');
				const last = document.querySelector('.flux:last-of-type');
				if (last.classList.contains('flux')) {
					toggleContent(last, old_active, false);
				}
			}
			ev.preventDefault();
			return;
		}

		if (ev.altKey || ev.shiftKey) {
			return;
		}
		if (k === s.mark_favorite) {	// Toggle the favorite state
			mark_favorite(document.querySelector('.flux.current'));
			ev.preventDefault();
			return;
		}
		if (k === s.go_website) {
			if (context.auto_mark_site) {
				mark_read(document.querySelector('.flux.current'), true, false);
			}
			const newWindow = window.open();
			if (newWindow) {
				newWindow.opener = null;
				newWindow.location = document.querySelector('.flux.current a.go_website').href;
			}
			ev.preventDefault();
			return;
		}
		if (k === s.skip_next_entry) { next_entry(true); ev.preventDefault(); return; }
		if (k === s.skip_prev_entry) { prev_entry(true); ev.preventDefault(); return; }
		if (k === s.collapse_entry) { collapse_entry(); ev.preventDefault(); return; }
		if (k === s.auto_share) { auto_share(); ev.preventDefault(); return; }
		if (k === s.user_filter) { user_filter(); ev.preventDefault(); return; }
		if (k === s.load_more) { load_more_posts(); ev.preventDefault(); return; }
		if (k === s.close_dropdown) { location.hash = null; ev.preventDefault(); return; }
		if (k === s.help) { window.open(context.urls.help); ev.preventDefault(); return; }
		if (k === s.focus_search) { document.getElementById('search').focus(); ev.preventDefault(); return; }
		if (k === s.normal_view) { delayedClick(document.querySelector('#nav_menu_views .view-normal')); ev.preventDefault(); return; }
		if (k === s.reading_view) { delayedClick(document.querySelector('#nav_menu_views .view-reader')); ev.preventDefault(); return; }
		if (k === s.global_view) { delayedClick(document.querySelector('#nav_menu_views .view-global')); ev.preventDefault(); return; }
		if (k === s.rss_view) { delayedClick(document.querySelector('#nav_menu_views .view-rss')); ev.preventDefault(); return; }
		if (k === s.toggle_media) { toggle_media(); ev.preventDefault(); }
	});
}

function init_stream(stream) {
	stream.onclick = function (ev) {
		let el = ev.target.closest('.flux a.read');
		if (el) {
			mark_read(el.closest('.flux'), false, false);
			return false;
		}

		el = ev.target.closest('.flux a.bookmark');
		if (el) {
			mark_favorite(el.closest('.flux'));
			return false;
		}

		el = ev.target.closest('.dynamictags');
		if (el) {
			loadDynamicTags(el);
			return true;
		}

		el = ev.target.closest('.item.title > a');
		if (el) {	// Allow default control-click behaviour such as open in backround-tab
			return ev.ctrlKey;
		}

		el = ev.target.closest('.flux .content a');
		if (el) {
			if (!el.closest('div').classList.contains('author')) {
				el.target = '_blank';
				el.rel = 'noreferrer';
			}
			return true;
		}

		el = ev.target.closest('.item.share > a[data-type="print"]');
		if (el) {	// Print
			const tmp_window = window.open();
			for (let i = 0; i < document.styleSheets.length; i++) {
				tmp_window.document.writeln('<link href="' + document.styleSheets[i].href + '" rel="stylesheet" type="text/css" />');
			}
			tmp_window.document.writeln(el.closest('.flux_content').querySelector('.content').innerHTML);
			tmp_window.document.close();
			tmp_window.focus();
			tmp_window.print();
			tmp_window.close();
			return false;
		}

		el = ev.target.closest('.item.share > a[data-type="clipboard"]');
		if (el && navigator.clipboard) {	// Clipboard
			navigator.clipboard.writeText(el.href);
			return false;
		}

		el = ev.target.closest('.item.share > a[href="POST"]');
		if (el) {	// Share by POST
			const f = el.parentElement.querySelector('form');
			f.disabled = false;
			f.submit();
			return false;
		}

		el = ev.target.closest('.flux_header, .flux_content');
		if (el) {	// flux_toggle
			if (ev.target.closest('.content, .item.website, .item.link, .dropdown-menu')) {
				return true;
			}
			if (!context.sides_close_article && ev.target.matches('div.flux_content')) {
				// setting for not-closing after clicking outside article area
				return false;
			}
			const old_active = document.querySelector('.flux.current');
			const new_active = el.parentNode;
			if (ev.target.tagName.toUpperCase() === 'A') {	// Leave real links alone
				if (context.auto_mark_article) {
					mark_read(new_active, true, false);
				}
				return true;
			}
			toggleContent(new_active, old_active, false);
			return false;
		}
	};

	stream.onmouseup = function (ev) {	// Mouseup enables us to catch middle click, and control+click in IE/Edge
		if (ev.altKey || ev.metaKey || ev.shiftKey) {
			return;
		}

		let el = ev.target.closest('.item.title > a');
		if (el) {
			if (ev.which == 1) {
				if (ev.ctrlKey) {	// Control+click
					if (context.auto_mark_site) {
						mark_read(el.closest('.flux'), true, false);
					}
				} else {
					el.parentElement.click();	// Normal click, just toggle article.
				}
			} else if (ev.which == 2 && !ev.ctrlKey) {	// Simple middle click: same behaviour as CTRL+click
				if (context.auto_mark_article) {
					const new_active = el.closest('.flux');
					mark_read(new_active, true, false);
				}
			}
			return;
		}

		if (context.auto_mark_site) {
			// catch mouseup instead of click so we can have the correct behaviour
			// with middle button click (scroll button).
			el = ev.target.closest('.flux .link > a');
			if (el) {
				if (ev.which == 3) {
					return;
				}
				mark_read(el.closest('.flux'), true, false);
			}
		}
	};

	stream.onchange = function (ev) {
		const checkboxTag = ev.target.closest('.checkboxTag');
		if (checkboxTag) {	// Dynamic tags
			ev.stopPropagation();
			const isChecked = checkboxTag.checked;
			const tagId = checkboxTag.name.replace(/^t_/, '');
			const tagName = checkboxTag.nextElementSibling ? checkboxTag.nextElementSibling.value : '';
			const entry = checkboxTag.closest('div.flux');
			const entryId = entry.id.replace(/^flux_/, '');
			checkboxTag.disabled = true;

			const req = new XMLHttpRequest();
			req.open('POST', './?c=tag&a=tagEntry', true);
			req.responseType = 'json';
			req.onerror = function (e) {
				checkboxTag.checked = !isChecked;
				badAjax(this.status == 403);
			};
			req.onload = function (e) {
				if (this.status != 200) {
					return req.onerror(e);
				}
				if (entry.classList.contains('not_read')) {
					incUnreadsTag('t_' + tagId, isChecked ? 1 : -1);
				}
			};
			req.onloadend = function (e) {
				checkboxTag.disabled = false;
				if (tagId == 0) {
					loadDynamicTags(checkboxTag.closest('div.dropdown'));
				}
			};
			req.setRequestHeader('Content-Type', 'application/json');
			req.send(JSON.stringify({
				_csrf: context.csrf,
				id_tag: tagId,
				name_tag: tagId == 0 ? tagName : '',
				id_entry: entryId,
				checked: isChecked,
			}));
		}
	};
}

function init_nav_entries() {
	const nav_entries = document.getElementById('nav_entries');
	if (nav_entries) {
		nav_entries.querySelector('.previous_entry').onclick = function (e) {
			prev_entry(false);
			return false;
		};
		nav_entries.querySelector('.next_entry').onclick = function (e) {
			next_entry(false);
			return false;
		};
		nav_entries.querySelector('.up').onclick = function (e) {
			const active_item = (document.querySelector('.flux.current') || document.querySelector('.flux'));
			const windowTop = document.scrollingElement.scrollTop;
			const item_top = active_item.offsetParent.offsetTop + active_item.offsetTop;

			document.scrollingElement.scrollTop = windowTop > item_top ? item_top : 0;
			return false;
		};
	}
}

function loadDynamicTags(div) {
	div.classList.remove('dynamictags');
	div.querySelectorAll('li.item').forEach(function (li) { li.remove(); });
	const entryId = div.closest('div.flux').id.replace(/^flux_/, '');

	const req = new XMLHttpRequest();
	req.open('GET', './?c=tag&a=getTagsForEntry&id_entry=' + entryId, true);
	req.responseType = 'json';
	req.onerror = function (e) {
		div.querySelectorAll('li.item').forEach(function (li) { li.remove(); });
		div.classList.add('dynamictags');
	};
	req.onload = function (e) {
		if (this.status != 200) {
			return req.onerror(e);
		}
		const json = xmlHttpRequestJson(this);
		if (!json) {
			return req.onerror(e);
		}
		let html = '<li class="item"><label><input class="checkboxTag" name="t_0" type="checkbox" /> <input type="text" name="newTag" /></label></li>';
		if (json && json.length) {
			for (let i = 0; i < json.length; i++) {
				const tag = json[i];
				html += '<li class="item"><label><input class="checkboxTag" name="t_' + tag.id + '" type="checkbox"' +
						(tag.checked ? ' checked="checked"' : '') + '> ' + tag.name + '</label></li>';
			}
		}
		div.querySelector('.dropdown-menu').insertAdjacentHTML('beforeend', html);
	};
	req.send();
}

// <actualize>
let feed_processed = 0;

function updateFeed(feeds, feeds_count) {
	const feed = feeds.pop();
	if (!feed) {
		return;
	}
	const req = new XMLHttpRequest();
	req.open('POST', feed.url, true);
	req.onloadend = function (e) {
		if (this.status != 200) {
			return badAjax(false);
		}
		feed_processed++;
		const div = document.getElementById('actualizeProgress');
		div.querySelector('.progress').innerHTML = feed_processed + ' / ' + feeds_count;
		div.querySelector('.title').innerHTML = feed.title;
		if (feed_processed === feeds_count) {
			// Empty request to commit new articles
			const req2 = new XMLHttpRequest();
			req2.open('POST', './?c=feed&a=actualize&id=-1&ajax=1', true);
			req2.onloadend = function (e) {
				delayedFunction(function () { location.reload(); });
			};
			req2.setRequestHeader('Content-Type', 'application/json');
			req2.send(JSON.stringify({
				_csrf: context.csrf,
				noCommit: 0,
			}));
		} else {
			updateFeed(feeds, feeds_count);
		}
	};
	req.setRequestHeader('Content-Type', 'application/json');
	req.send(JSON.stringify({
		_csrf: context.csrf,
		noCommit: 1,
	}));
}

function init_actualize() {
	let auto = false;

	const actualize = document.getElementById('actualize');
	if (!actualize) {
		return;
	}

	actualize.onclick = function () {
		if (context.ajax_loading) {
			return false;
		}
		context.ajax_loading = true;

		const req = new XMLHttpRequest();
		req.open('POST', './?c=javascript&a=actualize', true);
		req.responseType = 'json';
		req.onload = function (e) {
			if (this.status != 200) {
				return badAjax(false);
			}
			const json = xmlHttpRequestJson(this);
			if (!json) {
				return badAjax(false);
			}
			if (auto && json.feeds.length < 1) {
				auto = false;
				context.ajax_loading = false;
				return false;
			}
			if (json.feeds.length === 0) {
				openNotification(json.feedback_no_refresh, 'good');
				// Empty request to commit new articles
				const req2 = new XMLHttpRequest();
				req2.open('POST', './?c=feed&a=actualize&id=-1&ajax=1', true);
				req2.onloadend = function (e) {
					context.ajax_loading = false;
				};
				req2.setRequestHeader('Content-Type', 'application/json');
				req2.send(JSON.stringify({
					_csrf: context.csrf,
					noCommit: 0,
				}));
				return;
			}
			// Progress bar
			const feeds_count = json.feeds.length;
			document.body.insertAdjacentHTML('beforeend', '<div id="actualizeProgress" class="notification good">' +
					json.feedback_actualize + '<br /><span class="title">/</span><br /><span class="progress">0 / ' +
					feeds_count + '</span></div>');
			for (let i = 10; i > 0; i--) {
				updateFeed(json.feeds, feeds_count);
			}
		};
		req.setRequestHeader('Content-Type', 'application/json');
		req.send(JSON.stringify({
			_csrf: context.csrf,
		}));

		return false;
	};

	if (context.auto_actualize_feeds) {
		auto = true;
		actualize.click();
	}
}
// </actualize>

// <notification>
let notification = null;
let notification_interval = null;
let notification_working = false;

function openNotification(msg, status) {
	if (notification_working === true) {
		return false;
	}
	notification_working = true;
	notification.querySelector('.msg').innerHTML = msg;
	notification.className = 'notification';
	notification.classList.add(status);
	if (status = 'good') {
		notification_interval = setTimeout(closeNotification, 4000);
	} else {
		// no status or f.e. status = 'bad', give some more time to read
		notification_interval = setTimeout(closeNotification, 8000);
	}
}

function closeNotification() {
	notification.classList.add('closed');
	clearInterval(notification_interval);
	notification_working = false;
}

function init_notifications() {
	notification = document.getElementById('notification');

	notification.querySelector('a.close').addEventListener('click',function (ev) {
		closeNotification();
		ev.preventDefault();
		return false;
	});

	notification.addEventListener('mouseenter',function(){
		clearInterval(notification_interval);
	});

	notification.addEventListener('mouseleave',function(){
		notification_interval = setTimeout(closeNotification, 1000);
	});

	if (notification.querySelector('.msg').innerHTML.length > 0) {
		notification_working = true;
		if (notification.classList.contains('good')) {
			notification_interval = setTimeout(closeNotification, 4000);
		} else {
			// no status or f.e. status = 'bad', give some more time to read
			notification_interval = setTimeout(closeNotification, 8000);
		}
	}
}
// </notification>

// <popup>
let popup = null;
let popup_iframe_container = null;
let popup_iframe = null;
let popup_txt = null;
let popup_working = false;

/* eslint-disable no-unused-vars */
// TODO: Re-enable no-unused-vars
function openPopupWithMessage(msg) {
	if (popup_working === true) {
		return false;
	}

	popup_working = true;

	popup_txt.innerHTML = msg;

	popup_txt.style.display = 'table-row';
	popup.style.display = 'block';
}

function openPopupWithSource(source) {
	if (popup_working === true) {
		return false;
	}

	popup_working = true;

	popup_iframe.src = source;

	popup_iframe_container.style.display = 'table-row';
	popup.style.display = 'block';
}
/* eslint-enable no-unused-vars */

function closePopup() {
	popup.style.display = 'none';
	popup_iframe_container.style.display = 'none';
	popup_txt.style.display = 'none';

	popup_iframe.src = 'about:blank';

	popup_working = false;
}

function init_popup() {
	// Fetch elements.
	popup = document.getElementById('popup');
	if (popup) {
		popup_iframe_container = document.getElementById('popup-iframe-container');
		popup_iframe = document.getElementById('popup-iframe');

		popup_txt = document.getElementById('popup-txt');

		// Configure close button.
		document.getElementById('popup-close').addEventListener('click', function (ev) {
			closePopup();
		});

		// Configure close-on-click.
		window.addEventListener('click', function (ev) {
			if (ev.target == popup) {
				closePopup();
			}
		});
	}
}
// </popup>

// <notifs html5>
let notifs_html5_permission = 'denied';

function notifs_html5_is_supported() {
	return window.Notification !== undefined;
}

function notifs_html5_ask_permission() {
	window.Notification.requestPermission(function () {
		notifs_html5_permission = window.Notification.permission;
	});
}

function notifs_html5_show(nb) {
	if (notifs_html5_permission !== 'granted') {
		return;
	}

	const notification = new window.Notification(context.i18n.notif_title_articles, {
		icon: '../themes/icons/favicon-256-padding.png',
		body: context.i18n.notif_body_articles.replace('%d', nb),
		tag: 'freshRssNewArticles',
	});

	notification.onclick = function () {
		delayedFunction(function () {
			location.reload();
			window.focus();
			notification.close();
		});
	};

	if (context.html5_notif_timeout !== 0) {
		setTimeout(function () {
			notification.close();
		}, context.html5_notif_timeout * 1000);
	}
}

function init_notifs_html5() {
	if (!notifs_html5_is_supported()) {
		return;
	}

	notifs_html5_permission = notifs_html5_ask_permission();
}
// </notifs html5>

function refreshUnreads() {
	const req = new XMLHttpRequest();
	req.open('GET', './?c=javascript&a=nbUnreadsPerFeed', true);
	req.responseType = 'json';
	req.onload = function (e) {
		const json = xmlHttpRequestJson(this);
		if (!json) {
			return badAjax(false);
		}
		const isAll = document.querySelector('.category.all.active');
		let new_articles = false;

		Object.keys(json.feeds).forEach(function (feed_id) {
			const nbUnreads = json.feeds[feed_id];
			feed_id = 'f_' + feed_id;
			const elem = document.getElementById(feed_id);
			const feed_unreads = elem ? str2int(elem.getAttribute('data-unread')) : 0;

			if ((incUnreadsFeed(null, feed_id, nbUnreads - feed_unreads) || isAll) &&	// Update of current view?
					(nbUnreads - feed_unreads > 0)) {
				const newArticle = document.getElementById('new-article');
				newArticle.setAttribute('aria-hidden', 'false');
				newArticle.style.display = 'block';
				new_articles = true;
			}
		});

		let nbUnreadTags = 0;

		Object.keys(json.tags).forEach(function (tag_id) {
			const nbUnreads = json.tags[tag_id];
			nbUnreadTags += nbUnreads;
			const tag = document.getElementById('t_' + tag_id);
			if (tag) {
				tag.setAttribute('data-unread', nbUnreads);
				tag.querySelector('.item-title').setAttribute('data-unread', numberFormat(nbUnreads));
			}
		});

		const tags = document.querySelector('.category.tags');
		if (tags) {
			tags.setAttribute('data-unread', nbUnreadTags);
			tags.querySelector('.title').setAttribute('data-unread', numberFormat(nbUnreadTags));
		}

		const title = document.querySelector('.category.all .title');
		const nb_unreads = title ? str2int(title.getAttribute('data-unread')) : 0;

		if (nb_unreads > 0 && new_articles) {
			faviconNbUnread(nb_unreads);
			notifs_html5_show(nb_unreads);
		}
	};
	req.send();
}

// <endless_mode>
let url_load_more = '';
let load_more = false;
let box_load_more = null;

function load_more_posts() {
	if (load_more || !url_load_more || !box_load_more) {
		return;
	}
	load_more = true;
	document.getElementById('load_more').classList.add('loading');

	const req = new XMLHttpRequest();
	req.open('GET', url_load_more, true);
	req.responseType = 'document';
	req.onload = function (e) {
		const html = this.response;
		const formPagination = document.getElementById('mark-read-pagination');

		const streamAdopted = document.adoptNode(html.getElementById('stream'));
		streamAdopted.querySelectorAll('.flux, .day').forEach(function (div) {
			box_load_more.insertBefore(div, formPagination);
		});

		const paginationOld = formPagination.querySelector('.pagination');
		const paginationNew = streamAdopted.querySelector('.pagination');
		formPagination.replaceChild(paginationNew, paginationOld);

		const bigMarkAsRead = document.getElementById('bigMarkAsRead');
		const readAll = document.querySelector('#nav_menu_read_all .read_all');
		if (readAll && bigMarkAsRead && bigMarkAsRead.formAction) {
			if (context.display_order === 'ASC') {
				readAll.formAction = bigMarkAsRead.formAction;
			} else {
				bigMarkAsRead.formAction = readAll.formAction;
			}
		}

		document.querySelectorAll('[id^=day_]').forEach(function (div) {
			const ids = document.querySelectorAll('[id="' + div.id + '"]');
			for (let i = ids.length - 1; i > 0; i--) {	// Keep only the first
				ids[i].remove();
			}
		});

		init_load_more(box_load_more);

		const div_load_more = document.getElementById('load_more');
		if (bigMarkAsRead) {
			bigMarkAsRead.removeAttribute('disabled');
		}
		if (div_load_more) {
			div_load_more.classList.remove('loading');
		}

		load_more = false;
	};
	req.send();
}

const freshrssLoadMoreEvent = document.createEvent('Event');
freshrssLoadMoreEvent.initEvent('freshrss:load-more', true, true);

function init_load_more(box) {
	box_load_more = box;
	document.body.dispatchEvent(freshrssLoadMoreEvent);

	const next_link = document.getElementById('load_more');
	if (!next_link) {
		// no more article to load
		url_load_more = '';
		return;
	}

	url_load_more = next_link.href;

	next_link.onclick = function (e) {
		load_more_posts();
		return false;
	};
}
// </endless_mode>

function init_confirm_action() {
	document.body.onclick = function (ev) {
		const b = ev.target.closest('.confirm');
		if (b) {
			let str_confirmation = this.getAttribute('data-str-confirm');
			if (!str_confirmation) {
				str_confirmation = context.i18n.confirmation_default;
			}
			return confirm(str_confirmation);
		}
	};
	document.querySelectorAll('button.confirm').forEach(function (b) { b.disabled = false; });
}

function faviconNbUnread(n) {
	if (typeof n === 'undefined') {
		const t = document.querySelector('.category.all .title');
		n = t ? str2int(t.getAttribute('data-unread')) : 0;
	}
	// http://remysharp.com/2010/08/24/dynamic-favicons/
	const canvas = document.createElement('canvas');
	const link = document.getElementById('favicon').cloneNode(true);
	const ratio = window.devicePixelRatio;
	if (canvas.getContext && link) {
		canvas.height = canvas.width = 16 * ratio;
		const img = document.createElement('img');
		img.onload = function () {
			const ctx = canvas.getContext('2d');
			ctx.drawImage(this, 0, 0, canvas.width, canvas.height);
			if (n > 0) {
				let text = '';
				if (n < 1000) {
					text = n;
				} else if (n < 100000) {
					text = Math.floor(n / 1000) + 'k';
				} else {
					text = 'E' + Math.floor(Math.log10(n));
				}
				ctx.font = 'bold ' + 9 * ratio + 'px "Arial", sans-serif';
				ctx.fillStyle = 'rgba(255, 255, 255, 0.8)';
				ctx.fillRect(0, 7 * ratio, ctx.measureText(text).width, 9 * ratio);
				ctx.fillStyle = '#F00';
				ctx.fillText(text, 0, canvas.height - 1);
			}
			link.href = canvas.toDataURL('image/png');
			document.querySelector('link[rel~=icon]').remove();
			document.head.appendChild(link);
		};
		img.src = '../favicon.ico';
	}
}

function removeFirstLoadSpinner() {
	const first_load = document.getElementById('first_load');
	if (first_load) {
		first_load.remove();
	}
}

function init_normal() {
	const stream = document.getElementById('stream');
	if (!stream) {
		if (window.console) {
			console.log('FreshRSS waiting for content…');
		}
		setTimeout(init_normal, 100);
		return;
	}
	init_column_categories();
	init_stream(stream);
	init_shortcuts();
	init_actualize();
	faviconNbUnread();

	window.onbeforeunload = function (e) {
		const sidebar = document.getElementById('sidebar');
		if (sidebar) {	// Save sidebar scroll position
			sessionStorage.setItem('FreshRSS_sidebar_scrollTop', sidebar.scrollTop);
		}
		if (mark_read_queue && mark_read_queue.length > 0) {
			return false;
		}
	};
}

function init_beforeDOM() {
	document.scrollingElement.scrollTop = 0;
	if (['normal', 'reader', 'global'].indexOf(context.current_view) >= 0) {
		init_normal();
	}
}

function init_afterDOM() {
	removeFirstLoadSpinner();
	init_notifications();
	init_popup();
	init_confirm_action();
	const stream = document.getElementById('stream');
	if (stream) {
		init_load_more(stream);
		init_posts();
		init_nav_entries();
		init_notifs_html5();
		setTimeout(faviconNbUnread, 1000);
		setInterval(refreshUnreads, 120000);
	}

	if (window.console) {
		console.log('FreshRSS main init done.');
	}
}

init_beforeDOM();	// Can be called before DOM is fully loaded

if (document.readyState && document.readyState !== 'loading') {
	init_afterDOM();
} else {
	if (window.console) {
		console.log('FreshRSS waiting for DOMContentLoaded…');
	}
	document.addEventListener('DOMContentLoaded', init_afterDOM, false);
}
// @license-end
