#!/usr/bin/env php
<?php
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::$system_conf->db['type']);

require(LIB_PATH . '/lib_greader.php');

$params = [
	'user:',
];

$options = getopt('', $params);

if (!validateOptions($argv, $params) || empty($options['user'])) {
	fail('Usage: ' . basename(__FILE__) . ' --user username');
}

$username = cliInitUser($options['user']);

$feedDAO = FreshRSS_Factory::createFeedDao();
$arrayFeedCategoryNames = $feedDAO->arrayFeedCategoryNames();

$tagDAO = FreshRSS_Factory::createTagDao();
$entryIdsTagNames = $tagDAO->getEntryIdsTagNames(null);
if ($entryIdsTagNames == false) {
	$entryIdsTagNames = [];
}

$entryDAO = FreshRSS_Factory::createEntryDao();
$entries = $entryDAO->listWhere('AA', '', FreshRSS_Entry::STATE_ALL, 'ASC', -1, '', null, 0);

foreach ($entries as $entry) {
	$f_id = $entry->feed();
	if (isset($arrayFeedCategoryNames[$f_id])) {
		$c_name = $arrayFeedCategoryNames[$f_id]['c_name'];
		$f_name = $arrayFeedCategoryNames[$f_id]['name'];
		$f_url = $arrayFeedCategoryNames[$f_id]['url'];
		$f_website = $arrayFeedCategoryNames[$f_id]['website'];
	} else {
		$c_name = '_';
		$f_name = '_';
		$f_url = '_';
		$f_website = '_';
	}
	$item = [
		'id' => 'tag:google.com,2005:reader/item/' . dec2hex($entry->id()),	//64-bit hexa http://code.google.com/p/google-reader-api/wiki/ItemId
		'crawlTimeMsec' => substr($entry->dateAdded(true, true), 0, -3),
		'timestampUsec' => '' . $entry->dateAdded(true, true),
		'published' => $entry->date(true),
		'title' => escapeToUnicodeAlternative($entry->title(), false),
		'summary' => [ 'content' => $entry->content() ],
		'canonical' => [
			[ 'href' => htmlspecialchars_decode($entry->link(), ENT_QUOTES) ],
		],
		'alternate' => [
			[ 'href' => htmlspecialchars_decode($entry->link(), ENT_QUOTES) ],
		],
		'categories' => [
			'user/-/state/com.google/reading-list',
			'user/folder/label/' . htmlspecialchars_decode($c_name, ENT_QUOTES),
		],
		'origin' => [
			'streamId' => 'feed/' . htmlspecialchars_decode($f_url, ENT_QUOTES),
			'title' => escapeToUnicodeAlternative($f_name, true),
			'htmlUrl' => htmlspecialchars_decode($f_website, ENT_QUOTES),
		],
	];
	foreach ($entry->enclosures() as $enclosure) {
		if (!empty($enclosure['url']) && !empty($enclosure['type'])) {
			$media = [
					'href' => $enclosure['url'],
					'type' => $enclosure['type'],
				];
			if (!empty($enclosure['length'])) {
				$media['length'] = intval($enclosure['length']);
			}
			$item['enclosure'][] = $media;
		}
	}
	$author = $entry->authors(true);
	$author = trim($author, '; ');
	if ($author != '') {
		$item['author'] = escapeToUnicodeAlternative($author, false);
	}
	if ($entry->isRead()) {
		$item['categories'][] = 'user/-/state/com.google/read';
	}
	if ($entry->isFavorite()) {
		$item['categories'][] = 'user/-/state/com.google/starred';
	}
	$tagNames = isset($entryIdsTagNames['e_' . $entry->id()]) ? $entryIdsTagNames['e_' . $entry->id()] : [];
	foreach ($tagNames as $tagName) {
		$item['categories'][] = 'user/tag/label/' . htmlspecialchars_decode($tagName, ENT_QUOTES);
	}

	echo json_encode($item, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), "\n";
}

done();
