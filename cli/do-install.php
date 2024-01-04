#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

if (file_exists(DATA_PATH . '/applied_migrations.txt')) {
	fail('FreshRSS seems to be already installed!' . "\n" . 'Please use `./cli/reconfigure.php` instead.', EXIT_CODE_ALREADY_EXISTS);
}

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
	'environment' => 'environment',
	'base-url' => 'base_url',
	'language' => 'language',
	'title' => 'title',
	'default-user' => 'default_user',
	'allow-anonymous' => 'allow_anonymous',
	'allow-anonymous-refresh' => 'allow_anonymous_refresh',
	'auth-type' => 'auth_type',
	'api-enabled' => 'api_enabled',
	'allow-robots' => 'allow_robots',
	'disable-update' => 'disable_update',
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

if (!empty($options['invalid']) || empty($options['valid']['default-user']) || !is_string($options['valid']['default-user'])) {
	fail('Usage: ' . basename(__FILE__) . " --default-user admin ( --auth-type form" .
		" --environment production --base-url https://rss.example.net --allow-robots" .
		" --language en --title FreshRSS --allow-anonymous --allow-anonymous-refresh --api-enabled" .
		" --db-type mysql --db-host localhost:3306 --db-user freshrss --db-password dbPassword123" .
		" --db-base freshrss --db-prefix freshrss_ --disable-update )");
}

fwrite(STDERR, 'FreshRSS install…' . "\n");

$config = array(
		'salt' => generateSalt(),
		'db' => FreshRSS_Context::systemConf()->db,
	);

$customConfigPath = DATA_PATH . '/config.custom.php';
if (file_exists($customConfigPath)) {
	$customConfig = include($customConfigPath);
	if (is_array($customConfig)) {
		$config = array_merge($customConfig, $config);
	}
}

foreach ($configParams as $param => $configParam) {
	if (isset($options['valid'][$param])) {
		$config[$configParam] = $options['valid'][$param];
	}
}

if ((!empty($config['base_url'])) && is_string($config['base_url']) && Minz_Request::serverIsPublic($config['base_url'])) {
	$config['pubsubhubbub_enabled'] = true;
}

foreach ($dBconfigParams as $dBparam => $configDbParam) {
	if (isset($options['valid'][$dBparam])) {
		$config['db'][$configDbParam] = $options['valid'][$dBparam];
	}
}

performRequirementCheck($config['db']['type']);

if (!FreshRSS_user_Controller::checkUsername($options['valid']['default-user'])) {
	fail('FreshRSS error: invalid default username “' . $options['valid']['default-user']
		. '”! Must be matching ' . FreshRSS_user_Controller::USERNAME_PATTERN);
}

if (isset($options['valid']['auth-type']) && !in_array($options['valid']['auth-type'], ['form', 'http_auth', 'none'], true)) {
	fail('FreshRSS invalid authentication method (auth-type must be one of { form, http_auth, none })');
}

if (file_put_contents(join_path(DATA_PATH, 'config.php'),
	"<?php\n return " . var_export($config, true) . ";\n") === false) {
	fail('FreshRSS could not write configuration file!: ' . join_path(DATA_PATH, 'config.php'));
}

if (function_exists('opcache_reset')) {
	opcache_reset();
}

FreshRSS_Context::initSystem(true);
Minz_User::change(Minz_User::INTERNAL_USER);

$ok = false;
try {
	$error = initDb();
	if ($error != '') {
		$_SESSION['bd_error'] = $error;
	} else {
		$ok = true;
	}
} catch (Exception $ex) {
	$_SESSION['bd_error'] = $ex->getMessage();
}

if (!$ok) {
	@unlink(join_path(DATA_PATH, 'config.php'));
	fail('FreshRSS database error: ' . (empty($_SESSION['bd_error']) ? 'Unknown error' : $_SESSION['bd_error']));
}

echo 'ℹ️ Remember to create the default user: ', $config['default_user'],
	"\t", './cli/create-user.php --user ', $config['default_user'], " --password 'password' --more-options\n";

accessRights();

if (!setupMigrations()) {
	fail('FreshRSS access right problem while creating migrations version file!');
}

done();
