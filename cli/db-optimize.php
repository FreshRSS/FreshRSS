#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

final class DbOptimizeDefinition extends CommandLineParser {
	public string $user;

	public function __construct() {
		$this->addRequiredOption('user', (new Option('user')));
		parent::__construct();
	}
}

$options = new DbOptimizeDefinition();

if (!empty($options->errors)) {
	fail('FreshRSS error: ' . array_shift($options->errors) . "\n" . $options->usage);
}

$username = cliInitUser($options->user);

echo 'FreshRSS optimizing database for user “', $username, "”…\n";

$databaseDAO = FreshRSS_Factory::createDatabaseDAO($username);
$ok = $databaseDAO->optimize();

done($ok);
