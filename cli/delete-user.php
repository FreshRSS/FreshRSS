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
];

$options = parseAndValidateCliParams($parameters);

$error = empty($options['invalid']) ? 0 : 1;
if (key_exists('help', $options['valid']) || $error) {
	$error ? fwrite(STDERR, "\nFreshRSS error: " . current($options['invalid']) . "\n\n") : '';
	exit($error);
}

$username = cliInitUser($parameters['user']['read']($options['valid']['user']));
if (strcasecmp($username, FreshRSS_Context::systemConf()->default_user) === 0) {
	fail('FreshRSS error: default user must not be deleted: “' . $username . '”');
}

echo 'FreshRSS deleting user “', $username, "”…\n";

$ok = FreshRSS_user_Controller::deleteUser($username);

invalidateHttpCache(FreshRSS_Context::systemConf()->default_user);

done($ok);
