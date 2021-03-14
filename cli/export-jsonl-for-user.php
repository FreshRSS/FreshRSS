#!/usr/bin/env php
<?php
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::$system_conf->db['type']);

$params = [
	'user:',
	'filter:',
];

$options = getopt('', $params);

if (!validateOptions($argv, $params) || empty($options['user'])) {
	fail('Usage: ' . basename(__FILE__) . ' --user username [ --filter "search query" ] | gzip > articles.jsonl.gz');
}

$username = cliInitUser($options['user']);
$filter = empty($options['filter']) ? null : new FreshRSS_BooleanSearch(safe_utf8($options['filter']));

$entryDAO = FreshRSS_Factory::createEntryDao();
$entries = $entryDAO->listWhere('AA', '', FreshRSS_Entry::STATE_ALL, 'ASC', -1, '', $filter, 0);

$export_service = new FreshRSS_Export_Service($username);
$items = $export_service->entriesToGReaderItems($entries);

foreach ($items as $item) {
	echo json_encode($item, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), "\n";
}

done();
