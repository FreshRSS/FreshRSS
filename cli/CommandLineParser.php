<?php
declare(strict_types=1);

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
						break;
					case 'bool':
						if (filter_var($value, FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE) === null) {
							$output->errors[$name] = 'invalid input: ' . $input['aliasUsed'] . ' must be a boolean';
						}
						break;
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
				$required[] = ($option->getShortAlias() ? '-' . $option->getShortAlias() . ' ' : '--') .
				$option->getLongAlias() . ($option->getValueTaken() === 'required' ? '=<' . strtolower($name) . '>' : '');
			} else {
				$optional[] = ($option->getShortAlias() ? '[-' . $option->getShortAlias() . ' ' : '[--') .
				$option->getLongAlias() . ($option->getValueTaken() === 'required' ? '=<' . strtolower($name) . '>' : '') . ']';
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
