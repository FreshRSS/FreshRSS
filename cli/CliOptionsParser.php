<?php
declare(strict_types=1);

abstract class CliOptionsParser {
	/** @var array<string,CliOption> */
	private array $options = [];
	/** @var array<string,array{defaultInput:?string[],required:?bool,aliasUsed:?string,values:?string[]}> */
	private array $inputs = [];
	/** @var array<string,string> $errors */
	public array $errors = [];
	public string $usage = '';

	public function __construct() {
		global $argv;

		$this->usage = $this->getUsageMessage($argv[0]);

		$this->parseInput();
		$this->appendUnknownAliases($argv);
		$this->appendInvalidValues();
		$this->appendTypedValidValues();
	}

	private function parseInput(): void {
		$getoptInputs = $this->getGetoptInputs();
		$this->getoptOutputTransformer(getopt($getoptInputs['short'], $getoptInputs['long']));
		$this->checkForDeprecatedAliasUse();
	}

	/** Adds an option that produces an error message if not set. */
	protected function addRequiredOption(string $name, CliOption $option): void {
		$this->inputs[$name] = [
			'defaultInput' => null,
			'required' => true,
			'aliasUsed' => null,
			'values' => null,
		];
		$this->options[$name] = $option;
	}

	/**
	 * Adds an optional option.
	 * @param string $defaultInput If not null this value is received as input in all cases where no
	 *  user input is present. e.g. set this if you want an option to always return a value.
	 */
	protected function addOption(string $name, CliOption $option, ?string $defaultInput = null): void {
		$this->inputs[$name] = [
			'defaultInput' => is_string($defaultInput) ? [$defaultInput] : $defaultInput,
			'required' => null,
			'aliasUsed' => null,
			'values' => null,
		];
		$this->options[$name] = $option;
	}

	private function appendInvalidValues(): void {
		foreach ($this->options as $name => $option) {
			if ($this->inputs[$name]['required'] && $this->inputs[$name]['values'] === null) {
				$this->errors[$name] = 'invalid input: ' . $option->getLongAlias() . ' cannot be empty';
			}
		}

		foreach ($this->inputs as $name => $input) {
			foreach ($input['values'] ?? $input['defaultInput'] ?? [] as $value) {
				switch ($this->options[$name]->getTypes()['type']) {
					case 'int':
						if (!ctype_digit($value)) {
							$this->errors[$name] = 'invalid input: ' . $input['aliasUsed'] . ' must be an integer';
						}
						break;
					case 'bool':
						if (filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === null) {
							$this->errors[$name] = 'invalid input: ' . $input['aliasUsed'] . ' must be a boolean';
						}
						break;
				}
			}
		}
	}

	private function appendTypedValidValues(): void {
		foreach ($this->inputs as $name => $input) {
			$values = $input['values'] ?? $input['defaultInput'] ?? null;
			$types = $this->options[$name]->getTypes();
			if ($values) {
				$validValues = [];
				$typedValues = [];

				switch ($types['type']) {
					case 'string':
						$typedValues = $values;
						break;
					case 'int':
						$validValues = array_filter($values, static fn($value) => ctype_digit($value));
						$typedValues = array_map(static fn($value) => (int)$value, $validValues);
						break;
					case 'bool':
						$validValues = array_filter($values, static fn($value) => filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null);
						$typedValues = array_map(static fn($value) => (bool)filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE), $validValues);
						break;
				}

				if (!empty($typedValues)) {
					// @phpstan-ignore property.dynamicName
					$this->$name = $types['isArray'] ? $typedValues : array_pop($typedValues);
				}
			}
		}
	}

	/** @param array<string,string|false>|false $getoptOutput */
	private function getoptOutputTransformer($getoptOutput): void {
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

			if (!empty($matches['short'])) {
				$foundAliases = array_merge($foundAliases, str_split($matches['short']));
			}
			if (!empty($matches['long'])) {
				$foundAliases[] = $matches['long'];
			}
		}

		return $foundAliases;
	}

	/**
	 * @param array<string> $input List of user command-line inputs.
	 */
	private function appendUnknownAliases(array $input): void {
		$valid = [];
		foreach ($this->options as $option) {
			$valid = array_merge($valid, $option->getAliases());
		}

		$sanitizeInput = $this->getAliasesUsed($input, $this->makeInputRegex());
		$unknownAliases = array_diff($sanitizeInput, $valid);
		if (empty($unknownAliases)) {
			return;
		}

		foreach ($unknownAliases as $unknownAlias) {
			$this->errors[$unknownAlias] = 'unknown option: ' . $unknownAlias;
		}
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
			$shortAlias = $option->getShortAlias() ? '-' . $option->getShortAlias() . ' ' : '';
			$longAlias = '--' . $option->getLongAlias() . ($option->getValueTaken() === 'required' ? '=<' . strtolower($name) . '>' : '');
			if ($this->inputs[$name]['required']) {
				$required[] = $shortAlias . $longAlias;
			} else {
				$optional[] = '[' . $shortAlias . $longAlias . ']';
			}
		}

		return implode(' ', $required) . ' ' . implode(' ', $optional);
	}

	private function makeInputRegex(): string {
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
