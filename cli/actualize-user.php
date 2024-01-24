#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

/** @var array<string,array{'getopt':string,'required':bool,'default':string,'short':string,'deprecated':string,
 *  'read':callable,'validators':array<callable>}> $parameters */
$parameters = [
	'user' => [
		'getopt' => ':',
		'required' => true,
		'read' => readAsString(),
		'validators' => [
			validateOneOf(listUsers(), 'username', 'the name of an existing user')
		],
	],
];

$options = parseAndValidateCliParams($parameters);

$error = empty($options['invalid']) ? 0 : 1;
if (key_exists('help', $options['valid']) || $error) {
	$error ? fwrite(STDERR, "\nFreshRSS error: " . current($options['invalid']) . "\n\n") : '';
	exit($error);
}


$username = cliInitUser($parameters['user']['read']($options['valid']['user']));

Minz_ExtensionManager::callHookVoid('freshrss_user_maintenance');

fwrite(STDERR, 'FreshRSS actualizing user “' . $username . "”…\n");

$result = FreshRSS_category_Controller::refreshDynamicOpmls();
if (!empty($result['errors'])) {
	$errors = $result['errors'];
	fwrite(STDERR, "FreshRSS error refreshing $errors dynamic OPMLs!\n");
}
if (!empty($result['successes'])) {
	$successes = $result['successes'];
	echo "FreshRSS refreshed $successes dynamic OPMLs for $username\n";
}

[$nbUpdatedFeeds, , $nbNewArticles] = FreshRSS_feed_Controller::actualizeFeeds();
if ($nbNewArticles > 0) {
	FreshRSS_feed_Controller::commitNewEntries();
}

echo "FreshRSS actualized $nbUpdatedFeeds feeds for $username ($nbNewArticles new articles)\n";

invalidateHttpCache($username);

done($nbUpdatedFeeds > 0);
