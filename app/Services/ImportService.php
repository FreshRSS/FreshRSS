<?php

/**
 * Provide methods to import files.
 */
class FreshRSS_Import_Service {
	/** @var FreshRSS_CategoryDAO */
	private $catDAO;

	/** @var FreshRSS_FeedDAO */
	private $feedDAO;

	/** @var bool true if success, false otherwise */
	private $lastStatus;

	/**
	 * Initialize the service for the given user.
	 *
	 * @param string $username
	 */
	public function __construct($username = null) {
		require_once(LIB_PATH . '/lib_opml.php');

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
	 * @param FreshRSS_Category|null $parent_cat the name of the parent category.
	 * @param boolean $flatten true to disable categories, false otherwise.
	 * @return array<FreshRSS_Category>|false an array of categories containing some feeds, or false if an error occurred.
	 */
	public function importOpml(string $opml_file, $parent_cat = null, $flatten = false, $dryRun = false) {
		$this->lastStatus = true;
		$opml_array = array();
		try {
			$opml_array = libopml_parse_string($opml_file, false);
		} catch (LibOPML_Exception $e) {
			if (FreshRSS_Context::$isCli) {
				fwrite(STDERR, 'FreshRSS error during OPML parsing: ' . $e->getMessage() . "\n");
			} else {
				Minz_Log::warning($e->getMessage());
			}
			$this->lastStatus = false;
			return false;
		}

		return $this->addOpmlElements($opml_array['body'], $parent_cat, $flatten, $dryRun);
	}

	/**
	 * This method imports an OPML file based on its body.
	 *
	 * @param array $opml_elements an OPML element (body or outline).
	 * @param FreshRSS_Category|null $parent_cat the name of the parent category.
	 * @param boolean $flatten true to disable categories, false otherwise.
	 * @return array<FreshRSS_Category> an array of categories containing some feeds
	 */
	private function addOpmlElements($opml_elements, $parent_cat = null, $flatten = false, $dryRun = false) {
		$nb_feeds = count($this->feedDAO->listFeeds());
		$nb_cats = count($this->catDAO->listCategories(false));
		$limits = FreshRSS_Context::$system_conf->limits;

		//Sort with categories first
		usort($opml_elements, function ($a, $b) {
			return strcmp(
				(isset($a['xmlUrl']) ? 'Z' : 'A') . (isset($a['text']) ? $a['text'] : ''),
				(isset($b['xmlUrl']) ? 'Z' : 'A') . (isset($b['text']) ? $b['text'] : ''));
		});

		$categories = [];

		foreach ($opml_elements as $elt) {
			if (isset($elt['xmlUrl'])) {
				// If xmlUrl exists, it means it is a feed
				if (FreshRSS_Context::$isCli && $nb_feeds >= $limits['max_feeds']) {
					Minz_Log::warning(_t('feedback.sub.feed.over_max',
									  $limits['max_feeds']));
					$this->lastStatus = false;
					continue;
				}

				if ($this->addFeedOpml($elt, $parent_cat, $dryRun)) {
					$nb_feeds++;
				} else {
					$this->lastStatus = false;
				}
			} elseif (!empty($elt['text'])) {
				// No xmlUrl? It should be a category!
				$limit_reached = !$flatten && ($nb_cats >= $limits['max_categories']);
				if (!FreshRSS_Context::$isCli && $limit_reached) {
					Minz_Log::warning(_t('feedback.sub.category.over_max',
									  $limits['max_categories']));
					$this->lastStatus = false;
					$flatten = true;
				}

				$category = $this->addCategoryOpml($elt, $parent_cat, $flatten, $dryRun);

				if ($category) {
					$nb_cats++;
					$categories[] = $category;
				}
			}
		}

		return $categories;
	}

	/**
	 * This method imports an OPML feed element.
	 *
	 * @param array $feed_elt an OPML element (must be a feed element).
	 * @param FreshRSS_Category|null $parent_cat the name of the parent category.
	 * @return FreshRSS_Feed|null a feed.
	 */
	private function addFeedOpml($feed_elt, $parent_cat, $dryRun = false) {
		if ($parent_cat == null) {
			// This feed has no parent category so we get the default one
			$this->catDAO->checkDefault();
			$parent_cat = $this->catDAO->getDefault();
			if ($parent_cat == null) {
				$this->lastStatus = false;
				return null;
			}
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

		try {
			// Create a Feed object and add it in DB
			$feed = new FreshRSS_Feed($url);
			$feed->_categoryId($parent_cat->id());
			$parent_cat->addFeed($feed);
			$feed->_name($name);
			$feed->_website($website);
			$feed->_description($description);

			switch ($feed_elt['type'] ?? '') {
				case FreshRSS_Export_Service::TYPE_HTML_XPATH:
					$feed->_kind(FreshRSS_Feed::KIND_HTML_XPATH);
					break;
				case FreshRSS_Export_Service::TYPE_RSS_ATOM:
				default:
					$feed->_kind(FreshRSS_Feed::KIND_RSS);
					break;
			}

			$xPathSettings = [];
			foreach ($feed_elt as $key => $value) {
				if (is_array($value) && !empty($value['value']) && ($value['namespace'] ?? '') === FreshRSS_Export_Service::FRSS_NAMESPACE) {
					switch ($key) {
						case 'cssFullContent': $feed->_pathEntries($value['value']); break;
						case 'filtersActionRead': $feed->_filtersAction('read', preg_split('/[\n\r]+/', $value['value'])); break;
						case 'xPathItem': $xPathSettings['item'] = $value['value']; break;
						case 'xPathItemTitle': $xPathSettings['itemTitle'] = $value['value']; break;
						case 'xPathItemContent': $xPathSettings['itemContent'] = $value['value']; break;
						case 'xPathItemUri': $xPathSettings['itemUri'] = $value['value']; break;
						case 'xPathItemAuthor': $xPathSettings['itemAuthor'] = $value['value']; break;
						case 'xPathItemTimestamp': $xPathSettings['itemTimestamp'] = $value['value']; break;
						case 'xPathItemThumbnail': $xPathSettings['itemThumbnail'] = $value['value']; break;
						case 'xPathItemCategories': $xPathSettings['itemCategories'] = $value['value']; break;
					}
				}
			}
			if (!empty($xPathSettings)) {
				$feed->_attributes('xpath', $xPathSettings);
			}

			// Call the extension hook
			/** @var FreshRSS_Feed|null */
			$feed = Minz_ExtensionManager::callHook('feed_before_insert', $feed);
			if ($dryRun) {
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
			if (FreshRSS_Context::$isCli) {
				fwrite(STDERR, 'FreshRSS error during OPML feed import: ' . $e->getMessage() . "\n");
			} else {
				Minz_Log::warning($e->getMessage());
			}
			$this->lastStatus = false;
		}

		if (FreshRSS_Context::$isCli) {
			fwrite(STDERR, 'FreshRSS error during OPML feed import from URL: ' .
				SimplePie_Misc::url_remove_credentials($url) . ' in category ' . $parent_cat->id() . "\n");
		} else {
			Minz_Log::warning('Error during OPML feed import from URL: ' .
				SimplePie_Misc::url_remove_credentials($url) . ' in category ' . $parent_cat->id());
		}

		return null;
	}

	/**
	 * This method imports an OPML category element.
	 *
	 * @param array $cat_elt an OPML element (must be a category element).
	 * @param FreshRSS_Category|null $parent_cat the name of the parent category.
	 * @param boolean $flatten true to disable categories, false otherwise.
	 * @return FreshRSS_Category|null a new category containing some feeds, or null if no category was created, or false if an error occurred.
	 */
	private function addCategoryOpml($cat_elt, $parent_cat, $flatten = false, $dryRun = false) {
		$error = false;
		$cat = null;
		if (!$flatten) {
			$catName = Minz_Helper::htmlspecialchars_utf8($cat_elt['text']);
			$cat = new FreshRSS_Category($catName);

			foreach ($cat_elt as $key => $value) {
				if (is_array($value) && !empty($value['value']) && ($value['namespace'] ?? '') === FreshRSS_Export_Service::FRSS_NAMESPACE) {
					switch ($key) {
						case 'opmlUrl':
							$opml_url = checkUrl($value['value']);
							if ($opml_url != '') {
								$cat->_kind(FreshRSS_Category::KIND_DYNAMIC_OPML);
								$cat->_attributes('opml_url', $opml_url);
							}
							break;
					}
				}
			}

			if (!$dryRun) {
				$id = $this->catDAO->addCategoryObject($cat);
				if ($id == false) {
					$this->lastStatus = false;
					$error = true;
				} else {
					$cat->_id($id);
				}
			}
			if ($error) {
				if (FreshRSS_Context::$isCli) {
					fwrite(STDERR, 'FreshRSS error during OPML category import from URL: ' . $catName . "\n");
				} else {
					Minz_Log::warning('Error during OPML category import from URL: ' . $catName);
				}
			} else {
				$parent_cat = $cat;
			}
		}

		if (isset($cat_elt['@outlines'])) {
			// Our cat_elt contains more categories or more feeds, so we
			// add them recursively.
			// Note: FreshRSS does not support yet category arborescence, so always flatten from here
			$this->addOpmlElements($cat_elt['@outlines'], $parent_cat, true, $dryRun);
		}

		return $cat;
	}
}
