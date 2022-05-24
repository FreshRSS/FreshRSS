<?php

/**
 * Contains Boolean search from the search form.
 */
class FreshRSS_BooleanSearch {

	/** @var string */
	private $raw_input = '';
	/** @var array<FreshRSS_BooleanSearch|FreshRSS_Search> */
	private $searches = array();

	public function __construct(string $input, int $level = 0) {
		$input = trim($input);
		if ($input == '') {
			return;
		}
		$this->raw_input = $input;

		if ($level === 0) {
			$input = preg_replace('/:&quot;(.*?)&quot;/', ':"\1"', $input);
			$input = preg_replace('/(?<=[\s!-]|^)&quot;(.*?)&quot;/', '"\1"', $input);

			$input = $this->parseUserQueryNames($input);
		}

		// Either parse everything as a series of BooleanSearch's combined by implicit AND
		// or parse everything as a series of Search's combined by explicit OR
		$this->parseParentheses($input, $level) || $this->parseOrSegments($input);
	}

	/**
	 * Parse the user queries and expand them in the input string.
	 */
	private function parseUserQueryNames(string $input): string {
		$all_matches = [];
		if (preg_match_all('/\bS:(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$all_matches[] = $matches;

		}
		if (preg_match_all('/\bS:(?P<search>[^\s"]*)/', $input, $matches)) {
			$all_matches[] = $matches;
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
				for ($i = count($matches['search']) - 1; $i >= 0; $i--) {
					$name = trim($matches['search'][$i]);
					$fromS[] = $matches[0][$i];
					$toS[] = empty($queries[$name]) ? '' : '(' . trim($queries[$name]->getSearch()) . ')';
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
		while ($i < $length) {
			$c = $input[$i];

			if ($c === '(') {
				$hasParenthesis = true;

				// The text prior to the opening parenthesis is a BooleanSearch
				$searchBefore = new FreshRSS_BooleanSearch($before, $level + 1);
				if (count($searchBefore->searches()) > 0) {
					$this->searches[] = $searchBefore;
				}
				$before = '';

				// Search the matching closing parenthesis
				$parentheses = 1;
				$sub = '';
				$i++;
				while ($i < $length) {
					$c = $input[$i];
					if ($c === '(') {
						// One nested level deeper
						$parentheses++;
						$sub .= $c;
					} elseif ($c === ')') {
						$parentheses--;
						if ($parentheses === 0) {
							// Found the matching closing parenthesis
							$searchSub = new FreshRSS_BooleanSearch($sub, $level + 1);
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
			// The remaining text after the last parenthesis is a BooleanSearch
			$searchBefore = new FreshRSS_BooleanSearch($before, $level + 1);
			if (count($searchBefore->searches()) > 0) {
				$this->searches[] = $searchBefore;
			}
			return true;
		}
		// There was no parenthesis logic to apply
		return false;
	}

	private function parseOrSegments(string $input) {
		$input = trim($input);
		if ($input == '') {
			return;
		}
		$splits = preg_split('/\b(OR)\b/i', $input, -1, PREG_SPLIT_DELIM_CAPTURE);

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
					if ($segment != '') {
						$this->searches[] = new FreshRSS_Search($segment);
					}
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
	public function searches() {
		return $this->searches;
	}

	/** @param FreshRSS_BooleanSearch|FreshRSS_Search $search */
	public function add($search) {
		$this->searches[] = $search;
	}

	public function __toString(): string {
		return $this->getRawInput();
	}

	public function getRawInput(): string {
		return $this->raw_input;
	}
}
