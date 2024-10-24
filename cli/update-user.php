#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

$cliOptions = new class extends CliOptionsParser {
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

	public function __construct() {
		$this->addRequiredOption('user', (new CliOption('user')));
		$this->addOption('password', (new CliOption('password')));
		$this->addOption('apiPassword', (new CliOption('api-password'))->deprecatedAs('api_password'));
		$this->addOption('language', (new CliOption('language')));
		$this->addOption('email', (new CliOption('email')));
		$this->addOption('token', (new CliOption('token')));
		$this->addOption(
			'purgeAfterMonths',
			(new CliOption('purge-after-months'))->typeOfInt()->deprecatedAs('purge_after_months')
		);
		$this->addOption(
			'feedMinArticles',
			(new CliOption('feed-min-articles-default'))->typeOfInt()->deprecatedAs('feed_min_articles_default')
		);
		$this->addOption(
			'feedTtl',
			(new CliOption('feed-ttl-default'))->typeOfInt()->deprecatedAs('feed_ttl_default')
		);
		$this->addOption(
			'sinceHoursPostsPerRss',
			(new CliOption('since-hours-posts-per-rss'))->typeOfInt()->deprecatedAs('since_hours_posts_per_rss')
		);
		$this->addOption(
			'maxPostsPerRss',
			(new CliOption('max-posts-per-rss'))->typeOfInt()->deprecatedAs('max_posts_per_rss')
		);
		parent::__construct();
	}
};

if (!empty($cliOptions->errors)) {
	fail('FreshRSS error: ' . array_shift($cliOptions->errors) . "\n" . $cliOptions->usage);
}

$username = cliInitUser($cliOptions->user);

echo 'FreshRSS updating user “', $username, "”…\n";

$values = [
	'language' => $cliOptions->language ?? null,
	'mail_login' => $cliOptions->email ?? null,
	'token' => $cliOptions->token ?? null,
	'old_entries' => $cliOptions->purgeAfterMonths ?? null,
	'keep_history_default' => $cliOptions->feedMinArticles ?? null,
	'ttl_default' => $cliOptions->feedTtl ?? null,
	'since_hours_posts_per_rss' => $cliOptions->sinceHoursPostsPerRss ?? null,
	'max_posts_per_rss' => $cliOptions->maxPostsPerRss ?? null,
];

$values = array_filter($values);

$ok = FreshRSS_user_Controller::updateUser(
	$username,
	$cliOptions->email ?? null,
	$cliOptions->password ?? '',
	$values);

if (!$ok) {
	fail('FreshRSS could not update user!');
}

if (isset($cliOptions->apiPassword)) {
	$error = FreshRSS_api_Controller::updatePassword($cliOptions->apiPassword);
	if ($error !== false) {
		fail($error);
	}
}

invalidateHttpCache($username);

accessRights();

done($ok);
