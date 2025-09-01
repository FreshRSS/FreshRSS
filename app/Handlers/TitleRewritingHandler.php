<?php

declare(strict_types=1);

/**
 * @phpstan-type FilterNames 'ireplace'|'replace'|'trim'
 * @phpstan-type VariableNames 'feed'|'title'
 * @phpstan-type SupportedFilter array{name: FilterNames, parameters: int[]}
 * @phpstan-type Filter array{name: FilterNames, parameters?: array<array-key, string>}
 * @phpstan-type Rule array{variable: VariableNames, filters?: list<Filter>}
 */
class FreshRSS_TitleRewriting_Handler {
	private const TOKEN_VARIABLE_START = '{';
	private const TOKEN_VARIABLE_END = '}';
	private const TOKEN_VARIABLE_FILTER = '|';
	private const TOKEN_VARIABLE_FILTER_PARAM_START = '(';
	private const TOKEN_VARIABLE_FILTER_PARAM_END = ')';
	private const TOKEN_VARIABLE_FILTER_PARAM_DELIMITER = ',';
	private const TOKEN_SPACE = ' ';
	private const TOKEN_PARAM_STRING_DELIMITER = '"';

	/** @var list<VariableNames> */
	private const SUPPORTED_VARIABLES = [
		'title',
		'feed',
	];
	/** @var list<SupportedFilter> */
	private const SUPPORTED_FILTERS = [
		[
			'name' => 'trim',
			'parameters' => [
				0,
				1,
			],
		],
		[
			'name' => 'replace',
			'parameters' => [
				2
			],
		],
		[
			'name' => 'ireplace',
			'parameters' => [
				2
			],
		],
	];

	/** @var list<Rule> */
	private array $rules = [];

	public function __construct(string $rules) {
		$this->parseRules($rules);
		$this->cleanRules();
	}

	private function parseRules(string $rules): void {
		if ($rules === '') {
			return;
		}

		$isParsingVariable = false;
		$isParsingFilter = false;
		$isParsingString = true;
		$isParsingParameter = false;
		$isParsingParameterString = false;
		$currentSegment = '';
		$tokens = mb_str_split($rules);
		$length = count($tokens);
		$chunks = [];
		/** @var VariableNames|null */
		$variable = null;
		/** @var list<Filter> */
		$filters = [];
		/** @var FilterNames|null */
		$filter = null;
		/** @var array<array-key, string> */
		$parameters = [];

		for ($i = 0; $i < $length; $i++) {
			$current = $tokens[$i];
			$next = null;

			if (($i + 1) < $length) {
				$next = $tokens[$i + 1];
			}

			// Error detection
			if ($current === self::TOKEN_VARIABLE_FILTER) {
				if ($isParsingParameter && !$isParsingParameterString) { // @phpstan-ignore-line
					throw new FreshRSS_Parsing_Exception('Missing filter end delimiter');
				}
			} elseif ($current === self::TOKEN_VARIABLE_END) {
				if ($next === self::TOKEN_VARIABLE_END) {
					if ($isParsingParameter) {
						throw new FreshRSS_Parsing_Exception('Missing filter end delimiter');
					}
				}
			}

			// Parsing
			if ($current === self::TOKEN_PARAM_STRING_DELIMITER) {
				if ($isParsingParameter) {
					if ($isParsingParameterString) { // @phpstan-ignore-line
						$isParsingParameterString = false;
						continue;
					}

					$isParsingParameterString = true;
					$currentSegment = '';
					continue;
				}
			} elseif ($current === self::TOKEN_VARIABLE_START) {
				if ($next === self::TOKEN_VARIABLE_START) {
					if ($isParsingString && $currentSegment !== '') {
						$chunks[] = $currentSegment;
					}
					$i++;
					$currentSegment = '';
					$isParsingString = false;
					$isParsingVariable = true;
					$isParsingFilter = false;
					$isParsingParameter = false;
					continue;
				}
			} elseif ($current === self::TOKEN_VARIABLE_END) {
				if ($next === self::TOKEN_VARIABLE_END) {
					if ($isParsingVariable) {
						if ($currentSegment !== '') {
							if ($isParsingFilter) {
								$filters[] = [
									'name' => $currentSegment,
								];
								$chunks[] = [
									'variable' => $variable,
									'filters' => $filters,
								];
							} else {
								$chunks[] = [
									'variable' => $currentSegment,
								];
							}
						} else {
							$chunks[] = [
								'variable' => $variable,
								'filters' => $filters,
							];
						}
					}
					$i++;
					$currentSegment = '';
					$variable = null;
					$filters = [];
					$isParsingVariable = false;
					$isParsingFilter = false;
					$isParsingString = true;
					$isParsingParameter = false;
					continue;
				}
			} elseif ($current === self::TOKEN_SPACE) {
				if ($isParsingVariable && !$isParsingParameterString) { // @phpstan-ignore-line
					continue;
				}
			} elseif ($current === self::TOKEN_VARIABLE_FILTER) {
				if ($isParsingVariable && !$isParsingParameterString) { // @phpstan-ignore-line
					if ($currentSegment !== '') {
						if ($isParsingFilter) {
							$filters[] = [
								'name' => $currentSegment,
							];
						} else {
							$variable = $currentSegment;
						}
					}
					$currentSegment = '';
					$isParsingFilter = true;
					$isParsingParameter = false;
					continue;
				}
			} elseif ($current === self::TOKEN_VARIABLE_FILTER_PARAM_START) {
				if ($isParsingFilter && !$isParsingParameterString) { // @phpstan-ignore-line
					$filter = $currentSegment;
					$currentSegment = '';
					$isParsingParameter = true;
					continue;
				}
			} elseif ($current === self::TOKEN_VARIABLE_FILTER_PARAM_END) {
				if ($isParsingFilter && !$isParsingParameterString) { // @phpstan-ignore-line
					$parameters[] = $currentSegment;
					$filters[] = [
						'name' => $filter,
						'parameters' => $parameters,
					];

					$currentSegment = '';
					$filter = null;
					$parameters = [];
					$isParsingParameter = false;
					continue;
				}
			} elseif ($current === self::TOKEN_VARIABLE_FILTER_PARAM_DELIMITER) {
				if ($isParsingFilter && !$isParsingParameterString) { // @phpstan-ignore-line
					$parameters[] = $currentSegment;
					$currentSegment = '';
					continue;
				}
			}

			$currentSegment .= $current;
		}
		if ($isParsingString && $currentSegment !== '') {
			$chunks[] = $currentSegment;
		}

		if ($isParsingVariable) {
			throw new FreshRSS_Parsing_Exception('Missing variable end delimiter');
		}

		$this->rules = $chunks; // @phpstan-ignore-line
	}

