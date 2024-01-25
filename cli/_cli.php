<?php
declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
	die('FreshRSS error: This PHP script may only be invoked from command line!');
}

const EXIT_CODE_ALREADY_EXISTS = 3;
const REGEX_INPUT_OPTIONS = "/^--(?'long'\w.+)|^-(?'short'\w+)/";

require(__DIR__ . '/../constants.php');
require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader
require(LIB_PATH . '/lib_install.php');

Minz_Session::init('FreshRSS', true);
FreshRSS_Context::initSystem();
Minz_ExtensionManager::init();
Minz_Translate::init('en');

FreshRSS_Context::$isCli = true;

class CommandLineParser {

	/**
	 * Parses and validates options and values used with FreshRSS' CLI commands.
	 * @param array<string,array{'getopt':string,'required':bool,'default':string,'short':string,'deprecated':string,
	 * 'read':callable,'validators':array<callable>}> $parameters
	 * @return array{'valid':array<string,array<string>>,'invalid':array<string,string>} Matrix of 'valid': map of of
	 * all known option names used and their respective values and 'invalid': map of all unknown options used and
	 * their respective error messages.
	 */
	public function parseAndValidateParams(array $parameters): array {
		$parsedParams = $this->parseCliParams($parameters);

		if(!empty($parsedParams['invalid'])) {
			return $parsedParams;
		}

		return $this->validateCliParams($parsedParams['valid'], $parameters);
	}

	/**
	 * Parses parameters used with FreshRSS' CLI commands.
	 * @param array<string,array{'getopt':string,'required':bool,'default':string,'short':string,'deprecated':string,
	 * 'read':callable,'validators':array<callable>}> $parameters
	 * @return array{'valid':array<string,array<string>>,'invalid':array<string,string>} Matrix of 'valid': map of of
	 * all known option names used and their respective values and 'invalid': map of all unknown options used and
	 * their respective error messages.
	 */
	private function parseCliParams(array $parameters): array {
		global $argv;
		$getoptLongOptions = $this->returnGetoptLongOptions($parameters);
		$getoptShortOptions = $this->returnGetoptShortOptions($parameters);

		$options = getopt($getoptShortOptions, $getoptLongOptions);

		$valid = is_array($options) ? $options : [];

		array_walk($valid, static fn(&$opt) => $opt = $opt === false ? [''] : (is_string($opt) ? [$opt] : $opt));

		/** @var array<string,array<string>> $valid */
		$this->checkForDeprecatedOptions(array_keys($valid), $this->returnMap('deprecated', $parameters));

		$valid = $this->replaceOptions($valid, $this->returnMap('short', $parameters));
		$valid = $this->replaceOptions($valid, $this->returnMap('deprecated', $parameters));

		$invalid = $this->findInvalidOptions($argv, $this->returnAllOptions($parameters));

		return [
			'valid' => $valid,
			'invalid' => $invalid
		];
	}

	/**
	 * @param array<string,array<string>> $input
	 * @param array<string,array{'getopt':string,'required':bool,'default':string,'short':string,'deprecated':string,
	 * 'read':callable,'validators':array<callable>}> $validations
	 * @return array{'valid':array<string,array<string>>,'invalid':array<string,string>}
	 */
	private function validateCliParams(array $input, array $validations): array {
		$valid = [];
		$invalid = [];

		foreach ($input as $key => $values) {
			$isValid = true;

			if (!key_exists($key, $validations)) {
				$invalid[$key] = 'unknown option: ' . $key;
				$isValid = false;
			}

			foreach ($validations[$key]['validators'] ?? [] as $validator) {
				foreach ($values as $value) {
					if ($validator($key, $value)) {
						$invalid[$key] = $validator($key, $value);
						$isValid = false;
						break;
					}
				}
			}

			if ($isValid) {
				$valid[$key] = $values;
			}
		}

		foreach ($validations as $key => $checks) {
			if ($checks['required'] && !key_exists($key, $input)) {
				$invalid[$key] = $key . ' cannot be empty';
			}
			if (key_exists('default', $checks) && !key_exists($key, $input)) {
				$valid[$key] = [$validations[$key]['default']];
			}
		}

		return [
			'valid' => $valid,
			'invalid' => $invalid,
		];
	}

