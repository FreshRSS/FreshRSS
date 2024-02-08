#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

$parser = new CommandLineParser();

$parser->addRequiredOption('user', (new Option('user')));

$options = $parser->parse(stdClass::class);

if (!empty($options->errors)) {
	fail('FreshRSS error: ' . array_shift($options->errors) . "\n" . $options->usage);
}

$username = $options->user;

if (!FreshRSS_user_Controller::checkUsername($username)) {
	fail('FreshRSS error: invalid username: ' . $username . "\n");
}
if (!FreshRSS_user_Controller::userExists($username)) {
	fail('FreshRSS error: user not found: ' . $username . "\n");
}
if (strcasecmp($username, FreshRSS_Context::systemConf()->default_user) === 0) {
	fail('FreshRSS error: default user must not be deleted: “' . $username . '”');
}

echo 'FreshRSS deleting user “', $username, "”…\n";

$ok = FreshRSS_user_Controller::deleteUser($username);

invalidateHttpCache(FreshRSS_Context::systemConf()->default_user);

done($ok);
