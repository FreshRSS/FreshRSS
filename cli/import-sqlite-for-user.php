#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

$parameters = [
	'long' => [
		'user' => ':',
		'filename' => ':',
		'force-overwrite' => '',
	],
	'short' => [],
	'deprecated' => [],
];

$options = parseCliParams($parameters);

if (!empty($options['invalid'])
	|| empty($options['valid']['user']) || empty($options['valid']['filename'])
	|| !is_string($options['valid']['user']) || !is_string($options['valid']['filename'])
) {
	fail('Usage: ' . basename(__FILE__) . ' --user username --force-overwrite --filename /path/to/db.sqlite');
}

$username = cliInitUser($options['valid']['user']);
$filename = $options['valid']['filename'];

if (pathinfo($filename, PATHINFO_EXTENSION) !== 'sqlite') {
	fail('Only *.sqlite files are supported!');
}

echo 'FreshRSS importing database from SQLite for user “', $username, "”…\n";

$databaseDAO = FreshRSS_Factory::createDatabaseDAO($username);
$clearFirst = array_key_exists('force-overwrite', $options['valid']);
$ok = $databaseDAO->dbCopy($filename, FreshRSS_DatabaseDAO::SQLITE_IMPORT, $clearFirst);
if (!$ok) {
	echo 'If you would like to clear the user database first, use the option --force-overwrite', "\n";
}
invalidateHttpCache($username);

done($ok);
