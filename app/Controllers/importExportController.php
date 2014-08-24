<?php

class FreshRSS_importExport_Controller extends Minz_ActionController {
	public function firstAction() {
		if (!$this->view->loginOk) {
			Minz_Error::error(
				403,
				array('error' => array(_t('access_denied')))
			);
		}

		require_once(LIB_PATH . '/lib_opml.php');

		$this->catDAO = new FreshRSS_CategoryDAO();
		$this->entryDAO = FreshRSS_Factory::createEntryDao();
		$this->feedDAO = FreshRSS_Factory::createFeedDao();
	}

	public function indexAction() {
		$this->view->categories = $this->catDAO->listCategories();
		$this->view->feeds = $this->feedDAO->listFeeds();

		Minz_View::prependTitle(_t('import_export') . ' · ');
	}

	public function importAction() {
		if (!Minz_Request::isPost()) {
			Minz_Request::forward(array('c' => 'importExport', 'a' => 'index'), true);
		}

		$file = $_FILES['file'];
		$status_file = $file['error'];

		if ($status_file !== 0) {
			Minz_Log::error('File cannot be uploaded. Error code: ' . $status_file);
			Minz_Request::bad(_t('file_cannot_be_uploaded'),
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
				Minz_Log::error('Zip archive cannot be imported. Error code: ' . $zip);
				Minz_Request::bad(_t('zip_error'),
				                  array('c' => 'importExport', 'a' => 'index'));
			}

			while (($zipfile = zip_read($zip)) !== false) {
				if (!is_resource($zipfile)) {
					// zip_entry() can also return an error code!
					Minz_Log::error('Zip file cannot be imported. Error code: ' . $zipfile);
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
			Minz_Request::bad(_t('no_zip_extension'),
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
			$error = $this->importArticles($article_file, true);
		}
		foreach ($list_files['json_feed'] as $article_file) {
			$error = $this->importArticles($article_file);
		}

		// And finally, we get import status and redirect to the home page
		Minz_Session::_param('actualize_feeds', true);
		$content_notif = $error === true ? _t('feeds_imported_with_errors') :
		                                   _t('feeds_imported');
		Minz_Request::good($content_notif);
	}

	private function guessFileType($filename) {
		// A *very* basic guess file type function. Only based on filename
		// That's could be improved but should be enough, at least for a first
		// implementation.
		// TODO: improve this function?

		if (substr_compare($filename, '.zip', -4) === 0) {
			return 'zip';
		} elseif (substr_compare($filename, '.opml', -5) === 0 ||
		          substr_compare($filename, '.xml', -4) === 0) {
			return 'opml';
		} elseif (substr_compare($filename, '.json', -5) === 0 &&
		          strpos($filename, 'starred') !== false) {
			return 'json_starred';
		} elseif (substr_compare($filename, '.json', -5) === 0 &&
		          strpos($filename, 'feed_') === 0) {
			return 'json_feed';
		} else {
			return 'unknown';
		}
	}

	private function importOpml($opml_file) {
		$opml_array = array();
		try {
			$opml_array = libopml_parse_string($opml_file);
		} catch (LibOPML_Exception $e) {
			Minz_Log::warning($e->getMessage());
			return true;
		}

		$this->catDAO->checkDefault();

		return $this->addOpmlElements($opml_array['body']);
	}

	private function addOpmlElements($opml_elements, $parent_cat = null) {
		$error = false;
		foreach ($opml_elements as $elt) {
			$res = false;
			if (isset($elt['xmlUrl'])) {
				$res = $this->addFeedOpml($elt, $parent_cat);
			} else {
				$res = $this->addCategoryOpml($elt, $parent_cat);
			}

			if (!$error && $res) {
				// oops: there is at least one error!
				$error = $res;
			}
		}

		return $error;
	}

	private function addFeedOpml($feed_elt, $parent_cat) {
		if (is_null($parent_cat)) {
			// This feed has no parent category so we get the default one
			$parent_cat = $this->catDAO->getDefault()->name();
		}

		$cat = $this->catDAO->searchByName($parent_cat);

		if (!$cat) {
			return true;
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

			// addFeedObject checks if feed is already in DB so nothing else to
			// check here
			$id = $this->feedDAO->addFeedObject($feed);
			$error = ($id === false);
		} catch (FreshRSS_Feed_Exception $e) {
			Minz_Log::warning($e->getMessage());
			$error = true;
		}

		return $error;
	}

	private function addCategoryOpml($cat_elt, $parent_cat) {
		// Create a new Category object
		$cat = new FreshRSS_Category(Minz_Helper::htmlspecialchars_utf8($cat_elt['text']));

		$id = $this->catDAO->addCategoryObject($cat);
		$error = ($id === false);

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

	private function importArticles($article_file, $starred = false) {
		$article_object = json_decode($article_file, true);
		if (is_null($article_object)) {
			Minz_Log::warning('Try to import a non-JSON file');
			return true;
		}

		$is_read = $this->view->conf->mark_when['reception'] ? 1 : 0;

		$google_compliant = (
			strpos($article_object['id'], 'com.google') !== false
		);

		$error = false;
		foreach ($article_object['items'] as $item) {
			$feed = $this->addFeedArticles($item['origin'], $google_compliant);
			if (is_null($feed)) {
				$error = true;
				continue;
			}

			$author = isset($item['author']) ? $item['author'] : '';
			$key_content = ($google_compliant && !isset($item['content'])) ?
			               'summary' : 'content';
			$tags = $item['categories'];
			if ($google_compliant) {
				$tags = array_filter($tags, function($var) {
					return strpos($var, '/state/com.google') === false;
				});
			}

			$entry = new FreshRSS_Entry(
				$feed->id(), $item['id'], $item['title'], $author,
				$item[$key_content]['content'], $item['alternate'][0]['href'],
				$item['published'], $is_read, $starred
			);
			$entry->_tags($tags);

			//FIME: Use entryDAO->addEntryPrepare(). Do not call entryDAO->listLastGuidsByFeed() for each entry. Consider using a transaction.
			$id = $this->entryDAO->addEntryObject(
				$entry, $this->view->conf, $feed->keepHistory()
			);

			if (!$error && ($id === false)) {
				$error = true;
			}
		}

		return $error;
	}

	private function addFeedArticles($origin, $google_compliant) {
		$default_cat = $this->catDAO->getDefault();

		$return = null;
		$key = $google_compliant ? 'htmlUrl' : 'feedUrl';
		$url = $origin[$key];
		$name = $origin['title'];
		$website = $origin['htmlUrl'];

		try {
			// Create a Feed object and add it in DB
			$feed = new FreshRSS_Feed($url);
			$feed->_category($default_cat->id());
			$feed->_name($name);
			$feed->_website($website);

			// addFeedObject checks if feed is already in DB so nothing else to
			// check here
			$id = $this->feedDAO->addFeedObject($feed);

			if ($id !== false) {
				$feed->_id($id);
				$return = $feed;
			}
		} catch (FreshRSS_Feed_Exception $e) {
			Minz_Log::warning($e->getMessage());
		}

		return $return;
	}

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
			$export_files['starred.json'] = $this->generateArticles('starred');
		}

		foreach ($export_feeds as $feed_id) {
			$feed = $this->feedDAO->searchById($feed_id);
			if ($feed) {
				$filename = 'feed_' . $feed->category() . '_'
				          . $feed->id() . '.json';
				$export_files[$filename] = $this->generateArticles(
					'feed', $feed
				);
			}
		}

		$nb_files = count($export_files);
		if ($nb_files > 1) {
			// If there are more than 1 file to export, we need a zip archive.
			try {
				$this->exportZip($export_files);
			} catch (Exception $e) {
				# Oops, there is no Zip extension!
				Minz_Request::bad(_t('export_no_zip_extension'),
				                  array('c' => 'importExport', 'a' => 'index'));
			}
		} elseif ($nb_files === 1) {
			// Only one file? Guess its type and export it.
			$filename = key($export_files);
			$type = $this->guessFileType($filename);
			$this->exportFile('freshrss_' . $filename, $export_files[$filename], $type);
		} else {
			Minz_Request::forward(array('c' => 'importExport', 'a' => 'index'), true);
		}
	}

	private function generateOpml() {
		$list = array();
		foreach ($this->catDAO->listCategories() as $key => $cat) {
			$list[$key]['name'] = $cat->name();
			$list[$key]['feeds'] = $this->feedDAO->listByCategory($cat->id());
		}

		$this->view->categories = $list;
		return $this->view->helperToString('export/opml');
	}

	private function generateArticles($type, $feed = NULL) {
		$this->view->categories = $this->catDAO->listCategories();

		if ($type == 'starred') {
			$this->view->list_title = _t('starred_list');
			$this->view->type = 'starred';
			$unread_fav = $this->entryDAO->countUnreadReadFavorites();
			$this->view->entries = $this->entryDAO->listWhere(
				's', '', FreshRSS_Entry::STATE_ALL, 'ASC',
				$unread_fav['all']
			);
		} elseif ($type == 'feed' && !is_null($feed)) {
			$this->view->list_title = _t('feed_list', $feed->name());
			$this->view->type = 'feed/' . $feed->id();
			$this->view->entries = $this->entryDAO->listWhere(
				'f', $feed->id(), FreshRSS_Entry::STATE_ALL, 'ASC',
				$this->view->conf->posts_per_page
			);
			$this->view->feed = $feed;
		}

		return $this->view->helperToString('export/articles');
	}

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
