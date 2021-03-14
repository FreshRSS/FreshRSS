#!/usr/bin/env php
<?php
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::$system_conf->db['type']);

$params = [
	'user:',
];

$options = getopt('', $params);

if (!validateOptions($argv, $params) || empty($options['user']) || empty($options['filename'])) {
	fail('Usage: zcat articles.jsonl.gz | ' . basename(__FILE__) . ' --user username ');
}

$username = cliInitUser($options['user']);

echo 'FreshRSS importing JSON Lines for user “', $username, "”…\n";

$importService = new FreshRSS_Import_Service($username);

function readItems() {
	while ($line = fgets(STDIN)) {
		$item = json_decode($line, true);
		yield $item;
	}
}

importGReaderItems(readItems());

invalidateHttpCache($username);

done();
