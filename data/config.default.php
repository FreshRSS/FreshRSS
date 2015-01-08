<?php

return array(
	'environment' => 'production',
	'salt' => '',
	'base_url' => '',
	'language' => 'en',
	'title' => 'FreshRSS',
	'default_user' => '_',
	'allow_anonymous' => false,
	'allow_anonymous_refresh' => false,
	'auth_type' => 'none',
	'api_enabled' => false,
	'unsafe_autologin_enabled' => false,
	'limits' => array(
		'cache_duration' => 800,
		'timeout' => 10,
		'max_inactivity' => PHP_INT_MAX,
		'max_feeds' => 16384,
		'max_categories' => 16384,
	),
	'db' => array(
		'type' => 'sqlite',
		'host' => '',
		'user' => '',
		'password' => '',
		'base' => '',
		'prefix' => '',
	),
	'extensions_enabled' => array(),
);
