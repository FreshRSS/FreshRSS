<?php

/**
 * Provide methods to import files.
 */
class FreshRSS_Import_Service {
	/** @var FreshRSS_CategoryDAO */
	private $catDAO;

	/** @var FreshRSS_FeedDAO */
	private $feedDAO;

	/**
	 * Initialize the service for the given user.
	 *
	 * @param string $username
	 */
	public function __construct($username) {
		require_once(LIB_PATH . '/lib_opml/src/LibOpml/Exception.php');
		require_once(LIB_PATH . '/lib_opml/src/LibOpml/LibOpml.php');
		require_once(LIB_PATH . '/lib_opml/src/functions.php');

		$this->catDAO = FreshRSS_Factory::createCategoryDao($username);
		$this->feedDAO = FreshRSS_Factory::createFeedDao($username);
	}

	/**
	 * This method parses and imports an OPML file.
	 *
	 * @param string $opml_file the OPML file content.
	 *
	 * @return boolean false if an error occurred, true otherwise.
	 */
	public function importOpml($opml_file) {
		$opml_array = array();
		try {
			$opml_array = libopml_parse_string($opml_file, false);
		} catch (\marienfressinaud\LibOpml\Exception $e) {
			if (FreshRSS_Context::$isCli) {
				fwrite(STDERR, 'FreshRSS error during OPML parsing: ' . $e->getMessage() . "\n");
			} else {
				Minz_Log::warning($e->getMessage());
			}
			return false;
		}

		$this->catDAO->checkDefault();
		$default_category = $this->catDAO->getDefault();

		// Get the categories by names so we can use this array to retrieve
		// existing categories later.
		$categories = $this->catDAO->listCategories(false);
		$categories_by_names = [];
		foreach ($categories as $category) {
			$categories_by_names[$category->name()] = $category;
		}

		// Get current numbers of categories and feeds, and the limits to
		// verify the user can import its categories/feeds.
		$nb_categories = count($categories);
		$nb_feeds = count($this->feedDAO->listFeeds());
		$limits = FreshRSS_Context::$system_conf->limits;

		// Process the OPML outlines to get a list of feeds elements indexed by
		// their categories names.
		$categories_to_feeds = $this->loadFeedsFromOutlines($opml_array['body'], '');

		$is_ok_status = true;

		foreach ($categories_to_feeds as $category_name => $feeds_elements) {
			// First, retrieve the category by its name.
			$category = null;
			if ($category_name === '') {
				// If empty, get the default category
				$category = $default_category;
			} elseif (isset($categories_by_names[$category_name])) {
				// If the category already exists, get it from $categories_by_names
				$category = $categories_by_names[$category_name];
			} else {
				// Otherwise, create the category (if possible)
				$limit_reached = $nb_categories >= $limits['max_categories'];
				$can_create_category = FreshRSS_Context::$isCli || !$limit_reached;

				if ($can_create_category) {
					$category = $this->createAndGetCategory($category_name);
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
				// We weren't able to create the category because the user
				// reached the limit (or because an error occured), so we'll
				// attach the feeds to the default category.
				$category = $default_category;
				$is_ok_status = false;
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
					$is_ok_status = false;
					break;
				}

				if ($this->createFeed($feed_element, $category)) {
					// TODO what if the feed already exists in the database?
					$nb_feeds++;
				} else {
					$is_ok_status = false;
				}
			}
		}

		return $is_ok_status;
	}

