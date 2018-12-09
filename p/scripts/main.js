"use strict";
/* globals $, jQuery, context, i18n, shortcut, shortcuts, SimpleScrollbar, url */
/* jshint strict:global */

var $stream = null,
	isCollapsed = true,
	shares = 0,
	ajax_loading = false;

function redirect(url, new_tab) {
	if (url) {
		if (new_tab) {
			window.open(url);
		} else {
			location.href = url;
		}
	}
}

function needsScroll($elem) {
	var $win = $(window),
		winTop = $win.scrollTop(),
		winHeight = $win.height(),
		winBottom = winTop + winHeight,
		elemTop = $elem.offset().top,
		elemBottom = elemTop + $elem.outerHeight();
	return (elemTop < winTop || elemBottom > winBottom) ? elemTop - (winHeight / 2) : 0;
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
	var x = nStr.split('.'),
		x1 = x[0],
		x2 = x.length > 1 ? '.' + x[1] : '',
		rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ' ' + '$2');
	}
	return x1 + x2;
}

function incLabel(p, inc, spaceAfter) {
	var i = str2int(p) + inc;
	return i > 0 ? ((spaceAfter ? '' : ' ') + '(' + numberFormat(i) + ')' + (spaceAfter ? ' ' : '')) : '';
}

function incUnreadsFeed(article, feed_id, nb) {
	//Update unread: feed
	var elem = $('#' + feed_id).get(0),
		feed_unreads = elem ? str2int(elem.getAttribute('data-unread')) : 0,
		feed_priority = elem ? str2int(elem.getAttribute('data-priority')) : 0;
	if (elem) {
		elem.setAttribute('data-unread', feed_unreads + nb);
		elem = $(elem).children('.item-title').get(0);
		if (elem) {
			elem.setAttribute('data-unread', numberFormat(feed_unreads + nb));
		}
	}

	//Update unread: category
	elem = $('#' + feed_id).parents('.category').get(0);
	feed_unreads = elem ? str2int(elem.getAttribute('data-unread')) : 0;
	if (elem) {
		elem.setAttribute('data-unread', feed_unreads + nb);
		elem = $(elem).find('.title').get(0);
		if (elem) {
			elem.setAttribute('data-unread', numberFormat(feed_unreads + nb));
		}
	}

	//Update unread: all
	if (feed_priority > 0) {
		elem = $('#aside_feed .all .title').get(0);
		if (elem) {
			feed_unreads = elem ? str2int(elem.getAttribute('data-unread')) : 0;
			elem.setAttribute('data-unread', numberFormat(feed_unreads + nb));
		}
	}

	//Update unread: favourites
	if (article && article.closest('div').hasClass('favorite')) {
		elem = $('#aside_feed .favorites .title').get(0);
		if (elem) {
			feed_unreads = elem ? str2int(elem.getAttribute('data-unread')) : 0;
			elem.setAttribute('data-unread', numberFormat(feed_unreads + nb));
		}
	}

	var isCurrentView = false;
	// Update unread: title
	document.title = document.title.replace(/^((?:\([ 0-9]+\) )?)/, function (m, p1) {
		var $feed = $('#' + feed_id);
		if (article || ($feed.closest('.active').length > 0 && $feed.siblings('.active').length === 0)) {
			isCurrentView = true;
			return incLabel(p1, nb, true);
		} else if ($('.all.active').length > 0) {
			isCurrentView = feed_priority > 0;
			return incLabel(p1, feed_priority > 0 ? nb : 0, true);
		} else {
			return p1;
		}
	});
	return isCurrentView;
}

function incUnreadsTag(tag_id, nb) {
	var $t = $('#t_' + tag_id);
	var unreads = str2int($t.attr('data-unread'));
	$t.attr('data-unread', unreads + nb)
		.children('.item-title').attr('data-unread', numberFormat(unreads + nb));

	$t = $('.category.tags').find('.title');
	unreads = str2int($t.attr('data-unread'));
	$t.attr('data-unread', numberFormat(unreads + nb));
}

