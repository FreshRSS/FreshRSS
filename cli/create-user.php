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
$parser->addOption(
	'purgeAfterMonths',
	(new Option('purge-after-months'))->typeOfInt()->deprecatedAs('purge_after_months')
);
$parser->addOption(
	'feedMinArticles',
	(new Option('feed-min-articles-default'))->typeOfInt()->deprecatedAs('feed_min_articles_default')
);
$parser->addOption(
	'feedTtl',
	(new Option('feed-ttl-default'))->typeOfInt()->deprecatedAs('feed_ttl_default')
);
$parser->addOption(
	'sinceHoursPostsPerRss',
	(new Option('since-hours-posts-per-rss'))->typeOfInt()->deprecatedAs('since_hours_posts_per_rss')
);
$parser->addOption(
	'maxPostsPerRss',
	(new Option('max-posts-per-rss'))->typeOfInt()->deprecatedAs('max_posts_per_rss')
);
$parser->addOption(
	'noDefaultFeeds',
	(new Option('no-default-feeds'))->withValueNone()->deprecatedAs('no_default_feeds')
);

$options = $parser->parse(stdClass::class);

if (!empty($options->errors)) {
	fail('FreshRSS error: ' . array_shift($options->errors) . "\n" . $options->usage);
}

$username = $options->user;

echo 'FreshRSS creating user “', $username, "”…\n";

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

$ok = FreshRSS_user_Controller::createUser(
	$username,
	isset($options->email) ? $options->email : null,
	$options->password ?? '',
	$values,
	!isset($options->noDefaultFeeds)
);

if (!$ok) {
	fail('FreshRSS could not create user!');
}

if (isset($options->apiPassword)) {
	$username = cliInitUser($username);
	$error = FreshRSS_api_Controller::updatePassword($options->apiPassword);
	if ($error !== false) {
		fail($error);
	}
}

invalidateHttpCache(FreshRSS_Context::systemConf()->default_user);

echo 'ℹ️ Remember to refresh the feeds of the user: ', $username ,
	"\t", './cli/actualize-user.php --user ', $username, "\n";

accessRights();

done($ok);
