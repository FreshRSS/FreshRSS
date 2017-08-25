#!/usr/bin/php
<?php
$isUpdate = false;
require('_update-or-create-user.php');

$username = $options['user'];
if (!FreshRSS_user_Controller::checkUsername($username)) {
	fail('FreshRSS error: invalid username “' . $username .
		'”! Must be matching ' . FreshRSS_user_Controller::USERNAME_PATTERN);
}

$usernames = listUsers();
if (preg_grep("/^$username$/i", $usernames)) {
	fail('FreshRSS error: username already taken “' . $username . '”');
}

echo 'FreshRSS creating user “', $username, "”…\n";

$ok = FreshRSS_user_Controller::createUser($username,
	empty($options['password']) ? '' : $options['password'],
	empty($options['api_password']) ? '' : $options['api_password'],
	$values,
	!isset($options['no-default-feeds']));

if (!$ok) {
	fail('FreshRSS could not create user!');
}

invalidateHttpCache(FreshRSS_Context::$system_conf->default_user);

echo '• Remember to refresh the feeds of the user: ', $username , "\n",
	"\t", './cli/actualize-user.php --user ', $username, "\n";

accessRights();

done($ok);
