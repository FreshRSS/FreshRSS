#!/usr/bin/env php
<?php
declare(strict_types=1);

use FreshRss\Controllers\UserController;
use FreshRss\Models\Context;

require __DIR__ . '/_cli.php';

performRequirementCheck(Context::systemConf()->db['type'] ?? '');

$cliOptions = new class extends CliOptionsParser {
	public string $user;

	public function __construct() {
		$this->addRequiredOption('user', (new CliOption('user')));
		parent::__construct();
	}
};

if (!empty($cliOptions->errors)) {
	fail('FreshRSS error: ' . array_shift($cliOptions->errors) . "\n" . $cliOptions->usage);
}

$username = $cliOptions->user;

if (!UserController::checkUsername($username)) {
	fail('FreshRSS error: invalid username: ' . $username . "\n");
}
if (!UserController::userExists($username)) {
	fail('FreshRSS error: user not found: ' . $username . "\n");
}
if (strcasecmp($username, Context::systemConf()->default_user) === 0) {
	fail('FreshRSS error: default user must not be deleted: “' . $username . '”');
}

echo 'FreshRSS deleting user “', $username, "”…\n";

$ok = UserController::deleteUser($username);

invalidateHttpCache(Context::systemConf()->default_user);

done($ok);
