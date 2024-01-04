#!/usr/bin/env php
<?php
declare(strict_types=1);

$isUpdate = false;
require(__DIR__ . '/_update-or-create-user.php');

$username = $GLOBALS['options']['valid']['user'];
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
	empty($options['valid']['email']) ? '' : $options['valid']['email'],
	empty($options['valid']['password']) ? '' : $options['valid']['password'],
	$GLOBALS['values'],
	!isset($options['valid']['no-default-feeds'])
);

if (!$ok) {
	fail('FreshRSS could not create user!');
}

if (!empty($options['valid']['api-password'])) {
	$username = cliInitUser($username);
	$error = FreshRSS_api_Controller::updatePassword($options['valid']['api-password']);
	if ($error !== false) {
		fail($error);
	}
}

invalidateHttpCache(FreshRSS_Context::systemConf()->default_user);

echo 'ℹ️ Remember to refresh the feeds of the user: ', $username ,
	"\t", './cli/actualize-user.php --user ', $username, "\n";

accessRights();

done($ok);
