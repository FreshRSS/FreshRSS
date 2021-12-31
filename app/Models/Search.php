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
	private $entry_ids;
	private $feed_ids;
	private $label_ids;
	private $label_names;
	private $intitle;
	private $min_date;
	private $max_date;
	private $min_pubdate;
	private $max_pubdate;
	private $inurl;
	private $author;
	private $tags;
	private $search;

	private $not_entry_ids;
	private $not_feed_ids;
	private $not_label_ids;
	private $not_label_names;
	private $not_intitle;
	private $not_min_date;
	private $not_max_date;
	private $not_min_pubdate;
	private $not_max_pubdate;
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

		$input = $this->parseNotEntryIds($input);
		$input = $this->parseNotFeedIds($input);
		$input = $this->parseNotLabelIds($input);
		$input = $this->parseNotLabelNames($input);

		$input = $this->parseNotPubdateSearch($input);
		$input = $this->parseNotDateSearch($input);

		$input = $this->parseNotIntitleSearch($input);
		$input = $this->parseNotAuthorSearch($input);
		$input = $this->parseNotInurlSearch($input);
		$input = $this->parseNotTagsSearch($input);

		$input = $this->parseEntryIds($input);
		$input = $this->parseFeedIds($input);
		$input = $this->parseLabelIds($input);
		$input = $this->parseLabelNames($input);

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

	public function getEntryIds() {
		return $this->entry_ids;
	}
	public function getNotEntryIds() {
		return $this->not_entry_ids;
	}

	public function getFeedIds() {
		return $this->feed_ids;
	}
	public function getNotFeedIds() {
		return $this->not_feed_ids;
	}

	public function getLabelIds() {
		return $this->label_ids;
	}
	public function getNotlabelIds() {
		return $this->not_label_ids;
	}
	public function getLabelNames() {
		return $this->label_names;
	}
	public function getNotlabelNames() {
		return $this->not_label_names;
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
	public function getNotMinDate() {
		return $this->not_min_date;
	}
	public function setMinDate($value) {
		return $this->min_date = $value;
	}

	public function getMaxDate() {
		return $this->max_date;
	}
	public function getNotMaxDate() {
		return $this->not_max_date;
	}
	public function setMaxDate($value) {
		return $this->max_date = $value;
	}

	public function getMinPubdate() {
		return $this->min_pubdate;
	}
	public function getNotMinPubdate() {
		return $this->not_min_pubdate;
	}

	public function getMaxPubdate() {
		return $this->max_pubdate;
	}
	public function getNotMaxPubdate() {
		return $this->not_max_pubdate;
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
	 * Parse the search string to find entry (article) IDs.
	 *
	 * @param string $input
	 * @return string
	 */
	private function parseEntryIds($input) {
		if (preg_match_all('/\be:(?P<search>[0-9,]*)/', $input, $matches)) {
			$input = str_replace($matches[0], '', $input);
			$ids_lists = $matches['search'];
			$this->entry_ids = [];
			foreach ($ids_lists as $ids_list) {
				$entry_ids = explode(',', $ids_list);
				$entry_ids = self::removeEmptyValues($entry_ids);
				if (!empty($entry_ids)) {
					$this->entry_ids[] = $entry_ids;
				}
			}
		}
		return $input;
	}

	private function parseNotEntryIds($input) {
		if (preg_match_all('/[!-]e:(?P<search>[0-9,]*)/', $input, $matches)) {
			$input = str_replace($matches[0], '', $input);
			$ids_lists = $matches['search'];
			$this->not_entry_ids = [];
			foreach ($ids_lists as $ids_list) {
				$entry_ids = explode(',', $ids_list);
				$entry_ids = self::removeEmptyValues($entry_ids);
				if (!empty($entry_ids)) {
					$this->not_entry_ids[] = $entry_ids;
				}
			}
		}
		return $input;
	}

	/**
	 * Parse the search string to find feed IDs.
	 *
	 * @param string $input
	 * @return string
	 */
	private function parseFeedIds($input) {
		if (preg_match_all('/\bf:(?P<search>[0-9,]*)/', $input, $matches)) {
			$input = str_replace($matches[0], '', $input);
			$ids_lists = $matches['search'];
			$this->feed_ids = [];
			foreach ($ids_lists as $ids_list) {
				$feed_ids = explode(',', $ids_list);
				$feed_ids = self::removeEmptyValues($feed_ids);
				if (!empty($feed_ids)) {
					$this->feed_ids[] = $feed_ids;
				}
			}
		}
		return $input;
	}

	private function parseNotFeedIds($input) {
		if (preg_match_all('/[!-]f:(?P<search>[0-9,]*)/', $input, $matches)) {
			$input = str_replace($matches[0], '', $input);
			$ids_lists = $matches['search'];
			$this->not_feed_ids = [];
			foreach ($ids_lists as $ids_list) {
				$feed_ids = explode(',', $ids_list);
				$feed_ids = self::removeEmptyValues($feed_ids);
				if (!empty($feed_ids)) {
					$this->not_feed_ids[] = $feed_ids;
				}
			}
		}
		return $input;
	}

	/**
	 * Parse the search string to find tags (labels) IDs.
	 *
	 * @param string $input
	 * @return string
	 */
	private function parseLabelIds($input) {
		if (preg_match_all('/\b[lL]:(?P<search>[0-9,]+|[*])/', $input, $matches)) {
			$input = str_replace($matches[0], '', $input);
			$ids_lists = $matches['search'];
			$this->label_ids = [];
			foreach ($ids_lists as $ids_list) {
				if ($ids_list === '*') {
					$this->label_ids[] = '*';
					break;
				}
				$label_ids = explode(',', $ids_list);
				$label_ids = self::removeEmptyValues($label_ids);
				if (!empty($label_ids)) {
					$this->label_ids[] = $label_ids;
				}
			}
		}
		return $input;
	}

	private function parseNotLabelIds($input) {
		if (preg_match_all('/[!-][lL]:(?P<search>[0-9,]+|[*])/', $input, $matches)) {
			$input = str_replace($matches[0], '', $input);
			$ids_lists = $matches['search'];
			$this->not_label_ids = [];
			foreach ($ids_lists as $ids_list) {
				if ($ids_list === '*') {
					$this->not_label_ids[] = '*';
					break;
				}
				$label_ids = explode(',', $ids_list);
				$label_ids = self::removeEmptyValues($label_ids);
				if (!empty($label_ids)) {
					$this->not_label_ids[] = $label_ids;
				}
			}
		}
		return $input;
	}

	/**
	 * Parse the search string to find tags (labels) names.
	 *
	 * @param string $input
	 * @return string
	 */
	private function parseLabelNames($input) {
		$names_lists = [];
		if (preg_match_all('/\blabels?:(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$names_lists = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/\blabels?:(?P<search>[^\s"]*)/', $input, $matches)) {
			$names_lists = array_merge($names_lists, $matches['search']);
			$input = str_replace($matches[0], '', $input);
		}
		if (!empty($names_lists)) {
			$this->label_names = [];
			foreach ($names_lists as $names_list) {
				$names_array = explode(',', $names_list);
				$names_array = self::removeEmptyValues($names_array);
				if (!empty($names_array)) {
					$this->label_names[] = $names_array;
				}
			}
		}
		return $input;
	}

	/**
	 * Parse the search string to find tags (labels) names to exclude.
	 *
	 * @param string $input
	 * @return string
	 */
	private function parseNotLabelNames($input) {
		$names_lists = [];
		if (preg_match_all('/[!-]labels?:(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$names_lists = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/[!-]labels?:(?P<search>[^\s"]*)/', $input, $matches)) {
			$names_lists = array_merge($names_lists, $matches['search']);
			$input = str_replace($matches[0], '', $input);
		}
		if (!empty($names_lists)) {
			$this->not_label_names = [];
			foreach ($names_lists as $names_list) {
				$names_array = explode(',', $names_list);
				$names_array = self::removeEmptyValues($names_array);
				if (!empty($names_array)) {
					$this->not_label_names[] = $names_array;
				}
			}
		}
		return $input;
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
		return $input;
	}

	private function parseNotInurlSearch($input) {
		if (preg_match_all('/[!-]inurl:(?P<search>[^\s]*)/', $input, $matches)) {
			$this->not_inurl = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		$this->not_inurl = self::removeEmptyValues($this->not_inurl);
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

	private function parseNotDateSearch($input) {
		if (preg_match_all('/[!-]date:(?P<search>[^\s]*)/', $input, $matches)) {
			$input = str_replace($matches[0], '', $input);
			$dates = self::removeEmptyValues($matches['search']);
			if (!empty($dates[0])) {
				list($this->not_min_date, $this->not_max_date) = parseDateInterval($dates[0]);
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

	private function parseNotPubdateSearch($input) {
		if (preg_match_all('/[!-]pubdate:(?P<search>[^\s]*)/', $input, $matches)) {
			$input = str_replace($matches[0], '', $input);
			$dates = self::removeEmptyValues($matches['search']);
			if (!empty($dates[0])) {
				list($this->not_min_pubdate, $this->not_max_pubdate) = parseDateInterval($dates[0]);
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
