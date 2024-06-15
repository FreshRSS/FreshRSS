#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');
$ok = true;

foreach (listUsers() as $username) {
	$username = cliInitUser($username);
	$filename = DATA_PATH . '/users/' . $username . '/backup.sqlite';
	@unlink($filename);

	echo 'FreshRSS backup database to SQLite for user “', $username, "”…\n";

	$databaseDAO = FreshRSS_Factory::createDatabaseDAO($username);
	$ok &= $databaseDAO->dbCopy($filename, FreshRSS_DatabaseDAO::SQLITE_EXPORT);
}

done((bool)$ok);
