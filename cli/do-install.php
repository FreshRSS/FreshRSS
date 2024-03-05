#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

if (file_exists(DATA_PATH . '/applied_migrations.txt')) {
	fail('FreshRSS seems to be already installed!' . "\n" . 'Please use `./cli/reconfigure.php` instead.', EXIT_CODE_ALREADY_EXISTS);
}

$cliOptions = new class extends CliOptionsParser {
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

	public function __construct() {
		$this->addRequiredOption('defaultUser', (new CliOption('default-user'))->deprecatedAs('default_user'));
		$this->addOption('environment', (new CliOption('environment')));
		$this->addOption('baseUrl', (new CliOption('base-url'))->deprecatedAs('base_url'));
		$this->addOption('language', (new CliOption('language')));
		$this->addOption('title', (new CliOption('title')));
		$this->addOption(
			'allowAnonymous',
			(new CliOption('allow-anonymous'))->withValueOptional('true')->deprecatedAs('allow_anonymous')->typeOfBool()
		);
		$this->addOption(
			'allowAnonymousRefresh',
			(new CliOption('allow-anonymous-refresh'))->withValueOptional('true')->deprecatedAs('allow_anonymous_refresh')->typeOfBool()
		);
		$this->addOption('authType', (new CliOption('auth-type'))->deprecatedAs('auth_type'));
		$this->addOption(
			'apiEnabled',
			(new CliOption('api-enabled'))->withValueOptional('true')->deprecatedAs('api_enabled')->typeOfBool()
		);
		$this->addOption(
			'allowRobots',
			(new CliOption('allow-robots'))->withValueOptional('true')->deprecatedAs('allow_robots')->typeOfBool()
		);
		$this->addOption(
			'disableUpdate',
			(new CliOption('disable-update'))->withValueOptional('true')->deprecatedAs('disable_update')->typeOfBool()
		);
		$this->addOption('dbType', (new CliOption('db-type')));
		$this->addOption('dbHost', (new CliOption('db-host')));
		$this->addOption('dbUser', (new CliOption('db-user')));
		$this->addOption('dbPassword', (new CliOption('db-password')));
		$this->addOption('dbBase', (new CliOption('db-base')));
		$this->addOption('dbPrefix', (new CliOption('db-prefix'))->withValueOptional());
		parent::__construct();
	}
};

if (!empty($cliOptions->errors)) {
	fail('FreshRSS error: ' . array_shift($cliOptions->errors) . "\n" . $cliOptions->usage);
}

fwrite(STDERR, 'FreshRSS install…' . "\n");

$values = [
	'default_user' => $cliOptions->defaultUser ?? null,
	'environment' => $cliOptions->environment ?? null,
	'base_url' => $cliOptions->baseUrl ?? null,
	'language' => $cliOptions->language ?? null,
	'title' => $cliOptions->title ?? null,
	'allow_anonymous' => $cliOptions->allowAnonymous ?? null,
	'allow_anonymous_refresh' => $cliOptions->allowAnonymousRefresh ?? null,
	'auth_type' => $cliOptions->authType ?? null,
	'api_enabled' => $cliOptions->apiEnabled ?? null,
	'allow_robots' => $cliOptions->allowRobots ?? null,
	'disable_update' => $cliOptions->disableUpdate ?? null,
];

$dbValues = [
	'type' => $cliOptions->dbType ?? null,
	'host' => $cliOptions->dbHost ?? null,
	'user' => $cliOptions->dbUser ?? null,
	'password' => $cliOptions->dbPassword ?? null,
	'base' => $cliOptions->dbBase ?? null,
	'prefix' => $cliOptions->dbPrefix ?? null,
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
