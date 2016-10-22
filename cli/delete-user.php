#!/usr/bin/php
<?php
require('_cli.php');

$options = getopt('', array(
		'user:',
	));

if (empty($options['user'])) {
	fail('Usage: ' . basename(__FILE__) . " --user=username");
}
$username = $options['user'];
if (!ctype_alnum($username)) {
	fail('FreshRSS error: invalid username “' . $username . '”');
}

$usernames = listUsers();
if (!preg_grep("/^$username$/i", $usernames)) {
	fail('FreshRSS error: username not found “' . $username . '”');
}

if (strcasecmp($username, FreshRSS_Context::$system_conf->default_user) === 0) {
	fail('FreshRSS error: default user must not be deleted: “' . $username . '”');
}

echo 'FreshRSS deleting user “', $username, "”…\n";

$ok = FreshRSS_user_Controller::deleteUser($username);

invalidateHttpCache(FreshRSS_Context::$system_conf->default_user);

done($ok);
