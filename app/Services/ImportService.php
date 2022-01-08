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
		require_once(LIB_PATH . '/lib_opml.php');

		$this->catDAO = FreshRSS_Factory::createCategoryDao($username);
		$this->feedDAO = FreshRSS_Factory::createFeedDao($username);
	}

	/**
	 * This method parses and imports an OPML file.
	 *
	 * @param string $opml_file the OPML file content.
	 * @return boolean false if an error occurred, true otherwise.
	 */
	public function importOpml($opml_file) {
		$opml_array = array();
		try {
			$opml_array = libopml_parse_string($opml_file, false);
		} catch (LibOPML_Exception $e) {
			if (FreshRSS_Context::$isCli) {
				fwrite(STDERR, 'FreshRSS error during OPML parsing: ' . $e->getMessage() . "\n");
			} else {
				Minz_Log::warning($e->getMessage());
			}
			return false;
		}

		$this->catDAO->checkDefault();

		return $this->addOpmlElements($opml_array['body']);
	}

	/**
	 * This method imports an OPML file based on its body.
	 *
	 * @param array $opml_elements an OPML element (body or outline).
	 * @param string $parent_cat the name of the parent category.
	 * @return boolean false if an error occurred, true otherwise.
	 */
	private function addOpmlElements($opml_elements, $parent_cat = null) {
		$isOkStatus = true;

		$nb_feeds = count($this->feedDAO->listFeeds());
		$nb_cats = count($this->catDAO->listCategories(false));
		$limits = FreshRSS_Context::$system_conf->limits;

		//Sort with categories first
		usort($opml_elements, function ($a, $b) {
			return strcmp(
				(isset($a['xmlUrl']) ? 'Z' : 'A') . (isset($a['text']) ? $a['text'] : ''),
				(isset($b['xmlUrl']) ? 'Z' : 'A') . (isset($b['text']) ? $b['text'] : ''));
		});

		foreach ($opml_elements as $elt) {
			if (isset($elt['xmlUrl'])) {
				// If xmlUrl exists, it means it is a feed
				if (FreshRSS_Context::$isCli && $nb_feeds >= $limits['max_feeds']) {
					Minz_Log::warning(_t('feedback.sub.feed.over_max',
									  $limits['max_feeds']));
					$isOkStatus = false;
					continue;
				}

				if ($this->addFeedOpml($elt, $parent_cat)) {
					$nb_feeds++;
				} else {
					$isOkStatus = false;
				}
			} elseif (!empty($elt['text'])) {
				// No xmlUrl? It should be a category!
				$limit_reached = ($nb_cats >= $limits['max_categories']);
				if (!FreshRSS_Context::$isCli && $limit_reached) {
					Minz_Log::warning(_t('feedback.sub.category.over_max',
									  $limits['max_categories']));
					$isOkStatus = false;
					continue;
				}

				if ($this->addCategoryOpml($elt, $parent_cat, $limit_reached)) {
					$nb_cats++;
				} else {
					$isOkStatus = false;
				}
			}
		}

		return $isOkStatus;
	}

	/**
	 * This method imports an OPML feed element.
	 *
	 * @param array $feed_elt an OPML element (must be a feed element).
	 * @param string $parent_cat the name of the parent category.
	 * @return boolean false if an error occurred, true otherwise.
	 */
	private function addFeedOpml($feed_elt, $parent_cat) {
		if ($parent_cat == null) {
			// This feed has no parent category so we get the default one
			$this->catDAO->checkDefault();
			$default_cat = $this->catDAO->getDefault();
			$parent_cat = $default_cat->name();
		}

		$cat = $this->catDAO->searchByName($parent_cat);
		if ($cat == null) {
			// If there is not $cat, it means parent category does not exist in
			// database.
			// If it happens, take the default category.
			$this->catDAO->checkDefault();
			$cat = $this->catDAO->getDefault();
		}

		// We get different useful information
		$url = Minz_Helper::htmlspecialchars_utf8($feed_elt['xmlUrl']);
		$name = Minz_Helper::htmlspecialchars_utf8($feed_elt['text']);
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
			$feed->_category($cat->id());
			$feed->_name($name);
			$feed->_website($website);
			$feed->_description($description);

			// Call the extension hook
			$feed = Minz_ExtensionManager::callHook('feed_before_insert', $feed);
			if ($feed != null) {
				// addFeedObject checks if feed is already in DB so nothing else to
				// check here
				$id = $this->feedDAO->addFeedObject($feed);
				$error = ($id === false);
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
				fwrite(STDERR, 'FreshRSS error during OPML feed import from URL: ' . $url . ' in category ' . $cat->id() . "\n");
			} else {
				Minz_Log::warning('Error during OPML feed import from URL: ' . $url . ' in category ' . $cat->id());
			}
		}

		return !$error;
	}

	/**
	 * This method imports an OPML category element.
	 *
	 * @param array $cat_elt an OPML element (must be a category element).
	 * @param string $parent_cat the name of the parent category.
	 * @param boolean $cat_limit_reached indicates if category limit has been reached.
	 *                if yes, category is not added (but we try for feeds!)
	 * @return boolean false if an error occurred, true otherwise.
	 */
	private function addCategoryOpml($cat_elt, $parent_cat, $cat_limit_reached) {
		// Create a new Category object
		$catName = Minz_Helper::htmlspecialchars_utf8($cat_elt['text']);
		$cat = new FreshRSS_Category($catName);

		$error = true;
		if (FreshRSS_Context::$isCli || !$cat_limit_reached) {
			$id = $this->catDAO->addCategoryObject($cat);
			$error = ($id === false);
		}
		if ($error) {
			if (FreshRSS_Context::$isCli) {
				fwrite(STDERR, 'FreshRSS error during OPML category import from URL: ' . $catName . "\n");
			} else {
				Minz_Log::warning('Error during OPML category import from URL: ' . $catName);
			}
		}

		if (isset($cat_elt['@outlines'])) {
			// Our cat_elt contains more categories or more feeds, so we
			// add them recursively.
			// Note: FreshRSS does not support yet category arborescence
			$error &= !$this->addOpmlElements($cat_elt['@outlines'], $catName);
		}

		return !$error;
	}
}
