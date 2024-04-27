#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

$cliOptions = new class extends CliOptionsParser {
	public string $deleteBackup;
	public string $forceOverwrite;

	public function __construct() {
		$this->addOption('deleteBackup', (new CliOption('delete-backup'))->withValueNone());
		$this->addOption('forceOverwrite', (new CliOption('force-overwrite'))->withValueNone());
		parent::__construct();
	}
};

if (!empty($cliOptions->errors)) {
	fail('FreshRSS error: ' . array_shift($cliOptions->errors) . "\n" . $cliOptions->usage);
}

FreshRSS_Context::initSystem(true);
Minz_User::change(Minz_User::INTERNAL_USER);
$ok = false;
try {
	$error = initDb();
	if ($error != '') {
		$_SESSION['bd_error'] = $error;
	} else {
		$ok = true;
	}
} catch (Exception $ex) {
	$_SESSION['bd_error'] = $ex->getMessage();
}
if (!$ok) {
	fail('FreshRSS database error: ' . (empty($_SESSION['bd_error']) ? 'Unknown error' : $_SESSION['bd_error']));
}

foreach (listUsers() as $username) {
	$username = cliInitUser($username);
	$filename = DATA_PATH . "/users/{$username}/backup.sqlite";
	if (!file_exists($filename)) {
		fwrite(STDERR, "FreshRSS SQLite backup not found for user “{$username}”!\n");
		$ok = false;
		continue;
	}

	echo 'FreshRSS restore database from SQLite for user “', $username, "”…\n";

	$databaseDAO = FreshRSS_Factory::createDatabaseDAO($username);
	$clearFirst = isset($cliOptions->forceOverwrite);
	$ok &= $databaseDAO->dbCopy($filename, FreshRSS_DatabaseDAO::SQLITE_IMPORT, $clearFirst);
	if ($ok) {
		if (isset($cliOptions->deleteBackup)) {
			unlink($filename);
		}
	} else {
		fwrite(STDERR, "FreshRSS database already exists for user “{$username}”!\n");
		fwrite(STDERR, "If you would like to clear the user database first, use the option --force-overwrite\n");
	}
	invalidateHttpCache($username);
}

done((bool)$ok);
