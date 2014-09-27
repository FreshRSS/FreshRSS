"use strict";
var $stream = null,
	isCollapsed = true,
	shares = 0,
	ajax_loading = false;

function is_normal_mode() {
	return $stream.hasClass('normal');
}

function is_global_mode() {
	return $stream.hasClass('global');
}

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
	if (str == '' || str === undefined) {
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
	return i > 0
		? ((spaceAfter ? '' : ' ') + '(' + numberFormat(i) + ')' + (spaceAfter ? ' ' : ''))
		: '';
}

function incUnreadsFeed(article, feed_id, nb) {
	//Update unread: feed
	var elem = $('#' + feed_id + '>.feed').get(0),
		feed_unreads = elem ? str2int(elem.getAttribute('data-unread')) : 0,
		feed_priority = elem ? str2int(elem.getAttribute('data-priority')) : 0;
	if (elem) {
		elem.setAttribute('data-unread', numberFormat(feed_unreads + nb));
		elem = $(elem).closest('li').get(0);
		if (elem) {
			elem.setAttribute('data-unread', feed_unreads + nb);
		}
	}

	//Update unread: category
	elem = $('#' + feed_id).parent().prevAll('.category').children(':first').get(0);
	feed_unreads = elem ? str2int(elem.getAttribute('data-unread')) : 0;
	if (elem) {
		elem.setAttribute('data-unread', numberFormat(feed_unreads + nb));
		elem = $(elem).closest('li').get(0);
		if (elem) {
			elem.setAttribute('data-unread', feed_unreads + nb);
		}
	}

	//Update unread: all
	if (feed_priority > 0) {
		elem = $('#aside_flux .all').children(':first').get(0);
		if (elem) {
			feed_unreads = elem ? str2int(elem.getAttribute('data-unread')) : 0;
			elem.setAttribute('data-unread', numberFormat(feed_unreads + nb));
		}
	}

	//Update unread: favourites
	if (article && article.closest('div').hasClass('favorite')) {
		elem = $('#aside_flux .favorites').children(':first').get(0);
		if (elem) {
			feed_unreads = elem ? str2int(elem.getAttribute('data-unread')) : 0;
			elem.setAttribute('data-unread', numberFormat(feed_unreads + nb));
		}
	}

	var isCurrentView = false;
	//Update unread: title
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

var pending_feeds = [];
function mark_read(active, only_not_read) {
	if (active.length === 0 ||
		(only_not_read === true && !active.hasClass("not_read"))) {
		return false;
	}

	var url = active.find("a.read").attr("href");
	if (url === undefined) {
		return false;
	}

	var feed_url = active.find(".website>a").attr("href"),
		feed_id = feed_url.substr(feed_url.lastIndexOf('f_')),
		index_pending = pending_feeds.indexOf(feed_id);

	if (index_pending !== -1) {
		return false;
	}

	pending_feeds.push(feed_id);

	$.ajax({
		type: 'POST',
		url: url,
		data : { ajax: true }
	}).done(function (data) {
		var $r = active.find("a.read").attr("href", data.url),
			inc = 0;
		if (active.hasClass("not_read")) {
			active.removeClass("not_read");
			inc--;
		} else if (only_not_read !== true || active.hasClass("not_read")) {
			active.addClass("not_read");
			inc++;
		}
		$r.find('.icon').replaceWith(data.icon);

		incUnreadsFeed(active, feed_id, inc);
		faviconNbUnread();

		pending_feeds.splice(index_pending, 1);
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

	var feed_url = active.find(".website>a").attr("href"),
		feed_id = feed_url.substr(feed_url.lastIndexOf('f_')),
		index_pending = pending_feeds.indexOf(feed_id);

	if (index_pending !== -1) {
		return false;
	}

	pending_feeds.push(feed_id);

	$.ajax({
		type: 'POST',
		url: url,
		data : { ajax: true }
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

		var favourites = $('.favorites>a').contents().last().get(0);
		if (favourites && favourites.textContent) {
			favourites.textContent = favourites.textContent.replace(/((?: \([ 0-9]+\))?\s*)$/, function (m, p1) {
				return incLabel(p1, inc, false);
			});
		}

		if (active.closest('div').hasClass('not_read')) {
			var elem = $('#aside_flux .favorites').children(':first').get(0),
				feed_unreads = elem ? str2int(elem.getAttribute('data-unread')) : 0;
			if (elem) {
				elem.setAttribute('data-unread', numberFormat(feed_unreads + inc));
			}
		}

		pending_feeds.splice(index_pending, 1);
	});
}

function toggleContent(new_active, old_active) {
	if (new_active.length === 0) {
		return;
	}

	if (does_lazyload) {
		new_active.find('img[data-original], iframe[data-original]').each(function () {
			this.setAttribute('src', this.getAttribute('data-original'));
			this.removeAttribute('data-original');
		});
	}

	if (old_active[0] !== new_active[0]) {
		if (isCollapsed) {
			new_active.addClass("active");
		}
		old_active.removeClass("active current");
		new_active.addClass("current");
	} else {
		new_active.toggleClass('active');
	}

	var box_to_move = "html,body",
		relative_move = false;
	if (is_global_mode()) {
		box_to_move = "#panel";
		relative_move = true;
	}

	if (sticky_post) {
		var prev_article = new_active.prevAll('.flux'),
		    new_pos = new_active.position().top,
			old_scroll = $(box_to_move).scrollTop();

		if (prev_article.length > 0 && new_pos - prev_article.position().top <= 150) {
			new_pos = prev_article.position().top;
		}

		if (hide_posts) {
			if (relative_move) {
				new_pos += old_scroll;
			}

			if (old_active[0] !== new_active[0]) {
				new_active.children(".flux_content").first().each(function () {
					$(box_to_move).scrollTop(new_pos).scrollTop();
				});
			}
		} else {
			if (relative_move) {
				new_pos += old_scroll;
			}

			$(box_to_move).scrollTop(new_pos).scrollTop();
		}
	}

	if (auto_mark_article && new_active.hasClass('active')) {
		mark_read(new_active, true);
	}
}

function prev_entry() {
	var old_active = $(".flux.current"),
		new_active = old_active.length === 0 ? $(".flux:last") : old_active.prevAll(".flux:first");
	toggleContent(new_active, old_active);
}

function next_entry() {
	var old_active = $(".flux.current"),
		new_active = old_active.length === 0 ? $(".flux:first") : old_active.nextAll(".flux:first");
	toggleContent(new_active, old_active);

	if (new_active.nextAll().length < 3) {
		load_more_posts();
	}
}

function prev_feed() {
	var active_feed = $("#aside_flux .feeds li.active");
	if (active_feed.length > 0) {
		active_feed.prevAll(':visible:first').find('a.feed').each(function(){this.click();});
	} else {
		last_feed();
	}
}

function next_feed() {
	var active_feed = $("#aside_flux .feeds li.active");
	if (active_feed.length > 0) {
		active_feed.nextAll(':visible:first').find('a.feed').each(function(){this.click();});
	} else {
		first_feed();
	}
}

function first_feed() {
	var feed = $("#aside_flux .feeds.active li:visible:first");
	if (feed.length > 0) {
		feed.find('a')[1].click();
	}
}

function last_feed() {
	var feed = $("#aside_flux .feeds.active li:visible:last");
	if (feed.length > 0) {
		feed.find('a')[1].click();
	}
}

function prev_category() {
	var active_cat = $("#aside_flux .category.stick.active");

	if (active_cat.length > 0) {
		var prev_cat = active_cat.parent('li').prevAll(':visible:first').find('.category.stick a.btn');
		if (prev_cat.length > 0) {
			prev_cat[0].click();
		}
	} else {
		last_category();
	}
	return;
}

function next_category() {
	var active_cat = $("#aside_flux .category.stick.active");

	if (active_cat.length > 0) {
		var next_cat = active_cat.parent('li').nextAll(':visible:first').find('.category.stick a.btn');
		if (next_cat.length > 0) {
			next_cat[0].click();
		}
	} else {
		first_category();
	}
	return;
}

function first_category() {
	var cat = $("#aside_flux .category.stick:visible:first");
	if (cat.length > 0) {
		cat.find('a.btn')[0].click();
	}
}

function last_category() {
	var cat = $("#aside_flux .category.stick:visible:last");
	if (cat.length > 0) {
		cat.find('a.btn')[0].click();
	}
}

function collapse_entry() {
	isCollapsed = !isCollapsed;

	var flux_current = $(".flux.current");
	flux_current.toggleClass("active");
	if (isCollapsed && auto_mark_article) {
		mark_read(flux_current, true);
	}
}

function user_filter(key) {
	console.log('user filter');
	console.warn(key);
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

function inMarkViewport(flux, box_to_follow, relative_follow) {
	var top = flux.position().top;
	if (relative_follow) {
		top += box_to_follow.scrollTop();
	}
	var height = flux.height(),
		begin = top + 3 * height / 4,
		bot = Math.min(begin + 75, top + height),
		windowTop = box_to_follow.scrollTop(),
		windowBot = windowTop + box_to_follow.height() / 2;

	return (windowBot >= begin && bot >= windowBot);
}

function init_posts() {
	var box_to_follow = $(window),
		relative_follow = false;
	if (is_global_mode()) {
		box_to_follow = $("#panel");
		relative_follow = true;
	}

	if (auto_mark_scroll) {
		box_to_follow.scroll(function () {
			$('.not_read:visible').each(function () {
				if ($(this).children(".flux_content").is(':visible') && inMarkViewport($(this), box_to_follow, relative_follow)) {
					mark_read($(this), true);
				}
			});
		});
	}

	if (auto_load_more) {
		box_to_follow.scroll(function () {
			var load_more = $("#load_more");
			if (!load_more.is(':visible')) {
				return;
			}
			var boxBot = box_to_follow.scrollTop() + box_to_follow.height(),
				load_more_top = load_more.position().top;
			if (relative_follow) {
				load_more_top += box_to_follow.scrollTop();
			}
			if (boxBot >= load_more_top) {
				load_more_posts();
			}
		});
		box_to_follow.scroll();
	}
}

function init_column_categories() {
	if (!is_normal_mode()) {
		return;
	}
	$('#aside_flux').on('click', '.category>a.dropdown-toggle', function () {
		$(this).children().each(function() {
			if (this.alt === '▽') {
				this.src = this.src.replace('/icons/down.', '/icons/up.');
				this.alt = '△';
			} else {
				this.src = this.src.replace('/icons/up.', '/icons/down.');
				this.alt = '▽';
			}
		});
		$(this).parent().next(".feeds").slideToggle();
		return false;
	});
	$('#aside_flux').on('click', '.feeds .dropdown-toggle', function () {
		if ($(this).nextAll('.dropdown-menu').length === 0) {
			var feed_id = $(this).closest('li').attr('id').substr(2),
				feed_web = $(this).data('fweb'),
				template = $('#feed_config_template').html().replace(/!!!!!!/g, feed_id).replace('http://example.net/', feed_web);
			$(this).attr('href', '#dropdown-' + feed_id).prev('.dropdown-target').attr('id', 'dropdown-' + feed_id).parent().append(template);
		}
	});
}

function init_shortcuts() {
	if (!(window.shortcut && window.shortcuts)) {
		if (window.console) {
			console.log('FreshRSS waiting for sortcut.js…');
		}
		window.setTimeout(init_shortcuts, 50);
		return;
	}
	// Touches de manipulation
	shortcut.add(shortcuts.mark_read, function () {
		// on marque comme lu ou non lu
		var active = $(".flux.current");
		mark_read(active, false);
	}, {
		'disable_in_input': true
	});
	shortcut.add("shift+" + shortcuts.mark_read, function () {
		// on marque tout comme lu
		$(".nav_menu .read_all").click();
	}, {
		'disable_in_input': true
	});
	shortcut.add(shortcuts.mark_favorite, function () {
		// on marque comme favori ou non favori
		var active = $(".flux.current");
		mark_favorite(active);
	}, {
		'disable_in_input': true
	});
	shortcut.add(shortcuts.collapse_entry, function () {
		collapse_entry();
	}, {
		'disable_in_input': true
	});
	shortcut.add(shortcuts.auto_share, function () {
		auto_share();
	}, {
		'disable_in_input': true
	});

	shortcut.add(shortcuts.user_filter, function () {
		user_filter();
	}, {
		'disable_in_input': true
	});
	for(var i = 1; i < 10; i++){
		shortcut.add(i.toString(), function (e) {
			if ($('#dropdown-query').siblings('.dropdown-menu').is(':visible')) {
				user_filter(String.fromCharCode(e.keyCode));
			} else {
				auto_share(String.fromCharCode(e.keyCode));
			}
		}, {
			'disable_in_input': true
		});
	}

	// Touches de navigation pour les articles
	shortcut.add(shortcuts.prev_entry, prev_entry, {
		'disable_in_input': true
	});
	shortcut.add(shortcuts.first_entry, function () {
		var old_active = $(".flux.current"),
			first = $(".flux:first");

		if (first.hasClass("flux")) {
			toggleContent(first, old_active);
		}
	}, {
		'disable_in_input': true
	});
	shortcut.add(shortcuts.next_entry, next_entry, {
		'disable_in_input': true
	});
	shortcut.add(shortcuts.last_entry, function () {
		var old_active = $(".flux.current"),
			last = $(".flux:last");

		if (last.hasClass("flux")) {
			toggleContent(last, old_active);
		}
	}, {
		'disable_in_input': true
	});
	// Touches de navigation pour les flux
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
	// Touches de navigation pour les categories
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
		var url_website = $('.flux.current > .flux_header > .title > a').attr("href");

		if (auto_mark_site) {
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
		redirect(help_url, true);
	}, {
		'disable_in_input': true
	});

}

function init_stream(divStream) {
	divStream.on('click', '.flux_header,.flux_content', function (e) {	//flux_toggle
		if ($(e.target).closest('.content, .item.website, .item.link').length > 0) {
			return;
		}
		var old_active = $(".flux.current"),
			new_active = $(this).parent();
			isCollapsed = true;
		if (e.target.tagName.toUpperCase() === 'A') {	//Leave real links alone
			if (auto_mark_article) {
				mark_read(new_active, true);
			}
			return true;
		}
		toggleContent(new_active, old_active);
	});

	divStream.on('click', '.flux a.read', function () {
		var active = $(this).parents(".flux");
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
			var e = jQuery.Event("click");
			e.ctrlKey = true;
			$(this).trigger(e);
		} else if(e.which == 1) {
			// Normal click, just toggle article.
			$(this).parent().click();
		}
	});

	divStream.on('click', '.flux .content a', function () {
		$(this).attr('target', '_blank');
	});

	if (auto_mark_site) {
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

function init_nav_entries() {
	var $nav_entries = $('#nav_entries');
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
			item_top = active_item.position().top;

		if (windowTop > item_top) {
			$("html,body").scrollTop(item_top);
		} else {
			$("html,body").scrollTop(0);
		}
		return false;
	});
}

function init_actualize() {
	var auto = false;

	$("#actualize").click(function () {
		if (ajax_loading) {
			return false;
		}

		ajax_loading = true;

		$.getScript('./?c=javascript&a=actualize').done(function () {
			if (auto && feed_count < 1) {
				auto = false;
				ajax_loading = false;
				return false;
			}

			updateFeeds();
		});

		return false;
	});

	if (auto_actualize_feeds) {
		auto = true;
		$("#actualize").click();
	}
}


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
		return
	}

	var notification = new window.Notification(str_notif_title_articles, {
		icon: "../themes/icons/favicon-256.png",
		body: str_notif_body_articles.replace("\d", nb),
		tag: "freshRssNewArticles"
	});

	notification.onclick = function() {
		window.location.reload();
	}

	if (html5_notif_timeout !== 0){
		setTimeout(function() {
					notification.close();
				}, html5_notif_timeout * 1000);
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
		var isAll = $('.category.all > .active').length > 0,
		    new_articles = false;

		$.each(data, function(feed_id, nbUnreads) {
			feed_id = 'f_' + feed_id;
			var elem = $('#' + feed_id + '>.feed').get(0),
				feed_unreads = elem ? str2int(elem.getAttribute('data-unread')) : 0;

			if ((incUnreadsFeed(null, feed_id, nbUnreads - feed_unreads) || isAll) &&	//Update of current view?
				(nbUnreads - feed_unreads > 0)) {
				$('#new-article').show();
				new_articles = true;
			};
		});

		var nb_unreads = str2int($('.category.all>a').attr('data-unread'));

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
		if (display_order === 'ASC') {
			$('#nav_menu_read_all > .read_all').attr(
				'formaction', $('#bigMarkAsRead').attr('formaction')
			);
		} else {
			$('#bigMarkAsRead').attr(
				'formaction', $('#nav_menu_read_all > .read_all').attr('formaction')
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
		load_more = false;
	});
}

function focus_search() {
	$('#search').focus();
}

function init_load_more(box) {
	box_load_more = box;

	if (!does_lazyload) {
		$('img[postpone], audio[postpone], iframe[postpone], video[postpone]').each(function () {
			this.removeAttribute('postpone');
		});
	}

	var $next_link = $("#load_more");
	if (!$next_link.length) {
		// no more article to load
		url_load_more = "";
		return;
	}

	url_load_more = $next_link.attr("href");
	var $prefetch = $('#prefetch');
	if ($prefetch.attr('href') !== url_load_more) {
		$prefetch.attr('rel', 'next');	//Remove prefetch
		$.ajax({url: url_load_more, ifModified: true });	//TODO: Try to find a less agressive solution
		$prefetch.attr('href', url_load_more);
	}

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
			if (data.salt1 == '' || data.nonce == '') {
				openNotification('Invalid user!', 'bad');
			} else {
				try {
					var strong = window.Uint32Array && window.crypto && (typeof window.crypto.getRandomValues === 'function'),
						s = dcodeIO.bcrypt.hashSync($('#passwordPlain').val(), data.salt1),
						c = dcodeIO.bcrypt.hashSync(data.nonce + s, strong ? 4 : poormanSalt());
					$('#challenge').val(c);
					if (s == '' || c == '') {
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

//<persona>
function init_persona() {
	if (!(navigator.id)) {
		if (window.console) {
			console.log('FreshRSS waiting for Persona…');
		}
		window.setTimeout(init_persona, 100);
		return;
	}
	$('a.signin').click(function() {
		navigator.id.request();
		return false;
	});

	$('a.signout').click(function() {
		navigator.id.logout();
		return false;
	});

	navigator.id.watch({
		loggedInUser: current_user_mail,

		onlogin: function(assertion) {
			// A user has logged in! Here you need to:
			// 1. Send the assertion to your backend for verification and to create a session.
			// 2. Update your UI.
			$.ajax ({
				type: 'POST',
				url: url_login,
				data: {assertion: assertion},
				success: function(res, status, xhr) {
					/*if (res.status === 'failure') {
						alert (res_obj.reason);
					} else*/ if (res.status === 'okay') {
						location.href = url_freshrss;
					}
				},
				error: function(res, status, xhr) {
					alert("Login failure: " + res);
				}
			});
		},
		onlogout: function() {
			// A user has logged out! Here you need to:
			// Tear down the user's session by redirecting the user or making a call to your backend.
			// Also, make sure loggedInUser will get set to null on the next page load.
			// (That's a literal JavaScript null. Not false, 0, or undefined. null.)
			$.ajax ({
				type: 'POST',
				url: url_logout,
				success: function(res, status, xhr) {
					location.href = url_freshrss;
				},
				error: function(res, status, xhr) {
					//alert("logout failure" + res);
				}
			});
		}
	});
}
//</persona>

function init_confirm_action() {
	$('body').on('click', '.confirm', function () {
		var str_confirmation = $(this).attr('data-str-confirm');
		if (!str_confirmation) {
			str_confirmation = str_confirmation_default;
		}

		return confirm(str_confirmation);
	});
}

function init_print_action() {
	$('.item.share > a[href="#"]').click(function () {
		var content = "<html><head><style>"
			+ "body { font-family: Serif; text-align: justify; }"
			+ "a { color: #000; text-decoration: none; }"
			+ "a:after { content: ' [' attr(href) ']'}"
			+ "</style></head><body>"
			+ $(".flux.current .content").html()
			+ "</body></html>";

		var tmp_window = window.open();
		tmp_window.document.writeln(content);
		tmp_window.document.close();
		tmp_window.focus();
		tmp_window.print();
		tmp_window.close();

		return false;
	});
}

function init_share_observers() {
	shares = $('.form-group:not(".form-actions")').length;

	$('.share.add').on('click', function(e) {
		var opt = $(this).siblings('select').find(':selected');
		var row = $(this).parents('form').data(opt.data('form'));
		row = row.replace('##label##', opt.html(), 'g');
		row = row.replace('##type##', opt.val(), 'g');
		row = row.replace('##help##', opt.data('help'), 'g');
		row = row.replace('##key##', shares, 'g');
		$(this).parents('.form-group').before(row);
		shares++;

		return false;
	});
}

function init_stats_observers() {
	$('#feed_select').on('change', function(e) {
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
			detail.show();
			detail.find('input').focus();
		} else {
			detail.hide();
		}
	});
}

function init_password_observers() {
	$('input[type="password"] + a.btn.toggle-password').on('click', function(e) {
		var button = $(this);
		var passwordField = $(this).siblings('input[type="password"]');

		passwordField.attr('type', 'text');
		button.addClass('active');

		setTimeout(function() {
			passwordField.attr('type', 'password');
			button.removeClass('active');
		}, 2000);

		return false;
	});
}

function faviconNbUnread(n) {
	if (typeof n === 'undefined') {
		n = str2int($('.category.all>a').attr('data-unread'));
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

function init_all() {
	if (!(window.$ && window.url_freshrss)) {
		if (window.console) {
			console.log('FreshRSS waiting for JS…');
		}
		window.setTimeout(init_all, 50);
		return;
	}
	init_notifications();
	switch (authType) {
		case 'persona':
			init_persona();
			break;
	}
	init_confirm_action();
	$stream = $('#stream');
	if ($stream.length > 0) {
		init_actualize();
		init_column_categories();
		init_load_more($stream);
		init_posts();
		init_stream($stream);
		init_nav_entries();
		init_shortcuts();
		faviconNbUnread();
		init_print_action();
		init_notifs_html5();
		window.setInterval(refreshUnreads, 120000);
	} else {
		init_crypto_form();
		init_share_observers();
		init_remove_observers();
		init_feed_observers();
		init_password_observers();
		init_stats_observers();
	}

	if (window.console) {
		console.log('FreshRSS init done.');
	}
}

if (document.readyState && document.readyState !== 'loading') {
	if (window.console) {
		console.log('FreshRSS immediate init…');
	}
	init_all();
} else if (document.addEventListener) {
	document.addEventListener('DOMContentLoaded', function () {
		if (window.console) {
			console.log('FreshRSS waiting for DOMContentLoaded…');
		}
		init_all();
	}, false);
}
