#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

class ExportSqliteForUserDefinition {
	/** @var array<string,string> $errors */
	public array $errors = [];
	public string $usage;
	public string $user;
	public string $filename;
}

$parser = new CommandLineParser();

$parser->addRequiredOption('user', (new Option('user')));
$parser->addRequiredOption('filename', (new Option('filename')));

$options = $parser->parse(ExportSqliteForUserDefinition::class);

if (!empty($options->errors)) {
	fail('FreshRSS error: ' . array_shift($options->errors) . "\n" . $options->usage);
}

$username = cliInitUser($options->user);
$filename = $options->filename;

if (pathinfo($filename, PATHINFO_EXTENSION) !== 'sqlite') {
	fail('Only *.sqlite files are supported!');
}

echo 'FreshRSS exporting database to SQLite for user “', $username, "”…\n";

$databaseDAO = FreshRSS_Factory::createDatabaseDAO($username);
$ok = $databaseDAO->dbCopy($filename, FreshRSS_DatabaseDAO::SQLITE_EXPORT);

done($ok);
