<?php

declare(strict_types=1);

class FreshRSS_TitleRewriting_Handler {
	private const TOKEN_VARIABLE_START = '{';
	private const TOKEN_VARIABLE_END = '}';
	private const TOKEN_VARIABLE_FILTER = '|';
	private const TOKEN_VARIABLE_FILTER_PARAM_START = '(';
	private const TOKEN_VARIABLE_FILTER_PARAM_END = ')';
	private const TOKEN_VARIABLE_FILTER_PARAM_DELIMITER = ',';
	private const TOKEN_SPACE = ' ';
	private const TOKEN_PARAM_STRING_DELIMITER = '"';

	private const SUPPORTED_VARIABLES = [
		'title',
		'feed',
	];
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

	private $rule = [];

	public function __construct(string $rule) {
		$this->parseRule($rule);
		$this->cleanRule();
	}

	private function parseRule(string $rule) {
		if ($rule === '') {
			return;
		}

		$isParsingVariable = false;
		$isParsingFilter = false;
		$isParsingString = true;
		$isParsingParameter = false;
		$isParsingParameterString = false;
		$currentSegment = '';
		$tokens = mb_str_split($rule);
		$length = count($tokens);
		$chunks = [];
		$variable = null;
		$filters = [];
		$filter = null;
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

		$this->rule = $chunks;
	}

	private function cleanRule() {
		$filterNames = array_column(self::SUPPORTED_FILTERS, 'name');
		$filterParams = array_reduce(self::SUPPORTED_FILTERS, static function ($carry, $item) {
			$carry[$item['name']] = $item['parameters'];
			return $carry;
		}, []);

		foreach ($this->rule as $chunkKey => $chunk) {
			if (is_string($chunk)) {
				continue;
			}
			if (!in_array($chunk['variable'], self::SUPPORTED_VARIABLES)) {
				unset($this->rule[$chunkKey]);
			}
			if (array_key_exists('filters', $chunk)) {
				$filters = [];
				foreach ($chunk['filters'] as $filterKey => $filter) {
					if (!in_array($filter['name'], $filterNames)) {
						continue;
					}
					if (!in_array(count($filter['parameters'] ?? []), $filterParams[$filter['name']])) {
						continue;
					}
					$filters[] = $filter;
				}
				if ($filters === []) {
					unset($this->rule[$chunkKey]['filters']);
				} else {
					$this->rule[$chunkKey]['filters'] = $filters;
				}
			}
		}
	}

	private function trim(string $variable, string $parameter = null) {
		if ($parameter === null) {
			return trim($variable);
		}
		return trim($variable, $parameter);
	}

	private function replace(string $variable, string $search, string $replace) {
		return str_replace($search, $replace, $variable);
	}

	private function ireplace(string $variable, string $search, string $replace) {
		return str_ireplace($search, $replace, $variable);
	}

	public function rewrite(string $title, string $feed) {
		$value = '';
		foreach ($this->rule as $rule) {
			if (is_string($rule)) {
				$value .= $rule;
				continue;
			}
			$variable = ${$rule['variable']};
			foreach ($rule['filters'] ?? [] as $filter) {
				$variable = call_user_func_array([$this, $filter['name']], array_merge([$variable], $filter['parameters'] ?? []));
			}
			$value .= $variable;
		}

		return $value;
	}
}
