<?php
declare(strict_types=1);

class FreshRSS_Entry extends Minz_Model {
	use FreshRSS_AttributesTrait;

	public const STATE_READ = 1;
	public const STATE_NOT_READ = 2;
	public const STATE_ALL = 3;
	public const STATE_FAVORITE = 4;
	public const STATE_NOT_FAVORITE = 8;

	private string $id = '0';
	private string $guid;
	private string $title;
	/** @var array<string> */
	private array $authors;
	private string $content;
	private string $link;
	private int $date;
	private int $lastSeen = 0;
	/** In microseconds */
	private string $date_added = '0';
	private string $hash = '';
	private ?bool $is_read;
	private ?bool $is_favorite;
	private int $feedId;
	private ?FreshRSS_Feed $feed;
	/** @var array<string> */
	private array $tags = [];

	/**
	 * @param int|string $pubdate
	 * @param bool|int|null $is_read
	 * @param bool|int|null $is_favorite
	 * @param string|array<string> $tags
	 */
	public function __construct(int $feedId = 0, string $guid = '', string $title = '', string $authors = '', string $content = '',
			string $link = '', $pubdate = 0, $is_read = false, $is_favorite = false, $tags = '') {
		$this->_title($title);
		$this->_authors($authors);
		$this->_content($content);
		$this->_link($link);
		$this->_date($pubdate);
		$this->_isRead($is_read);
		$this->_isFavorite($is_favorite);
		$this->_feedId($feedId);
		$this->_tags($tags);
		$this->_guid($guid);
	}

	/** @param array{'id'?:string,'id_feed'?:int,'guid'?:string,'title'?:string,'author'?:string,'content'?:string,'link'?:string,'date'?:int|string,'lastSeen'?:int,
	 *		'hash'?:string,'is_read'?:bool|int,'is_favorite'?:bool|int,'tags'?:string|array<string>,'attributes'?:?string,'thumbnail'?:string,'timestamp'?:string} $dao */
	public static function fromArray(array $dao): FreshRSS_Entry {
		FreshRSS_DatabaseDAO::pdoInt($dao, ['id_feed', 'date', 'lastSeen', 'is_read', 'is_favorite']);

		if (empty($dao['content'])) {
			$dao['content'] = '';
		}

		$dao['attributes'] = empty($dao['attributes']) ? [] : json_decode($dao['attributes'], true);
		if (!is_array($dao['attributes'])) {
			$dao['attributes'] = [];
		}

		if (!empty($dao['thumbnail'])) {
			$dao['attributes']['thumbnail'] = [
				'url' => $dao['thumbnail'],
			];
		}
		$entry = new FreshRSS_Entry(
			$dao['id_feed'] ?? 0,
			$dao['guid'] ?? '',
			$dao['title'] ?? '',
			$dao['author'] ?? '',
			$dao['content'],
			$dao['link'] ?? '',
			$dao['date'] ?? 0,
			$dao['is_read'] ?? false,
			$dao['is_favorite'] ?? false,
			$dao['tags'] ?? ''
		);
		if (!empty($dao['id'])) {
			$entry->_id($dao['id']);
		}
		if (!empty($dao['timestamp'])) {
			$entry->_date(strtotime($dao['timestamp']) ?: 0);
		}
		if (isset($dao['lastSeen'])) {
			$entry->_lastSeen($dao['lastSeen']);
		}
		if (!empty($dao['attributes'])) {
			$entry->_attributes($dao['attributes']);
		}
		if (!empty($dao['hash'])) {
			$entry->_hash($dao['hash']);
		}
		return $entry;
	}

	/**
	 * @param Traversable<array{'id'?:string,'id_feed'?:int,'guid'?:string,'title'?:string,'author'?:string,'content'?:string,'link'?:string,'date'?:int|string,'lastSeen'?:int,
	 *	'hash'?:string,'is_read'?:bool|int,'is_favorite'?:bool|int,'tags'?:string|array<string>,'attributes'?:?string,'thumbnail'?:string,'timestamp'?:string}> $daos
	 * @return Traversable<FreshRSS_Entry>
	 */
	public static function fromTraversable(Traversable $daos): Traversable {
		foreach ($daos as $dao) {
			yield FreshRSS_Entry::fromArray($dao);
		}
	}

