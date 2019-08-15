<?php

# Do not modify this file, which defines default values,
# but edit `./data/config.php` instead, after the install process is completed.
return array(

	# Set to `development` to get additional error messages,
	#	or to `production` to get only the most important messages.
	'environment' => 'production',

	# Used to make crypto more unique. Generated during install.
	'salt' => '',

	# Specify address of the FreshRSS instance,
	# used when building absolute URLs, e.g. for WebSub.
	# Examples:
	# https://example.net/FreshRSS/p/
	# https://freshrss.example.net/
	'base_url' => '',

	# Specify address of the FreshRSS auto-update server.
	'auto_update_url' => 'https://update.freshrss.org',

	# Natural language of the user interface, e.g. `en`, `fr`.
	'language' => 'en',

	# Title of this FreshRSS instance in the Web user interface.
	'title' => 'FreshRSS',

	# Meta description used when `allow_robots` is true.
	'meta_description' => '',

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
	#	`http_auth` is an access controled by the HTTP Web server (e.g. `/FreshRSS/p/i/.htaccess` for Apache)
	#		if you use `http_auth`, remember to protect only `/FreshRSS/p/i/`,
	#		and in particular not protect `/FreshRSS/p/api/` if you would like to use the API (different login system).
	'auth_type' => 'form',

	# Allow or not the use of the API, used for mobile apps.
	#	End-point is https://freshrss.example.net/api/greader.php
	#	You need to set the user's API password.
	'api_enabled' => false,

	# Allow or not the use of an unsafe login,
	#	by providing username and password in the login URL:
	#	http://example.net/FreshRSS/p/i/?c=auth&a=login&u=alice&p=1234
	'unsafe_autologin_enabled' => false,

	# Enable or not the use of syslog to log the activity of
	#	SimplePie, which is retrieving RSS feeds via HTTP requests.
	'simplepie_syslog_enabled' => true,

	# Enable or not support of PubSubHubbub.
	# /!\ It should NOT be enabled if base_url is not reachable by an external server.
	'pubsubhubbub_enabled' => false,

	# Allow or not Web robots (e.g. search engines) in HTML headers.
	'allow_robots' => false,

	# If true does nothing, if false restricts HTTP Referer via: meta referrer origin
	'allow_referrer' => false,

	'limits' => array(

		# Duration in seconds of the login cookie.
		'cookie_duration' => 2592000,

		# Duration in seconds of the SimplePie cache,
		#	during which a query to the RSS feed will return the local cached version.
		# Especially important for multi-user setups.
		'cache_duration' => 800,

		# SimplePie HTTP request timeout in seconds.
		'timeout' => 15,

		# If a user has not used FreshRSS for more than x seconds,
		#	then its feeds are not refreshed anymore.
		'max_inactivity' => PHP_INT_MAX,

		# Max number of feeds for a user.
		'max_feeds' => 16384,

		# Max number of categories for a user.
		'max_categories' => 16384,

		# Max number of accounts that anonymous users can create
		#   0 for an unlimited number of accounts
		#   1 is to not allow user registrations (1 is corresponding to the admin account)
		'max_registrations' => 1,
	),

	# Options used by cURL when making HTTP requests, e.g. when the SimplePie library retrieves feeds.
	# http://php.net/manual/function.curl-setopt
	'curl_options' => array(
		# Options to disable SSL/TLS certificate check (e.g. for self-signed HTTPS)
		//CURLOPT_SSL_VERIFYHOST => 0,
		//CURLOPT_SSL_VERIFYPEER => false,

		# Options to use a proxy for retrieving feeds.
		//CURLOPT_PROXYTYPE => CURLPROXY_HTTP,
		//CURLOPT_PROXY => '127.0.0.1',
		//CURLOPT_PROXYPORT => 8080,
		//CURLOPT_PROXYAUTH => CURLAUTH_BASIC,
		//CURLOPT_PROXYUSERPWD => 'user:password',
	),

	'db' => array(

		# Type of database: `sqlite` or `mysql`.
		'type' => 'sqlite',

		# MySQL host.
		'host' => 'localhost',

		# MySQL user.
		'user' => '',

		# MySQL password.
		'password' => '',

		# MySQL database.
		'base' => '',

		# MySQL table prefix.
		'prefix' => 'freshrss_',

		'pdo_options' => array(
			//PDO::MYSQL_ATTR_SSL_KEY	=> '/path/to/client-key.pem',
			//PDO::MYSQL_ATTR_SSL_CERT	=> '/path/to/client-cert.pem',
			//PDO::MYSQL_ATTR_SSL_CA	=> '/path/to/ca-cert.pem',
		),

	),

	# Configuration to send emails. Be aware that PHP < 5.5 are not supported.
	# These options are basically a mapping of the PHPMailer class attributes
	# from the PHPMailer library.
	#
	# See http://phpmailer.github.io/PHPMailer/classes/PHPMailer.PHPMailer.PHPMailer.html#properties
	'mailer' => 'mail', // 'mail' or 'smtp'
	'smtp' => array(
		'hostname' => '', // the domain used in the Message-ID header
		'host' => 'localhost', // the SMTP server address
		'port' => 25,
		'auth' => false,
		'auth_type' => '', // 'CRAM-MD5', 'LOGIN', 'PLAIN', 'XOAUTH2' or ''
		'username' => '',
		'password' => '',
		'secure' => '', // '', 'ssl' or 'tls'
		'from' => 'noreply@localhost',
	),

	# List of enabled FreshRSS extensions.
	'extensions_enabled' => array(
		'Tumblr-GDPR' => true,
	),

	# Disable self-update,
	'disable_update' => false,
);
