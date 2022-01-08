<?php

/**
 * Controller to handle every import and export actions.
 */
class FreshRSS_importExport_Controller extends FreshRSS_ActionController {

	private $entryDAO;
	private $feedDAO;

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

		$this->entryDAO = FreshRSS_Factory::createEntryDao();
		$this->feedDAO = FreshRSS_Factory::createFeedDao();
	}

	/**
	 * This action displays the main page for import / export system.
	 */
	public function indexAction() {
		$this->view->feeds = $this->feedDAO->listFeeds();
		FreshRSS_View::prependTitle(_t('sub.import_export.title') . ' · ');
	}

	private static function megabytes($size_str) {
		switch (substr($size_str, -1)) {
			case 'M': case 'm': return (int)$size_str;
			case 'K': case 'k': return (int)$size_str / 1024;
			case 'G': case 'g': return (int)$size_str * 1024;
		}
		return $size_str;
	}

	private static function minimumMemory($mb) {
		$mb = (int)$mb;
		$ini = self::megabytes(ini_get('memory_limit'));
		if ($ini < $mb) {
			ini_set('memory_limit', $mb . 'M');
		}
	}

	public function importFile($name, $path, $username = null) {
		self::minimumMemory(256);

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
		if ('zip' === $type_file && extension_loaded('zip')) {
			$zip = new ZipArchive();
			$result = $zip->open($path);
			if (true !== $result) {
				// zip_open cannot open file: something is wrong
				throw new FreshRSS_Zip_Exception($result);
			}
			for ($i = 0; $i < $zip->numFiles; $i++) {
				$type_zipfile = self::guessFileType($zip->getNameIndex($i));
				if ('unknown' !== $type_zipfile) {
					$list_files[$type_zipfile][] = $zip->getFromIndex($i);
				}
			}
			$zip->close();
		} elseif ('zip' === $type_file) {
			// ZIP extension is not loaded
			throw new FreshRSS_ZipMissing_Exception();
		} elseif ('unknown' !== $type_file) {
			$list_files[$type_file][] = file_get_contents($path);
		}

		// Import file contents.
		// OPML first(so categories and feeds are imported)
		// Starred articles then so the "favourite" status is already set
		// And finally all other files.
		$ok = true;

		$importService = new FreshRSS_Import_Service($username);

		foreach ($list_files['opml'] as $opml_file) {
			if (!$importService->importOpml($opml_file)) {
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
			Minz_Request::bad(_t('feedback.import_export.file_cannot_be_uploaded'), [ 'c' => 'importExport', 'a' => 'index' ]);
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
	 * It is a *very* basic guess file type function. Only based on filename.
	 * That could be improved but should be enough for what we have to do.
	 */
	private static function guessFileType($filename) {
		if (substr_compare($filename, '.zip', -4) === 0) {
			return 'zip';
		} elseif (stripos($filename, 'opml') !== false) {
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

	private function ttrssXmlToJson(string $xml) {
		$table = (array)simplexml_load_string($xml, null, LIBXML_NOBLANKS | LIBXML_NOCDATA);
		$table['items'] = isset($table['article']) ? $table['article'] : array();
		unset($table['article']);
		for ($i = count($table['items']) - 1; $i >= 0; $i--) {
			$item = (array)($table['items'][$i]);
			$item = array_filter($item, function ($v) {
					// Filter out empty properties, potentially reported as empty objects
					return (is_string($v) && trim($v) !== '') || !empty($v);
				});
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
		$items = isset($article_object['items']) ? $article_object['items'] : $article_object;

		$mark_as_read = FreshRSS_Context::$user_conf->mark_when['reception'] ? 1 : 0;

		$error = false;
		$article_to_feed = array();

		$nb_feeds = count($this->feedDAO->listFeeds());
		$newFeedGuids = array();
		$limits = FreshRSS_Context::$system_conf->limits;

		// First, we check feeds of articles are in DB (and add them if needed).
		foreach ($items as $item) {
			if (empty($item['id'])) {
				continue;
			}
			if (empty($item['origin'])) {
				$item['origin'] = [];
			}
			if (empty($item['origin']['title']) || trim($item['origin']['title']) === '') {
				$item['origin']['title'] = 'Import';
			}
			if (!empty($item['origin']['feedUrl'])) {
				$feedUrl = $item['origin']['feedUrl'];
			} elseif (!empty($item['origin']['streamId']) && strpos($item['origin']['streamId'], 'feed/') === 0) {
				$feedUrl = substr($item['origin']['streamId'], 5);	//Google Reader
				$item['origin']['feedUrl'] = $feedUrl;
			} elseif (!empty($item['origin']['htmlUrl'])) {
				$feedUrl = $item['origin']['htmlUrl'];
			} else {
				$feedUrl = 'http://import.localhost/import.xml';
				$item['origin']['feedUrl'] = $feedUrl;
				$item['origin']['disable'] = true;
			}
			$feed = new FreshRSS_Feed($feedUrl);
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
		foreach ($items as $item) {
			if (empty($item['id']) || empty($article_to_feed[$item['id']])) {
				// Related feed does not exist for this entry, do nothing.
				continue;
			}

			$feed_id = $article_to_feed[$item['id']];
			$author = isset($item['author']) ? $item['author'] : '';
			$is_starred = false;
			$is_read = null;
			$tags = empty($item['categories']) ? array() : $item['categories'];
			$labels = array();
			for ($i = count($tags) - 1; $i >= 0; $i--) {
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

			if (isset($item['alternate'][0]['href'])) {
				$url = $item['alternate'][0]['href'];
			} elseif (isset($item['url'])) {
				$url = $item['url'];	//FeedBin
			} else {
				$url = '';
			}

			$title = empty($item['title']) ? $url : $item['title'];

			if (!empty($item['content']['content'])) {
				$content = $item['content']['content'];
			} elseif (!empty($item['summary']['content'])) {
				$content = $item['summary']['content'];
			} elseif (!empty($item['content'])) {
				$content = $item['content'];	//FeedBin
			} else {
				$content = '';
			}
			$content = sanitizeHTML($content, $url);

			if (!empty($item['published'])) {
				$published = $item['published'];
			} elseif (!empty($item['timestampUsec'])) {
				$published = substr($item['timestampUsec'], 0, -6);
			} elseif (!empty($item['updated'])) {
				$published = $item['updated'];
			} else {
				$published = 0;
			}
			if (!ctype_digit('' . $published)) {
				$published = strtotime($published);
			}

			$entry = new FreshRSS_Entry(
				$feed_id, $item['id'], $title, $author,
				$content, $url, $published, $is_read, $is_starred
			);
			$entry->_id(uTimeString());
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
	 * @param array<string,string> $origin represents a feed.
	 * @return FreshRSS_Feed|null if feed is in database at the end of the process, else null.
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
		} else {
			$website = '';
		}
		$name = empty($origin['title']) ? $website : $origin['title'];

		try {
			// Create a Feed object and add it in database.
			$feed = new FreshRSS_Feed($url);
			$feed->_category(FreshRSS_CategoryDAO::DEFAULTCATEGORYID);
			$feed->_name($name);
			$feed->_website($website);
			if (!empty($origin['disable'])) {
				$feed->_ttl(-1 * FreshRSS_Context::$user_conf->ttl_default);
			}

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

	/**
	 * This action handles export action.
	 *
	 * This action must be reached by a POST request.
	 *
	 * Parameters are:
	 *   - export_opml (default: false)
	 *   - export_starred (default: false)
	 *   - export_labelled (default: false)
	 *   - export_feeds (default: array()) a list of feed ids
	 */
	public function exportAction() {
		if (!Minz_Request::isPost()) {
			return Minz_Request::forward(
				array('c' => 'importExport', 'a' => 'index'),
				true
			);
		}

		$username = Minz_Session::param('currentUser');
		$export_service = new FreshRSS_Export_Service($username);

		$export_opml = Minz_Request::param('export_opml', false);
		$export_starred = Minz_Request::param('export_starred', false);
		$export_labelled = Minz_Request::param('export_labelled', false);
		$export_feeds = Minz_Request::param('export_feeds', array());
		$max_number_entries = 50;

		$exported_files = [];

		if ($export_opml) {
			list($filename, $content) = $export_service->generateOpml();
			$exported_files[$filename] = $content;
		}

		// Starred and labelled entries are merged in the same `starred` file
		// to avoid duplication of content.
		if ($export_starred && $export_labelled) {
			list($filename, $content) = $export_service->generateStarredEntries('ST');
			$exported_files[$filename] = $content;
		} elseif ($export_starred) {
			list($filename, $content) = $export_service->generateStarredEntries('S');
			$exported_files[$filename] = $content;
		} elseif ($export_labelled) {
			list($filename, $content) = $export_service->generateStarredEntries('T');
			$exported_files[$filename] = $content;
		}

		foreach ($export_feeds as $feed_id) {
			$result = $export_service->generateFeedEntries($feed_id, $max_number_entries);
			if (!$result) {
				// It means the actual feed_id does not correspond to any existing feed
				continue;
			}

			list($filename, $content) = $result;
			$exported_files[$filename] = $content;
		}

		$nb_files = count($exported_files);
		if ($nb_files <= 0) {
			// There’s nothing to do, there’re no files to export
			return Minz_Request::forward(
				array('c' => 'importExport', 'a' => 'index'),
				true
			);
		}

		if ($nb_files === 1) {
			// If we only have one file, we just export it as it is
			$filename = key($exported_files);
			$content = $exported_files[$filename];
		} else {
			// More files? Let’s compress them in a Zip archive
			if (!extension_loaded('zip')) {
				// Oops, there is no ZIP extension!
				return Minz_Request::bad(
					_t('feedback.import_export.export_no_zip_extension'),
					array('c' => 'importExport', 'a' => 'index')
				);
			}

			list($filename, $content) = $export_service->zip($exported_files);
		}

		$content_type = self::filenameToContentType($filename);
		header('Content-Type: ' . $content_type);
		header('Content-disposition: attachment; filename="' . $filename . '"');

		$this->view->_layout(false);
		$this->view->content = $content;
	}

	/**
	 * Return the Content-Type corresponding to a filename.
	 *
	 * If the type of the filename is not supported, it returns
	 * `application/octet-stream` by default.
	 *
	 * @param string $filename
	 *
	 * @return string
	 */
	private static function filenameToContentType($filename) {
		$filetype = self::guessFileType($filename);
		switch ($filetype) {
		case 'zip':
			return 'application/zip';
		case 'opml':
			return 'application/xml; charset=utf-8';
		case 'json_starred':
		case 'json_feed':
			return 'application/json; charset=utf-8';
		default:
			return 'application/octet-stream';
		}
	}
}
