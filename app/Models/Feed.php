<?php

class FreshRSS_Feed extends Minz_Model {
	const PRIORITY_MAIN_STREAM = 10;
	const PRIORITY_NORMAL = 0;
	const PRIORITY_ARCHIVED = -10;

	const TTL_DEFAULT = 0;

	const KEEP_HISTORY_DEFAULT = -3;	//Legacy < FreshRSS 1.15

	const ARCHIVING_RETENTION_COUNT_LIMIT = 10000;
	const ARCHIVING_RETENTION_PERIOD = 'P3M';

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
	private $priority = self::PRIORITY_MAIN_STREAM;
	private $pathEntries = '';
	private $httpAuth = '';
	private $error = false;
	private $keep_history = self::KEEP_HISTORY_DEFAULT;
	private $ttl = self::TTL_DEFAULT;
	private $attributes = [];
	private $mute = false;
	private $hash = null;
	private $lockPath = '';
	private $hubUrl = '';
	private $selfUrl = '';
	private $filterActions = null;

	public function __construct($url, $validate = true) {
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

	public function url($includeCredentials = true) {
		return $includeCredentials ? $this->url : SimplePie_Misc::url_remove_credentials($this->url);
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
	public function attributes($key = '') {
		if ($key == '') {
			return $this->attributes;
		} else {
			return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
		}
	}
	public function mute() {
		return $this->mute;
	}
	// public function ttlExpire() {
		// $ttl = $this->ttl;
		// if ($ttl == self::TTL_DEFAULT) {	//Default
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
		require_once(LIB_PATH . '/favicons.php');
		$url = $this->website;
		if ($url == '') {
			$url = $this->url;
		}
		$txt = FAVICONS_DIR . $this->hash() . '.txt';
		if (!file_exists($txt)) {
			file_put_contents($txt, $url);
		}
		if (FreshRSS_Context::$isCli) {
			$ico = FAVICONS_DIR . $this->hash() . '.ico';
			$ico_mtime = @filemtime($ico);
			$txt_mtime = @filemtime($txt);
			if ($txt_mtime != false &&
				($ico_mtime == false || $ico_mtime < $txt_mtime || ($ico_mtime < time() - (14 * 86400)))) {
				// no ico file or we should download a new one.
				$url = file_get_contents($txt);
				download_favicon($url, $ico) || touch($ico);
			}
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
	public function _url($value, $validate = true) {
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
	public function _website($value, $validate = true) {
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
		$this->priority = intval($value);
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
		$value = max($value, self::KEEP_HISTORY_DEFAULT);
		$this->keep_history = $value;
	}
	public function _ttl($value) {
		$value = intval($value);
		$value = min($value, 100000000);
		$this->ttl = abs($value);
		$this->mute = $value < self::TTL_DEFAULT;
	}

	public function _attributes($key, $value) {
		if ($key == '') {
			if (is_string($value)) {
				$value = json_decode($value, true);
			}
			if (is_array($value)) {
				$this->attributes = $value;
			}
		} elseif ($value === null) {
			unset($this->attributes[$key]);
		} else {
			$this->attributes[$key] = $value;
		}
	}

	public function _nbNotRead($value) {
		$this->nbNotRead = intval($value);
	}
	public function _nbEntries($value) {
		$this->nbEntries = intval($value);
	}

	public function load($loadDetails = false, $noCache = false) {
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
				$feed = customSimplePie($this->attributes());
				if (substr($url, -11) === '#force_feed') {
					$feed->force_feed(true);
					$url = substr($url, 0, -11);
				}
				$feed->set_feed_url($url);
				if (!$loadDetails) {	//Only activates auto-discovery when adding a new feed
					$feed->set_autodiscovery_level(SIMPLEPIE_LOCATOR_NONE);
				}
				if ($this->attributes('clear_cache')) {
					// Do not use `$simplePie->enable_cache(false);` as it would prevent caching in multiuser context
					$this->clearCache();
				}
				Minz_ExtensionManager::callHook('simplepie_before_init', $feed, $this);
				$mtime = $feed->init();

				if ((!$mtime) || $feed->error()) {
					$errorMessage = $feed->error();
					throw new FreshRSS_Feed_Exception(
						($errorMessage == '' ? 'Unknown error for feed' : $errorMessage) . ' [' . $url . ']'
					);
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

				if (($mtime === true) || ($mtime > $this->lastUpdate) || $noCache) {
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
		$guids = array();
		$hasUniqueGuids = true;

		foreach ($feed->get_items() as $item) {
			$title = html_only_entity_decode(strip_tags($item->get_title()));
			$authors = $item->get_authors();
			$link = $item->get_permalink();
			$date = @strtotime($item->get_date());

			//Tag processing (tag == category)
			$categories = $item->get_categories();
			$tags = array();
			if (is_array($categories)) {
				foreach ($categories as $category) {
					$text = html_only_entity_decode($category->get_label());
					//Some feeds use a single category with comma-separated tags
					$labels = explode(',', $text);
					if (is_array($labels)) {
						foreach ($labels as $label) {
							$tags[] = trim($label);
						}
					}
				}
				$tags = array_unique($tags);
			}

			$content = html_only_entity_decode($item->get_content());

			if ($item->get_enclosures() != null) {
				$elinks = array();
				foreach ($item->get_enclosures() as $enclosure) {
					$elink = $enclosure->get_link();
					if ($elink != '' && empty($elinks[$elink])) {
						$content .= '<div class="enclosure">';

						if ($enclosure->get_title() != '') {
							$content .= '<p class="enclosure-title">' . $enclosure->get_title() . '</p>';
						}

						$enclosureContent = '';
						$elinks[$elink] = true;
						$mime = strtolower($enclosure->get_type());
						$medium = strtolower($enclosure->get_medium());
						if ($medium === 'image' || strpos($mime, 'image/') === 0) {
							$enclosureContent .= '<p class="enclosure-content"><img src="' . $elink . '" alt="" /></p>';
						} elseif ($medium === 'audio' || strpos($mime, 'audio/') === 0) {
							$enclosureContent .= '<p class="enclosure-content"><audio preload="none" src="' . $elink
								. '" controls="controls"></audio> <a download="" href="' . $elink . '">💾</a></p>';
						} elseif ($medium === 'video' || strpos($mime, 'video/') === 0) {
							$enclosureContent .= '<p class="enclosure-content"><video preload="none" src="' . $elink
								. '" controls="controls"></video> <a download="" href="' . $elink . '">💾</a></p>';
						} elseif ($medium != '' || strpos($mime, 'application/') === 0 || strpos($mime, 'text/') === 0) {
							$enclosureContent .= '<p class="enclosure-content"><a download="" href="' . $elink . '">💾</a></p>';
						} else {
							unset($elinks[$elink]);
						}

						$thumbnailContent = '';
						if ($enclosure->get_thumbnails() != null) {
							foreach ($enclosure->get_thumbnails() as $thumbnail) {
								if (empty($elinks[$thumbnail])) {
									$elinks[$thumbnail] = true;
									$thumbnailContent .= '<p><img class="enclosure-thumbnail" src="' . $thumbnail . '" alt="" /></p>';
								}
							}
						}

						$content .= $thumbnailContent;
						$content .= $enclosureContent;

						if ($enclosure->get_description() != '') {
							$content .= '<pre class="enclosure-description">' . $enclosure->get_description() . '</pre>';
						}
						$content .= "</div>\n";
					}
				}
			}

			$guid = $item->get_id(false, false);
			$hasUniqueGuids &= empty($guids['_' . $guid]);
			$guids['_' . $guid] = true;
			$author_names = '';
			if (is_array($authors)) {
				foreach ($authors as $author) {
					$author_names .= escapeToUnicodeAlternative(strip_tags($author->name == '' ? $author->email : $author->name), true) . '; ';
				}
			}
			$author_names = substr($author_names, 0, -2);

			$entry = new FreshRSS_Entry(
				$this->id(),
				$guid,
				$title === null ? '' : $title,
				$author_names,
				$content === null ? '' : $content,
				$link === null ? '' : $link,
				$date ? $date : time()
			);
			$entry->_tags($tags);
			$entry->_feed($this);
			if ($this->pathEntries != '') {
				// Optionally load full content for truncated feeds
				$entry->loadCompleteContent();
			}

			$entries[] = $entry;
			unset($item);
		}

		$hasBadGuids = $this->attributes('hasBadGuids');
		if ($hasBadGuids != !$hasUniqueGuids) {
			$hasBadGuids = !$hasUniqueGuids;
			if ($hasBadGuids) {
				Minz_Log::warning('Feed has invalid GUIDs: ' . $this->url);
			} else {
				Minz_Log::warning('Feed has valid GUIDs again: ' . $this->url);
			}
			$feedDAO = FreshRSS_Factory::createFeedDao();
			$feedDAO->updateFeedAttribute($this, 'hasBadGuids', $hasBadGuids);
		}
		if (!$hasUniqueGuids) {
			foreach ($entries as $entry) {
				$entry->_guid('');
			}
		}

		$this->entries = $entries;
	}

	protected function cacheFilename() {
		return CACHE_PATH . '/' . md5($this->url) . '.spc';
	}

	public function clearCache() {
		return @unlink($this->cacheFilename());
	}

	public function cacheModifiedTime() {
		return @filemtime($this->cacheFilename());
	}

	public function lock() {
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

	public function unlock() {
		@unlink($this->lockPath);
	}

	public function filterActions() {
		if ($this->filterActions == null) {
			$this->filterActions = array();
			$filters = $this->attributes('filters');
			if (is_array($filters)) {
				foreach ($filters as $filter) {
					$filterAction = FreshRSS_FilterAction::fromJSON($filter);
					if ($filterAction != null) {
						$this->filterActions[] = $filterAction;
					}
				}
			}
		}
		return $this->filterActions;
	}

	private function _filterActions($filterActions) {
		$this->filterActions = $filterActions;
		if (is_array($this->filterActions) && !empty($this->filterActions)) {
			$this->_attributes('filters', array_map(function ($af) {
					return $af == null ? null : $af->toJSON();
				}, $this->filterActions));
		} else {
			$this->_attributes('filters', null);
		}
	}

	public function filtersAction($action) {
		$action = trim($action);
		if ($action == '') {
			return array();
		}
		$filters = array();
		$filterActions = $this->filterActions();
		for ($i = count($filterActions) - 1; $i >= 0; $i--) {
			$filterAction = $filterActions[$i];
			if ($filterAction != null && $filterAction->booleanSearch() != null &&
				$filterAction->actions() != null && in_array($action, $filterAction->actions(), true)) {
				$filters[] = $filterAction->booleanSearch();
			}
		}
		return $filters;
	}

	public function _filtersAction($action, $filters) {
		$action = trim($action);
		if ($action == '' || !is_array($filters)) {
			return false;
		}
		$filters = array_unique(array_map('trim', $filters));
		$filterActions = $this->filterActions();

		//Check existing filters
		for ($i = count($filterActions) - 1; $i >= 0; $i--) {
			$filterAction = $filterActions[$i];
			if ($filterAction == null || !is_array($filterAction->actions()) ||
				$filterAction->booleanSearch() == null || trim($filterAction->booleanSearch()->getRawInput()) == '') {
				array_splice($filterAction, $i, 1);
				continue;
			}
			$actions = $filterAction->actions();
			//Remove existing rules with same action
			for ($j = count($actions) - 1; $j >= 0; $j--) {
				if ($actions[$j] === $action) {
					array_splice($actions, $j, 1);
				}
			}
			//Update existing filter with new action
			for ($k = count($filters) - 1; $k >= 0; $k --) {
				$filter = $filters[$k];
				if ($filter === $filterAction->booleanSearch()->getRawInput()) {
					$actions[] = $action;
					array_splice($filters, $k, 1);
				}
			}
			//Save result
			if (empty($actions)) {
				array_splice($filterActions, $i, 1);
			} else {
				$filterAction->_actions($actions);
			}
		}

		//Add new filters
		for ($k = count($filters) - 1; $k >= 0; $k --) {
			$filter = $filters[$k];
			if ($filter != '') {
				$filterAction = FreshRSS_FilterAction::fromJSON(array(
						'search' => $filter,
						'actions' => array($action),
					));
				if ($filterAction != null) {
					$filterActions[] = $filterAction;
				}
			}
		}

		if (empty($filterActions)) {
			$filterActions = null;
		}
		$this->_filterActions($filterActions);
	}

	//<WebSub>

	public function pubSubHubbubEnabled() {
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

	public function pubSubHubbubError($error = true) {
		$url = $this->selfUrl ? $this->selfUrl : $this->url;
		$hubFilename = PSHB_PATH . '/feeds/' . base64url_encode($url) . '/!hub.json';
		$hubFile = @file_get_contents($hubFilename);
		$hubJson = $hubFile ? json_decode($hubFile, true) : array();
		if (!isset($hubJson['error']) || $hubJson['error'] !== (bool)$error) {
			$hubJson['error'] = (bool)$error;
			file_put_contents($hubFilename, json_encode($hubJson));
			Minz_Log::warning('Set error to ' . ($error ? 1 : 0) . ' for ' . $url, PSHB_LOG);
		}
		return false;
	}

	public function pubSubHubbubPrepare() {
		$key = '';
		if (FreshRSS_Context::$system_conf->base_url && $this->hubUrl && $this->selfUrl && @is_dir(PSHB_PATH)) {
			$path = PSHB_PATH . '/feeds/' . base64url_encode($this->selfUrl);
			$hubFilename = $path . '/!hub.json';
			if ($hubFile = @file_get_contents($hubFilename)) {
				$hubJson = json_decode($hubFile, true);
				if (!$hubJson || empty($hubJson['key']) || !ctype_xdigit($hubJson['key'])) {
					$text = 'Invalid JSON for WebSub: ' . $this->url;
					Minz_Log::warning($text);
					Minz_Log::warning($text, PSHB_LOG);
					return false;
				}
				if ((!empty($hubJson['lease_end'])) && ($hubJson['lease_end'] < (time() + (3600 * 23)))) {	//TODO: Make a better policy
					$text = 'WebSub lease ends at '
						. date('c', empty($hubJson['lease_end']) ? time() : $hubJson['lease_end'])
						. ' and needs renewal: ' . $this->url;
					Minz_Log::warning($text);
					Minz_Log::warning($text, PSHB_LOG);
					$key = $hubJson['key'];	//To renew our lease
				} elseif (((!empty($hubJson['error'])) || empty($hubJson['lease_end'])) &&
					(empty($hubJson['lease_start']) || $hubJson['lease_start'] < time() - (3600 * 23))) {	//Do not renew too often
					$key = $hubJson['key'];	//To renew our lease
				}
			} else {
				@mkdir($path, 0777, true);
				$key = sha1($path . FreshRSS_Context::$system_conf->salt);
				$hubJson = array(
					'hub' => $this->hubUrl,
					'key' => $key,
				);
				file_put_contents($hubFilename, json_encode($hubJson));
				@mkdir(PSHB_PATH . '/keys/');
				file_put_contents(PSHB_PATH . '/keys/' . $key . '.txt', base64url_encode($this->selfUrl));
				$text = 'WebSub prepared for ' . $this->url;
				Minz_Log::debug($text);
				Minz_Log::debug($text, PSHB_LOG);
			}
			$currentUser = Minz_Session::param('currentUser');
			if (FreshRSS_user_Controller::checkUsername($currentUser) && !file_exists($path . '/' . $currentUser . '.txt')) {
				touch($path . '/' . $currentUser . '.txt');
			}
		}
		return $key;
	}

	//Parameter true to subscribe, false to unsubscribe.
	public function pubSubHubbubSubscribe($state) {
		$url = $this->selfUrl ? $this->selfUrl : $this->url;
		if (FreshRSS_Context::$system_conf->base_url && $url) {
			$hubFilename = PSHB_PATH . '/feeds/' . base64url_encode($url) . '/!hub.json';
			$hubFile = @file_get_contents($hubFilename);
			if ($hubFile === false) {
				Minz_Log::warning('JSON not found for WebSub: ' . $this->url);
				return false;
			}
			$hubJson = json_decode($hubFile, true);
			if (!$hubJson || empty($hubJson['key']) || !ctype_xdigit($hubJson['key']) || empty($hubJson['hub'])) {
				Minz_Log::warning('Invalid JSON for WebSub: ' . $this->url);
				return false;
			}
			$callbackUrl = checkUrl(Minz_Request::getBaseUrl() . '/api/pshb.php?k=' . $hubJson['key']);
			if ($callbackUrl == '') {
				Minz_Log::warning('Invalid callback for WebSub: ' . $this->url);
				return false;
			}
			if (!$state) {	//unsubscribe
				$hubJson['lease_end'] = time() - 60;
				file_put_contents($hubFilename, json_encode($hubJson));
			}
			$ch = curl_init();
			curl_setopt_array($ch, [
					CURLOPT_URL => $hubJson['hub'],
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_POSTFIELDS => http_build_query(array(
						'hub.verify' => 'sync',
						'hub.mode' => $state ? 'subscribe' : 'unsubscribe',
						'hub.topic' => $url,
						'hub.callback' => $callbackUrl,
						)),
					CURLOPT_USERAGENT => FRESHRSS_USERAGENT,
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_ENCODING => '',	//Enable all encodings
				]);
			$response = curl_exec($ch);
			$info = curl_getinfo($ch);

			Minz_Log::warning('WebSub ' . ($state ? 'subscribe' : 'unsubscribe') . ' to ' . $url .
				' via hub ' . $hubJson['hub'] .
				' with callback ' . $callbackUrl . ': ' . $info['http_code'] . ' ' . $response, PSHB_LOG);

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

	//</WebSub>
}