	public function id(): string {
		return $this->id;
	}
	public function guid(): string {
		return $this->guid;
	}
	public function title(): string {
		return $this->title == '' ? $this->guid() : $this->title;
	}
	/** @deprecated */
	public function author(): string {
		return $this->authors(true);
	}
	/**
	 * @phpstan-return ($asString is true ? string : array<string>)
	 * @return string|array<string>
	 */
	public function authors(bool $asString = false) {
		if ($asString) {
			return $this->authors == null ? '' : ';' . implode('; ', $this->authors);
		} else {
			return $this->authors;
		}
	}

	/**
	 * Basic test without ambition to catch all cases such as unquoted addresses, variants of entities, HTML comments, etc.
	 */
	private static function containsLink(string $html, string $link): bool {
		return preg_match('/(?P<delim>[\'"])' . preg_quote($link, '/') . '(?P=delim)/', $html) == 1;
	}

	/** @param array{'url'?:string,'length'?:int,'medium'?:string,'type'?:string} $enclosure */
	private static function enclosureIsImage(array $enclosure): bool {
		$elink = $enclosure['url'] ?? '';
		$length = $enclosure['length'] ?? 0;
		$medium = $enclosure['medium'] ?? '';
		$mime = $enclosure['type'] ?? '';

		return ($elink != '' && $medium === 'image') || strpos($mime, 'image') === 0 ||
			($mime == '' && $length == 0 && preg_match('/[.](avif|gif|jpe?g|png|svg|webp)$/i', $elink));
	}

	/**
	 * Provides the original content without additional content potentially added by loadCompleteContent().
	 */
	public function originalContent(): string {
		return preg_replace('#<!-- FULLCONTENT start //-->.*<!-- FULLCONTENT end //-->#s', '', $this->content) ?? '';
	}

	/**
	 * @param bool $withEnclosures Set to true to include the enclosures in the returned HTML, false otherwise.
	 * @param bool $allowDuplicateEnclosures Set to false to remove obvious enclosure duplicates (based on simple string comparison), true otherwise.
	 * @return string HTML content
	 */
	public function content(bool $withEnclosures = true, bool $allowDuplicateEnclosures = false): string {
		if (!$withEnclosures) {
			return $this->content;
		}

		$content = $this->content;

		$thumbnailAttribute = $this->attributeArray('thumbnail') ?? [];
		if (!empty($thumbnailAttribute['url'])) {
			$elink = $thumbnailAttribute['url'];
			if ($allowDuplicateEnclosures || !self::containsLink($content, $elink)) {
			$content .= <<<HTML
<figure class="enclosure">
	<p class="enclosure-content">
		<img class="enclosure-thumbnail" src="{$elink}" alt="" />
	</p>
</figure>
HTML;
			}
		}

		$attributeEnclosures = $this->attributeArray('enclosures');
		if (empty($attributeEnclosures)) {
			return $content;
		}

		foreach ($attributeEnclosures as $enclosure) {
			if (!is_array($enclosure)) {
				continue;
			}
			$elink = $enclosure['url'] ?? '';
			if ($elink == '') {
				continue;
			}
			if (!$allowDuplicateEnclosures && self::containsLink($content, $elink)) {
				continue;
			}
			$credit = $enclosure['credit'] ?? '';
			$description = nl2br($enclosure['description'] ?? '', true);
			$length = $enclosure['length'] ?? 0;
			$medium = $enclosure['medium'] ?? '';
			$mime = $enclosure['type'] ?? '';
			$thumbnails = $enclosure['thumbnails'] ?? null;
			if (!is_array($thumbnails)) {
				$thumbnails = [];
			}
			$etitle = $enclosure['title'] ?? '';

			$content .= "\n";
			$content .= '<figure class="enclosure">';

			foreach ($thumbnails as $thumbnail) {
				$content .= '<p><img class="enclosure-thumbnail" src="' . $thumbnail . '" alt="" title="' . $etitle . '" /></p>';
			}

			if (self::enclosureIsImage($enclosure)) {
				$content .= '<p class="enclosure-content"><img src="' . $elink . '" alt="" title="' . $etitle . '" /></p>';
			} elseif ($medium === 'audio' || strpos($mime, 'audio') === 0) {
				$content .= '<p class="enclosure-content"><audio preload="none" src="' . $elink
					. ($length == null ? '' : '" data-length="' . intval($length))
					. ($mime == '' ? '' : '" data-type="' . htmlspecialchars($mime, ENT_COMPAT, 'UTF-8'))
					. '" controls="controls" title="' . $etitle . '"></audio> <a download="" href="' . $elink . '">💾</a></p>';
			} elseif ($medium === 'video' || strpos($mime, 'video') === 0) {
				$content .= '<p class="enclosure-content"><video preload="none" src="' . $elink
					. ($length == null ? '' : '" data-length="' . intval($length))
					. ($mime == '' ? '' : '" data-type="' . htmlspecialchars($mime, ENT_COMPAT, 'UTF-8'))
					. '" controls="controls" title="' . $etitle . '"></video> <a download="" href="' . $elink . '">💾</a></p>';
			} else {	//e.g. application, text, unknown
				$content .= '<p class="enclosure-content"><a download="" href="' . $elink
					. ($mime == '' ? '' : '" data-type="' . htmlspecialchars($mime, ENT_COMPAT, 'UTF-8'))
					. ($medium == '' ? '' : '" data-medium="' . htmlspecialchars($medium, ENT_COMPAT, 'UTF-8'))
					. '" title="' . $etitle . '">💾</a></p>';
			}

			if ($credit != '') {
				$content .= '<p class="enclosure-credits">© ' . $credit . '</p>';
			}
			if ($description != '') {
				$content .= '<figcaption class="enclosure-description">' . $description . '</figcaption>';
			}
			$content .= "</figure>\n";
		}

		return $content;
	}

