#!/usr/bin/php
<?php
require(__DIR__ . '/_cli.php');

$params = array(
	'user:',
);

$options = getopt('', $params);

if (!validateOptions($argv, $params) || empty($options['user'])) {
	fail('Usage: ' . basename(__FILE__) . " --user username");
}

$username = cliInitUser($options['user']);

echo 'FreshRSS optimizing database for user “', $username, "”…\n";

$databaseDAO = FreshRSS_Factory::createDatabaseDAO($username);
$ok = $databaseDAO->optimize();

done($ok);
