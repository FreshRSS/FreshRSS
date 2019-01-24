<?php

/**
 * Controller to handle every import and export actions.
 */
class FreshRSS_importExport_Controller extends Minz_ActionController {
	/**
	 * This action is called before every other action in that class. It is
	 * the common boiler plate for every action. It is triggered by the
	 * underlying framework.
	 */
	public function firstAction() {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}

		require_once(LIB_PATH . '/lib_opml.php');

		$this->catDAO = new FreshRSS_CategoryDAO();
		$this->entryDAO = FreshRSS_Factory::createEntryDao();
		$this->feedDAO = FreshRSS_Factory::createFeedDao();
	}

	/**
	 * This action displays the main page for import / export system.
	 */
	public function indexAction() {
		$this->view->feeds = $this->feedDAO->listFeeds();
		Minz_View::prependTitle(_t('sub.import_export.title') . ' · ');
	}

	public function importFile($name, $path, $username = null) {
		require_once(LIB_PATH . '/lib_opml.php');

		$this->catDAO = new FreshRSS_CategoryDAO($username);
		$this->entryDAO = FreshRSS_Factory::createEntryDao($username);
		$this->feedDAO = FreshRSS_Factory::createFeedDao($username);

		$type_file = self::guessFileType($name);

		$list_files = array(
			'opml' => array(),
			'json_starred' => array(),
			'json_feed' => array(),
			'ttrss_starred' => array(),
		);

		// We try to list all files according to their type
		$list = array();
		if ($type_file === 'zip' && extension_loaded('zip')) {
			$zip = zip_open($path);
			if (!is_resource($zip)) {
				// zip_open cannot open file: something is wrong
				throw new FreshRSS_Zip_Exception($zip);
			}
			while (($zipfile = zip_read($zip)) !== false) {
				if (!is_resource($zipfile)) {
					// zip_entry() can also return an error code!
					throw new FreshRSS_Zip_Exception($zipfile);
				} else {
					$type_zipfile = self::guessFileType(zip_entry_name($zipfile));
					if ($type_file !== 'unknown') {
						$list_files[$type_zipfile][] = zip_entry_read(
							$zipfile,
							zip_entry_filesize($zipfile)
						);
					}
				}
			}
			zip_close($zip);
		} elseif ($type_file === 'zip') {
			// ZIP extension is not loaded
			throw new FreshRSS_ZipMissing_Exception();
		} elseif ($type_file !== 'unknown') {
			$list_files[$type_file][] = file_get_contents($path);
		}

		// Import file contents.
		// OPML first(so categories and feeds are imported)
		// Starred articles then so the "favourite" status is already set
		// And finally all other files.
		$ok = true;
		foreach ($list_files['opml'] as $opml_file) {
			if (!$this->importOpml($opml_file)) {
				$ok = false;
				if (FreshRSS_Context::$isCli) {
					fwrite(STDERR, 'FreshRSS error during OPML import' . "\n");
				} else {
					Minz_Log::warning('Error during OPML import');
				}
			}
		}
		foreach ($list_files['json_starred'] as $article_file) {
			if (!$this->importJson($article_file, true)) {
				$ok = false;
				if (FreshRSS_Context::$isCli) {
					fwrite(STDERR, 'FreshRSS error during JSON stars import' . "\n");
				} else {
					Minz_Log::warning('Error during JSON stars import');
				}
			}
		}
		foreach ($list_files['json_feed'] as $article_file) {
			if (!$this->importJson($article_file)) {
				$ok = false;
				if (FreshRSS_Context::$isCli) {
					fwrite(STDERR, 'FreshRSS error during JSON feeds import' . "\n");
				} else {
					Minz_Log::warning('Error during JSON feeds import');
				}
			}
		}
		foreach ($list_files['ttrss_starred'] as $article_file) {
			$json = $this->ttrssXmlToJson($article_file);
			if (!$this->importJson($json, true)) {
				$ok = false;
				if (FreshRSS_Context::$isCli) {
					fwrite(STDERR, 'FreshRSS error during TT-RSS articles import' . "\n");
				} else {
					Minz_Log::warning('Error during TT-RSS articles import');
				}
			}
		}

		return $ok;
	}

	/**
	 * This action handles import action.
	 *
	 * It must be reached by a POST request.
	 *
	 * Parameter is:
	 *   - file (default: nothing!)
	 * Available file types are: zip, json or xml.
	 */
	public function importAction() {
		if (!Minz_Request::isPost()) {
			Minz_Request::forward(array('c' => 'importExport', 'a' => 'index'), true);
		}

		$file = $_FILES['file'];
		$status_file = $file['error'];

		if ($status_file !== 0) {
			Minz_Log::warning('File cannot be uploaded. Error code: ' . $status_file);
			Minz_Request::bad(_t('feedback.import_export.file_cannot_be_uploaded'),
			                  array('c' => 'importExport', 'a' => 'index'));
		}

		@set_time_limit(300);

		$error = false;
		try {
			$error = !$this->importFile($file['name'], $file['tmp_name']);
		} catch (FreshRSS_ZipMissing_Exception $zme) {
			Minz_Request::bad(_t('feedback.import_export.no_zip_extension'),
				array('c' => 'importExport', 'a' => 'index'));
		} catch (FreshRSS_Zip_Exception $ze) {
			Minz_Log::warning('ZIP archive cannot be imported. Error code: ' . $ze->zipErrorCode());
			Minz_Request::bad(_t('feedback.import_export.zip_error'),
				array('c' => 'importExport', 'a' => 'index'));
		}

		// And finally, we get import status and redirect to the home page
		Minz_Session::_param('actualize_feeds', true);
		$content_notif = $error === true ? _t('feedback.import_export.feeds_imported_with_errors') : _t('feedback.import_export.feeds_imported');
		Minz_Request::good($content_notif);
	}

	/**
	 * This method tries to guess the file type based on its name.
	 *
	 * Itis a *very* basic guess file type function. Only based on filename.
	 * That's could be improved but should be enough for what we have to do.
	 */
	private static function guessFileType($filename) {
		if (substr_compare($filename, '.zip', -4) === 0) {
			return 'zip';
		} elseif (substr_compare($filename, '.opml', -5) === 0) {
			return 'opml';
		} elseif (substr_compare($filename, '.json', -5) === 0) {
			if (strpos($filename, 'starred') !== false) {
				return 'json_starred';
			} else {
				return 'json_feed';
			}
		} elseif (substr_compare($filename, '.xml', -4) === 0) {
			if (preg_match('/Tiny|tt-?rss/i', $filename)) {
				return 'ttrss_starred';
			} else {
				return 'opml';
			}
		}
		return 'unknown';
	}

	/**
	 * This method parses and imports an OPML file.
	 *
	 * @param string $opml_file the OPML file content.
	 * @return boolean false if an error occured, true otherwise.
	 */
	private function importOpml($opml_file) {
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
	 * @return boolean false if an error occured, true otherwise.
	 */
	private function addOpmlElements($opml_elements, $parent_cat = null) {
		$ok = true;

		$nb_feeds = count($this->feedDAO->listFeeds());
		$nb_cats = count($this->catDAO->listCategories(false));
		$limits = FreshRSS_Context::$system_conf->limits;

		foreach ($opml_elements as $elt) {
			if (isset($elt['xmlUrl'])) {
				// If xmlUrl exists, it means it is a feed
				if (FreshRSS_Context::$isCli && $nb_feeds >= $limits['max_feeds']) {
					Minz_Log::warning(_t('feedback.sub.feed.over_max',
									  $limits['max_feeds']));
					$ok = false;
					continue;
				}

				if ($this->addFeedOpml($elt, $parent_cat)) {
					$nb_feeds++;
				} else {
					$ok = false;
				}
			} else {
				// No xmlUrl? It should be a category!
				$limit_reached = ($nb_cats >= $limits['max_categories']);
				if (!FreshRSS_Context::$isCli && $limit_reached) {
					Minz_Log::warning(_t('feedback.sub.category.over_max',
									  $limits['max_categories']));
					$ok = false;
					continue;
				}

				if ($this->addCategoryOpml($elt, $parent_cat, $limit_reached)) {
					$nb_cats++;
				} else {
					$ok = false;
				}
			}
		}

		return $ok;
	}

	/**
	 * This method imports an OPML feed element.
	 *
	 * @param array $feed_elt an OPML element (must be a feed element).
	 * @param string $parent_cat the name of the parent category.
	 * @return boolean false if an error occured, true otherwise.
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
	 * @return boolean false if an error occured, true otherwise.
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

	private function ttrssXmlToJson($xml) {
		$table = (array)simplexml_load_string($xml, null, LIBXML_NOCDATA);
		$table['items'] = isset($table['article']) ? $table['article'] : array();
		unset($table['article']);
		for ($i = count($table['items']) - 1; $i >= 0; $i--) {
			$item = (array)($table['items'][$i]);
			$item['updated'] = isset($item['updated']) ? strtotime($item['updated']) : '';
			$item['published'] = $item['updated'];
			$item['content'] = array('content' => isset($item['content']) ? $item['content'] : '');
			$item['categories'] = isset($item['tag_cache']) ? array($item['tag_cache']) : array();
			if (!empty($item['marked'])) {
				$item['categories'][] = 'user/-/state/com.google/starred';
			}
			if (!empty($item['published'])) {
				$item['categories'][] = 'user/-/state/com.google/broadcast';
			}
			if (!empty($item['label_cache'])) {
				$labels_cache = json_decode($item['label_cache'], true);
				if (is_array($labels_cache)) {
					foreach ($labels_cache as $label_cache) {
						if (!empty($label_cache[1])) {
							$item['categories'][] = 'user/-/label/' . trim($label_cache[1]);
						}
					}
				}
			}
			$item['alternate'][0]['href'] = isset($item['link']) ? $item['link'] : '';
			$item['origin'] = array(
					'title' => isset($item['feed_title']) ? $item['feed_title'] : '',
					'feedUrl' => isset($item['feed_url']) ? $item['feed_url'] : '',
				);
			$item['id'] = isset($item['guid']) ? $item['guid'] : (isset($item['feed_url']) ? $item['feed_url'] : $item['published']);
			$table['items'][$i] = $item;
		}
		return json_encode($table);
	}

	/**
	 * This method import a JSON-based file (Google Reader format).
	 *
	 * @param string $article_file the JSON file content.
	 * @param boolean $starred true if articles from the file must be starred.
	 * @return boolean false if an error occured, true otherwise.
	 */
	private function importJson($article_file, $starred = false) {
		$article_object = json_decode($article_file, true);
		if ($article_object == null) {
			if (FreshRSS_Context::$isCli) {
				fwrite(STDERR, 'FreshRSS error trying to import a non-JSON file' . "\n");
			} else {
				Minz_Log::warning('Try to import a non-JSON file');
			}
			return false;
		}

		$mark_as_read = FreshRSS_Context::$user_conf->mark_when['reception'] ? 1 : 0;

		$google_compliant = strpos($article_object['id'], 'com.google') !== false;

		$error = false;
		$article_to_feed = array();

		$nb_feeds = count($this->feedDAO->listFeeds());
		$newFeedGuids = array();
		$limits = FreshRSS_Context::$system_conf->limits;

		// First, we check feeds of articles are in DB (and add them if needed).
		foreach ($article_object['items'] as $item) {
			$key = $google_compliant ? 'htmlUrl' : 'feedUrl';
			$feed = new FreshRSS_Feed($item['origin'][$key]);
			$feed = $this->feedDAO->searchByUrl($feed->url());

			if ($feed == null) {
				// Feed does not exist in DB,we should to try to add it.
				if ((!FreshRSS_Context::$isCli) && ($nb_feeds >= $limits['max_feeds'])) {
					// Oops, no more place!
					Minz_Log::warning(_t('feedback.sub.feed.over_max', $limits['max_feeds']));
				} else {
					$feed = $this->addFeedJson($item['origin']);
				}

				if ($feed == null) {
					// Still null? It means something went wrong.
					$error = true;
				} else {
					$nb_feeds++;
				}
			}

			if ($feed != null) {
				$article_to_feed[$item['id']] = $feed->id();
				if (!isset($newFeedGuids['f_' . $feed->id()])) {
					$newFeedGuids['f_' . $feed->id()] = array();
				}
				$newFeedGuids['f_' . $feed->id()][] = safe_ascii($item['id']);
			}
		}

		$tagDAO = FreshRSS_Factory::createTagDao();
		$labels = $tagDAO->listTags();
		$knownLabels = array();
		foreach ($labels as $label) {
			$knownLabels[$label->name()]['id'] = $label->id();
			$knownLabels[$label->name()]['articles'] = array();
		}
		unset($labels);

		// For each feed, check existing GUIDs already in database.
		$existingHashForGuids = array();
		foreach ($newFeedGuids as $feedId => $newGuids) {
			$existingHashForGuids[$feedId] = $this->entryDAO->listHashForFeedGuids(substr($feedId, 2), $newGuids);
		}
		unset($newFeedGuids);

		// Then, articles are imported.
		$newGuids = array();
		$this->entryDAO->beginTransaction();
		foreach ($article_object['items'] as $item) {
			if (empty($article_to_feed[$item['id']])) {
				// Related feed does not exist for this entry, do nothing.
				continue;
			}

			$feed_id = $article_to_feed[$item['id']];
			$author = isset($item['author']) ? $item['author'] : '';
			$is_starred = false;
			$is_read = null;
			$tags = $item['categories'];
			$labels = array();
			for ($i = count($tags) - 1; $i >= 0; $i --) {
				$tag = trim($tags[$i]);
				if (strpos($tag, 'user/-/') !== false) {
					if ($tag === 'user/-/state/com.google/starred') {
						$is_starred = true;
					} elseif ($tag === 'user/-/state/com.google/read') {
						$is_read = true;
					} elseif ($tag === 'user/-/state/com.google/unread') {
						$is_read = false;
					} elseif (strpos($tag, 'user/-/label/') === 0) {
						$tag = trim(substr($tag, 13));
						if ($tag != '') {
							$labels[] = $tag;
						}
					}
					unset($tags[$i]);
				}
			}
			if ($starred && !$is_starred) {
				//If the article has no label, mark it as starred (old format)
				$is_starred = empty($labels);
			}
			if ($is_read === null) {
				$is_read = $mark_as_read;
			}

			$url = $item['alternate'][0]['href'];
			if (!empty($item['content']['content'])) {
				$content = $item['content']['content'];
			} elseif (!empty($item['summary']['content'])) {
				$content = $item['summary']['content'];
			}
			$content = sanitizeHTML($content, $url);

			$entry = new FreshRSS_Entry(
				$feed_id, $item['id'], $item['title'], $author,
				$content, $url,
				$item['published'], $is_read, $is_starred
			);
			$entry->_id(min(time(), $entry->date(true)) . uSecString());
			$entry->_tags($tags);

			if (isset($newGuids[$entry->guid()])) {
				continue;	//Skip subsequent articles with same GUID
			}
			$newGuids[$entry->guid()] = true;

			$entry = Minz_ExtensionManager::callHook('entry_before_insert', $entry);
			if ($entry == null) {
				// An extension has returned a null value, there is nothing to insert.
				continue;
			}

			$values = $entry->toArray();
			$ok = false;
			if (isset($existingHashForGuids['f_' . $feed_id][$entry->guid()])) {
				$ok = $this->entryDAO->updateEntry($values);
			} else {
				$ok = $this->entryDAO->addEntry($values);
			}

			foreach ($labels as $labelName) {
				if (empty($knownLabels[$labelName]['id'])) {
					$labelId = $tagDAO->addTag(array('name' => $labelName));
					$knownLabels[$labelName]['id'] = $labelId;
					$knownLabels[$labelName]['articles'] = array();
				}
				$knownLabels[$labelName]['articles'][] = array(
						//'id' => $entry->id(),	//ID changes after commitNewEntries()
						'id_feed' => $entry->feed(),
						'guid' => $entry->guid(),
					);
			}

			$error |= ($ok === false);
		}
		$this->entryDAO->commit();

		$this->entryDAO->beginTransaction();
		$this->entryDAO->commitNewEntries();
		$this->feedDAO->updateCachedValues();
		$this->entryDAO->commit();

		$this->entryDAO->beginTransaction();
		foreach ($knownLabels as $labelName => $knownLabel) {
			$labelId = $knownLabel['id'];
			foreach ($knownLabel['articles'] as $article) {
				$entryId = $this->entryDAO->searchIdByGuid($article['id_feed'], $article['guid']);
				if ($entryId != null) {
					$tagDAO->tagEntry($labelId, $entryId);
				} else {
					Minz_Log::warning('Could not add label "' . $labelName . '" to entry "' . $article['guid'] . '" in feed ' . $article['id_feed']);
				}
			}
		}
		$this->entryDAO->commit();

		return !$error;
	}

	/**
	 * This method import a JSON-based feed (Google Reader format).
	 *
	 * @param array $origin represents a feed.
	 * @return FreshRSS_Feed if feed is in database at the end of the process,
	 *         else null.
	 */
	private function addFeedJson($origin) {
		$return = null;
		if (!empty($origin['feedUrl'])) {
			$url = $origin['feedUrl'];
		} elseif (!empty($origin['htmlUrl'])) {
			$url = $origin['htmlUrl'];
		} else {
			return null;
		}
		if (!empty($origin['htmlUrl'])) {
			$website = $origin['htmlUrl'];
		} elseif (!empty($origin['feedUrl'])) {
			$website = $origin['feedUrl'];
		}
		$name = empty($origin['title']) ? '' : $origin['title'];

		try {
			// Create a Feed object and add it in database.
			$feed = new FreshRSS_Feed($url);
			$feed->_category(FreshRSS_CategoryDAO::DEFAULTCATEGORYID);
			$feed->_name($name);
			$feed->_website($website);

			// Call the extension hook
			$feed = Minz_ExtensionManager::callHook('feed_before_insert', $feed);
			if ($feed != null) {
				// addFeedObject checks if feed is already in DB so nothing else to
				// check here.
				$id = $this->feedDAO->addFeedObject($feed);

				if ($id !== false) {
					$feed->_id($id);
					$return = $feed;
				}
			}
		} catch (FreshRSS_Feed_Exception $e) {
			if (FreshRSS_Context::$isCli) {
				fwrite(STDERR, 'FreshRSS error during JSON feed import: ' . $e->getMessage() . "\n");
			} else {
				Minz_Log::warning($e->getMessage());
			}
		}

		return $return;
	}

	public function exportFile($export_opml = true, $export_starred = false, $export_labelled = false, $export_feeds = array(), $maxFeedEntries = 50, $username = null) {
		require_once(LIB_PATH . '/lib_opml.php');

		$this->catDAO = new FreshRSS_CategoryDAO($username);
		$this->entryDAO = FreshRSS_Factory::createEntryDao($username);
		$this->feedDAO = FreshRSS_Factory::createFeedDao($username);

		$this->entryDAO->disableBuffering();

		if ($export_feeds === true) {
			//All feeds
			$export_feeds = $this->feedDAO->listFeedsIds();
		}
		if (!is_array($export_feeds)) {
			$export_feeds = array();
		}

		$day = date('Y-m-d');

		$export_files = array();
		if ($export_opml) {
			$export_files["feeds_${day}.opml.xml"] = $this->generateOpml();
		}

		if ($export_starred || $export_labelled) {
			$export_files["starred_${day}.json"] = $this->generateEntries(
				($export_starred ? 'S' : '') .
				($export_labelled ? 'T' : '')
			);
		}

		foreach ($export_feeds as $feed_id) {
			$feed = $this->feedDAO->searchById($feed_id);
			if ($feed) {
				$filename = "feed_${day}_" . $feed->category() . '_'
				          . $feed->id() . '.json';
				$export_files[$filename] = $this->generateEntries('f', $feed, $maxFeedEntries);
			}
		}

		$nb_files = count($export_files);
		if ($nb_files > 1) {
			// If there are more than 1 file to export, we need a ZIP archive.
			try {
				$this->sendZip($export_files);
			} catch (Exception $e) {
				throw new FreshRSS_ZipMissing_Exception($e);
			}
		} elseif ($nb_files === 1) {
			// Only one file? Guess its type and export it.
			$filename = key($export_files);
			$type = self::guessFileType($filename);
			$this->sendFile('freshrss_' . Minz_Session::param('currentUser', '_') . '_' . $filename, $export_files[$filename], $type);
		}
		return $nb_files;
	}

	/**
	 * This action handles export action.
	 *
	 * This action must be reached by a POST request.
	 *
	 * Parameters are:
	 *   - export_opml (default: false)
	 *   - export_starred (default: false)
	 *   - export_feeds (default: array()) a list of feed ids
	 */
	public function exportAction() {
		if (!Minz_Request::isPost()) {
			Minz_Request::forward(array('c' => 'importExport', 'a' => 'index'), true);
		}
		$this->view->_useLayout(false);

		$nb_files = 0;
		try {
			$nb_files = $this->exportFile(
					Minz_Request::param('export_opml', false),
					Minz_Request::param('export_starred', false),
					Minz_Request::param('export_labelled', false),
					Minz_Request::param('export_feeds', array())
				);
		} catch (FreshRSS_ZipMissing_Exception $zme) {
			# Oops, there is no ZIP extension!
			Minz_Request::bad(_t('feedback.import_export.export_no_zip_extension'),
			                  array('c' => 'importExport', 'a' => 'index'));
		}

		if ($nb_files < 1) {
			// Nothing to do...
			Minz_Request::forward(array('c' => 'importExport', 'a' => 'index'), true);
		}
	}

	/**
	 * This method returns the OPML file based on user subscriptions.
	 *
	 * @return string the OPML file content.
	 */
	private function generateOpml() {
		$list = array();
		foreach ($this->catDAO->listCategories() as $key => $cat) {
			$list[$key]['name'] = $cat->name();
			$list[$key]['feeds'] = $this->feedDAO->listByCategory($cat->id());
		}

		$this->view->categories = $list;
		return $this->view->helperToString('export/opml');
	}

	/**
	 * This method returns a JSON file content.
	 *
	 * @param string $type must be one of:
	 * 	'S' (starred/favourite), 'f' (feed), 'T' (taggued/labelled), 'ST' (starred or labelled)
	 * @param FreshRSS_Feed $feed feed of which we want to get entries.
	 * @return string the JSON file content.
	 */
	private function generateEntries($type, $feed = null, $maxFeedEntries = 50) {
		$this->view->categories = $this->catDAO->listCategories();
		$tagDAO = FreshRSS_Factory::createTagDao();

		if ($type === 's' || $type === 'S' || $type === 'T' || $type === 'ST') {
			$this->view->list_title = _t('sub.import_export.starred_list');
			$this->view->type = 'starred';
			$this->view->entriesId = $this->entryDAO->listIdsWhere($type, '', FreshRSS_Entry::STATE_ALL, 'ASC', -1);
			$this->view->entryIdsTagNames = $tagDAO->getEntryIdsTagNames($this->view->entriesId);
			//The following is a streamable query, i.e. must be last
			$this->view->entriesRaw = $this->entryDAO->listWhereRaw($type, '', FreshRSS_Entry::STATE_ALL, 'ASC', -1);
		} elseif ($type === 'f' && $feed != null) {
			$this->view->list_title = _t('sub.import_export.feed_list', $feed->name());
			$this->view->type = 'feed/' . $feed->id();
			$this->view->entriesId = $this->entryDAO->listIdsWhere($type, $feed->id(), FreshRSS_Entry::STATE_ALL, 'ASC', $maxFeedEntries);
			$this->view->entryIdsTagNames = $tagDAO->getEntryIdsTagNames($this->view->entriesId);
			//The following is a streamable query, i.e. must be last
			$this->view->entriesRaw = $this->entryDAO->listWhereRaw($type, $feed->id(), FreshRSS_Entry::STATE_ALL, 'ASC', $maxFeedEntries);
			$this->view->feed = $feed;
		}

		return $this->view->helperToString('export/articles');
	}

	/**
	 * This method zips a list of files and returns it by HTTP.
	 *
	 * @param array $files list of files where key is filename and value the content.
	 * @throws Exception if Zip extension is not loaded.
	 */
	private function sendZip($files) {
		if (!extension_loaded('zip')) {
			throw new Exception();
		}

		// From https://stackoverflow.com/questions/1061710/php-zip-files-on-the-fly
		$zip_file = @tempnam('/tmp', 'zip');
		$zip = new ZipArchive();
		$zip->open($zip_file, ZipArchive::OVERWRITE);

		foreach ($files as $filename => $content) {
			$zip->addFromString($filename, $content);
		}

		// Close and send to user
		$zip->close();
		header('Content-Type: application/zip');
		header('Content-Length: ' . filesize($zip_file));
		$day = date('Y-m-d');
		header('Content-Disposition: attachment; filename="freshrss_' . Minz_Session::param('currentUser', '_') . '_' . $day . '_export.zip"');
		readfile($zip_file);
		unlink($zip_file);
	}

	/**
	 * This method returns a single file (OPML or JSON) by HTTP.
	 *
	 * @param string $filename
	 * @param string $content
	 * @param string $type the file type (opml, json_feed or json_starred).
	 *                     If equals to unknown, nothing happens.
	 */
	private function sendFile($filename, $content, $type) {
		if ($type === 'unknown') {
			return;
		}

		$content_type = '';
		if ($type === 'opml') {
			$content_type = 'application/xml';
		} elseif ($type === 'json_feed' || $type === 'json_starred') {
			$content_type = 'application/json';
		}

		header('Content-Type: ' . $content_type . '; charset=utf-8');
		header('Content-disposition: attachment; filename=' . $filename);
		print($content);
	}
}
