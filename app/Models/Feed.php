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
	 * Normal XML with XPath scraping
	 * @var int
	 */
	const KIND_XML_XPATH = 15;
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

	/** @var int */
	private $id = 0;
	/** @var string */
	private $url = '';
	/** @var int */
	private $kind = 0;
	/** @var int */
	private $categoryId = 1;
	/** @var FreshRSS_Category|null */
	private $category;
	/** @var int */
	private $nbEntries = -1;
	/** @var int */
	private $nbNotRead = -1;
	/** @var int */
	private $nbPendingNotRead = 0;
	/** @var string */
	private $name = '';
	/** @var string */
	private $website = '';
	/** @var string */
	private $description = '';
	/** @var int */
	private $lastUpdate = 0;
	/** @var int */
	private $priority = self::PRIORITY_MAIN_STREAM;
	/** @var string */
	private $pathEntries = '';
	/** @var string */
	private $httpAuth = '';
	/** @var bool */
	private $error = false;
	/** @var int */
	private $ttl = self::TTL_DEFAULT;
	private $attributes = [];
	/** @var bool */
	private $mute = false;
	/** @var string */
	private $hash = '';
	/** @var string */
	private $lockPath = '';
	/** @var string */
	private $hubUrl = '';
	/** @var string */
	private $selfUrl = '';
	/** @var array<FreshRSS_FilterAction> $filterActions */
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

	/**
	 * @return FreshRSS_Category|null|false
	 */
	public function category() {
		if ($this->category === null) {
			$catDAO = FreshRSS_Factory::createCategoryDao();
			$this->category = $catDAO->searchById($this->categoryId);
		}
		return $this->category;
	}

	public function categoryId(): int {
		return $this->categoryId;
	}

	public function entries() {
		Minz_Log::warning(__method__ . ' is deprecated since FreshRSS 1.16.1!');
		$simplePie = $this->load(false, true);
		return $simplePie == null ? [] : iterator_to_array($this->loadEntries($simplePie));
	}
	public function name($raw = false): string {
		return $raw || $this->name != '' ? $this->name : preg_replace('%^https?://(www[.])?%i', '', $this->url);
	}
	/** @return string HTML-encoded URL of the Web site of the feed */
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
	/** @return string HTML-encoded CSS selector */
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

	/**
	 * @param bool $raw true for database version combined with mute information, false otherwise
	 */
	public function ttl(bool $raw = false): int {
		if ($raw) {
			$ttl = $this->ttl;
			if ($this->mute && FreshRSS_Feed::TTL_DEFAULT === $ttl) {
				$ttl = FreshRSS_Context::$user_conf ? FreshRSS_Context::$user_conf->ttl_default : 3600;
			}
			return $ttl * ($this->mute ? -1 : 1);
		}
		return $this->ttl;
	}

	/** @return mixed attribute (if $key is not blank) or array of attributes, not HTML-encoded */
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
		if (@file_get_contents($txt) !== $url) {
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
		$url = $value;
		if ($validate) {
			$url = checkUrl($url);
		}
		if ($url == '') {
			throw new FreshRSS_BadUrl_Exception($value);
		}
		$this->url = $url;
	}
	public function _kind(int $value) {
		$this->kind = $value;
	}

	/** @param FreshRSS_Category|null $cat */
	public function _category($cat) {
		$this->category = $cat;
		$this->categoryId = $this->category == null ? 0 : $this->category->id();
	}

	/** @param int|string $id */
	public function _categoryId($id) {
		$this->category = null;
		$this->categoryId = intval($id);
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
	/** @param string $value HTML-encoded CSS selector */
	public function _pathEntries(string $value) {
		$this->pathEntries = $value;
	}
	public function _httpAuth(string $value) {
		$this->httpAuth = $value;
	}
	public function _error($value) {
		$this->error = (bool)$value;
	}
	public function _mute(bool $value) {
		$this->mute = $value;
	}
	public function _ttl($value) {
		$value = intval($value);
		$value = min($value, 100000000);
		$this->ttl = abs($value);
		$this->mute = $value < self::TTL_DEFAULT;
	}

	/** @param mixed $value Value, not HTML-encoded */
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
				$this->selfUrl = empty($links[0]) ? '' : checkUrl($links[0]);
				if ($this->selfUrl == false) {
					$this->selfUrl = '';
				}
				$links = $simplePie->get_links('hub');
				$this->hubUrl = empty($links[0]) ? '' : checkUrl($links[0]);
				if ($this->hubUrl == false) {
					$this->hubUrl = '';
				}

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

		$items = $simplePie->get_items();
		if (empty($items)) {
			return $guids;
		}
		for ($i = count($items) - 1; $i >= 0; $i--) {
			$item = $items[$i];
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

		$items = $simplePie->get_items();
		if (empty($items)) {
			return;
		}
		// We want chronological order and SimplePie uses reverse order.
		for ($i = count($items) - 1; $i >= 0; $i--) {
			$item = $items[$i];
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

			$attributeThumbnail = $item->get_thumbnail() ?? [];
			if (empty($attributeThumbnail['url'])) {
				$attributeThumbnail['url'] = '';
			}

			$attributeEnclosures = [];
			if (!empty($item->get_enclosures())) {
				foreach ($item->get_enclosures() as $enclosure) {
					$elink = $enclosure->get_link();
					if ($elink != '') {
						$etitle = $enclosure->get_title() ?? '';
						$credit = $enclosure->get_credit() ?? null;
						$description = $enclosure->get_description() ?? '';
						$mime = strtolower($enclosure->get_type() ?? '');
						$medium = strtolower($enclosure->get_medium() ?? '');
						$height = $enclosure->get_height();
						$width = $enclosure->get_width();
						$length = $enclosure->get_length();

						$attributeEnclosure = [
							'url' => $elink,
						];
						if ($etitle != '') $attributeEnclosure['title'] = $etitle;
						if ($credit != null) $attributeEnclosure['credit'] = $credit->get_name();
						if ($description != '') $attributeEnclosure['description'] = $description;
						if ($mime != '') $attributeEnclosure['type'] = $mime;
						if ($medium != '') $attributeEnclosure['medium'] = $medium;
						if ($length != '') $attributeEnclosure['length'] = intval($length);
						if ($height != '') $attributeEnclosure['height'] = intval($height);
						if ($width != '') $attributeEnclosure['width'] = intval($width);

						if (!empty($enclosure->get_thumbnails())) {
							foreach ($enclosure->get_thumbnails() as $thumbnail) {
								if ($thumbnail !== $attributeThumbnail['url']) {
									$attributeEnclosure['thumbnails'][] = $thumbnail;
								}
							}
						}

						$attributeEnclosures[] = $attributeEnclosure;
					}
				}
			}

			$guid = safe_ascii($item->get_id(false, false));
			unset($item);

			$authorNames = '';
			if (is_array($authors)) {
				foreach ($authors as $author) {
					$authorName = $author->name != '' ? $author->name : $author->email;
					if ($authorName != '') {
						$authorNames .= escapeToUnicodeAlternative(strip_tags($authorName), true) . '; ';
					}
				}
			}
			$authorNames = substr($authorNames, 0, -2);

			$entry = new FreshRSS_Entry(
				$this->id(),
				$hasBadGuids ? '' : $guid,
				$title == '' ? '' : $title,
				$authorNames,
				$content == '' ? '' : $content,
				$link == '' ? '' : $link,
				$date ? $date : time()
			);
			$entry->_tags($tags);
			$entry->_feed($this);
			if (!empty($attributeThumbnail['url'])) {
				$entry->_attributes('thumbnail', $attributeThumbnail);
			}
			$entry->_attributes('enclosures', $attributeEnclosures);
			$entry->hash();	//Must be computed before loading full content
			$entry->loadCompleteContent();	// Optionally load full content for truncated feeds

			yield $entry;
		}
	}

	/**
	 * @return SimplePie|null
	 */
	public function loadHtmlXpath() {
		if ($this->url == '') {
			return null;
		}
		$feedSourceUrl = htmlspecialchars_decode($this->url, ENT_QUOTES);
		if ($this->httpAuth != '') {
			$feedSourceUrl = preg_replace('#((.+)://)(.+)#', '${1}' . $this->httpAuth . '@${3}', $feedSourceUrl);
		}

		// Same naming conventions than https://rss-bridge.github.io/rss-bridge/Bridge_API/XPathAbstract.html
		// https://rss-bridge.github.io/rss-bridge/Bridge_API/BridgeAbstract.html#collectdata
		/** @var array<string,string> */
		$xPathSettings = $this->attributes('xpath');
		$xPathFeedTitle = $xPathSettings['feedTitle'] ?? '';
		$xPathItem = $xPathSettings['item'] ?? '';
		$xPathItemTitle = $xPathSettings['itemTitle'] ?? '';
		$xPathItemContent = $xPathSettings['itemContent'] ?? '';
		$xPathItemUri = $xPathSettings['itemUri'] ?? '';
		$xPathItemAuthor = $xPathSettings['itemAuthor'] ?? '';
		$xPathItemTimestamp = $xPathSettings['itemTimestamp'] ?? '';
		$xPathItemTimeFormat = $xPathSettings['itemTimeFormat'] ?? '';
		$xPathItemThumbnail = $xPathSettings['itemThumbnail'] ?? '';
		$xPathItemCategories = $xPathSettings['itemCategories'] ?? '';
		$xPathItemUid = $xPathSettings['itemUid'] ?? '';
		if ($xPathItem == '') {
			return null;
		}

		$cachePath = FreshRSS_Feed::cacheFilename($feedSourceUrl, $this->attributes(), $this->kind());
		$html = httpGet($feedSourceUrl, $cachePath,
			$this->kind() === FreshRSS_Feed::KIND_XML_XPATH ? 'xml' : 'html', $this->attributes());
		if (strlen($html) <= 0) {
			return null;
		}

		$view = new FreshRSS_View();
		$view->_path('index/rss.phtml');
		$view->internal_rendering = true;
		$view->rss_url = $feedSourceUrl;
		$view->entries = [];

		try {
			$doc = new DOMDocument();
			$doc->recover = true;
			$doc->strictErrorChecking = false;

			switch ($this->kind()) {
				case FreshRSS_Feed::KIND_HTML_XPATH:
					$doc->loadHTML($html, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);
					break;
				case FreshRSS_Feed::KIND_XML_XPATH:
					$doc->loadXML($html, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);
					break;
				default:
					return null;
			}

			$xpath = new DOMXPath($doc);
			$view->rss_title = $xPathFeedTitle == '' ? $this->name() :
				htmlspecialchars(@$xpath->evaluate('normalize-space(' . $xPathFeedTitle . ')'), ENT_COMPAT, 'UTF-8');
			$view->rss_base = htmlspecialchars(trim($xpath->evaluate('normalize-space(//base/@href)')), ENT_COMPAT, 'UTF-8');
			$nodes = $xpath->query($xPathItem);
			if (empty($nodes)) {
				return null;
			}

			foreach ($nodes as $node) {
				$item = [];
				$item['title'] = $xPathItemTitle == '' ? '' : @$xpath->evaluate('normalize-space(' . $xPathItemTitle . ')', $node);

				$item['content'] = '';
				if ($xPathItemContent != '') {
					$result = @$xpath->evaluate($xPathItemContent, $node);
					if ($result instanceof DOMNodeList) {
						// List of nodes, save as HTML
						$content = '';
						foreach ($result as $child) {
							$content .= $doc->saveHTML($child) . "\n";
						}
						$item['content'] = $content;
					} else {
						// Typed expression, save as-is
						$item['content'] = strval($result);
					}
				}

				$item['link'] = $xPathItemUri == '' ? '' : @$xpath->evaluate('normalize-space(' . $xPathItemUri . ')', $node);
				$item['author'] = $xPathItemAuthor == '' ? '' : @$xpath->evaluate('normalize-space(' . $xPathItemAuthor . ')', $node);
				$item['timestamp'] = $xPathItemTimestamp == '' ? '' : @$xpath->evaluate('normalize-space(' . $xPathItemTimestamp . ')', $node);
				if ($xPathItemTimeFormat != '') {
					$dateTime = DateTime::createFromFormat($xPathItemTimeFormat, $item['timestamp'] ?? '');
					if ($dateTime != false) {
						$item['timestamp'] = $dateTime->format(DateTime::ATOM);
					}
				}
				$item['thumbnail'] = $xPathItemThumbnail == '' ? '' : @$xpath->evaluate('normalize-space(' . $xPathItemThumbnail . ')', $node);
				if ($xPathItemCategories != '') {
					$itemCategories = @$xpath->query($xPathItemCategories, $node);
					if ($itemCategories) {
						foreach ($itemCategories as $itemCategory) {
							$item['categories'][] = $itemCategory->textContent;
						}
					}
				}
				if ($xPathItemUid != '') {
					$item['guid'] = @$xpath->evaluate('normalize-space(' . $xPathItemUid . ')', $node);
				}
				if (empty($item['guid'])) {
					$item['guid'] = 'urn:sha1:' . sha1($item['title'] . $item['content'] . $item['link']);
				}

				if ($item['title'] != '' || $item['content'] != '' || $item['link'] != '') {
					// HTML-encoding/escaping of the relevant fields (all except 'content')
					foreach (['author', 'categories', 'guid', 'link', 'thumbnail', 'timestamp', 'title'] as $key) {
						if (!empty($item[$key])) {
							$item[$key] = Minz_Helper::htmlspecialchars_utf8($item[$key]);
						}
					}
					// CDATA protection
					$item['content'] = str_replace(']]>', ']]&gt;', $item['content']);
					$view->entries[] = FreshRSS_Entry::fromArray($item);
				}
			}
		} catch (Exception $ex) {
			Minz_Log::warning($ex->getMessage());
			return null;
		}

		$simplePie = customSimplePie();
		$simplePie->set_raw_data($view->renderToString());
		$simplePie->init();
		return $simplePie;
	}

	/**
	 * To keep track of some new potentially unread articles since last commit+fetch from database
	 */
	public function incPendingUnread(int $n = 1) {
		$this->nbPendingNotRead += $n;
	}

	/**
	 * Remember to call updateCachedValue($id_feed) or updateCachedValues() just after.
	 * @return int|false the number of lines affected, or false if not applicable
	 */
	public function keepMaxUnread() {
		$keepMaxUnread = $this->attributes('keep_max_n_unread');
		if ($keepMaxUnread === null) {
			$keepMaxUnread = FreshRSS_Context::$user_conf->mark_when['max_n_unread'];
		}
		if ($keepMaxUnread > 0 && $this->nbNotRead(false) + $this->nbPendingNotRead > $keepMaxUnread) {
			$feedDAO = FreshRSS_Factory::createFeedDao();
			return $feedDAO->keepMaxUnread($this->id(), max(0, $keepMaxUnread - $this->nbPendingNotRead));
		}
		return false;
	}

	/**
	 * Applies the *mark as read upon gone* policy, if enabled.
	 * Remember to call updateCachedValue($id_feed) or updateCachedValues() just after.
	 * @return int|false the number of lines affected, or false if not applicable
	 */
	public function markAsReadUponGone() {
		$readUponGone = $this->attributes('read_upon_gone');
		if ($readUponGone === null) {
			$readUponGone = FreshRSS_Context::$user_conf->mark_when['gone'];
		}
		if ($readUponGone) {
			$feedDAO = FreshRSS_Factory::createFeedDao();
			return $feedDAO->markAsReadUponGone($this->id());
		}
		return false;
	}

	/**
	 * Remember to call updateCachedValue($id_feed) or updateCachedValues() just after
	 */
	public function cleanOldEntries() {
		$archiving = $this->attributes('archiving');
		if ($archiving == null) {
			$catDAO = FreshRSS_Factory::createCategoryDao();
			$category = $catDAO->searchById($this->categoryId);
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

	public static function cacheFilename(string $url, array $attributes, int $kind = FreshRSS_Feed::KIND_RSS): string {
		$simplePie = customSimplePie($attributes);
		$filename = $simplePie->get_cache_filename($url);
		if ($kind === FreshRSS_Feed::KIND_HTML_XPATH) {
			return CACHE_PATH . '/' . $filename . '.html';
		} elseif ($kind === FreshRSS_Feed::KIND_XML_XPATH) {
			return CACHE_PATH . '/' . $filename . '.xml';
		} else {
			return CACHE_PATH . '/' . $filename . '.spc';
		}
	}

	public function clearCache(): bool {
		return @unlink(FreshRSS_Feed::cacheFilename($this->url, $this->attributes(), $this->kind));
	}

	/** @return int|false */
	public function cacheModifiedTime() {
		return @filemtime(FreshRSS_Feed::cacheFilename($this->url, $this->attributes(), $this->kind));
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

	/** @return array<FreshRSS_BooleanSearch> */
	public function filtersAction(string $action): array {
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

	/**
	 * @param array<string> $filters
	 */
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
		$hubFilename = PSHB_PATH . '/feeds/' . sha1($url) . '/!hub.json';
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
		$hubFilename = PSHB_PATH . '/feeds/' . sha1($url) . '/!hub.json';
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
			$path = PSHB_PATH . '/feeds/' . sha1($this->selfUrl);
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
				@mkdir($path, 0770, true);
				$key = sha1($path . FreshRSS_Context::$system_conf->salt);
				$hubJson = array(
					'hub' => $this->hubUrl,
					'key' => $key,
				);
				file_put_contents($hubFilename, json_encode($hubJson));
				@mkdir(PSHB_PATH . '/keys/', 0770, true);
				file_put_contents(PSHB_PATH . '/keys/' . $key . '.txt', $this->selfUrl);
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
			$hubFilename = PSHB_PATH . '/feeds/' . sha1($url) . '/!hub.json';
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

			if (substr('' . $info['http_code'], 0, 1) == '2') {
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
