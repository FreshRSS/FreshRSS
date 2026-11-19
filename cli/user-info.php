#!/usr/bin/env php
<?php
declare(strict_types=1);
require __DIR__ . '/_cli.php';

const DATA_FORMAT = "%-7s | %-20s | %-5s | %-7s | %-25s | %-15s | %-10s | %-10s | %-10s | %-10s | %-10s | %-10s | %-5s | %-10s\n";

$cliOptions = new class extends CliOptionsParser {
	/** @var array<int,string> $user */
	public array $user;
	public bool $header;
	public bool $json;
	public bool $humanReadable;
	/** Disable database size */
	public bool $noDbSize;
	/** Disable database counts */
	public bool $noDbCounts;

	public function __construct() {
		$this->addOption('user', (new CliOption('user'))->typeOfArrayOfString());
		$this->addOption('header', (new CliOption('header'))->withValueNone());
		$this->addOption('json', (new CliOption('json'))->withValueNone());
		$this->addOption('humanReadable', (new CliOption('human-readable', 'h'))->withValueNone());
		$this->addOption('noDbSize', (new CliOption('no-db-size'))->withValueNone());
		$this->addOption('noDbCounts', (new CliOption('no-db-counts'))->withValueNone());
		parent::__construct();
	}
};

if (!empty($cliOptions->errors)) {
	fail('FreshRSS error: ' . array_shift($cliOptions->errors) . "\n" . $cliOptions->usage);
}

$users = $cliOptions->user ?? FreshRSS_user_Controller::listUsers();

sort($users);

$jsonOutput = [];
if ($cliOptions->json) {
	$cliOptions->header = false;
	$cliOptions->humanReadable = false;
}

if ($cliOptions->header) {
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

	if ($cliOptions->noDbCounts) {
		$catDAO = null;
		$feedDAO = null;
		$tagDAO = null;
		$nbEntries = null;
	} else {
		$catDAO = FreshRSS_Factory::createCategoryDao($username);
		$feedDAO = FreshRSS_Factory::createFeedDao($username);
		$entryDAO = FreshRSS_Factory::createEntryDao($username);
		$tagDAO = FreshRSS_Factory::createTagDao($username);
		$nbEntries = $entryDAO->countAsStates();
	}
	if ($cliOptions->noDbSize) {
		$databaseDAO = null;
	} else {
		$databaseDAO = FreshRSS_Factory::createDatabaseDAO($username);
	}

	$data = [
		'default' => $username === FreshRSS_Context::systemConf()->default_user ? '*' : '',
		'user' => $username,
		'admin' => FreshRSS_Context::userConf()->is_admin ? '*' : '',
		'enabled' => FreshRSS_Context::userConf()->enabled ? '*' : '',
		'last_user_activity' => FreshRSS_UserDAO::mtime($username),
		'database_size' => isset($databaseDAO) ? $databaseDAO->size() : '?',
		'categories' => isset($catDAO) ? $catDAO->count() : '?',
		'feeds' => isset($feedDAO) ? $feedDAO->count() : '?',
		'reads' => isset($nbEntries) ? $nbEntries['read'] : '?',
		'unreads' => isset($nbEntries) ? $nbEntries['unread'] : '?',
		'favourites' => isset($nbEntries) ? $nbEntries['favorites'] : '?',
		'tags' => isset($tagDAO) ? $tagDAO->count() : '?',
		'lang' => FreshRSS_Context::userConf()->language,
		'mail_login' => FreshRSS_Context::userConf()->mail_login,
	];
	if ($cliOptions->humanReadable) {	//Human format
		$data['last_user_activity'] = date('c', $data['last_user_activity']);
		if (ctype_digit($data['database_size'])) {
			$data['database_size'] = format_bytes($data['database_size']);
		}
	}

	if ($cliOptions->json) {
		$data['default'] = !empty($data['default']);
		$data['admin'] = !empty($data['admin']);
		$data['enabled'] = !empty($data['enabled']);
		$data['last_user_activity'] = gmdate('Y-m-d\TH:i:s\Z', (int)$data['last_user_activity']);
		$jsonOutput[] = $data;
	} else {
		vprintf(DATA_FORMAT, $data);
	}
}

if ($cliOptions->json) {
	echo json_encode($jsonOutput), "\n";
}

done();
