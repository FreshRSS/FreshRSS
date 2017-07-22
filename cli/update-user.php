#!/usr/bin/php
<?php
require('_cli.php');

$options = getopt('', array(
		'user:',
		'password:',
		'api-password:',
		'language:',
		'email:',
		'token:',
		'purge_after_months:',
		'feed_min_articles_default:',
		'feed_ttl_default:',
		'since_hours_posts_per_rss:',
		'min_posts_per_rss:',
		'max_posts_per_rss:',
	));

if (empty($options['user'])) {
	fail('Usage: ' . basename(__FILE__) . " --user username ( --password 'password' --api-password 'api_password'" .
		" --language en --email user@example.net --token 'longRandomString' )");
}

$username = cliInitUser($options['user']);

echo 'FreshRSS updating user “', $username, "”…\n";

function intParam($name) {
	return isset($options[$name]) && ctype_digit($options[$name]) ? intval($options[$name]) : null;
}

$ok = FreshRSS_user_Controller::updateContextUser(
	empty($options['password']) ? '' : $options['password'],
	empty($options['api-password']) ? '' : $options['api-password'],
	array(
		'language' => isset($options['language']) ? $options['language'] : null,
		'mail_login' => isset($options['email']) ? $options['email'] : null,
		'token' => isset($options['token']) ? $options['token'] : null,
		'old_entries' => intParam('purge_after_months'),
		'keep_history_default' => intParam('feed_min_articles_default'),
		'ttl_default' => intParam('feed_ttl_default'),
		'since_hours_posts_per_rss' => intParam('since_hours_posts_per_rss'),
		'min_posts_per_rss' => intParam('min_posts_per_rss'),
		'max_posts_per_rss' => intParam('max_posts_per_rss'),
	));

if (!$ok) {
	fail('FreshRSS could not update user!');
}

invalidateHttpCache($username);

done($ok);
