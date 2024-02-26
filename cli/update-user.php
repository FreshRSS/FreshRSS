#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

final class UpdateUserDefinition extends CommandLineParser {
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
}

$options = new UpdateUserDefinition();

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
