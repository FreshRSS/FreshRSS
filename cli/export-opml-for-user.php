#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

$parameters = array(
	'long' => array(
		'user' => ':',
	),
	'short' => array(),
	'deprecated' => array(),
);

$options = parseCliParams($parameters);

if (!empty($options['invalid']) || empty($options['valid']['user']) || !is_string($options['valid']['user'])) {
	fail('Usage: ' . basename(__FILE__) . " --user username > /path/to/file.opml.xml");
}

$username = cliInitUser($options['valid']['user']);

fwrite(STDERR, 'FreshRSS exporting OPML for user “' . $username . "”…\n");

$export_service = new FreshRSS_Export_Service($username);
list($filename, $content) = $export_service->generateOpml();
echo $content;

invalidateHttpCache($username);

done();
