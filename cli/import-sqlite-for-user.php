#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

final class ImportSqliteForUserDefinition extends CommandLineParser {
	public string $user;
	public string $filename;
	public string $forceOverwrite;

	public function __construct() {
		$this->addRequiredOption('user', (new CliOption('user')));
		$this->addRequiredOption('filename', (new CliOption('filename')));
		$this->addOption('forceOverwrite', (new CliOption('force-overwrite'))->withValueNone());
		parent::__construct();
	}
}

$options = new ImportSqliteForUserDefinition();

if (!empty($options->errors)) {
	fail('FreshRSS error: ' . array_shift($options->errors) . "\n" . $options->usage);
}

$username = cliInitUser($options->user);
$filename = $options->filename;

if (pathinfo($filename, PATHINFO_EXTENSION) !== 'sqlite') {
	fail('Only *.sqlite files are supported!');
}

echo 'FreshRSS importing database from SQLite for user “', $username, "”…\n";

$databaseDAO = FreshRSS_Factory::createDatabaseDAO($username);
$clearFirst = isset($options->forceOverwrite);
$ok = $databaseDAO->dbCopy($filename, FreshRSS_DatabaseDAO::SQLITE_IMPORT, $clearFirst);
if (!$ok) {
	echo 'If you would like to clear the user database first, use the option --force-overwrite', "\n";
}
invalidateHttpCache($username);

done($ok);
