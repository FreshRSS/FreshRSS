#!/usr/bin/php
<?php
require(__DIR__ . '/_cli.php');

$params = array(
		'environment:',
		'base_url:',
		'language:',
		'title:',
		'default_user:',
		'allow_anonymous',
		'allow_anonymous_refresh',
		'auth_type:',
		'api_enabled',
		'allow_robots',
		'disable_update',
	);

$dBparams = array(
		'db-type:',
		'db-host:',
		'db-user:',
		'db-password:',
		'db-base:',
		'db-prefix:',
	);

$options = getopt('', array_merge($params, $dBparams));

if (!validateOptions($argv, array_merge($params, $dBparams))) {
	fail('Usage: ' . basename(__FILE__) . " --default_user admin ( --auth_type form" .
		" --environment production --base_url https://rss.example.net --allow_robots" .
		" --language en --title FreshRSS --allow_anonymous --allow_anonymous_refresh --api_enabled" .
		" --db-type mysql --db-host localhost:3306 --db-user freshrss --db-password dbPassword123" .
		" --db-base freshrss --db-prefix freshrss_ --disable_update )");
}

fwrite(STDERR, 'Reconfiguring FreshRSS…' . "\n");

$config = Configuration::get('system');
foreach ($params as $param) {
	$param = rtrim($param, ':');
	if (isset($options[$param])) {
		$config->$param = $options[$param] === false ? true : $options[$param];
	}
}
$db = $config->db;
foreach ($dBparams as $dBparam) {
	$dBparam = rtrim($dBparam, ':');
	if (isset($options[$dBparam])) {
		$param = substr($dBparam, strlen('db-'));
		$db[$param] = $options[$dBparam];
	}
}
$config->db = $db;

if (!user_Controller::checkUsername($config->default_user)) {
	fail('FreshRSS invalid default username (must be ASCII alphanumeric): ' . $config->default_user);
}

if (isset($config->auth_type) && !in_array($config->auth_type, array('form', 'http_auth', 'none'))) {
	fail('FreshRSS invalid authentication method (auth_type must be one of { form, http_auth, none }: '
		. $config->auth_type);
}

$config->save();

done();
