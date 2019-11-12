<?php

namespace Freshrss\Models;

/**
 * Contains Boolean search from the search form.
 */
class BooleanSearch {

	private $raw_input = '';
	private $searches = array();

	public function __construct($input) {
		$input = trim($input);
		if ($input == '') {
			return;
		}
		$this->raw_input = $input;

		$input = preg_replace('/:&quot;(.*?)&quot;/', ':"\1"', $input);
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
						$this->searches[] = new Search($segment);
					}
					$segment = '';
				}
			}
		}
		$segment = trim($segment);
		if ($segment != '') {
			$this->searches[] = new Search($segment);
		}
	}

	public function searches() {
		return $this->searches;
	}

	public function add($search) {
		if ($search instanceof Search) {
			$this->searches[] = $search;
			return $search;
		}
		return null;
	}

	public function __toString() {
		return $this->getRawInput();
	}

	public function getRawInput() {
		return $this->raw_input;
	}
}
