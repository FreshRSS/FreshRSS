<?php
declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
	die('FreshRSS error: This PHP script may only be invoked from command line!');
}

const EXIT_CODE_ALREADY_EXISTS = 3;

require(__DIR__ . '/../constants.php');
require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader
require(LIB_PATH . '/lib_install.php');

Minz_Session::init('FreshRSS', true);
FreshRSS_Context::initSystem();
Minz_ExtensionManager::init();
Minz_Translate::init('en');

FreshRSS_Context::$isCli = true;

class Option {
	public const VALUE_NONE = '';
	public const VALUE_REQUIRED = ':';
	public const VALUE_OPTIONAL = '::';

	private string $valueTaken = self::VALUE_REQUIRED;
	/** @var array{type:string,isArray:bool} $types */
	private array $types = ['type' => 'string', 'isArray' => false];
	/** @var callable[] $validators */
	private array $validators = [];
	private string $optionalValueDefault = '';
	private ?string $deprecatedAlias = null;

	public function __construct(private readonly string $longAlias, private readonly ?string $shortAlias = null) {
	}

	public function withValueNone(): static {
		$this->valueTaken = static::VALUE_NONE;

		return $this;
	}

	public function withValueRequired(): static {
		$this->valueTaken = static::VALUE_REQUIRED;

		return $this;
	}

	public function withValueOptional(string $optionalValueDefault = ''): static {
		$this->valueTaken = static::VALUE_OPTIONAL;
		$this->optionalValueDefault = $optionalValueDefault;

		return $this;
	}

	public function typeOfString(callable ...$validators): static {
		$this->types = ['type' => 'string', 'isArray' => false];
		$this->validators = $validators;

		return $this;
	}

	public function typeOfInt(callable ...$validators): static {
		$this->types = ['type' => 'int', 'isArray' => false];
		$this->validators = $validators;

		return $this;
	}

	public function typeOfBool(callable ...$validators): static {
		$this->types = ['type' => 'bool', 'isArray' => false];
		$this->validators = $validators;

		return $this;
	}

	public function typeOfArrayOfString(callable ...$validators): static {
		$this->types = ['type' => 'string', 'isArray' => true];
		$this->validators = $validators;

		return $this;
	}

	public function deprecatedAs(string $deprecated): static {
		$this->deprecatedAlias = $deprecated;

		return $this;
	}

	public function getValueTaken(): string {
		return $this->valueTaken;
	}

	/** @param string[] $values*/
	public function castToType($values): mixed {
		$typedValues = [];

		switch ($this->types['type']) {
			case 'string' :
				$typedValues = $values;
				break;
			case 'int' :
				$typedValues = array_map(static fn(&$value) => $value = (int) $value, $values);
				break;
			case 'bool' :
				$typedValues = array_map(static fn(&$value) => $value = (bool) filter_var($value, FILTER_VALIDATE_BOOL), $values);
			break;
		}

		return $this->types['isArray'] ? $typedValues : array_pop($typedValues);
	}

	/** @return array<callable> */
	public function getValidators(): array {
		return $this->validators;
	}

	public function getOptionalValueDefault(): string {
		return $this->optionalValueDefault;
	}

	public function getDeprecatedAlias(): ?string {
		return $this->deprecatedAlias;
	}

	public function getLongAlias(): string {
		return $this->longAlias;
	}

	public function getShortAlias(): ?string {
		return $this->shortAlias;
	}

	/** @return string[] */
	public function getAliases(): array {
		$aliases = [
			$this->longAlias,
			$this->shortAlias,
			$this->deprecatedAlias,
		];

		return array_filter($aliases);
	}
}

class CommandLineParser {
	private const REGEX_INPUT_ALIASES = "/^--(?'long'\w.+)=|^-(?'short'\w+)/";

	/** @var array<string,Option> */
	private array $options;
	/** @var array<string,array{default:?string[],required:?bool,aliasUsed:?string,values:?string[]}> */
	private array $inputs;

	public function addRequiredOption(string $name, Option $option): static {
		$this->inputs[$name] = [
			'default' => null,
			'required' => true,
			'aliasUsed' => null,
			'values' => null,
		];
		$this->options[$name] = $option;

		return $this;
	}

