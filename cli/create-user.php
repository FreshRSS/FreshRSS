#!/usr/bin/php
<?php
require('_cli.php');

$options = getopt('', array(
		'user:',
		'password:',
		'api-password:',
		'language:',
		'email:',
		'token:',
		'no-default-feeds',
	));

if (empty($options['user'])) {
	fail('Usage: ' . basename(__FILE__) . " --user username ( --password 'password' --api-password 'api_password'" .
		" --language en --email user@example.net --token 'longRandomString --no-default-feeds' )");
}
$username = $options['user'];
if (!ctype_alnum($username)) {
	fail('FreshRSS error: invalid username “' . $username . '”');
}

$usernames = listUsers();
if (preg_grep("/^$username$/i", $usernames)) {
	fail('FreshRSS error: username already taken “' . $username . '”');
}

echo 'FreshRSS creating user “', $username, "”…\n";

$ok = FreshRSS_user_Controller::createUser($username,
	empty($options['password']) ? '' : $options['password'],
	empty($options['api-password']) ? '' : $options['api-password'],
	array(
		'language' => empty($options['language']) ? '' : $options['language'],
		'token' => empty($options['token']) ? '' : $options['token'],
	),
	!isset($options['no-default-feeds']));

if (!$ok) {
	fail('FreshRSS could not create user!');
}

invalidateHttpCache(FreshRSS_Context::$system_conf->default_user);

accessRights();

done($ok);
