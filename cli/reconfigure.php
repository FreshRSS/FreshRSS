#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

$parser = new CommandLineParser();

$parser->addRequiredOption(
	'defaultUser',
	(new Option('default-user'))
	   ->deprecatedAs('default_user')
	   ->typeOfString(validateRegex('/^' . FreshRSS_user_Controller::USERNAME_PATTERN . '$/', 'ASCII alphanumeric input'))
);
$parser->addOption('environment', (new Option('environment'))->typeOfString(validateOneOf(['development', 'production', 'silent'])));
$parser->addOption('baseUrl', (new Option('base-url'))->deprecatedAs('base_url'));
$parser->addOption('language', (new Option('language'))->typeOfString(validateIsLanguage()));
$parser->addOption('title', (new Option('title')));
$parser->addOption(
	'allowAnonymous',
	(new Option('allow-anonymous'))
	   ->withValueOptional('true')
	   ->deprecatedAs('allow_anonymous')
	   ->typeOfBool(validateBool())
);
$parser->addOption(
	'allowAnonymousRefresh',
	(new Option('allow-anonymous-refresh'))
	   ->withValueOptional('true')
	   ->deprecatedAs('allow_anonymous_refresh')
	   ->typeOfBool(validateBool())
);
$parser->addOption(
	'authType',
	(new Option('auth-type'))
	   ->deprecatedAs('auth_type')
	   ->typeOfString(validateOneOf(['form', 'http_auth', 'none']))
);
$parser->addOption(
	'apiEnabled',
	(new Option('api-enabled'))
	   ->withValueOptional('true')
	   ->deprecatedAs('api_enabled')
	   ->typeOfBool(validateBool())
);
$parser->addOption(
	'allowRobots',
	(new Option('allow-robots'))
	   ->withValueOptional('true')
	   ->deprecatedAs('allow_robots')
	   ->typeOfBool(validateBool())
);
$parser->addOption(
	'disableUpdate',
	(new Option('disable-update'))
	   ->withValueOptional('true')
	   ->deprecatedAs('disable_update')
	   ->typeOfBool(validateBool())
);
$parser->addOption('dbType', (new Option('db-type'))->typeOfString(validateOneOf(['sqlite', 'mysql', 'pgsql'])));
$parser->addOption('dbHost', (new Option('db-host')));
$parser->addOption('dbUser', (new Option('db-user')));
$parser->addOption('dbPassword', (new Option('db-password')));
$parser->addOption('dbBase', (new Option('db-base')));
$parser->addOption('dbPrefix', (new Option('db-prefix'))->withValueOptional());

$options = $parser->parse(stdClass::class);

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

/** @var stdClass $systemConf */
$systemConf = FreshRSS_Context::systemConf();
foreach ($values as $name => $value) {
	if ($value) {
		$systemConf->$name = $value;
	}
}
$db = array_merge(FreshRSS_Context::systemConf()->db, array_filter($dbValues));
FreshRSS_Context::systemConf()->db = $db;

FreshRSS_Context::systemConf()->save();

done();
