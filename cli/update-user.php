#!/usr/bin/php
<?php
$isUpdate = true;
require(__DIR__ . '/_update-or-create-user.php');

$username = cliInitUser($options['user']);

echo 'FreshRSS updating user “', $username, "”…\n";

$ok = FreshRSS_user_Controller::updateUser(
	$username,
	empty($options['mail_login']) ? null : $options['mail_login'],
	empty($options['password']) ? '' : $options['password'],
	empty($options['api_password']) ? '' : $options['api_password'],
	$values);

if (!$ok) {
	fail('FreshRSS could not update user!');
}

invalidateHttpCache($username);

accessRights();

done($ok);
