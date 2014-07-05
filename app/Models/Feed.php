<?php

class FreshRSS_Feed extends Minz_Model {
	private $id = 0;
	private $url;
	private $category = 1;
	private $nbEntries = -1;
	private $nbNotRead = -1;
	private $entries = null;
	private $name = '';
	private $website = '';
	private $description = '';
	private $lastUpdate = 0;
	private $priority = 10;
	private $pathEntries = '';
	private $httpAuth = '';
	private $error = false;
	private $keep_history = -2;
	private $ttl = -2;
	private $hash = null;
	private $lockPath = '';

	public function __construct($url, $validate=true) {
		if ($validate) {
			$this->_url($url);
		} else {
			$this->url = $url;
		}
	}

	public function id() {
		return $this->id;
	}

	public function hash() {
		if ($this->hash === null) {
			$this->hash = hash('crc32b', Minz_Configuration::salt() . $this->url);
		}
		return $this->hash;
	}

	public function url() {
		return $this->url;
	}
	public function category() {
		return $this->category;
	}
	public function entries() {
		return $this->entries === null ? array() : $this->entries;
	}
	public function name() {
		return $this->name;
	}
	public function website() {
		return $this->website;
	}
	public function description() {
		return $this->description;
	}
	public function lastUpdate() {
		return $this->lastUpdate;
	}
	public function priority() {
		return $this->priority;
	}
	public function pathEntries() {
		return $this->pathEntries;
	}
	public function httpAuth($raw = true) {
		if ($raw) {
			return $this->httpAuth;
		} else {
			$pos_colon = strpos($this->httpAuth, ':');
			$user = substr($this->httpAuth, 0, $pos_colon);
			$pass = substr($this->httpAuth, $pos_colon + 1);

			return array(
				'username' => $user,
				'password' => $pass
			);
		}
	}
	public function inError() {
		return $this->error;
	}
	public function keepHistory() {
		return $this->keep_history;
	}
	public function ttl() {
		return $this->ttl;
	}
	public function nbEntries() {
		if ($this->nbEntries < 0) {
			$feedDAO = FreshRSS_Factory::createFeedDao();
			$this->nbEntries = $feedDAO->countEntries($this->id());
		}

		return $this->nbEntries;
	}
	public function nbNotRead() {
		if ($this->nbNotRead < 0) {
			$feedDAO = FreshRSS_Factory::createFeedDao();
			$this->nbNotRead = $feedDAO->countNotRead($this->id());
		}

		return $this->nbNotRead;
	}
	public function faviconPrepare() {
		$file = DATA_PATH . '/favicons/' . $this->hash() . '.txt';
		if (!file_exists($file)) {
			$t = $this->website;
			if ($t == '') {
				$t = $this->url;
			}
			file_put_contents($file, $t);
		}
	}
	public static function faviconDelete($hash) {
		$path = DATA_PATH . '/favicons/' . $hash;
		@unlink($path . '.ico');
		@unlink($path . '.txt');
	}
	public function favicon() {
		return Minz_Url::display('/f.php?' . $this->hash());
	}

	public function _id($value) {
		$this->id = $value;
	}
	public function _url($value, $validate=true) {
		$this->hash = null;
		if ($validate) {
			$value = checkUrl($value);
		}
		if (empty($value)) {
			throw new FreshRSS_BadUrl_Exception($value);
		}
		$this->url = $value;
	}
	public function _category($value) {
		$value = intval($value);
		$this->category = $value >= 0 ? $value : 0;
	}
	public function _name($value) {
		$this->name = $value === null ? '' : $value;
	}
	public function _website($value, $validate=true) {
		if ($validate) {
			$value = checkUrl($value);
		}
		if (empty($value)) {
			$value = '';
		}
		$this->website = $value;
	}
	public function _description($value) {
		$this->description = $value === null ? '' : $value;
	}
	public function _lastUpdate($value) {
		$this->lastUpdate = $value;
	}
	public function _priority($value) {
		$value = intval($value);
		$this->priority = $value >= 0 ? $value : 10;
	}
	public function _pathEntries($value) {
		$this->pathEntries = $value;
	}
	public function _httpAuth($value) {
		$this->httpAuth = $value;
	}
	public function _error($value) {
		$this->error = (bool)$value;
	}
	public function _keepHistory($value) {
		$value = intval($value);
		$value = min($value, 1000000);
		$value = max($value, -2);
		$this->keep_history = $value;
	}
	public function _ttl($value) {
		$value = intval($value);
		$value = min($value, 100000000);
		$value = max($value, -2);
		$this->ttl = $value;
	}
	public function _nbNotRead($value) {
		$this->nbNotRead = intval($value);
	}
	public function _nbEntries($value) {
		$this->nbEntries = intval($value);
	}

