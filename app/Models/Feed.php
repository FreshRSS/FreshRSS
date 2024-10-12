<?php
declare(strict_types=1);

class FreshRSS_Feed extends Minz_Model {
	use FreshRSS_AttributesTrait, FreshRSS_FilterActionsTrait;

	/**
	 * Normal RSS or Atom feed
	 * @var int
	 */
	public const KIND_RSS = 0;
	/**
	 * Invalid RSS or Atom feed
	 * @var int
	 */
	public const KIND_RSS_FORCED = 2;
	/**
	 * Normal HTML with XPath scraping
	 * @var int
	 */
	public const KIND_HTML_XPATH = 10;
	/**
	 * Normal XML with XPath scraping
	 * @var int
	 */
	public const KIND_XML_XPATH = 15;
	/**
	 * Normal JSON with XPath scraping
	 * @var int
	 */
	public const KIND_JSON_XPATH = 20;

	public const KIND_JSONFEED = 25;
	public const KIND_JSON_DOTNOTATION = 30;

	public const PRIORITY_IMPORTANT = 20;
	public const PRIORITY_MAIN_STREAM = 10;
	public const PRIORITY_CATEGORY = 0;
	public const PRIORITY_ARCHIVED = -10;

	public const TTL_DEFAULT = 0;

	public const ARCHIVING_RETENTION_COUNT_LIMIT = 10000;
	public const ARCHIVING_RETENTION_PERIOD = 'P3M';

	private int $id = 0;
	private string $url = '';
	private int $kind = 0;
	private int $categoryId = 0;
	private ?FreshRSS_Category $category = null;
	private int $nbEntries = -1;
	private int $nbNotRead = -1;
	private string $name = '';
	private string $website = '';
	private string $description = '';
	private int $lastUpdate = 0;
	private int $priority = self::PRIORITY_MAIN_STREAM;
	private string $pathEntries = '';
	private string $httpAuth = '';
	private bool $error = false;
	private int $ttl = self::TTL_DEFAULT;
	private bool $mute = false;
	private string $hash = '';
	private string $lockPath = '';
	private string $hubUrl = '';
	private string $selfUrl = '';

	/**
	 * @throws FreshRSS_BadUrl_Exception
	 */
	public function __construct(string $url, bool $validate = true) {
		if ($validate) {
			$this->_url($url);
		} else {
			$this->url = $url;
		}
	}

	public static function default(): FreshRSS_Feed {
		$f = new FreshRSS_Feed('http://example.net/', false);
		$f->faviconPrepare();
		return $f;
	}

	public function id(): int {
		return $this->id;
	}

	public function hash(): string {
		if ($this->hash == '') {
			$salt = FreshRSS_Context::systemConf()->salt;
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

	public function category(): ?FreshRSS_Category {
		if ($this->category === null && $this->categoryId > 0) {
			$catDAO = FreshRSS_Factory::createCategoryDao();
			$this->category = $catDAO->searchById($this->categoryId);
		}
		return $this->category;
	}

	public function categoryId(): int {
		if ($this->category !== null) {
			return $this->category->id() ?: $this->categoryId;
		}
		return $this->categoryId;
	}

	/**
	 * @return array<FreshRSS_Entry>|null
	 * @deprecated
	 */
	public function entries(): ?array {
		Minz_Log::warning(__method__ . ' is deprecated since FreshRSS 1.16.1!');
		$simplePie = $this->load(false, true);
		return $simplePie == null ? [] : iterator_to_array($this->loadEntries($simplePie));
	}
	public function name(bool $raw = false): string {
		return $raw || $this->name != '' ? $this->name : (preg_replace('%^https?://(www[.])?%i', '', $this->url) ?? '');
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
	/**
	 * @phpstan-return ($raw is true ? string : array{'username':string,'password':string})
	 * @return array{'username':string,'password':string}|string
	 */
	public function httpAuth(bool $raw = true) {
		if ($raw) {
			return $this->httpAuth;
		} else {
			$pos_colon = strpos($this->httpAuth, ':');
			if ($pos_colon !== false) {
				$user = substr($this->httpAuth, 0, $pos_colon);
				$pass = substr($this->httpAuth, $pos_colon + 1);
			} else {
				$user = '';
				$pass = '';
			}

			return [
				'username' => $user,
				'password' => $pass,
				];
		}
	}

	/** @return array<int,mixed> */
	public function curlOptions(): array {
		$curl_options = [];
		if ($this->httpAuth !== '') {
			$curl_options[CURLOPT_USERPWD] = htmlspecialchars_decode($this->httpAuth, ENT_QUOTES);
		}
		return $curl_options;
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
				$ttl = FreshRSS_Context::userConf()->ttl_default;
			}
			return $ttl * ($this->mute ? -1 : 1);
		}
		if ($this->mute && $this->ttl === FreshRSS_Context::userConf()->ttl_default) {
			return FreshRSS_Feed::TTL_DEFAULT;
		}
		return $this->ttl;
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
	public function nbNotRead(): int {
		if ($this->nbNotRead < 0) {
			$feedDAO = FreshRSS_Factory::createFeedDao();
			$this->nbNotRead = $feedDAO->countNotRead($this->id());
		}

		return $this->nbNotRead;
	}

	public function faviconPrepare(): void {
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
				if ($url == false || !download_favicon($url, $ico)) {
					touch($ico);
				}
			}
		}
	}

