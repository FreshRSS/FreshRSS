#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

if (file_exists(DATA_PATH . '/applied_migrations.txt')) {
	fail('FreshRSS seems to be already installed!' . "\n" . 'Please use `./cli/reconfigure.php` instead.', EXIT_CODE_ALREADY_EXISTS);
}

final class DoInstallDefinition extends CommandLineParser {
	public string $defaultUser;
	public string $environment;
	public string $baseUrl;
	public string $language;
	public string $title;
	public bool $allowAnonymous;
	public bool $allowAnonymousRefresh;
	public string $authType;
	public bool $apiEnabled;
	public bool $allowRobots;
	public bool $disableUpdate;
	public string $dbType;
	public string $dbHost;
	public string $dbUser;
	public string $dbPassword;
	public string $dbBase;
	public string $dbPrefix;
}

$options = new DoInstallDefinition();
$options->addRequiredOption('defaultUser', (new Option('default-user'))->deprecatedAs('default_user'));
$options->addOption('environment', (new Option('environment')));
$options->addOption('baseUrl', (new Option('base-url'))->deprecatedAs('base_url'));
$options->addOption('language', (new Option('language')));
$options->addOption('title', (new Option('title')));
$options->addOption(
	'allowAnonymous',
	(new Option('allow-anonymous'))->withValueOptional('true')->deprecatedAs('allow_anonymous')->typeOfBool()
);
$options->addOption(
	'allowAnonymousRefresh',
	(new Option('allow-anonymous-refresh'))->withValueOptional('true')->deprecatedAs('allow_anonymous_refresh')->typeOfBool()
);
$options->addOption('authType', (new Option('auth-type'))->deprecatedAs('auth_type'));
$options->addOption(
	'apiEnabled',
	(new Option('api-enabled'))->withValueOptional('true')->deprecatedAs('api_enabled')->typeOfBool()
);
$options->addOption(
	'allowRobots',
	(new Option('allow-robots'))->withValueOptional('true')->deprecatedAs('allow_robots')->typeOfBool()
);
$options->addOption(
	'disableUpdate',
	(new Option('disable-update'))->withValueOptional('true')->deprecatedAs('disable_update')->typeOfBool()
);
$options->addOption('dbType', (new Option('db-type')));
$options->addOption('dbHost', (new Option('db-host')));
$options->addOption('dbUser', (new Option('db-user')));
$options->addOption('dbPassword', (new Option('db-password')));
$options->addOption('dbBase', (new Option('db-base')));
$options->addOption('dbPrefix', (new Option('db-prefix'))->withValueOptional());

if (!empty($options->errors)) {
	fail('FreshRSS error: ' . array_shift($options->errors) . "\n" . $options->usage);
}

fwrite(STDERR, 'FreshRSS install…' . "\n");

$values = [
	'default_user' => $options->defaultUser ?? null,
	'environment' => $options->environment ?? null,
	'base_url' => $options->baseUrl ?? null,
	'language' => $options->language ?? null,
	'title' => $options->title ?? null,
	'allow_anonymous' => $options->allowAnonymous ?? null,
	'allow_anonymous_refresh' => $options->allowAnonymousRefresh ?? null,
	'auth_type' => $options->authType ?? null,
	'api_enabled' => $options->apiEnabled ?? null,
	'allow_robots' => $options->allowRobots ?? null,
	'disable_update' => $options->disableUpdate ?? null,
];

$dbValues = [
	'type' => $options->dbType ?? null,
	'host' => $options->dbHost ?? null,
	'user' => $options->dbUser ?? null,
	'password' => $options->dbPassword ?? null,
	'base' => $options->dbBase ?? null,
	'prefix' => $options->dbPrefix ?? null,
];

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

foreach ($values as $name => $value) {
	if ($value !== null) {
		switch ($name) {
			case 'default_user':
				if (!FreshRSS_user_Controller::checkUsername($value)) {
					fail('FreshRSS invalid default username! default_user must be ASCII alphanumeric');
				}
				break;
			case 'environment':
				if (!in_array($value, ['development', 'production', 'silent'], true)) {
					fail('FreshRSS invalid environment! environment must be one of { development, production, silent }');
				}
				break;
			case 'auth_type':
				if (!in_array($value, ['form', 'http_auth', 'none'], true)) {
					fail('FreshRSS invalid authentication method! auth_type must be one of { form, http_auth, none }');
				}
				break;
		}
		$config[$name] = $value;
	}
}

if ((!empty($config['base_url'])) && is_string($config['base_url']) && Minz_Request::serverIsPublic($config['base_url'])) {
	$config['pubsubhubbub_enabled'] = true;
}

$config['db'] = array_merge($config['db'], array_filter($dbValues));

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
