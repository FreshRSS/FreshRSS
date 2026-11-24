#!/usr/bin/env php
<?php
declare(strict_types=1);

use FreshRss\Controllers\UserController;
use FreshRss\Models\Context;
use FreshRss\Models\DatabaseDAO;
use FreshRss\Models\Factory;

require __DIR__ . '/_cli.php';

performRequirementCheck(Context::systemConf()->db['type'] ?? '');
$ok = true;

$cliOptions = new class extends CliOptionsParser {
	public bool $quiet;

	public function __construct() {
		$this->addOption('quiet', (new CliOption('quiet', 'q'))->withValueNone());
		parent::__construct();
	}
};

if (!empty($cliOptions->errors)) {
	fail('FreshRSS error: ' . array_shift($cliOptions->errors) . "\n" . $cliOptions->usage);
}

foreach (UserController::listUsers() as $username) {
	$username = cliInitUser($username);
	$filename = DATA_PATH . '/users/' . $username . '/backup.sqlite';
	@unlink($filename);
	$verbose = !$cliOptions->quiet;

	if ($verbose) {
		echo 'FreshRSS backup database to SQLite for user “', $username, "”…\n";
	}

	$databaseDAO = Factory::createDatabaseDAO($username);
	$ok &= $databaseDAO->dbCopy($filename, DatabaseDAO::SQLITE_EXPORT, false, $verbose);
}

done((bool)$ok);