	/**
	 * @param array<string> $options
	 * @return array<string>
	 */
	private function getOptions(array $options, string $regex): array {
		$foundOptions = [];

		foreach ($options as $option) {
			preg_match($regex, $option, $matches);

			if(!empty($matches['long'])) {
				$foundOptions[] = $matches['long'];
			}
			if(!empty($matches['short'])) {
				$foundOptions = array_merge($foundOptions, str_split($matches['short']));
			}
		}

		return $foundOptions;
	}

	/**
	* Checks for presence of unknown options.
	* @param array<string> $input List of command line arguments to check for validity.
	* @param array<string> $params List of valid options to check against.
	* @return array<string,string> Returns a list all unknown options found.
	*/
	private function findInvalidOptions(array $input, array $params): array {
		$sanitizeInput = $this->getOptions($input, REGEX_INPUT_OPTIONS);
		$unknownOptions = array_diff($sanitizeInput, $params);

		if (0 === count($unknownOptions)) {
			return [];
		}

		$invalid = [];

		foreach ($unknownOptions as $unknownOption) {
			$invalid[$unknownOption] = 'unknown option: ' . $unknownOption;
		}

		return $invalid;
	}

	/**
	 * Checks for presence of deprecated options.
	 * @param array<string> $optionNames Command line option names to check for deprecation.
	 * @param array<string,string> $params Map of replacement options as keys and their respective deprecated
	 * options as values.
	 * @return bool Returns TRUE and generates a deprecation warning if deprecated options are present, FALSE otherwise.
	 */
	private function checkForDeprecatedOptions(array $optionNames, array $params): bool {
		$deprecatedOptions = array_intersect($optionNames, $params);
		$replacements = array_map(static fn($option) => array_search($option, $params, true), $deprecatedOptions);

		if (0 === count($deprecatedOptions)) {
			return false;
		}

		fwrite(STDERR, "FreshRSS deprecation warning: the CLI option(s): " . implode(', ', $deprecatedOptions) .
			" are deprecated and will be removed in a future release. Use: " . implode(', ', $replacements) .
			" instead\n\n");
		return true;
	}

	/**
	 * Switches items in a list to their provided replacements.
	 * @param array<string,array<string>> $options Map with items to check for replacement as keys.
	 * @param array<string,string> $replacements Map of replacement items as keys and the item they replace as their values.
	 * @return array<string,array<string>> Returns $options with replacements.
	 */
	private function replaceOptions(array $options, array $replacements): array {
		$updatedOptions = [];

		foreach ($options as $name => $values) {
			$replacement = array_search($name, $replacements, true);
			$updatedOptions[$replacement ? $replacement : $name] = $values;
		}

		return $updatedOptions;
	}

	/**
	 * @param array<string,array{'getopt':string,'required':bool,'short':string,'deprecated':string,'read':callable,
	 * 'validators':array<callable>}> $parameters
	 * @return array<string>
	 */
	private function returnGetoptLongOptions(array $parameters): array {
		$output = [];

		foreach ($parameters as $name => $data) {
			$output[] = $name. $data['getopt'];
			$output[] = $data['deprecated'] ?? 0 ? $data['deprecated'] . $data['getopt'] : '';
		}

		return array_filter($output);
	}

	/**
	 * @param array<string,array{'getopt':string,'required':bool,'default':string,'short':string,'deprecated':string,
	 * 'read':callable,'validators':array<callable>}> $parameters
	 */
	private function returnGetoptShortOptions(array $parameters): string {
		$output = '';

		foreach ($parameters as $data) {
			$output .= $data['short'] ?? 0 ? $data['short'] . $data['getopt'] : '';
		}

		return $output;
	}

	/**
	 * @param array<string,array{'getopt':string,'required':bool,'short':string,'deprecated':string,'read':callable,
	 * 'validators':array<callable>}> $haystack
	 * @return array<string,string>
	 */
	private function returnMap(string $needle, array $haystack): array {
		$output = [];

		foreach ($haystack as $option => $data) {
			$output[$option] = isset($data[$needle]) && is_string($data[$needle]) ? $data[$needle] : '';
		}

		return array_filter($output);
	}

