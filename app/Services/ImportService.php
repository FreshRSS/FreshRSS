<?php
declare(strict_types=1);

/**
 * Provide methods to import files.
 */
class FreshRSS_Import_Service {

	private FreshRSS_CategoryDAO $catDAO;

	private FreshRSS_FeedDAO $feedDAO;

	/** true if success, false otherwise */
	private bool $lastStatus;

	/**
	 * Initialize the service for the given user.
	 */
	public function __construct(?string $username = null) {
		$this->catDAO = FreshRSS_Factory::createCategoryDao($username);
		$this->feedDAO = FreshRSS_Factory::createFeedDao($username);
	}

	/** @return bool true if success, false otherwise */
	public function lastStatus(): bool {
		return $this->lastStatus;
	}

	/**
	 * This method parses and imports an OPML file.
	 *
	 * @param string $opml_file the OPML file content.
	 * @param FreshRSS_Category|null $forced_category force the feeds to be associated to this category.
	 * @param bool $dry_run true to not create categories and feeds in database.
	 */
	public function importOpml(string $opml_file, ?FreshRSS_Category $forced_category = null, bool $dry_run = false): void {
		if (function_exists('set_time_limit')) {
			@set_time_limit(300);
		}
		$this->lastStatus = true;
		$opml_array = [];
		try {
			$libopml = new \marienfressinaud\LibOpml\LibOpml(false);
			$opml_array = $libopml->parseString($opml_file);
		} catch (\marienfressinaud\LibOpml\Exception $e) {
			self::log($e->getMessage());
			$this->lastStatus = false;
			return;
		}

		$this->catDAO->checkDefault();
		$default_category = $this->catDAO->getDefault();
		if ($default_category === null) {
			self::log('Cannot get the default category');
			$this->lastStatus = false;
			return;
		}

		// Get the categories by names so we can use this array to retrieve
		// existing categories later.
		$categories = $this->catDAO->listCategories(false) ?: [];
		$categories_by_names = [];
		foreach ($categories as $category) {
			$categories_by_names[$category->name()] = $category;
		}

		// Get current numbers of categories and feeds, and the limits to
		// verify the user can import its categories/feeds.
		$nb_categories = count($categories);
		$nb_feeds = count($this->feedDAO->listFeeds());
		$limits = FreshRSS_Context::systemConf()->limits;

		// Process the OPML outlines to get a list of categories and a list of
		// feeds elements indexed by their categories names.
		[$categories_elements, $categories_to_feeds] = $this->loadFromOutlines($opml_array['body'], '');

		foreach ($categories_to_feeds as $category_name => $feeds_elements) {
			$category_element = $categories_elements[$category_name] ?? null;

			$category = null;
			if ($forced_category) {
				// If the category is forced, ignore the actual category name
				$category = $forced_category;
			} elseif (isset($categories_by_names[$category_name])) {
				// If the category already exists, get it from $categories_by_names
				$category = $categories_by_names[$category_name];
			} elseif ($category_element) {
				// Otherwise, create the category (if possible)
				$limit_reached = $nb_categories >= $limits['max_categories'];
				$can_create_category = FreshRSS_Context::$isCli || !$limit_reached;

				if ($can_create_category) {
					$category = $this->createCategory($category_element, $dry_run);
					if ($category) {
						$categories_by_names[$category->name()] = $category;
						$nb_categories++;
					}
				} else {
					Minz_Log::warning(
						_t('feedback.sub.category.over_max', $limits['max_categories'])
					);
				}
			}

			if (!$category) {
				// Category can be null if the feeds weren't in a category
				// outline, or if we weren't able to create the category.
				$category = $default_category;
			}

			// Then, create the feeds one by one and attach them to the
			// category we just got.
			foreach ($feeds_elements as $feed_element) {
				$limit_reached = $nb_feeds >= $limits['max_feeds'];
				$can_create_feed = FreshRSS_Context::$isCli || !$limit_reached;
				if (!$can_create_feed) {
					Minz_Log::warning(
						_t('feedback.sub.feed.over_max', $limits['max_feeds'])
					);
					$this->lastStatus = false;
					break;
				}

				if ($this->createFeed($feed_element, $category, $dry_run)) {
					// TODO what if the feed already exists in the database?
					$nb_feeds++;
				} else {
					$this->lastStatus = false;
				}
			}
		}
	}

