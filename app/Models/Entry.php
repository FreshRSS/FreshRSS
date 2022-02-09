<?php

class FreshRSS_Entry extends Minz_Model {
	const STATE_READ = 1;
	const STATE_NOT_READ = 2;
	const STATE_ALL = 3;
	const STATE_FAVORITE = 4;
	const STATE_NOT_FAVORITE = 8;

	/**
	 * @var string
	 */
	private $id = '0';

	/**
	 * @var string
	 */
	private $guid;

	private $title;
	private $authors;
	private $content;
	private $link;
	private $date;
	private $date_added = 0; //In microseconds
	/**
	 * @var string
	 */
	private $hash = '';
	/**
	 * @var bool|null
	 */
	private $is_read;
	private $is_favorite;

	/**
	 * @var int
	 */
	private $feedId;

	/**
	 * @var FreshRSS_Feed|null
	 */
	private $feed;

	private $tags;

	public function __construct(int $feedId = 0, string $guid = '', string $title = '', string $authors = '', string $content = '',
			string $link = '', $pubdate = 0, bool $is_read = false, bool $is_favorite = false, string $tags = '') {
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

	public function id(): string {
		return $this->id;
	}
	public function guid(): string {
		return $this->guid;
	}
	public function title(): string {
		return $this->title == '' ? $this->guid() : $this->title;
	}
	public function author(): string {
		//Deprecated
		return $this->authors(true);
	}
	public function authors(bool $asString = false) {
		if ($asString) {
			return $this->authors == null ? '' : ';' . implode('; ', $this->authors);
		} else {
			return $this->authors;
		}
	}
	public function content(): string {
		return $this->content;
	}

	public function enclosures(bool $searchBodyImages = false): array {
		$results = [];
		try {
			$searchEnclosures = strpos($this->content, '<p class="enclosure-content') !== false;
			$searchBodyImages &= (stripos($this->content, '<img') !== false);
			$xpath = null;
			if ($searchEnclosures || $searchBodyImages) {
				$dom = new DOMDocument();
				$dom->loadHTML('<?xml version="1.0" encoding="UTF-8" ?>' . $this->content, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);
				$xpath = new DOMXpath($dom);
			}
			if ($searchEnclosures) {
				$enclosures = $xpath->query('//div[@class="enclosure"]/p[@class="enclosure-content"]/*[@src]');
				foreach ($enclosures as $enclosure) {
					$results[] = [
						'url' => $enclosure->getAttribute('src'),
						'type' => $enclosure->getAttribute('data-type'),
						'length' => $enclosure->getAttribute('data-length'),
					];
				}
			}
			if ($searchBodyImages) {
				$images = $xpath->query('//img');
				foreach ($images as $img) {
					$src = $img->getAttribute('src');
					if ($src == null) {
						$src = $img->getAttribute('data-src');
					}
					if ($src != null) {
						$results[] = [
							'url' => $src,
							'alt' => $img->getAttribute('alt'),
						];
					}
				}
			}
			return $results;
		} catch (Exception $ex) {
			return $results;
		}
	}


	/**
	 * @return array<string,string>|null
	 */
	public function thumbnail() {
		foreach ($this->enclosures(true) as $enclosure) {
			if (!empty($enclosure['url']) && empty($enclosure['type'])) {
				return $enclosure;
			}
		}
		return null;
	}

	public function link(): string {
		return $this->link;
	}
	public function date(bool $raw = false) {
		if ($raw) {
			return $this->date;
		}
		return timestamptodate($this->date);
	}
	public function machineReadableDate(): string {
		return @date (DATE_ATOM, $this->date);
	}
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
	public function isRead() {
		return $this->is_read;
	}
	public function isFavorite() {
		return $this->is_favorite;
	}
	public function feed($object = false) {
		if ($object) {
			if ($this->feed == null) {
				$feedDAO = FreshRSS_Factory::createFeedDao();
				$this->feed = $feedDAO->searchById($this->feedId);
			}
			return $this->feed;
		} else {
			return $this->feedId;
		}
	}
	public function tags($asString = false) {
		if ($asString) {
			return $this->tags == null ? '' : '#' . implode(' #', $this->tags);
		} else {
			return $this->tags;
		}
	}

	public function hash(): string {
		if ($this->hash == '') {
			//Do not include $this->date because it may be automatically generated when lacking
			$this->hash = md5($this->link . $this->title . $this->authors(true) . $this->content . $this->tags(true));
		}
		return $this->hash;
	}

	public function _hash(string $value) {
		$value = trim($value);
		if (ctype_xdigit($value)) {
			$this->hash = substr($value, 0, 32);
		}
		return $this->hash;
	}

	public function _id($value) {
		$this->id = $value;
		if ($this->date_added == 0) {
			$this->date_added = $value;
		}
	}
	public function _guid(string $value) {
		if ($value == '') {
			$value = $this->link;
			if ($value == '') {
				$value = $this->hash();
			}
		}
		$this->guid = $value;
	}
	public function _title(string $value) {
		$this->hash = '';
		$this->title = trim($value);
	}
	public function _author(string $value) {
		//Deprecated
		$this->_authors($value);
	}
	public function _authors($value) {
		$this->hash = '';
		if (!is_array($value)) {
			if (strpos($value, ';') !== false) {
				$value = preg_split('/\s*[;]\s*/', $value, -1, PREG_SPLIT_NO_EMPTY);
			} else {
				$value = preg_split('/\s*[,]\s*/', $value, -1, PREG_SPLIT_NO_EMPTY);
			}
		}
		$this->authors = $value;
	}
	public function _content(string $value) {
		$this->hash = '';
		$this->content = $value;
	}
	public function _link(string $value) {
		$this->hash = '';
		$this->link = $value;
	}
	public function _date($value) {
		$this->hash = '';
		$value = intval($value);
		$this->date = $value > 1 ? $value : time();
	}
	public function _dateAdded($value, bool $microsecond = false) {
		if ($microsecond) {
			$this->date_added = $value;
		} else {
			$this->date_added = $value * 1000000;
		}
	}
	public function _isRead($value) {
		$this->is_read = $value === null ? null : (bool)$value;
	}
	public function _isFavorite($value) {
		$this->is_favorite = $value;
	}
	public function _feed($value) {
		if ($value != null) {
			$this->feed = $value;
			$this->feedId = $this->feed->id();
		}
	}
	private function _feedId($value) {
		$this->feed = null;
		$this->feedId = intval($value);
	}
	public function _tags($value) {
		$this->hash = '';
		if (!is_array($value)) {
			$value = preg_split('/\s*[#,]\s*/', $value, -1, PREG_SPLIT_NO_EMPTY);
		}
		$this->tags = $value;
	}

	public function matches(FreshRSS_BooleanSearch $booleanSearch): bool {
		if (count($booleanSearch->searches()) <= 0) {
			return true;
		}
		foreach ($booleanSearch->searches() as $filter) {
			$ok = true;
			if ($filter->getMinDate()) {
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
				$ok &= in_array($this->feedId, $filter->getFeedIds());
			}
			if ($ok && $filter->getNotFeedIds()) {
				$ok &= !in_array($this->feedId, $filter->getFeedIds());
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
		return false;
	}

	public function applyFilterActions(array $titlesAsRead = []) {
		if ($this->feed != null) {
			if ($this->feed->attributes('read_upon_reception') ||
				($this->feed->attributes('read_upon_reception') === null && FreshRSS_Context::$user_conf->mark_when['reception'])) {
				$this->_isRead(true);
			}
			if (isset($titlesAsRead[$this->title()])) {
				Minz_Log::debug('Mark title as read: ' . $this->title());
				$this->_isRead(true);
			}
			foreach ($this->feed->filterActions() as $filterAction) {
				if ($this->matches($filterAction->booleanSearch())) {
					foreach ($filterAction->actions() as $action) {
						switch ($action) {
							case 'read':
								$this->_isRead(true);
								break;
							case 'star':
								$this->_isFavorite(true);
								break;
							case 'label':
								//TODO: Implement more actions
								break;
						}
					}
				}
			}
		}
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
	 */
	public static function getContentByParsing(string $url, string $path, array $attributes = [], int $maxRedirs = 3): string {
		$html = getHtml($url, $attributes);
		if (strlen($html) > 0) {
			require_once(LIB_PATH . '/lib_phpQuery.php');
			/**
			 * @var phpQueryObject @doc
			 */
			$doc = phpQuery::newDocument($html);

			if ($maxRedirs > 0) {
				//Follow any HTML redirection
				/**
				 * @var phpQueryObject @metas
				 */
				$metas = $doc->find('meta[http-equiv][content]');
				foreach ($metas as $meta) {
					if (strtolower(trim($meta->getAttribute('http-equiv'))) === 'refresh') {
						$refresh = preg_replace('/^[0-9.; ]*\s*(url\s*=)?\s*/i', '', trim($meta->getAttribute('content')));
						$refresh = SimplePie_Misc::absolutize_url($refresh, $url);
						if ($refresh != false && $refresh !== $url) {
							phpQuery::unloadDocuments();
							return self::getContentByParsing($refresh, $path, $attributes, $maxRedirs - 1);
						}
					}
				}
			}

			/**
			 * @var phpQueryObject @content
			 */
			$content = $doc->find($path);
			$html = trim(sanitizeHTML($content->__toString(), $url));
			phpQuery::unloadDocuments();
			return $html;
		} else {
			throw new Exception();
		}
	}

	public function loadCompleteContent(bool $force = false): bool {
		// Gestion du contenu
		// Trying to fetch full article content even when feeds do not propose it
		$feed = $this->feed(true);
		if ($feed != null && trim($feed->pathEntries()) != '') {
			$entryDAO = FreshRSS_Factory::createEntryDao();
			$entry = $force ? null : $entryDAO->searchByGuid($this->feedId, $this->guid);

			if ($entry) {
				// l’article existe déjà en BDD, en se contente de recharger ce contenu
				$this->content = $entry->content();
			} else {
				try {
					// l’article n’est pas en BDD, on va le chercher sur le site
					$fullContent = self::getContentByParsing(
						htmlspecialchars_decode($this->link(), ENT_QUOTES),
						$feed->pathEntries(),
						$feed->attributes()
					);
					if ('' !== $fullContent) {
						$fullContent = "<!-- FULLCONTENT start //-->{$fullContent}<!-- FULLCONTENT end //-->";
						$originalContent = preg_replace('#<!-- FULLCONTENT start //-->.*<!-- FULLCONTENT end //-->#s', '', $this->content());
						switch ($feed->attributes('content_action')) {
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

	public function toArray(): array {
		return array(
			'id' => $this->id(),
			'guid' => $this->guid(),
			'title' => $this->title(),
			'author' => $this->authors(true),
			'content' => $this->content(),
			'link' => $this->link(),
			'date' => $this->date(true),
			'hash' => $this->hash(),
			'is_read' => $this->isRead(),
			'is_favorite' => $this->isFavorite(),
			'id_feed' => $this->feed(),
			'tags' => $this->tags(true),
		);
	}
}