	/** @return Traversable<array{'url':string,'type'?:string,'medium'?:string,'length'?:int,'title'?:string,'description'?:string,'credit'?:string,'height'?:int,'width'?:int,'thumbnails'?:array<string>}> */
	public function enclosures(bool $searchBodyImages = false): Traversable {
		$attributeEnclosures = $this->attributeArray('enclosures');
		if (is_iterable($attributeEnclosures)) {
			// FreshRSS 1.20.1+: The enclosures are saved as attributes
			yield from $attributeEnclosures;
		}
		try {
			$searchEnclosures = !is_iterable($attributeEnclosures) && (strpos($this->content, '<p class="enclosure-content') !== false);
			$searchBodyImages &= (stripos($this->content, '<img') !== false);
			$xpath = null;
			if ($searchEnclosures || $searchBodyImages) {
				$dom = new DOMDocument();
				$dom->loadHTML('<?xml version="1.0" encoding="UTF-8" ?>' . $this->content, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);
				$xpath = new DOMXPath($dom);
			}
			if ($searchEnclosures && $xpath !== null) {
				// Legacy code for database entries < FreshRSS 1.20.1
				$enclosures = $xpath->query('//div[@class="enclosure"]/p[@class="enclosure-content"]/*[@src]');
				if (!empty($enclosures)) {
					/** @var DOMElement $enclosure */
					foreach ($enclosures as $enclosure) {
						$result = [
							'url' => $enclosure->getAttribute('src'),
							'type' => $enclosure->getAttribute('data-type'),
							'medium' => $enclosure->getAttribute('data-medium'),
							'length' => (int)($enclosure->getAttribute('data-length')),
						];
						if (empty($result['medium'])) {
							switch (strtolower($enclosure->nodeName)) {
								case 'img': $result['medium'] = 'image'; break;
								case 'video': $result['medium'] = 'video'; break;
								case 'audio': $result['medium'] = 'audio'; break;
							}
						}
						yield Minz_Helper::htmlspecialchars_utf8($result);
					}
				}
			}
			if ($searchBodyImages && $xpath !== null) {
				$images = $xpath->query('//img');
				if (!empty($images)) {
					/** @var DOMElement $img */
					foreach ($images as $img) {
						$src = $img->getAttribute('src');
						if ($src == null) {
							$src = $img->getAttribute('data-src');
						}
						if ($src != null) {
							$result = [
								'url' => $src,
								'medium' => 'image',
							];
							yield Minz_Helper::htmlspecialchars_utf8($result);
						}
					}
				}
			}
		} catch (Exception $ex) {
			Minz_Log::debug(__METHOD__ . ' ' . $ex->getMessage());
		}
	}

	/**
	 * @return array{'url':string,'height'?:int,'width'?:int,'time'?:string}|null
	 */
	public function thumbnail(bool $searchEnclosures = true): ?array {
		$thumbnail = $this->attributeArray('thumbnail') ?? [];
		// First, use the provided thumbnail, if any
		if (!empty($thumbnail['url'])) {
			return $thumbnail;
		}
		if ($searchEnclosures) {
			foreach ($this->enclosures(true) as $enclosure) {
				// Second, search each enclosure’s thumbnails
				if (!empty($enclosure['thumbnails'][0])) {
					foreach ($enclosure['thumbnails'] as $src) {
						if (is_string($src)) {
							return [
								'url' => $src,
								'medium' => 'image',
							];
						}
					}
				}
				// Third, check whether each enclosure itself is an appropriate image
				if (self::enclosureIsImage($enclosure)) {
					return $enclosure;
				}
			}
		}
		return null;
	}

