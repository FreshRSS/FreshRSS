#!/usr/bin/php
<?php
require('_cli.php');

$options = getopt('h', array(
		'user:',
	));

if (empty($options['user'])) {
	fail('Usage: ' . basename(__FILE__) . " -h --user username");
}

$users = $options['user'] === '*' ? listUsers() : array($options['user']);

foreach ($users as $username) {
	$username = cliInitUser($username);

	$entryDAO = FreshRSS_Factory::createEntryDao($username);

	echo $username === FreshRSS_Context::$system_conf->default_user ? '*' : ' ', "\t";

	if (isset($options['h'])) {	//Human format
		echo
			$username, "\t",
			date('c', FreshRSS_UserDAO::mtime($username)), "\t",
			format_bytes($entryDAO->size()), "\t",
			"\n";
	} else {
		echo
			$username, "\t",
			FreshRSS_UserDAO::mtime($username), "\t",
			$entryDAO->size(), "\t",
			"\n";
	}
}
