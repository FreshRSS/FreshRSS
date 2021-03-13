#!/usr/bin/env php
<?php
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::$system_conf->db['type']);

require(LIB_PATH . '/lib_greader.php');

$params = [
	'user:',
];

$options = getopt('', $params);

if (!validateOptions($argv, $params) || empty($options['user']) || empty($options['filename'])) {
	fail('Usage: zcat articles.jsonl.gz | ' . basename(__FILE__) . ' --user username ');
}

$username = cliInitUser($options['user']);

//TODO

invalidateHttpCache($username);

done($ok);
