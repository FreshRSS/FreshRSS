#!/usr/bin/php
<?php
require('_cli.php');

$options = getopt('', array(
		'user:',
	));

if (empty($options['user'])) {
	fail('Usage: ' . basename(__FILE__) . " --user username");
}

$username = cliInitUser($options['user']);

echo 'FreshRSS optimizing database for user “', $username, "”…\n";

$databaseDAO = FreshRSS_Factory::createDatabaseDAO($username);
$ok = $databaseDAO->optimize();

done($ok);
