#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

$cliOptions = new class extends CliOptionsParser {
	public string $user;
	public int $maxFeedEntries;

	public function __construct() {
		$this->addRequiredOption('user', (new CliOption('user')));
		$this->addOption('maxFeedEntries', (new CliOption('max-feed-entries'))->typeOfInt(), '100');
		parent::__construct();
	}
};

if (!empty($cliOptions->errors)) {
	fail('FreshRSS error: ' . array_shift($cliOptions->errors) . "\n" . $cliOptions->usage);
}

if (!extension_loaded('zip')) {
	fail('FreshRSS error: Lacking php-zip extension!');
}

$username = cliInitUser($cliOptions->user);

fwrite(STDERR, 'FreshRSS exporting ZIP for user “' . $username . "”…\n");

$export_service = new FreshRSS_Export_Service($username);
$number_entries = $cliOptions->maxFeedEntries;
$exported_files = [];

// First, we generate the OPML file
[$filename, $content] = $export_service->generateOpml();
$exported_files[$filename] = $content;

// Then, labelled and starred entries
[$filename, $content] = $export_service->generateStarredEntries('ST');
$exported_files[$filename] = $content;

// And a list of entries based on the complete list of feeds
$feeds_exported_files = $export_service->generateAllFeedEntries($number_entries);
$exported_files = array_merge($exported_files, $feeds_exported_files);

// Finally, we compress all these files into a single Zip archive and we output
// the content
[$filename, $content] = $export_service->zip($exported_files);
echo $content;

invalidateHttpCache($username);

done();