	public function addOption(string $name, Option $option, string $default = null) :static {
		$this->inputs[$name] = [
			'default' => is_string($default) ? [$default] : $default,
			'required' => null,
			'aliasUsed' => null,
			'values' => null,
		];
		$this->options[$name] = $option;

		return $this;
	}

	/**
	 * @template T
	 * @param class-string<T> $target
	 * @return T
	 */
	public function parse(string $target) {
		global $argv;

		$output = new $target();
		$output->errors = [];

		$this->parseOptions();
		$output = $this->appendUnknownAliases($argv, $output);
		$output = $this->appendInvalidValues($output);

		if (!empty($output->errors)) {
			$output->usage = $this->getUsage($argv[0]);
			return $output;
		}

		foreach ($this->inputs as $name => $input) {
			$values = $input['values'] ?? $input['default'] ?? null;
			if ($values !== null) {
				/** @var stdClass $output */
				$output->$name = $this->options[$name]->castToType($values);
			}
		}
		/** @var T $output */
		return $output;
	}

	private function parseOptions(): void {
		$getoptInputs = $this->getGetoptInputs();

		$this->getoptOutputTransformer(getopt($getoptInputs['short'], $getoptInputs['long']));

		$this->checkForDeprecatedAliases();
	}

	/**
	 * @template T
	 * @param T $output
	 * @return T
	 */
	private function appendInvalidValues($output) {
		foreach ($this->options as $name => $option) {
			if ($this->inputs[$name]['required'] && $this->inputs[$name]['values'] === null) {
				$output->errors[$name] = $option->getLongAlias() . ' cannot be empty';
			}
		}

		foreach ($this->inputs as $name => $input) {
			foreach ($this->options[$name]->getValidators() as $validator) {
				foreach ($input['values'] ?? $input['default'] ?? [] as $value) {
					$isInvalid = $validator($input['aliasUsed'] ?? $this->options[$name]->getLongAlias(), $value);
					if ($isInvalid) {
						$output->errors[$name] = $isInvalid;
						break;
					}
				}
			}
		}

		return $output;
	}

	/** @param array<string,string|false>|false $getoptOutput */
	private function getoptOutputTransformer(false|array $getoptOutput): void {
		$getoptOutput = is_array($getoptOutput) ? $getoptOutput : [];

		foreach ($getoptOutput as $alias => $value) {
			foreach ($this->options as $name => $data) {
				if (in_array($alias, $data->getAliases(), true)) {
					$this->inputs[$name]['aliasUsed'] = $alias;
					$this->inputs[$name]['values'] = $value === false
						? [$data->getOptionalValueDefault()]
						: (is_array($value)
							? $value
							: [$value]);
				}
			}
		}
	}

	/**
	 * @param array<string> $options
	 * @return array<string>
	 */
	private function getAliasesUsed(array $userInputs, string $regex): array {
		$foundAliases = [];

		foreach ($userInputs as $input) {
			preg_match($regex, $input, $matches);

			if(!empty($matches['short'])) {
				$foundAliases = str_split($matches['short']);
			}
			if(!empty($matches['long'])) {
				$foundAliases = array_merge($foundAliases, $matches['short']);
			}
		}

		return $foundAliases;
	}

	/**
	 * @template T
	 * @param array<string> $input List of user command-line inputs.
	 * @param T $output
	 * @return T
	 */
	private function appendUnknownAliases(array $input, $output) {
		$valid = [];
		foreach ($this->options as $option) {
			$valid = array_merge($valid, $option->getAliases());
		}

		$sanitizeInput = $this->getAliasesUsed($input, self::REGEX_INPUT_ALIASES);
		$unknownAliases = array_diff($sanitizeInput, $valid);
		if (empty($unknownAliases)) {
			return $output;
		}

		foreach ($unknownAliases as $unknownAlias) {
			$output->errors[$unknownAlias] = 'unknown option: ' . $unknownAlias;
		}

		return $output;
	}

	/**
	 * Checks for presence of deprecated aliases.
	 * @return bool Returns TRUE and generates a deprecation warning if deprecated aliases are present, FALSE otherwise.
	 */
	private function checkForDeprecatedAliases(): bool {
		$deprecated = [];
		$replacements = [];

		foreach ($this->inputs as $name => $data) {
			if ($data['aliasUsed'] !== null && $data['aliasUsed'] === $this->options[$name]->getDeprecatedAlias()) {
				$deprecated[] = $this->options[$name]->getDeprecatedAlias();
				$replacements[] = $this->options[$name]->getLongAlias();
			}
		}

		if (empty($deprecated)) {
			return false;
		}

		fwrite(STDERR, "FreshRSS deprecation warning: the CLI option(s): " . implode(', ', $deprecated) .
			" are deprecated and will be removed in a future release. Use: " . implode(', ', $replacements) .
			" instead\n");
		return true;
	}