var pending_entries = {};
function mark_read(active, only_not_read) {
	if ((active.length === 0) || (!active.attr('id')) ||
		context.anonymous ||
		(only_not_read && !active.hasClass("not_read"))) {
		return false;
	}

	if (pending_entries[active.attr('id')]) {
		return false;
	}
	pending_entries[active.attr('id')] = true;

	var url = '.?c=entry&a=read&id=' + active.attr('id').replace(/^flux_/, '') +
		(active.hasClass('not_read') ? '' : '&is_read=0');

	$.ajax({
		type: 'POST',
		url: url,
		data: {
			ajax: true,
			_csrf: context.csrf,
		},
	}).done(function (data) {
		var $r = active.find("a.read").attr("href", data.url),
			inc = 0;
		if (active.hasClass("not_read")) {
			active.removeClass("not_read");
			inc--;
		} else {
			active.addClass("not_read");
			active.addClass("keep_unread");
			inc++;
		}
		$r.find('.icon').replaceWith(data.icon);

		var feed_url = active.find(".website>a").attr("href");
		if (feed_url) {
			var feed_id = feed_url.substr(feed_url.lastIndexOf('f_'));
			incUnreadsFeed(active, feed_id, inc);
		}
		faviconNbUnread();

		if (data.tags) {
			for (var i = data.tags.length - 1; i >= 0; i--) {
				incUnreadsTag(data.tags[i], inc);
			}
		}

		delete pending_entries[active.attr('id')];
	}).fail(function (data) {
		openNotification(i18n.notif_request_failed, 'bad');
		delete pending_entries[active.attr('id')];
	});
}

function mark_favorite(active) {
	if (active.length === 0) {
		return false;
	}

	var url = active.find("a.bookmark").attr("href");
	if (url === undefined) {
		return false;
	}

	if (pending_entries[active.attr('id')]) {
		return false;
	}
	pending_entries[active.attr('id')] = true;

	$.ajax({
		type: 'POST',
		url: url,
		data: {
			ajax: true,
			_csrf: context.csrf,
		},
	}).done(function (data) {
		var $b = active.find("a.bookmark").attr("href", data.url),
			inc = 0;
		if (active.hasClass("favorite")) {
			active.removeClass("favorite");
			inc--;
		} else {
			active.addClass("favorite").find('.bookmark');
			inc++;
		}
		$b.find('.icon').replaceWith(data.icon);

		var favourites = $('#aside_feed .favorites .title').contents().last().get(0);
		if (favourites && favourites.textContent) {
			favourites.textContent = favourites.textContent.replace(/((?: \([ 0-9]+\))?\s*)$/, function (m, p1) {
				return incLabel(p1, inc, false);
			});
		}

		if (active.closest('div').hasClass('not_read')) {
			var elem = $('#aside_feed .favorites .title').get(0),
				feed_unreads = elem ? str2int(elem.getAttribute('data-unread')) : 0;
			if (elem) {
				elem.setAttribute('data-unread', numberFormat(feed_unreads + inc));
			}
		}

		delete pending_entries[active.attr('id')];
	}).fail(function (data) {
		openNotification(i18n.notif_request_failed, 'bad');
		delete pending_entries[active.attr('id')];
	});
}

function toggleContent(new_active, old_active, skipping) {
	// If skipping, move current without activating or marking as read
	if (new_active.length === 0) {
		return;
	}

	if (context.does_lazyload && !skipping) {
		new_active.find('img[data-original], iframe[data-original]').each(function () {
			this.setAttribute('src', this.getAttribute('data-original'));
			this.removeAttribute('data-original');
		});
	}

	if (old_active[0] !== new_active[0]) {
		if (isCollapsed && !skipping) { // BUG?: isCollapsed can only ever be true
			new_active.addClass("active");
		}
		old_active.removeClass("active current");
		new_active.addClass("current");
		if (context.auto_remove_article && !old_active.hasClass('not_read') && !skipping) {
			auto_remove(old_active);
		}
	} else { // collapse_entry calls toggleContent(flux_current, flux_current, false)
		new_active.toggleClass('active');
	}

	var relative_move = context.current_view === 'global',
		box_to_move = $(relative_move ? "#panel" : "html,body");

	if (context.sticky_post) {
		var prev_article = new_active.prevAll('.flux'),
			new_pos = new_active.offset().top,
			old_scroll = box_to_move.scrollTop();

		if (prev_article.length > 0 && new_pos - prev_article.offset().top <= 150) {
			new_pos = prev_article.offset().top;
			if (relative_move) {
				new_pos -= box_to_move.offset().top;
			}
		}

		if (skipping) {
			// when skipping, this feels more natural if it's not so near the top
			new_pos -= $(window).height() / 4;
		}
		if (context.hide_posts) {
			if (relative_move) {
				new_pos += old_scroll;
			}

			new_active.children(".flux_content").first().each(function () {
				box_to_move.scrollTop(new_pos).scrollTop();
			});
		} else {
			if (relative_move) {
				new_pos += old_scroll;
			}

			box_to_move.scrollTop(new_pos).scrollTop();
		}
	}

	if (context.auto_mark_article && new_active.hasClass('active') && !skipping) {
		mark_read(new_active, true);
	}
}

function auto_remove(element) {
	var p = element.prev();
	var n = element.next();
	if (p.hasClass('day') && n.hasClass('day')) {
		p.remove();
	}
	element.remove();
	$('#stream > .flux:not(.not_read):not(.active)').remove();
}

function prev_entry() {
	var old_active = $(".flux.current"),
		new_active = old_active.length === 0 ? $(".flux:last") : old_active.prevAll(".flux:first");
	toggleContent(new_active, old_active, false);
}

