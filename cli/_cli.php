<?php
declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
	die('FreshRSS error: This PHP script may only be invoked from command line!');
}

const EXIT_CODE_ALREADY_EXISTS = 3;

require dirname(__DIR__) . '/constants.php';
require LIB_PATH . '/lib_rss.php';	//Includes class autoloader
require LIB_PATH . '/lib_install.php';
require_once __DIR__ . '/CliOption.php';
require_once __DIR__ . '/CliOptionsParser.php';

Minz_Session::init('FreshRSS', true);
FreshRSS_Context::initSystem();
Minz_ExtensionManager::init();
Minz_Translate::init(Minz_Translate::DEFAULT_LANGUAGE);

FreshRSS_Context::$isCli = true;

function fail(string $message, int $exitCode = 1): never {
	fwrite(STDERR, $message . "\n");
	die($exitCode);
}

function cliInitUser(string $username): string {
	if (!FreshRSS_user_Controller::checkUsername($username)) {
		fail('FreshRSS error: invalid username: ' . $username . "\n");
	}

	if (!FreshRSS_user_Controller::userExists($username)) {
		fail('FreshRSS error: user not found: ' . $username . "\n");
	}

	FreshRSS_Context::initUser($username);
	if (!FreshRSS_Context::hasUserConf()) {
		fail('FreshRSS error: invalid configuration for user: ' . $username . "\n");
	}

	$ext_list = FreshRSS_Context::userConf()->extensions_enabled;
	Minz_ExtensionManager::enableByList($ext_list, 'user');

	return $username;
}

function accessRights(): void {
	echo 'ℹ️ Remember to re-apply the appropriate access rights, such as:',
		"\t", 'sudo cli/access-permissions.sh', "\n";
}

function done(bool $ok = true): never {
	if (!$ok) {
		fwrite(STDERR, (isset($_SERVER['argv']) && is_array($_SERVER['argv']) && !empty($_SERVER['argv'][0]) && is_string($_SERVER['argv'][0]) ?
			basename($_SERVER['argv'][0]) : 'Process') . ' failed!' . "\n");
	}
	exit($ok ? 0 : 1);
}

function requirementStatus(string $key, string $status): string {
	if ($key === 'php') {
		return _t('install.check.' . $key . '.' . ($status === 'ok' ? 'ok' : 'nok'), PHP_VERSION, FRESHRSS_MIN_PHP_VERSION);
	}
	return _t('install.check.' . $key . '.' . ($status === 'ok' ? 'ok' : 'nok'));
}

function performRequirementCheck(string $databaseType): void {
	if (!in_array($databaseType, ['mysql', 'pgsql', 'sqlite'], true)) {
		fail('Invalid database type!');
	}
	$requirements = checkRequirements($databaseType);
	$message = '';

	if (in_array('warn', array_values($requirements), true)) {
		$message .= 'FreshRSS failed recommendations:' . "\n";
		foreach ($requirements as $requirement => $check) {
			if ($check === 'warn') {
				$message .= '⚠ ' . $requirement . ': ' . requirementStatus($requirement, $check) . "\n";
			}
		}
		$message .= "\n";
	}

	if ($requirements['all'] !== 'ok') {
		$message .= 'FreshRSS failed requirements:' . "\n";
		foreach ($requirements as $requirement => $check) {
			if ($check === 'ko' && !in_array($requirement, ['all'], true)) {
				$message .= '❌ ' . $requirement . ': ' . requirementStatus($requirement, $check) . "\n";
			}
		}
		fail($message);
	}

	$message = trim($message);
	if ($message !== '') {
		fwrite(STDERR, $message . "\n");
	}
}
