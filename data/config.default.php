<?php

# Do not modify this file, which is only a template.
# See `config.php` after the install process is completed.
return array(

	# Set to `development` to get additional error messages,
	#	or to `production` to get only the most important messages.
	'environment' => 'production',

	# Used to make crypto more unique. Generated during install.
	'salt' => '',

	# Specify address of the FreshRSS instance,
	# used when building absolute URLs, e.g. for PubSubHubbub.
	# Examples:
	# https://example.net/FreshRSS/p/
	# https://freshrss.example.net/
	'base_url' => '',

	# Natural language of the user interface, e.g. `en`, `fr`.
	'language' => 'en',

	# Title of this FreshRSS instance in the Web user interface.
	'title' => 'FreshRSS',

	# Name of the user that has administration rights.
	'default_user' => '_',

	# Allow or not visitors without login to see the articles
	#	of the default user.
	'allow_anonymous' => false,

	# Allow or not anonymous users to start the refresh process.
	'allow_anonymous_refresh' => false,

	# Login method:
	#	`none` is without password and shows only the default user;
	#	`form` is a conventional Web login form;
	#	`persona` is the email-based login by Mozilla;
	#	`http_auth` is an access controled by the HTTP Web server (e.g. `/FreshRSS/p/i/.htaccess` for Apache)
	#		if you use `http_auth`, remember to protect only `/FreshRSS/p/i/`,
	#		and in particular not protect `/FreshRSS/p/api/` if you would like to use the API (different login system).
	'auth_type' => 'none',

	# Allow or not the use of the API, used for mobile apps.
	#	End-point is http://example.net/FreshRSS/p/api/greader.php
	#	You need to set the user's API password.
	'api_enabled' => false,

	# Allow or not the use of an unsafe login,
	#	by providing username and password in the login URL:
	#	http://example.net/FreshRSS/p/i/?c=auth&a=login&u=alice&p=1234
	'unsafe_autologin_enabled' => false,

	# Enable or not the use of syslog to log the activity of
	#	SimplePie, which is retrieving RSS feeds via HTTP requests.
	'simplepie_syslog_enabled' => true,

	'limits' => array(

		# Duration in seconds of the SimplePie cache,
		#	during which a query to the RSS feed will return the local cached version.
		# Especially important for multi-user setups.
		'cache_duration' => 800,

		# SimplePie HTTP request timeout in seconds.
		'timeout' => 10,

		# If a user has not used FreshRSS for more than x seconds,
		#	then its feeds are not refreshed anymore.
		'max_inactivity' => PHP_INT_MAX,

		# Max number of feeds for a user.
		'max_feeds' => 16384,

		# Max number of categories for a user.
		'max_categories' => 16384,

	),

	'db' => array(

		# Type of database: `sqlite` or `mysql`.
		'type' => 'sqlite',

		# MySQL host.
		'host' => '',

		# MySQL user.
		'user' => '',

		# MySQL password.
		'password' => '',

		# MySQL database.
		'base' => '',

		# MySQL table prefix.
		'prefix' => '',

	),

	# List of enabled FreshRSS extensions.
	'extensions_enabled' => array(),
);