	public static function faviconDelete(string $hash): void {
		$path = DATA_PATH . '/favicons/' . $hash;
		@unlink($path . '.ico');
		@unlink($path . '.txt');
	}
	public function favicon(): string {
		return Minz_Url::display('/f.php?' . $this->hash());
	}

	public function _id(int $value): void {
		$this->id = $value;
	}

	/**
	 * @throws FreshRSS_BadUrl_Exception
	 */
	public function _url(string $value, bool $validate = true): void {
		$this->hash = '';
		$url = $value;
		if ($validate) {
			$url = checkUrl($url);
		}
		if ($url == false) {
			throw new FreshRSS_BadUrl_Exception($value);
		}
		$this->url = $url;
	}

	public function _kind(int $value): void {
		$this->kind = $value;
	}

	public function _category(?FreshRSS_Category $cat): void {
		$this->category = $cat;
		$this->categoryId = $this->category == null ? 0 : $this->category->id();
	}

	/** @param int|string $id */
	public function _categoryId($id): void {
		$this->category = null;
		$this->categoryId = (int)$id;
	}

	public function _name(string $value): void {
		$this->name = $value == '' ? '' : trim($value);
	}
	public function _website(string $value, bool $validate = true): void {
		if ($validate) {
			$value = checkUrl($value);
		}
		if ($value == false) {
			$value = '';
		}
		$this->website = $value;
	}
	public function _description(string $value): void {
		$this->description = $value == '' ? '' : $value;
	}
	public function _lastUpdate(int $value): void {
		$this->lastUpdate = $value;
	}
	public function _priority(int $value): void {
		$this->priority = $value;
	}
	/** @param string $value HTML-encoded CSS selector */
	public function _pathEntries(string $value): void {
		$this->pathEntries = $value;
	}
	public function _httpAuth(string $value): void {
		$this->httpAuth = $value;
	}
	/** @param bool|int $value */
	public function _error($value): void {
		$this->error = (bool)$value;
	}
	public function _mute(bool $value): void {
		$this->mute = $value;
	}
	public function _ttl(int $value): void {
		$value = min($value, 100_000_000);
		$this->ttl = abs($value);
		$this->mute = $value < self::TTL_DEFAULT;
	}

	public function _nbNotRead(int $value): void {
		$this->nbNotRead = $value;
	}
	public function _nbEntries(int $value): void {
		$this->nbEntries = $value;
	}

