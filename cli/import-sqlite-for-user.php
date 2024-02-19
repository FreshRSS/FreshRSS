#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

class ImportSqliteForUserDefinition {
	/** @var array<string,string> $errors */
	public array $errors = [];
	public string $usage;
	public string $user;
	public string $filename;
	public string $forceOverwrite;
}

$parser = new CommandLineParser();

$parser->addRequiredOption('user', (new Option('user')));
$parser->addRequiredOption('filename', (new Option('filename')));
$parser->addOption('forceOverwrite', (new Option('force-overwrite'))->withValueNone());

$options = $parser->parse(ImportSqliteForUserDefinition::class);

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