	/**
	 * Create a feed from a feed element (i.e. OPML outline).
	 *
	 * @param array<string,string> $feed_elt An OPML element (must be a feed element).
	 * @param FreshRSS_Category $category The category to associate to the feed.
	 * @param bool $dry_run true to not create the feed in database.
	 * @return FreshRSS_Feed|null The created feed, or null if it failed.
	 */
	private function createFeed(array $feed_elt, FreshRSS_Category $category, bool $dry_run): ?FreshRSS_Feed {
		$url = Minz_Helper::htmlspecialchars_utf8($feed_elt['xmlUrl']);
		$name = $feed_elt['text'] ?? $feed_elt['title'] ?? '';
		$name = Minz_Helper::htmlspecialchars_utf8($name);
		$website = Minz_Helper::htmlspecialchars_utf8($feed_elt['htmlUrl'] ?? '');
		$description = Minz_Helper::htmlspecialchars_utf8($feed_elt['description'] ?? '');

		try {
			// Create a Feed object and add it in DB
			$feed = new FreshRSS_Feed($url);
			$category->addFeed($feed);
			$feed->_name($name);
			$feed->_website($website);
			$feed->_description($description);

			switch (strtolower($feed_elt['type'] ?? '')) {
				case strtolower(FreshRSS_Export_Service::TYPE_HTML_XPATH):
					$feed->_kind(FreshRSS_Feed::KIND_HTML_XPATH);
					break;
				case strtolower(FreshRSS_Export_Service::TYPE_XML_XPATH):
					$feed->_kind(FreshRSS_Feed::KIND_XML_XPATH);
					break;
				case strtolower(FreshRSS_Export_Service::TYPE_JSON_DOTPATH):
					$feed->_kind(FreshRSS_Feed::KIND_JSON_DOTPATH);
					break;
				case strtolower(FreshRSS_Export_Service::TYPE_JSONFEED):
					$feed->_kind(FreshRSS_Feed::KIND_JSONFEED);
					break;
				default:
					$feed->_kind(FreshRSS_Feed::KIND_RSS);
					break;
			}

			if (isset($feed_elt['frss:cssFullContent'])) {
				$feed->_pathEntries(Minz_Helper::htmlspecialchars_utf8($feed_elt['frss:cssFullContent']));
			}

			if (isset($feed_elt['frss:cssFullContentFilter'])) {
				$feed->_attribute('path_entries_filter', $feed_elt['frss:cssFullContentFilter']);
			}

			if (isset($feed_elt['frss:filtersActionRead'])) {
				$feed->_filtersAction(
					'read',
					preg_split('/\R/', $feed_elt['frss:filtersActionRead']) ?: []
				);
			}

			$xPathSettings = [];
			if (isset($feed_elt['frss:xPathItem'])) {
				$xPathSettings['item'] = $feed_elt['frss:xPathItem'];
			}
			if (isset($feed_elt['frss:xPathItemTitle'])) {
				$xPathSettings['itemTitle'] = $feed_elt['frss:xPathItemTitle'];
			}
			if (isset($feed_elt['frss:xPathItemContent'])) {
				$xPathSettings['itemContent'] = $feed_elt['frss:xPathItemContent'];
			}
			if (isset($feed_elt['frss:xPathItemUri'])) {
				$xPathSettings['itemUri'] = $feed_elt['frss:xPathItemUri'];
			}
			if (isset($feed_elt['frss:xPathItemAuthor'])) {
				$xPathSettings['itemAuthor'] = $feed_elt['frss:xPathItemAuthor'];
			}
			if (isset($feed_elt['frss:xPathItemTimestamp'])) {
				$xPathSettings['itemTimestamp'] = $feed_elt['frss:xPathItemTimestamp'];
			}
			if (isset($feed_elt['frss:xPathItemTimeFormat'])) {
				$xPathSettings['itemTimeFormat'] = $feed_elt['frss:xPathItemTimeFormat'];
			}
			if (isset($feed_elt['frss:xPathItemThumbnail'])) {
				$xPathSettings['itemThumbnail'] = $feed_elt['frss:xPathItemThumbnail'];
			}
			if (isset($feed_elt['frss:xPathItemCategories'])) {
				$xPathSettings['itemCategories'] = $feed_elt['frss:xPathItemCategories'];
			}
			if (isset($feed_elt['frss:xPathItemUid'])) {
				$xPathSettings['itemUid'] = $feed_elt['frss:xPathItemUid'];
			}
			if (!empty($xPathSettings)) {
				$feed->_attribute('xpath', $xPathSettings);
			}

			$jsonSettings = [];
			if (isset($feed_elt['frss:jsonItem'])) {
				$jsonSettings['item'] = $feed_elt['frss:jsonItem'];
			}
			if (isset($feed_elt['frss:jsonItemTitle'])) {
				$jsonSettings['itemTitle'] = $feed_elt['frss:jsonItemTitle'];
			}
			if (isset($feed_elt['frss:jsonItemContent'])) {
				$jsonSettings['itemContent'] = $feed_elt['frss:jsonItemContent'];
			}
			if (isset($feed_elt['frss:jsonItemUri'])) {
				$jsonSettings['itemUri'] = $feed_elt['frss:jsonItemUri'];
			}
			if (isset($feed_elt['frss:jsonItemAuthor'])) {
				$jsonSettings['itemAuthor'] = $feed_elt['frss:jsonItemAuthor'];
			}
			if (isset($feed_elt['frss:jsonItemTimestamp'])) {
				$jsonSettings['itemTimestamp'] = $feed_elt['frss:jsonItemTimestamp'];
			}
			if (isset($feed_elt['frss:jsonItemTimeFormat'])) {
				$jsonSettings['itemTimeFormat'] = $feed_elt['frss:jsonItemTimeFormat'];
			}
			if (isset($feed_elt['frss:jsonItemThumbnail'])) {
				$jsonSettings['itemThumbnail'] = $feed_elt['frss:jsonItemThumbnail'];
			}
			if (isset($feed_elt['frss:jsonItemCategories'])) {
				$jsonSettings['itemCategories'] = $feed_elt['frss:jsonItemCategories'];
			}
			if (isset($feed_elt['frss:jsonItemUid'])) {
				$jsonSettings['itemUid'] = $feed_elt['frss:jsonItemUid'];
			}
			if (!empty($jsonSettings)) {
				$feed->_attribute('json_dotpath', $jsonSettings);
			}

			$curl_params = [];
			if (isset($feed_elt['frss:CURLOPT_COOKIE'])) {
				$curl_params[CURLOPT_COOKIE] = $feed_elt['frss:CURLOPT_COOKIE'];
			}
			if (isset($feed_elt['frss:CURLOPT_COOKIEFILE'])) {
				$curl_params[CURLOPT_COOKIEFILE] = $feed_elt['frss:CURLOPT_COOKIEFILE'];
			}
			if (isset($feed_elt['frss:CURLOPT_FOLLOWLOCATION'])) {
				$curl_params[CURLOPT_FOLLOWLOCATION] = (bool)$feed_elt['frss:CURLOPT_FOLLOWLOCATION'];
			}
			if (isset($feed_elt['frss:CURLOPT_HTTPHEADER'])) {
				$curl_params[CURLOPT_HTTPHEADER] = preg_split('/\R/', $feed_elt['frss:CURLOPT_HTTPHEADER']) ?: [];
			}
			if (isset($feed_elt['frss:CURLOPT_MAXREDIRS'])) {
				$curl_params[CURLOPT_MAXREDIRS] = (int)$feed_elt['frss:CURLOPT_MAXREDIRS'];
			}
			if (isset($feed_elt['frss:CURLOPT_POST'])) {
				$curl_params[CURLOPT_POST] = (bool)$feed_elt['frss:CURLOPT_POST'];
			}
			if (isset($feed_elt['frss:CURLOPT_POSTFIELDS'])) {
				$curl_params[CURLOPT_POSTFIELDS] = $feed_elt['frss:CURLOPT_POSTFIELDS'];
			}
			if (isset($feed_elt['frss:CURLOPT_PROXY'])) {
				$curl_params[CURLOPT_PROXY] = $feed_elt['frss:CURLOPT_PROXY'];
			}
			if (isset($feed_elt['frss:CURLOPT_PROXYTYPE'])) {
				$curl_params[CURLOPT_PROXYTYPE] = $feed_elt['frss:CURLOPT_PROXYTYPE'];
			}
			if (isset($feed_elt['frss:CURLOPT_USERAGENT'])) {
				$curl_params[CURLOPT_USERAGENT] = $feed_elt['frss:CURLOPT_USERAGENT'];
			}
			if (!empty($curl_params)) {
				$feed->_attribute('curl_params', $curl_params);
			}

			// Call the extension hook
			/** @var FreshRSS_Feed|null */
			$feed = Minz_ExtensionManager::callHook('feed_before_insert', $feed);

			if ($dry_run) {
				return $feed;
			}

			if ($feed != null) {
				// addFeedObject checks if feed is already in DB
				$id = $this->feedDAO->addFeedObject($feed);
				if ($id == false) {
					$this->lastStatus = false;
				} else {
					$feed->_id($id);
					return $feed;
				}
			}
		} catch (FreshRSS_Feed_Exception $e) {
			self::log($e->getMessage());
			$this->lastStatus = false;
		}

		$clean_url = SimplePie_Misc::url_remove_credentials($url);
		self::log("Cannot create {$clean_url} feed in category {$category->name()}");
		return null;
	}

