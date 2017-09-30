<?php
require('_cli.php');

$params = array(
		'user:',
		'password:',
		'api_password:',
		'language:',
		'email:',
		'token:',
		'purge_after_months:',
		'feed_min_articles_default:',
		'feed_ttl_default:',
		'since_hours_posts_per_rss:',
		'min_posts_per_rss:',
		'max_posts_per_rss:',
	);

if (!$isUpdate) {
	$params[] = 'no_default_feeds';	//Only for creating new users
}

$options = getopt('', $params);

if (empty($options['user'])) {
	fail('Usage: ' . basename($_SERVER['SCRIPT_FILENAME']) .
		" --user username ( --password 'password' --api_password 'api_password'" .
		" --language en --email user@example.net --token 'longRandomString'" .
		($isUpdate ? '' : '--no_default_feeds') .
		" --purge_after_months 3 --feed_min_articles_default 50 --feed_ttl_default 3600" .
		" --since_hours_posts_per_rss 168 --min_posts_per_rss 2 --max_posts_per_rss 400 )");
}

function strParam($name) {
	global $options;
	return isset($options[$name]) ? strval($options[$name]) : null;
}

function intParam($name) {
	global $options;
	return isset($options[$name]) && ctype_digit($options[$name]) ? intval($options[$name]) : null;
}

$values = array(
		'language' => strParam('language'),
		'mail_login' => strParam('email'),
		'token' => strParam('token'),
		'old_entries' => intParam('purge_after_months'),
		'keep_history_default' => intParam('feed_min_articles_default'),
		'ttl_default' => intParam('feed_ttl_default'),
		'since_hours_posts_per_rss' => intParam('since_hours_posts_per_rss'),
		'min_posts_per_rss' => intParam('min_posts_per_rss'),
		'max_posts_per_rss' => intParam('max_posts_per_rss'),
	);

$values = array_filter($values);
