#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

$parser = new CommandLineParser();

$parser->addRequiredOption('user', (new Option('user'))->typeOfString(validateIsUser()));
$parser->addRequiredOption(
	'filename',
	(new Option('filename'))
		->typeOfString(validateFileExtension(['sqlite'], 'a path to a .sqlite file'))
);
$parser->addOption('forceOverwrite', (new Option('force-overwrite'))->withValueNone());

$options = $parser->parse(stdClass::class);

if (!empty($options->errors)) {
	fail('FreshRSS error: ' . array_shift($options->errors) . "\n" . $options->usage);
}

$username = cliInitUser($options->user);
$filename = $options->filename;

echo 'FreshRSS importing database from SQLite for user “', $username, "”…\n";

$databaseDAO = FreshRSS_Factory::createDatabaseDAO($username);
$clearFirst = isset($options->forceOverwrite);
$ok = $databaseDAO->dbCopy($filename, FreshRSS_DatabaseDAO::SQLITE_IMPORT, $clearFirst);
if (!$ok) {
	echo 'If you would like to clear the user database first, use the option --force-overwrite', "\n";
}
invalidateHttpCache($username);

done($ok);
