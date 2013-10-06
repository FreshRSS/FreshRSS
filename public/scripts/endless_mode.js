var url_load_more = "";
var load_more = false;
var container = null;

function init_load_more(block) {
	var next_link = $("a#load_more")
	if (!next_link.length) {
		// no more article to load
		url_load_more = "";
		return;
	}

	url_load_more = next_link.attr("href");
	container = block;

	$("#load_more").click (function () {
		load_more_posts ();

		return false;
	});
}

function load_more_posts () {
	if(load_more == true || url_load_more == "") {
		return;
	}

	load_more = true;
	$("#load_more").addClass("loading");
	$.get (url_load_more, function (data) {
		container.children(".flux:last").after($("#stream .flux", data));
		$(".pagination").html($(".pagination", data).html());

		init_load_more(container);
		init_posts();
		
		$("#load_more").removeClass("loading");
		load_more = false;
	});
}

$(document).ready (function () {
	init_load_more($("#stream"));
});