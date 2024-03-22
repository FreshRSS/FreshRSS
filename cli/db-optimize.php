#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

$cliOptions = new class extends CliOptionsParser {
	public string $user;

	public function __construct() {
		$this->addRequiredOption('user', (new CliOption('user')));
		parent::__construct();
	}
};

if (!empty($cliOptions->errors)) {
	fail('FreshRSS error: ' . array_shift($cliOptions->errors) . "\n" . $cliOptions->usage);
}

$username = cliInitUser($cliOptions->user);

echo 'FreshRSS optimizing database for user “', $username, "”…\n";

$databaseDAO = FreshRSS_Factory::createDatabaseDAO($username);
$ok = $databaseDAO->optimize();

done($ok);