function next_entry() {
	var old_active = $(".flux.current"),
		new_active = old_active.length === 0 ? $(".flux:first") : old_active.nextAll(".flux:first");
	toggleContent(new_active, old_active, false);

	if (new_active.nextAll().length < 3) {
		load_more_posts();
	}
}

function skip_prev_entry() {
	var old_active = $(".flux.current"),
		new_active = old_active.length === 0 ? $(".flux:last") : old_active.prevAll(".flux:first");
	toggleContent(new_active, old_active, true);
}

function skip_next_entry() {
	var old_active = $(".flux.current"),
		new_active = old_active.length === 0 ? $(".flux:first") : old_active.nextAll(".flux:first");
	toggleContent(new_active, old_active, true);

	if (new_active.nextAll().length < 3) {
		load_more_posts();
	}
}

function prev_feed() {
	var active_feed = $("#aside_feed .tree-folder-items .item.active");
	if (active_feed.length > 0) {
		active_feed.prevAll(':visible:first').find('a').each(function(){this.click();});
	} else {
		last_feed();
	}
}

function next_feed() {
	var active_feed = $("#aside_feed .tree-folder-items .item.active");
	if (active_feed.length > 0) {
		active_feed.nextAll(':visible:first').find('a').each(function(){this.click();});
	} else {
		first_feed();
	}
}

function first_feed() {
	var feed = $("#aside_feed .tree-folder-items.active .item:visible:first");
	if (feed.length > 0) {
		feed.find('a')[1].click();
	}
}

function last_feed() {
	var feed = $("#aside_feed .tree-folder-items.active .item:visible:last");
	if (feed.length > 0) {
		feed.find('a')[1].click();
	}
}

function prev_category() {
	var active_cat = $("#aside_feed .tree-folder.active");

	if (active_cat.length > 0) {
		var prev_cat = active_cat.prevAll(':visible:first').find('.tree-folder-title .title');
		if (prev_cat.length > 0) {
			prev_cat[0].click();
		}
	} else {
		last_category();
	}
	return;
}

function next_category() {
	var active_cat = $("#aside_feed .tree-folder.active");

	if (active_cat.length > 0) {
		var next_cat = active_cat.nextAll(':visible:first').find('.tree-folder-title .title');
		if (next_cat.length > 0) {
			next_cat[0].click();
		}
	} else {
		first_category();
	}
	return;
}

function first_category() {
	var cat = $("#aside_feed .tree-folder:visible:first");
	if (cat.length > 0) {
		cat.find('.tree-folder-title .title')[0].click();
	}
}

function last_category() {
	var cat = $("#aside_feed .tree-folder:visible:last");
	if (cat.length > 0) {
		cat.find('.tree-folder-title .title')[0].click();
	}
}

function collapse_entry() {
	var flux_current = $(".flux.current");
	toggleContent(flux_current, flux_current, false);
}

