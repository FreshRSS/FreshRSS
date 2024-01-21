<?php
declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
	die('FreshRSS error: This PHP script may only be invoked from command line!');
}

const EXIT_CODE_ALREADY_EXISTS = 3;
const REGEX_INPUT_OPTIONS = '/^-{2}|^-{1}/';

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

/**
 * Parses parameters used with FreshRSS' CLI commands.
 * @param array{'long':array<string,string>,'short':array<string,string>,'deprecated':array<string,string>} $parameters
 * Matrix of 'long': map of long option names as keys and their respective getopt() notations as values,
 * 'short': map of short option names as values and their equivalent long options as keys, 'deprecated': map of
 * replacement option names as keys and their respective deprecated option names as values.
 * @return array{'valid':array<string,string>,'invalid':array<string>} Matrix of 'valid': map of of all known
 * option names used and their respective values and 'invalid': list of all unknown options used.
 */
function parseCliParams(array $parameters): array {
	global $argv;
	$longOptions = [];
	$shortOptions = '';

	foreach ($parameters['long'] as $name => $getopt_note) {
		$longOptions[] = $name . $getopt_note;
	}
	foreach ($parameters['deprecated'] as $name => $deprecatedName) {
		$longOptions[] = $deprecatedName . $parameters['long'][$name];
	}
	foreach ($parameters['short'] as $name => $shortName) {
		$shortOptions .= $shortName . $parameters['long'][$name];
	}

	$options = getopt($shortOptions, $longOptions);

	$valid = is_array($options) ? $options : [];

	array_walk($valid, static fn(&$option) => $option = $option === false ? '' : $option);

	/** @var array<string,string> $valid */
	checkForDeprecatedOptions(array_keys($valid), $parameters['deprecated']);

	$valid = replaceOptions($valid, $parameters['short']);
	$valid = replaceOptions($valid, $parameters['deprecated']);

	$invalid = findInvalidOptions(
		$argv,
		array_merge(array_keys($parameters['long']), array_values($parameters['short']), array_values($parameters['deprecated']))
	);

	return [
		'valid' => $valid,
		'invalid' => $invalid
	];
}

/**
 * @param array<string> $options
 * @return array<string>
 */
function getOptions(array $options, string $regex): array {
	$longOptions = array_filter($options, static function (string $a) use ($regex) {
		return preg_match($regex, $a) === 1;
	});
	return array_map(static function (string $a) use ($regex) {
		return preg_replace($regex, '', $a) ?? '';
	}, $longOptions);
}

/**
 * Checks for presence of unknown options.
 * @param array<string> $input List of command line arguments to check for validity.
 * @param array<string> $params List of valid options to check against.
 * @return array<string> Returns a list all unknown options found.
 */
function findInvalidOptions(array $input, array $params): array {
	$sanitizeInput = getOptions($input, REGEX_INPUT_OPTIONS);
	$unknownOptions = array_diff($sanitizeInput, $params);

	if (0 === count($unknownOptions)) {
		return [];
	}

	fwrite(STDERR, sprintf("FreshRSS error: unknown options: %s\n", implode (', ', $unknownOptions)));
	return $unknownOptions;
}

/**
 * Checks for presence of deprecated options.
 * @param array<string> $optionNames Command line option names to check for deprecation.
 * @param array<string,string> $params Map of replacement options as keys and their respective deprecated
 * options as values.
 * @return bool Returns TRUE and generates a deprecation warning if deprecated options are present, FALSE otherwise.
 */
function checkForDeprecatedOptions(array $optionNames, array $params): bool {
	$deprecatedOptions = array_intersect($optionNames, $params);
	$replacements = array_map(static fn($option) => array_search($option, $params, true), $deprecatedOptions);

	if (0 === count($deprecatedOptions)) {
		return false;
	}

	fwrite(STDERR, "FreshRSS deprecation warning: the CLI option(s): " . implode(', ', $deprecatedOptions) .
		" are deprecated and will be removed in a future release. Use: "
		. implode(', ', $replacements) . " instead\n");
	return true;
}

/**
 * Switches items in a list to their provided replacements.
 * @param array<string,string> $options Map with items to check for replacement as keys.
 * @param array<string,string> $replacements Map of replacement items as keys and the item they replace as their values.
 * @return array<string,string>  Returns $options with replacements.
 */
function replaceOptions(array $options, array $replacements): array {
	$updatedOptions = [];

	foreach ($options as $name => $value) {
		$replacement = array_search($name, $replacements, true);
		$updatedOptions[$replacement ? $replacement : $name] = $value;
	}

	return $updatedOptions;
}
