<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

$parameters = array(
	'valid' => array(
		'user' => ':',
		'password' => ':',
		'api-password' => ':',
		'language' => ':',
		'email' => ':',
		'token' => ':',
		'purge-after-months' => ':',
		'feed-min-articles-default' => ':',
		'feed-ttl-default' => ':',
		'since-hours-posts-per-rss' => ':',
		'max-posts-per-rss' => ':',
	),
	'deprecated' => array(
		'api-password' => 'api_password',
		'purge-after-months' => 'purge_after_months',
		'feed-min-articles-default' => 'feed_min_articles_default',
		'feed-ttl-default' => 'feed_ttl_default',
		'since-hours-posts-per-rss' => 'since_hours_posts_per_rss',
		'max-posts-per-rss' => 'max_posts_per_rss',
	),
);

if (!isset($isUpdate)) {
	$isUpdate = false;
} elseif (!$isUpdate) {
	$parameters['valid']['no-default-feeds'] = '';	//Only for creating new users
	$parameters['deprecated']['no-default-feeds'] = 'no_default_feeds';
}

$GLOBALS['options'] = parseCliParams($parameters);

if (!empty($options['invalid']) || empty($options['valid']['user'])) {
	fail('Usage: ' . basename($_SERVER['SCRIPT_FILENAME']) .
		" --user username ( --password 'password' --api-password 'api_password'" .
		" --language en --email user@example.net --token 'longRandomString'" .
		($isUpdate ? '' : ' --no-default-feeds') .
		" --purge-after-months 3 --feed-min-articles-default 50 --feed-ttl-default 3600" .
		" --since-hours-posts-per-rss 168 --max-posts-per-rss 400 )");
}

function strParam(string $name): ?string {
	global $options;
	return isset($options['valid'][$name]) ? strval($options['valid'][$name]) : null;
}

function intParam(string $name): ?int {
	global $options;
	return isset($options['valid'][$name]) && ctype_digit($options['valid'][$name]) ? intval($options['valid'][$name]) : null;
}

$values = array(
		'language' => strParam('language'),
		'mail_login' => strParam('email'),
		'token' => strParam('token'),
		'old_entries' => intParam('purge-after-months'),	//TODO: Update with new mechanism
		'keep_history_default' => intParam('feed-min-articles-default'),	//TODO: Update with new mechanism
		'ttl_default' => intParam('feed-ttl-default'),
		'since_hours_posts_per_rss' => intParam('since-hours-posts-per-rss'),
		'max_posts_per_rss' => intParam('max-posts-per-rss'),
	);

$values = array_filter($values);
