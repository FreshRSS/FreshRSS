#!/usr/bin/env php
<?php
require(__DIR__ . '/_cli.php');

const DATA_FORMAT = "%-7s | %-20s | %-5s | %-7s | %-25s | %-15s | %-10s | %-10s | %-10s | %-10s | %-10s | %-10s | %-5s | %-10s\n";

$params = array(
	'user:',
	'header',
	'json',
);
$options = getopt('h', $params);

if (!validateOptions($argv, $params)) {
	fail('Usage: ' . basename(__FILE__) . ' (-h --header --json --user username --user username …)');
}

if (empty($options['user'])) {
	$users = listUsers();
} elseif (is_array($options['user'])) {
	$users = $options['user'];
} else {
	$users = array($options['user']);
}

sort($users);

$formatJson = isset($options['json']);
if ($formatJson) {
	unset($options['header']);
	unset($options['h']);
	$jsonOutput = [];
}

if (array_key_exists('header', $options)) {
	printf(
		DATA_FORMAT,
		'default',
		'user',
		'admin',
		'enabled',
		'last user activity',
		'space used',
		'categories',
		'feeds',
		'reads',
		'unreads',
		'favourites',
		'tags',
		'lang',
		'email'
	);
}

foreach ($users as $username) {
	$username = cliInitUser($username);

	$userConfiguration = get_user_configuration($username);
	$catDAO = FreshRSS_Factory::createCategoryDao($username);
	$feedDAO = FreshRSS_Factory::createFeedDao($username);
	$entryDAO = FreshRSS_Factory::createEntryDao($username);
	$tagDAO = FreshRSS_Factory::createTagDao($username);
	$databaseDAO = FreshRSS_Factory::createDatabaseDAO($username);

	$nbEntries = $entryDAO->countUnreadRead();
	$nbFavorites = $entryDAO->countUnreadReadFavorites();

	$data = array(
		'default' => $username === FreshRSS_Context::$system_conf->default_user ? '*' : '',
		'user' => $username,
		'admin' => $userConfiguration->is_admin ? '*' : '',
		'enabled' => $userConfiguration->enabled ? '*' : '',
		'last_user_activity' => FreshRSS_UserDAO::mtime($username),
		'database_size' => $databaseDAO->size(),
		'categories' => (int) $catDAO->count(),
		'feeds' => (int) count($feedDAO->listFeedsIds()),
		'reads' => (int) $nbEntries['read'],
		'unreads' => (int) $nbEntries['unread'],
		'favourites' => (int) $nbFavorites['all'],
		'tags' => (int) $tagDAO->count(),
		'lang' => $userConfiguration->language,
		'mail_login' => $userConfiguration->mail_login,
	);
	if (isset($options['h'])) {	//Human format
		$data['last_user_activity'] = date('c', $data['last_user_activity']);
		$data['database_size'] = format_bytes($data['database_size']);
	}
	if ($formatJson) {
		$data['default'] = !empty($data['default']);
		$data['admin'] = !empty($data['admin']);
		$data['enabled'] = !empty($data['enabled']);
		$data['last_user_activity'] = gmdate('Y-m-d\TH:i:s\Z', $data['last_user_activity']);
		$jsonOutput[] = $data;
	} else {
		vprintf(DATA_FORMAT, $data);
	}
}

if ($formatJson) {
	echo json_encode($jsonOutput), "\n";
}

done();
