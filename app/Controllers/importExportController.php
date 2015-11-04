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

		$type_file = $this->guessFileType($file['name']);

		$list_files = array(
			'opml' => array(),
			'json_starred' => array(),
			'json_feed' => array()
		);

		// We try to list all files according to their type
		$list = array();
		if ($type_file === 'zip' && extension_loaded('zip')) {
			$zip = zip_open($file['tmp_name']);

			if (!is_resource($zip)) {
				// zip_open cannot open file: something is wrong
				Minz_Log::warning('Zip archive cannot be imported. Error code: ' . $zip);
				Minz_Request::bad(_t('feedback.import_export.zip_error'),
				                  array('c' => 'importExport', 'a' => 'index'));
			}

			while (($zipfile = zip_read($zip)) !== false) {
				if (!is_resource($zipfile)) {
					// zip_entry() can also return an error code!
					Minz_Log::warning('Zip file cannot be imported. Error code: ' . $zipfile);
				} else {
					$type_zipfile = $this->guessFileType(zip_entry_name($zipfile));
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
			// Zip extension is not loaded
			Minz_Request::bad(_t('feedback.import_export.no_zip_extension'),
			                  array('c' => 'importExport', 'a' => 'index'));
		} elseif ($type_file !== 'unknown') {
			$list_files[$type_file][] = file_get_contents($file['tmp_name']);
		}

		// Import file contents.
		// OPML first(so categories and feeds are imported)
		// Starred articles then so the "favourite" status is already set
		// And finally all other files.
		$error = false;
		foreach ($list_files['opml'] as $opml_file) {
			$error = $this->importOpml($opml_file);
		}
		foreach ($list_files['json_starred'] as $article_file) {
			$error = $this->importJson($article_file, true);
		}
		foreach ($list_files['json_feed'] as $article_file) {
			$error = $this->importJson($article_file);
		}

		// And finally, we get import status and redirect to the home page
		Minz_Session::_param('actualize_feeds', true);
		$content_notif = $error === true ? _t('feedback.import_export.feeds_imported_with_errors') :
		                                   _t('feedback.import_export.feeds_imported');
		Minz_Request::good($content_notif);
	}

	/**
	 * This method tries to guess the file type based on its name.
	 *
	 * Itis a *very* basic guess file type function. Only based on filename.
	 * That's could be improved but should be enough for what we have to do.
	 */
	private function guessFileType($filename) {
		if (substr_compare($filename, '.zip', -4) === 0) {
			return 'zip';
		} elseif (substr_compare($filename, '.opml', -5) === 0 ||
		          substr_compare($filename, '.xml', -4) === 0) {
			return 'opml';
		} elseif (substr_compare($filename, '.json', -5) === 0 &&
		          strpos($filename, 'starred') !== false) {
			return 'json_starred';
		} elseif (substr_compare($filename, '.json', -5) === 0) {
			return 'json_feed';
		} else {
			return 'unknown';
		}
	}

	/**
	 * This method parses and imports an OPML file.
	 *
	 * @param string $opml_file the OPML file content.
	 * @return boolean true if an error occured, false else.
	 */
	private function importOpml($opml_file) {
		$opml_array = array();
		try {
			$opml_array = libopml_parse_string($opml_file, false);
		} catch (LibOPML_Exception $e) {
			Minz_Log::warning($e->getMessage());
			return true;
		}

		$this->catDAO->checkDefault();

		return $this->addOpmlElements($opml_array['body']);
	}

	/**
	 * This method imports an OPML file based on its body.
	 *
	 * @param array $opml_elements an OPML element (body or outline).
	 * @param string $parent_cat the name of the parent category.
	 * @return boolean true if an error occured, false else.
	 */
	private function addOpmlElements($opml_elements, $parent_cat = null) {
		$error = false;

		$nb_feeds = count($this->feedDAO->listFeeds());
		$nb_cats = count($this->catDAO->listCategories(false));
		$limits = FreshRSS_Context::$system_conf->limits;

		foreach ($opml_elements as $elt) {
			$is_error = false;
			if (isset($elt['xmlUrl'])) {
				// If xmlUrl exists, it means it is a feed
				if ($nb_feeds >= $limits['max_feeds']) {
					Minz_Log::warning(_t('feedback.sub.feed.over_max',
					                  $limits['max_feeds']));
					$is_error = true;
					continue;
				}

				$is_error = $this->addFeedOpml($elt, $parent_cat);
				if (!$is_error) {
					$nb_feeds += 1;
				}
			} else {
				// No xmlUrl? It should be a category!
				$limit_reached = ($nb_cats >= $limits['max_categories']);
				if ($limit_reached) {
					Minz_Log::warning(_t('feedback.sub.category.over_max',
					                  $limits['max_categories']));
				}

				$is_error = $this->addCategoryOpml($elt, $parent_cat, $limit_reached);
				if (!$is_error) {
					$nb_cats += 1;
				}
			}

			if (!$error && $is_error) {
				// oops: there is at least one error!
				$error = $is_error;
			}
		}

		return $error;
	}

	/**
	 * This method imports an OPML feed element.
	 *
	 * @param array $feed_elt an OPML element (must be a feed element).
	 * @param string $parent_cat the name of the parent category.
	 * @return boolean true if an error occured, false else.
	 */
	private function addFeedOpml($feed_elt, $parent_cat) {
		$default_cat = $this->catDAO->getDefault();
		if (is_null($parent_cat)) {
			// This feed has no parent category so we get the default one
			$parent_cat = $default_cat->name();
		}

		$cat = $this->catDAO->searchByName($parent_cat);
		if (is_null($cat)) {
			// If there is not $cat, it means parent category does not exist in
			// database.
			// If it happens, take the default category.
			$cat = $default_cat;
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
			if (!is_null($feed)) {
				// addFeedObject checks if feed is already in DB so nothing else to
				// check here
				$id = $this->feedDAO->addFeedObject($feed);
				$error = ($id === false);
			} else {
				$error = true;
			}
		} catch (FreshRSS_Feed_Exception $e) {
			Minz_Log::warning($e->getMessage());
			$error = true;
		}

		return $error;
	}

	/**
	 * This method imports an OPML category element.
	 *
	 * @param array $cat_elt an OPML element (must be a category element).
	 * @param string $parent_cat the name of the parent category.
	 * @param boolean $cat_limit_reached indicates if category limit has been reached.
	 *                if yes, category is not added (but we try for feeds!)
	 * @return boolean true if an error occured, false else.
	 */
	private function addCategoryOpml($cat_elt, $parent_cat, $cat_limit_reached) {
		// Create a new Category object
		$cat = new FreshRSS_Category(Minz_Helper::htmlspecialchars_utf8($cat_elt['text']));

		$error = true;
		if (!$cat_limit_reached) {
			$id = $this->catDAO->addCategoryObject($cat);
			$error = ($id === false);
		}

		if (isset($cat_elt['@outlines'])) {
			// Our cat_elt contains more categories or more feeds, so we
			// add them recursively.
			// Note: FreshRSS does not support yet category arborescence
			$res = $this->addOpmlElements($cat_elt['@outlines'], $cat->name());
			if (!$error && $res) {
				$error = true;
			}
		}

		return $error;
	}

	/**
	 * This method import a JSON-based file (Google Reader format).
	 *
	 * @param string $article_file the JSON file content.
	 * @param boolean $starred true if articles from the file must be starred.
	 * @return boolean true if an error occured, false else.
	 */
	private function importJson($article_file, $starred = false) {
		$article_object = json_decode($article_file, true);
		if (is_null($article_object)) {
			Minz_Log::warning('Try to import a non-JSON file');
			return true;
		}

		$is_read = FreshRSS_Context::$user_conf->mark_when['reception'] ? 1 : 0;

		$google_compliant = strpos($article_object['id'], 'com.google') !== false;

		$error = false;
		$article_to_feed = array();

		$nb_feeds = count($this->feedDAO->listFeeds());
		$limits = FreshRSS_Context::$system_conf->limits;

		// First, we check feeds of articles are in DB (and add them if needed).
		foreach ($article_object['items'] as $item) {
			$key = $google_compliant ? 'htmlUrl' : 'feedUrl';
			$feed = new FreshRSS_Feed($item['origin'][$key]);
			$feed = $this->feedDAO->searchByUrl($feed->url());

			if (is_null($feed)) {
				// Feed does not exist in DB,we should to try to add it.
				if ($nb_feeds >= $limits['max_feeds']) {
					// Oops, no more place!
					Minz_Log::warning(_t('feedback.sub.feed.over_max', $limits['max_feeds']));
				} else {
					$feed = $this->addFeedJson($item['origin'], $google_compliant);
				}

				if (is_null($feed)) {
					// Still null? It means something went wrong.
					$error = true;
				} else {
					// Nice! Increase the counter.
					$nb_feeds += 1;
				}
			}

			if (!is_null($feed)) {
				$article_to_feed[$item['id']] = $feed->id();
			}
		}

		// Then, articles are imported.
		$this->entryDAO->beginTransaction();
		foreach ($article_object['items'] as $item) {
			if (!isset($article_to_feed[$item['id']])) {
				// Related feed does not exist for this entry, do nothing.
				continue;
			}

			$feed_id = $article_to_feed[$item['id']];
			$author = isset($item['author']) ? $item['author'] : '';
			$key_content = ($google_compliant && !isset($item['content'])) ?
			               'summary' : 'content';
			$tags = $item['categories'];
			if ($google_compliant) {
				// Remove tags containing "/state/com.google" which are useless.
				$tags = array_filter($tags, function($var) {
					return strpos($var, '/state/com.google') === false;
				});
			}

			$entry = new FreshRSS_Entry(
				$feed_id, $item['id'], $item['title'], $author,
				$item[$key_content]['content'], $item['alternate'][0]['href'],
				$item['published'], $is_read, $starred
			);
			$entry->_id(min(time(), $entry->date(true)) . uSecString());
			$entry->_tags($tags);

			$entry = Minz_ExtensionManager::callHook('entry_before_insert', $entry);
			if (is_null($entry)) {
				// An extension has returned a null value, there is nothing to insert.
				continue;
			}

			$values = $entry->toArray();
			$id = $this->entryDAO->addEntry($values);

			if (!$error && ($id === false)) {
				$error = true;
			}
		}
		$this->entryDAO->commit();

		return $error;
	}

	/**
	 * This method import a JSON-based feed (Google Reader format).
	 *
	 * @param array $origin represents a feed.
	 * @param boolean $google_compliant takes care of some specific values if true.
	 * @return FreshRSS_Feed if feed is in database at the end of the process,
	 *         else null.
	 */
	private function addFeedJson($origin, $google_compliant) {
		$default_cat = $this->catDAO->getDefault();

		$return = null;
		$key = $google_compliant ? 'htmlUrl' : 'feedUrl';
		$url = $origin[$key];
		$name = $origin['title'];
		$website = $origin['htmlUrl'];

		try {
			// Create a Feed object and add it in database.
			$feed = new FreshRSS_Feed($url);
			$feed->_category($default_cat->id());
			$feed->_name($name);
			$feed->_website($website);

			// Call the extension hook
			$feed = Minz_ExtensionManager::callHook('feed_before_insert', $feed);
			if (!is_null($feed)) {
				// addFeedObject checks if feed is already in DB so nothing else to
				// check here.
				$id = $this->feedDAO->addFeedObject($feed);

				if ($id !== false) {
					$feed->_id($id);
					$return = $feed;
				}
			}
		} catch (FreshRSS_Feed_Exception $e) {
			Minz_Log::warning($e->getMessage());
		}

		return $return;
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

		$export_opml = Minz_Request::param('export_opml', false);
		$export_starred = Minz_Request::param('export_starred', false);
		$export_feeds = Minz_Request::param('export_feeds', array());

		$export_files = array();
		if ($export_opml) {
			$export_files['feeds.opml'] = $this->generateOpml();
		}

		if ($export_starred) {
			$export_files['starred.json'] = $this->generateEntries('starred');
		}

		foreach ($export_feeds as $feed_id) {
			$feed = $this->feedDAO->searchById($feed_id);
			if ($feed) {
				$filename = 'feed_' . $feed->category() . '_'
				          . $feed->id() . '.json';
				$export_files[$filename] = $this->generateEntries('feed', $feed);
			}
		}

		$nb_files = count($export_files);
		if ($nb_files > 1) {
			// If there are more than 1 file to export, we need a zip archive.
			try {
				$this->exportZip($export_files);
			} catch (Exception $e) {
				# Oops, there is no Zip extension!
				Minz_Request::bad(_t('feedback.import_export.export_no_zip_extension'),
				                  array('c' => 'importExport', 'a' => 'index'));
			}
		} elseif ($nb_files === 1) {
			// Only one file? Guess its type and export it.
			$filename = key($export_files);
			$type = $this->guessFileType($filename);
			$this->exportFile('freshrss_' . $filename, $export_files[$filename], $type);
		} else {
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
	 * @param string $type must be "starred" or "feed"
	 * @param FreshRSS_Feed $feed feed of which we want to get entries.
	 * @return string the JSON file content.
	 */
	private function generateEntries($type, $feed = NULL) {
		$this->view->categories = $this->catDAO->listCategories();

		if ($type == 'starred') {
			$this->view->list_title = _t('sub.import_export.starred_list');
			$this->view->type = 'starred';
			$unread_fav = $this->entryDAO->countUnreadReadFavorites();
			$this->view->entries = $this->entryDAO->listWhere(
				's', '', FreshRSS_Entry::STATE_ALL, 'ASC', $unread_fav['all']
			);
		} elseif ($type == 'feed' && !is_null($feed)) {
			$this->view->list_title = _t('sub.import_export.feed_list', $feed->name());
			$this->view->type = 'feed/' . $feed->id();
			$this->view->entries = $this->entryDAO->listWhere(
				'f', $feed->id(), FreshRSS_Entry::STATE_ALL, 'ASC',
				FreshRSS_Context::$user_conf->posts_per_page
			);
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
	private function exportZip($files) {
		if (!extension_loaded('zip')) {
			throw new Exception();
		}

		// From https://stackoverflow.com/questions/1061710/php-zip-files-on-the-fly
		$zip_file = tempnam('tmp', 'zip');
		$zip = new ZipArchive();
		$zip->open($zip_file, ZipArchive::OVERWRITE);

		foreach ($files as $filename => $content) {
			$zip->addFromString($filename, $content);
		}

		// Close and send to user
		$zip->close();
		header('Content-Type: application/zip');
		header('Content-Length: ' . filesize($zip_file));
		header('Content-Disposition: attachment; filename="freshrss_export.zip"');
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
	private function exportFile($filename, $content, $type) {
		if ($type === 'unknown') {
			return;
		}

		$content_type = '';
		if ($type === 'opml') {
			$content_type = "text/opml";
		} elseif ($type === 'json_feed' || $type === 'json_starred') {
			$content_type = "text/json";
		}

		header('Content-Type: ' . $content_type . '; charset=utf-8');
		header('Content-disposition: attachment; filename=' . $filename);
		print($content);
	}
}
