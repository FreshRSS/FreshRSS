<?php

class FreshRSS_Entry extends Minz_Model {
	const STATE_READ = 1;
	const STATE_NOT_READ = 2;
	const STATE_ALL = 3;
	const STATE_FAVORITE = 4;
	const STATE_NOT_FAVORITE = 8;

	private $id = 0;
	private $guid;
	private $title;
	private $authors;
	private $content;
	private $link;
	private $date;
	private $date_added = 0; //In microseconds
	private $hash = null;
	private $is_read;	//Nullable boolean
	private $is_favorite;
	private $feedId;
	private $feed;
	private $tags;

	public function __construct($feedId = '', $guid = '', $title = '', $authors = '', $content = '',
	                            $link = '', $pubdate = 0, $is_read = false, $is_favorite = false, $tags = '') {
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

	public function id() {
		return $this->id;
	}
	public function guid() {
		return $this->guid;
	}
	public function title() {
		return $this->title == '' ? $this->guid() : $this->title;
	}
	public function author() {
		//Deprecated
		return $this->authors(true);
	}
	public function authors($asString = false) {
		if ($asString) {
			return $this->authors == null ? '' : ';' . implode('; ', $this->authors);
		} else {
			return $this->authors;
		}
	}
	public function content() {
		return $this->content;
	}
	public function enclosures() {
		$results = [];
		try {
			if (strpos($this->content, '<p class="enclosure-content') !== false) {
				$dom = new DOMDocument();
				$dom->loadHTML($this->content, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);
				$xpath = new DOMXpath($dom);
				$enclosures = $xpath->query('//div[@class="enclosure"]/p[@class="enclosure-content"]/*[@src]');
				foreach ($enclosures as $enclosure) {
					$results[] = [
						'url' => $enclosure->getAttribute('src'),
						'type' => $enclosure->getAttribute('data-type'),
						'length' => $enclosure->getAttribute('data-length'),
					];
				}
			}
			return $results;
		} catch (Exception $ex) {
			return $results;
		}
	}

	public function link() {
		return $this->link;
	}
	public function date($raw = false) {
		if ($raw) {
			return $this->date;
		}
		return timestamptodate($this->date);
	}
	public function machineReadableDate() {
		return @date (DATE_ATOM, $this->date);
	}
	public function dateAdded($raw = false, $microsecond = false) {
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

	public function hash() {
		if ($this->hash === null) {
			//Do not include $this->date because it may be automatically generated when lacking
			$this->hash = md5($this->link . $this->title . $this->authors(true) . $this->content . $this->tags(true));
		}
		return $this->hash;
	}

	public function _hash($value) {
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
	public function _guid($value) {
		if ($value == '') {
			$value = $this->link;
			if ($value == '') {
				$value = $this->hash();
			}
		}
		$this->guid = $value;
	}
	public function _title($value) {
		$this->hash = null;
		$this->title = trim($value);
	}
	public function _author($value) {
		//Deprecated
		$this->_authors($value);
	}
	public function _authors($value) {
		$this->hash = null;
		if (!is_array($value)) {
			if (strpos($value, ';') !== false) {
				$value = preg_split('/\s*[;]\s*/', $value, -1, PREG_SPLIT_NO_EMPTY);
			} else {
				$value = preg_split('/\s*[,]\s*/', $value, -1, PREG_SPLIT_NO_EMPTY);
			}
		}
		$this->authors = $value;
	}
	public function _content($value) {
		$this->hash = null;
		$this->content = $value;
	}
	public function _link($value) {
		$this->hash = null;
		$this->link = $value;
	}
	public function _date($value) {
		$this->hash = null;
		$value = intval($value);
		$this->date = $value > 1 ? $value : time();
	}
	public function _dateAdded($value, $microsecond = false) {
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
		$this->hash = null;
		if (!is_array($value)) {
			$value = preg_split('/\s*[#,]\s*/', $value, -1, PREG_SPLIT_NO_EMPTY);
		}
		$this->tags = $value;
	}

	public function matches($booleanSearch) {
		if (!$booleanSearch || count($booleanSearch->searches()) <= 0) {
			return true;
		}
		foreach ($booleanSearch->searches() as $filter) {
			$ok = true;
			if ($ok && $filter->getMinPubdate()) {
				$ok &= $this->date >= $filter->getMinPubdate();
			}
			if ($ok && $filter->getMaxPubdate()) {
				$ok &= $this->date <= $filter->getMaxPubdate();
			}
			if ($ok && $filter->getMinDate()) {
				$ok &= strnatcmp($this->id, $filter->getMinDate() . '000000') >= 0;
			}
			if ($ok && $filter->getMaxDate()) {
				$ok &= strnatcmp($this->id, $filter->getMaxDate() . '000000') <= 0;
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

	public function applyFilterActions() {
		if ($this->feed != null) {
			if ($this->feed->attributes('read_upon_reception') ||
				($this->feed->attributes('read_upon_reception') === null && FreshRSS_Context::$user_conf->mark_when['reception'])) {
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
								$this->_is_favorite(true);
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

	public function isDay($day, $today) {
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

	public static function getContentByParsing($url, $path, $attributes = array(), $maxRedirs = 3) {
		$system_conf = Minz_Configuration::get('system');
		$limits = $system_conf->limits;
		$feed_timeout = empty($attributes['timeout']) ? 0 : intval($attributes['timeout']);

		if ($system_conf->simplepie_syslog_enabled) {
			syslog(LOG_INFO, 'FreshRSS GET ' . SimplePie_Misc::url_remove_credentials($url));
		}

		$ch = curl_init();
		curl_setopt_array($ch, [
			CURLOPT_URL => $url,
			CURLOPT_REFERER => SimplePie_Misc::url_remove_credentials($url),
			CURLOPT_HTTPHEADER => array('Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'),
			CURLOPT_USERAGENT => FRESHRSS_USERAGENT,
			CURLOPT_CONNECTTIMEOUT => $feed_timeout > 0 ? $feed_timeout : $limits['timeout'],
			CURLOPT_TIMEOUT => $feed_timeout > 0 ? $feed_timeout : $limits['timeout'],
			//CURLOPT_FAILONERROR => true;
			CURLOPT_MAXREDIRS => 4,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ENCODING => '',	//Enable all encodings
		]);

		if (is_array($attributes['curl_params']) && !empty($attributes['curl_params']) ){
			Minz_Log::warning('Attributes have been read');
			foreach ( $attributes['curl_params'] as $co => $v){
				curl_setopt($ch, $co,$v);
			}
		}

		curl_setopt_array($ch, $system_conf->curl_options);
		if (isset($attributes['ssl_verify'])) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $attributes['ssl_verify'] ? 2 : 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $attributes['ssl_verify'] ? true : false);
			if (!$attributes['ssl_verify']) {
				curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
			}
		}
		$html = curl_exec($ch);
		$c_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$c_error = curl_error($ch);
		curl_close($ch);

		if ($c_status != 200 || $c_error != '') {
			Minz_Log::warning('Error fetching content: HTTP code ' . $c_status . ': ' . $c_error . ' ' . $url);
		}

		if ($html) {
			require_once(LIB_PATH . '/lib_phpQuery.php');
			$doc = phpQuery::newDocument($html);

			if ($maxRedirs > 0) {
				//Follow any HTML redirection
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

			$content = $doc->find($path);
			$html = trim(sanitizeHTML($content->__toString(), $url));
			phpQuery::unloadDocuments();
			return $html;
		} else {
			throw new Exception();
		}
	}

	public function loadCompleteContent($force = false) {
		// Gestion du contenu
		// On cherche à récupérer les articles en entier... même si le flux ne le propose pas
		$feed = $this->feed(true);
		if ($feed != null && trim($feed->pathEntries()) != '') {
			$entryDAO = FreshRSS_Factory::createEntryDao();
			$entry = $entryDAO->searchByGuid($this->feedId, $this->guid);

			if ($entry && !$force) {
				// l'article existe déjà en BDD, en se contente de recharger ce contenu
				$this->content = $entry->content();
			} else {
				try {
					// l'article n'est pas en BDD, on va le chercher sur le site
					$fullContent = self::getContentByParsing(
						htmlspecialchars_decode($this->link(), ENT_QUOTES),
						$feed->pathEntries(),
						$feed->attributes()
					);
					if ($fullContent != '') {
						$this->content = $fullContent;
					}
				} catch (Exception $e) {
					// rien à faire, on garde l'ancien contenu(requête a échoué)
					Minz_Log::warning($e->getMessage());
				}
			}
		}
	}

	public function toArray() {
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
