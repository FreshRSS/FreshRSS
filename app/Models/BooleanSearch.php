<?php

/**
 * Contains Boolean search from the search form.
 */
class FreshRSS_BooleanSearch {

	private string $raw_input = '';
	/** @var array<FreshRSS_BooleanSearch|FreshRSS_Search> */
	private array $searches = [];

	/**
	 * @phpstan-var 'AND'|'OR'|'AND NOT'
	 */
	private string $operator;

	/** @param 'AND'|'OR'|'AND NOT' $operator */
	public function __construct(string $input, int $level = 0, string $operator = 'AND') {
		$this->operator = $operator;
		$input = trim($input);
		if ($input == '') {
			return;
		}
		$this->raw_input = $input;

		if ($level === 0) {
			$input = preg_replace('/:&quot;(.*?)&quot;/', ':"\1"', $input);
			$input = preg_replace('/(?<=[\s!-]|^)&quot;(.*?)&quot;/', '"\1"', $input);

			$input = $this->parseUserQueryNames($input);
			$input = $this->parseUserQueryIds($input);
		}

		// Either parse everything as a series of BooleanSearch’s combined by implicit AND
		// or parse everything as a series of Search’s combined by explicit OR
		$this->parseParentheses($input, $level) || $this->parseOrSegments($input);
	}

	/**
	 * Parse the user queries (saved searches) by name and expand them in the input string.
	 */
	private function parseUserQueryNames(string $input): string {
		$all_matches = [];
		if (preg_match_all('/\bsearch:(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matchesFound)) {
			$all_matches[] = $matchesFound;

		}
		if (preg_match_all('/\bsearch:(?P<search>[^\s"]*)/', $input, $matchesFound)) {
			$all_matches[] = $matchesFound;
		}

		if (!empty($all_matches)) {
			/** @var array<string,FreshRSS_UserQuery> */
			$queries = [];
			foreach (FreshRSS_Context::$user_conf->queries as $raw_query) {
				$query = new FreshRSS_UserQuery($raw_query);
				$queries[$query->getName()] = $query;
			}

			$fromS = [];
			$toS = [];
			foreach ($all_matches as $matches) {
				if (empty($matches['search'])) {
					continue;
				}
				for ($i = count($matches['search']) - 1; $i >= 0; $i--) {
					$name = trim($matches['search'][$i]);
					if (!empty($queries[$name])) {
						$fromS[] = $matches[0][$i];
						$toS[] = '(' . trim($queries[$name]->getSearch()) . ')';
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
	private function parseUserQueryIds(string $input): string {
		$all_matches = [];

		if (preg_match_all('/\bS:(?P<search>\d+)/', $input, $matchesFound)) {
			$all_matches[] = $matchesFound;
		}

		if (!empty($all_matches)) {
			$category_dao = FreshRSS_Factory::createCategoryDao();
			$feed_dao = FreshRSS_Factory::createFeedDao();
			$tag_dao = FreshRSS_Factory::createTagDao();

			/** @var array<string,FreshRSS_UserQuery> */
			$queries = [];
			foreach (FreshRSS_Context::$user_conf->queries as $raw_query) {
				$query = new FreshRSS_UserQuery($raw_query, $feed_dao, $category_dao, $tag_dao);
				$queries[] = $query;
			}

			$fromS = [];
			$toS = [];
			foreach ($all_matches as $matches) {
				if (empty($matches['search'])) {
					continue;
				}
				for ($i = count($matches['search']) - 1; $i >= 0; $i--) {
					// Index starting from 1
					$id = (int)(trim($matches['search'][$i])) - 1;
					if (!empty($queries[$id])) {
						$fromS[] = $matches[0][$i];
						$toS[] = '(' . trim($queries[$id]->getSearch()) . ')';
					}
				}
			}

			$input = str_replace($fromS, $toS, $input);
		}
		return $input;
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
				if (preg_match('/[!-]$/i', $before)) {
					// Trim trailing negation
					$before = substr($before, 0, -1);

					// The text prior to the negation is a BooleanSearch
					$searchBefore = new FreshRSS_BooleanSearch($before, $level + 1, $nextOperator);
					if (count($searchBefore->searches()) > 0) {
						$this->searches[] = $searchBefore;
					}
					$before = '';

					// The next BooleanSearch will have to be combined with AND NOT instead of default AND
					$nextOperator = 'AND NOT';
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
				// if ($sub != '') {
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
			if (trim($segment) == '' || strcasecmp($segment, 'OR') === 0) {
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
		if ($segment != '') {
			$this->searches[] = new FreshRSS_Search($segment);
		}
	}

	/**
	 * Either a list of FreshRSS_BooleanSearch combined by implicit AND
	 * or a series of FreshRSS_Search combined by explicit OR
	 * @return array<FreshRSS_BooleanSearch|FreshRSS_Search>
	 */
	public function searches(): array {
		return $this->searches;
	}

	/** @return 'AND'|'OR'|'AND NOT' depending on how this BooleanSearch should be combined */
	public function operator(): string {
		return $this->operator;
	}

	/** @param FreshRSS_BooleanSearch|FreshRSS_Search $search */
	public function add($search): void {
		$this->searches[] = $search;
	}

	public function __toString(): string {
		return $this->getRawInput();
	}

	public function getRawInput(): string {
		return $this->raw_input;
	}
}
