#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

const DATA_FORMAT = "%-7s | %-20s | %-5s | %-7s | %-25s | %-15s | %-10s | %-10s | %-10s | %-10s | %-10s | %-10s | %-5s | %-10s\n";

$parameters = [
	'long' => [
		'user' => ':',
		'header' => '',
		'json' => '',
		'human-readable' => '',
	],
	'short' => [
		'human-readable' => 'h',
	],
	'deprecated' => [],
];

$options = parseCliParams($parameters);

if (!empty($options['invalid'])) {
	fail('Usage: ' . basename(__FILE__) . ' (--human-readable --header --json --user username --user username …)');
}

if (empty($options['valid']['user'])) {
	$users = listUsers();
} elseif (is_array($options['valid']['user'])) {
	/** @var array<string> $users */
	$users = $options['valid']['user'];
} else {
	/** @var array<string> $users */
	$users = [$options['valid']['user']];
}

sort($users);

$formatJson = isset($options['valid']['json']);
$jsonOutput = [];
if ($formatJson) {
	unset($options['valid']['header']);
	unset($options['valid']['human-readable']);
}

if (array_key_exists('header', $options['valid'])) {
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

	$catDAO = FreshRSS_Factory::createCategoryDao($username);
	$feedDAO = FreshRSS_Factory::createFeedDao($username);
	$entryDAO = FreshRSS_Factory::createEntryDao($username);
	$tagDAO = FreshRSS_Factory::createTagDao($username);
	$databaseDAO = FreshRSS_Factory::createDatabaseDAO($username);

	$nbEntries = $entryDAO->countUnreadRead();
	$nbFavorites = $entryDAO->countUnreadReadFavorites();
	$feedList = $feedDAO->listFeedsIds();

	$data = [
		'default' => $username === FreshRSS_Context::systemConf()->default_user ? '*' : '',
		'user' => $username, 'admin' => FreshRSS_Context::userConf()->is_admin ? '*' : '',
		'enabled' => FreshRSS_Context::userConf()->enabled ? '*' : '',
		'last_user_activity' => FreshRSS_UserDAO::mtime($username),
		'database_size' => $databaseDAO->size(),
		'categories' => $catDAO->count(),
		'feeds' => count($feedList),
		'reads' => $nbEntries['read'],
		'unreads' => $nbEntries['unread'],
		'favourites' => (int)$nbFavorites['all'],
		'tags' => $tagDAO->count(),
		'lang' => FreshRSS_Context::userConf()->language,
		'mail_login' => FreshRSS_Context::userConf()->mail_login,

	);
	if (isset($options['valid']['human-readable'])) {	//Human format
		$data['last_user_activity'] = date('c', $data['last_user_activity']);
		$data['database_size'] = format_bytes($data['database_size']);
	}

	if ($formatJson) {
		$data['default'] = !empty($data['default']);
		$data['admin'] = !empty($data['admin']);
		$data['enabled'] = !empty($data['enabled']);
		$data['last_user_activity'] = gmdate('Y-m-d\TH:i:s\Z', (int)$data['last_user_activity']);
		$jsonOutput[] = $data;
	} else {
		vprintf(DATA_FORMAT, $data);
	}
}

if ($formatJson) {
	echo json_encode($jsonOutput), "\n";
}

done();