	/** @return string HTML-encoded link of the entry */
	public function link(): string {
		return $this->link;
	}
	/**
	 * @phpstan-return ($raw is false ? string : int)
	 * @return string|int
	 */
	public function date(bool $raw = false) {
		if ($raw) {
			return $this->date;
		}
		return timestamptodate($this->date);
	}
	public function machineReadableDate(): string {
		return @date (DATE_ATOM, $this->date);
	}

	public function lastSeen(): int {
		return $this->lastSeen;
	}

	/**
	 * @phpstan-return ($raw is false ? string : ($microsecond is true ? string : int))
	 * @return int|string
	 */
	public function dateAdded(bool $raw = false, bool $microsecond = false) {
		if ($raw) {
			if ($microsecond) {
				return $this->date_added;
			} else {
				return intval(substr($this->date_added, 0, -6));
			}
		} else {
			$date = intval(substr($this->date_added, 0, -6));
			return timestamptodate($date);
		}
	}
	public function isRead(): ?bool {
		return $this->is_read;
	}
	public function isFavorite(): ?bool {
		return $this->is_favorite;
	}

	public function feed(): ?FreshRSS_Feed {
		if ($this->feed === null) {
			$feedDAO = FreshRSS_Factory::createFeedDao();
			$this->feed = $feedDAO->searchById($this->feedId);
		}
		return $this->feed;
	}

	public function feedId(): int {
		return $this->feedId;
	}

	/**
	 * @phpstan-return ($asString is true ? string : array<string>)
	 * @return string|array<string>
	 */
	public function tags(bool $asString = false) {
		if ($asString) {
			return $this->tags == null ? '' : '#' . implode(' #', $this->tags);
		} else {
			return $this->tags;
		}
	}

	public function hash(): string {
		if ($this->hash == '') {
			//Do not include $this->date because it may be automatically generated when lacking
			$this->hash = md5($this->link . $this->title . $this->authors(true) . $this->originalContent() . $this->tags(true));
		}
		return $this->hash;
	}

	public function _hash(string $value): string {
		$value = trim($value);
		if (ctype_xdigit($value)) {
			$this->hash = substr($value, 0, 32);
		}
		return $this->hash;
	}

	/** @param int|string $value String is for compatibility with 32-bit platforms */
	public function _id($value): void {
		if (is_int($value)) {
			$value = (string)$value;
		}
		$this->id = $value;
		if ($this->date_added == 0) {
			$this->date_added = $value;
		}
	}
	public function _guid(string $value): void {
		$value = trim($value);
		if (empty($value)) {
			$value = $this->link;
			if (empty($value)) {
				$value = $this->hash();
			}
		}
		$this->guid = $value;
	}
	public function _title(string $value): void {
		$this->hash = '';
		$this->title = trim($value);
	}
	/** @deprecated */
	public function _author(string $value): void {
		$this->_authors($value);
	}
	/** @param array<string>|string $value */
	public function _authors($value): void {
		$this->hash = '';
		if (!is_array($value)) {
			if (strpos($value, ';') !== false) {
				$value = htmlspecialchars_decode($value, ENT_QUOTES);
				$value = preg_split('/\s*[;]\s*/', $value, -1, PREG_SPLIT_NO_EMPTY) ?: [];
				$value = Minz_Helper::htmlspecialchars_utf8($value);
			} else {
				$value = preg_split('/\s*[,]\s*/', $value, -1, PREG_SPLIT_NO_EMPTY) ?: [];
			}
		}
		$this->authors = $value;
	}
	public function _content(string $value): void {
		$this->hash = '';
		$this->content = $value;
	}
	public function _link(string $value): void {
		$this->hash = '';
		$this->link = trim($value);
	}
	/** @param int|string $value */
	public function _date($value): void {
		$value = intval($value);
		$this->date = $value > 1 ? $value : time();
	}

	public function _lastSeen(int $value): void {
		$this->lastSeen = $value > 0 ? $value : 0;
	}