	/**
	 * @param array<string,array{'getopt':string,'required':bool,'default':string,'short':string,'deprecated':string,
	 * 'read':callable,'validators':array<callable>}> $parameters
	 * @return array<string>
	 */
	private function returnAllOptions(array $parameters): array {
		$output = [];

		foreach ($parameters as $name => $data) {
			$output[] = $name;
			$output[] = $data['deprecated'] ?? 0 ? $data['deprecated'] : '';
			$output[] = $data['short'] ?? 0 ? $data['short'] : '';
		}

		return array_filter($output);
	}
}

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
 * @param array<string> $validValues
 */
function validateOneOf(array $validValues, string $errorMessageName, ?string $errorMessagePrompt = null): callable {
	$errorMessagePrompt = $errorMessagePrompt ? $errorMessagePrompt : 'one of { ' . implode(', ', $validValues) . ' }';

	return function (string $name, string $value) use ($validValues, $errorMessageName, $errorMessagePrompt): ?string {
		return !in_array($value, $validValues, true)
		? 'invalid ' . $errorMessageName . ': \'' . $value . '\'. ' . $name . ' must be ' . $errorMessagePrompt
		: null;
	};
}

/**
 * @param array<string> $validValues
 */
function validateNotOneOf(array $validValues, string $errorMessageName, ?string $errorMessagePrompt = null): callable {
	$errorMessagePrompt = $errorMessagePrompt ? $errorMessagePrompt : 'one of { ' . implode(', ', $validValues) . ' }';

	return function (string $name, string $value) use ($validValues, $errorMessageName, $errorMessagePrompt): ?string {
		return in_array($value, $validValues, true)
		? 'invalid ' . $errorMessageName . ': \'' . $value . '\'. ' . $name . ' must not be ' . $errorMessagePrompt
		: null;
	};
}

function validateRegex(string $regex, string $errorMessageName, string $errorMessagePrompt): callable {

	return function (string $name, string $value) use ($regex, $errorMessageName, $errorMessagePrompt): ?string {
		return preg_match($regex, $value) !== 1
		? 'invalid ' . $errorMessageName . ': \'' . $value . '\'. ' . $name . ' must be ' . $errorMessagePrompt
		: null;
	};
}

/**
 * @param array<string> $validValues
 */
function validateFileExtension(array $validValues, string $errorMessageName, ?string $errorMessagePrompt = null): callable {
	$errorMessagePrompt = $errorMessagePrompt ? $errorMessagePrompt : 'a path to a file ending in one of { .' . implode(', .', $validValues) . ' }';

	return function (string $name, string $value) use ($validValues, $errorMessageName, $errorMessagePrompt): ?string {
		return !in_array(pathinfo($value, PATHINFO_EXTENSION), $validValues, true)
		? 'invalid ' . $errorMessageName . ': \'' . $value . '\'. ' . $name . ' must be ' . $errorMessagePrompt
		: null;
	};
}

/**
 * Parses parameters used with FreshRSS' CLI commands.
 * @param array<string,array{'getopt':string,'required':bool,'default':string,'short':string,'deprecated':string,
 * 'read':callable,'validators':array<callable>}> $parameters
 * @return array{'valid':array<string,array<string>>,'invalid':array<string,string>} Matrix of 'valid': map of of all known
 * option names used and their respective values and 'invalid': map of all unknown options used and their respective
 * error messages.
 */
function parseAndValidateCliParams(array $parameters): array {
	$parser = new CommandLineParser();

	return $parser->parseAndValidateParams($parameters);
}

function readAsString(): callable {

	return function (array $values): string {
		return strval(array_pop($values));
	};
}

function readAsInt(): callable {

	return function (array $values): int {
		return intval(array_pop($values));
	};
}

function readAsBool(): callable {

	return function (array $values): bool {
		return filter_var(array_pop($values), FILTER_VALIDATE_BOOL);
	};
}

function readAsArrayOfString(): callable {

	return function (array $values): array {
		return array_map(static fn(&$value) => $value = strval($value), $values);
	};
}

/**
 * @return array<string>
 */
function listLanguages(): array {
	return array_values(array_diff(scandir(I18N_PATH) ? : [], ['..', '.']));
}
