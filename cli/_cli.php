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
	public const VALUE_NONE = 'none';
	public const VALUE_REQUIRED = 'required';
	public const VALUE_OPTIONAL = 'optional';

	private string $valueTaken = self::VALUE_REQUIRED;
	/** @var array{type:string,isArray:bool} $types */
	private array $types = ['type' => 'string', 'isArray' => false];
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

	public function typeOfString(): static {
		$this->types = ['type' => 'string', 'isArray' => false];
		return $this;
	}

	public function typeOfInt(): static {
		$this->types = ['type' => 'int', 'isArray' => false];
		return $this;
	}

	public function typeOfBool(): static {
		$this->types = ['type' => 'bool', 'isArray' => false];
		return $this;
	}

	public function typeOfArrayOfString(): static {
		$this->types = ['type' => 'string', 'isArray' => true];
		return $this;
	}

	public function deprecatedAs(string $deprecated): static {
		$this->deprecatedAlias = $deprecated;
		return $this;
	}

	public function getValueTaken(): string {
		return $this->valueTaken;
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

	/** @return array{type:string,isArray:bool} */
	public function getTypes(): array {
		return $this->types;
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
		$output->usage = $this->getUsageMessage($argv[0]);

		$this->parseInput();
		$output = $this->appendUnknownAliases($argv, $output);
		$output = $this->appendInvalidValues($output);
		$output = $this->appendTypedValues($output);

		return $output;
	}

	private function parseInput(): void {
		$getoptInputs = $this->getGetoptInputs();

		$this->getoptOutputTransformer(getopt($getoptInputs['short'], $getoptInputs['long']));

		$this->checkForDeprecatedAliasUse();
	}

	/**
	 * @template T
	 * @param T $output
	 * @return T
	 */
	private function appendInvalidValues($output) {
		foreach ($this->options as $name => $option) {
			if ($this->inputs[$name]['required'] && $this->inputs[$name]['values'] === null) {
				$output->errors[$name] = 'invalid input: ' . $option->getLongAlias() . ' cannot be empty';
			}
		}

		foreach ($this->inputs as $name => $input) {
			foreach ($input['values'] ?? $input['default'] ?? [] as $value) {
				switch ($this->options[$name]->getTypes()['type']) {
					case 'int':
						if (!ctype_digit($value)) {
							$output->errors[$name] = 'invalid input: ' . $input['aliasUsed'] . ' must be an integer';
						}
					case 'bool':
						if (filter_var($value, FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE) === null) {
							$output->errors[$name] = 'invalid input: ' . $input['aliasUsed'] . ' must be a boolean';
						}
				}
			}
		}

		return $output;
	}

	/**
	 * @template T
	 * @param T $output
	 * @return T
	 */
	private function appendTypedValues($output) {
		foreach ($this->inputs as $name => $input) {
			$values = $input['values'] ?? $input['default'] ?? null;
			$types = $this->options[$name]->getTypes();
			if ($values) {
				$typedValues = [];

				switch ($types['type']) {
					case 'string':
						$typedValues = $values;
						break;
					case 'int':
						$typedValues = array_map(static fn($value) => (int) $value, $values);
						break;
					case 'bool':
						$typedValues = array_map(static fn($value) => (bool) filter_var($value, FILTER_VALIDATE_BOOL), $values);
						break;
				}

				/** @var stdClass $output */
				$output->$name = $types['isArray'] ? $typedValues : array_pop($typedValues);
			}
		}

		/** @var T $output */
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
	 * @param array<string> $userInputs
	 * @return array<string>
	 */
	private function getAliasesUsed(array $userInputs, string $regex): array {
		$foundAliases = [];

		foreach ($userInputs as $input) {
			preg_match($regex, $input, $matches);

			if(!empty($matches['short'])) {
				$foundAliases = array_merge($foundAliases, str_split($matches['short']));
			}
			if(!empty($matches['long'])) {
				$foundAliases[] = $matches['long'];
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

		$sanitizeInput = $this->getAliasesUsed($input, $this->makeInputRegex());
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
	private function checkForDeprecatedAliasUse(): bool {
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
		$getoptNotation = [
			'none' => '',
			'required' => ':',
			'optional' => '::',
		];

		$long = [];
		$short = '';

		foreach ($this->options as $option) {
			$long[] = $option->getLongAlias() . $getoptNotation[$option->getValueTaken()];
			$long[] = $option->getDeprecatedAlias() ? $option->getDeprecatedAlias() . $getoptNotation[$option->getValueTaken()] : '';
			$short .= $option->getShortAlias() ? $option->getShortAlias() . $getoptNotation[$option->getValueTaken()] : '';
		}

		return [
			'long' => array_filter($long),
			'short' => $short
		];
	}

	private function getUsageMessage(string $command): string {
		$required = ['Usage: ' . basename($command)];
		$optional = [];

		foreach ($this->options as $name => $option) {
			if ($this->inputs[$name]['required']) {
				$required[] = ($option->getShortAlias() ? '-' . $option->getShortAlias() : '') .
				' --' . $option->getLongAlias() .
				($option->getValueTaken() === 'required' ? '=<' . strtolower($name) . '>' : '');
			} else {
				$optional[] = ($option->getShortAlias() ? '[-' . $option->getShortAlias() . ' ' : '[') .
				'--' . $option->getLongAlias() .
				($option->getValueTaken() === 'required' ? '=<' . strtolower($name) . '>' : '') . ']';
			}
		}

		return implode(' ', $required) . ' ' . implode(' ', $optional);
	}

	private function makeInputRegex() : string {
		$shortWithValues = '';
		foreach ($this->options as $option) {
			if (($option->getValueTaken() === 'required' || $option->getValueTaken() === 'optional') && $option->getShortAlias()) {
				$shortWithValues .= $option->getShortAlias();
			}
		}

		return $shortWithValues === ''
			? "/^--(?'long'[^=]+)|^-(?<short>\w+)/"
			: "/^--(?'long'[^=]+)|^-(?<short>(?(?=\w*[$shortWithValues])[^$shortWithValues]*[$shortWithValues]|\w+))/";
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
