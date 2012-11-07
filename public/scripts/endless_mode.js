var url = "";

function load_more_posts () {
	$.get (url, function (data) {
		$("#load_more").before ($("#stream .post", data));
		
		url = $(".pagination:last li.pager-next a", data).attr ("href");
		if (url === undefined) {
			$("#load_more").html ("Il n'y a plus rien à charger");
			$("#load_more").addClass ("disable");
		}
		
		init_posts ();
	});
}

$(document).ready (function () {
	url = $(".pagination:last li.pager-next a").attr ("href");
	$(".pagination:last").remove ();
	
	$("#stream").append ("<a id=\"load_more\" href=\"#\">Charger plus d'articles</a>");
	
	$("#load_more").click (function () {
		load_more_posts ();
		
		return false;
	});
});