	/**
	 * Create a feed from a feed element (i.e. OPML outline).
	 *
	 * @param array $feed_elt An OPML element (must be a feed element).
	 * @param FreshRSS_Category $category The category to associate to the feed.
	 *
	 * @return boolean false if an error occurred, true otherwise.
	 */
	private function createFeed($feed_elt, $category) {
		$url = Minz_Helper::htmlspecialchars_utf8($feed_elt['xmlUrl']);
		$name = '';
		if (!empty($feed_elt['text'])) {
			$name = Minz_Helper::htmlspecialchars_utf8($feed_elt['text']);
		} elseif (!empty($feed_elt['title'])) {
			$name = Minz_Helper::htmlspecialchars_utf8($feed_elt['title']);
		}
		$website = '';
		if (isset($feed_elt['htmlUrl'])) {
			$website = Minz_Helper::htmlspecialchars_utf8($feed_elt['htmlUrl']);
		}
		$description = '';
		if (isset($feed_elt['description'])) {
			$description = Minz_Helper::htmlspecialchars_utf8($feed_elt['description']);
		}

		$error = false;
		try {
			// Create a Feed object and add it in DB
			$feed = new FreshRSS_Feed($url);
			$feed->_category($category->id());
			$feed->_name($name);
			$feed->_website($website);
			$feed->_description($description);

			switch ($feed_elt['type'] ?? '') {
				case strtolower(FreshRSS_Export_Service::TYPE_HTML_XPATH):
					$feed->_kind(FreshRSS_Feed::KIND_HTML_XPATH);
					break;
				case strtolower(FreshRSS_Export_Service::TYPE_RSS_ATOM):
				default:
					$feed->_kind(FreshRSS_Feed::KIND_RSS);
					break;
			}

			if (isset($feed_elt['frss:cssFullContent'])) {
				$feed->_pathEntries($feed_elt['frss:cssFullContent']);
			}

			if (isset($feed_elt['frss:filtersActionRead'])) {
				$feed->_filtersAction(
					'read',
					preg_split('/[\n\r]+/', $feed_elt['frss:filtersActionRead'])
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
			if (isset($feed_elt['frss:xPathItemThumbnail'])) {
				$xPathSettings['itemThumbnail'] = $feed_elt['frss:xPathItemThumbnail'];
			}
			if (isset($feed_elt['frss:xPathItemCategories'])) {
				$xPathSettings['itemCategories'] = $feed_elt['frss:xPathItemCategories'];
			}

			if (!empty($xPathSettings)) {
				$feed->_attributes('xpath', $xPathSettings);
			}

			// Call the extension hook
			$feed = Minz_ExtensionManager::callHook('feed_before_insert', $feed);
			if ($feed != null) {
				// addFeedObject checks if feed is already in DB so nothing else to
				// check here
				$id = $this->feedDAO->addFeedObject($feed);
				$error = ($id == false);
			} else {
				$error = true;
			}
		} catch (FreshRSS_Feed_Exception $e) {
			if (FreshRSS_Context::$isCli) {
				fwrite(STDERR, 'FreshRSS error during OPML feed import: ' . $e->getMessage() . "\n");
			} else {
				Minz_Log::warning($e->getMessage());
			}
			$error = true;
		}

		if ($error) {
			if (FreshRSS_Context::$isCli) {
				fwrite(STDERR, 'FreshRSS error during OPML feed import from URL: ' . $url . ' in category ' . $category->id() . "\n");
			} else {
				Minz_Log::warning('Error during OPML feed import from URL: ' . $url . ' in category ' . $category->id());
			}
		}

		return !$error;
	}

	/**
	 * Create and return a category.
	 *
	 * @param string $category_name
	 *     The name of the category to create (must be valid).
	 *
	 * @return FreshRSS_Category|null The created category, or null if it failed.
	 */
	private function createAndGetCategory($category_name) {
		$id = $this->catDAO->addCategory([
			'name' => $category_name,
		]);

		if ($id !== false) {
			return $this->catDAO->searchById($id);
		} else {
			if (FreshRSS_Context::$isCli) {
				fwrite(STDERR, 'FreshRSS error during OPML category import from URL: ' . $category_name . "\n");
			} else {
				Minz_Log::warning('Error during OPML category import from URL: ' . $category_name);
			}

			return null;
		}
	}

	/**
	 * Return the list of feed outlines by categories names.
	 *
	 * This method is applied to a list of outlines. It merges the different
	 * list of feeds from several outlines into one array.
	 *
	 * @param array $outlines
	 *     The outlines from which to extract the feeds outlines.
	 * @param string $parent_category_name
	 *     The name of the parent category of the current outlines.
	 *
	 * @return array[]
	 */
	private function loadFeedsFromOutlines($outlines, $parent_category_name) {
		$categories_to_feeds = [];

		foreach ($outlines as $outline) {
			// Get the feeds from the child outline (it may return several
			// feeds if the outline is a category).
			$outline_categories_to_feeds = $this->loadFeedsFromOutline(
				$outline,
				$parent_category_name
			);

			// Then, we merge the initial array with the array returned by the
			// outline.
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

		return $categories_to_feeds;
	}

	/**
	 * Return the list of feed outlines by categories names.
	 *
	 * This method is applied to a specific outline. If the outline represents
	 * a category (i.e. @outlines key exists), it will reapply loadFeedsFromOutlines()
	 * to its children. If the outline represents a feed (i.e. xmlUrl key
	 * exists), it will add the outline to an array accessible by its category
	 * name.
	 *
	 * The method also cleans the parent_category_name so it will be directly
	 * usable in database.
	 *
	 * @param array $outline
	 *     The outline from which to extract the feeds outlines.
	 * @param string $parent_category_name
	 *     The name of the parent category of the current outline.
	 *
	 * @return array[]
	 */
	private function loadFeedsFromOutline($outline, $parent_category_name) {
		$categories_to_feeds = [];

		if ($parent_category_name === '' && isset($outline['category'])) {
			// The outline has no parent category, but its OPML category
			// attribute is set, so we use it as the category name.
			// lib_opml parses this attribute as an array of strings, so we
			// rebuild a string here.
			$parent_category_name = implode(', ', $outline['category']);
		}

		if (isset($outline['@outlines'])) {
			// The outline has children, it's probably a category
			if (!empty($outline['text'])) {
				$category_name = $outline['text'];
			} elseif (!empty($outline['title'])) {
				$category_name = $outline['title'];
			} else {
				$category_name = $parent_category_name;
			}

			$categories_to_feeds = $this->loadFeedsFromOutlines(
				$outline['@outlines'],
				$category_name
			);
		}

		// Before adding the parent category_name in the array, we clean the name.
		$parent_category_name = Minz_Helper::htmlspecialchars_utf8(trim($parent_category_name));
		$parent_category = new FreshRSS_Category($parent_category_name);
		$parent_category_name = $parent_category->name();

		if (!isset($categories_to_feeds[$parent_category_name])) {
			$categories_to_feeds[$parent_category_name] = [];
		}

		if (isset($outline['xmlUrl'])) {
			// The xmlUrl means it's a feed URL: add the outline to the array
			$categories_to_feeds[$parent_category_name][] = $outline;
		}

		return $categories_to_feeds;
	}
}
