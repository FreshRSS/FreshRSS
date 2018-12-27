"use strict";
/* globals $, jQuery, shortcut */
/* jshint esversion:6, strict:global */

//<Polyfills>
if (!NodeList.prototype.forEach) NodeList.prototype.forEach = Array.prototype.forEach;
if (!Element.prototype.matches) Element.prototype.matches = Element.prototype.msMatchesSelector || Element.prototype.mozMatchesSelector || Element.prototype.webkitMatchesSelector;
if (!Element.prototype.closest) Element.prototype.closest = function (s) {
		let el = this;
		do {
			if (el.matches(s)) return el;
			el = el.parentElement;
		} while (el);
		return null;
	};
if (!Element.prototype.remove) Element.prototype.remove = function () { if (this.parentNode) this.parentNode.removeChild(this); };
//</Polyfills>

//<Global variables>
var context, i18n, icons, shortcuts, urls;

(function parseJsonVars() {
	const jsonVars = document.getElementById('jsonVars'),
		json = JSON.parse(jsonVars.innerHTML);
	jsonVars.outerHTML = '';
	context = json.context;
	i18n = json.i18n;
	shortcuts = json.shortcuts;
	urls = json.urls;
	icons = json.icons;
	icons.read = decodeURIComponent(icons.read);
	icons.unread = decodeURIComponent(icons.unread);
}());

var $stream = null,
	ajax_loading = false,
	$nav_entries = null;
//</Global variables>

function redirect(url, new_tab) {
	if (url) {
		if (new_tab) {
			window.open(url);
		} else {
			location.href = url;
		}
	}
}

function needsScroll(elem) {
	const winBottom = document.documentElement.scrollTop + document.documentElement.clientHeight,
		elemBottom = elem.offsetTop + elem.offsetHeight;
	return (elem.offsetTop < document.documentElement.scrollTop || elemBottom > winBottom) ?
		elem.offsetTop - (document.documentElement.clientHeight / 2) : 0;
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
	const x = nStr.split('.'),
		x2 = x.length > 1 ? '.' + x[1] : '',
		rgx = /(\d+)(\d{3})/;
	let x1 = x[0];
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ' ' + '$2');
	}
	return x1 + x2;
}

function incLabel(p, inc, spaceAfter) {
	const i = str2int(p) + inc;
	return i > 0 ? ((spaceAfter ? '' : ' ') + '(' + numberFormat(i) + ')' + (spaceAfter ? ' ' : '')) : '';
}

