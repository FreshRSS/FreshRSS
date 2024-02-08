#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

$parser = new CommandLineParser();

$parser->addRequiredOption('user', (new Option('user')));
$parser->addOption('password', (new Option('password')));
$parser->addOption('apiPassword', (new Option('api-password'))->deprecatedAs('api_password'));
$parser->addOption('language', (new Option('language')));
$parser->addOption('email', (new Option('email')));
$parser->addOption('token', (new Option('token')));
$parser->addOption('purgeAfterMonths',
	(new Option('purge-after-months'))
		->typeOfInt()
		->deprecatedAs('purge_after_months')
);
$parser->addOption('feedMinArticles',
	(new Option('feed-min-articles-default'))
		->typeOfInt()
		->deprecatedAs('feed_min_articles_default')
);
$parser->addOption('feedTtl',
	(new Option('feed-ttl-default'))
		->typeOfInt()
		->deprecatedAs('feed_ttl_default')
);
$parser->addOption('sinceHoursPostsPerRss',
	(new Option('since-hours-posts-per-rss'))
		->typeOfInt()
		->deprecatedAs('since_hours_posts_per_rss')
);
$parser->addOption('maxPostsPerRss',
	(new Option('max-posts-per-rss'))
		->typeOfInt()
		->deprecatedAs('max_posts_per_rss')
);

$options = $parser->parse(stdClass::class);

if (!empty($options->errors)) {
	fail('FreshRSS error: ' . array_shift($options->errors) . "\n" . $options->usage);
}

$username = cliInitUser($options->user);

echo 'FreshRSS updating user “', $username, "”…\n";

$values = [
	'language' => $options->language ?? null,
	'mail_login' => $options->email ?? null,
	'token' => $options->token ?? null,
	'old_entries' => $options->purgeAfterMonths ?? null,
	'keep_history_default' => $options->feedMinArticles ?? null,
	'ttl_default' => $options->feedTtl ?? null,
	'since_hours_posts_per_rss' => $options->sinceHoursPostsPerRss ?? null,
	'max_posts_per_rss' => $options->maxPostsPerRss ?? null,
];

$values = array_filter($values);

$ok = FreshRSS_user_Controller::updateUser(
	$username,
	isset($options->email) ? $options->email : null,
	$options->password ?? '',
	$values);

if (!$ok) {
	fail('FreshRSS could not update user!');
}

if (isset($options->apiPassword)) {
	$error = FreshRSS_api_Controller::updatePassword($options->apiPassword);
	if ($error) {
		fail($error);
	}
}

invalidateHttpCache($username);

accessRights();

done($ok);
