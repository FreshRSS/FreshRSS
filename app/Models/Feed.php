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
	private $hubUrl = '';
	private $selfUrl = '';

	public function __construct($url, $validate=true) {
		if ($validate) {
			$this->_url($url);
		} else {
			$this->url = $url;
		}
	}

	public static function example() {
		$f = new FreshRSS_Feed('http://example.net/', false);
		$f->faviconPrepare();
		return $f;
	}

	public function id() {
		return $this->id;
	}

	public function hash() {
		if ($this->hash === null) {
			$salt = FreshRSS_Context::$system_conf->salt;
			$this->hash = hash('crc32b', $salt . $this->url);
		}
		return $this->hash;
	}

	public function url() {
		return $this->url;
	}
	public function selfUrl() {
		return $this->selfUrl;
	}
	public function hubUrl() {
		return $this->hubUrl;
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
	// public function ttlExpire() {
		// $ttl = $this->ttl;
		// if ($ttl == -2) {	//Default
			// $ttl = FreshRSS_Context::$user_conf->ttl_default;
		// }
		// if ($ttl == -1) {	//Never
			// $ttl = 64000000;	//~2 years. Good enough for PubSubHubbub logic
		// }
		// return $this->lastUpdate + $ttl;
	// }
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
				if (substr($url, -11) === '#force_feed') {
					$feed->force_feed(true);
					$url = substr($url, 0, -11);
				}
				$feed->set_feed_url($url);
				if (!$loadDetails) {	//Only activates auto-discovery when adding a new feed
					$feed->set_autodiscovery_level(SIMPLEPIE_LOCATOR_NONE);
				}
				$mtime = $feed->init();

				if ((!$mtime) || $feed->error()) {
					$errorMessage = $feed->error();
					throw new FreshRSS_Feed_Exception(($errorMessage == '' ? 'Feed error' : $errorMessage) . ' [' . $url . ']');
				}

				$links = $feed->get_links('self');
				$this->selfUrl = isset($links[0]) ? $links[0] : null;
				$links = $feed->get_links('hub');
				$this->hubUrl = isset($links[0]) ? $links[0] : null;

				if ($loadDetails) {
					// si on a utilisé l'auto-discover, notre url va avoir changé
					$subscribe_url = $feed->subscribe_url(false);

					$title = strtr(html_only_entity_decode($feed->get_title()), array('<' => '&lt;', '>' => '&gt;', '"' => '&quot;'));	//HTML to HTML-PRE	//ENT_COMPAT except &
					$this->_name($title == '' ? $url : $title);

					$this->_website(html_only_entity_decode($feed->get_link()));
					$this->_description(html_only_entity_decode($feed->get_description()));
				} else {
					//The case of HTTP 301 Moved Permanently
					$subscribe_url = $feed->subscribe_url(true);
				}

				$clean_url = SimplePie_Misc::url_remove_credentials($subscribe_url);
				if ($subscribe_url !== null && $subscribe_url !== $url) {
					$this->_url($clean_url);
				}

				if (($mtime === true) || ($mtime > $this->lastUpdate)) {
					//Minz_Log::debug('FreshRSS no cache ' . $mtime . ' > ' . $this->lastUpdate . ' for ' . $clean_url);
					$this->loadEntries($feed);	// et on charge les articles du flux
				} else {
					//Minz_Log::debug('FreshRSS use cache for ' . $clean_url);
					$this->entries = array();
				}

				$feed->__destruct();	//http://simplepie.org/wiki/faq/i_m_getting_memory_leaks
				unset($feed);
			}
		}
	}

	public function loadEntries($feed) {
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
						$content .= '<br /><img lazyload="" postpone="" src="' . $elink . '" alt="" />';
					} elseif (strpos($mime, 'audio/') === 0) {
						$content .= '<br /><audio lazyload="" postpone="" preload="none" src="' . $elink . '" controls="controls" />';
					} elseif (strpos($mime, 'video/') === 0) {
						$content .= '<br /><video lazyload="" postpone="" preload="none" src="' . $elink . '" controls="controls" />';
					} else {
						unset($elinks[$elink]);
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

	//<PubSubHubbub>

	function pubSubHubbubEnabled() {
		$url = $this->selfUrl ? $this->selfUrl : $this->url;
		$hubFilename = PSHB_PATH . '/feeds/' . base64url_encode($url) . '/!hub.json';
		if ($hubFile = @file_get_contents($hubFilename)) {
			$hubJson = json_decode($hubFile, true);
			if ($hubJson && empty($hubJson['error']) &&
				(empty($hubJson['lease_end']) || $hubJson['lease_end'] > time())) {
				return true;
			}
		}
		return false;
	}

	function pubSubHubbubError($error = true) {
		$url = $this->selfUrl ? $this->selfUrl : $this->url;
		$hubFilename = PSHB_PATH . '/feeds/' . base64url_encode($url) . '/!hub.json';
		$hubFile = @file_get_contents($hubFilename);
		$hubJson = $hubFile ? json_decode($hubFile, true) : array();
		if (!isset($hubJson['error']) || $hubJson['error'] !== (bool)$error) {
			$hubJson['error'] = (bool)$error;
			file_put_contents($hubFilename, json_encode($hubJson));
			file_put_contents(USERS_PATH . '/_/log_pshb.txt', date('c') . "\t"
				. 'Set error to ' . ($error ? 1 : 0) . ' for ' . $url . "\n", FILE_APPEND);
		}
		return false;
	}

	function pubSubHubbubPrepare() {
		$key = '';
		if (FreshRSS_Context::$system_conf->base_url && $this->hubUrl && $this->selfUrl && @is_dir(PSHB_PATH)) {
			$path = PSHB_PATH . '/feeds/' . base64url_encode($this->selfUrl);
			$hubFilename = $path . '/!hub.json';
			if ($hubFile = @file_get_contents($hubFilename)) {
				$hubJson = json_decode($hubFile, true);
				if (!$hubJson || empty($hubJson['key']) || !ctype_xdigit($hubJson['key'])) {
					$text = 'Invalid JSON for PubSubHubbub: ' . $this->url;
					Minz_Log::warning($text);
					file_put_contents(USERS_PATH . '/_/log_pshb.txt', date('c') . "\t" . $text . "\n", FILE_APPEND);
					return false;
				}
				if ((!empty($hubJson['lease_end'])) && ($hubJson['lease_end'] < (time() + (3600 * 23)))) {	//TODO: Make a better policy
					$text = 'PubSubHubbub lease ends at '
						. date('c', empty($hubJson['lease_end']) ? time() : $hubJson['lease_end'])
						. ' and needs renewal: ' . $this->url;
					Minz_Log::warning($text);
					file_put_contents(USERS_PATH . '/_/log_pshb.txt', date('c') . "\t" . $text . "\n", FILE_APPEND);
					$key = $hubJson['key'];	//To renew our lease
				} elseif (((!empty($hubJson['error'])) || empty($hubJson['lease_end'])) &&
					(empty($hubJson['lease_start']) || $hubJson['lease_start'] < time() - (3600 * 23))) {	//Do not renew too often
					$key = $hubJson['key'];	//To renew our lease
				}
			} else {
				@mkdir($path, 0777, true);
				$key = sha1($path . FreshRSS_Context::$system_conf->salt . uniqid(mt_rand(), true));
				$hubJson = array(
					'hub' => $this->hubUrl,
					'key' => $key,
				);
				file_put_contents($hubFilename, json_encode($hubJson));
				@mkdir(PSHB_PATH . '/keys/');
				file_put_contents(PSHB_PATH . '/keys/' . $key . '.txt', base64url_encode($this->selfUrl));
				$text = 'PubSubHubbub prepared for ' . $this->url;
				Minz_Log::debug($text);
				file_put_contents(USERS_PATH . '/_/log_pshb.txt', date('c') . "\t" . $text . "\n", FILE_APPEND);
			}
			$currentUser = Minz_Session::param('currentUser');
			if (ctype_alnum($currentUser) && !file_exists($path . '/' . $currentUser . '.txt')) {
				touch($path . '/' . $currentUser . '.txt');
			}
		}
		return $key;
	}

	//Parameter true to subscribe, false to unsubscribe.
	function pubSubHubbubSubscribe($state) {
		if (FreshRSS_Context::$system_conf->base_url && $this->hubUrl && $this->selfUrl) {
			$hubFilename = PSHB_PATH . '/feeds/' . base64url_encode($this->selfUrl) . '/!hub.json';
			$hubFile = @file_get_contents($hubFilename);
			if ($hubFile === false) {
				Minz_Log::warning('JSON not found for PubSubHubbub: ' . $this->url);
				return false;
			}
			$hubJson = json_decode($hubFile, true);
			if (!$hubJson || empty($hubJson['key']) || !ctype_xdigit($hubJson['key'])) {
				Minz_Log::warning('Invalid JSON for PubSubHubbub: ' . $this->url);
				return false;
			}
			$callbackUrl = checkUrl(FreshRSS_Context::$system_conf->base_url . 'api/pshb.php?k=' . $hubJson['key']);
			if ($callbackUrl == '') {
				Minz_Log::warning('Invalid callback for PubSubHubbub: ' . $this->url);
				return false;
			}
			if (!$state) {	//unsubscribe
				$hubJson['lease_end'] = time() - 60;
				file_put_contents($hubFilename, json_encode($hubJson));
			}
			$ch = curl_init();
			curl_setopt_array($ch, array(
				CURLOPT_URL => $this->hubUrl,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_USERAGENT => _t('gen.freshrss') . '/' . FRESHRSS_VERSION . ' (' . PHP_OS . '; ' . FRESHRSS_WEBSITE . ')',
				CURLOPT_POSTFIELDS => 'hub.verify=sync'
					. '&hub.mode=' . ($state ? 'subscribe' : 'unsubscribe')
					. '&hub.topic=' . urlencode($this->selfUrl)
					. '&hub.callback=' . urlencode($callbackUrl)
				)
			);
			$response = curl_exec($ch);
			$info = curl_getinfo($ch);

			file_put_contents(USERS_PATH . '/_/log_pshb.txt', date('c') . "\t" .
				'PubSubHubbub ' . ($state ? 'subscribe' : 'unsubscribe') . ' to ' . $this->selfUrl .
				' with callback ' . $callbackUrl . ': ' . $info['http_code'] . ' ' . $response . "\n", FILE_APPEND);

			if (substr($info['http_code'], 0, 1) == '2') {
				return true;
			} else {
				$hubJson['lease_start'] = time();	//Prevent trying again too soon
				$hubJson['error'] = true;
				file_put_contents($hubFilename, json_encode($hubJson));
				return false;
			}
		}
		return false;
	}

	//</PubSubHubbub>
}