function incUnreadsFeed(article, feed_id, nb) {
	//Update unread: feed
	let elem = document.getElementById(feed_id),
		feed_unreads = elem ? str2int(elem.getAttribute('data-unread')) : 0,
		feed_priority = elem ? str2int(elem.getAttribute('data-priority')) : 0;
	if (elem) {
		elem.setAttribute('data-unread', feed_unreads + nb);
		elem = elem.querySelector('.item-title');
		if (elem) {
			elem.setAttribute('data-unread', numberFormat(feed_unreads + nb));
		}
	}

	//Update unread: category
	elem = document.getElementById(feed_id).closest('.category');
	feed_unreads = elem ? str2int(elem.getAttribute('data-unread')) : 0;
	if (elem) {
		elem.setAttribute('data-unread', feed_unreads + nb);
		elem = elem.querySelector('.title');
		if (elem) {
			elem.setAttribute('data-unread', numberFormat(feed_unreads + nb));
		}
	}

	//Update unread: all
	if (feed_priority > 0) {
		elem = document.querySelector('#aside_feed .all .title');
		if (elem) {
			feed_unreads = elem ? str2int(elem.getAttribute('data-unread')) : 0;
			elem.setAttribute('data-unread', numberFormat(feed_unreads + nb));
		}
	}

	//Update unread: favourites
	if (article && article.closest('div').classList.contains('favorite')) {
		elem = document.querySelector('#aside_feed .favorites .title');
		if (elem) {
			feed_unreads = elem ? str2int(elem.getAttribute('data-unread')) : 0;
			elem.setAttribute('data-unread', numberFormat(feed_unreads + nb));
		}
	}

	let isCurrentView = false;
	// Update unread: title
	document.title = document.title.replace(/^((?:\([ 0-9]+\) )?)/, function (m, p1) {
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
		let unreads = str2int(t.getAttribute('data-unread'));
		t.setAttribute('data-unread', unreads + nb);
		t.querySelector('.item-title').setAttribute('data-unread', numberFormat(unreads + nb));
	}
	t = document.querySelector('.category.tags .title');
	if (t) {
		let unreads = str2int(t.getAttribute('data-unread'));
		t.setAttribute('data-unread', numberFormat(unreads + nb));
	}
}

var pending_entries = {},
	mark_read_queue = [];

function send_mark_read_queue(queue, asRead) {
	$.ajax({
		type: 'POST',
		url: '.?c=entry&a=read' + (asRead ? '' : '&is_read=0'),
		data: {
			ajax: true,
			_csrf: context.csrf,
			'id[]': queue,
		},
	}).done(function (data) {
		for (let i = queue.length - 1; i >= 0; i--) {
			const div = document.getElementById('flux_' + queue[i]),
				myIcons = icons;
			let inc = 0;
			if (div.classList.contains('not_read')) {
				div.classList.remove('not_read');
				div.querySelectorAll('a.read').forEach(function (a) { a.setAttribute('href', a.getAttribute('href').replace('&is_read=0', '') + '&is_read=1'); });
				div.querySelectorAll('a.read > .icon').forEach(function (img) { img.outerHTML = myIcons.read; });
				inc--;
			} else {
				div.classList.add('not_read', 'keep_unread');
				div.querySelectorAll('a.read').forEach(function (a) { a.setAttribute('href', a.getAttribute('href').replace('&is_read=1', '')); });
				div.querySelectorAll('a.read > .icon').forEach(function (img) { img.outerHTML = myIcons.unread; });
				inc++;
			}
			let feed_link = div.querySelector('.website > a');
			if (feed_link) {
				let feed_url = feed_link.getAttribute('href');
				let feed_id = feed_url.substr(feed_url.lastIndexOf('f_'));
				incUnreadsFeed(div, feed_id, inc);
			}
			delete pending_entries['flux_' + queue[i]];
		}
		faviconNbUnread();
		if (data.tags) {
			let tagIds = Object.keys(data.tags);
			for (let i = tagIds.length - 1; i >= 0; i--) {
				let tagId = tagIds[i];
				incUnreadsTag(tagId, (asRead ? -1 : 1) * data.tags[tagId].length);
			}
		}
		onScroll();
	}).fail(function (data) {
		openNotification(i18n.notif_request_failed, 'bad');
		for (let i = queue.length - 1; i >= 0; i--) {
			delete pending_entries['flux_' + queue[i]];
		}
	});
}

var send_mark_read_queue_timeout = 0;

function mark_read(div, only_not_read) {
	if (!div || !div.id || context.anonymous ||
		(only_not_read && !div.classList.contains('not_read'))) {
		return false;
	}
	if (pending_entries[div.id]) {
		return false;
	}
	pending_entries[div.id] = true;

	const asRead = div.classList.contains('not_read'),
		entryId = div.id.replace(/^flux_/, '');
	if (asRead) {
		mark_read_queue.push(entryId);
		if (send_mark_read_queue_timeout == 0) {
			send_mark_read_queue_timeout = setTimeout(function () {
					send_mark_read_queue_timeout = 0;
					const queue = mark_read_queue.slice(0);
					mark_read_queue = [];
					send_mark_read_queue(queue, asRead);
				}, 1000);
		}
	} else {
		const queue = [ entryId ];
		send_mark_read_queue(queue, asRead);
	}
}

function mark_favorite(div) {
	if (!div) {
		return false;
	}

	let a = div.querySelector('a.bookmark'),
		url = a ? a.getAttribute('href') : '';
	if (!url) {
		return false;
	}

	if (pending_entries[div.id]) {
		return false;
	}
	pending_entries[div.id] = true;

	$.ajax({
		type: 'POST',
		url: url,
		data: {
			ajax: true,
			_csrf: context.csrf,
		},
	}).done(function (data) {
		let inc = 0;
		if (div.classList.contains('favorite')) {
			div.classList.remove('favorite');
			inc--;
		} else {
			div.classList.add('favorite');
			inc++;
		}
		div.querySelectorAll('a.bookmark').forEach(function (a) { a.setAttribute('href', data.url); });
		div.querySelectorAll('a.bookmark > .icon').forEach(function (img) { img.outerHTML = data.icon; });

		const favourites = document.querySelector('#aside_feed .favorites .title');
		if (favourites) {
			favourites.textContent = favourites.textContent.replace(/((?: \([ 0-9]+\))?\s*)$/, function (m, p1) {
				return incLabel(p1, inc, false);
			});
		}

		if (div.classList.contains('not_read')) {
			const elem = document.querySelector('#aside_feed .favorites .title'),
				feed_unreads = elem ? str2int(elem.getAttribute('data-unread')) : 0;
			if (elem) {
				elem.setAttribute('data-unread', numberFormat(feed_unreads + inc));
			}
		}

		delete pending_entries[div.id];
	}).fail(function (data) {
		openNotification(i18n.notif_request_failed, 'bad');
		delete pending_entries[div.id];
	});
}

function toggleContent(new_active, old_active, skipping) {
	// If skipping, move current without activating or marking as read
	if (!new_active) {
		return;
	}

	if (context.does_lazyload && !skipping) {
		new_active.querySelectorAll('img[data-original], iframe[data-original]').forEach(function (elem) {
			elem.setAttribute('src', elem.getAttribute('data-original'));
			elem.removeAttribute('data-original');
		});
	}

	if (old_active !== new_active) {
		if (!skipping) {
			new_active.classList.add('active');
		}
		new_active.classList.add('current');
		if (old_active) {
			old_active.classList.remove('active');
			old_active.classList.remove('current');	//Split for IE11
		}
	} else { // collapse_entry calls toggleContent(flux_current, flux_current, false)
		new_active.classList.toggle('active');
	}

	const relative_move = context.current_view === 'global',
		box_to_move = relative_move ? document.getElementById('#panel') : document.documentElement;

	if (context.sticky_post) {
		let prev_article = new_active.previousElementSibling,
			new_pos = new_active.offsetTop + document.documentElement.scrollTop,
			old_scroll = box_to_move.scrollTop;

		if (prev_article && new_active.offsetTop - prev_article.offsetTop <= 150) {
			new_pos = prev_article.offsetTop;
			if (relative_move) {
				new_pos -= box_to_move.offsetTop;
			}
		}

		if (skipping) {
			// when skipping, this feels more natural if it's not so near the top
			new_pos -= document.body.clientHeight / 4;
		}
		if (relative_move) {
			new_pos += old_scroll;
		}
		box_to_move.scrollTop = new_pos;
	}

	if (context.auto_mark_article && new_active.classList.contains('active') && !skipping) {
		mark_read(new_active, true);
	}
	onScroll();
}

function prev_entry(skipping) {
	const old_active = document.querySelector('.flux.current'),
		new_active = old_active ? old_active.previousElementSibling : document.querySelector('.flux');
	toggleContent(new_active, old_active, skipping);
}

function next_entry(skipping) {
	const old_active = document.querySelector('.flux.current'),
		new_active = old_active ? old_active.nextElementSibling : document.querySelector('.flux');
	toggleContent(new_active, old_active, skipping);
}

function prev_feed() {
	const $active_feed = $('#aside_feed .tree-folder-items .item.active');
	if ($active_feed.length > 0) {
		$active_feed.prevAll(':visible:first').find('a').each(function () { this.click(); });
	} else {
		last_feed();
	}
}

function next_feed() {
	const $active_feed = $('#aside_feed .tree-folder-items .item.active');
	if ($active_feed.length > 0) {
		$active_feed.nextAll(':visible:first').find('a').each(function () { this.click(); });
	} else {
		first_feed();
	}
}

function first_feed() {
	const a = document.querySelector('#aside_feed .category.active .feed:not([data-unread="0"]) a.item-title');
	if (a) {
		a.click();
	}
}

function last_feed() {
	const links = document.querySelectorAll('#aside_feed .category.active .feed:not([data-unread="0"]) a.item-title');
	if (links && links.length > 0) {
		links[links.length - 1].click();
	}
}

function prev_category() {
	const $active_cat = $('#aside_feed .tree-folder.active');

	if ($active_cat.length > 0) {
		const $prev_cat = $active_cat.prevAll(':visible:first').find('.tree-folder-title .title');
		if ($prev_cat.length > 0) {
			$prev_cat[0].click();
		}
	} else {
		last_category();
	}
	return;
}

function next_category() {
	const $active_cat = $('#aside_feed .tree-folder.active');

	if ($active_cat.length > 0) {
		const $next_cat = $active_cat.nextAll(':visible:first').find('.tree-folder-title .title');
		if ($next_cat.length > 0) {
			$next_cat[0].click();
		}
	} else {
		first_category();
	}
	return;
}

function first_category() {
	const a = document.querySelector('#aside_feed .category:not([data-unread="0"]) a.title');
	if (a) {
		a.click();
	}
}

function last_category() {
	const links = document.querySelectorAll('#aside_feed .category:not([data-unread="0"]) a.title');
	if (links && links.length > 0) {
		links[links.length - 1].click();
	}
}

function collapse_entry() {
	const flux_current = document.querySelector('.flux.current');
	toggleContent(flux_current, flux_current, false);
}

function user_filter(key) {
	const $filter = $('#dropdown-query'),
		$filters = $filter.siblings('.dropdown-menu').find('.item.query a');
	if (typeof key === 'undefined') {
		if (!$filters.length) {
			return;
		}
		// Display the filter div
		location.hash = $filters.attr('id');
		// Force scrolling to the filter div
		const scroll = needsScroll(document.querySelector('.header'));
		if (scroll !== 0) {
			document.documentElement.scrollTop = scroll;
		}
		// Force the key value if there is only one action, so we can trigger it automatically
		if ($filters.length === 1) {
			key = 1;
		} else {
			return;
		}
	}
	// Trigger selected share action
	key = parseInt(key);
	if (key <= $filters.length) {
		$filters[key - 1].click();
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
			document.documentElement.scrollTop = scrollTop;
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

var box_to_follow;

function onScroll() {
	if (!box_to_follow) {
		return;
	}
	if (context.auto_mark_scroll) {
		const minTop = 40 + box_to_follow.scrollTop;
		document.querySelectorAll('.not_read:not(.keep_unread)').forEach(function (div) {
				if (div.offsetHeight > 0 &&
					div.offsetParent.offsetTop + div.offsetTop + div.offsetHeight < minTop) {
					mark_read(div, true);
				}
			});
	}
	if (context.auto_remove_article) {
		let maxTop = box_to_follow.scrollTop,
			scrollOffset = 0;
		document.querySelectorAll('.flux:not(.active):not(.keep_unread)').forEach(function (div) {
				if (!pending_entries[div.id] && div.offsetHeight > 0 &&
					div.offsetParent.offsetTop + div.offsetTop + div.offsetHeight < maxTop) {
					const p = div.previousElementSibling,
						n = div.nextElementSibling;
					if (p && p.classList.contains('day') && n && n.classList.contains('day')) {
						p.remove();
					}
					maxTop -= div.offsetHeight;
					scrollOffset -= div.offsetHeight;
					div.remove();
				}
			});
		if (scrollOffset != 0) {
			box_to_follow.scrollTop += scrollOffset;
			return;	//onscroll will be called again
		}
	}
	if (context.auto_load_more) {
		const load_more = document.getElementById('mark-read-pagination');
		if (load_more && box_to_follow.scrollTop > 0 &&
			box_to_follow.scrollTop + box_to_follow.offsetHeight >= load_more.offsetTop) {
			load_more_posts();
		}
	}
}

function init_posts() {
	if (context.auto_load_more || context.auto_mark_scroll || context.auto_remove_article) {
		box_to_follow = context.current_view === 'global' ? document.getElementById('panel') : document.documentElement;
		let lastScroll = 0,	//Throttle
			timerId = 0;
		(box_to_follow === document.documentElement ? window : box_to_follow).onscroll = function () {
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

function init_column_categories() {
	if (context.current_view !== 'normal' && context.current_view !== 'reader') {
		return;
	}

	$('#aside_feed').on('click', '.tree-folder>.tree-folder-title>a.dropdown-toggle', function () {
		$(this).children().each(function () {
			if (this.alt === '▽') {
				this.src = this.src.replace('/icons/down.', '/icons/up.');
				this.alt = '△';
			} else {
				this.src = this.src.replace('/icons/up.', '/icons/down.');
				this.alt = '▽';
			}
		});
		$(this).parent().next('.tree-folder-items').slideToggle(300, function () {
			//Workaround for Gecko bug in Firefox 64-65(+?):
			const sidebar = document.getElementById('sidebar');
			if (sidebar && sidebar.scrollHeight > sidebar.clientHeight &&	//if needs scrollbar
				sidebar.scrollWidth >= sidebar.offsetWidth) {	//but no scrollbar
				sidebar.style['overflow-y'] = 'scroll';	//then force scrollbar
				setTimeout(function () { sidebar.style['overflow-y'] = ''; }, 0);
			}
		});
		return false;
	});

	$('#aside_feed').on('click', '.tree-folder-items .feed .dropdown-toggle', function () {
		const itemId = $(this).closest('.item').attr('id'),
			templateId = itemId.substring(0, 2) === 't_' ? 'tag_config_template' : 'feed_config_template',
			id = itemId.substr(2),
			feed_web = $(this).data('fweb'),
			template = $('#' + templateId)
				.html().replace(/------/g, id).replace('http://example.net/', feed_web);
		if ($(this).next('.dropdown-menu').length === 0) {
			$(this).attr('href', '#dropdown-' + id).prev('.dropdown-target').attr('id', 'dropdown-' + id).parent()
				.append(template).find('button.confirm').removeAttr('disabled');
		} else {
			if ($(this).next('.dropdown-menu').css('display') === 'none') {
				const id2 = $(this).closest('.item').attr('id').substr(2);
				$(this).attr('href', '#dropdown-' + id2);
			} else {
				$(this).attr('href', '#close');
			}
		}
	});
}

function init_shortcuts() {
	if (!(window.shortcut)) {
		if (window.console) {
			console.log('FreshRSS waiting for shortcut.js…');
		}
		setTimeout(init_shortcuts, 200);
		return;
	}
	// Manipulation shortcuts
	shortcut.add(shortcuts.mark_read, function () {
		// Toggle the read state
		mark_read(document.querySelector('.flux.current'), false);
	}, {
		'disable_in_input': true
	});
	shortcut.add('shift+' + shortcuts.mark_read, function () {
		// Mark everything as read
		$('.nav_menu .read_all').click();
	}, {
		'disable_in_input': true
	});
	shortcut.add(shortcuts.mark_favorite, function () {
		// Toggle the favorite state
		mark_favorite(document.querySelector('.flux.current'));
	}, {
		'disable_in_input': true
	});
	shortcut.add(shortcuts.collapse_entry, function () {
		// Toggle the collapse state
		collapse_entry();
	}, {
		'disable_in_input': true
	});
	shortcut.add(shortcuts.auto_share, function () {
		// Display the share options
		auto_share();
	}, {
		'disable_in_input': true
	});

	shortcut.add(shortcuts.user_filter, function () {
		// Display the user filters
		user_filter();
	}, {
		'disable_in_input': true
	});

	function addShortcut(evt) {
		if ($('#dropdown-query').siblings('.dropdown-menu').is(':visible')) {
			user_filter(String.fromCharCode(evt.keyCode));
		} else {
			auto_share(String.fromCharCode(evt.keyCode));
		}
	}
	for (let i = 1; i < 10; i++) {
		shortcut.add(i.toString(), addShortcut, {
			'disable_in_input': true
		});
	}

	// Entry navigation shortcuts
	shortcut.add(shortcuts.prev_entry, function () { prev_entry(false); }, {
		'disable_in_input': true
	});
	shortcut.add(shortcuts.skip_prev_entry,  function () { prev_entry(true); }, {
		'disable_in_input': true
	});
	shortcut.add(shortcuts.first_entry, function () {
		const $old_active = $('.flux.current'),
			$first = $('.flux:first');

		if ($first.hasClass('flux')) {
			toggleContent($first, $old_active, false);
		}
	}, {
		'disable_in_input': true
	});
	shortcut.add(shortcuts.next_entry, function () { next_entry(false); }, {
		'disable_in_input': true
	});
	shortcut.add(shortcuts.skip_next_entry, function () { next_entry(true); }, {
		'disable_in_input': true
	});
	shortcut.add(shortcuts.last_entry, function () {
		const $old_active = $('.flux.current'),
			$last = $('.flux:last');

		if ($last.hasClass('flux')) {
			toggleContent($last, $old_active, false);
		}
	}, {
		'disable_in_input': true
	});
	// Feed navigation shortcuts
	shortcut.add('shift+' + shortcuts.prev_entry, prev_feed, {
		'disable_in_input': true
	});
	shortcut.add('shift+' + shortcuts.next_entry, next_feed, {
		'disable_in_input': true
	});
	shortcut.add('shift+' + shortcuts.first_entry, first_feed, {
		'disable_in_input': true
	});
	shortcut.add('shift+' + shortcuts.last_entry, last_feed, {
		'disable_in_input': true
	});
	// Category navigation shortcuts
	shortcut.add('alt+' + shortcuts.prev_entry, prev_category, {
		'disable_in_input': true
	});
	shortcut.add('alt+' + shortcuts.next_entry, next_category, {
		'disable_in_input': true
	});
	shortcut.add('alt+' + shortcuts.first_entry, first_category, {
		'disable_in_input': true
	});
	shortcut.add('alt+' + shortcuts.last_entry, last_category, {
		'disable_in_input': true
	});

	shortcut.add(shortcuts.go_website, function () {
		const url_website = $('.flux.current a.go_website').attr('href');

		if (context.auto_mark_site) {
			$('.flux.current').each(function () {
				mark_read(this, true);
			});
		}

		redirect(url_website, true);
	}, {
		'disable_in_input': true
	});

	shortcut.add(shortcuts.load_more, load_more_posts, {
		'disable_in_input': true
	});

	shortcut.add(shortcuts.focus_search, focus_search, {
		'disable_in_input': true
	});

	shortcut.add(shortcuts.help, function () {
		redirect(urls.help, true);
	}, {
		'disable_in_input': true
	});

	shortcut.add(shortcuts.close_dropdown, function () {
		location.hash = null;
	}, {
		'disable_in_input': true
	});

	shortcut.add(shortcuts.normal_view, function () {
		$('#nav_menu_views .view-normal').get(0).click();
	}, {
		'disable_in_input': true
	});

	shortcut.add(shortcuts.global_view, function () {
		$('#nav_menu_views .view-global').get(0).click();
	}, {
		'disable_in_input': true
	});

	shortcut.add(shortcuts.reading_view, function () {
		$('#nav_menu_views .view-reader').get(0).click();
	}, {
		'disable_in_input': true
	});

	shortcut.add(shortcuts.rss_view, function () {
		$('#nav_menu_views .view-rss').get(0).click();
	}, {
		'disable_in_input': true
	});
}

function init_stream(divStream) {
	divStream.on('click', '.flux_header,.flux_content', function (e) {	//flux_toggle
		if ($(e.target).closest('.content, .item.website, .item.link, .dropdown-menu').length > 0) {
			return;
		}
		if (!context.sides_close_article && $(e.target).is('div.flux_content')) {
			// setting for not-closing after clicking outside article area
			return;
		}
		const old_active = document.querySelector('.flux.current'),
			new_active = this.parentNode;
		if (e.target.tagName.toUpperCase() === 'A') {	//Leave real links alone
			if (context.auto_mark_article) {
				mark_read(new_active, true);
			}
			return true;
		}
		toggleContent(new_active, old_active, false);
	});

	divStream.on('click', '.flux a.read', function () {
		mark_read(this.closest('.flux'), false);
		return false;
	});

	divStream.on('click', '.flux a.bookmark', function () {
		mark_favorite(this.closest('.flux'));
		return false;
	});

	divStream.on('click', '.item.title > a', function (e) {
		// Allow default control-click behaviour such as open in backround-tab.
		return e.ctrlKey;
	});
	divStream.on('mouseup', '.item.title > a', function (e) {
		// Mouseup enables us to catch middle click.
		if (e.ctrlKey) {
			// CTRL+click, it will be manage by previous rule.
			return;
		}

		if (e.which == 2) {
			// If middle click, we want same behaviour as CTRL+click.
			const ev = jQuery.Event('click');
			ev.ctrlKey = true;
			$(this).trigger(ev);
		} else if (e.which == 1) {
			// Normal click, just toggle article.
			$(this).parent().click();
		}
	});

	divStream.on('click', '.flux .content a', function () {
		if (!$(this).closest('div').hasClass('author')) {
			$(this).attr('target', '_blank').attr('rel', 'noreferrer');
		}
	});

	if (context.auto_mark_site) {
		// catch mouseup instead of click so we can have the correct behaviour
		// with middle button click (scroll button).
		divStream.on('mouseup', '.flux .link > a', function (e) {
			if (e.which == 3) {
				return;
			}

			mark_read(this.closest('.flux'), true);
		});
	}
}

function init_nav_entries() {
	$nav_entries = $('#nav_entries');
	$nav_entries.find('.previous_entry').click(function () {
		prev_entry(false);
		return false;
	});
	$nav_entries.find('.next_entry').click(function () {
		next_entry(false);
		return false;
	});
	$nav_entries.find('.up').click(function () {
		const $active_item = $('.flux.current'),
			windowTop = $(window).scrollTop(),
			item_top = $active_item.offset().top;

		if (windowTop > item_top) {
			$('html,body').scrollTop(item_top);
		} else {
			$('html,body').scrollTop(0);
		}
		return false;
	});
}

function loadDynamicTags($div) {
	$div.removeClass('dynamictags');
	$div.find('li.item').remove();
	const entryId = $div.closest('div.flux').attr('id').replace(/^flux_/, '');
	$.getJSON('./?c=tag&a=getTagsForEntry&id_entry=' + entryId)
		.done(function (data) {
			const $ul = $div.find('.dropdown-menu');
			$ul.append('<li class="item"><label><input class="checkboxTag" name="t_0" type="checkbox" /> <input type="text" name="newTag" /></label></li>');
			if (data && data.length) {
				for (let i = 0; i < data.length; i++) {
					const tag = data[i];
					$ul.append('<li class="item"><label><input class="checkboxTag" name="t_' + tag.id + '" type="checkbox"' +
						(tag.checked ? ' checked="checked"' : '') + '> ' + tag.name + '</label></li>');
				}
			}
		})
		.fail(function () {
			$div.find('li.item').remove();
			$div.addClass('dynamictags');
		});
}

function init_dynamic_tags() {
	$stream.on('click', '.dynamictags', function () {
		loadDynamicTags($(this));
	});

	$stream.on('change', '.checkboxTag', function (ev) {
		const $checkbox = $(this),
			isChecked = $checkbox.prop('checked'),
			tagId = $checkbox.attr('name').replace(/^t_/, ''),
			tagName = $checkbox.siblings('input[name]').val(),
			$entry = $checkbox.closest('div.flux'),
			entryId = $entry.attr('id').replace(/^flux_/, '');
		$checkbox.prop('disabled', true);
		$.ajax({
				type: 'POST',
				url: './?c=tag&a=tagEntry',
				data: {
					_csrf: context.csrf,
					id_tag: tagId,
					name_tag: tagId == 0 ? tagName : '',
					id_entry: entryId,
					checked: isChecked,
				},
			})
			.done(function () {
				if ($entry.hasClass('not_read')) {
					incUnreadsTag('t_' + tagId, isChecked ? 1 : -1);
				}
			})
			.fail(function () {
				$checkbox.prop('checked', !isChecked);
			})
			.always(function () {
				$checkbox.prop('disabled', false);
				if (tagId == 0) {
					loadDynamicTags($checkbox.closest('div.dropdown'));
				}
			});
	});
}

// <actualize>
var feed_processed = 0;

function updateFeed(feeds, feeds_count) {
	const feed = feeds.pop();
	if (!feed) {
		return;
	}
	$.ajax({
		type: 'POST',
		url: feed.url,
		data: {
			_csrf: context.csrf,
			noCommit: 1,
		},
	}).always(function (data) {
		feed_processed++;
		$('#actualizeProgress .progress').html(feed_processed + ' / ' + feeds_count);
		$('#actualizeProgress .title').html(feed.title);

		if (feed_processed === feeds_count) {
			$.ajax({	//Empty request to commit new articles
					type: 'POST',
					url: './?c=feed&a=actualize&id=-1&ajax=1',
					data: {
						_csrf: context.csrf,
						noCommit: 0,
					},
				}).always(function (data) {
					location.reload();
				});
		} else {
			updateFeed(feeds, feeds_count);
		}
	});
}

function init_actualize() {
	let auto = false;

	$('#actualize').click(function () {
		if (ajax_loading) {
			return false;
		}
		ajax_loading = true;

		$.getJSON('./?c=javascript&a=actualize').done(function (data) {
			if (auto && data.feeds.length < 1) {
				auto = false;
				ajax_loading = false;
				return false;
			}
			if (data.feeds.length === 0) {
				openNotification(data.feedback_no_refresh, 'good');
				$.ajax({	//Empty request to force refresh server database cache
					type: 'POST',
					url: './?c=feed&a=actualize&id=-1&ajax=1',
					data: {
						_csrf: context.csrf,
						noCommit: 0,
					},
				}).always(function (data) {
					ajax_loading = false;
				});
				return;
			}
			//Progress bar
			const feeds_count = data.feeds.length;
			$('body').after('<div id="actualizeProgress" class="notification good">' + data.feedback_actualize +
				'<br /><span class="title">/</span><br /><span class="progress">0 / ' + feeds_count +
				'</span></div>');
			for (let i = 10; i > 0; i--) {
				updateFeed(data.feeds, feeds_count);
			}
		});

		return false;
	});

	if (context.auto_actualize_feeds) {
		auto = true;
		$('#actualize').click();
	}
}
// </actualize>

// <notification>
var $notification = null,
	notification_interval = null,
	notification_working = false;

function openNotification(msg, status) {
	if (notification_working === true) {
		return false;
	}

	notification_working = true;

	$notification.removeClass();
	$notification.addClass('notification');
	$notification.addClass(status);
	$notification.find('.msg').html(msg);
	$notification.fadeIn(300);

	notification_interval = setTimeout(closeNotification, 4000);
}

function closeNotification() {
	$notification.fadeOut(600, function () {
		$notification.removeClass();
		$notification.addClass('closed');

		clearInterval(notification_interval);
		notification_working = false;
	});
}

function init_notifications() {
	$notification = $('#notification');

	$notification.find('a.close').click(function () {
		closeNotification();
		return false;
	});

	if ($notification.find('.msg').html().length > 0) {
		notification_working = true;
		notification_interval = setTimeout(closeNotification, 4000);
	}
}
// </notification>

// <notifs html5>
var notifs_html5_permission = 'denied';

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

	const notification = new window.Notification(i18n.notif_title_articles, {
		icon: '../themes/icons/favicon-256.png',
		body: i18n.notif_body_articles.replace('%d', nb),
		tag: 'freshRssNewArticles',
	});

	notification.onclick = function () {
		location.reload();
		window.focus();
		notification.close();
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
	$.getJSON('./?c=javascript&a=nbUnreadsPerFeed').done(function (data) {
		const isAll = document.querySelector('.category.all.active');
		let new_articles = false;

		$.each(data.feeds, function (feed_id, nbUnreads) {
			feed_id = 'f_' + feed_id;
			const elem = document.getElementById(feed_id),
				feed_unreads = elem ? str2int(elem.getAttribute('data-unread')) : 0;

			if ((incUnreadsFeed(null, feed_id, nbUnreads - feed_unreads) || isAll) &&	//Update of current view?
				(nbUnreads - feed_unreads > 0)) {
				$('#new-article').attr('aria-hidden', 'false').show();
				new_articles = true;
			}
		});

		let nbUnreadTags = 0;

		$.each(data.tags, function (tag_id, nbUnreads) {
			nbUnreadTags += nbUnreads;
			$('#t_' + tag_id).attr('data-unread', nbUnreads)
				.children('.item-title').attr('data-unread', numberFormat(nbUnreads));
		});

		$('.category.tags').attr('data-unread', nbUnreadTags)
			.find('.title').attr('data-unread', numberFormat(nbUnreadTags));

		const nb_unreads = str2int($('.category.all .title').attr('data-unread'));

		if (nb_unreads > 0 && new_articles) {
			faviconNbUnread(nb_unreads);
			notifs_html5_show(nb_unreads);
		}
	});
}

//<endless_mode>
var url_load_more = '',
	load_more = false,
	box_load_more = null;

function load_more_posts() {
	if (load_more || url_load_more === '' || box_load_more === null) {
		return;
	}

	load_more = true;
	document.getElementById('load_more').classList.add('loading');
	$.get(url_load_more, function (data) {
		box_load_more.children('.flux:last').after($('#stream', data).children('.flux, .day'));
		$('.pagination').replaceWith($('.pagination', data));
		if (context.display_order === 'ASC') {
			$('#nav_menu_read_all .read_all').attr(
				'formaction', $('#bigMarkAsRead').attr('formaction')
			);
		} else {
			$('#bigMarkAsRead').attr(
				'formaction', $('#nav_menu_read_all .read_all').attr('formaction')
			);
		}

		$('[id^=day_]').each(function (i) {
			const ids = $('[id="' + this.id + '"]');
			if (ids.length > 1) {
				$('[id="' + this.id + '"]:gt(0)').remove();
			}
		});

		init_load_more(box_load_more);

		const bigMarkAsRead = document.getElementById('bigMarkAsRead'),
			div_load_more = document.getElementById('load_more');
		if (bigMarkAsRead) {
			bigMarkAsRead.removeAttribute('disabled');
		}
		if (div_load_more) {
			div_load_more.classList.remove('loading');
		}

		load_more = false;
	});
}

function focus_search() {
	$('#search').focus();
}

var freshrssLoadMoreEvent = document.createEvent('Event');
freshrssLoadMoreEvent.initEvent('freshrss:load-more', true, true);

function init_load_more(box) {
	box_load_more = box;
	document.body.dispatchEvent(freshrssLoadMoreEvent);

	const $next_link = $('#load_more');
	if (!$next_link.length) {
		// no more article to load
		url_load_more = '';
		return;
	}

	url_load_more = $next_link.attr('href');

	$next_link.click(function () {
		load_more_posts();
		return false;
	});
}
//</endless_mode>

//<crypto form (Web login)>
function poormanSalt() {	//If crypto.getRandomValues is not available
	const base = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ.0123456789/abcdefghijklmnopqrstuvwxyz';
	let text = '$2a$04$';
	for (let i = 22; i > 0; i--) {
		text += base.charAt(Math.floor(Math.random() * 64));
	}
	return text;
}

function init_crypto_form() {
	/* globals dcodeIO */
	const $crypto_form = $('#crypto-form');
	if ($crypto_form.length === 0) {
		return;
	}

	if (!(window.dcodeIO)) {
		if (window.console) {
			console.log('FreshRSS waiting for bcrypt.js…');
		}
		setTimeout(init_crypto_form, 100);
		return;
	}

	$crypto_form.on('submit', function () {
		const $submit_button = $(this).find('button[type="submit"]');
		$submit_button.attr('disabled', '');

		let success = false;
		$.ajax({
			url: './?c=javascript&a=nonce&user=' + $('#username').val(),
			dataType: 'json',
			async: false
		}).done(function (data) {
			if (!data.salt1 || !data.nonce) {
				openNotification('Invalid user!', 'bad');
			} else {
				try {
					const strong = window.Uint32Array && window.crypto && (typeof window.crypto.getRandomValues === 'function'),
						s = dcodeIO.bcrypt.hashSync($('#passwordPlain').val(), data.salt1),
						c = dcodeIO.bcrypt.hashSync(data.nonce + s, strong ? dcodeIO.bcrypt.genSaltSync(4) : poormanSalt());
					$('#challenge').val(c);
					if (!s || !c) {
						openNotification('Crypto error!', 'bad');
					} else {
						success = true;
					}
				} catch (e) {
					openNotification('Crypto exception! ' + e, 'bad');
				}
			}
		}).fail(function () {
			openNotification('Communication error!', 'bad');
		});

		$submit_button.removeAttr('disabled');
		return success;
	});
}
//</crypto form (Web login)>

function init_confirm_action() {
	$('body').on('click', '.confirm', function () {
		let str_confirmation = $(this).attr('data-str-confirm');
		if (!str_confirmation) {
			str_confirmation = i18n.confirmation_default;
		}

		return confirm(str_confirmation);
	});
	$('button.confirm').removeAttr('disabled');
}

function init_print_action() {
	$('.item.share > a[href="#"]').click(function (e) {
		const content = '<html><head><style>' +
			'body { font-family: Serif; text-align: justify; }' +
			'a { color: #000; text-decoration: none; }' +
			'a:after { content: " [" attr(href) "]"}' +
			'</style></head><body>' +
			$(e.target).closest('.flux_content').find('.content').html() +
			'</body></html>';

		const tmp_window = window.open();
		tmp_window.document.writeln(content);
		tmp_window.document.close();
		tmp_window.focus();
		tmp_window.print();
		tmp_window.close();

		return false;
	});
}

function init_post_action() {
	$('.item.share > a[href="POST"]').click(function (e) {
		e.preventDefault();
		const $form = $(this).next('form');
		$.post($form.data('url'), $form.serialize());
	});
}

var shares = 0;

function init_share_observers() {
	shares = $('.group-share').length;

	$('.share.add').on('click', function (e) {
		const $opt = $(this).siblings('select').find(':selected');
		let row = $(this).parents('form').data($opt.data('form'));
		row = row.replace(/##label##/g, $opt.html().trim());
		row = row.replace(/##type##/g, $opt.val());
		row = row.replace(/##help##/g, $opt.data('help'));
		row = row.replace(/##key##/g, shares);
		row = row.replace(/##method##/g, $opt.data('method'));
		row = row.replace(/##field##/g, $opt.data('field'));
		$(this).parents('.form-group').before(row);
		shares++;

		return false;
	});
}

function init_stats_observers() {
	$('.select-change').on('change', function (e) {
		redirect($(this).find(':selected').data('url'));
	});
}

function init_remove_observers() {
	$('.post').on('click', 'a.remove', function (e) {
		const remove_what = $(this).attr('data-remove');
		if (remove_what !== undefined) {
			$('#' + remove_what).remove();
		}
		return false;
	});
}

function init_feed_observers() {
	$('select[id="category"]').on('change', function () {
		const $detail = $('#new_category_name').parent();
		if ($(this).val() === 'nc') {
			$detail.attr('aria-hidden', 'false').show();
			$detail.find('input').focus();
		} else {
			$detail.attr('aria-hidden', 'true').hide();
		}
	});
}

function init_password_observers() {
	$('.toggle-password').on('mousedown', function (e) {
		const $button = $(this),
			$passwordField = $('#' + $button.attr('data-toggle'));
		$passwordField.attr('type', 'text');
		$button.addClass('active');
		return false;
	}).on('mouseup', function (e) {
		const $button = $(this),
			$passwordField = $('#' + $button.attr('data-toggle'));
		$passwordField.attr('type', 'password');
		$button.removeClass('active');
		return false;
	});
}

function faviconNbUnread(n) {
	if (typeof n === 'undefined') {
		n = str2int($('.category.all .title').attr('data-unread'));
	}
	//http://remysharp.com/2010/08/24/dynamic-favicons/
	const canvas = document.createElement('canvas'),
		link = document.getElementById('favicon').cloneNode(true);
	if (canvas.getContext && link) {
		canvas.height = canvas.width = 16;
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
				ctx.font = 'bold 9px "Arial", sans-serif';
				ctx.fillStyle = 'rgba(255, 255, 255, 0.8)';
				ctx.fillRect(0, 7, ctx.measureText(text).width, 9);
				ctx.fillStyle = '#F00';
				ctx.fillText(text, 0, canvas.height - 1);
			}
			link.href = canvas.toDataURL('image/png');
			$('link[rel~=icon]').remove();
			document.head.appendChild(link);
		};
		img.src = '../favicon.ico';
	}
}

function init_slider_observers() {
	const $slider = $('#slider'),
		$closer = $('#close-slider');
	if ($slider.length < 1) {
		return;
	}

	$('.post').on('click', '.open-slider', function () {
		if (ajax_loading) {
			return false;
		}

		ajax_loading = true;

		$.ajax({
			type: 'GET',
			url: $(this).attr('href'),
			data: { ajax: true }
		}).done(function (data) {
			$slider.html(data);
			$closer.addClass('active');
			$slider.addClass('active');
			ajax_loading = false;
		});

		return false;
	});

	$closer.on('click', function () {
		$closer.removeClass('active');
		$slider.removeClass('active');
		return false;
	});
}

function init_configuration_alert() {
	$(window).on('submit', function (e) {
		window.hasSubmit = true;
	});
	$(window).on('beforeunload', function (e) {
		if (window.hasSubmit) {
			return;
		}
		const inputs = document.querySelectorAll('[data-leave-validation]');
		for (let i = inputs.length - 1; i >= 0; i--) {
			const input = inputs[i];
			if (input.type === 'checkbox' || input.type === 'radio') {
				if (input.checked != input.getAttribute('data-leave-validation')) {
					return false;
				}
			} else if (input.value != input.getAttribute('data-leave-validation')) {
				return false;
			}
		}
	});
}

function init_subscription() {
	$('body').on('click', '.bookmarkClick', function (e) {
		return false;
	});
}

function init_normal() {
	$stream = $('#stream');
	if ($stream.length < 1) {
		if (window.console) {
			console.log('FreshRSS waiting for content…');
		}
		setTimeout(init_normal, 100);
		return;
	}
	init_column_categories();
	init_stream($stream);
	init_shortcuts();
	init_actualize();
	faviconNbUnread();
}

function init_beforeDOM() {
	if (!window.$) {
		if (window.console) {
			console.log('FreshRSS waiting for jQuery…');
		}
		setTimeout(init_beforeDOM, 100);
		return;
	}
	if (['normal', 'reader', 'global'].indexOf(context.current_view) >= 0) {
		init_normal();
	}
}

function init_afterDOM() {
	if (!window.$) {
		if (window.console) {
			console.log('FreshRSS waiting again for jQuery…');
		}
		setTimeout(init_afterDOM, 100);
		return;
	}
	init_notifications();
	init_confirm_action();
	$stream = $('#stream');
	if ($stream.length > 0) {
		init_load_more($stream);
		init_posts();
		init_nav_entries();
		init_dynamic_tags();
		init_print_action();
		init_post_action();
		init_notifs_html5();
		setInterval(refreshUnreads, 120000);
	} else {
		init_subscription();
		init_crypto_form();
		init_share_observers();
		init_remove_observers();
		init_feed_observers();
		init_password_observers();
		init_stats_observers();
		init_slider_observers();
		init_configuration_alert();
	}

	if (window.console) {
		console.log('FreshRSS init done.');
	}
}

init_beforeDOM();	//Can be called before DOM is fully loaded

if (document.readyState && document.readyState !== 'loading') {
	init_afterDOM();
} else if (document.addEventListener) {
	document.addEventListener('DOMContentLoaded', function () {
		if (window.console) {
			console.log('FreshRSS waiting for DOMContentLoaded…');
		}
		init_afterDOM();
	}, false);
}
