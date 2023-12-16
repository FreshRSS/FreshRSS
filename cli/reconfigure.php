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
		switch ($param) {
			case 'allow_anonymous_refresh':
				FreshRSS_Context::systemConf()->allow_anonymous_refresh = true;
				break;
			case 'allow_anonymous':
				FreshRSS_Context::systemConf()->allow_anonymous = true;
				break;
			case 'allow_robots':
				FreshRSS_Context::systemConf()->allow_robots = true;
				break;
			case 'api_enabled':
				FreshRSS_Context::systemConf()->api_enabled = true;
				break;
			case 'auth_type':
				if (in_array($options[$param], ['form', 'http_auth', 'none'], true)) {
					FreshRSS_Context::systemConf()->auth_type = $options[$param];
				} else {
					fail('FreshRSS invalid authentication method! auth_type must be one of { form, http_auth, none }');
				}
				break;
			case 'base_url':
				FreshRSS_Context::systemConf()->base_url = $options[$param];
				break;
			case 'default_user':
				if (FreshRSS_user_Controller::checkUsername($options[$param])) {
					FreshRSS_Context::systemConf()->default_user = $options[$param];
				} else {
					fail('FreshRSS invalid default username! default_user must be ASCII alphanumeric');
				}
				break;
			case 'disable_update':
				FreshRSS_Context::systemConf()->disable_update = true;
				break;
			case 'environment':
				if (in_array($options[$param], ['development', 'production', 'silent'], true)) {
					FreshRSS_Context::systemConf()->environment = $options[$param];
				} else {
					fail('FreshRSS invalid environment! environment must be one of { development, production, silent }');
				}
				break;
			case 'language':
				FreshRSS_Context::systemConf()->language = $options[$param];
				break;
			case 'title':
				FreshRSS_Context::systemConf()->title = $options[$param];
				break;
		}
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

FreshRSS_Context::systemConf()->save();

done();
