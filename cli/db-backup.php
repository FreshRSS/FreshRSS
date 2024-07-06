#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');
$ok = true;

$cliOptions = new class extends CliOptionsParser {
	public string $quiet;

	public function __construct() {
		$this->addOption('quiet', (new CliOption('quiet', 'q'))->withValueNone());
		parent::__construct();
	}
};

if (!empty($cliOptions->errors)) {
	fail('FreshRSS error: ' . array_shift($cliOptions->errors) . "\n" . $cliOptions->usage);
}

foreach (listUsers() as $username) {
	$username = cliInitUser($username);
	$filename = DATA_PATH . '/users/' . $username . '/backup.sqlite';
	@unlink($filename);
	$verbose = !isset($cliOptions->quiet);

	if ($verbose) {
		echo 'FreshRSS backup database to SQLite for user “', $username, "”…\n";
	}

	$databaseDAO = FreshRSS_Factory::createDatabaseDAO($username);
	$ok &= $databaseDAO->dbCopy($filename, FreshRSS_DatabaseDAO::SQLITE_EXPORT, false, $verbose);
}

done((bool)$ok);
