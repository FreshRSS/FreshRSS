<?php

class FreshRSS_Feed extends Minz_Model {

	/**
	 * Normal RSS or Atom feed
	 * @var int
	 */
	const KIND_RSS = 0;
	/**
	 * Invalid RSS or Atom feed
	 * @var int
	 */
	const KIND_RSS_FORCED = 2;
	/**
	 * Normal HTML with XPath scraping
	 * @var int
	 */
	const KIND_HTML_XPATH = 10;
	/**
	 * Normal JSON with XPath scraping
	 * @var int
	 */
	const KIND_JSON_XPATH = 20;

	const PRIORITY_MAIN_STREAM = 10;
	const PRIORITY_NORMAL = 0;
	const PRIORITY_ARCHIVED = -10;

	const TTL_DEFAULT = 0;

	const ARCHIVING_RETENTION_COUNT_LIMIT = 10000;
	const ARCHIVING_RETENTION_PERIOD = 'P3M';

	/**
	 * @var int
	 */
	private $id = 0;
	/**
	 * @var string
	 */
	private $url = '';
	/**
	 * @var int
	 */
	private $kind = 0;
	/**
	 * @var int
	 */
	private $category = 1;
	/**
	 * @var int
	 */
	private $nbEntries = -1;
	/**
	 * @var int
	 */
	private $nbNotRead = -1;
	/**
	 * @var int
	 */
	private $nbPendingNotRead = 0;
	/**
	 * @var string
	 */
	private $name = '';
	/**
	 * @var string
	 */
	private $website = '';
	/**
	 * @var string
	 */
	private $description = '';
	/**
	 * @var int
	 */
	private $lastUpdate = 0;
	/**
	 * @var int
	 */
	private $priority = self::PRIORITY_MAIN_STREAM;
	/**
	 * @var string
	 */
	private $pathEntries = '';
	/**
	 * @var string
	 */
	private $httpAuth = '';
	/**
	 * @var bool
	 */
	private $error = false;
	/**
	 * @var int
	 */
	private $ttl = self::TTL_DEFAULT;
	private $attributes = [];
	/**
	 * @var bool
	 */
	private $mute = false;
	/**
	 * @var string
	 */
	private $hash = '';
	/**
	 * @var string
	 */
	private $lockPath = '';
	/**
	 * @var string
	 */
	private $hubUrl = '';
	/**
	 * @var string
	 */
	private $selfUrl = '';
	/**
	 * @var array<FreshRSS_FilterAction> $filterActions
	 */
	private $filterActions = null;

	public function __construct(string $url, bool $validate = true) {
		if ($validate) {
			$this->_url($url);
		} else {
			$this->url = $url;
		}
	}

	/**
	 * @return FreshRSS_Feed
	 */
	public static function example() {
		$f = new FreshRSS_Feed('http://example.net/', false);
		$f->faviconPrepare();
		return $f;
	}

	public function id(): int {
		return $this->id;
	}

	public function hash(): string {
		if ($this->hash == '') {
			$salt = FreshRSS_Context::$system_conf->salt;
			$this->hash = hash('crc32b', $salt . $this->url);
		}
		return $this->hash;
	}

