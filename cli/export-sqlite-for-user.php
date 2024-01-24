#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

/** @var array<string,array{'getopt':string,'required':bool,'default':string,'short':string,'deprecated':string,
 *  'read':callable,'validators':array<callable>}> $parameters */
$parameters = [
	'user' => [
		'getopt' => ':',
		'required' => true,
		'read' => readAsString(),
		'validators' => [
			validateOneOf(listUsers(), 'username', 'the name of an existing user')
		],
	],
	'filename' => [
		'getopt' => ':',
		'required' => true,
		'read' => readAsString(),
		'validators' => [
			validateFileExtension(['sqlite'], 'file extension', 'a path to a .sqlite file')
		]
	]
];

$options = parseAndValidateCliParams($parameters);

$error = empty($options['invalid']) ? 0 : 1;
if (key_exists('help', $options['valid']) || $error) {
	$error ? fwrite(STDERR, "\nFreshRSS error: " . current($options['invalid']) . "\n\n") : '';
	exit($error);
}

$username = cliInitUser($parameters['user']['read']($options['valid']['user']));
$filename = $parameters['user']['read']($options['valid']['filename']);

echo 'FreshRSS exporting database to SQLite for user “', $username, "”…\n";

$databaseDAO = FreshRSS_Factory::createDatabaseDAO($username);
$ok = $databaseDAO->dbCopy($filename, FreshRSS_DatabaseDAO::SQLITE_EXPORT);

done($ok);
