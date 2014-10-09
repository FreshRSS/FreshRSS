"use strict";
var panel_loading = false;

function load_panel(link) {
	if (panel_loading) {
		return;
	}

	panel_loading = true;

	$.get(link, function (data) {
		$("#panel").append($(".nav_menu, #stream .day, #stream .flux, #stream .pagination", data));

		$("#panel .nav_menu").children().not("#nav_menu_read_all").remove();

		init_load_more($("#panel"));
		init_posts();

		$("#overlay").fadeIn();
		$("#panel").slideToggle();

		// force le démarrage du scroll en haut.
		// Sans ça, si l'on scroll en lisant une catégorie par exemple,
		// en en ouvrant une autre ensuite, on se retrouve au même point de scroll
		$("#panel").scrollTop(0);

		$('#panel').on('click', '#nav_menu_read_all > a, #nav_menu_read_all .item > a, #bigMarkAsRead', function () {
			$.ajax({
				url: $(this).attr("href"),
				async: false
			});
			//$("#panel .close").first().click();
			window.location.reload(false);
			return false;
		});

		panel_loading = false;
	});
}

function init_close_panel() {
	$("#panel .close").click(function () {
		$("#panel").html('<a class="close" href="#">' + window.iconClose + '</a>');
		init_close_panel();
		$("#panel").slideToggle();
		$("#overlay").fadeOut();

		return false;
	});
}

function init_global_view() {
	$("#stream .box-category a").click(function () {
		var link = $(this).attr("href");

		load_panel(link);

		return false;
	});

	$(".nav_menu #nav_menu_read_all, .nav_menu .toggle_aside").remove();

	init_stream($("#panel"));
}

function init_all_global_view() {
	if (!(window.$ && window.init_stream)) {
		if (window.console) {
			console.log('FreshRSS Global view waiting for JS…');
		}
		window.setTimeout(init_all_global_view, 50);	//Wait for all js to be loaded
		return;
	}
	init_global_view();
	init_close_panel();
}

if (document.readyState && document.readyState !== 'loading') {
	init_all_global_view();
} else if (document.addEventListener) {
	document.addEventListener('DOMContentLoaded', function () {
		init_all_global_view();
	}, false);
}