	public function url(bool $includeCredentials = true): string {
		return $includeCredentials ? $this->url : SimplePie_Misc::url_remove_credentials($this->url);
	}
	public function selfUrl(): string {
		return $this->selfUrl;
	}
	public function kind(): int {
		return $this->kind;
	}
	public function hubUrl(): string {
		return $this->hubUrl;
	}
	public function category(): int {
		return $this->category;
	}
	public function entries() {
		Minz_Log::warning(__method__ . ' is deprecated since FreshRSS 1.16.1!');
		$simplePie = $this->load(false, true);
		return $simplePie == null ? [] : iterator_to_array($this->loadEntries($simplePie));
	}
	public function name($raw = false): string {
		return $raw || $this->name != '' ? $this->name : preg_replace('%^https?://(www[.])?%i', '', $this->url);
	}
	public function website(): string {
		return $this->website;
	}
	public function description(): string {
		return $this->description;
	}
	public function lastUpdate(): int {
		return $this->lastUpdate;
	}
	public function priority(): int {
		return $this->priority;
	}
	public function pathEntries(): string {
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
	public function inError(): bool {
		return $this->error;
	}
	public function ttl(): int {
		return $this->ttl;
	}
	public function attributes($key = '') {
		if ($key == '') {
			return $this->attributes;
		} else {
			return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
		}
	}
	public function mute(): bool {
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
	public function nbEntries(): int {
		if ($this->nbEntries < 0) {
			$feedDAO = FreshRSS_Factory::createFeedDao();
			$this->nbEntries = $feedDAO->countEntries($this->id());
		}

		return $this->nbEntries;
	}
	public function nbNotRead($includePending = false): int {
		if ($this->nbNotRead < 0) {
			$feedDAO = FreshRSS_Factory::createFeedDao();
			$this->nbNotRead = $feedDAO->countNotRead($this->id());
		}

		return $this->nbNotRead + ($includePending ? $this->nbPendingNotRead : 0);
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
	public function favicon(): string {
		return Minz_Url::display('/f.php?' . $this->hash());
	}

	public function _id($value) {
		$this->id = intval($value);
	}
	public function _url(string $value, bool $validate = true) {
		$this->hash = '';
		if ($validate) {
			$value = checkUrl($value);
		}
		if ($value == '') {
			throw new FreshRSS_BadUrl_Exception($value);
		}
		$this->url = $value;
	}
	public function _kind($value) {
		$this->kind = $value;
	}
	public function _category($value) {
		$value = intval($value);
		$this->category = $value >= 0 ? $value : 0;
	}
	public function _name(string $value) {
		$this->name = $value == '' ? '' : trim($value);
	}
	public function _website(string $value, bool $validate = true) {
		if ($validate) {
			$value = checkUrl($value);
		}
		if ($value == '') {
			$value = '';
		}
		$this->website = $value;
	}
	public function _description(string $value) {
		$this->description = $value == '' ? '' : $value;
	}
	public function _lastUpdate($value) {
		$this->lastUpdate = intval($value);
	}
	public function _priority($value) {
		$this->priority = intval($value);
	}
	public function _pathEntries(string $value) {
		$this->pathEntries = $value;
	}
	public function _httpAuth(string $value) {
		$this->httpAuth = $value;
	}
	public function _error($value) {
		$this->error = (bool)$value;
	}
	public function _ttl($value) {
		$value = intval($value);
		$value = min($value, 100000000);
		$this->ttl = abs($value);
		$this->mute = $value < self::TTL_DEFAULT;
	}

	public function _attributes(string $key, $value) {
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

	/**
	 * @return SimplePie|null
	 */
	public function load(bool $loadDetails = false, bool $noCache = false) {
		if ($this->url != '') {
			// @phpstan-ignore-next-line
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
				$simplePie = customSimplePie($this->attributes());
				if (substr($url, -11) === '#force_feed') {
					$simplePie->force_feed(true);
					$url = substr($url, 0, -11);
				}
				$simplePie->set_feed_url($url);
				if (!$loadDetails) {	//Only activates auto-discovery when adding a new feed
					$simplePie->set_autodiscovery_level(SIMPLEPIE_LOCATOR_NONE);
				}
				if ($this->attributes('clear_cache')) {
					// Do not use `$simplePie->enable_cache(false);` as it would prevent caching in multiuser context
					$this->clearCache();
				}
				Minz_ExtensionManager::callHook('simplepie_before_init', $simplePie, $this);
				$mtime = $simplePie->init();

				if ((!$mtime) || $simplePie->error()) {
					$errorMessage = $simplePie->error();
					throw new FreshRSS_Feed_Exception(
						($errorMessage == '' ? 'Unknown error for feed' : $errorMessage) . ' [' . $this->url . ']',
						$simplePie->status_code()
					);
				}

				$links = $simplePie->get_links('self');
				$this->selfUrl = isset($links[0]) ? $links[0] : null;
				$links = $simplePie->get_links('hub');
				$this->hubUrl = isset($links[0]) ? $links[0] : null;

				if ($loadDetails) {
					// si on a utilisé l’auto-discover, notre url va avoir changé
					$subscribe_url = $simplePie->subscribe_url(false);

					//HTML to HTML-PRE	//ENT_COMPAT except '&'
					$title = strtr(html_only_entity_decode($simplePie->get_title()), array('<' => '&lt;', '>' => '&gt;', '"' => '&quot;'));
					$this->_name($title == '' ? $this->url : $title);

					$this->_website(html_only_entity_decode($simplePie->get_link()));
					$this->_description(html_only_entity_decode($simplePie->get_description()));
				} else {
					//The case of HTTP 301 Moved Permanently
					$subscribe_url = $simplePie->subscribe_url(true);
				}

				$clean_url = SimplePie_Misc::url_remove_credentials($subscribe_url);
				if ($subscribe_url !== null && $subscribe_url !== $url) {
					$this->_url($clean_url);
				}

				if (($mtime === true) || ($mtime > $this->lastUpdate) || $noCache) {
					//Minz_Log::debug('FreshRSS no cache ' . $mtime . ' > ' . $this->lastUpdate . ' for ' . $clean_url);
					return $simplePie;
				}
				//Minz_Log::debug('FreshRSS use cache for ' . $clean_url);
			}
		}
		return null;
	}

	/**
	 * @return array<string>
	 */
	public function loadGuids(SimplePie $simplePie) {
		$hasUniqueGuids = true;
		$testGuids = [];
		$guids = [];
		$hasBadGuids = $this->attributes('hasBadGuids');

		for ($i = $simplePie->get_item_quantity() - 1; $i >= 0; $i--) {
			$item = $simplePie->get_item($i);
			if ($item == null) {
				continue;
			}
			$guid = safe_ascii($item->get_id(false, false));
			$hasUniqueGuids &= empty($testGuids['_' . $guid]);
			$testGuids['_' . $guid] = true;
			$guids[] = $guid;
		}

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
		return $guids;
	}

	public function loadEntries(SimplePie $simplePie) {
		$hasBadGuids = $this->attributes('hasBadGuids');

		// We want chronological order and SimplePie uses reverse order.
		for ($i = $simplePie->get_item_quantity() - 1; $i >= 0; $i--) {
			$item = $simplePie->get_item($i);
			if ($item == null) {
				continue;
			}
			$title = html_only_entity_decode(strip_tags($item->get_title() ?? ''));
			$authors = $item->get_authors();
			$link = $item->get_permalink();
			$date = @strtotime($item->get_date() ?? '');

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
						$mime = strtolower($enclosure->get_type() ?? '');
						$medium = strtolower($enclosure->get_medium() ?? '');
						$height = $enclosure->get_height();
						$width = $enclosure->get_width();
						$length = $enclosure->get_length();
						if ($medium === 'image' || strpos($mime, 'image') === 0 ||
							($mime == '' && $length == null && ($width != 0 || $height != 0 || preg_match('/[.](avif|gif|jpe?g|png|svg|webp)$/i', $elink)))) {
							$enclosureContent .= '<p class="enclosure-content"><img src="' . $elink . '" alt="" /></p>';
						} elseif ($medium === 'audio' || strpos($mime, 'audio') === 0) {
							$enclosureContent .= '<p class="enclosure-content"><audio preload="none" src="' . $elink
								. ($length == null ? '' : '" data-length="' . intval($length))
								. '" data-type="' . htmlspecialchars($mime, ENT_COMPAT, 'UTF-8')
								. '" controls="controls"></audio> <a download="" href="' . $elink . '">💾</a></p>';
						} elseif ($medium === 'video' || strpos($mime, 'video') === 0) {
							$enclosureContent .= '<p class="enclosure-content"><video preload="none" src="' . $elink
								. ($length == null ? '' : '" data-length="' . intval($length))
								. '" data-type="' . htmlspecialchars($mime, ENT_COMPAT, 'UTF-8')
								. '" controls="controls"></video> <a download="" href="' . $elink . '">💾</a></p>';
						} else {	//e.g. application, text, unknown
							$enclosureContent .= '<p class="enclosure-content"><a download="" href="' . $elink . '">💾</a></p>';
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
							$content .= '<p class="enclosure-description">' . $enclosure->get_description() . '</p>';
						}
						$content .= "</div>\n";
					}
				}
			}

			$guid = safe_ascii($item->get_id(false, false));
			unset($item);

			$author_names = '';
			if (is_array($authors)) {
				foreach ($authors as $author) {
					$author_names .= escapeToUnicodeAlternative(strip_tags($author->name == '' ? $author->email : $author->name), true) . '; ';
				}
			}
			$author_names = substr($author_names, 0, -2);

			$entry = new FreshRSS_Entry(
				$this->id(),
				$hasBadGuids ? '' : $guid,
				$title == '' ? '' : $title,
				$author_names,
				$content == '' ? '' : $content,
				$link == '' ? '' : $link,
				$date ? $date : time()
			);
			$entry->_tags($tags);
			$entry->_feed($this);
			$entry->hash();	//Must be computed before loading full content
			$entry->loadCompleteContent();	// Optionally load full content for truncated feeds

			yield $entry;
		}
	}