	/** @param int|string $value */
	public function _dateAdded($value, bool $microsecond = false): void {
		if ($microsecond) {
			$this->date_added = (string)($value);
		} else {
			$this->date_added = $value . '000000';
		}
	}
	/** @param bool|int|null $value */
	public function _isRead($value): void {
		$this->is_read = $value === null ? null : (bool)$value;
	}
	/** @param bool|int|null $value */
	public function _isFavorite($value): void {
		$this->is_favorite = $value === null ? null : (bool)$value;
	}

	public function _feed(?FreshRSS_Feed $feed): void {
		$this->feed = $feed;
		$this->feedId = $this->feed == null ? 0 : $this->feed->id();
	}

	/** @param int|string $id */
	private function _feedId($id): void {
		$this->feed = null;
		$this->feedId = intval($id);
	}

	/** @param array<string>|string $value */
	public function _tags($value): void {
		$this->hash = '';
		if (!is_array($value)) {
			$value = preg_split('/\s*[#,]\s*/', $value, -1, PREG_SPLIT_NO_EMPTY) ?: [];
		}
		$this->tags = $value;
	}

	public function matches(FreshRSS_BooleanSearch $booleanSearch): bool {
		$ok = true;
		foreach ($booleanSearch->searches() as $filter) {
			if ($filter instanceof FreshRSS_BooleanSearch) {
				// BooleanSearches are combined by AND (default) or OR or AND NOT (special cases) operators and are recursive
				if ($filter->operator() === 'OR') {
					$ok |= $this->matches($filter);
				} elseif ($filter->operator() === 'AND NOT') {
					$ok &= !$this->matches($filter);
				} else {	// AND
					$ok &= $this->matches($filter);
				}
			} elseif ($filter instanceof FreshRSS_Search) {
				// Searches are combined by OR and are not recursive
				$ok = true;
				if ($filter->getEntryIds()) {
					$ok &= in_array($this->id, $filter->getEntryIds(), true);
				}
				if ($ok && $filter->getNotEntryIds()) {
					$ok &= !in_array($this->id, $filter->getNotEntryIds(), true);
				}
				if ($ok && $filter->getMinDate()) {
					$ok &= strnatcmp($this->id, $filter->getMinDate() . '000000') >= 0;
				}
				if ($ok && $filter->getNotMinDate()) {
					$ok &= strnatcmp($this->id, $filter->getNotMinDate() . '000000') < 0;
				}
				if ($ok && $filter->getMaxDate()) {
					$ok &= strnatcmp($this->id, $filter->getMaxDate() . '000000') <= 0;
				}
				if ($ok && $filter->getNotMaxDate()) {
					$ok &= strnatcmp($this->id, $filter->getNotMaxDate() . '000000') > 0;
				}
				if ($ok && $filter->getMinPubdate()) {
					$ok &= $this->date >= $filter->getMinPubdate();
				}
				if ($ok && $filter->getNotMinPubdate()) {
					$ok &= $this->date < $filter->getNotMinPubdate();
				}
				if ($ok && $filter->getMaxPubdate()) {
					$ok &= $this->date <= $filter->getMaxPubdate();
				}
				if ($ok && $filter->getNotMaxPubdate()) {
					$ok &= $this->date > $filter->getNotMaxPubdate();
				}
				if ($ok && $filter->getFeedIds()) {
					$ok &= in_array($this->feedId, $filter->getFeedIds(), true);
				}
				if ($ok && $filter->getNotFeedIds()) {
					$ok &= !in_array($this->feedId, $filter->getNotFeedIds(), true);
				}
				if ($ok && $filter->getAuthor()) {
					foreach ($filter->getAuthor() as $author) {
						$ok &= stripos(implode(';', $this->authors), $author) !== false;
					}
				}
				if ($ok && $filter->getNotAuthor()) {
					foreach ($filter->getNotAuthor() as $author) {
						$ok &= stripos(implode(';', $this->authors), $author) === false;
					}
				}
				if ($ok && $filter->getIntitle()) {
					foreach ($filter->getIntitle() as $title) {
						$ok &= stripos($this->title, $title) !== false;
					}
				}
				if ($ok && $filter->getNotIntitle()) {
					foreach ($filter->getNotIntitle() as $title) {
						$ok &= stripos($this->title, $title) === false;
					}
				}
				if ($ok && $filter->getTags()) {
					foreach ($filter->getTags() as $tag2) {
						$found = false;
						foreach ($this->tags as $tag1) {
							if (strcasecmp($tag1, $tag2) === 0) {
								$found = true;
							}
						}
						$ok &= $found;
					}
				}
				if ($ok && $filter->getNotTags()) {
					foreach ($filter->getNotTags() as $tag2) {
						$found = false;
						foreach ($this->tags as $tag1) {
							if (strcasecmp($tag1, $tag2) === 0) {
								$found = true;
							}
						}
						$ok &= !$found;
					}
				}
				if ($ok && $filter->getInurl()) {
					foreach ($filter->getInurl() as $url) {
						$ok &= stripos($this->link, $url) !== false;
					}
				}
				if ($ok && $filter->getNotInurl()) {
					foreach ($filter->getNotInurl() as $url) {
						$ok &= stripos($this->link, $url) === false;
					}
				}
				if ($ok && $filter->getSearch()) {
					foreach ($filter->getSearch() as $needle) {
						$ok &= (stripos($this->title, $needle) !== false || stripos($this->content, $needle) !== false);
					}
				}
				if ($ok && $filter->getNotSearch()) {
					foreach ($filter->getNotSearch() as $needle) {
						$ok &= (stripos($this->title, $needle) === false && stripos($this->content, $needle) === false);
					}
				}
				if ($ok) {
					return true;
				}
			}
		}
		return (bool)$ok;
	}

