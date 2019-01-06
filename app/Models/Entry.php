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
		return $this->title;
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
	public function link() {
		return $this->link;
	}
	public function date($raw = false) {
		if ($raw) {
			return $this->date;
		} else {
			return timestamptodate($this->date);
		}
	}
	public function dateAdded($raw = false) {
		$date = intval(substr($this->id, 0, -6));
		if ($raw) {
			return $date;
		} else {
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
		$this->title = $value;
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
		$this->feedId = $value;
	}
	public function _tags($value) {
		$this->hash = null;
		if (!is_array($value)) {
			$value = preg_split('/\s*[#,]\s*/', $value, -1, PREG_SPLIT_NO_EMPTY);
		}
		$this->tags = $value;
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

	private static function get_content_by_parsing($url, $path, $attributes = array()) {
		require_once(LIB_PATH . '/lib_phpQuery.php');
		$system_conf = Minz_Configuration::get('system');
		$limits = $system_conf->limits;
		$feed_timeout = empty($attributes['timeout']) ? 0 : intval($attributes['timeout']);

		if ($system_conf->simplepie_syslog_enabled) {
			prepareSyslog();
			syslog(LOG_INFO, 'FreshRSS GET ' . SimplePie_Misc::url_remove_credentials($url));
		}

		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_REFERER => SimplePie_Misc::url_remove_credentials($url),
			CURLOPT_HTTPHEADER => array('Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'),
			CURLOPT_USERAGENT => FRESHRSS_USERAGENT,
			CURLOPT_CONNECTTIMEOUT => $feed_timeout > 0 ? $feed_timeout : $limits['timeout'],
			CURLOPT_TIMEOUT => $feed_timeout > 0 ? $feed_timeout : $limits['timeout'],
			//CURLOPT_FAILONERROR => true;
			CURLOPT_MAXREDIRS => 4,
			CURLOPT_RETURNTRANSFER => true,
		));
		if (version_compare(PHP_VERSION, '5.6.0') >= 0 || ini_get('open_basedir') == '') {
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);	//Keep option separated for open_basedir PHP bug 65646
		}
		if (defined('CURLOPT_ENCODING')) {
			curl_setopt($ch, CURLOPT_ENCODING, '');	//Enable all encodings
		}
		curl_setopt_array($ch, $system_conf->curl_options);
		if (isset($attributes['ssl_verify'])) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $attributes['ssl_verify'] ? 2 : 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $attributes['ssl_verify'] ? true : false);
		}
		$html = curl_exec($ch);
		$c_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$c_error = curl_error($ch);
		curl_close($ch);

		if ($c_status != 200 || $c_error != '') {
			Minz_Log::warning('Error fetching content: HTTP code ' . $c_status . ': ' . $c_error . ' ' . $url);
		}

		if ($html) {
			$doc = phpQuery::newDocument($html);
			$content = $doc->find($path);

			foreach (pq('img[data-src]') as $img) {
				$imgP = pq($img);
				$dataSrc = $imgP->attr('data-src');
				if (strlen($dataSrc) > 4) {
					$imgP->attr('src', $dataSrc);
					$imgP->removeAttr('data-src');
				}
			}

			return trim(sanitizeHTML($content->__toString(), $url));
		} else {
			throw new Exception();
		}
	}

	public function loadCompleteContent() {
		// Gestion du contenu
		// On cherche à récupérer les articles en entier... même si le flux ne le propose pas
		$feed = $this->feed(true);
		if ($feed != null && trim($feed->pathEntries()) != '') {
			$entryDAO = FreshRSS_Factory::createEntryDao();
			$entry = $entryDAO->searchByGuid($this->feedId, $this->guid);

			if ($entry) {
				// l'article existe déjà en BDD, en se contente de recharger ce contenu
				$this->content = $entry->content();
			} else {
				try {
					// l'article n'est pas en BDD, on va le chercher sur le site
					$fullContent = self::get_content_by_parsing(
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
