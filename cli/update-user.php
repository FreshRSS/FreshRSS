#!/usr/bin/php
<?php
$isUpdate = true;
require('./_update-or-create-user.php');

$username = cliInitUser($options['user']);

echo 'FreshRSS updating user “', $username, "”…\n";

$ok = FreshRSS_user_Controller::updateContextUser(
	empty($options['password']) ? '' : $options['password'],
	empty($options['api_password']) ? '' : $options['api_password'],
	$values);

if (!$ok) {
	fail('FreshRSS could not update user!');
}

invalidateHttpCache($username);

accessRights();

done($ok);