	/** @param array<string,bool|int> $titlesAsRead */
	public function applyFilterActions(array $titlesAsRead = []): void {
		$feed = $this->feed;
		if ($feed === null) {
			return;
		}
		if (!$this->isRead()) {
			if ($feed->attributeBoolean('read_upon_reception') ||
				($feed->attributeBoolean('read_upon_reception') === null && FreshRSS_Context::userConf()->mark_when['reception'])) {
				$this->_isRead(true);
				Minz_ExtensionManager::callHook('entry_auto_read', $this, 'upon_reception');
			}
			if (!empty($titlesAsRead[$this->title()])) {
				Minz_Log::debug('Mark title as read: ' . $this->title());
				$this->_isRead(true);
				Minz_ExtensionManager::callHook('entry_auto_read', $this, 'same_title_in_feed');
			}
		}
		FreshRSS_Context::userConf()->applyFilterActions($this);
		if ($feed->category() !== null) {
			$feed->category()->applyFilterActions($this);
		}
		$feed->applyFilterActions($this);
	}

	public function isDay(int $day, int $today): bool {
		$date = $this->dateAdded(true);
		switch ($day) {
		case FreshRSS_Days::TODAY:
			$tomorrow = $today + 86400;
			return $date >= $today && $date < $tomorrow;
		case FreshRSS_Days::YESTERDAY:
			$yesterday = $today - 86400;
			return $date >= $yesterday && $date < $today;
		case FreshRSS_Days::BEFORE_YESTERDAY:
			$yesterday = $today - 86400;
			return $date < $yesterday;
		default:
			return false;
		}
	}

	/**
	 * @param array<string,mixed> $attributes
	 * @throws Minz_Exception
	 */
	public static function getContentByParsing(string $url, string $path, array $attributes = [], int $maxRedirs = 3): string {
		$cachePath = FreshRSS_Feed::cacheFilename($url, $attributes, FreshRSS_Feed::KIND_HTML_XPATH);
		$html = httpGet($url, $cachePath, 'html', $attributes);
		if (strlen($html) > 0) {
			$doc = new DOMDocument();
			$doc->loadHTML($html, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);
			$xpath = new DOMXPath($doc);

			if ($maxRedirs > 0) {
				//Follow any HTML redirection
				$metas = $xpath->query('//meta[@content]') ?: [];
				foreach ($metas as $meta) {
					if ($meta instanceof DOMElement && strtolower(trim($meta->getAttribute('http-equiv'))) === 'refresh') {
						$refresh = preg_replace('/^[0-9.; ]*\s*(url\s*=)?\s*/i', '', trim($meta->getAttribute('content')));
						$refresh = SimplePie_Misc::absolutize_url($refresh, $url);
						if ($refresh != false && $refresh !== $url) {
							return self::getContentByParsing($refresh, $path, $attributes, $maxRedirs - 1);
						}
					}
				}
			}

			$base = $xpath->evaluate('normalize-space(//base/@href)');
			if ($base == false || !is_string($base)) {
				$base = $url;
			} elseif (substr($base, 0, 2) === '//') {
				//Protocol-relative URLs "//www.example.net"
				$base = (parse_url($url, PHP_URL_SCHEME) ?? 'https') . ':' . $base;
			}

			$content = '';
			$nodes = $xpath->query((new Gt\CssXPath\Translator($path))->asXPath());
			if ($nodes != false) {
				foreach ($nodes as $node) {
					if (!empty($attributes['path_entries_filter'])) {
						$filterednodes = $xpath->query((new Gt\CssXPath\Translator($attributes['path_entries_filter']))->asXPath(), $node) ?: [];
						foreach ($filterednodes as $filterednode) {
							if ($filterednode->parentNode === null) {
								continue;
							}
							$filterednode->parentNode->removeChild($filterednode);
						}
					}
					$content .= $doc->saveHTML($node) . "\n";
				}
			}
			$html = trim(sanitizeHTML($content, $base));
			return $html;
		} else {
			throw new Minz_Exception();
		}
	}

