#!/usr/bin/env php
<?php
$isUpdate = false;
require(__DIR__ . '/_update-or-create-user.php');

$username = $GLOBALS['options']['user'];
if (!FreshRSS_user_Controller::checkUsername($username)) {
	fail('FreshRSS error: invalid username “' . $username .
		'”! Must be matching ' . FreshRSS_user_Controller::USERNAME_PATTERN);
}

$usernames = listUsers();
if (preg_grep("/^$username$/i", $usernames)) {
	fail('FreshRSS warning: username already exists “' . $username . '”', EXIT_CODE_ALREADY_EXISTS);
}

echo 'FreshRSS creating user “', $username, "”…\n";

$ok = FreshRSS_user_Controller::createUser(
	$username,
	empty($options['mail_login']) ? '' : $options['mail_login'],
	empty($options['password']) ? '' : $options['password'],
	$GLOBALS['values'],
	!isset($options['no_default_feeds'])
);

if (!$ok) {
	fail('FreshRSS could not create user!');
}

if (!empty($options['api_password'])) {
	$username = cliInitUser($username);
	$error = FreshRSS_api_Controller::updatePassword($options['api_password']);
	if ($error) {
		fail($error);
	}
}

invalidateHttpCache(FreshRSS_Context::$system_conf->default_user);

echo 'ℹ️ Remember to refresh the feeds of the user: ', $username ,
	"\t", './cli/actualize-user.php --user ', $username, "\n";

accessRights();

done($ok);