	/**
	 * To keep track of some new potentially unread articles since last commit+fetch from database
	 */
	public function incPendingUnread(int $n = 1) {
		$this->nbPendingNotRead += $n;
	}

	public function keepMaxUnread() {
		$keepMaxUnread = $this->attributes('keep_max_n_unread');
		if ($keepMaxUnread == false) {
			$keepMaxUnread = FreshRSS_Context::$user_conf->mark_when['max_n_unread'];
		}
		if ($keepMaxUnread > 0 && $this->nbNotRead(false) + $this->nbPendingNotRead > $keepMaxUnread) {
			$feedDAO = FreshRSS_Factory::createFeedDao();
			$feedDAO->keepMaxUnread($this->id(), max(0, $keepMaxUnread - $this->nbPendingNotRead));
		}
	}

	/**
	 * Remember to call updateCachedValue($id_feed) or updateCachedValues() just after
	 */
	public function cleanOldEntries() {
		$archiving = $this->attributes('archiving');
		if ($archiving == null) {
			$catDAO = FreshRSS_Factory::createCategoryDao();
			$category = $catDAO->searchById($this->category());
			$archiving = $category == null ? null : $category->attributes('archiving');
			if ($archiving == null) {
				$archiving = FreshRSS_Context::$user_conf->archiving;
			}
		}
		if (is_array($archiving)) {
			$entryDAO = FreshRSS_Factory::createEntryDao();
			$nb = $entryDAO->cleanOldEntries($this->id(), $archiving);
			if ($nb > 0) {
				$needFeedCacheRefresh = true;
				Minz_Log::debug($nb . ' entries cleaned in feed [' . $this->url(false) . '] with: ' . json_encode($archiving));
			}
			return $nb;
		}
		return false;
	}

