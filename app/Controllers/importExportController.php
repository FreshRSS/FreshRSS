<?php

class FreshRSS_importExport_Controller extends Minz_ActionController {
	public function firstAction() {
		if (!$this->view->loginOk) {
			Minz_Error::error(
				403,
				array('error' => array(Minz_Translate::t('access_denied')))
			);
		}

		require_once(LIB_PATH . '/lib_opml.php');

		$this->catDAO = new FreshRSS_CategoryDAO();
		$this->entryDAO = new FreshRSS_EntryDAO();
		$this->feedDAO = new FreshRSS_FeedDAO();
	}

	public function indexAction() {
		$this->view->categories = $this->catDAO->listCategories();
		$this->view->feeds = $this->feedDAO->listFeeds();

		// au niveau de la vue, permet de ne pas voir un flux sélectionné dans la liste
		$this->view->flux = false;

		Minz_View::prependTitle(Minz_Translate::t('import_export') . ' · ');
	}

	public function importAction() {
		if (Minz_Request::isPost() && $_FILES['file']['error'] == 0) {
			@set_time_limit(300);

			$file = $_FILES['file'];
			$type_file = $this->guess_file_type($file['name']);

			$list_files = array(
				'opml' => array(),
				'json_starred' => array(),
				'json_feed' => array()
			);

			// We try to list all files according to their type
			// A zip file is first opened and then its files are listed
			$list = array();
			if ($type_file === 'zip') {
				$zip = zip_open($file['tmp_name']);

				while (($zipfile = zip_read($zip)) !== false) {
					$type_zipfile = $this->guess_file_type(zip_entry_name($zipfile));

					if ($type_file !== 'unknown') {
						$list_files[$type_zipfile][] = zip_entry_read(
							$zipfile,
							zip_entry_filesize($zipfile)
						);
					}
				}

				zip_close($zip);
			} elseif ($type_file !== 'unknown') {
				$list_files[$type_file][] = file_get_contents($file['tmp_name']);
			}

			// Import different files.
			// OPML first(so categories and feeds are imported)
			// Starred articles then so the "favourite" status is already set
			// And finally all other files.
			$error = false;
			foreach ($list_files['opml'] as $opml_file) {
				$error = $this->import_opml($opml_file);
			}
			foreach ($list_files['json_starred'] as $article_file) {
				$error = $this->import_articles($article_file, true);
			}
			foreach ($list_files['json_feed'] as $article_file) {
				$error = $this->import_articles($article_file);
			}

			// And finally, we get import status and redirect to the home page
			$notif = null;
			if ($error === true) {
				$notif = array(
					'type' => 'good',
					'content' => Minz_Translate::t('feeds_imported_with_errors')
				);
			} else {
				$notif = array(
					'type' => 'good',
					'content' => Minz_Translate::t('feeds_imported')
				);
			}

			Minz_Session::_param('notification', $notif);
			Minz_Session::_param('actualize_feeds', true);

			Minz_Request::forward(array(
				'c' => 'index',
				'a' => 'index'
			), true);
		}

		// What are you doing? you have to call this controller
		// with a POST request!
		Minz_Request::forward(array(
			'c' => 'importExport',
			'a' => 'index'
		));
	}

	private function guess_file_type($filename) {
		// A *very* basic guess file type function. Only based on filename
		// That's could be improved but should be enough, at least for a first
		// implementation.
		// TODO: improve this function?

		if (substr_compare($filename, '.zip', -4) === 0) {
			return 'zip';
		} elseif (substr_compare($filename, '.opml', -5) === 0) {
			return 'opml';
		} elseif (strcmp($filename, 'starred.json') === 0) {
			return 'json_starred';
		} elseif (substr_compare($filename, '.json', -5) === 0 &&
		          strpos($filename, 'feed_') === 0) {
			return 'json_feed';
		} else {
			return 'unknown';
		}
	}

	private function import_opml($opml_file) {
		$categories = array();
		$feeds = array();
		try {
			list($categories, $feeds) = opml_import($opml_file);
		} catch (FreshRSS_Opml_Exception $e) {
			Minz_Log::warning($e->getMessage());
			return true;
		}

		$this->catDAO->checkDefault();

		// on ajoute les catégories en masse dans une fonction à part
		$this->addCategories($categories);

		// on calcule la date des articles les plus anciens qu'on accepte
		$nb_month_old = $this->view->conf->old_entries;
		$date_min = time() -(3600 * 24 * 30 * $nb_month_old);

		// la variable $error permet de savoir si une erreur est survenue
		// Le but est de ne pas arrêter l'import même en cas d'erreur
		// L'utilisateur sera mis au courant s'il y a eu des erreurs, mais
		// ne connaîtra pas les détails. Ceux-ci seront toutefois logguées
		$error = false;
		foreach ($feeds as $feed) {
			try {
				$values = array(
					'id' => $feed->id(),
					'url' => $feed->url(),
					'category' => $feed->category(),
					'name' => $feed->name(),
					'website' => $feed->website(),
					'description' => $feed->description(),
					'lastUpdate' => 0,
					'httpAuth' => $feed->httpAuth()
				);

				// ajout du flux que s'il n'est pas déjà en BDD
				if (!$this->feedDAO->searchByUrl($values['url'])) {
					$id = $this->feedDAO->addFeed($values);
					if ($id) {
						$feed->_id($id);
						$feed->faviconPrepare();
					} else {
						$error = true;
					}
				}
			} catch (FreshRSS_Feed_Exception $e) {
				$error = true;
				Minz_Log::record($e->getMessage(), Minz_Log::WARNING);
			}
		}

		return $error;
	}