	public function loadCompleteContent(bool $force = false): bool {
		// Gestion du contenu
		// Trying to fetch full article content even when feeds do not propose it
		$feed = $this->feed();
		if ($feed != null && trim($feed->pathEntries()) != '') {
			$entryDAO = FreshRSS_Factory::createEntryDao();
			$entry = $force ? null : $entryDAO->searchByGuid($this->feedId, $this->guid);

			if ($entry) {
				// l’article existe déjà en BDD, en se contente de recharger ce contenu
				$this->content = $entry->content(false);
			} else {
				try {
					// The article is not yet in the database, so let’s fetch it
					$fullContent = self::getContentByParsing(
						htmlspecialchars_decode($this->link(), ENT_QUOTES),
						htmlspecialchars_decode($feed->pathEntries(), ENT_QUOTES),
						$feed->attributes()
					);
					if ('' !== $fullContent) {
						$fullContent = "<!-- FULLCONTENT start //-->{$fullContent}<!-- FULLCONTENT end //-->";
						$originalContent = $this->originalContent();
						switch ($feed->attributeString('content_action')) {
							case 'prepend':
								$this->content = $fullContent . $originalContent;
								break;
							case 'append':
								$this->content = $originalContent . $fullContent;
								break;
							case 'replace':
							default:
								$this->content = $fullContent;
								break;
						}

						return true;
					}
				} catch (Exception $e) {
					// rien à faire, on garde l’ancien contenu(requête a échoué)
					Minz_Log::warning($e->getMessage());
				}
			}
		}
		return false;
	}

	/**
	 * @return array{'id':string,'guid':string,'title':string,'author':string,'content':string,'link':string,'date':int,'lastSeen':int,
	 * 	'hash':string,'is_read':?bool,'is_favorite':?bool,'id_feed':int,'tags':string,'attributes':array<string,mixed>}
	 */
	public function toArray(): array {
		return [
			'id' => $this->id(),
			'guid' => $this->guid(),
			'title' => $this->title(),
			'author' => $this->authors(true),
			'content' => $this->content(false),
			'link' => $this->link(),
			'date' => $this->date(true),
			'lastSeen' => $this->lastSeen(),
			'hash' => $this->hash(),
			'is_read' => $this->isRead(),
			'is_favorite' => $this->isFavorite(),
			'id_feed' => $this->feedId(),
			'tags' => $this->tags(true),
			'attributes' => $this->attributes(),
		];
	}

	/**
	 * @return array{array<string>,array<string>} Array of first tags to show, then array of remaining tags
	 */
	public function tagsFormattingHelper(): array {
		$firstTags = [];
		$remainingTags = [];

		if (FreshRSS_Context::hasUserConf() && in_array(FreshRSS_Context::userConf()->show_tags, ['b', 'f', 'h'], true)) {
			$maxTagsDisplayed = (int)FreshRSS_Context::userConf()->show_tags_max;
			$tags = $this->tags();
			if (!empty($tags)) {
				if ($maxTagsDisplayed > 0) {
					$firstTags = array_slice($tags, 0, $maxTagsDisplayed);
					$remainingTags = array_slice($tags, $maxTagsDisplayed);
				} else {
					$firstTags = $tags;
				}
			}
		}
		return [$firstTags,$remainingTags];
	}

	/**
	 * Integer format conversion for Google Reader API format
	 * @param string|int $dec Decimal number
	 * @return string 64-bit hexa http://code.google.com/p/google-reader-api/wiki/ItemId
	 */
	private static function dec2hex($dec): string {
		return PHP_INT_SIZE < 8 ? // 32-bit ?
			str_pad(gmp_strval(gmp_init($dec, 10), 16), 16, '0', STR_PAD_LEFT) :
			str_pad(dechex((int)($dec)), 16, '0', STR_PAD_LEFT);
	}

