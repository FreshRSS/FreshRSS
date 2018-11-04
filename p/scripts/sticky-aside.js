window.onscroll = function() {addSticky()};
$(document).ready(function() {recalc()});


var sidebar = document.getElementById("sidebar");
var sticky = sidebar.offsetTop;

function addSticky() {
	if (window.pageYOffset >= sticky) {
		sidebar.classList.add("sticky");
		recalc();
	} else {
		sidebar.classList.remove("sticky");
		recalc();
	}
}

function recalc() {
	$('#sidebar').width($('#sidebar').parent().width());
	$('#sidebar').height($(window).height() - $('#sidebar').getBoundingClientRect().top - $('#nav_entries').height());
}