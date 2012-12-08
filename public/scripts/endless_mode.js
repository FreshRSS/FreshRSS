var url_next_page = "";
var load = false;

function load_more_refresh () {
	if (url_next_page === undefined) {
		$("#load_more").html ("Il n'y a rien à charger");
		$("#load_more").addClass ("disable");
	} else {
		$("#load_more").html ("Charger plus d'articles");
	}
}

function load_more_posts (f_callback) {
	load = true;
	$.get (url_next_page, function (data) {
		$("#load_more").before ($("#stream .post", data));
		
		url_next_page = $(".pagination:last li.pager-next a", data).attr ("href");
		
		init_posts ();
		load_more_refresh ();
		if (typeof f_callback == 'function') {
			f_callback.call (this);
		}
		load = false;
	});
}

$(document).ready (function () {
	url_next_page = $(".pagination:last li.pager-next a").attr ("href");
	$(".pagination:last").remove ();
	
	$("#stream").append ("<a id=\"load_more\" href=\"#\"></a>");
	load_more_refresh ();
	
	$("#load_more").click (function () {
		load_more_posts ();
		
		return false;
	});
});
