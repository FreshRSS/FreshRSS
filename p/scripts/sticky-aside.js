window.onscroll = function() {addSticky()};
$(document).ready(function() {recalc()});


var sidebar = document.getElementById("sidebar");
var sticky = sidebar.offsetTop;
var nav_visible = $(".nav_menu .toggle_aside").css("display");

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
	if(nav_visible == 'none'){
		$('#sidebar').height($(window).height() - $('#sidebar')[0].getBoundingClientRect().top);
	} else {
		$('#sidebar').height($(window).height() - $('#sidebar')[0].getBoundingClientRect().top - $('#nav_entries').height());
	}
}