	private function cleanRules(): void {
		$filterNames = array_column(self::SUPPORTED_FILTERS, 'name');
		/** @var array<FilterNames, int[]> $filterParams */
		$filterParams = array_reduce(self::SUPPORTED_FILTERS, static function ($carry, $item) {
			$carry[$item['name']] = $item['parameters']; // @phpstan-ignore-line
			return $carry;
		}, []);

		foreach ($this->rules as $chunkKey => $chunk) {
			if (is_string($chunk)) {
				continue;
			}
			if (!in_array($chunk['variable'], self::SUPPORTED_VARIABLES, true)) {
				unset($this->rules[$chunkKey]); // @phpstan-ignore-line
			}
			if (array_key_exists('filters', $chunk)) {
				$filters = [];
				foreach ($chunk['filters'] as $filterKey => $filter) {
					if (!in_array($filter['name'], $filterNames, true)) {
						continue;
					}
					if (!in_array(count($filter['parameters'] ?? []), $filterParams[$filter['name']], true)) {
						continue;
					}
					$filters[] = $filter;
				}
				if ($filters === []) {
					unset($this->rules[$chunkKey]['filters']);
				} else {
					$this->rules[$chunkKey]['filters'] = $filters;
				}
			}
		}
	}

	private function trim(string $variable, ?string $parameter = null): string {
		if ($parameter === null) {
			return trim($variable);
		}
		return trim($variable, $parameter);
	}

	private function replace(string $variable, string $search, string $replace): string {
		return str_replace($search, $replace, $variable);
	}

	private function ireplace(string $variable, string $search, string $replace): string {
		return str_ireplace($search, $replace, $variable);
	}

	public function rewrite(string $title, string $feed): string {
		$value = '';
		foreach ($this->rules as $rule) {
			if (is_string($rule)) {
				$value .= $rule;
				continue;
			}
			$variable = ${$rule['variable']}; // @phpstan-ignore-line
			foreach ($rule['filters'] ?? [] as $filter) {
				/** @var string $variable */
				$variable = call_user_func_array([$this, $filter['name']], array_merge([$variable], $filter['parameters'] ?? []));
			}
			$value .= $variable;
		}

		return $value;
	}
}
