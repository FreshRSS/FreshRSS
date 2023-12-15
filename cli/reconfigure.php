#!/usr/bin/env php
<?php
declare(strict_types=1);
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
		'db-prefix::',
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
		FreshRSS_Context::systemConf()->$param = $options[$param] === false ? true : $options[$param];
	}
}
$db = FreshRSS_Context::systemConf()->db;
foreach ($dBparams as $dBparam) {
	$dBparam = rtrim($dBparam, ':');
	if (isset($options[$dBparam])) {
		$param = substr($dBparam, strlen('db-'));
		$db[$param] = $options[$dBparam];
	}
}
/** @var array{'type':string,'host':string,'user':string,'password':string,'base':string,'prefix':string,
 *  'connection_uri_params':string,'pdo_options':array<int,int|string|bool>} $db */
FreshRSS_Context::systemConf()->db = $db;

if (!FreshRSS_user_Controller::checkUsername(FreshRSS_Context::systemConf()->default_user)) {
	fail('FreshRSS invalid default username (must be ASCII alphanumeric): ' .
		FreshRSS_Context::systemConf()->default_user);
}

if (isset(FreshRSS_Context::systemConf()->auth_type) &&
	!in_array(FreshRSS_Context::systemConf()->auth_type, ['form', 'http_auth', 'none'], true)) {
	fail('FreshRSS invalid authentication method (auth_type must be one of { form, http_auth, none }: '
		. FreshRSS_Context::systemConf()->auth_type);
}

FreshRSS_Context::systemConf()->save();

done();
