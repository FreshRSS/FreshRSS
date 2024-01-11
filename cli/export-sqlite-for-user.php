#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

$parameters = array(
	'long' => array(
		'user' => ':',
		'filename' => ':',
	),
	'short' => array(),
	'deprecated' => array(),
);

$options = parseCliParams($parameters);

if (!empty($options['invalid'])
	|| empty($options['valid']['user']) || empty($options['valid']['filename'])
	|| !is_string($options['valid']['user']) || !is_string($options['valid']['filename'])
) {
	fail('Usage: ' . basename(__FILE__) . ' --user username --filename /path/to/db.sqlite');
}

$username = cliInitUser($options['valid']['user']);
$filename = $options['valid']['filename'];

if (pathinfo($filename, PATHINFO_EXTENSION) !== 'sqlite') {
	fail('Only *.sqlite files are supported!');
}

echo 'FreshRSS exporting database to SQLite for user “', $username, "”…\n";

$databaseDAO = FreshRSS_Factory::createDatabaseDAO($username);
$ok = $databaseDAO->dbCopy($filename, FreshRSS_DatabaseDAO::SQLITE_EXPORT);

done($ok);
