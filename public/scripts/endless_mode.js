var url_load_more = "";
var load_more = false;

function init_load_more() {
	url_load_more = $("a#load_more").attr("href");
	
	$("#load_more").click (function () {
		load_more_posts ();
		
		return false;
	});
}

function load_more_posts () {
	if(load_more == true) {
		return;
	}

	load_more = true;
	$("#load_more").addClass("loading");
	$.get (url_load_more, function (data) {
		$("#stream .flux:last").after($("#stream .flux", data));
		$(".pagination").html($(".pagination", data).html());
		
		init_load_more();
		init_posts();
		
		$("#load_more").removeClass("loading");
		load_more = false;
	});
}

$(document).ready (function () {
	init_load_more();
});