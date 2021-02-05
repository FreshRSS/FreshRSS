#!/usr/bin/env php
<?php
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::$system_conf->db['type']);

$params = [
	'user:',
	'filename:',
	'force-overwrite',
];

$options = getopt('', $params);

if (!validateOptions($argv, $params) || empty($options['user']) || empty($options['filename'])) {
	fail('Usage: ' . basename(__FILE__) . ' --user username --force-overwrite --filename /path/to/db.sqlite');
}

$username = cliInitUser($options['user']);
$filename = $options['filename'];

if (pathinfo($filename, PATHINFO_EXTENSION) !== 'sqlite') {
	fail('Only *.sqlite files are supported!');
}

echo 'FreshRSS importing database from SQLite for user “', $username, "”…\n";

$databaseDAO = FreshRSS_Factory::createDatabaseDAO($username);
$clearFirst = array_key_exists('force-overwrite', $options);
$ok = $databaseDAO->dbCopy($filename, FreshRSS_DatabaseDAO::SQLITE_IMPORT, $clearFirst);
if (!$ok) {
	echo 'If you would like to clear the user database first, use the option --force-overwrite', "\n";
}
invalidateHttpCache($username);

done($ok);