	protected function cacheFilename(): string {
		$simplePie = customSimplePie($this->attributes());
		$filename = $simplePie->get_cache_filename($this->url);
		return CACHE_PATH . '/' . $filename . '.spc';
	}

	public function clearCache(): bool {
		return @unlink($this->cacheFilename());
	}

	public function cacheModifiedTime() {
		return @filemtime($this->cacheFilename());
	}

	public function lock(): bool {
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

	public function unlock(): bool {
		return @unlink($this->lockPath);
	}

	/**
	 * @return array<FreshRSS_FilterAction>
	 */
	public function filterActions(): array {
		if (empty($this->filterActions)) {
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

	/**
	 * @param array<FreshRSS_FilterAction> $filterActions
	 */
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

	public function filtersAction(string $action) {
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

	public function _filtersAction(string $action, $filters) {
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
				array_splice($filterActions, $i, 1);
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

	public function pubSubHubbubEnabled(): bool {
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

	public function pubSubHubbubError(bool $error = true): bool {
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

	/**
	 * @return string|false
	 */
	public function pubSubHubbubPrepare() {
		$key = '';
		if (Minz_Request::serverIsPublic(FreshRSS_Context::$system_conf->base_url) &&
			$this->hubUrl && $this->selfUrl && @is_dir(PSHB_PATH)) {
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
	public function pubSubHubbubSubscribe(bool $state): bool {
		if ($state) {
			$url = $this->selfUrl ? $this->selfUrl : $this->url;
		} else {
			$url = $this->url;	//Always use current URL during unsubscribe
		}
		if ($url && (Minz_Request::serverIsPublic(FreshRSS_Context::$system_conf->base_url) || !$state)) {
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
