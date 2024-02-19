#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

class ExportZipForUserDefinition {
	/** @var array<string,string> $errors */
	public array $errors = [];
	public string $usage;
	public string $user;
	public int $maxFeedEntries;
}

$parser = new CommandLineParser();

$parser->addRequiredOption('user', (new Option('user')));
$parser->addOption('maxFeedEntries', (new Option('max-feed-entries'))->typeOfInt(), '100');

$options = $parser->parse(ExportZipForUserDefinition::class);

if (!empty($options->errors)) {
	fail('FreshRSS error: ' . array_shift($options->errors) . "\n" . $options->usage);
}

if (!extension_loaded('zip')) {
	fail('FreshRSS error: Lacking php-zip extension!');
}

$username = cliInitUser($options->user);

fwrite(STDERR, 'FreshRSS exporting ZIP for user “' . $username . "”…\n");

$export_service = new FreshRSS_Export_Service($username);
$number_entries = $options->maxFeedEntries;
$exported_files = [];

// First, we generate the OPML file
list($filename, $content) = $export_service->generateOpml();
$exported_files[$filename] = $content;

// Then, labelled and starred entries
list($filename, $content) = $export_service->generateStarredEntries('ST');
$exported_files[$filename] = $content;

// And a list of entries based on the complete list of feeds
$feeds_exported_files = $export_service->generateAllFeedEntries($number_entries);
$exported_files = array_merge($exported_files, $feeds_exported_files);

// Finally, we compress all these files into a single Zip archive and we output
// the content
list($filename, $content) = $export_service->zip($exported_files);
echo $content;

invalidateHttpCache($username);

done();
