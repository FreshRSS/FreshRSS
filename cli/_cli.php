<?php
declare(strict_types=1);

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

function parseCliParams(array $parameters): array {
	global $argv;

	foreach ($parameters['valid'] as $param => $getopt_val) {
		$cliParams[] = $param . $getopt_val;
	}
	foreach ($parameters['deprecated'] as $param => $deprecatedParam) {
		$cliParams[] = $deprecatedParam . $parameters['valid'][$param];
	}

	$options['valid'] = getopt('', $cliParams);

	array_walk($options['valid'], static fn(&$option) => $option = $option === false ? true: $option);

	if (checkforDeprecatedParameterUse(array_keys($options['valid']), $parameters['deprecated'])) {
		$options['valid'] = updateDeprecatedParameters($options['valid'], $parameters['deprecated']);
	}

	$options['invalid'] = findInvalidOptions(
		$argv,
		array_merge(array_keys($parameters['valid']), array_values($parameters['deprecated']))
	);

	return $options;
}

/**
 * @param array<string> $options
 * @return array<string>
 */
function getLongOptions(array $options, string $regex): array {
	$longOptions = array_filter($options, static function (string $a) use ($regex) {
		return preg_match($regex, $a) === 1;
	});
	return array_map(static function (string $a) use ($regex) {
		return preg_replace($regex, '', $a) ?? '';
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

function findInvalidOptions(array $input, array $params): array {
	$sanitizeInput = getLongOptions($input, REGEX_INPUT_OPTIONS);
	$unknownOptions = array_diff($sanitizeInput, $params);

	if (0 === count($unknownOptions)) {
		return [];
	}

	fwrite(STDERR, sprintf("FreshRSS error: unknown options: %s\n", implode (', ', $unknownOptions)));
	return $unknownOptions;
}

/**
 * Checks for use of deprecated parameters with FreshRSS' CLI commands.
 * @param array<string> $options User inputs to check for deprecated parameter use.
 * @param array<string> $params Deprecated parameters to check for use of in $options.
 * @return bool Returns TRUE and generates a deprecation warning if deprecated parameters
 * have been used, FALSE otherwise.
 */
function checkforDeprecatedParameterUse(array $options, array $params): bool {
	$deprecatedOptions = array_intersect($options, $params);
	$replacements = array_map(static fn($option) => array_search($option, $params), $deprecatedOptions);

	if (0 === count($deprecatedOptions)) {
		return false;
	}

	trigger_error("The FreshRss CLI option(s): " . implode (', ', $deprecatedOptions) .
		" are deprecated and will be removed in a future release. Use: "
		. implode (', ', $replacements) . " instead", E_USER_DEPRECATED);
	return true;
}

/**
 * Switches all used deprecated parameters to their replacements if they have one.
 * @param array<string> $options User inputs.
 * @param array<string> $params An array with replacement parameters as keys and their respective deprecated
 * parameters as values, eg.
 * ```php
 * ['replacement parameter' => 'deprecated parameter']
 * ```
 * @return array<string>  Returns $options with deprications replaced.
 */
function updateDeprecatedParameters(array $options, array $params): array {
	foreach ($options as $param => $option) {
		if (array_search($param, $params)) {
			$updatedOptions[array_search($param, $params)] = $option;
		} else {
			$updatedOptions[$param] = $option;
		}
	}

	return $updatedOptions;
}
