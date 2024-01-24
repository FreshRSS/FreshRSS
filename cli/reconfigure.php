#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

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
			validateOneOf(listLanguages(), 'language setting', 'an iso 639-1 code for a supported language')
		],
	],
	'title' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsString(),
	],
	'default-user' => [
		'getopt' => ':',
		'required' => false,
		'read' => readAsString(),
		'deprecated' => 'default_user',
		'validators' => [
			validateRegex('/^' . FreshRSS_user_Controller::USERNAME_PATTERN . '$/', 'default username', 'ASCII alphanumeric')
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

$error = empty($options['invalid']) ? 0 : 1;
if (key_exists('help', $options['valid']) || $error) {
	$error ? fwrite(STDERR, "\nFreshRSS error: " . current($options['invalid']) . "\n\n") : '';
	reconfigureHelp($error);
}

/** @var stdClass $systemConf */
$systemConf = FreshRSS_Context::systemConf();
foreach ($configParams as $param => $configParam) {
	$readAsValue = $parameters[$param]['read']($param, $options['valid']);
	if ($readAsValue) {
		$systemConf->$configParam = $readAsValue;
	}
}

/** @var array{'type':string,'host':string,'user':string,'password':string,'base':string,'prefix':string,
 *  'connection_uri_params':string,'pdo_options':array<int,int|string|bool>} $db */
$db = FreshRSS_Context::systemConf()->db;
foreach ($dBconfigParams as $dBparam => $configDbParam) {
	$readAsValue = $parameters[$dBparam]['read']($dBparam, $options['valid']);
	if ($readAsValue) {
		$db[$configDbParam] = $readAsValue;
	}
}

FreshRSS_Context::systemConf()->db = $db;

FreshRSS_Context::systemConf()->save();

done();

function reconfigureHelp(int $exitCode = 0): void {
	$file = str_replace(__DIR__ . '/', '', __FILE__);

	echo <<<HELP
NAME
	$file

SYNOPSIS
	php $file [OPTION]...

DESCRIPTION
	Reconfigures a FreshRSS instance.

	[--default-user=<defaultuser>]
		sets the default user of this FreshRSS instance.

	[--auth-type=<authtype>]
		sets method used for user login.
		---
		default: form
		options:
			- form
			- http_auth
			- none
		---

	[--environment=<environment>]
		sets log messaging behavior.
		---
		default: production
		options:
			- production
			- development
			- silent
		---

	[--base-url=<baseurl>]
		address of the FreshRSS instance, used when building absolute URLs.
		---
		default: http://localhost:8080/
		---

	[--language=<language>]
		sets instance language.
		---
		default: en
		---

	[--title=<title>]
		web interface title for this instance.
		---
		default: FreshRSS
		---

	[--allow-anonymous=<true|false>]
		sets whether non logged-in visitors are permitted to see the default user's feeds.
		---
		default: false
		---

	[--allow-anonymous-refresh=<true|false>]
		sets whether to allow anonymous users to start the refresh process.
		---
		default: false
		---

	[--api-enabled=<true|false>]
		sets whether the API may be used for mobile apps.
		---
		default: false
		---

	[--allow-robots=<true|false>]
		sets permissions on robots (e.g. search engines) in HTML headers.
		---
		default: false
		---

	[--disable-update=<true|false>]
		sets whether updating is disabled.
		---
		default: false
		---

	[--help]
		displays this help text.

	[--db-type=<dbtype>]
		sets type of database used.
		---
		default: sqlite
		options:
			- sqlite
			- mysql
			- pgsql
		---

	[--db-host=<dburl>]
		sets URL of the database server.
		---
		default: 'localhost'
		---

	[--db-user=<dbuser>]
		sets database user.

	[--db-password=<password>]
		sets database password.

	[--db-base=<dbname>]
		sets database name.

	[--db-prefix=<dbprefix>]
		sets a prefix used in the names of database tables.
		---
		default: freshrss_
		---

HELP;
	exit($exitCode);
}
