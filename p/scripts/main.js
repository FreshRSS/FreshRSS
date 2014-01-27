"use strict";
var $stream = null,
	isCollapsed = true;

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

function numberFormat(nStr) {
	// Thx to http://www.mredkj.com/javascript/numberFormat.html
	nStr += '';
	var x = nStr.split('.');
	var x1 = x[0];
	var x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + " " + '$2');
	}
	return x1 + x2;
}

function incLabel(p, inc) {
	var i = (parseInt(p.replace(/\D/g, ''), 10) || 0) + inc;
	return i > 0 ? ' (' + numberFormat(i) + ')' : '';
}

function incUnreadsFeed(article, feed_id, nb) {
	
	//Update unread: feed
	var elem = $('#' + feed_id + '>.feed').get(0),
		feed_unreads = elem ? (parseInt(elem.getAttribute('data-unread').replace(' ', ''), 10) || 0) : 0,
		feed_priority = elem ? (parseInt(elem.getAttribute('data-priority'), 10) || 0) : 0;
	if (elem) {
		elem.setAttribute('data-unread', numberFormat(Math.max(0, feed_unreads + nb)));
	}

	//Update unread: category
	elem = $('#' + feed_id).parent().prevAll('.category').children(':first').get(0);
	feed_unreads = elem ? (parseInt(elem.getAttribute('data-unread').replace(' ', ''), 10) || 0) : 0;
	if (elem) {
		elem.setAttribute('data-unread', numberFormat(Math.max(0, feed_unreads + nb)));
	}

	//Update unread: all
	if (feed_priority > 0) {
		elem = $('#aside_flux .all').children(':first').get(0);
		if (elem) {
			feed_unreads = elem ? (parseInt(elem.getAttribute('data-unread').replace(' ', ''), 10) || 0) : 0;
			elem.setAttribute('data-unread', numberFormat(Math.max(0, feed_unreads + nb)));
		}
	}

	//Update unread: favourites
	if (article && article.closest('div').hasClass('favorite')) {
		elem = $('#aside_flux .favorites').children(':first').get(0);
		if (elem) {
			feed_unreads = elem ? (parseInt(elem.getAttribute('data-unread').replace(' ', ''), 10) || 0) : 0;
			elem.setAttribute('data-unread', numberFormat(Math.max(0, feed_unreads + nb)));
		}
	}

	var isCurrentView = false;
	//Update unread: title
	document.title = document.title.replace(/((?: \(\d+\))?)( · .*?)((?: \(\d+\))?)$/, function (m, p1, p2, p3) {
		var $feed = $('#' + feed_id);
		if (article || ($feed.closest('.active').length > 0 && $feed.siblings('.active').length === 0)) {
			isCurrentView = true;
			return incLabel(p1, nb) + p2 + incLabel(p3, feed_priority > 0 ? nb : 0);
		} else {
			return p1 + p2 + incLabel(p3, feed_priority > 0 ? nb : 0);
		}
	});
	return isCurrentView;
}

function mark_read(active, only_not_read) {
	if (active.length === 0 || (only_not_read === true && !active.hasClass("not_read"))) {
		return false;
	}

	var url = active.find("a.read").attr("href");
	if (url === undefined) {
		return false;
	}

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

		var feed_url = active.find(".website>a").attr("href"),
			feed_id = feed_url.substr(feed_url.lastIndexOf('f_'));
		incUnreadsFeed(active, feed_id, inc);
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
			// Without javascript, the text displayed is « Favorites (1544) » where 1544 is the number unformatted.
			// With Javascript, we replace this with « Favorites (1 544) ». To update this, the text is converted
			// to the non-javascript format before.
			favourites.textContent = favourites.textContent.replace(/ /g, '').replace('(', ' (').replace(/((?: \(\d+\))?\s*)$/, function (m, p1) {
				return incLabel(p1, inc);
			});
		}

		if (active.closest('div').hasClass('not_read')) {
			var elem = $('#aside_flux .favorites').children(':first').get(0),
				feed_unreads = elem ? (parseInt(elem.getAttribute('data-unread').replace(' ', ''), 10) || 0) : 0;
			if (elem) {
				elem.setAttribute('data-unread', numberFormat(Math.max(0, feed_unreads + inc)));
			}
		}
	});
}

