#!/usr/bin/env php
<?php
require(__DIR__ . '/_cli.php');

$params = [
	'user:',
	'filename:',
];

$options = getopt('', $params);

if (!validateOptions($argv, $params) || empty($options['user']) || empty($options['filename'])) {
	fail('Usage: ' . basename(__FILE__) . ' --user username --filename /path/to/db.sqlite');
}

$username = cliInitUser($options['user']);
$filename = $options['filename'];

if (pathinfo($filename, PATHINFO_EXTENSION) !== 'sqlite') {
	fail('Only *.sqlite files are supported!');
}

echo 'FreshRSS exporting database to SQLite for user “', $username, "”…\n";

$databaseDAO = FreshRSS_Factory::createDatabaseDAO($username);
$ok = $databaseDAO->dbCopy($filename, FreshRSS_DatabaseDAO::SQLITE_EXPORT);

done($ok);
