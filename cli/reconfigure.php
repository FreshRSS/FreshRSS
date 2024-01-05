#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

$parameters = array(
	'valid' => array(
		'environment' => ':',
		'base-url' => ':',
		'language' => ':',
		'title' => ':',
		'default-user' => ':',
		'allow-anonymous' => '',
		'allow-anonymous-refresh' => '',
		'auth-type' => ':',
		'api-enabled' => '',
		'allow-robots' => '',
		'disable-update' => '',
		'db-type' => ':',
		'db-host' => ':',
		'db-user' => ':',
		'db-password' => ':',
		'db-base' => ':',
		'db-prefix' => '::',
	),
	'deprecated' => array(
		'base-url' => 'base_url',
		'default-user' => 'default_user',
		'allow-anonymous' => 'allow_anonymous',
		'allow-anonymous-refresh' => 'allow_anonymous_refresh',
		'auth-type' => 'auth_type',
		'api-enabled' => 'api_enabled',
		'allow-robots' => 'allow_robots',
		'disable-update' => 'disable_update',
	),
);

$configParams = array(
	'environment',
	'base-url',
	'language',
	'title',
	'default-user',
	'allow-anonymous',
	'allow-anonymous-refresh',
	'auth-type',
	'api-enabled',
	'allow-robots',
	'disable-update',
);

$dBconfigParams = array(
	'db-type' => 'type',
	'db-host' => 'host',
	'db-user' => 'user',
	'db-password' => 'password',
	'db-base' => 'base',
	'db-prefix' => 'prefix',
);

$options = parseCliParams($parameters);

if (!empty($options['invalid'])) {
	fail('Usage: ' . basename(__FILE__) . " --default-user admin ( --auth-type form" .
		" --environment production --base-url https://rss.example.net --allow-robots" .
		" --language en --title FreshRSS --allow-anonymous --allow-anonymous-refresh --api-enabled" .
		" --db-type mysql --db-host localhost:3306 --db-user freshrss --db-password dbPassword123" .
		" --db-base freshrss --db-prefix freshrss_ --disable-update )");
}

fwrite(STDERR, 'Reconfiguring FreshRSS…' . "\n");

foreach ($configParams as $param) {
	if (isset($options['valid'][$param])) {
		switch ($param) {
			case 'allow-anonymous-refresh':
				FreshRSS_Context::systemConf()->allow_anonymous_refresh = true;
				break;
			case 'allow-anonymous':
				FreshRSS_Context::systemConf()->allow_anonymous = true;
				break;
			case 'allow-robots':
				FreshRSS_Context::systemConf()->allow_robots = true;
				break;
			case 'api-enabled':
				FreshRSS_Context::systemConf()->api_enabled = true;
				break;
			case 'auth-type':
				if (in_array($options['valid'][$param], ['form', 'http_auth', 'none'], true)) {
					FreshRSS_Context::systemConf()->auth_type = $options['valid'][$param];
				} else {
					fail('FreshRSS invalid authentication method! auth_type must be one of { form, http_auth, none }');
				}
				break;
			case 'base-url':
				FreshRSS_Context::systemConf()->base_url = (string) $options['valid'][$param];
				break;
			case 'default-user':
				if (FreshRSS_user_Controller::checkUsername((string) $options['valid'][$param])) {
					FreshRSS_Context::systemConf()->default_user = (string) $options['valid'][$param];
				} else {
					fail('FreshRSS invalid default username! default_user must be ASCII alphanumeric');
				}
				break;
			case 'disable-update':
				FreshRSS_Context::systemConf()->disable_update = true;
				break;
			case 'environment':
				if (in_array($options['valid'][$param], ['development', 'production', 'silent'], true)) {
					FreshRSS_Context::systemConf()->environment = $options['valid'][$param];
				} else {
					fail('FreshRSS invalid environment! environment must be one of { development, production, silent }');
				}
				break;
			case 'language':
				FreshRSS_Context::systemConf()->language = (string) $options['valid'][$param];
				break;
			case 'title':
				FreshRSS_Context::systemConf()->title = (string) $options['valid'][$param];
				break;
		}
	}
}
$db = FreshRSS_Context::systemConf()->db;
foreach ($dBconfigParams as $dBparam => $configDbParam) {
	if (isset($options['valid'][$dBparam])) {
		$db[$configDbParam] = $options['valid'][$dBparam];
	}
}
/** @var array{'type':string,'host':string,'user':string,'password':string,'base':string,'prefix':string,
 *  'connection_uri_params':string,'pdo_options':array<int,int|string|bool>} $db */
FreshRSS_Context::systemConf()->db = $db;

FreshRSS_Context::systemConf()->save();

done();
