<?php

require_once(LIB_PATH . '/lib_date.php');

/**
 * Contains a search from the search form.
 *
 * It allows to extract meaningful bits of the search and store them in a
 * convenient object
 */
class FreshRSS_Search {

	// This contains the user input string
	private $raw_input = '';
	// The following properties are extracted from the raw input
	private $intitle;
	private $min_date;
	private $max_date;
	private $min_pubdate;
	private $max_pubdate;
	private $inurl;
	private $author;
	private $tags;
	private $search;

	public function __construct($input) {
		if (strcmp($input, '') == 0) {
			return;
		}
		$this->raw_input = $input;
		$input = $this->parseIntitleSearch($input);
		$input = $this->parseAuthorSearch($input);
		$input = $this->parseInurlSearch($input);
		$input = $this->parsePubdateSearch($input);
		$input = $this->parseDateSearch($input);
		$input = $this->parseTagsSeach($input);
		$this->parseSearch($input);
	}

	public function __toString() {
		return $this->getRawInput();
	}

	public function getRawInput() {
		return $this->raw_input;
	}

	public function getIntitle() {
		return $this->intitle;
	}

	public function getMinDate() {
		return $this->min_date;
	}

	public function getMaxDate() {
		return $this->max_date;
	}

	public function getMinPubdate() {
		return $this->min_pubdate;
	}

	public function getMaxPubdate() {
		return $this->max_pubdate;
	}

	public function getInurl() {
		return $this->inurl;
	}

	public function getAuthor() {
		return $this->author;
	}

	public function getTags() {
		return $this->tags;
	}

	public function getSearch() {
		return $this->search;
	}

	private static function removeEmptyValues($anArray) {
		return is_array($anArray) ? array_filter($anArray, function($value) { return $value !== ''; }) : array();
	}

	/**
	 * Parse the search string to find intitle keyword and the search related
	 * to it.
	 * The search is the first word following the keyword.
	 *
	 * @param string $input
	 * @return string
	 */
	private function parseIntitleSearch($input) {
		if (preg_match_all('/intitle:(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$this->intitle = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/intitle:(?P<search>\w*)/', $input, $matches)) {
			$this->intitle = array_merge($this->intitle ? $this->intitle : array(), $matches['search']);
			$input = str_replace($matches[0], '', $input);
		}
		$this->intitle = self::removeEmptyValues($this->intitle);
		return $input;
	}

	/**
	 * Parse the search string to find author keyword and the search related
	 * to it.
	 * The search is the first word following the keyword except when using
	 * a delimiter. Supported delimiters are single quote (') and double
	 * quotes (").
	 *
	 * @param string $input
	 * @return string
	 */
	private function parseAuthorSearch($input) {
		if (preg_match_all('/author:(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$this->author = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/author:(?P<search>\w*)/', $input, $matches)) {
			$this->author = array_merge($this->author ? $this->author : array(), $matches['search']);
			$input = str_replace($matches[0], '', $input);
		}
		$this->author = self::removeEmptyValues($this->author);
		return $input;
	}

	/**
	 * Parse the search string to find inurl keyword and the search related
	 * to it.
	 * The search is the first word following the keyword.
	 *
	 * @param string $input
	 * @return string
	 */
	private function parseInurlSearch($input) {
		if (preg_match_all('/inurl:(?P<search>[^\s]*)/', $input, $matches)) {
			$this->inurl = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		$this->inurl = self::removeEmptyValues($this->inurl);
		return $input;
	}

	/**
	 * Parse the search string to find date keyword and the search related
	 * to it.
	 * The search is the first word following the keyword.
	 *
	 * @param string $input
	 * @return string
	 */
	private function parseDateSearch($input) {
		if (preg_match_all('/date:(?P<search>[^\s]*)/', $input, $matches)) {
			$input = str_replace($matches[0], '', $input);
			$dates = self::removeEmptyValues($matches['search']);
			if (!empty($dates[0])) {
				list($this->min_date, $this->max_date) = parseDateInterval($dates[0]);
			}
		}
		return $input;
	}

	/**
	 * Parse the search string to find pubdate keyword and the search related
	 * to it.
	 * The search is the first word following the keyword.
	 *
	 * @param string $input
	 * @return string
	 */
	private function parsePubdateSearch($input) {
		if (preg_match_all('/pubdate:(?P<search>[^\s]*)/', $input, $matches)) {
			$input = str_replace($matches[0], '', $input);
			$dates = self::removeEmptyValues($matches['search']);
			if (!empty($dates[0])) {
				list($this->min_pubdate, $this->max_pubdate) = parseDateInterval($dates[0]);
			}
		}
		return $input;
	}

	/**
	 * Parse the search string to find tags keyword (# followed by a word)
	 * and the search related to it.
	 * The search is the first word following the #.
	 *
	 * @param string $input
	 * @return string
	 */
	private function parseTagsSeach($input) {
		if (preg_match_all('/#(?P<search>[^\s]+)/', $input, $matches)) {
			$this->tags = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		$this->tags = self::removeEmptyValues($this->tags);
		return $input;
	}

	/**
	 * Parse the search string to find search values.
	 * Every word is a distinct search value, except when using a delimiter.
	 * Supported delimiters are single quote (') and double quotes (").
	 *
	 * @param string $input
	 * @return string
	 */
	private function parseSearch($input) {
		$input = self::cleanSearch($input);
		if (strcmp($input, '') == 0) {
			return;
		}
		if (preg_match_all('/(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$this->search = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		$input = self::cleanSearch($input);
		if (strcmp($input, '') == 0) {
			return;
		}
		if (is_array($this->search)) {
			$this->search = array_merge($this->search, explode(' ', $input));
		} else {
			$this->search = explode(' ', $input);
		}
	}

	/**
	 * Remove all unnecessary spaces in the search
	 *
	 * @param string $input
	 * @return string
	 */
	private static function cleanSearch($input) {
		$input = preg_replace('/\s+/', ' ', $input);
		return trim($input);
	}

}
