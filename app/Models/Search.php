<?php
declare(strict_types=1);

require_once LIB_PATH . '/lib_date.php';

/**
 * Contains a search from the search form.
 *
 * It allows to extract meaningful bits of the search and store them in a
 * convenient object
 */
class FreshRSS_Search implements \Stringable {

	/**
	 * This contains the user input string
	 */
	private string $raw_input = '';

	// The following properties are extracted from the raw input
	/** @var list<string>|null */
	private ?array $entry_ids = null;
	/** @var list<int>|null */
	private ?array $feed_ids = null;
	/** @var list<int>|null */
	private ?array $category_ids = null;
	/** @var list<list<int>|'*'>|null */
	private $label_ids = null;
	/** @var list<list<string>>|null */
	private ?array $label_names = null;
	/** @var list<string>|null */
	private ?array $intitle = null;
	/** @var list<string>|null */
	private ?array $intitle_regex = null;
	/** @var list<string>|null */
	private ?array $intext = null;
	/** @var list<string>|null */
	private ?array $intext_regex = null;
	private ?string $input_date = null;
	private int|false|null $min_date = null;
	private int|false|null $max_date = null;
	private ?string $input_pubdate = null;
	private int|false|null $min_pubdate = null;
	private int|false|null $max_pubdate = null;
	private ?string $input_userdate = null;
	private int|false|null $min_userdate = null;
	private int|false|null $max_userdate = null;
	/** @var list<string>|null */
	private ?array $inurl = null;
	/** @var list<string>|null */
	private ?array $inurl_regex = null;
	/** @var list<string>|null */
	private ?array $author = null;
	/** @var list<string>|null */
	private ?array $author_regex = null;
	/** @var list<string>|null */
	private ?array $tags = null;
	/** @var list<string>|null */
	private ?array $tags_regex = null;
	/** @var list<string>|null */
	private ?array $search = null;
	/** @var list<string>|null */
	private ?array $search_regex = null;

	/** @var list<string>|null */
	private ?array $not_entry_ids = null;
	/** @var list<int>|null */
	private ?array $not_feed_ids = null;
	/** @var list<int>|null */
	private ?array $not_category_ids = null;
	/** @var list<list<int>|'*'>|null */
	private $not_label_ids = null;
	/** @var list<list<string>>|null */
	private ?array $not_label_names = null;
	/** @var list<string>|null */
	private ?array $not_intitle = null;
	/** @var list<string>|null */
	private ?array $not_intitle_regex = null;
	/** @var list<string>|null */
	private ?array $not_intext = null;
	/** @var list<string>|null */
	private ?array $not_intext_regex = null;
	private ?string $input_not_date = null;
	private int|false|null $not_min_date = null;
	private int|false|null $not_max_date = null;
	private ?string $input_not_pubdate = null;
	private int|false|null $not_min_pubdate = null;
	private int|false|null $not_max_pubdate = null;
	private ?string $input_not_userdate = null;
	private int|false|null $not_min_userdate = null;
	private int|false|null $not_max_userdate = null;
	/** @var list<string>|null */
	private ?array $not_inurl = null;
	/** @var list<string>|null */
	private ?array $not_inurl_regex = null;
	/** @var list<string>|null */
	private ?array $not_author = null;
	/** @var list<string>|null */
	private ?array $not_author_regex = null;
	/** @var list<string>|null */
	private ?array $not_tags = null;
	/** @var list<string>|null */
	private ?array $not_tags_regex = null;
	/** @var list<string>|null */
	private ?array $not_search = null;
	/** @var list<string>|null */
	private ?array $not_search_regex = null;

	public function __construct(string $input) {
		$input = self::cleanSearch($input);
		$input = self::unescape($input);
		$input = FreshRSS_BooleanSearch::unescapeLiterals($input);
		$this->raw_input = $input;

		$input = $this->parseNotEntryIds($input);
		$input = $this->parseNotFeedIds($input);
		$input = $this->parseNotCategoryIds($input);
		$input = $this->parseNotLabelIds($input);
		$input = $this->parseNotLabelNames($input);

		$input = $this->parseNotUserdateSearch($input);
		$input = $this->parseNotPubdateSearch($input);
		$input = $this->parseNotDateSearch($input);

		$input = $this->parseNotIntitleSearch($input);
		$input = $this->parseNotIntextSearch($input);
		$input = $this->parseNotAuthorSearch($input);
		$input = $this->parseNotInurlSearch($input);
		$input = $this->parseNotTagsSearch($input);

		$input = $this->parseEntryIds($input);
		$input = $this->parseFeedIds($input);
		$input = $this->parseCategoryIds($input);
		$input = $this->parseLabelIds($input);
		$input = $this->parseLabelNames($input);

		$input = $this->parseUserdateSearch($input);
		$input = $this->parsePubdateSearch($input);
		$input = $this->parseDateSearch($input);

		$input = $this->parseIntitleSearch($input);
		$input = $this->parseIntextSearch($input);
		$input = $this->parseAuthorSearch($input);
		$input = $this->parseInurlSearch($input);
		$input = $this->parseTagsSearch($input);

		$input = $this->parseQuotedSearch($input);
		$input = $this->parseNotSearch($input);
		$this->parseSearch($input);
	}

	private static function quote(string $s): string {
		if (strpbrk($s, ' "\'\\/') !== false || $s === '') {
			return '"' . addcslashes($s, '\\"') . '"';
		}
		return $s;
	}

