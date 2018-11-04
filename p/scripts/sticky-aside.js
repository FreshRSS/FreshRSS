window.onscroll = function() {addSticky()};
$(document).ready(function() {recalc()});


var sidebar = document.getElementById("sidebar");
var sticky = sidebar.offsetTop;

function addSticky() {
	if (window.pageYOffset >= sticky) {
		sidebar.classList.add("sticky")
	} else {
		sidebar.classList.remove("sticky");
	}
}

function recalc() {
	$('#sidebar').width($('#sidebar').parent().width());
	$('#sidebar').height($(window).height() - $('#sidebar').offset().top - $('#nav_entries').height());
}