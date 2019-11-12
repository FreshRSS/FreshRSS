#!/usr/bin/php
<?php
require(__DIR__ . '/_cli.php');

$params = array(
	'user:',
);

$options = getopt('', $params);

if (!validateOptions($argv, $params) || empty($options['user'])) {
	fail('Usage: ' . basename(__FILE__) . " --user username");
}
$username = $options['user'];
if (!user_Controller::checkUsername($username)) {
	fail('FreshRSS error: invalid username “' . $username . '”');
}

$usernames = listUsers();
if (!preg_grep("/^$username$/i", $usernames)) {
	fail('FreshRSS error: username not found “' . $username . '”');
}

if (strcasecmp($username, Context::$system_conf->default_user) === 0) {
	fail('FreshRSS error: default user must not be deleted: “' . $username . '”');
}

echo 'FreshRSS deleting user “', $username, "”…\n";

$ok = user_Controller::deleteUser($username);

invalidateHttpCache(Context::$system_conf->default_user);

done($ok);
