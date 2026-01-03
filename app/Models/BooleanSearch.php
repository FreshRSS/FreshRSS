<?php
declare(strict_types=1);

/**
 * Contains Boolean search from the search form.
 */
class FreshRSS_BooleanSearch implements \Stringable {

	private string $raw_input = '';
	/** @var list<FreshRSS_BooleanSearch|FreshRSS_Search> */
	private array $searches = [];

	/**
	 * @param string $input
	 * @param int $level
	 * @param 'AND'|'OR'|'AND NOT'|'OR NOT' $operator
	 * @param bool $allowUserQueries
	 */
	public function __construct(
		string $input,
		int $level = 0,
		private readonly string $operator = 'AND',
		bool $allowUserQueries = true,
		bool $expandUserQueries = true
	) {
		$input = trim($input);
		if ($input === '') {
			return;
		}
		$this->raw_input = $input;

		if ($level === 0) {
			$input = self::escapeLiterals($input);
			if ($expandUserQueries || !$allowUserQueries) {
				$input = $this->parseUserQueryNames($input, $allowUserQueries);
				$input = $this->parseUserQueryIds($input, $allowUserQueries);
			}
			$input = trim($input);
		}

		$input = self::consistentOrParentheses($input);

		// Either parse everything as a series of BooleanSearch’s combined by implicit AND
		// or parse everything as a series of Search’s combined by explicit OR
		$this->parseParentheses($input, $level) || $this->parseOrSegments($input);
	}

	public function __clone() {
		foreach ($this->searches as $key => $search) {
			$this->searches[$key] = clone $search;
		}
		$this->expanded = null;
		$this->notExpanded = null;
	}