	/** @return array{long:array<string>,short:string}*/
	private function getGetoptInputs(): array {
		$long = [];
		$short = '';

		foreach ($this->options as $option) {
			$long[] = $option->getLongAlias() . $option->getValueTaken();
			$long[] = $option->getDeprecatedAlias() ? $option->getDeprecatedAlias() . $option->getValueTaken() : '';
			$short .= $option->getShortAlias() ? $option->getShortAlias() . $option->getValueTaken() : '';
		}

		return [
			'long' => array_filter($long),
			'short' => $short
		];
	}

	private function getUsage(string $command): string {
		$required = ['Usage: ' . basename($command)];
		$optional = [];

		foreach ($this->options as $name => $option) {
			if ($this->inputs[$name]['required']) {
				$required[] = ($option->getShortAlias() ? '-' . $option->getShortAlias() : '') .
				' --' . $option->getLongAlias() .
				($option->getValueTaken() === ':' ? '=<' . strtolower($name) . '>': '');
			} else {
				$optional[] = ($option->getShortAlias() ? '[-' . $option->getShortAlias() . ' ' : '[') .
				'--' . $option->getLongAlias() .
				($option->getValueTaken() === ':' ? '=<' . strtolower($name) . '>': '') . ']';
			}
		}

		return implode(' ', $required) . ' ' . implode(' ', $optional);
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

/** @param array<string> $validValues */
function validateOneOf(array $validValues, ?string $prompt = null): callable {
	$prompt = $prompt ? $prompt : 'one of { ' . implode(', ', $validValues) . ' }';

	return function (string $name, string $value) use ($validValues, $prompt): ?string {
		return !in_array($value, $validValues, true)
		? '\'' . $name . '\' given: ' . $value . '. expected ' . $prompt
		: null;
	};
}

/** @param array<string> $validValues */
function validateNotOneOf(array $validValues, ?string $prompt = null): callable {
	$prompt = $prompt ? $prompt : 'one of { ' . implode(', ', $validValues) . ' }';

	return function (string $name, string $value) use ($validValues, $prompt): ?string {
		return in_array($value, $validValues, true)
		? '\'' . $name . '\' given: ' . $value . '. must not be ' . $prompt
		: null;
	};
}

function validateRegex(string $regex, string $prompt): callable {

	return function (string $name, string $value) use ($regex, $prompt): ?string {
		return preg_match($regex, $value) !== 1
		? '\'' . $name . '\' given: \'' . $value . '\'. expected  ' . $prompt
		: null;
	};
}

/** @param array<string> $validValues */
function validateFileExtension(array $validValues, ?string $prompt = null): callable {
	$prompt = $prompt ? $prompt : 'a path to a file ending in one of { .' . implode(', .', $validValues) . ' }';

	return function (string $name, string $value) use ($validValues, $prompt): ?string {
		return !in_array(pathinfo($value, PATHINFO_EXTENSION), $validValues, true)
		? '\'' . $name . '\' given: ' . $value . '. expected ' . $prompt
		: null;
	};
}

function validateBool(): callable {
	return function (string $name, string $value): ?string {
		return !in_array($value, ['true', 'false'], true)
		? '\'' . $name . '\' given: ' . $value . '. expected either \'true\' or \'false\''
		: null;
	};
}

function validateIsUser(): callable {
	return function (string $name, string $value): ?string {
		return !in_array($value, listUsers(), true)
		? '\'' . $name . '\' given: ' . $value . '. expected the name of an existing user'
		: null;
	};
}

function validateIsLanguage(): callable {
	return function (string $name, string $value): ?string {
		return !in_array($value, listLanguages(), true)
		? '\'' . $name . '\' given: ' . $value . '. expected an iso 639-1 code for a supported language'
		: null;
	};
}

/**
 * @return array<string>
 */
function listLanguages(): array {
	return array_values(array_diff(scandir(I18N_PATH) ? : [], ['..', '.']));
}
