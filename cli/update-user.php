#!/usr/bin/env php
<?php
$isUpdate = true;
require(__DIR__ . '/_update-or-create-user.php');

$username = cliInitUser($GLOBALS['options']['user']);

echo 'FreshRSS updating user “', $username, "”…\n";

$ok = FreshRSS_user_Controller::updateUser(
	$username,
	empty($options['mail_login']) ? null : $options['mail_login'],
	empty($options['password']) ? '' : $options['password'],
	$GLOBALS['values']);

if (!$ok) {
	fail('FreshRSS could not update user!');
}

if (!empty($options['api_password'])) {
	$error = FreshRSS_api_Controller::updatePassword($options['api_password']);
	if ($error) {
		fail($error);
	}
}

invalidateHttpCache($username);

accessRights();

done($ok);
