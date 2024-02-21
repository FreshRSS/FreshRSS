#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

final class CreateUserDefinition extends CommandLineParser {
	public string $user;
	public string $password;
	public string $apiPassword;
	public string $language;
	public string $email;
	public string $token;
	public int $purgeAfterMonths;
	public int $feedMinArticles;
	public int $feedTtl;
	public int $sinceHoursPostsPerRss;
	public int $maxPostsPerRss;
	public bool $noDefaultFeeds;

	public function __construct() {
		$this->addRequiredOption('user', (new Option('user')));
		$this->addOption('password', (new Option('password')));
		$this->addOption('apiPassword', (new Option('api-password'))->deprecatedAs('api_password'));
		$this->addOption('language', (new Option('language')));
		$this->addOption('email', (new Option('email')));
		$this->addOption('token', (new Option('token')));
		$this->addOption(
			'purgeAfterMonths',
			(new Option('purge-after-months'))->typeOfInt()->deprecatedAs('purge_after_months')
		);
		$this->addOption(
			'feedMinArticles',
			(new Option('feed-min-articles-default'))->typeOfInt()->deprecatedAs('feed_min_articles_default')
		);
		$this->addOption(
			'feedTtl',
			(new Option('feed-ttl-default'))->typeOfInt()->deprecatedAs('feed_ttl_default')
		);
		$this->addOption(
			'sinceHoursPostsPerRss',
			(new Option('since-hours-posts-per-rss'))->typeOfInt()->deprecatedAs('since_hours_posts_per_rss')
		);
		$this->addOption(
			'maxPostsPerRss',
			(new Option('max-posts-per-rss'))->typeOfInt()->deprecatedAs('max_posts_per_rss')
		);
		$this->addOption(
			'noDefaultFeeds',
			(new Option('no-default-feeds'))->withValueNone()->deprecatedAs('no_default_feeds')
		);
		parent::__construct();
	}
}

$options = new CreateUserDefinition();

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
