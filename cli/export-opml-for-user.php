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

fwrite(STDERR, 'FreshRSS exporting OPML for user “' . $username . "”…\n");

$export_service = new FreshRSS_Export_Service($username);
list($filename, $content) = $export_service->generateOpml();
echo $content;

invalidateHttpCache($username);

done();
