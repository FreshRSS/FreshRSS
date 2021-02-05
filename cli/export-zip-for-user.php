#!/usr/bin/env php
<?php
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::$system_conf->db['type']);

$params = array(
	'user:',
	'max-feed-entries:',
);

$options = getopt('', $params);

if (!validateOptions($argv, $params) || empty($options['user'])) {
	fail('Usage: ' . basename(__FILE__) . " --user username ( --max-feed-entries 100 ) > /path/to/file.zip");
}

if (!extension_loaded('zip')) {
	fail('FreshRSS error: Lacking php-zip extension!');
}

$username = cliInitUser($options['user']);

fwrite(STDERR, 'FreshRSS exporting ZIP for user “' . $username . "”…\n");

$export_service = new FreshRSS_Export_Service($username);
$number_entries = empty($options['max-feed-entries']) ? 100 : intval($options['max-feed-entries']);
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
