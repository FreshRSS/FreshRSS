#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

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
		$this->addOption('defaultUser', (new CliOption('default-user'))->deprecatedAs('default_user'));
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

fwrite(STDERR, 'Reconfiguring FreshRSS…' . "\n");

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

$systemConf = FreshRSS_Context::systemConf();
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
		// @phpstan-ignore assign.propertyType, property.dynamicName
		$systemConf->$name = $value;
	}
}

$db = array_merge(FreshRSS_Context::systemConf()->db, array_filter($dbValues));

performRequirementCheck($db['type']);

FreshRSS_Context::systemConf()->db = $db;

FreshRSS_Context::systemConf()->save();

done();
