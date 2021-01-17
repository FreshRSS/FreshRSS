#!/usr/bin/env php
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

foreach ($params as $param) {
	$param = rtrim($param, ':');
	if (isset($options[$param])) {
		FreshRSS_Context::$system_conf->$param = $options[$param] === false ? true : $options[$param];
	}
}
$db = FreshRSS_Context::$system_conf->db;
foreach ($dBparams as $dBparam) {
	$dBparam = rtrim($dBparam, ':');
	if (isset($options[$dBparam])) {
		$param = substr($dBparam, strlen('db-'));
		$db[$param] = $options[$dBparam];
	}
}
FreshRSS_Context::$system_conf->db = $db;

if (!FreshRSS_user_Controller::checkUsername(FreshRSS_Context::$system_conf->default_user)) {
	fail('FreshRSS invalid default username (must be ASCII alphanumeric): ' .
		FreshRSS_Context::$system_conf->default_user);
}

if (isset(FreshRSS_Context::$system_conf->auth_type) &&
	!in_array(FreshRSS_Context::$system_conf->auth_type, array('form', 'http_auth', 'none'))) {
	fail('FreshRSS invalid authentication method (auth_type must be one of { form, http_auth, none }: '
		. FreshRSS_Context::$system_conf->auth_type);
}

FreshRSS_Context::$system_conf->save();

done();
