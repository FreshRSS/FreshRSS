<?php

/**
 * Contains Boolean search from the search form.
 */
class FreshRSS_BooleanSearch {

	/** @var string */
	private $raw_input = '';
	private $searches = array();

	public function __construct($input) {
		$input = trim($input);
		if ($input == '') {
			return;
		}
		$this->raw_input = $input;

		$input = preg_replace('/:&quot;(.*?)&quot;/', ':"\1"', $input);
		$input = preg_replace('/(?<=[\s!-]|^)&quot;(.*?)&quot;/', '"\1"', $input);

		$input = $this->parseUserQueryNames($input);

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

			$froms = [];
			$tos = [];
			foreach ($all_matches as $matches) {
				for ($i = count($matches['search']) - 1; $i >= 0; $i--) {
					$name = $matches['search'][$i];
					$froms[] = $matches[0][$i];
					$tos[] = empty($queries[$name]) ? '' : $queries[$name]->getSearch();
				}
			}

			$input = str_replace($froms, $tos, $input);
		}
		return $input;
	}

	public function searches() {
		return $this->searches;
	}

	public function add($search) {
		if ($search instanceof FreshRSS_Search) {
			$this->searches[] = $search;
			return $search;
		}
		return null;
	}

	public function __toString(): string {
		return $this->getRawInput();
	}

	public function getRawInput(): string {
		return $this->raw_input;
	}
}
