#!/usr/bin/php
<?php
require(__DIR__ . '/_cli.php');

const DATA_FORMAT = "%-7s | %-20s | %-25s | %-15s | %-10s | %-10s | %-10s | %-10s | %-10s | %-10s\n";

$params = array(
	'user:',
	'header',
);
$options = getopt('h', $params);

if (!validateOptions($argv, $params)) {
	fail('Usage: ' . basename(__FILE__) . ' (-h --header --user username --user username …)');
}

if (empty($options['user'])) {
	$users = listUsers();
} elseif (is_array($options['user'])) {
	$users = $options['user'];
} else {
	$users = array($options['user']);
}

sort($users);

if (array_key_exists('header', $options)) {
	printf(
		DATA_FORMAT,
		'default',
		'user',
		'last update',
		'space used',
		'categories',
		'feeds',
		'reads',
		'unreads',
		'favourites',
		'tags'
	);
}

foreach ($users as $username) {
	$username = cliInitUser($username);

	$catDAO = Factory::createCategoryDao($username);
	$feedDAO = Factory::createFeedDao($username);
	$entryDAO = Factory::createEntryDao($username);
	$tagDAO = Factory::createTagDao($username);
	$databaseDAO = Factory::createDatabaseDAO($username);

	$nbEntries = $entryDAO->countUnreadRead();
	$nbFavorites = $entryDAO->countUnreadReadFavorites();

	$data = array(
		'default' => $username === Context::$system_conf->default_user ? '*' : '',
		'user' => $username,
		'lastUpdate' => UserDAO::mtime($username),
		'spaceUsed' => $databaseDAO->size(),
		'categories' => $catDAO->count(),
		'feeds' => count($feedDAO->listFeedsIds()),
		'reads' => $nbEntries['read'],
		'unreads' => $nbEntries['unread'],
		'favourites' => $nbFavorites['all'],
		'tags' => $tagDAO->count(),
	);
	if (isset($options['h'])) {	//Human format
		$data['lastUpdate'] = date('c', $data['lastUpdate']);
		$data['spaceUsed'] = format_bytes($data['spaceUsed']);
	}
	vprintf(DATA_FORMAT, $data);
}

done();
