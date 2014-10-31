"use strict";

function init_persona() {
	if (!(navigator.id && window.$)) {
		if (window.console) {
			console.log('FreshRSS (Persona) waiting for JS…');
		}
		window.setTimeout(init_persona, 100);
		return;
	}

	$('a.signin').click(function() {
		navigator.id.request();
		return false;
	});

	$('a.signout').click(function() {
		navigator.id.logout();
		return false;
	});

	navigator.id.watch({
		loggedInUser: context['current_user_mail'],

		onlogin: function(assertion) {
			// A user has logged in! Here you need to:
			// 1. Send the assertion to your backend for verification and to create a session.
			// 2. Update your UI.
			$.ajax ({
				type: 'POST',
				url: url['login'],
				data: {assertion: assertion},
				success: function(res, status, xhr) {
					if (res.status === 'failure') {
						openNotification(res.reason, 'bad');
					} else if (res.status === 'okay') {
						location.href = url['index'];
					}
				},
				error: function(res, status, xhr) {
					// alert(res);
				}
			});
		},
		onlogout: function() {
			// A user has logged out! Here you need to:
			// Tear down the user's session by redirecting the user or making a call to your backend.
			// Also, make sure loggedInUser will get set to null on the next page load.
			// (That's a literal JavaScript null. Not false, 0, or undefined. null.)
			$.ajax ({
				type: 'POST',
				url: url['logout'],
				success: function(res, status, xhr) {
					location.href = url['index'];
				},
				error: function(res, status, xhr) {
					// alert(res);
				}
			});
		}
	});
}

if (document.readyState && document.readyState !== 'loading') {
	if (window.console) {
		console.log('FreshRSS (Persona) immediate init…');
	}
	init_persona();
} else if (document.addEventListener) {
	document.addEventListener('DOMContentLoaded', function () {
		if (window.console) {
			console.log('FreshRSS (Persona) waiting for DOMContentLoaded…');
		}
		init_persona();
	}, false);
}
