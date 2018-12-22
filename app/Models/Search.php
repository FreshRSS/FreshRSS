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

	private $not_intitle;
	private $not_inurl;
	private $not_author;
	private $not_tags;
	private $not_search;

	public function __construct($input) {
		if ($input == '') {
			return;
		}
		$this->raw_input = $input;

		$input = preg_replace('/:&quot;(.*?)&quot;/', ':"\1"', $input);

		$input = $this->parseNotIntitleSearch($input);
		$input = $this->parseNotAuthorSearch($input);
		$input = $this->parseNotInurlSearch($input);
		$input = $this->parseNotTagsSearch($input);

		$input = $this->parsePubdateSearch($input);
		$input = $this->parseDateSearch($input);

		$input = $this->parseIntitleSearch($input);
		$input = $this->parseAuthorSearch($input);
		$input = $this->parseInurlSearch($input);
		$input = $this->parseTagsSearch($input);

		$input = $this->parseNotSearch($input);
		$input = $this->parseSearch($input);
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
	public function getNotIntitle() {
		return $this->not_intitle;
	}

	public function getMinDate() {
		return $this->min_date;
	}

	public function setMinDate($value) {
		return $this->min_date = $value;
	}

	public function getMaxDate() {
		return $this->max_date;
	}

	public function setMaxDate($value) {
		return $this->max_date = $value;
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
	public function getNotInurl() {
		return $this->not_inurl;
	}

	public function getAuthor() {
		return $this->author;
	}
	public function getNotAuthor() {
		return $this->not_author;
	}

	public function getTags() {
		return $this->tags;
	}
	public function getNotTags() {
		return $this->not_tags;
	}

	public function getSearch() {
		return $this->search;
	}
	public function getNotSearch() {
		return $this->not_search;
	}

	private static function removeEmptyValues($anArray) {
		return is_array($anArray) ? array_filter($anArray, function($value) { return $value !== ''; }) : array();
	}

	private static function decodeSpaces($value) {
		if (is_array($value)) {
			for ($i = count($value) - 1; $i >= 0; $i--) {
				$value[$i] = self::decodeSpaces($value[$i]);
			}
		} else {
			$value = trim(str_replace('+', ' ', $value));
		}
		return $value;
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
		if (preg_match_all('/\bintitle:(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$this->intitle = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/\bintitle:(?P<search>[^\s"]*)/', $input, $matches)) {
			$this->intitle = array_merge($this->intitle ? $this->intitle : array(), $matches['search']);
			$input = str_replace($matches[0], '', $input);
		}
		$this->intitle = self::removeEmptyValues($this->intitle);
		$this->intitle = self::decodeSpaces($this->intitle);
		return $input;
	}

	private function parseNotIntitleSearch($input) {
		if (preg_match_all('/[!-]intitle:(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$this->not_intitle = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/[!-]intitle:(?P<search>[^\s"]*)/', $input, $matches)) {
			$this->not_intitle = array_merge($this->not_intitle ? $this->not_intitle : array(), $matches['search']);
			$input = str_replace($matches[0], '', $input);
		}
		$this->not_intitle = self::removeEmptyValues($this->not_intitle);
		$this->not_intitle = self::decodeSpaces($this->not_intitle);
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
		if (preg_match_all('/\bauthor:(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$this->author = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/\bauthor:(?P<search>[^\s"]*)/', $input, $matches)) {
			$this->author = array_merge($this->author ? $this->author : array(), $matches['search']);
			$input = str_replace($matches[0], '', $input);
		}
		$this->author = self::removeEmptyValues($this->author);
		$this->author = self::decodeSpaces($this->author);
		return $input;
	}

	private function parseNotAuthorSearch($input) {
		if (preg_match_all('/[!-]author:(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$this->not_author = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/[!-]author:(?P<search>[^\s"]*)/', $input, $matches)) {
			$this->not_author = array_merge($this->not_author ? $this->not_author : array(), $matches['search']);
			$input = str_replace($matches[0], '', $input);
		}
		$this->not_author = self::removeEmptyValues($this->not_author);
		$this->not_author = self::decodeSpaces($this->not_author);
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
		if (preg_match_all('/\binurl:(?P<search>[^\s]*)/', $input, $matches)) {
			$this->inurl = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		$this->inurl = self::removeEmptyValues($this->inurl);
		$this->inurl = self::decodeSpaces($this->inurl);
		return $input;
	}

	private function parseNotInurlSearch($input) {
		if (preg_match_all('/[!-]inurl:(?P<search>[^\s]*)/', $input, $matches)) {
			$this->not_inurl = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		$this->not_inurl = self::removeEmptyValues($this->not_inurl);
		$this->not_inurl = self::decodeSpaces($this->not_inurl);
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
		if (preg_match_all('/\bdate:(?P<search>[^\s]*)/', $input, $matches)) {
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
		if (preg_match_all('/\bpubdate:(?P<search>[^\s]*)/', $input, $matches)) {
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
	private function parseTagsSearch($input) {
		if (preg_match_all('/#(?P<search>[^\s]+)/', $input, $matches)) {
			$this->tags = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		$this->tags = self::removeEmptyValues($this->tags);
		$this->tags = self::decodeSpaces($this->tags);
		return $input;
	}

	private function parseNotTagsSearch($input) {
		if (preg_match_all('/[!-]#(?P<search>[^\s]+)/', $input, $matches)) {
			$this->not_tags = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		$this->not_tags = self::removeEmptyValues($this->not_tags);
		$this->not_tags = self::decodeSpaces($this->not_tags);
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
		if ($input == '') {
			return;
		}
		if (preg_match_all('/(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$this->search = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		$input = self::cleanSearch($input);
		if ($input == '') {
			return;
		}
		if (is_array($this->search)) {
			$this->search = array_merge($this->search, explode(' ', $input));
		} else {
			$this->search = explode(' ', $input);
		}
		$this->search = self::decodeSpaces($this->search);
	}

	private function parseNotSearch($input) {
		$input = self::cleanSearch($input);
		if ($input == '') {
			return;
		}
		if (preg_match_all('/[!-](?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$this->not_search = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if ($input == '') {
			return;
		}
		if (preg_match_all('/[!-](?P<search>[^\s]+)/', $input, $matches)) {
			$this->not_search = array_merge(is_array($this->not_search) ? $this->not_search : array(), $matches['search']);
			$input = str_replace($matches[0], '', $input);
		}
		$this->not_search = self::removeEmptyValues($this->not_search);
		$this->not_search = self::decodeSpaces($this->not_search);
		return $input;
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