	/**
	 * Create and return a category.
	 *
	 * @param array<string,string> $category_element An OPML element (must be a category element).
	 * @param bool $dry_run true to not create the category in database.
	 * @return FreshRSS_Category|null The created category, or null if it failed.
	 */
	private function createCategory(array $category_element, bool $dry_run): ?FreshRSS_Category {
		$name = $category_element['text'] ?? $category_element['title'] ?? '';
		$name = Minz_Helper::htmlspecialchars_utf8($name);
		$category = new FreshRSS_Category($name);

		if (isset($category_element['frss:opmlUrl'])) {
			$opml_url = checkUrl($category_element['frss:opmlUrl']);
			if ($opml_url != '') {
				$category->_kind(FreshRSS_Category::KIND_DYNAMIC_OPML);
				$category->_attribute('opml_url', $opml_url);
			}
		}

		if ($dry_run) {
			return $category;
		}

		$id = $this->catDAO->addCategoryObject($category);
		if ($id !== false) {
			$category->_id($id);
			return $category;
		} else {
			self::log("Cannot create category {$category->name()}");
			$this->lastStatus = false;
			return null;
		}
	}

	/**
	 * Return the list of category and feed outlines by categories names.
	 *
	 * This method is applied to a list of outlines. It merges the different
	 * list of feeds from several outlines into one array.
	 *
	 * @param array<mixed> $outlines
	 *     The outlines from which to extract the outlines.
	 * @param string $parent_category_name
	 *     The name of the parent category of the current outlines.
	 * @return array{0:array<mixed>,1:array<mixed>}
	 */
	private function loadFromOutlines(array $outlines, string $parent_category_name): array {
		$categories_elements = [];
		$categories_to_feeds = [];

		foreach ($outlines as $outline) {
			// Get the categories and feeds from the child outline (it may
			// return several categories and feeds if the outline is a category).
			[$outline_categories, $outline_categories_to_feeds] = $this->loadFromOutline($outline, $parent_category_name);

			// Then, we merge the initial arrays with the arrays returned by
			// the outline.
			$categories_elements = array_merge($categories_elements, $outline_categories);

			foreach ($outline_categories_to_feeds as $category_name => $feeds) {
				if (!isset($categories_to_feeds[$category_name])) {
					$categories_to_feeds[$category_name] = [];
				}

				$categories_to_feeds[$category_name] = array_merge(
					$categories_to_feeds[$category_name],
					$feeds
				);
			}
		}

		return [$categories_elements, $categories_to_feeds];
	}

