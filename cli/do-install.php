#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

if (file_exists(DATA_PATH . '/applied_migrations.txt')) {
	fail('FreshRSS seems to be already installed!' . "\n" . 'Please use `./cli/reconfigure.php` instead.', EXIT_CODE_ALREADY_EXISTS);
}

$i18nFile = new I18nFile();
$i18nData = new I18nData($i18nFile->load());

/** @var array<string,array{'getopt':string,'required':bool,'short':string,'deprecated':string,'read':callable,
 * 'validators':array<callable>}> $parameters */
$parameters = [
	'environment' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsString(),
		'validators' => [
			validateOneOf(['development', 'production', 'silent'], 'environment setting')
		],
	],
	'base-url' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsString(),
		'deprecated' => 'base_url',
	],
	'language' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsString(),
		'validators' => [
			validateOneOf($i18nData->getAvailableLanguages(), 'language setting', 'an iso 639-1 code for a supported language')
		],
	],
	'title' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsString(),
	],
	'default-user' => [
		'getopt' => ':',
		'required' => true,
		'read' => readAsString(),
		'deprecated' => 'default_user',
		'validators' => [
			validateRegex(FreshRSS_user_Controller::USERNAME_PATTERN, 'default username', 'ASCII alphanumeric')
		],
	],
	'allow-anonymous' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsBool(),
		'deprecated' => 'allow_anonymous',
		'validators' => [validateOneOf(['true', 'false'], 'value')],
	],
	'allow-anonymous-refresh' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsBool(),
		'deprecated' => 'allow_anonymous_refresh',
		'validators' => [validateOneOf(['true', 'false'], 'value')],
	],
	'auth-type' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsString(),
		'deprecated' => 'auth_type',
		'validators' => [
			validateOneOf(['form', 'http_auth', 'none'], 'authentication method')
		],
	],
	'api-enabled' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsBool(),
		'deprecated' => 'api_enabled',
		'validators' => [validateOneOf(['true', 'false'], 'value')],
	],
	'allow-robots' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsBool(),
		'deprecated' => 'allow_robots',
		'validators' => [validateOneOf(['true', 'false'], 'value')],
	],
	'disable-update' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsBool(),
		'deprecated' => 'disable_update',
		'validators' => [validateOneOf(['true', 'false'], 'value')],
	],
	'help' => [
		'getopt' => '',
		'required' => false,
		'read' => readAsString(),
	],
	'db-type' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsString(),
		'validators' => [
			validateOneOf(['sqlite', 'mysql', 'pgsql'], 'database type')
		],
	],
	'db-host' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsString(),
	],
	'db-user' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsString(),
	],
	'db-password' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsString(),
	],
	'db-base' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsString(),
	],
	'db-prefix' => [
		'getopt' => '::',
		'required' => false,
		'read' => readAsString(),
	],
];

$configParams = [
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
];

$dBconfigParams = [
	'db-type' => 'type',
	'db-host' => 'host',
	'db-user' => 'user',
	'db-password' => 'password',
	'db-base' => 'base',
	'db-prefix' => 'prefix',
];

$options = parseAndValidateCliParams($parameters);
$error = empty($options['invalid']) ? '' : current($options['invalid']);

if (key_exists('help', $options['valid']) || !empty($error)) {
	!empty($error) ? fwrite(STDERR, "\nFreshRSS error: $error\n\n") : '';
	exit();
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
	$configValue = $parameters[$param]['read']($param, $options['valid']);
	if ($configValue) {
		$config[$configParam] = $configValue;
	}
}

if ((!empty($config['base_url'])) && is_string($config['base_url']) && Minz_Request::serverIsPublic($config['base_url'])) {
	$config['pubsubhubbub_enabled'] = true;
}

foreach ($dBconfigParams as $dBparam => $configDbParam) {
	$configValue = $parameters[$dBparam]['read']($dBparam, $options['valid']);
	if ($configValue) {
		$config['db'][$configDbParam] = $configValue;
	}
}

performRequirementCheck($config['db']['type']);

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