	// TODO: Reuse as option for a string representation resolving and expanding date intervals
	// private static function dateIntervalToString(int|false|null $min, int|false|null $max): string {
	// 	if ($min === false) {
	// 		$min = null;
	// 	}
	// 	if ($max === false) {
	// 		$max = null;
	// 	}
	// 	if ($min === null && $max === null) {
	// 		return '';
	// 	}
	// 	$s = '';
	// 	if ($min !== null) {
	// 		$s .= date('Y-m-d\\TH:i:s', $min);
	// 	}
	// 	$s .= '/';
	// 	if ($max !== null) {
	// 		$s .= date('Y-m-d\\TH:i:s', $max);
	// 	}
	// 	return $s;
	// }

	/**
	 * Return true if both searches have the same constraint parameters (even if the values differ), false otherwise.
	 */
	public function hasSameOperators(FreshRSS_Search $search): bool {
		$properties = array_keys(get_object_vars($this));
		$properties = array_diff($properties, ['raw_input']);	// raw_input is not a constraint parameter
		foreach ($properties as $property) {
			// @phpstan-ignore property.dynamicName, property.dynamicName
			if (gettype($this->$property) !== gettype($search->$property)) {
				if (str_contains($property, 'min_') || str_contains($property, 'max_')) {
					// Process {min_*, max_*} pairs together (for dates)
					$mate = str_contains($property, 'min_') ? str_replace('min_', 'max_', $property) : str_replace('max_', 'min_', $property);
					// @phpstan-ignore property.dynamicName, property.dynamicName, property.dynamicName, property.dynamicName
					if (($this->$property !== null || $this->$mate !== null) !== ($search->$property !== null || $search->$mate !== null)) {
						return false;
					}
				} else {
					return false;
				}
			}
			// @phpstan-ignore property.dynamicName, property.dynamicName
			if (is_array($this->$property) && is_array($search->$property)) {
				// @phpstan-ignore property.dynamicName, property.dynamicName
				if (count($this->$property) !== count($search->$property)) {
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Modifies this search by enforcing the constraint parameters of another search.
	 * @return FreshRSS_Search a new instance, modified.
	 */
	public function enforce(FreshRSS_Search $search): self {
		$result = clone $this;
		$properties = array_keys(get_object_vars($result));
		$properties = array_diff($properties, ['raw_input']);	// raw_input is not a constraint parameter
		$result->raw_input = '';
		foreach ($properties as $property) {
			// @phpstan-ignore property.dynamicName
			if ($search->$property !== null) {
				// @phpstan-ignore property.dynamicName, property.dynamicName
				$result->$property = $search->$property;
				if (str_contains($property, 'min_') || str_contains($property, 'max_')) {
					// Process {min_*, max_*} pairs together (for dates)
					$mate = str_contains($property, 'min_') ? str_replace('min_', 'max_', $property) : str_replace('max_', 'min_', $property);
					// @phpstan-ignore property.dynamicName, property.dynamicName
					$result->$mate = $search->$mate;
				}
			}
		}
		return $result;
	}

	/**
	 * Modifies this search by removing the constraints given by another search.
	 * @return FreshRSS_Search a new instance, modified.
	 */
	public function remove(FreshRSS_Search $search): self {
		$result = clone $this;
		$properties = array_keys(get_object_vars($result));
		$properties = array_diff($properties, ['raw_input']);	// raw_input is not a constraint parameter
		$result->raw_input = '';
		foreach ($properties as $property) {
			// @phpstan-ignore property.dynamicName
			if ($search->$property !== null) {
				// @phpstan-ignore property.dynamicName
				$result->$property = null;
				if (str_contains($property, 'min_') || str_contains($property, 'max_')) {
					// Process {min_*, max_*} pairs together (for dates)
					$mate = str_contains($property, 'min_') ? str_replace('min_', 'max_', $property) : str_replace('max_', 'min_', $property);
					// @phpstan-ignore property.dynamicName
					$result->$mate = null;
				}
			}
		}
		return $result;
	}

	#[\Override]
	public function __toString(): string {
		$result = '';

		if ($this->entry_ids !== null) {
			$result .= ' e:' . implode(',', $this->entry_ids);
		}
		if ($this->feed_ids !== null) {
			$result .= ' f:' . implode(',', $this->feed_ids);
		}
		if ($this->category_ids !== null) {
			$result .= ' c:' . implode(',', $this->category_ids);
		}
		if ($this->label_ids !== null) {
			foreach ($this->label_ids as $ids) {
				$result .= ' L:' . (is_array($ids) ? implode(',', $ids) : $ids);
			}
		}
		if ($this->label_names !== null) {
			foreach ($this->label_names as $names) {
				$result .= ' labels:' . self::quote(implode(',', $names));
			}
		}

		if ($this->input_userdate !== null) {
			$result .= ' userdate:' . $this->input_userdate;
		}
		if ($this->input_pubdate !== null) {
			$result .= ' pubdate:' . $this->input_pubdate;
		}
		if ($this->input_date !== null) {
			$result .= ' date:' . $this->input_date;
		}

		if ($this->intitle_regex !== null) {
			foreach ($this->intitle_regex as $s) {
				$result .= ' intitle:' . $s;
			}
		}
		if ($this->intitle !== null) {
			foreach ($this->intitle as $s) {
				$result .= ' intitle:' . self::quote($s);
			}
		}
		if ($this->intext_regex !== null) {
			foreach ($this->intext_regex as $s) {
				$result .= ' intext:' . $s;
			}
		}
		if ($this->intext !== null) {
			foreach ($this->intext as $s) {
				$result .= ' intext:' . self::quote($s);
			}
		}
		if ($this->author_regex !== null) {
			foreach ($this->author_regex as $s) {
				$result .= ' author:' . $s;
			}
		}
		if ($this->author !== null) {
			foreach ($this->author as $s) {
				$result .= ' author:' . self::quote($s);
			}
		}
		if ($this->inurl_regex !== null) {
			foreach ($this->inurl_regex as $s) {
				$result .= ' inurl:' . $s;
			}
		}
		if ($this->inurl !== null) {
			foreach ($this->inurl as $s) {
				$result .= ' inurl:' . self::quote($s);
			}
		}
		if ($this->tags_regex !== null) {
			foreach ($this->tags_regex as $s) {
				$result .= ' #' . $s;
			}
		}
		if ($this->tags !== null) {
			foreach ($this->tags as $s) {
				$result .= ' #' . self::quote($s);
			}
		}
		if ($this->search_regex !== null) {
			foreach ($this->search_regex as $s) {
				$result .= ' ' . $s;
			}
		}
		if ($this->search !== null) {
			foreach ($this->search as $s) {
				$result .= ' ' . self::quote($s);
			}
		}

		if ($this->not_entry_ids !== null) {
			$result .= ' -e:' . implode(',', $this->not_entry_ids);
		}
		if ($this->not_feed_ids !== null) {
			$result .= ' -f:' . implode(',', $this->not_feed_ids);
		}
		if ($this->not_category_ids !== null) {
			$result .= ' -c:' . implode(',', $this->not_category_ids);
		}
		if ($this->not_label_ids !== null) {
			foreach ($this->not_label_ids as $ids) {
				$result .= ' -L:' . (is_array($ids) ? implode(',', $ids) : $ids);
			}
		}
		if ($this->not_label_names !== null) {
			foreach ($this->not_label_names as $names) {
				$result .= ' -labels:' . self::quote(implode(',', $names));
			}
		}

		if ($this->input_not_userdate !== null) {
			$result .= ' -userdate:' . $this->input_not_userdate;
		}
		if ($this->input_not_pubdate !== null) {
			$result .= ' -pubdate:' . $this->input_not_pubdate;
		}
		if ($this->input_not_date !== null) {
			$result .= ' -date:' . $this->input_not_date;
		}

		if ($this->not_intitle_regex !== null) {
			foreach ($this->not_intitle_regex as $s) {
				$result .= ' -intitle:' . $s;
			}
		}
		if ($this->not_intitle !== null) {
			foreach ($this->not_intitle as $s) {
				$result .= ' -intitle:' . self::quote($s);
			}
		}
		if ($this->not_intext_regex !== null) {
			foreach ($this->not_intext_regex as $s) {
				$result .= ' -intext:' . $s;
			}
		}
		if ($this->not_intext !== null) {
			foreach ($this->not_intext as $s) {
				$result .= ' -intext:' . self::quote($s);
			}
		}
		if ($this->not_author_regex !== null) {
			foreach ($this->not_author_regex as $s) {
				$result .= ' -author:' . $s;
			}
		}
		if ($this->not_author !== null) {
			foreach ($this->not_author as $s) {
				$result .= ' -author:' . self::quote($s);
			}
		}
		if ($this->not_inurl_regex !== null) {
			foreach ($this->not_inurl_regex as $s) {
				$result .= ' -inurl:' . $s;
			}
		}
		if ($this->not_inurl !== null) {
			foreach ($this->not_inurl as $s) {
				$result .= ' -inurl:' . self::quote($s);
			}
		}
		if ($this->not_tags_regex !== null) {
			foreach ($this->not_tags_regex as $s) {
				$result .= ' -#' . $s;
			}
		}
		if ($this->not_tags !== null) {
			foreach ($this->not_tags as $s) {
				$result .= ' -#' . self::quote($s);
			}
		}
		if ($this->not_search_regex !== null) {
			foreach ($this->not_search_regex as $s) {
				$result .= ' -' . $s;
			}
		}
		if ($this->not_search !== null) {
			foreach ($this->not_search as $s) {
				$result .= ' -' . self::quote($s);
			}
		}

		return trim($result);
	}

	#[Deprecated('Use __toString() instead')]
	public function getRawInput(): string {
		return $this->raw_input;
	}

	/** @return list<string>|null */
	public function getEntryIds(): ?array {
		return $this->entry_ids;
	}
	/** @return list<string>|null */
	public function getNotEntryIds(): ?array {
		return $this->not_entry_ids;
	}

	/** @return list<int>|null */
	public function getFeedIds(): ?array {
		return $this->feed_ids;
	}
	/** @return list<int>|null */
	public function getNotFeedIds(): ?array {
		return $this->not_feed_ids;
	}

	/** @return list<int>|null */
	public function getCategoryIds(): ?array {
		return $this->category_ids;
	}
	/** @return list<int>|null */
	public function getNotCategoryIds(): ?array {
		return $this->not_category_ids;
	}

	/** @return list<list<int>|'*'>|null */
	public function getLabelIds(): array|null {
		return $this->label_ids;
	}
	/** @return list<list<int>|'*'>|null */
	public function getNotLabelIds(): array|null {
		return $this->not_label_ids;
	}
	/** @return list<list<string>>|null */
	public function getLabelNames(bool $plaintext = false): ?array {
		return $plaintext ? $this->label_names : Minz_Helper::htmlspecialchars_utf8($this->label_names, ENT_NOQUOTES);
	}
	/** @return list<list<string>>|null */
	public function getNotLabelNames(bool $plaintext = false): ?array {
		return $plaintext ? $this->not_label_names : Minz_Helper::htmlspecialchars_utf8($this->not_label_names, ENT_NOQUOTES);
	}

	/** @return list<string>|null */
	public function getIntitle(bool $plaintext = false): ?array {
		return $plaintext ? $this->intitle : Minz_Helper::htmlspecialchars_utf8($this->intitle, ENT_NOQUOTES);
	}
	/** @return list<string>|null */
	public function getIntitleRegex(): ?array {
		return $this->intitle_regex;
	}
	/** @return list<string>|null */
	public function getNotIntitle(bool $plaintext = false): ?array {
		return $plaintext ? $this->not_intitle : Minz_Helper::htmlspecialchars_utf8($this->not_intitle, ENT_NOQUOTES);
	}
	/** @return list<string>|null */
	public function getNotIntitleRegex(): ?array {
		return $this->not_intitle_regex;
	}

	/** @return list<string>|null */
	public function getIntext(bool $plaintext = false): ?array {
		return $plaintext ? $this->intext : Minz_Helper::htmlspecialchars_utf8($this->intext, ENT_NOQUOTES);
	}
	/** @return list<string>|null */
	public function getIntextRegex(): ?array {
		return $this->intext_regex;
	}
	/** @return list<string>|null */
	public function getNotIntext(bool $plaintext = false): ?array {
		return $plaintext ? $this->not_intext : Minz_Helper::htmlspecialchars_utf8($this->not_intext, ENT_NOQUOTES);
	}
	/** @return list<string>|null */
	public function getNotIntextRegex(): ?array {
		return $this->not_intext_regex;
	}

	public function getMinDate(): ?int {
		return $this->min_date ?: null;
	}
	public function getNotMinDate(): ?int {
		return $this->not_min_date ?: null;
	}
	public function setMinDate(int $value): void {
		$this->min_date = $value;
	}

	public function getMaxDate(): ?int {
		return $this->max_date ?: null;
	}
	public function getNotMaxDate(): ?int {
		return $this->not_max_date ?: null;
	}
	public function setMaxDate(int $value): void {
		$this->max_date = $value;
	}

	public function getMinPubdate(): ?int {
		return $this->min_pubdate ?: null;
	}
	public function getNotMinPubdate(): ?int {
		return $this->not_min_pubdate ?: null;
	}

	public function getMaxPubdate(): ?int {
		return $this->max_pubdate ?: null;
	}
	public function getNotMaxPubdate(): ?int {
		return $this->not_max_pubdate ?: null;
	}
	public function setMaxPubdate(int $value): void {
		$this->max_pubdate = $value;
	}

	public function getMinUserdate(): ?int {
		return $this->min_userdate ?: null;
	}
	public function getNotMinUserdate(): ?int {
		return $this->not_min_userdate ?: null;
	}

	public function getMaxUserdate(): ?int {
		return $this->max_userdate ?: null;
	}
	public function getNotMaxUserdate(): ?int {
		return $this->not_max_userdate ?: null;
	}

	/** @return list<string>|null */
	public function getInurl(bool $plaintext = false): ?array {
		return $plaintext ? $this->inurl : Minz_Helper::htmlspecialchars_utf8($this->inurl, ENT_NOQUOTES);
	}
	/** @return list<string>|null */
	public function getInurlRegex(): ?array {
		return $this->inurl_regex;
	}
	/** @return list<string>|null */
	public function getNotInurl(bool $plaintext = false): ?array {
		return $plaintext ? $this->not_inurl : Minz_Helper::htmlspecialchars_utf8($this->not_inurl, ENT_NOQUOTES);
	}
	/** @return list<string>|null */
	public function getNotInurlRegex(): ?array {
		return $this->not_inurl_regex;
	}

	/** @return list<string>|null */
	public function getAuthor(bool $plaintext = false): ?array {
		return $plaintext ? $this->author : Minz_Helper::htmlspecialchars_utf8($this->author, ENT_NOQUOTES);
	}
	/** @return list<string>|null */
	public function getAuthorRegex(): ?array {
		return $this->author_regex;
	}
	/** @return list<string>|null */
	public function getNotAuthor(bool $plaintext = false): ?array {
		return $plaintext ? $this->not_author : Minz_Helper::htmlspecialchars_utf8($this->not_author, ENT_NOQUOTES);
	}
	/** @return list<string>|null */
	public function getNotAuthorRegex(): ?array {
		return $this->not_author_regex;
	}

	/** @return list<string>|null */
	public function getTags(bool $plaintext = false): ?array {
		return $plaintext ? $this->tags : Minz_Helper::htmlspecialchars_utf8($this->tags, ENT_NOQUOTES);
	}
	/** @return list<string>|null */
	public function getTagsRegex(): ?array {
		return $this->tags_regex;
	}
	/** @return list<string>|null */
	public function getNotTags(bool $plaintext = false): ?array {
		return $plaintext ? $this->not_tags : Minz_Helper::htmlspecialchars_utf8($this->not_tags, ENT_NOQUOTES);
	}
	/** @return list<string>|null */
	public function getNotTagsRegex(): ?array {
		return $this->not_tags_regex;
	}

	/** @return list<string>|null */
	public function getSearch(bool $plaintext = false): ?array {
		return $plaintext ? $this->search : Minz_Helper::htmlspecialchars_utf8($this->search, ENT_NOQUOTES);
	}
	/** @return list<string>|null */
	public function getSearchRegex(): ?array {
		return $this->search_regex;
	}
	/** @return list<string>|null */
	public function getNotSearch(bool $plaintext = false): ?array {
		return $plaintext ? $this->not_search : Minz_Helper::htmlspecialchars_utf8($this->not_search, ENT_NOQUOTES);
	}
	/** @return list<string>|null */
	public function getNotSearchRegex(): ?array {
		return $this->not_search_regex;
	}

	/**
	 * @param list<string>|null $anArray
	 * @return list<string>
	 */
	private static function removeEmptyValues(?array $anArray): array {
		return empty($anArray) ? [] : array_values(array_filter($anArray, static fn(string $value) => $value !== ''));
	}

	/**
	 * @param list<string>|string $value
	 * @return ($value is string ? string : list<string>)
	 */
	private static function decodeSpaces(array|string $value): array|string {
		if (is_array($value)) {
			foreach ($value as &$val) {
				$val = self::decodeSpaces($val);
			}
		} else {
			$value = trim(str_replace('+', ' ', $value));
		}
		// @phpstan-ignore return.type
		return $value;
	}

	/**
	 * Parse the search string to find entry (article) IDs.
	 */
	private function parseEntryIds(string $input): string {
		if (preg_match_all('/\\be:(?P<search>[0-9,]*)/', $input, $matches)) {
			$input = str_replace($matches[0], '', $input);
			$ids_lists = $matches['search'];
			$this->entry_ids = [];
			foreach ($ids_lists as $ids_list) {
				$entry_ids = explode(',', $ids_list);
				$entry_ids = self::removeEmptyValues($entry_ids);
				if (!empty($entry_ids)) {
					$this->entry_ids = array_merge($this->entry_ids, $entry_ids);
				}
			}
		}
		return $input;
	}

	private function parseNotEntryIds(string $input): string {
		if (preg_match_all('/(?<=[\\s(]|^)[!-]e:(?P<search>[0-9,]*)/', $input, $matches)) {
			$input = str_replace($matches[0], '', $input);
			$ids_lists = $matches['search'];
			$this->not_entry_ids = [];
			foreach ($ids_lists as $ids_list) {
				$entry_ids = explode(',', $ids_list);
				$entry_ids = self::removeEmptyValues($entry_ids);
				if (!empty($entry_ids)) {
					$this->not_entry_ids = array_merge($this->not_entry_ids, $entry_ids);
				}
			}
		}
		return $input;
	}

	private function parseFeedIds(string $input): string {
		if (preg_match_all('/\\bf:(?P<search>[0-9,]*)/', $input, $matches)) {
			$input = str_replace($matches[0], '', $input);
			$ids_lists = $matches['search'];
			$this->feed_ids = [];
			foreach ($ids_lists as $ids_list) {
				$feed_ids = explode(',', $ids_list);
				$feed_ids = self::removeEmptyValues($feed_ids);
				/** @var list<int> $feed_ids */
				$feed_ids = array_map('intval', $feed_ids);
				if (!empty($feed_ids)) {
					$this->feed_ids = array_merge($this->feed_ids, $feed_ids);
				}
			}
		}
		return $input;
	}

	private function parseNotFeedIds(string $input): string {
		if (preg_match_all('/(?<=[\\s(]|^)[!-]f:(?P<search>[0-9,]*)/', $input, $matches)) {
			$input = str_replace($matches[0], '', $input);
			$ids_lists = $matches['search'];
			$this->not_feed_ids = [];
			foreach ($ids_lists as $ids_list) {
				$feed_ids = explode(',', $ids_list);
				$feed_ids = self::removeEmptyValues($feed_ids);
				/** @var list<int> $feed_ids */
				$feed_ids = array_map('intval', $feed_ids);
				if (!empty($feed_ids)) {
					$this->not_feed_ids = array_merge($this->not_feed_ids, $feed_ids);
				}
			}
		}
		return $input;
	}

	private function parseCategoryIds(string $input): string {
		if (preg_match_all('/\\bc:(?P<search>[0-9,]*)/', $input, $matches)) {
			$input = str_replace($matches[0], '', $input);
			$ids_lists = $matches['search'];
			$this->category_ids = [];
			foreach ($ids_lists as $ids_list) {
				$category_ids = explode(',', $ids_list);
				$category_ids = self::removeEmptyValues($category_ids);
				/** @var list<int> $category_ids */
				$category_ids = array_map('intval', $category_ids);
				if (!empty($category_ids)) {
					$this->category_ids = array_merge($this->category_ids, $category_ids);
				}
			}
		}
		return $input;
	}

	private function parseNotCategoryIds(string $input): string {
		if (preg_match_all('/(?<=[\\s(]|^)[!-]c:(?P<search>[0-9,]*)/', $input, $matches)) {
			$input = str_replace($matches[0], '', $input);
			$ids_lists = $matches['search'];
			$this->not_category_ids = [];
			foreach ($ids_lists as $ids_list) {
				$category_ids = explode(',', $ids_list);
				$category_ids = self::removeEmptyValues($category_ids);
				/** @var list<int> $category_ids */
				$category_ids = array_map('intval', $category_ids);
				if (!empty($category_ids)) {
					$this->not_category_ids = array_merge($this->not_category_ids, $category_ids);
				}
			}
		}
		return $input;
	}

	/**
	 * Parse the search string to find tags (labels) IDs.
	 */
	private function parseLabelIds(string $input): string {
		if (preg_match_all('/\\b[lL]:(?P<search>[0-9,]+|[*])/', $input, $matches)) {
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
				/** @var list<int> $label_ids */
				$label_ids = array_map('intval', $label_ids);
				if (!empty($label_ids)) {
					$this->label_ids[] = $label_ids;
				}
			}
		}
		return $input;
	}

	private function parseNotLabelIds(string $input): string {
		if (preg_match_all('/(?<=[\\s(]|^)[!-][lL]:(?P<search>[0-9,]+|[*])/', $input, $matches)) {
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
				/** @var list<int> $label_ids */
				$label_ids = array_map('intval', $label_ids);
				if (!empty($label_ids)) {
					$this->not_label_ids[] = $label_ids;
				}
			}
		}
		return $input;
	}

	/**
	 * Parse the search string to find tags (labels) names.
	 */
	private function parseLabelNames(string $input): string {
		$names_lists = [];
		if (preg_match_all('/\\blabels?:(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$names_lists = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/\\blabels?:(?P<search>[^\s"]*)/', $input, $matches)) {
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
	 */
	private function parseNotLabelNames(string $input): string {
		$names_lists = [];
		if (preg_match_all('/(?<=[\\s(]|^)[!-]labels?:(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$names_lists = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/(?<=[\\s(]|^)[!-]labels?:(?P<search>[^\\s"]*)/', $input, $matches)) {
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
	 * Parse the search string to find intitle keyword and the search related to it.
	 */
	private function parseIntitleSearch(string $input): string {
		if (preg_match_all('#\\bintitle:(?P<search>/.*?(?<!\\\\)/[im]*)#', $input, $matches)) {
			$this->intitle_regex = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/\\bintitle:(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$this->intitle = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/\\bintitle:(?P<search>[^\s"]*)/', $input, $matches)) {
			$this->intitle = array_merge($this->intitle ?? [], $matches['search']);
			$input = str_replace($matches[0], '', $input);
		}
		$this->intitle = self::removeEmptyValues($this->intitle);
		if (empty($this->intitle)) {
			$this->intitle = null;
		}
		return $input;
	}

	private function parseNotIntitleSearch(string $input): string {
		if (preg_match_all('#(?<=[\\s(]|^)[!-]intitle:(?P<search>/.*?(?<!\\\\)/[im]*)#', $input, $matches)) {
			$this->not_intitle_regex = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/(?<=[\\s(]|^)[!-]intitle:(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$this->not_intitle = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/(?<=[\\s(]|^)[!-]intitle:(?P<search>[^\s"]*)/', $input, $matches)) {
			$this->not_intitle = array_merge($this->not_intitle ?? [], $matches['search']);
			$input = str_replace($matches[0], '', $input);
		}
		$this->not_intitle = self::removeEmptyValues($this->not_intitle);
		if (empty($this->not_intitle)) {
			$this->not_intitle = null;
		}
		return $input;
	}

	/**
	 * Parse the search string to find intext keyword and the search related to it.
	 */
	private function parseIntextSearch(string $input): string {
		if (preg_match_all('#\\bintext:(?P<search>/.*?(?<!\\\\)/[im]*)#', $input, $matches)) {
			$this->intext_regex = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/\\bintext:(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$this->intext = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/\\bintext:(?P<search>[^\s"]*)/', $input, $matches)) {
			$this->intext = array_merge($this->intext ?? [], $matches['search']);
			$input = str_replace($matches[0], '', $input);
		}
		$this->intext = self::removeEmptyValues($this->intext);
		if (empty($this->intext)) {
			$this->intext = null;
		}
		return $input;
	}

	private function parseNotIntextSearch(string $input): string {
		if (preg_match_all('#(?<=[\\s(]|^)[!-]intext:(?P<search>/.*?(?<!\\\\)/[im]*)#', $input, $matches)) {
			$this->not_intext_regex = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/(?<=[\\s(]|^)[!-]intext:(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$this->not_intext = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/(?<=[\\s(]|^)[!-]intext:(?P<search>[^\s"]*)/', $input, $matches)) {
			$this->not_intext = array_merge($this->not_intext ?? [], $matches['search']);
			$input = str_replace($matches[0], '', $input);
		}
		$this->not_intext = self::removeEmptyValues($this->not_intext);
		if (empty($this->not_intext)) {
			$this->not_intext = null;
		}
		return $input;
	}

	/**
	 * Parse the search string to find author keyword and the search related to it.
	 * The search is the first word following the keyword except when using
	 * a delimiter. Supported delimiters are single quote (') and double quotes (").
	 */
	private function parseAuthorSearch(string $input): string {
		if (preg_match_all('#\\bauthor:(?P<search>/.*?(?<!\\\\)/[im]*)#', $input, $matches)) {
			$this->author_regex = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/\\bauthor:(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$this->author = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/\\bauthor:(?P<search>[^\s"]*)/', $input, $matches)) {
			$this->author = array_merge($this->author ?? [], $matches['search']);
			$input = str_replace($matches[0], '', $input);
		}
		$this->author = self::removeEmptyValues($this->author);
		if (empty($this->author)) {
			$this->author = null;
		}
		return $input;
	}

	private function parseNotAuthorSearch(string $input): string {
		if (preg_match_all('#(?<=[\\s(]|^)[!-]author:(?P<search>/.*?(?<!\\\\)/[im]*)#', $input, $matches)) {
			$this->not_author_regex = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/(?<=[\\s(]|^)[!-]author:(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$this->not_author = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/(?<=[\\s(]|^)[!-]author:(?P<search>[^\s"]*)/', $input, $matches)) {
			$this->not_author = array_merge($this->not_author ?? [], $matches['search']);
			$input = str_replace($matches[0], '', $input);
		}
		$this->not_author = self::removeEmptyValues($this->not_author);
		if (empty($this->not_author)) {
			$this->not_author = null;
		}
		return $input;
	}

	/**
	 * Parse the search string to find inurl keyword and the search related to it.
	 * The search is the first word following the keyword.
	 */
	private function parseInurlSearch(string $input): string {
		if (preg_match_all('#\\binurl:(?P<search>/.*?(?<!\\\\)/[im]*)#', $input, $matches)) {
			$this->inurl_regex = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/\\binurl:(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$this->inurl = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/\\binurl:(?P<search>[^\\s]*)/', $input, $matches)) {
			$this->inurl = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		$this->inurl = self::removeEmptyValues($this->inurl);
		if (empty($this->inurl)) {
			$this->inurl = null;
		}
		return $input;
	}

	private function parseNotInurlSearch(string $input): string {
		if (preg_match_all('#(?<=[\\s(]|^)[!-]inurl:(?P<search>/.*?(?<!\\\\)/[im]*)#', $input, $matches)) {
			$this->not_inurl_regex = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/(?<=[\\s(]|^)[!-]inurl:(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$this->not_inurl = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/(?<=[\\s(]|^)[!-]inurl:(?P<search>[^\\s]*)/', $input, $matches)) {
			$this->not_inurl = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		$this->not_inurl = self::removeEmptyValues($this->not_inurl);
		if (empty($this->not_inurl)) {
			$this->not_inurl = null;
		}
		return $input;
	}

	/**
	 * Parse the search string to find date keyword and the search related to it.
	 * The search is the first word following the keyword.
	 */
	private function parseDateSearch(string $input): string {
		if (preg_match_all('/\\bdate:(?P<search>[^\\s]*)/', $input, $matches)) {
			$input = str_replace($matches[0], '', $input);
			$dates = self::removeEmptyValues($matches['search']);
			if (!empty($dates[0])) {
				[$this->min_date, $this->max_date] = parseDateInterval($dates[0]);
				if (is_int($this->min_date) || is_int($this->max_date)) {
					$this->input_date = $dates[0];
				}
			}
		}
		return $input;
	}

	private function parseNotDateSearch(string $input): string {
		if (preg_match_all('/(?<=[\\s(]|^)[!-]date:(?P<search>[^\\s]*)/', $input, $matches)) {
			$input = str_replace($matches[0], '', $input);
			$dates = self::removeEmptyValues($matches['search']);
			if (!empty($dates[0])) {
				[$this->not_min_date, $this->not_max_date] = parseDateInterval($dates[0]);
				if (is_int($this->not_min_date) || is_int($this->not_max_date)) {
					$this->input_not_date = $dates[0];
				}
			}
		}
		return $input;
	}


	/**
	 * Parse the search string to find pubdate keyword and the search related to it.
	 * The search is the first word following the keyword.
	 */
	private function parsePubdateSearch(string $input): string {
		if (preg_match_all('/\\bpubdate:(?P<search>[^\\s]*)/', $input, $matches)) {
			$input = str_replace($matches[0], '', $input);
			$dates = self::removeEmptyValues($matches['search']);
			if (!empty($dates[0])) {
				[$this->min_pubdate, $this->max_pubdate] = parseDateInterval($dates[0]);
				if (is_int($this->min_pubdate) || is_int($this->max_pubdate)) {
					$this->input_pubdate = $dates[0];
				}
			}
		}
		return $input;
	}

	private function parseNotPubdateSearch(string $input): string {
		if (preg_match_all('/(?<=[\\s(]|^)[!-]pubdate:(?P<search>[^\\s]*)/', $input, $matches)) {
			$input = str_replace($matches[0], '', $input);
			$dates = self::removeEmptyValues($matches['search']);
			if (!empty($dates[0])) {
				[$this->not_min_pubdate, $this->not_max_pubdate] = parseDateInterval($dates[0]);
				if (is_int($this->not_min_pubdate) || is_int($this->not_max_pubdate)) {
					$this->input_not_pubdate = $dates[0];
				}
			}
		}
		return $input;
	}

	/**
	 * Parse the search string to find userdate keyword and the search related to it.
	 * The search is the first word following the keyword.
	 */
	private function parseUserdateSearch(string $input): string {
		if (preg_match_all('/\\buserdate:(?P<search>[^\\s]*)/', $input, $matches)) {
			$input = str_replace($matches[0], '', $input);
			$dates = self::removeEmptyValues($matches['search']);
			if (!empty($dates[0])) {
				[$this->min_userdate, $this->max_userdate] = parseDateInterval($dates[0]);
				if (is_int($this->min_userdate) || is_int($this->max_userdate)) {
					$this->input_userdate = $dates[0];
				}
			}
		}
		return $input;
	}

	private function parseNotUserdateSearch(string $input): string {
		if (preg_match_all('/(?<=[\\s(]|^)[!-]userdate:(?P<search>[^\\s]*)/', $input, $matches)) {
			$input = str_replace($matches[0], '', $input);
			$dates = self::removeEmptyValues($matches['search']);
			if (!empty($dates[0])) {
				[$this->not_min_userdate, $this->not_max_userdate] = parseDateInterval($dates[0]);
				if (is_int($this->not_min_userdate) || is_int($this->not_max_userdate)) {
					$this->input_not_userdate = $dates[0];
				}
			}
		}
		return $input;
	}

	/**
	 * Parse the search string to find tags keyword (# followed by a word)
	 * and the search related to it.
	 * The search is the first word following the #.
	 */
	private function parseTagsSearch(string $input): string {
		if (preg_match_all('%#(?P<search>/.*?(?<!\\\\)/[im]*)%', $input, $matches)) {
			$this->tags_regex = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/#(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$this->tags = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/#(?P<search>[^\\s]+)/', $input, $matches)) {
			$this->tags = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		$this->tags = self::removeEmptyValues($this->tags);
		if (empty($this->tags)) {
			$this->tags = null;
		} else {
			$this->tags = self::decodeSpaces($this->tags);
		}
		return $input;
	}

	private function parseNotTagsSearch(string $input): string {
		if (preg_match_all('%(?<=[\\s(]|^)[!-]#(?P<search>/.*?(?<!\\\\)/[im]*)%', $input, $matches)) {
			$this->not_tags_regex = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/(?<=[\\s(]|^)[!-]#(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$this->not_tags = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/(?<=[\\s(]|^)[!-]#(?P<search>[^\\s]+)/', $input, $matches)) {
			$this->not_tags = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		$this->not_tags = self::removeEmptyValues($this->not_tags);
		if (empty($this->not_tags)) {
			$this->not_tags = null;
		} else {
			$this->not_tags = self::decodeSpaces($this->not_tags);
		}
		return $input;
	}

	/**
	 * Parse the search string to find search values.
	 * Every word is a distinct search value using a delimiter.
	 * Supported delimiters are single quote (') and double quotes (") and regex (/).
	 */
	private function parseQuotedSearch(string $input): string {
		$input = self::cleanSearch($input);
		if ($input === '') {
			return '';
		}
		if (preg_match_all('#(?<=[\\s(]|^)(?<![!-\\\\])(?P<search>/.*?(?<!\\\\)/[im]*)#', $input, $matches)) {
			$this->search_regex = $matches['search'];
			//TODO: Replace all those str_replace with PREG_OFFSET_CAPTURE
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/(?<=[\\s(]|^)(?<![!-\\\\])(?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$this->search = $matches['search'];
			//TODO: Replace all those str_replace with PREG_OFFSET_CAPTURE
			$input = str_replace($matches[0], '', $input);
		}
		return $input;
	}

	/**
	 * Parse the search string to find search values.
	 * Every word is a distinct search value.
	 */
	private function parseSearch(string $input): string {
		$input = self::cleanSearch($input);
		if ($input === '') {
			return '';
		}
		if (is_array($this->search)) {
			$this->search = array_merge($this->search, explode(' ', $input));
		} else {
			$this->search = explode(' ', $input);
		}
		return $input;
	}

	private function parseNotSearch(string $input): string {
		$input = self::cleanSearch($input);
		if ($input === '') {
			return '';
		}
		if (preg_match_all('#(?<=[\\s(]|^)[!-](?P<search>(?<!\\\\)/.*?(?<!\\\\)/[im]*)#', $input, $matches)) {
			$this->not_search_regex = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		if (preg_match_all('/(?<=[\\s(]|^)[!-](?P<delim>[\'"])(?P<search>.*)(?P=delim)/U', $input, $matches)) {
			$this->not_search = $matches['search'];
			$input = str_replace($matches[0], '', $input);
		}
		$input = self::cleanSearch($input);
		if ($input === '') {
			return '';
		}
		if (preg_match_all('/(?<=[\\s(]|^)[!-](?P<search>[^\\s]+)/', $input, $matches)) {
			$this->not_search = array_merge(is_array($this->not_search) ? $this->not_search : [], $matches['search']);
			$input = str_replace($matches[0], '', $input);
		}
		$this->not_search = self::removeEmptyValues($this->not_search);
		return $input;
	}

	/**
	 * Remove all unnecessary spaces in the search
	 */
	private static function cleanSearch(string $input): string {
		$input = preg_replace('/\\s+/', ' ', $input);
		if (!is_string($input)) {
			return '';
		}
		return trim($input);
	}

	/** Remove escaping backslashes for parenthesis logic */
	private static function unescape(string $input): string {
		return str_replace(['\\(', '\\)'], ['(', ')'], $input);
	}
}
