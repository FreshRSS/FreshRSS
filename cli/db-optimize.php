#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

$parser = new CommandLineParser();

$parser->addRequiredOption('user', (new Option('user')));

$options = $parser->parse(stdClass::class);

if (!empty($options->errors)) {
	fail('FreshRSS error: ' . array_shift($options->errors) . "\n" . $options->usage);
}

$username = cliInitUser($options->user);

echo 'FreshRSS optimizing database for user “', $username, "”…\n";

$databaseDAO = FreshRSS_Factory::createDatabaseDAO($username);
$ok = $databaseDAO->optimize();

done($ok);
