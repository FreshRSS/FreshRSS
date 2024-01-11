#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

$parameters = array(
	'long' => array(
		'user' => ':'
	),
	'short' => array(),
	'deprecated' => array(),
);

$options = parseCliParams($parameters);

if (!empty($options['invalid']) || empty($options['valid']['user']) || !is_string($options['valid']['user'])) {
	fail('Usage: ' . basename(__FILE__) . " --user username");
}

$username = cliInitUser($options['valid']['user']);

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