function toggleContent(new_active, old_active) {
	old_active.removeClass("active").removeClass("current");

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
		new_active.addClass("current");
	}

	var box_to_move = "html,body",
		relative_move = false;
	if (is_global_mode()) {
		box_to_move = "#panel";
		relative_move = true;
	}

	var new_pos = new_active.position().top,
		old_scroll = $(box_to_move).scrollTop();
	if (hide_posts) {

		new_pos = new_active.position().top;
		old_scroll = $(box_to_move).scrollTop();

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

	if (auto_mark_article) {
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

	if (!auto_load_more) {
		var last_active = $(".flux:last");
		if (last_active.attr("id") === new_active.attr("id")) {
			load_more_posts();
		}
	}
}

function collapse_entry() {
	isCollapsed = !isCollapsed;
	$(".flux.current").toggleClass("active");
}

function auto_share() {
	var share = $(".flux.current.active").find('.dropdown-target[id^="dropdown-share"]');
	if (share.length) {
		window.location.hash = share.attr('id');
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

function init_lazyload() {
	if ($.fn.lazyload) {
		if (is_global_mode()) {
			$(".flux_content img").lazyload({
				container: $("#panel")
			});
		} else {
			$(".flux_content img").lazyload();
		}
	}
}

function init_posts() {
	init_lazyload();

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
		var url = $(".nav_menu a.read_all").attr("href");
		redirect(url, false);
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

	// Touches de navigation
	shortcut.add(shortcuts.prev_entry, prev_entry, {
		'disable_in_input': true
	});
	shortcut.add("shift+" + shortcuts.prev_entry, function () {
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
	shortcut.add("shift+" + shortcuts.next_entry, function () {
		var old_active = $(".flux.current"),
			last = $(".flux:last");

		if (last.hasClass("flux")) {
			toggleContent(last, old_active);
		}
	}, {
		'disable_in_input': true
	});
	shortcut.add(shortcuts.go_website, function () {
		var url_website = $(".flux.active .link a").attr("href");

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
}

function init_stream(divStream) {
	divStream.on('click', '.flux_header', function (e) {	//flux_header_toggle
		if ($(e.target).closest('.item.website > a').length > 0) {
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

	divStream.on('click', '.item.title>a', function (e) {
		if (e.ctrlKey) {
			return true;	//Allow default control-click behaviour such as open in backround-tab
		}
		$(this).parent().click();	//Will perform toggle flux_content
		return false;
	});

	divStream.on('click', '.flux .content a', function () {
		$(this).attr('target', '_blank');
	});

	if (auto_mark_site) {
		divStream.on('click', '.flux .link a', function () {
			mark_read($(this).parent().parent().parent(), true);
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
	$("#actualize").click(function () {
		$.getScript('./?c=javascript&a=actualize').done(function () {
			updateFeeds();
		});
		return false;
	});

	if(auto_actualize_feeds) {
		$.getScript('./?c=javascript&a=actualize').done(function () {
			updateFeeds();
		});
	}
}

function closeNotification() {
	$(".notification").fadeOut(600, function () {
		$(".notification").remove();
	});
}

function init_notifications() {
	var notif = $(".notification");
	if (notif.length > 0) {
		window.setInterval(closeNotification, 4000);

		notif.find("a.close").click(function () {
			closeNotification();
			return false;
		});
	}
}

function refreshUnreads() {
	$.getJSON('./?c=javascript&a=nbUnreadsPerFeed').done(function (data) {
		var isAll = $('.category.all > .active').length > 0;
		$.each(data, function(feed_id, nbUnreads) {
			feed_id = 'f_' + feed_id;
			var elem = $('#' + feed_id + '>.feed').get(0),
				feed_unreads = elem ? (parseInt(elem.getAttribute('data-unread').replace(' ', ''), 10) || 0) : 0;
			if ((incUnreadsFeed(null, feed_id, nbUnreads - feed_unreads) || isAll) &&	//Update of current view?
				(nbUnreads - feed_unreads > 0)) {
				$('#new-article').show();
			};
		});
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
		$('#bigMarkAsRead').attr('href', $('#nav_menu_read_all>a').attr('href'));

		$('[id^=day_]').each(function (i) {
			var ids = $('[id="' + this.id + '"]');
			if (ids.length > 1) {
				$('[id="' + this.id + '"]:gt(0)').remove();
			}
		});

		init_load_more(box_load_more);
		init_lazyload();

		$('#load_more').removeClass('loading');
		load_more = false;
	});
}

function init_load_more(box) {
	box_load_more = box;

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

//<Web login form>
function poormanSalt() {	//If crypto.getRandomValues is not available
	var text = '$2a$04$',
		base = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ.0123456789/abcdefghijklmnopqrstuvwxyz';
	for (var i = 22; i > 0; i--) {
		text += base.charAt(Math.floor(Math.random() * 64));
	}
	return text;
}

function init_loginForm() {
	var $loginForm = $('#loginForm');
	if ($loginForm.length === 0) {
		return;
	}
	if (!(window.dcodeIO)) {
		if (window.console) {
			console.log('FreshRSS waiting for bcrypt.js…');
		}
		window.setTimeout(init_loginForm, 100);
		return;
	}
	$loginForm.on('submit', function() {
		$('#loginButton').attr('disabled', '');
		var success = false;
		$.ajax({
			url: './?c=javascript&a=nonce&user=' + $('#username').val(),
			dataType: 'json',
			async: false
		}).done(function (data) {
			if (data.salt1 == '' || data.nonce == '') {
				alert('Invalid user!');
			} else {
				try {
					var strong = window.Uint32Array && window.crypto && (typeof window.crypto.getRandomValues === 'function'),
						s = dcodeIO.bcrypt.hashSync($('#passwordPlain').val(), data.salt1),
						c = dcodeIO.bcrypt.hashSync(data.nonce + s, strong ? 4 : poormanSalt());
					$('#challenge').val(c);
					if (s == '' || c == '') {
					        alert('Crypto error!');
					} else {
					        success = true;
					}
				} catch (e) {
					alert('Crypto exception! ' + e);
				}
			}
		}).fail(function() {
			alert('Communication error!');
		});
		$('#loginButton').removeAttr('disabled');
		return success;
	});
}
//</Web login form>

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
	$('.confirm').click(function () {
		return confirm(str_confirmation);
	});
}

function init_print_action() {
	$('.print-article').click(function () {
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

function init_number_formats() {
	// Init global counter
	var elem = $('#aside_flux .categories li .all a');
	elem.attr('data-unread', numberFormat(elem.attr('data-unread')));
	
	// Init favorites counters
	elem = $('#aside_flux .categories li .favorites a');
	elem.attr('data-unread', numberFormat(elem.attr('data-unread')));
	
	var numFavorites = elem.text().replace(/((?: \(\d+\))?\s*)$/, function (m, p1) {
		return numberFormat(p1)
	});
	elem.text(numFavorites);
	
	// Init feeds counters
	$('#aside_flux .categories li .stick').each(function() {
		// Category-level counter
		elem = $(this).find('a');
		elem.attr('data-unread', numberFormat(elem.attr('data-unread')));
		
		// Feeds counters
		$(this).parent().find('ul.feeds li.item').each(function() {
			elem = $(this).find('a.feed'); // There are two links here. a.feed is the title.
			elem.attr('data-unread', numberFormat(elem.attr('data-unread')));
		});
	});
}

function init_all() {
	if (!(window.$ && window.url_freshrss && ((!full_lazyload) || $.fn.lazyload))) {
		if (window.console) {
			console.log('FreshRSS waiting for JS…');
		}
		window.setTimeout(init_all, 50);
		return;
	}
	init_notifications();
	switch (authType) {
		case 'form':
			init_loginForm();
			break;
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
		init_print_action();
		window.setInterval(refreshUnreads, 120000);
	}
	init_number_formats();
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
