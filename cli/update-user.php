#!/usr/bin/env php
<?php
declare(strict_types=1);

$isUpdate = true;
require(__DIR__ . '/_update-or-create-user.php');

$username = cliInitUser($GLOBALS['options']['valid']['user']);

echo 'FreshRSS updating user “', $username, "”…\n";

$ok = FreshRSS_user_Controller::updateUser(
	$username,
	empty($options['valid']['email']) ? null : $options['valid']['email'],
	empty($options['valid']['password']) ? '' : $options['valid']['password'],
	$GLOBALS['values']);

if (!$ok) {
	fail('FreshRSS could not update user!');
}

if (!empty($options['valid']['api_password'])) {
	$error = FreshRSS_api_Controller::updatePassword($options['valid']['api_password']);
	if ($error) {
		fail($error);
	}
}

invalidateHttpCache($username);

accessRights();

done($ok);
