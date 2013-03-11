function closeNotification () {
	$(".notification").slideUp (200, function () {
		$(".notification").remove ();
	});
}

$(document).ready (function () {
	notif = $(".notification");
	if (notif[0] !== undefined) {
		timer = setInterval('closeNotification()', 5000);
		
		notif.find ("a.close").click (function () {
			closeNotification ();
			return false;
		});
	}
});
