#!/usr/bin/env php
<?php
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::$system_conf->db['type']);

$params = [
	'user:',
];

$options = getopt('', $params);

$opml = stream_get_contents(STDIN);

if (!validateOptions($argv, $params) || empty($options['user']) || strlen($opml) < 50) {
	fail('Usage: cat subscriptions.opml.xml | ' . basename(__FILE__) . " --user username");
}

$username = cliInitUser($options['user']);

echo 'FreshRSS importing OPML for user “', $username, "”…\n";

$ok = true;

$importService = new FreshRSS_Import_Service($username);

if (!$importService->importOpml($opml)) {
	$ok = false;
	fwrite(STDERR, 'FreshRSS error during OPML import' . "\n");
}

invalidateHttpCache($username);

done($ok);
