#!/usr/bin/php
<?php
require('_cli.php');

$options = getopt('', array(
		'user:',
		'password::',
		'api-password::',
		'language::',
		'email::',
		'token::',
	));

if (empty($options['user'])) {
	fail('Usage: ' . basename(__FILE__) . " --user=username --password='password' --api-password='api_password'" .
		" --language=en --email=user@example.net --token='longRandomString'");
}
$new_user_name = $options['user'];
if (!ctype_alnum($new_user_name)) {
	fail('FreshRSS error: invalid username “' . $new_user_name . '”');
}

$usernames = listUsers();
if (preg_grep("/^$new_user_name$/i", $usernames)) {
	fail('FreshRSS error: username already taken “' . $new_user_name . '”');
}

echo 'FreshRSS creating user “', $new_user_name, "”…\n";

$ok = FreshRSS_user_Controller::createUser($new_user_name,
	empty($options['password']) ? '' : $options['password'],
	empty($options['api-password']) ? '' : $options['api-password'],
	array(
		'language' => empty($options['language']) ? '' : $options['language'],
		'token' => empty($options['token']) ? '' : $options['token'],
	));

invalidateHttpCache(FreshRSS_Context::$system_conf->default_user);

echo 'Result: ', ($ok ? 'success' : 'fail'), ".\n";
exit($ok ? 0 : 1);