	/**
	 * Parse the user queries (saved searches) by name and expand them in the input string.
	 */
	private function parseUserQueryNames(string $input, bool $allowUserQueries = true): string {
		$all_matches = [];
		if (preg_match_all('/\bsearch:(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matchesFound)) {
			$all_matches[] = $matchesFound;
		}
		if (preg_match_all('/\bsearch:(?P<search>[^\s"]*)/', $input, $matchesFound)) {
			$all_matches[] = $matchesFound;
		}

		if (!empty($all_matches)) {
			$queries = [];
			foreach (FreshRSS_Context::userConf()->queries as $raw_query) {
				if (($raw_query['name'] ?? '') !== '' && ($raw_query['search'] ?? '') !== '') {
					$queries[$raw_query['name']] = trim($raw_query['search']);
				}
			}

			$fromS = [];
			$toS = [];
			foreach ($all_matches as $matches) {
				if (empty($matches['search'])) {
					continue;
				}
				for ($i = count($matches['search']) - 1; $i >= 0; $i--) {
					$name = trim($matches['search'][$i]);
					$fromS[] = $matches[0][$i];
					if ($allowUserQueries && !empty($queries[$name])) {
						$toS[] = '(' . self::escapeLiterals($queries[$name]) . ')';
					} else {
						$toS[] = '';
					}
				}
			}

			$input = str_replace($fromS, $toS, $input);
		}
		return $input;
	}

	/**
	 * Parse the user queries (saved searches) by ID and expand them in the input string.
	 */
	private function parseUserQueryIds(string $input, bool $allowUserQueries = true): string {
		$all_matches = [];

		if (preg_match_all('/\bS:(?P<search>[0-9,]+)/', $input, $matchesFound)) {
			$all_matches[] = $matchesFound;
		}

		if (!empty($all_matches)) {
			$queries = [];
			foreach (FreshRSS_Context::userConf()->queries as $raw_query) {
				$queries[] = trim($raw_query['search'] ?? '');
			}

			$fromS = [];
			$toS = [];
			foreach ($all_matches as $matches) {
				if (empty($matches['search'])) {
					continue;
				}
				for ($i = count($matches['search']) - 1; $i >= 0; $i--) {
					$ids = explode(',', $matches['search'][$i]);
					$ids = array_map('intval', $ids);

					$matchedQueries = [];
					foreach ($ids as $id) {
						if (!empty($queries[$id])) {
							$matchedQueries[] = $queries[$id];
						}
					}

					$fromS[] = $matches[0][$i];
					if ($allowUserQueries && !empty($matchedQueries)) {
						$escapedQueries = array_map(fn(string $query): string => self::escapeLiterals($query), $matchedQueries);
						$toS[] = '(' . implode(') OR (', $escapedQueries) . ')';
					} else {
						$toS[] = '';
					}
				}
			}

			$input = str_replace($fromS, $toS, $input);
		}
		return $input;
	}

	/**
	 * Temporarily escape parentheses and 'OR' used in regex expressions or inside "quoted strings".
	 */
	public static function escapeLiterals(string $input): string {
		return preg_replace_callback('%(?<=[\\s(:#!-]|^)(?<![\\\\])(?P<delim>[\'"/]).+?(?<!\\\\)(?P=delim)[im]*%',
			function (array $matches): string {
				$match = $matches[0];
				$match = str_replace(['(', ')'], ['\\u0028', '\\u0029'], $match);
				$match = preg_replace_callback('/\bOR\b/i', fn(array $ms): string =>
					str_replace(['O', 'o', 'R', 'r'], ['\\u004f', '\\u006f', '\\u0052', '\\u0072'], $ms[0]),
					$match
				) ?? '';
				return $match;
			},
			$input
		) ?? '';
	}

	public static function unescapeLiterals(string $input): string {
		return str_replace(
			['\\u0028', '\\u0029', '\\u004f', '\\u006f', '\\u0052', '\\u0072'],
			['(', ')', 'O', 'o', 'R', 'r'],
			$input
		);
	}

	/**
	 * Example: 'ab cd OR ef OR "gh ij"' becomes '(ab cd) OR (ef) OR ("gh ij")'
	 */
	public static function addOrParentheses(string $input): string {
		$input = trim($input);
		if ($input === '') {
			return '';
		}
		$splits = preg_split('/\b(OR)\b/i', $input, -1, PREG_SPLIT_DELIM_CAPTURE) ?: [];
		$ns = count($splits);
		if ($ns <= 1) {
			return $input;
		}
		$result = '';
		$segment = '';
		for ($i = 0; $i < $ns; $i++) {
			$segment .= $splits[$i];
			if (trim($segment) === '') {
				$segment = '';
			} elseif (strcasecmp($segment, 'OR') === 0) {
				$result .= $segment . ' ';
				$segment = '';
			} else {
				$quotes = substr_count($segment, '"') + substr_count($segment, '&quot;');
				if ($quotes % 2 === 0) {
					$segment = trim($segment);
					if (in_array($segment, ['!', '-'], true)) {
						$result .= $segment;
					} else {
						$result .= '(' . $segment . ') ';
					}
					$segment = '';
				}
			}
		}
		$segment = trim($segment);
		if (in_array($segment, ['!', '-'], true)) {
			$result .= $segment;
		} elseif ($segment !== '') {
			$result .= '(' . $segment . ')';
		}
		return trim($result);
	}

	/**
	 * If the query contains a mix of `OR` expressions with and without parentheses,
	 * then add parentheses to make the query consistent.
	 * Example: '(ab (cd OR ef)) OR gh OR ij OR (kl)' becomes '(ab ((cd) OR (ef))) OR (gh) OR (ij) OR (kl)'
	 */
	public static function consistentOrParentheses(string $input): string {
		if (!preg_match('/(?<!\\\\)\\(/', $input)) {
			// No unescaped parentheses in the input
			return trim($input);
		}
		$parenthesesCount = 0;
		$result = '';
		$segment = '';
		$length = strlen($input);

		for ($i = 0; $i < $length; $i++) {
			$c = $input[$i];
			$backslashed = $i >= 1 ? $input[$i - 1] === '\\' : false;
			if (!$backslashed) {
				if ($c === '(') {
					if ($parenthesesCount === 0) {
						if ($segment !== '') {
							$result = rtrim($result) . ' ' . self::addOrParentheses($segment);
							$negation = preg_match('/[!-]$/', $result);
							if (!$negation) {
								$result .= ' ';
							}
							$segment = '';
						}
						$c = '';
					}
					$parenthesesCount++;
				} elseif ($c === ')') {
					$parenthesesCount--;
					if ($parenthesesCount === 0) {
						$segment = self::consistentOrParentheses($segment);
						if ($segment !== '') {
							$result .= '(' . $segment . ')';
							$segment = '';
						}
						$c = '';
					}
				}
			}
			$segment .= $c;
		}
		if (trim($segment) !== '') {
			$result = rtrim($result);
			$negation = preg_match('/[!-]$/', $segment);
			if (!$negation) {
				$result .= ' ';
			}
			$result .= self::addOrParentheses($segment);
		}
		return trim($result);
	}

	/** @return bool True if some parenthesis logic took over, false otherwise */
	private function parseParentheses(string $input, int $level): bool {
		$input = trim($input);
		$length = strlen($input);
		$i = 0;
		$before = '';
		$hasParenthesis = false;
		$nextOperator = 'AND';
		while ($i < $length) {
			$c = $input[$i];
			$backslashed = $i >= 1 ? $input[$i - 1] === '\\' : false;

			if ($c === '(' && !$backslashed) {
				$hasParenthesis = true;

				$before = trim($before);
				if (preg_match('/[!-]$/', $before)) {
					// Trim trailing negation
					$before = rtrim($before, ' !-');
					$isOr = preg_match('/\bOR$/i', $before);
					if ($isOr) {
						// Trim trailing OR
						$before = substr($before, 0, -2);
					}

					// The text prior to the negation is a BooleanSearch
					$searchBefore = new FreshRSS_BooleanSearch($before, $level + 1, $nextOperator);
					if (count($searchBefore->searches()) > 0) {
						$this->searches[] = $searchBefore;
					}
					$before = '';

					// The next BooleanSearch will have to be combined with AND NOT or OR NOT instead of default AND
					$nextOperator = $isOr ? 'OR NOT' : 'AND NOT';
				} elseif (preg_match('/\bOR$/i', $before)) {
					// Trim trailing OR
					$before = substr($before, 0, -2);

					// The text prior to the OR is a BooleanSearch
					$searchBefore = new FreshRSS_BooleanSearch($before, $level + 1, $nextOperator);
					if (count($searchBefore->searches()) > 0) {
						$this->searches[] = $searchBefore;
					}
					$before = '';

					// The next BooleanSearch will have to be combined with OR instead of default AND
					$nextOperator = 'OR';
				} elseif ($before !== '') {
					// The text prior to the opening parenthesis is a BooleanSearch
					$searchBefore = new FreshRSS_BooleanSearch($before, $level + 1, $nextOperator);
					if (count($searchBefore->searches()) > 0) {
						$this->searches[] = $searchBefore;
					}
					$before = '';
				}

				// Search the matching closing parenthesis
				$parentheses = 1;
				$sub = '';
				$i++;
				while ($i < $length) {
					$c = $input[$i];
					$backslashed = $input[$i - 1] === '\\';
					if ($c === '(' && !$backslashed) {
						// One nested level deeper
						$parentheses++;
						$sub .= $c;
					} elseif ($c === ')' && !$backslashed) {
						$parentheses--;
						if ($parentheses === 0) {
							// Found the matching closing parenthesis
							$searchSub = new FreshRSS_BooleanSearch($sub, $level + 1, $nextOperator);
							$nextOperator = 'AND';
							if (count($searchSub->searches()) > 0) {
								$this->searches[] = $searchSub;
							}
							$sub = '';
							break;
						} else {
							$sub .= $c;
						}
					} else {
						$sub .= $c;
					}
					$i++;
				}
				// $sub = trim($sub);
				// if ($sub !== '') {
				// 	// TODO: Consider throwing an error or warning in case of non-matching parenthesis
				// }
			// } elseif ($c === ')') {
			// 	// TODO: Consider throwing an error or warning in case of non-matching parenthesis
			} else {
				$before .= $c;
			}
			$i++;
		}
		if ($hasParenthesis) {
			$before = trim($before);
			if (preg_match('/^OR\b/i', $before)) {
				// The next BooleanSearch will have to be combined with OR instead of default AND
				$nextOperator = 'OR';
				// Trim leading OR
				$before = substr($before, 2);
			}

			// The remaining text after the last parenthesis is a BooleanSearch
			$searchBefore = new FreshRSS_BooleanSearch($before, $level + 1, $nextOperator);
			$nextOperator = 'AND';
			if (count($searchBefore->searches()) > 0) {
				$this->searches[] = $searchBefore;
			}
			return true;
		}
		// There was no parenthesis logic to apply
		return false;
	}

	private function parseOrSegments(string $input): void {
		$input = trim($input);
		if ($input === '') {
			return;
		}
		$splits = preg_split('/\b(OR)\b/i', $input, -1, PREG_SPLIT_DELIM_CAPTURE) ?: [];
		$segment = '';
		$ns = count($splits);
		for ($i = 0; $i < $ns; $i++) {
			$segment = $segment . $splits[$i];
			if (trim($segment) === '' || strcasecmp($segment, 'OR') === 0) {
				$segment = '';
			} else {
				$quotes = substr_count($segment, '"') + substr_count($segment, '&quot;');
				if ($quotes % 2 === 0) {
					$segment = trim($segment);
					$this->searches[] = new FreshRSS_Search($segment);
					$segment = '';
				}
			}
		}
		$segment = trim($segment);
		if ($segment !== '') {
			$this->searches[] = new FreshRSS_Search($segment);
		}
	}

	/**
	 * Either a list of FreshRSS_BooleanSearch combined by implicit AND
	 * or a series of FreshRSS_Search combined by explicit OR
	 * @return list<FreshRSS_BooleanSearch|FreshRSS_Search>
	 */
	public function searches(): array {
		return $this->searches;
	}

	/** @return 'AND'|'OR'|'AND NOT'|'OR NOT' depending on how this BooleanSearch should be combined */
	public function operator(): string {
		return $this->operator;
	}

	/** @param FreshRSS_BooleanSearch|FreshRSS_Search $search */
	public function prepend(FreshRSS_BooleanSearch|FreshRSS_Search $search): void {
		array_unshift($this->searches, $search);
	}

	/** @param FreshRSS_BooleanSearch|FreshRSS_Search $search */
	public function add(FreshRSS_BooleanSearch|FreshRSS_Search $search): void {
		$this->searches[] = $search;
	}

	/**
	 * Modify the first compatible search of the Boolean expression, or add it at the beginning.
	 * Useful to modify some search parameters.
	 * @return FreshRSS_BooleanSearch a new instance, modified.
	 */
	public function enforce(FreshRSS_Search $search): self {
		$result = clone $this;
		$result->raw_input = '';
		$result->expanded = null;
		$result->notExpanded = null;

		if (count($result->searches) === 1 && $result->searches[0] instanceof FreshRSS_Search) {
			$result->searches[0] = $result->searches[0]->enforce($search);
			return $result;
		}
		if (count($result->searches) === 2) {
			foreach ($result->searches as $booleanSearch) {
				if (!($booleanSearch instanceof FreshRSS_BooleanSearch)) {
					break;
				}
				if ($booleanSearch->operator() === 'AND') {
					if (count($booleanSearch->searches) === 1 && $booleanSearch->searches[0] instanceof FreshRSS_Search &&
						$booleanSearch->searches[0]->hasSameOperators($search)) {
						$booleanSearch->searches[0] = $search;
						return $result;
					}
				}
			}
		}

		if (count($result->searches) > 1 || (count($result->searches) > 0 && $result->searches[0] instanceof FreshRSS_Search)) {
			// Wrap the existing searches in a new BooleanSearch if needed
			$wrap = new FreshRSS_BooleanSearch('');
			foreach ($result->searches as $existingSearch) {
				$wrap->add($existingSearch);
			}
			if (count($wrap->searches) > 0) {
				$result->searches = [$wrap];
			}
		}
		array_unshift($result->searches, $search);
		return $result;
	}

	/**
	 * Remove the first compatible search of the Boolean expression, if any.
	 * Useful to modify some search parameters.
	 * @return FreshRSS_BooleanSearch a new instance, modified.
	 */
	public function remove(FreshRSS_Search $search): self {
		$result = clone $this;
		$result->raw_input = '';
		$result->expanded = null;
		$result->notExpanded = null;

		if (count($result->searches) === 1 && $result->searches[0] instanceof FreshRSS_Search) {
			$result->searches[0] = $result->searches[0]->remove($search);
			return $result;
		}
		if (count($result->searches) === 2) {
			foreach ($result->searches as $booleanSearch) {
				if (!($booleanSearch instanceof FreshRSS_BooleanSearch)) {
					break;
				}
				if ($booleanSearch->operator() === 'AND') {
					if (count($booleanSearch->searches) === 1 && $booleanSearch->searches[0] instanceof FreshRSS_Search &&
						$booleanSearch->searches[0]->hasSameOperators($search)) {
						array_shift($booleanSearch->searches);
						return $result;
					}
				}
			}
		}
		return $result;
	}

	private ?string $expanded = null;

	#[\Override]
	public function __toString(): string {
		if ($this->expanded === null) {
			$result = '';
			foreach ($this->searches as $search) {
				$part = $search->__toString();
				if ($part === '') {
					continue;
				}
				$operator = $search instanceof FreshRSS_BooleanSearch ? $search->operator : 'OR';

				if ((str_contains($part, ' ') || str_starts_with($part, '-')) && (count($this->searches) > 1 || in_array($operator, ['OR NOT', 'AND NOT'], true))) {
					$part = '(' . $part . ')';
				}

				$result .= match ($operator) {
					'OR' => $result === '' ? '' : ' OR ',
					'OR NOT' => $result === '' ? '-' : ' OR -',
					'AND NOT' => $result === '' ? '-' : ' -',
					'AND' => $result === '' ? '' : ' ',
					default => throw new InvalidArgumentException('Invalid operator: ' . $operator),
				} . $part;
			}
			$this->expanded = trim($result);
		}
		return $this->expanded;
	}

	private ?string $notExpanded = null;

	/**
	 * @param bool $expandUserQueries Whether to expand user queries (saved searches) or not
	 */
	public function toString(bool $expandUserQueries = true): string {
		if ($expandUserQueries) {
			return $this->__toString();
		}
		if ($this->notExpanded === null) {
			$this->notExpanded = (new FreshRSS_BooleanSearch($this->raw_input, expandUserQueries: false))->__toString();
		}
		return $this->notExpanded;
	}

	/** @return string Plain text search query. Must be XML-encoded or URL-encoded depending on the situation */
	#[Deprecated('Use __toString(expanded: false) instead')]
	public function getRawInput(): string {
		return $this->raw_input;
	}
}