	/**
	 * Return the list of category and feed outlines by categories names.
	 *
	 * This method is applied to a specific outline. If the outline represents
	 * a category (i.e. @outlines key exists), it will reapply loadFromOutlines()
	 * to its children. If the outline represents a feed (i.e. xmlUrl key
	 * exists), it will add the outline to an array accessible by its category
	 * name.
	 *
	 * @param array<mixed> $outline
	 *     The outline from which to extract the categories and feeds outlines.
	 * @param string $parent_category_name
	 *     The name of the parent category of the current outline.
	 *
	 * @return array{0:array<string,mixed>,1:array<string,mixed>}
	 */
	private function loadFromOutline($outline, $parent_category_name): array {
		$categories_elements = [];
		$categories_to_feeds = [];

		if ($parent_category_name === '' && isset($outline['category'])) {
			// The outline has no parent category, but its OPML category
			// attribute is set, so we use it as the category name.
			// lib_opml parses this attribute as an array of strings, so we
			// rebuild a string here.
			$parent_category_name = implode(', ', $outline['category']);
			$categories_elements[$parent_category_name] = [
				'text' => $parent_category_name,
			];
		}

		if (isset($outline['@outlines'])) {
			// The outline has children, it’s probably a category
			if (!empty($outline['text'])) {
				$category_name = $outline['text'];
			} elseif (!empty($outline['title'])) {
				$category_name = $outline['title'];
			} else {
				$category_name = $parent_category_name;
			}

			[$categories_elements, $categories_to_feeds] = $this->loadFromOutlines($outline['@outlines'], $category_name);

			unset($outline['@outlines']);
			$categories_elements[$category_name] = $outline;
		}

		// The xmlUrl means it’s a feed URL: add the outline to the array if it exists.
		if (isset($outline['xmlUrl'])) {
			if (!isset($categories_to_feeds[$parent_category_name])) {
				$categories_to_feeds[$parent_category_name] = [];
			}

			$categories_to_feeds[$parent_category_name][] = $outline;
		}

		return [$categories_elements, $categories_to_feeds];
	}

	private static function log(string $message): void {
		if (FreshRSS_Context::$isCli) {
			fwrite(STDERR, "FreshRSS error during OPML import: {$message}\n");
		} else {
			Minz_Log::warning("Error during OPML import: {$message}");
		}
	}
}
