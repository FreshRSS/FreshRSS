#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

/** @var array<string,array{'getopt':string,'required':bool,'default':string,'short':string,'deprecated':string,
 *  'read':callable,'validators':array<callable>}> $parameters */
$parameters = [
	'user' => [
		'getopt' => ':',
		'required' => true,
		'read' => readAsString(),
		'validators' => [
			validateRegex('/^' . FreshRSS_user_Controller::USERNAME_PATTERN . '$/', 'username', 'ASCII alphanumeric'),
			validateNotOneOf(listUsers(), 'new username', 'the name of an existing user'),
		],
	],
	'password' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsString(),
	],
	'api-password' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsString(),
		'deprecated' => 'api_password',
	],
	'language' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsString(),
		'validators' => [
			validateOneOf(listLanguages(), 'language setting', 'an iso 639-1 code for a supported language'),
		]
	],
	'email' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsString(),
	],
	'token' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsString(),
	],
	'purge-after-months' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsInt(),
		'deprecated' => 'purge_after_months',
	],
	'feed-min-articles-default' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsInt(),
		'deprecated' => 'feed_min_articles_default',
	],
	'feed-ttl-default' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsInt(),
		'deprecated' => 'feed_ttl_default',
	],
	'since-hours-posts-per-rss' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsInt(),
		'deprecated' => 'since_hours_posts_per_rss',
	],
	'max-posts-per-rss' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsInt(),
		'deprecated' => 'max_posts_per_rss',
	],
	'no-default-feeds' => [
		'getopt' => '',
		'required' => false,
		'deprecated' => 'no_default_feeds',
	],
];

$options = parseAndValidateCliParams($parameters);

$error = empty($options['invalid']) ? 0 : 1;
if (key_exists('help', $options['valid']) || $error) {
	$error ? fwrite(STDERR, "\nFreshRSS error: " . current($options['invalid']) . "\n\n") : '';
	exit($error);
}

$username = $parameters['user']['read']($options['valid']['user']);

echo 'FreshRSS creating user “', $username, "”…\n";

$values = [
	'language' => $options['valid']['language'] ?? 0
		? $parameters['language']['read']($options['valid']['language'])
		: null,
	'mail_login' => $options['valid']['email'] ?? 0
		? $parameters['email']['read']($options['valid']['email'])
		: null,
	'token' => $options['valid']['token'] ?? 0
		? $parameters['token']['read']($options['valid']['token'])
		: null,
	'old_entries' => $options['valid']['purge-after-months'] ?? 0
		? $parameters['purge-after-months']['read']($options['valid']['purge-after-months'])	//TODO: Update with new mechanism
		: null,
	'keep_history_default' => $options['valid']['feed-min-articles-default'] ?? 0
		? $parameters['feed-min-articles-default']['read']($options['valid']['feed-min-articles-default'])	//TODO: Update with new mechanism
		: null,
	'ttl_default' => $options['valid']['feed-ttl-default'] ?? 0
		? $parameters['feed-ttl-default']['read']($options['valid']['feed-ttl-default'])
		: null,
	'since_hours_posts_per_rss' => $options['valid']['since-hours-posts-per-rss'] ?? 0
		? $parameters['since-hours-posts-per-rss']['read']($options['valid']['since-hours-posts-per-rss'])
		: null,
	'max_posts_per_rss' => $options['valid']['max-posts-per-rss'] ?? 0
		? $parameters['max-posts-per-rss']['read']($options['valid']['max-posts-per-rss'])
		: null,
];

$values = array_filter($values);

$ok = FreshRSS_user_Controller::createUser(
	$username,
	empty($options['valid']['email']) ? '' : $parameters['email']['read']($options['valid']['email']),
	empty($options['valid']['password']) ? '' : $parameters['password']['read']($options['valid']['password']),
	$values,
	!isset($options['valid']['no-default-feeds'])
);

if (!$ok) {
	fail('FreshRSS could not create user!');
}

if (!empty($options['valid']['api-password'])) {
	$username = cliInitUser($username);
	$error = FreshRSS_api_Controller::updatePassword($parameters['api-password']['read']($options['valid']['api-password']));
	if ($error !== false) {
		fail($error);
	}
}

invalidateHttpCache(FreshRSS_Context::systemConf()->default_user);

echo 'ℹ️ Remember to refresh the feeds of the user: ', $username ,
	"\t", './cli/actualize-user.php --user ', $username, "\n";

accessRights();

done($ok);