	/**
	 * @throws Minz_FileNotExistException
	 * @throws FreshRSS_Feed_Exception
	 */
	public function load(bool $loadDetails = false, bool $noCache = false): ?SimplePie {
		if ($this->url != '') {
			/**
			 * @throws Minz_FileNotExistException
			 */
			if (CACHE_PATH == '') {
				throw new Minz_FileNotExistException(
					'CACHE_PATH',
					Minz_Exception::ERROR
				);
			} else {
				$simplePie = customSimplePie($this->attributes(), $this->curlOptions());
				$url = htmlspecialchars_decode($this->url, ENT_QUOTES);
				if (substr($url, -11) === '#force_feed') {
					$simplePie->force_feed(true);
					$url = substr($url, 0, -11);
				}
				$simplePie->set_feed_url($url);
				if (!$loadDetails) {	//Only activates auto-discovery when adding a new feed
					$simplePie->set_autodiscovery_level(SIMPLEPIE_LOCATOR_NONE);
				}
				if ($this->attributeBoolean('clear_cache')) {
					// Do not use `$simplePie->enable_cache(false);` as it would prevent caching in multiuser context
					$this->clearCache();
				}
				Minz_ExtensionManager::callHook('simplepie_before_init', $simplePie, $this);
				$mtime = $simplePie->init();

				if ((!$mtime) || $simplePie->error()) {
					$errorMessage = $simplePie->error();
					if (empty($errorMessage)) {
						$errorMessage = '';
					} elseif (is_array($errorMessage)) {
						$errorMessage = json_encode($errorMessage, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_LINE_TERMINATORS) ?: '';
					}
					throw new FreshRSS_Feed_Exception(
						($errorMessage == '' ? 'Unknown error for feed' : $errorMessage) .
							' [' . $this->url . ']',
						$simplePie->status_code()
					);
				}

				$links = $simplePie->get_links('self');
				$this->selfUrl = empty($links[0]) ? '' : (checkUrl($links[0]) ?: '');
				$links = $simplePie->get_links('hub');
				$this->hubUrl = empty($links[0]) ? '' : (checkUrl($links[0]) ?: '');

				if ($loadDetails) {
					// si on a utilisé l’auto-discover, notre url va avoir changé
					$subscribe_url = $simplePie->subscribe_url(false) ?? '';

					if ($this->name(true) === '') {
						//HTML to HTML-PRE	//ENT_COMPAT except '&'
						$title = strtr(html_only_entity_decode($simplePie->get_title()), ['<' => '&lt;', '>' => '&gt;', '"' => '&quot;']);
						$this->_name($title == '' ? $this->url : $title);
					}
					if ($this->website() === '') {
						$this->_website(html_only_entity_decode($simplePie->get_link()));
					}
					if ($this->description() === '') {
						$this->_description(html_only_entity_decode($simplePie->get_description()));
					}
				} else {
					//The case of HTTP 301 Moved Permanently
					$subscribe_url = $simplePie->subscribe_url(true) ?? '';
				}

				$clean_url = SimplePie_Misc::url_remove_credentials($subscribe_url);
				if ($subscribe_url !== '' && $subscribe_url !== $url) {
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
	public function loadGuids(SimplePie $simplePie): array {
		$hasUniqueGuids = true;
		$testGuids = [];
		$guids = [];
		$links = [];
		$hadBadGuids = $this->attributeBoolean('hasBadGuids');

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
			$permalink = $item->get_permalink();
			if ($permalink != null) {
				$links[] = $permalink;
			}
		}

		if ($hadBadGuids != !$hasUniqueGuids) {
			if ($hadBadGuids) {
				Minz_Log::warning('Feed has invalid GUIDs: ' . $this->url);
			} else {
				Minz_Log::warning('Feed has valid GUIDs again: ' . $this->url);
			}
			$feedDAO = FreshRSS_Factory::createFeedDao();
			$feedDAO->updateFeedAttribute($this, 'hasBadGuids', !$hasUniqueGuids);
		}

		return $hasUniqueGuids ? $guids : $links;
	}

	/** @return Traversable<FreshRSS_Entry> */
	public function loadEntries(SimplePie $simplePie): Traversable {
		$hasBadGuids = $this->attributeBoolean('hasBadGuids');

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
			$date = @strtotime((string)($item->get_date() ?? '')) ?: 0;

			//Tag processing (tag == category)
			$categories = $item->get_categories();
			$tags = [];
			if (is_array($categories)) {
				foreach ($categories as $category) {
					$text = html_only_entity_decode($category->get_label());
					//Some feeds use a single category with comma-separated tags
					$labels = explode(',', $text);
					if (!empty($labels)) {
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
						$credits = $enclosure->get_credits() ?? null;
						$description = $enclosure->get_description() ?? '';
						$mime = strtolower($enclosure->get_type() ?? '');
						$medium = strtolower($enclosure->get_medium() ?? '');
						$height = $enclosure->get_height();
						$width = $enclosure->get_width();
						$length = $enclosure->get_length();

						$attributeEnclosure = [
							'url' => $elink,
						];
						if ($etitle != '') {
							$attributeEnclosure['title'] = $etitle;
						}
						if (is_array($credits)) {
							$attributeEnclosure['credit'] = [];
							foreach ($credits as $credit) {
								$attributeEnclosure['credit'][] = $credit->get_name();
							}
						}
						if ($description != '') {
							$attributeEnclosure['description'] = $description;
						}
						if ($mime != '') {
							$attributeEnclosure['type'] = $mime;
						}
						if ($medium != '') {
							$attributeEnclosure['medium'] = $medium;
						}
						if ($length != '') {
							$attributeEnclosure['length'] = (int)$length;
						}
						if ($height != '') {
							$attributeEnclosure['height'] = (int)$height;
						}
						if ($width != '') {
							$attributeEnclosure['width'] = (int)$width;
						}

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
			$authorNames = substr($authorNames, 0, -2) ?: '';

			$entry = new FreshRSS_Entry(
				$this->id(),
				$hasBadGuids ? '' : $guid,
				$title == '' ? '' : $title,
				$authorNames,
				$content == '' ? '' : $content,
				$link == null ? '' : $link,
				$date ?: time()
			);
			$entry->_tags($tags);
			$entry->_feed($this);
			if (!empty($attributeThumbnail['url'])) {
				$entry->_attribute('thumbnail', $attributeThumbnail);
			}
			$entry->_attribute('enclosures', $attributeEnclosures);
			$entry->hash();	//Must be computed before loading full content
			$entry->loadCompleteContent();	// Optionally load full content for truncated feeds

			yield $entry;
		}
	}

	/**
	 * Given a feed content generated from a FreshRSS_View
	 * returns a SimplePie initialized already with that content
	 * @param string $feedContent the content of the feed, typically generated via FreshRSS_View::renderToString()
	 */
	private function simplePieFromContent(string $feedContent): SimplePie {
		$simplePie = customSimplePie();
		$simplePie->set_raw_data($feedContent);
		$simplePie->init();
		return $simplePie;
	}

	/** @return array<string,string> */
	private function dotNotationForStandardJsonFeed(): array {
		return [
			'feedTitle' => 'title',
			'item' => 'items',
			'itemTitle' => 'title',
			'itemContent' => 'content_text',
			'itemContentHTML' => 'content_html',
			'itemUri' => 'url',
			'itemTimestamp' => 'date_published',
			'itemTimeFormat' => DateTimeInterface::RFC3339_EXTENDED,
			'itemThumbnail' => 'image',
			'itemCategories' => 'tags',
			'itemUid' => 'id',
			'itemAttachment' => 'attachments',
			'itemAttachmentUrl' => 'url',
			'itemAttachmentType' => 'mime_type',
			'itemAttachmentLength' => 'size_in_bytes',
		];
	}

	public function loadJson(): ?SimplePie {
		if ($this->url == '') {
			return null;
		}
		$feedSourceUrl = htmlspecialchars_decode($this->url, ENT_QUOTES);
		if ($feedSourceUrl == null) {
			return null;
		}

		$httpAccept = 'json';
		$json = httpGet($feedSourceUrl, $this->cacheFilename(), $httpAccept, $this->attributes(), $this->curlOptions());
		if (strlen($json) <= 0) {
			return null;
		}

		//check if the content is actual JSON
		$jf = json_decode($json, true);
		if (json_last_error() !== JSON_ERROR_NONE || !is_array($jf)) {
			return null;
		}

		/** @var array<string,string> $json_dotnotation */
		$json_dotnotation = $this->attributeArray('json_dotnotation') ?? [];
		$dotnotations = $this->kind() === FreshRSS_Feed::KIND_JSONFEED ? $this->dotNotationForStandardJsonFeed() : $json_dotnotation;

		$feedContent = FreshRSS_dotNotation_Util::convertJsonToRss($jf, $feedSourceUrl, $dotnotations, $this->name());
		if ($feedContent == null) {
			return null;
		}
		return $this->simplePieFromContent($feedContent);
	}

	public function loadHtmlXpath(): ?SimplePie {
		if ($this->url == '') {
			return null;
		}
		$feedSourceUrl = htmlspecialchars_decode($this->url, ENT_QUOTES);
		if ($feedSourceUrl == null) {
			return null;
		}

		// Same naming conventions than https://rss-bridge.github.io/rss-bridge/Bridge_API/XPathAbstract.html
		// https://rss-bridge.github.io/rss-bridge/Bridge_API/BridgeAbstract.html#collectdata
		/** @var array<string,string> $xPathSettings */
		$xPathSettings = $this->attributeArray('xpath');
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

		$httpAccept = $this->kind() === FreshRSS_Feed::KIND_XML_XPATH ? 'xml' : 'html';
		$html = httpGet($feedSourceUrl, $this->cacheFilename(), $httpAccept, $this->attributes(), $this->curlOptions());
		if (strlen($html) <= 0) {
			return null;
		}

		$view = new FreshRSS_View();
		$view->_path('index/rss.phtml');
		$view->internal_rendering = true;
		$view->rss_url = htmlspecialchars($feedSourceUrl, ENT_COMPAT, 'UTF-8');
		$view->html_url = $view->rss_url;
		$view->entries = [];

		try {
			$doc = new DOMDocument();
			$doc->recover = true;
			$doc->strictErrorChecking = false;
			$ok = false;

			switch ($this->kind()) {
				case FreshRSS_Feed::KIND_HTML_XPATH:
					$ok = $doc->loadHTML($html, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING) !== false;
					break;
				case FreshRSS_Feed::KIND_XML_XPATH:
					$ok = $doc->loadXML($html, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING) !== false;
					break;
			}

			if (!$ok) {
				return null;
			}

			$xpath = new DOMXPath($doc);
			$xpathEvaluateString = function (string $expression, ?DOMNode $contextNode = null) use ($xpath): string {
				$result = @$xpath->evaluate('normalize-space(' . $expression . ')', $contextNode);
				return is_string($result) ? $result : '';
			};

			$view->rss_title = $xPathFeedTitle == '' ? $this->name() :
				htmlspecialchars($xpathEvaluateString($xPathFeedTitle), ENT_COMPAT, 'UTF-8');
			$view->rss_base = htmlspecialchars(trim($xpathEvaluateString('//base/@href')), ENT_COMPAT, 'UTF-8');
			$nodes = $xpath->query($xPathItem);
			if ($nodes === false || $nodes->length === 0) {
				return null;
			}

			foreach ($nodes as $node) {
				$item = [];
				$item['title'] = $xPathItemTitle == '' ? '' : $xpathEvaluateString($xPathItemTitle, $node);

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
					} elseif (is_string($result) || is_int($result) || is_bool($result)) {
						// Typed expression, save as-is
						$item['content'] = (string)$result;
					}
				}

				$item['link'] = $xPathItemUri == '' ? '' : $xpathEvaluateString($xPathItemUri, $node);
				$item['author'] = $xPathItemAuthor == '' ? '' : $xpathEvaluateString($xPathItemAuthor, $node);
				$item['timestamp'] = $xPathItemTimestamp == '' ? '' : $xpathEvaluateString($xPathItemTimestamp, $node);
				if ($xPathItemTimeFormat != '') {
					$dateTime = DateTime::createFromFormat($xPathItemTimeFormat, $item['timestamp']);
					if ($dateTime != false) {
						$item['timestamp'] = $dateTime->format(DateTime::ATOM);
					}
				}
				$item['thumbnail'] = $xPathItemThumbnail == '' ? '' : $xpathEvaluateString($xPathItemThumbnail, $node);
				if ($xPathItemCategories != '') {
					$itemCategories = @$xpath->evaluate($xPathItemCategories, $node);
					if (is_string($itemCategories) && $itemCategories !== '') {
						$item['tags'] = [$itemCategories];
					} elseif ($itemCategories instanceof DOMNodeList && $itemCategories->length > 0) {
						$item['tags'] = [];
						foreach ($itemCategories as $itemCategory) {
							$item['tags'][] = $itemCategory->textContent;
						}
					}
				}
				if ($xPathItemUid != '') {
					$item['guid'] = $xpathEvaluateString($xPathItemUid, $node);
				}
				if (empty($item['guid'])) {
					$item['guid'] = 'urn:sha1:' . sha1($item['title'] . $item['content'] . $item['link']);
				}

				if ($item['title'] != '' || $item['content'] != '' || $item['link'] != '') {
					// HTML-encoding/escaping of the relevant fields (all except 'content')
					foreach (['author', 'guid', 'link', 'thumbnail', 'timestamp', 'tags', 'title'] as $key) {
						if (!empty($item[$key]) && is_string($item[$key])) {
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
		return $this->simplePieFromContent($view->renderToString());
	}

	/**
	 * @return int|null The max number of unread articles to keep, or null if disabled.
	 */
	public function keepMaxUnread() {
		$keepMaxUnread = $this->attributeInt('keep_max_n_unread');
		if ($keepMaxUnread === null) {
			$keepMaxUnread = FreshRSS_Context::userConf()->mark_when['max_n_unread'];
		}
		return is_int($keepMaxUnread) && $keepMaxUnread >= 0 ? $keepMaxUnread : null;
	}

	/**
	 * @return int|false The number of articles marked as read, of false if error
	 */
	public function markAsReadMaxUnread() {
		$keepMaxUnread = $this->keepMaxUnread();
		if ($keepMaxUnread === null) {
			return false;
		}
		$feedDAO = FreshRSS_Factory::createFeedDao();
		$affected = $feedDAO->markAsReadMaxUnread($this->id(), $keepMaxUnread);
		return $affected;
	}

	/**
	 * Applies the *mark as read upon gone* policy, if enabled.
	 * Remember to call `updateCachedValues($id_feed)` or `updateCachedValues()` just after.
	 * @return int|false the number of lines affected, or false if not applicable
	 */
	public function markAsReadUponGone(bool $upstreamIsEmpty, int $minLastSeen = 0) {
		$readUponGone = $this->attributeBoolean('read_upon_gone');
		if ($readUponGone === null) {
			$readUponGone = FreshRSS_Context::userConf()->mark_when['gone'];
		}
		if (!$readUponGone) {
			return false;
		}
		if ($upstreamIsEmpty) {
			if ($minLastSeen <= 0) {
				$minLastSeen = time();
			}
			$entryDAO = FreshRSS_Factory::createEntryDao();
			$affected = $entryDAO->markReadFeed($this->id(), $minLastSeen . '000000');
		} else {
			$feedDAO = FreshRSS_Factory::createFeedDao();
			$affected = $feedDAO->markAsReadNotSeen($this->id(), $minLastSeen);
		}
		if ($affected > 0) {
			Minz_Log::debug(__METHOD__ . " $affected items" . ($upstreamIsEmpty ? ' (all)' : '') . ' [' . $this->url(false) . ']');
		}
		return $affected;
	}

	/**
	 * Remember to call `updateCachedValues($id_feed)` or `updateCachedValues()` just after
	 * @return int|false
	 */
	public function cleanOldEntries() {
		/** @var array<string,bool|int|string>|null $archiving */
		$archiving = $this->attributeArray('archiving');
		if ($archiving === null) {
			$catDAO = FreshRSS_Factory::createCategoryDao();
			$category = $catDAO->searchById($this->categoryId);
			$archiving = $category === null ? null : $category->attributeArray('archiving');
			/** @var array<string,bool|int|string>|null $archiving */
			if ($archiving === null) {
				$archiving = FreshRSS_Context::userConf()->archiving;
			}
		}
		if (is_array($archiving)) {
			$entryDAO = FreshRSS_Factory::createEntryDao();
			$nb = $entryDAO->cleanOldEntries($this->id(), $archiving);
			if ($nb > 0) {
				Minz_Log::debug($nb . ' entries cleaned in feed [' . $this->url(false) . '] with: ' . json_encode($archiving));
			}
			return $nb;
		}
		return false;
	}

	/**
	 * @param string $url Overridden URL. Will default to the feed URL.
	 * @throws FreshRSS_Context_Exception
	 */
	public function cacheFilename(string $url = ''): string {
		$simplePie = customSimplePie($this->attributes(), $this->curlOptions());
		if ($url !== '') {
			$filename = $simplePie->get_cache_filename($url);
			return CACHE_PATH . '/' . $filename . '.html';
		}
		$url = htmlspecialchars_decode($this->url);
		$filename = $simplePie->get_cache_filename($url);
		if ($this->kind === FreshRSS_Feed::KIND_HTML_XPATH) {
			return CACHE_PATH . '/' . $filename . '.html';
		} elseif ($this->kind === FreshRSS_Feed::KIND_XML_XPATH) {
			return CACHE_PATH . '/' . $filename . '.xml';
		} else {
			return CACHE_PATH . '/' . $filename . '.spc';
		}
	}

	public function clearCache(): bool {
		return @unlink($this->cacheFilename());
	}

	/** @return int|false */
	public function cacheModifiedTime() {
		$filename = $this->cacheFilename();
		clearstatcache(true, $filename);
		return @filemtime($filename);
	}

	public function lock(): bool {
		$this->lockPath = TMP_PATH . '/' . $this->hash() . '.freshrss.lock';
		if (file_exists($this->lockPath) && ((time() - (@filemtime($this->lockPath) ?: 0)) > 3600)) {
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

	//<WebSub>

	public function pubSubHubbubEnabled(): bool {
		$url = $this->selfUrl ?: $this->url;
		$hubFilename = PSHB_PATH . '/feeds/' . sha1($url) . '/!hub.json';
		if ($hubFile = @file_get_contents($hubFilename)) {
			$hubJson = json_decode($hubFile, true);
			if (is_array($hubJson) && empty($hubJson['error']) &&
				(empty($hubJson['lease_end']) || $hubJson['lease_end'] > time())) {
				return true;
			}
		}
		return false;
	}

	public function pubSubHubbubError(bool $error = true): bool {
		$url = $this->selfUrl ?: $this->url;
		$hubFilename = PSHB_PATH . '/feeds/' . sha1($url) . '/!hub.json';
		$hubFile = @file_get_contents($hubFilename);
		$hubJson = is_string($hubFile) ? json_decode($hubFile, true) : null;
		if (is_array($hubJson) && (!isset($hubJson['error']) || $hubJson['error'] !== $error)) {
			$hubJson['error'] = $error;
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
		if (Minz_Request::serverIsPublic(FreshRSS_Context::systemConf()->base_url) &&
			$this->hubUrl && $this->selfUrl && @is_dir(PSHB_PATH)) {
			$path = PSHB_PATH . '/feeds/' . sha1($this->selfUrl);
			$hubFilename = $path . '/!hub.json';
			if ($hubFile = @file_get_contents($hubFilename)) {
				$hubJson = json_decode($hubFile, true);
				if (!is_array($hubJson) || empty($hubJson['key']) || !ctype_xdigit($hubJson['key'])) {
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
				$key = sha1($path . FreshRSS_Context::systemConf()->salt);
				$hubJson = [
					'hub' => $this->hubUrl,
					'key' => $key,
				];
				file_put_contents($hubFilename, json_encode($hubJson));
				@mkdir(PSHB_PATH . '/keys/', 0770, true);
				file_put_contents(PSHB_PATH . '/keys/' . $key . '.txt', $this->selfUrl);
				$text = 'WebSub prepared for ' . $this->url;
				Minz_Log::debug($text);
				Minz_Log::debug($text, PSHB_LOG);
			}
			$currentUser = Minz_User::name() ?? '';
			if (FreshRSS_user_Controller::checkUsername($currentUser) && !file_exists($path . '/' . $currentUser . '.txt')) {
				touch($path . '/' . $currentUser . '.txt');
			}
		}
		return $key;
	}

	//Parameter true to subscribe, false to unsubscribe.
	public function pubSubHubbubSubscribe(bool $state): bool {
		if ($state) {
			$url = $this->selfUrl ?: $this->url;
		} else {
			$url = $this->url;	//Always use current URL during unsubscribe
		}
		if ($url && (Minz_Request::serverIsPublic(FreshRSS_Context::systemConf()->base_url) || !$state)) {
			$hubFilename = PSHB_PATH . '/feeds/' . sha1($url) . '/!hub.json';
			$hubFile = @file_get_contents($hubFilename);
			if ($hubFile === false) {
				Minz_Log::warning('JSON not found for WebSub: ' . $this->url);
				return false;
			}
			$hubJson = json_decode($hubFile, true);
			if (!is_array($hubJson) || empty($hubJson['key']) || !ctype_xdigit($hubJson['key']) || empty($hubJson['hub'])) {
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
				CURLOPT_POSTFIELDS => http_build_query([
					'hub.verify' => 'sync',
					'hub.mode' => $state ? 'subscribe' : 'unsubscribe',
					'hub.topic' => $url,
					'hub.callback' => $callbackUrl,
				]),
				CURLOPT_USERAGENT => FRESHRSS_USERAGENT,
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_ENCODING => '',	//Enable all encodings
				//CURLOPT_VERBOSE => 1,	// To debug sent HTTP headers
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
