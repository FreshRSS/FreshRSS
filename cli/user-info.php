#!/usr/bin/php
<?php
require('_cli.php');

function formatSize($bytes)
{//http://www.php.net/manual/function.disk-free-space.php#103382
	$si_prefix = array('', 'k', 'M', 'G', 'T', 'P');
	$i = min((int)log($bytes, 1024), count($si_prefix) - 1);
	return ($i <= 0) ? $bytes.'B' :
		round($bytes / pow(1024, $i), 2).' '.$si_prefix[$i].'B';
}

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
			formatSize($entryDAO->size()), "\t",
			"\n";
	} else {
		echo
			$username, "\t",
			FreshRSS_UserDAO::mtime($username), "\t",
			$entryDAO->size(), "\t",
			"\n";
	}
}