	private function addCategories($categories) {
		foreach ($categories as $cat) {
			if (!$this->catDAO->searchByName($cat->name())) {
				$values = array(
					'id' => $cat->id(),
					'name' => $cat->name(),
				);
				$this->catDAO->addCategory($values);
			}
		}
	}

	private function import_articles($article_file, $starred = false) {
		$article_object = json_decode($article_file, true);
		if (is_null($article_object)) {
			Minz_Log::warning('Try to import a non-JSON file');
			return true;
		}

		$google_compliant = (strpos($article_object['id'], 'com.google') !== false);

		foreach ($article_object['items'] as $item) {
			$key = $google_compliant ? 'htmlUrl' : 'feedUrl';
			$feed = $this->feedDAO->searchByUrl($item['origin'][$key]);
			if (is_null($feed)) {
				$feed = new FreshRSS_Feed($item['origin'][$key]);
				$feed->_name ($item['origin']['title']);
				$feed->_website ($item['origin']['htmlUrl']);

				$error = $this->addFeed($feed);  // TODO

				if ($error) {
					continue;
				}
			}

			$author = isset($item['author']) ? $item['author'] : '';
			$key_content = $google_compliant && !isset($item['content']) ? 'summary' : 'content';
			$tags = $item['categories'];
			if ($google_compliant) {
				$tags = array_filter($tags, function($var) {
					return strpos($var, '/state/com.google') === false;
				});
			}
			$entry = new FreshRSS_Entry(
				$feed->id(), $item['id'], $item['title'], $author,
				$item[$key_content]['content'], $item['alternate'][0]['href'],
				$item['published'], false, $starred, $tags
			);

			Minz_Log::debug(print_r($entry, true));  // TODO
		}
	}

	public function exportAction() {
		if (Minz_Request::isPost()) {
			$this->view->_useLayout(false);

			$export_opml = Minz_Request::param('export_opml', false);
			$export_starred = Minz_Request::param('export_starred', false);
			$export_feeds = Minz_Request::param('export_feeds', false);

			// code from https://stackoverflow.com/questions/1061710/php-zip-files-on-the-fly
			$file = tempnam('tmp', 'zip');
			$zip = new ZipArchive();
			$zip->open($file, ZipArchive::OVERWRITE);

			// Stuff with content
			if ($export_opml) {
				$zip->addFromString('feeds.opml', $this->generate_opml());
			}
			if ($export_starred) {
				$zip->addFromString('starred.json', $this->generate_articles('starred'));
			}
			foreach ($export_feeds as $feed_id) {
				$feed = $this->feedDAO->searchById($feed_id);
				$zip->addFromString(
					'feed_' . $feed->category() . '_' . $feed->id() . '.json',
					$this->generate_articles('feed', $feed)
				);
			}

			// Close and send to user
			$zip->close();
			header('Content-Type: application/zip');
			header('Content-Length: ' . filesize($file));
			header('Content-Disposition: attachment; filename="freshrss_export.zip"');
			readfile($file);
			unlink($file);
		}
	}

	private function generate_opml() {
		$list = array();
		foreach ($this->catDAO->listCategories() as $key => $cat) {
			$list[$key]['name'] = $cat->name();
			$list[$key]['feeds'] = $this->feedDAO->listByCategory($cat->id());
		}

		$this->view->categories = $list;
		return $this->view->helperToString('export/opml');
	}

	private function generate_articles($type, $feed = NULL) {
		$this->view->categories = $this->catDAO->listCategories();

		if ($type == 'starred') {
			$this->view->list_title = Minz_Translate::t("starred_list");
			$this->view->type = 'starred';
			$this->view->entries = $this->entryDAO->listWhere(
				's', '', 'all', 'ASC',
				$entryDAO->countUnreadReadFavorites()['all']
			);
		} elseif ($type == 'feed' && !is_null($feed)) {
			$this->view->list_title = Minz_Translate::t("feed_list", $feed->name());
			$this->view->type = 'feed/' . $feed->id();
			$this->view->entries = $this->entryDAO->listWhere(
				'f', $feed->id(), 'all', 'ASC',
				$this->view->conf->posts_per_page
			);
			$this->view->feed = $feed;
		}

		return $this->view->helperToString('export/articles');
	}
}
