#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

if (file_exists(DATA_PATH . '/applied_migrations.txt')) {
	fail('FreshRSS seems to be already installed!' . "\n" . 'Please use `./cli/reconfigure.php` instead.', EXIT_CODE_ALREADY_EXISTS);
}

$params = array(
		'environment:' => 'environment',
		'base-url:' => 'base_url',
		'language:' => 'language',
		'title:' => 'title',
		'default-user:' => 'default_user',
		'allow-anonymous' => 'allow_anonymous',
		'allow-anonymous-refresh' => 'allow_anonymous_refresh',
		'auth-type:' => 'auth_type',
		'api-enabled' => 'api_enabled',
		'allow-robots' => 'allow_robots',
		'disable-update' => 'disable_update',
	);

$dBparams = array(
		'db-type:' => 'type',
		'db-host:' => 'host',
		'db-user:' => 'user',
		'db-password:' => 'password',
		'db-base:' => 'base',
		'db-prefix::' => 'prefix',
	);

$replacementAndDeprecatedParams = array(
		'base-url' => 'base_url:',
		'default-user' => 'default_user:',
		'allow-anonymous' => 'allow_anonymous',
		'allow-anonymous-refresh' => 'allow_anonymous_refresh',
		'auth-type' => 'auth_type:',
		'api-enabled' => 'api_enabled',
		'allow-robots' => 'allow_robots',
		'disable-update' => 'disable_update',
	);

$cliParams =  array_merge(array_keys($params), array_keys($dBparams), array_values($replacementAndDeprecatedParams));

$options = getopt('', $cliParams);

if (checkforDeprecatedParameterUse($argv, $replacementAndDeprecatedParams)) {
	$options = updateDeprecatedParameters($options, $replacementAndDeprecatedParams);
}

if (!validateOptions($argv, $cliParams) || empty($options['default-user']) || !is_string($options['default-user'])) {
	fail('Usage: ' . basename(__FILE__) . " --default_user admin ( --auth_type form" .
		" --environment production --base_url https://rss.example.net --allow_robots" .
		" --language en --title FreshRSS --allow_anonymous --allow_anonymous_refresh --api_enabled" .
		" --db-type mysql --db-host localhost:3306 --db-user freshrss --db-password dbPassword123" .
		" --db-base freshrss --db-prefix freshrss_ --disable_update )");
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

foreach ($params as $cliParam => $configParam) {
	$cliParam = rtrim($cliParam, ':');
	if (isset($options[$cliParam])) {
		$config[$configParam] = $options[$cliParam] === false ? true : $options[$cliParam];
	}
}

if ((!empty($config['base_url'])) && is_string($config['base_url']) && Minz_Request::serverIsPublic($config['base_url'])) {
	$config['pubsubhubbub_enabled'] = true;
}

foreach ($dBparams as $cliDbParam => $configDbParam) {
	$cliDbParam = rtrim($cliDbParam, ':');
	if (isset($options[$cliDbParam])) {
		$config['db'][$configDbParam] = $options[$cliDbParam];
	}
}

performRequirementCheck($config['db']['type']);

if (!FreshRSS_user_Controller::checkUsername($options['default-user'])) {
	fail('FreshRSS error: invalid default username “' . $options['default-user']
		. '”! Must be matching ' . FreshRSS_user_Controller::USERNAME_PATTERN);
}

if (isset($options['auth-type']) && !in_array($options['auth-type'], ['form', 'http_auth', 'none'], true)) {
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
