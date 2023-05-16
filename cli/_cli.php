<?php
if (php_sapi_name() !== 'cli') {
	die('FreshRSS error: This PHP script may only be invoked from command line!');
}

const EXIT_CODE_ALREADY_EXISTS = 3;
const REGEX_INPUT_OPTIONS = '/^--/';
const REGEX_PARAM_OPTIONS = '/:*$/';

require(__DIR__ . '/../constants.php');
require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader
require(LIB_PATH . '/lib_install.php');

Minz_Session::init('FreshRSS', true);
FreshRSS_Context::initSystem();
Minz_ExtensionManager::init();
Minz_Translate::init('en');

FreshRSS_Context::$isCli = true;

/** @return never */
function fail(string $message, int $exitCode = 1) {
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

	if (!FreshRSS_Context::initUser($username)) {
		fail('FreshRSS error: invalid configuration for user: ' . $username . "\n");
	}

	$ext_list = FreshRSS_Context::$user_conf->extensions_enabled;
	Minz_ExtensionManager::enableByList($ext_list, 'user');

	return $username;
}

function accessRights(): void {
	echo 'ℹ️ Remember to re-apply the appropriate access rights, such as:',
		"\t", 'sudo cli/access-permissions.sh', "\n";
}

/** @return never */
function done(bool $ok = true) {
	if (!$ok) {
		fwrite(STDERR, (empty($_SERVER['argv'][0]) ? 'Process' : basename($_SERVER['argv'][0])) . ' failed!' . "\n");
	}
	exit($ok ? 0 : 1);
}

function performRequirementCheck(string $databaseType): void {
	$requirements = checkRequirements($databaseType);
	if ($requirements['all'] !== 'ok') {
		$message = 'FreshRSS failed requirements:' . "\n";
		foreach ($requirements as $requirement => $check) {
			if ($check !== 'ok' && !in_array($requirement, ['all', 'pdo', 'message'], true)) {
				$message .= '• ' . $requirement . "\n";
			}
		}
		if (!empty($requirements['message']) && $requirements['message'] !== 'ok') {
			$message .= '• ' . $requirements['message'] . "\n";
		}
		fail($message);
	}
}

/**
 * @param array<string> $options
 * @return array<string>
 */
function getLongOptions(array $options, string $regex): array {
	$longOptions = array_filter($options, static function (string $a) use ($regex) {
		return preg_match($regex, $a);
	});
	return array_map(static function (string $a) use ($regex) {
		return preg_replace($regex, '', $a);
	}, $longOptions);
}

/**
 * @param array<string> $input
 * @param array<string> $params
 */
function validateOptions(array $input, array $params): bool {
	$sanitizeInput = getLongOptions($input, REGEX_INPUT_OPTIONS);
	$sanitizeParams = getLongOptions($params, REGEX_PARAM_OPTIONS);
	$unknownOptions = array_diff($sanitizeInput, $sanitizeParams);

	if (0 === count($unknownOptions)) {
		return true;
	}

	fwrite(STDERR, sprintf("FreshRSS error: unknown options: %s\n", implode (', ', $unknownOptions)));
	return false;
}