	/**
	 * Some clients (tested with News+) would fail if sending too long item content
	 * @var int
	 */
	public const API_MAX_COMPAT_CONTENT_LENGTH = 500000;

	/**
	 * N.B.: To avoid expensive lookups, ensure to set `$entry->_feed($feed)` before calling this function.
	 * @param string $mode Set to `'compat'` to use an alternative Unicode representation for problematic HTML special characters not decoded by some clients;
	 * 	set to `'freshrss'` for using FreshRSS additions for internal use (e.g. export/import).
	 * @param array<string> $labels List of labels associated to this entry.
	 * @return array<string,mixed> A representation of this entry in a format compatible with Google Reader API
	 */
	public function toGReader(string $mode = '', array $labels = []): array {

		$feed = $this->feed();
		$category = $feed == null ? null : $feed->category();

		$item = [
			'id' => 'tag:google.com,2005:reader/item/' . self::dec2hex($this->id()),
			'crawlTimeMsec' => substr($this->dateAdded(true, true), 0, -3),
			'timestampUsec' => '' . $this->dateAdded(true, true), //EasyRSS & Reeder
			'published' => $this->date(true),
			// 'updated' => $this->date(true),
			'title' => $this->title(),
			'canonical' => [
				['href' => htmlspecialchars_decode($this->link(), ENT_QUOTES)],
			],
			'alternate' => [
				[
					'href' => htmlspecialchars_decode($this->link(), ENT_QUOTES),
					'type' => 'text/html',
				],
			],
			'categories' => [
				'user/-/state/com.google/reading-list',
			],
			'origin' => [
				'streamId' => 'feed/' . $this->feedId,
			],
		];
		if ($mode === 'compat') {
			$item['title'] = escapeToUnicodeAlternative($this->title(), false);
			unset($item['alternate'][0]['type']);
			$item['summary'] = [
				'content' => mb_strcut($this->content(true), 0, self::API_MAX_COMPAT_CONTENT_LENGTH, 'UTF-8'),
			];
		} else {
			$item['content'] = [
				'content' => $this->content(false),
			];
		}
		if ($mode === 'freshrss') {
			$item['guid'] = $this->guid();
		}
		if ($category != null && $mode !== 'freshrss') {
			$item['categories'][] = 'user/-/label/' . htmlspecialchars_decode($category->name(), ENT_QUOTES);
		}
		if ($feed != null) {
			$item['origin']['htmlUrl'] = htmlspecialchars_decode($feed->website());
			$item['origin']['title'] = $feed->name();	//EasyRSS
			if ($mode === 'compat') {
				$item['origin']['title'] = escapeToUnicodeAlternative($feed->name(), true);
			} elseif ($mode === 'freshrss') {
				$item['origin']['feedUrl'] = htmlspecialchars_decode($feed->url());
			}
		}
		foreach ($this->enclosures() as $enclosure) {
			if (!empty($enclosure['url'])) {
				$media = [
						'href' => $enclosure['url'],
						'type' => $enclosure['type'] ?? $enclosure['medium'] ??
							(self::enclosureIsImage($enclosure) ? 'image' : ''),
					];
				if (!empty($enclosure['length'])) {
					$media['length'] = intval($enclosure['length']);
				}
				$item['enclosure'][] = $media;
			}
		}
		$author = $this->authors(true);
		$author = trim($author, '; ');
		if ($author != '') {
			if ($mode === 'compat') {
				$item['author'] = escapeToUnicodeAlternative($author, false);
			} else {
				$item['author'] = $author;
			}
		}
		if ($this->isRead()) {
			$item['categories'][] = 'user/-/state/com.google/read';
		} elseif ($mode === 'freshrss') {
			$item['categories'][] = 'user/-/state/com.google/unread';
		}
		if ($this->isFavorite()) {
			$item['categories'][] = 'user/-/state/com.google/starred';
		}
		foreach ($labels as $labelName) {
			$item['categories'][] = 'user/-/label/' . htmlspecialchars_decode($labelName, ENT_QUOTES);
		}
		foreach ($this->tags() as $tagName) {
			$item['categories'][] = htmlspecialchars_decode($tagName, ENT_QUOTES);
		}
		return $item;
	}
}
