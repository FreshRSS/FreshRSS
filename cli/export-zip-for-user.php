#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

/** @var array<string,array{'getopt':string,'required':bool,'default':string,'short':string,'deprecated':string,
 *  'read':callable,'validators':array<callable>}> $parameters */
$parameters = [
	'user' => [
		'getopt' => ':',
		'required' => true,
		'read' => readAsString(),
		'validators' => [
			validateOneOf(listUsers(), 'username', 'the name of an existing user')
		],
	],
	'max-feed-entries' => [
		'getopt' => ':',
		'required' => false,
		'default' => '100',
		'read' => readAsInt(),
		'validators' => [
			validateRegex('/^[0-9]+$/', 'maximum number of entries per feed', 'numerals')
		],
	]
];

$options = parseAndValidateCliParams($parameters);

$error = empty($options['invalid']) ? 0 : 1;
if (key_exists('help', $options['valid']) || $error) {
	$error ? fwrite(STDERR, "\nFreshRSS error: " . current($options['invalid']) . "\n\n") : '';
	exit($error);
}

if (!extension_loaded('zip')) {
	fail('FreshRSS error: Lacking php-zip extension!');
}

$username = cliInitUser($parameters['user']['read']($options['valid']['user']));

fwrite(STDERR, 'FreshRSS exporting ZIP for user “' . $username . "”…\n");

$export_service = new FreshRSS_Export_Service($username);
$number_entries = $parameters['max-feed-entries']['read']($options['valid']['max-feed-entries']);
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
