var read_mode_on = false;
var scroll_auto = false;

function read_mode () {
	read_mode_on = true;
	
	// global
	$('#global').css({
		'background': '#ddd'
	});
	$('#main_aside').animate ({width: 0}, 500, function () {
		$('#main_aside').hide ();
	});
	$('#top').animate ({height: 0}, 500, function () {
		$('#top').hide ();
	});
	$('#main').animate({
		'width': 800,
		'padding-left': ($(window).width() - 800) / 2,
	});
	$('#main').css({
		'background': '#ddd'
	});
	$('#stream').addClass ('read_mode');
	$('ul.pagination').fadeOut (500);
	
	// posts
	$('.post.flux .content').slideDown (500);
	
	// mode endless auto
	scroll_auto = true;
	$(window).scroll (function () {
		offset = $('#load_more').offset ();
		
		if (offset.top - $(window).height () <= $(window).scrollTop ()
		 && !load
		 && url_next_page !== undefined
		 && scroll_auto) {
			load_more_posts ();
		}
	});
}
function un_read_mode () {
	read_mode_on = false;
	
	// global
	$('#global').css({
		'background': '#fafafa'
	});
	$('#main_aside').show ();
	$('#main_aside').animate ({width: 250});
	$('#top').show ();
	$('#top').animate ({height: 50});
	$('#main').animate({
		'width': '100%',
		'padding-left': 250,
	});
	$('#main').css({
		'background': '#fafafa'
	});
	$('#stream').removeClass ('read_mode');
	$('ul.pagination').fadeIn (500);
	
	// posts
	if (hide_posts) {
		$('.post.flux .content').slideUp (500);
	}
	
	// mode endless auto desactivé
	scroll_auto = false;
}

$(document).ready (function () {
	$('#global').append ('<a id="read_mode" href="#">&nbsp;</a>');
	
	$('a#read_mode').click (function () {
		if (read_mode_on) {
			un_read_mode ();
		} else {
			read_mode ();
		}
		
		return false;
	});
});
