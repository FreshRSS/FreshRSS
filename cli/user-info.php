#!/usr/bin/php
<?php
require(__DIR__ . '/_cli.php');

$options = getopt('h', array(
		'user:',
	));

if (empty($options['user'])) {
	fail('Usage: ' . basename(__FILE__) . " -h --user username");
}

$users = $options['user'] === '*' ? listUsers() : array($options['user']);

foreach ($users as $username) {
	$username = cliInitUser($username);
	echo $username === FreshRSS_Context::$system_conf->default_user ? '*' : ' ', "\t";

	$catDAO = FreshRSS_Factory::createCategoryDao();
	$feedDAO = FreshRSS_Factory::createFeedDao($username);
	$entryDAO = FreshRSS_Factory::createEntryDao($username);
	$tagDAO = FreshRSS_Factory::createTagDao($username);
	$databaseDAO = FreshRSS_Factory::createDatabaseDAO($username);

	$nbEntries = $entryDAO->countUnreadRead();
	$nbFavorites = $entryDAO->countUnreadReadFavorites();

	if (isset($options['h'])) {	//Human format
		echo
			$username, "\t",
			date('c', FreshRSS_UserDAO::mtime($username)), "\t",
			format_bytes($databaseDAO->size()), "\t",
			$catDAO->count(), " categories\t",
			count($feedDAO->listFeedsIds()), " feeds\t",
			$nbEntries['read'], " reads\t",
			$nbEntries['unread'], " unreads\t",
			$nbFavorites['all'], " favourites\t",
			$tagDAO->count(), " tags\t",
			"\n";
	} else {
		echo
			$username, "\t",
			FreshRSS_UserDAO::mtime($username), "\t",
			$databaseDAO->size(), "\t",
			$catDAO->count(), "\t",
			count($feedDAO->listFeedsIds()), "\t",
			$nbEntries['read'], "\t",
			$nbEntries['unread'], "\t",
			$nbFavorites['all'], "\t",
			$tagDAO->count(), "\t",
			"\n";
	}
}

done();
