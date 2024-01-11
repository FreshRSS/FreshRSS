#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

$parameters = array(
	'long' => array(
		'user' => ':',
	),
	'short' => array(),
	'deprecated' => array(),
);

$options = parseCliParams($parameters);

if (!empty($options['invalid']) || empty($options['valid']['user']) || !is_string($options['valid']['user'])) {
	fail('Usage: ' . basename(__FILE__) . " --user username");
}

$username = cliInitUser($options['valid']['user']);

echo 'FreshRSS optimizing database for user “', $username, "”…\n";

$databaseDAO = FreshRSS_Factory::createDatabaseDAO($username);
$ok = $databaseDAO->optimize();

done($ok);