	public function load($loadDetails = false) {
		if ($this->url !== null) {
			if (CACHE_PATH === false) {
				throw new Minz_FileNotExistException(
					'CACHE_PATH',
					Minz_Exception::ERROR
				);
			} else {
				$url = htmlspecialchars_decode($this->url, ENT_QUOTES);
				if ($this->httpAuth != '') {
					$url = preg_replace('#((.+)://)(.+)#', '${1}' . $this->httpAuth . '@${3}', $url);
				}
				$feed = customSimplePie();
				$feed->set_feed_url($url);
				if (!$loadDetails) {	//Only activates auto-discovery when adding a new feed
					$feed->set_autodiscovery_level(SIMPLEPIE_LOCATOR_NONE);
				}
				$mtime = $feed->init();

				if ((!$mtime) || $feed->error()) {
					throw new FreshRSS_Feed_Exception($feed->error() . ' [' . $url . ']');
				}

				if ($loadDetails) {
					// si on a utilisé l'auto-discover, notre url va avoir changé
					$subscribe_url = $feed->subscribe_url(false);

					$title = strtr(html_only_entity_decode($feed->get_title()), array('<' => '&lt;', '>' => '&gt;', '"' => '&quot;'));	//HTML to HTML-PRE	//ENT_COMPAT except &
					$this->_name($title == '' ? $this->url : $title);

					$this->_website(html_only_entity_decode($feed->get_link()));
					$this->_description(html_only_entity_decode($feed->get_description()));
				} else {
					//The case of HTTP 301 Moved Permanently
					$subscribe_url = $feed->subscribe_url(true);
				}

				if ($subscribe_url !== null && $subscribe_url !== $this->url) {
					if ($this->httpAuth != '') {
						// on enlève les id si authentification HTTP
						$subscribe_url = preg_replace('#((.+)://)((.+)@)(.+)#', '${1}${5}', $subscribe_url);
					}
					$this->_url($subscribe_url);
				}

				if (($mtime === true) ||($mtime > $this->lastUpdate)) {
					syslog(LOG_DEBUG, 'FreshRSS no cache ' . $mtime . ' > ' . $this->lastUpdate . ' for ' . $subscribe_url);
					$this->loadEntries($feed);	// et on charge les articles du flux
				} else {
					syslog(LOG_DEBUG, 'FreshRSS use cache for ' . $subscribe_url);
					$this->entries = array();
				}

				$feed->__destruct();	//http://simplepie.org/wiki/faq/i_m_getting_memory_leaks
				unset($feed);
			}
		}
	}

	private function loadEntries($feed) {
		$entries = array();

		foreach ($feed->get_items() as $item) {
			$title = html_only_entity_decode(strip_tags($item->get_title()));
			$author = $item->get_author();
			$link = $item->get_permalink();
			$date = @strtotime($item->get_date());

			// gestion des tags (catégorie == tag)
			$tags_tmp = $item->get_categories();
			$tags = array();
			if ($tags_tmp !== null) {
				foreach ($tags_tmp as $tag) {
					$tags[] = html_only_entity_decode($tag->get_label());
				}
			}

			$content = html_only_entity_decode($item->get_content());

			$elinks = array();
			foreach ($item->get_enclosures() as $enclosure) {
				$elink = $enclosure->get_link();
				if (empty($elinks[$elink])) {
					$elinks[$elink] = '1';
					$mime = strtolower($enclosure->get_type());
					if (strpos($mime, 'image/') === 0) {
						$content .= '<br /><img src="' . $elink . '" alt="" />';
					} elseif (strpos($mime, 'audio/') === 0) {
						$content .= '<br /><audio src="' . $elink . '" controls="controls" />';
					} elseif (strpos($mime, 'video/') === 0) {
						$content .= '<br /><video src="' . $elink . '" controls="controls" />';
					}
				}
			}

			$entry = new FreshRSS_Entry(
				$this->id(),
				$item->get_id(),
				$title === null ? '' : $title,
				$author === null ? '' : html_only_entity_decode($author->name),
				$content === null ? '' : $content,
				$link === null ? '' : $link,
				$date ? $date : time()
			);
			$entry->_tags($tags);
			// permet de récupérer le contenu des flux tronqués
			$entry->loadCompleteContent($this->pathEntries());

			$entries[] = $entry;
			unset($item);
		}

		$this->entries = $entries;
	}

	function lock() {
		$this->lockPath = TMP_PATH . '/' . $this->hash() . '.freshrss.lock';
		if (file_exists($this->lockPath) && ((time() - @filemtime($this->lockPath)) > 3600)) {
			@unlink($this->lockPath);
		}
		if (($handle = @fopen($this->lockPath, 'x')) === false) {
			return false;
		}
		//register_shutdown_function('unlink', $this->lockPath);
		@fclose($handle);
		return true;
	}

	function unlock() {
		@unlink($this->lockPath);
	}
}