function user_filter(key) {
	var filter = $('#dropdown-query');
	var filters = filter.siblings('.dropdown-menu').find('.item.query a');
	if (typeof key === "undefined") {
		if (!filter.length) {
			return;
		}
		// Display the filter div
		window.location.hash = filter.attr('id');
		// Force scrolling to the filter div
		var scroll = needsScroll($('.header'));
		if (scroll !== 0) {
			$('html,body').scrollTop(scroll);
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
	var share = $(".flux.current.active").find('.dropdown-target[id^="dropdown-share"]');
	var shares = share.siblings('.dropdown-menu').find('.item a');
	if (typeof key === "undefined") {
		if (!share.length) {
			return;
		}
		// Display the share div
		window.location.hash = share.attr('id');
		// Force scrolling to the share div
		var scroll = needsScroll(share.closest('.bottom'));
		if (scroll !== 0) {
			$('html,body').scrollTop(scroll);
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
		share.siblings('.dropdown-menu').find('.dropdown-close a')[0].click();
	}
}

function scrollAsRead(box_to_follow) {
	var minTop = 40 + (context.current_view === 'global' ? box_to_follow.offset().top : box_to_follow.scrollTop());
	$('.not_read:not(.keep_unread):visible').each(function () {
			var $this = $(this);
			if ($this.offset().top + $this.height() < minTop) {
				mark_read($this, true);
			}
		});
}

function init_posts() {
	var box_to_follow = context.current_view === 'global' ? $("#panel") : $(window);

	if (context.auto_mark_scroll) {
		var lastScroll = 0,	//Throttle
			timerId = 0;
		box_to_follow.scroll(function () {
			window.clearTimeout(timerId);
			if (lastScroll + 500 < Date.now()) {
				lastScroll = Date.now();
				scrollAsRead(box_to_follow);
			} else {
				timerId = window.setTimeout(function() {
						scrollAsRead(box_to_follow);
					}, 500);
			}
		});
	}

	if (context.auto_load_more) {
		box_to_follow.scroll(function () {
			var load_more = $("#load_more");
			if (!load_more.is(':visible')) {
				return;
			}
			var boxBot = box_to_follow.scrollTop() + box_to_follow.height(),
				load_more_top = load_more.offset().top;
			if (boxBot >= load_more_top) {
				load_more_posts();
			}
		});
		box_to_follow.scroll();
	}
}

function inject_script(name) {
	var script = document.createElement('script');
	script.async = 'async';
	script.defer = 'defer';
	script.src = '../scripts/' + name;
	document.head.appendChild(script);
}

var sidebarHref = null;

function init_column_categories() {
	if (context.current_view !== 'normal') {
		return;
	}

	$('#aside_feed').on('click', '.tree-folder>.tree-folder-title>a.dropdown-toggle', function () {
		$(this).children().each(function() {
			if (this.alt === '▽') {
				this.src = this.src.replace('/icons/down.', '/icons/up.');
				this.alt = '△';
			} else {
				this.src = this.src.replace('/icons/up.', '/icons/down.');
				this.alt = '▽';
			}
		});
		$(this).parent().next(".tree-folder-items").slideToggle(300, function () {
			if (useJsScrollbar && sidebar) { //Refresh JS scrollbar
				sidebar.querySelector('.ss-content').dispatchEvent(new Event('scroll'));
			}
		});
		return false;
	});
	$('#aside_feed').on('click', '.tree-folder-items .feed .dropdown-toggle', function () {
		if ($(this).nextAll('.dropdown-menu').length === 0) {
			var itemId = $(this).closest('.item').attr('id'),
				templateId = itemId.substring(0, 2) === 't_' ? 'tag_config_template' : 'feed_config_template',
				id = itemId.substr(2),
				feed_web = $(this).data('fweb'),
				template = $('#' + templateId)
					.html().replace(/------/g, id).replace('http://example.net/', feed_web);
			$(this).attr('href', '#dropdown-' + id).prev('.dropdown-target').attr('id', 'dropdown-' + id).parent()
				.append(template).find('button.confirm').removeAttr('disabled');
		} else {
			var id = $(this).closest('.item').attr('id').substr(2);
		}

		if ($(this).next('.dropdown-menu').css('display') === 'none'){
			if (window.location.hash != "close" && ($(this).attr('href') != '#close')) {
				sidebarHref = $(this).attr('href');
			}
			$(this).attr('href', sidebarHref);
		} else {
			$(this).attr('href', "#close");
		}
	});
}

var navHref = null;
var configHreg = null;

function init_dropdown_handler() {
	$('body').not($('.dropdown')).click(function () {
		window.location.hash = "close";
	});

	$('.nav_menu, .header').on('click', '.dropdown-toggle', function () {
		if ( $(this).parents('.nav_menu').length  === 1) {
			if ($(this).next('.dropdown-menu').css('display') === 'none'){
				if (window.location.hash != "close" && ($(this).attr('href') != '#close')) {
					navHref = $(this).attr('href');
				}
				$(this).attr('href', navHref);
			} else{
				$(this).attr('href', "#close");
			}
		} else if ($(this).parents('.header').length === 1) {
			if ($(this).next('.dropdown-menu').css('display') === 'none'){
				if (window.location.hash != "close" && ($(this).attr('href') != '#close')) {
					configHref = $(this).attr('href');
				}
				$(this).attr('href', configHref);
			} else{
				$(this).attr('href', "#close");
			}
		}
	});
}

function init_shortcuts() {
	if (!(window.shortcut && window.shortcuts)) {
		if (window.console) {
			console.log('FreshRSS waiting for shortcut.js…');
		}
		window.setTimeout(init_shortcuts, 200);
		return;
	}
	// Manipulation shortcuts
	shortcut.add(shortcuts.mark_read, function () {
		// Toggle the read state
		var active = $(".flux.current");
		mark_read(active, false);
	}, {
		'disable_in_input': true
	});
	shortcut.add("shift+" + shortcuts.mark_read, function () {
		// Mark everything as read
		$(".nav_menu .read_all").click();
	}, {
		'disable_in_input': true
	});
	shortcut.add(shortcuts.mark_favorite, function () {
		// Toggle the favorite state
		var active = $(".flux.current");
		mark_favorite(active);
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
	for (var i = 1; i < 10; i++) {
		shortcut.add(i.toString(), addShortcut, {
			'disable_in_input': true
		});
	}

	// Entry navigation shortcuts
	shortcut.add(shortcuts.prev_entry, prev_entry, {
		'disable_in_input': true
	});
	shortcut.add(shortcuts.skip_prev_entry, skip_prev_entry, {
		'disable_in_input': true
	});
	shortcut.add(shortcuts.first_entry, function () {
		var old_active = $(".flux.current"),
			first = $(".flux:first");

		if (first.hasClass("flux")) {
			toggleContent(first, old_active, false);
		}
	}, {
		'disable_in_input': true
	});
	shortcut.add(shortcuts.next_entry, next_entry, {
		'disable_in_input': true
	});
	shortcut.add(shortcuts.skip_next_entry, skip_next_entry, {
		'disable_in_input': true
	});
	shortcut.add(shortcuts.last_entry, function () {
		var old_active = $(".flux.current"),
			last = $(".flux:last");

		if (last.hasClass("flux")) {
			toggleContent(last, old_active, false);
		}
	}, {
		'disable_in_input': true
	});
	// Feed navigation shortcuts
	shortcut.add("shift+" + shortcuts.prev_entry, prev_feed, {
		'disable_in_input': true
	});
	shortcut.add("shift+" + shortcuts.next_entry, next_feed, {
		'disable_in_input': true
	});
	shortcut.add("shift+" + shortcuts.first_entry, first_feed, {
		'disable_in_input': true
	});
	shortcut.add("shift+" + shortcuts.last_entry, last_feed, {
		'disable_in_input': true
	});
	// Category navigation shortcuts
	shortcut.add("alt+" + shortcuts.prev_entry, prev_category, {
		'disable_in_input': true
	});
	shortcut.add("alt+" + shortcuts.next_entry, next_category, {
		'disable_in_input': true
	});
	shortcut.add("alt+" + shortcuts.first_entry, first_category, {
		'disable_in_input': true
	});
	shortcut.add("alt+" + shortcuts.last_entry, last_category, {
		'disable_in_input': true
	});

	shortcut.add(shortcuts.go_website, function () {
		var url_website = $('.flux.current a.go_website').attr("href");

		if (context.auto_mark_site) {
			$(".flux.current").each(function () {
				mark_read($(this), true);
			});
		}

		redirect(url_website, true);
	}, {
		'disable_in_input': true
	});

	shortcut.add(shortcuts.load_more, function () {
		load_more_posts();
	}, {
		'disable_in_input': true
	});

	shortcut.add(shortcuts.focus_search, function () {
		focus_search();
	}, {
		'disable_in_input': true
	});

	shortcut.add(shortcuts.help, function () {
		redirect(url.help, true);
	}, {
		'disable_in_input': true
	});

	shortcut.add(shortcuts.close_dropdown, function () {
		window.location.hash = null;
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
		var old_active = $(".flux.current"),
			new_active = $(this).parent();
		isCollapsed = true;
		if (e.target.tagName.toUpperCase() === 'A') {	//Leave real links alone
			if (context.auto_mark_article) {
				mark_read(new_active, true);
			}
			return true;
		}
		toggleContent(new_active, old_active, false);
	});

	divStream.on('click', '.flux a.read', function () {
		var active = $(this).parents(".flux");
		if (context.auto_remove_article && active.hasClass('not_read')) {
			auto_remove(active);
		}
		mark_read(active, false);
		return false;
	});

	divStream.on('click', '.flux a.bookmark', function () {
		var active = $(this).parents(".flux");
		mark_favorite(active);
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
			var ev = jQuery.Event("click");
			ev.ctrlKey = true;
			$(this).trigger(ev);
		} else if(e.which == 1) {
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

			mark_read($(this).parents(".flux"), true);
		});
	}
}

var $nav_entries = null;

function init_nav_entries() {
	$nav_entries = $('#nav_entries');
	$nav_entries.find('.previous_entry').click(function () {
		prev_entry();
		return false;
	});
	$nav_entries.find('.next_entry').click(function () {
		next_entry();
		return false;
	});
	$nav_entries.find('.up').click(function () {
		var active_item = $(".flux.current"),
			windowTop = $(window).scrollTop(),
			item_top = active_item.offset().top;

		if (windowTop > item_top) {
			$("html,body").scrollTop(item_top);
		} else {
			$("html,body").scrollTop(0);
		}
		return false;
	});
}

function loadDynamicTags($div) {
	$div.removeClass('dynamictags');
	$div.find('li.item').remove();
	var entryId = $div.closest('div.flux').attr('id').replace(/^flux_/, '');
	$.getJSON('./?c=tag&a=getTagsForEntry&id_entry=' + entryId)
		.done(function (data) {
			var $ul = $div.find('.dropdown-menu');
			$ul.append('<li class="item"><label><input class="checkboxTag" name="t_0" type="checkbox" /> <input type="text" name="newTag" /></label></li>');
			if (data && data.length) {
				for (var i = 0; i < data.length; i++) {
					var tag = data[i];
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
		var $checkbox = $(this);
		$checkbox.prop('disabled', true);
		var isChecked = $checkbox.prop('checked');
		var tagId = $checkbox.attr('name').replace(/^t_/, '');
		var tagName = $checkbox.siblings('input[name]').val();
		var $entry = $checkbox.closest('div.flux');
		var entryId = $entry.attr('id').replace(/^flux_/, '');
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
					incUnreadsTag(tagId, isChecked ? 1 : -1);
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
	var feed = feeds.pop();
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
		$("#actualizeProgress .progress").html(feed_processed + " / " + feeds_count);
		$("#actualizeProgress .title").html(feed.title);

		if (feed_processed === feeds_count) {
			$.ajax({	//Empty request to commit new articles
					type: 'POST',
					url: './?c=feed&a=actualize&id=-1&ajax=1',
					data: {
						_csrf: context.csrf,
						noCommit: 0,
					},
				}).always(function (data) {
					window.location.reload();
				});
		} else {
			updateFeed(feeds, feeds_count);
		}
	});
}

function init_actualize() {
	var auto = false;

	$("#actualize").click(function () {
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
				openNotification(data.feedback_no_refresh, "good");
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
			var feeds_count = data.feeds.length;
			$('body').after('<div id="actualizeProgress" class="notification good">' + data.feedback_actualize +
				'<br /><span class="title">/</span><br /><span class="progress">0 / ' + feeds_count +
				'</span></div>');
			for (var i = 10; i > 0; i--) {
				updateFeed(data.feeds, feeds_count);
			}
		});

		return false;
	});

	if (context.auto_actualize_feeds) {
		auto = true;
		$("#actualize").click();
	}
}
// </actualize>

// <notification>
var notification = null,
	notification_interval = null,
	notification_working = false;

function openNotification(msg, status) {
	if (notification_working === true) {
		return false;
	}

	notification_working = true;

	notification.removeClass();
	notification.addClass("notification");
	notification.addClass(status);
	notification.find(".msg").html(msg);
	notification.fadeIn(300);

	notification_interval = window.setTimeout(closeNotification, 4000);
}

function closeNotification() {
	notification.fadeOut(600, function() {
		notification.removeClass();
		notification.addClass('closed');

		window.clearInterval(notification_interval);
		notification_working = false;
	});
}

function init_notifications() {
	notification = $("#notification");

	notification.find("a.close").click(function () {
		closeNotification();
		return false;
	});

	if (notification.find(".msg").html().length > 0) {
		notification_working = true;
		notification_interval = window.setTimeout(closeNotification, 4000);
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
	if (notifs_html5_permission !== "granted") {
		return;
	}

	var notification = new window.Notification(i18n.notif_title_articles, {
		icon: "../themes/icons/favicon-256.png",
		body: i18n.notif_body_articles.replace('%d', nb),
		tag: "freshRssNewArticles"
	});

	notification.onclick = function() {
		window.location.reload();
		window.focus();
		notification.close();
	};

	if (context.html5_notif_timeout !== 0) {
		setTimeout(function() {
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
		var isAll = $('.category.all.active').length > 0,
			new_articles = false;

		$.each(data.feeds, function(feed_id, nbUnreads) {
			feed_id = 'f_' + feed_id;
			var elem = $('#' + feed_id).get(0),
				feed_unreads = elem ? str2int(elem.getAttribute('data-unread')) : 0;

			if ((incUnreadsFeed(null, feed_id, nbUnreads - feed_unreads) || isAll) &&	//Update of current view?
				(nbUnreads - feed_unreads > 0)) {
				$('#new-article').attr('aria-hidden', 'false').show();
				new_articles = true;
			}
		});

		var nbUnreadTags = 0;

		$.each(data.tags, function(tag_id, nbUnreads) {
			nbUnreadTags += nbUnreads;
			$('#t_' + tag_id).attr('data-unread', nbUnreads)
				.children('.item-title').attr('data-unread', numberFormat(nbUnreads));
		});

		$('.category.tags').attr('data-unread', nbUnreadTags)
			.find('.title').attr('data-unread', numberFormat(nbUnreadTags));

		var nb_unreads = str2int($('.category.all .title').attr('data-unread'));

		if (nb_unreads > 0 && new_articles) {
			faviconNbUnread(nb_unreads);
			notifs_html5_show(nb_unreads);
		}
	});
}

//<endless_mode>
var url_load_more = "",
	load_more = false,
	box_load_more = null;

function load_more_posts() {
	if (load_more || url_load_more === '' || box_load_more === null) {
		return;
	}

	load_more = true;
	$('#load_more').addClass('loading');
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
			var ids = $('[id="' + this.id + '"]');
			if (ids.length > 1) {
				$('[id="' + this.id + '"]:gt(0)').remove();
			}
		});

		init_load_more(box_load_more);

		$('#load_more').removeClass('loading');
		$('#bigMarkAsRead').removeAttr('disabled');
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

	var $next_link = $("#load_more");
	if (!$next_link.length) {
		// no more article to load
		url_load_more = "";
		return;
	}

	url_load_more = $next_link.attr("href");

	$next_link.click(function () {
		load_more_posts();
		return false;
	});
}
//</endless_mode>

//<crypto form (Web login)>
function poormanSalt() {	//If crypto.getRandomValues is not available
	var text = '$2a$04$',
		base = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ.0123456789/abcdefghijklmnopqrstuvwxyz';
	for (var i = 22; i > 0; i--) {
		text += base.charAt(Math.floor(Math.random() * 64));
	}
	return text;
}

function init_crypto_form() {
	/* globals dcodeIO */
	var $crypto_form = $('#crypto-form');
	if ($crypto_form.length === 0) {
		return;
	}

	if (!(window.dcodeIO)) {
		if (window.console) {
			console.log('FreshRSS waiting for bcrypt.js…');
		}
		window.setTimeout(init_crypto_form, 100);
		return;
	}

	$crypto_form.on('submit', function() {
		var $submit_button = $(this).find('button[type="submit"]');
		$submit_button.attr('disabled', '');

		var success = false;
		$.ajax({
			url: './?c=javascript&a=nonce&user=' + $('#username').val(),
			dataType: 'json',
			async: false
		}).done(function (data) {
			if (!data.salt1 || !data.nonce) {
				openNotification('Invalid user!', 'bad');
			} else {
				try {
					var strong = window.Uint32Array && window.crypto && (typeof window.crypto.getRandomValues === 'function'),
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
		}).fail(function() {
			openNotification('Communication error!', 'bad');
		});

		$submit_button.removeAttr('disabled');
		return success;
	});
}
//</crypto form (Web login)>

var sidebar = document.getElementById('sidebar');
var useJsScrollbar = true;
try {
	useJsScrollbar = sidebar && !CSS.supports('scrollbar-color: auto') &&
		!(parseInt(getComputedStyle(sidebar, '::-webkit-scrollbar').width) < 99);
} catch (ex) {
}
if (useJsScrollbar) {
	inject_script('simple-scrollbar.min.js');
}

function sticky_recalc() {
	var h = 0;
	if ($nav_entries && $nav_entries.length > 0) {
		h = $(window).height() - sidebar.getBoundingClientRect().top - $nav_entries.height();
	} else {
		h = $(window).height() - sidebar.getBoundingClientRect().top;
	}
	if (h > 0) {
		$(sidebar).height(h);
	}
}

function init_simple_scrollbar() {
	if (!window.SimpleScrollbar) {
		if (window.console) {
			console.log('FreshRSS waiting for simple-scrollbar…');
		}
		window.setTimeout(init_simple_scrollbar, 100);
	} else {
		SimpleScrollbar.initEl(sidebar);
	}
}

var scrollTimeout;
function init_sticky_sidebar(){
	if (!sidebar) {
		return;
	}
	if (useJsScrollbar) {
		init_simple_scrollbar();
	}
	$(window).scroll(function () {
				if (scrollTimeout) {
					clearTimeout(scrollTimeout);
					scrollTimeout = null;
				}
				scrollTimeout = setTimeout(sticky_recalc, 200);
			});
	window.onresize = sticky_recalc;
}

function init_confirm_action() {
	$('body').on('click', '.confirm', function () {
		var str_confirmation = $(this).attr('data-str-confirm');
		if (!str_confirmation) {
			str_confirmation = i18n.confirmation_default;
		}

		return confirm(str_confirmation);
	});
	$('button.confirm').removeAttr('disabled');
}

function init_print_action() {
	$('.item.share > a[href="#"]').click(function (e) {
		var content = "<html><head><style>" +
			"body { font-family: Serif; text-align: justify; }" +
			"a { color: #000; text-decoration: none; }" +
			"a:after { content: ' [' attr(href) ']'}" +
			"</style></head><body>" +
			$(e.target).closest('.flux_content').find('.content').html() +
			"</body></html>";

		var tmp_window = window.open();
		tmp_window.document.writeln(content);
		tmp_window.document.close();
		tmp_window.focus();
		tmp_window.print();
		tmp_window.close();

		return false;
	});
}

function init_post_action() {
	$('.item.share > a[href="POST"]').click(function (event) {
		event.preventDefault();
		var form = $(this).next('form');
		$.post(form.data('url'), form.serialize());
	});
}

function init_share_observers() {
	shares = $('.group-share').length;

	$('.share.add').on('click', function(e) {
		var opt = $(this).siblings('select').find(':selected');
		var row = $(this).parents('form').data(opt.data('form'));
		row = row.replace(/##label##/g, opt.html().trim());
		row = row.replace(/##type##/g, opt.val());
		row = row.replace(/##help##/g, opt.data('help'));
		row = row.replace(/##key##/g, shares);
		row = row.replace(/##method##/g, opt.data('method'));
		row = row.replace(/##field##/g, opt.data('field'));
		$(this).parents('.form-group').before(row);
		shares++;

		return false;
	});
}

function init_stats_observers() {
	$('.select-change').on('change', function(e) {
		redirect($(this).find(':selected').data('url'));
	});
}

function init_remove_observers() {
	$('.post').on('click', 'a.remove', function(e) {
		var remove_what = $(this).attr('data-remove');

		if (remove_what !== undefined) {
			var remove_obj = $('#' + remove_what);
			remove_obj.remove();
		}

		return false;
	});
}

function init_feed_observers() {
	$('select[id="category"]').on('change', function() {
		var detail = $('#new_category_name').parent();
		if ($(this).val() === 'nc') {
			detail.attr('aria-hidden', 'false').show();
			detail.find('input').focus();
		} else {
			detail.attr('aria-hidden', 'true').hide();
		}
	});
}

function init_password_observers() {
	$('.toggle-password').on('mousedown', function(e) {
		var button = $(this);
		var passwordField = $('#' + button.attr('data-toggle'));
		passwordField.attr('type', 'text');
		button.addClass('active');

		return false;
	}).on('mouseup', function(e) {
		var button = $(this);
		var passwordField = $('#' + button.attr('data-toggle'));
		passwordField.attr('type', 'password');
		button.removeClass('active');

		return false;
	});
}

function faviconNbUnread(n) {
	if (typeof n === 'undefined') {
		n = str2int($('.category.all .title').attr('data-unread'));
	}
	//http://remysharp.com/2010/08/24/dynamic-favicons/
	var canvas = document.createElement('canvas'),
		link = document.getElementById('favicon').cloneNode(true);
	if (canvas.getContext && link) {
		canvas.height = canvas.width = 16;
		var img = document.createElement('img');
		img.onload = function () {
			var ctx = canvas.getContext('2d');
			ctx.drawImage(this, 0, 0, canvas.width, canvas.height);
			if (n > 0) {
				var text = '';
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
	var slider = $('#slider'),
		closer = $('#close-slider');
	if (slider.length < 1) {
		return;
	}

	$('.post').on('click', '.open-slider', function() {
		if (ajax_loading) {
			return false;
		}

		ajax_loading = true;
		var url_slide = $(this).attr('href');

		$.ajax({
			type: 'GET',
			url: url_slide,
			data: { ajax: true }
		}).done(function (data) {
			slider.html(data);
			closer.addClass('active');
			slider.addClass('active');
			ajax_loading = false;
		});

		return false;
	});

	closer.on('click', function() {
		closer.removeClass('active');
		slider.removeClass('active');
		return false;
	});
}

function init_configuration_alert() {
	$(window).on('submit', function(e) {
		window.hasSubmit = true;
	});
	$(window).on('beforeunload', function(e) {
		if (window.hasSubmit) {
			return;
		}
		var fields = $("[data-leave-validation]");
		for (var i = 0; i < fields.length; i++) {
			if ($(fields[i]).attr('type') === 'checkbox' || $(fields[i]).attr('type') === 'radio') {
				// The use of != is done on purpose to check boolean against integer
				if ($(fields[i]).is(':checked') != $(fields[i]).attr('data-leave-validation')) {
					return false;
				}
			} else {
				if ($(fields[i]).attr('data-leave-validation') !== $(fields[i]).val()) {
					return false;
				}
			}
		}
		return;
	});
}

function init_subscription() {
	$('body').on('click', '.bookmarkClick', function (e) {
		return false;
	});
}

function parseJsonVars() {
	var jsonVars = document.getElementById('jsonVars'),
		json = JSON.parse(jsonVars.innerHTML);
	jsonVars.outerHTML = '';
	window.context = json.context;
	window.shortcuts = json.shortcuts;
	window.url = json.url;
	window.i18n = json.i18n;
	window.icons = json.icons;
}

function init_normal() {
	$stream = $('#stream');
	if ($stream.length < 1) {
		if (window.console) {
			console.log('FreshRSS waiting for content…');
		}
		window.setTimeout(init_normal, 100);
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
		window.setTimeout(init_beforeDOM, 100);
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
		window.setTimeout(init_afterDOM, 100);
		return;
	}
	init_notifications();
	init_confirm_action();
	init_dropdown_handler();
	$stream = $('#stream');
	if ($stream.length > 0) {
		init_load_more($stream);
		init_sticky_sidebar();
		init_posts();
		init_nav_entries();
		init_dynamic_tags();
		init_print_action();
		init_post_action();
		init_notifs_html5();
		window.setInterval(refreshUnreads, 120000);
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

parseJsonVars();
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
