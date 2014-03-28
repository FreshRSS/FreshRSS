<?php

class FreshRSS_importExport_Controller extends Minz_ActionController {
	public function firstAction() {
		if (!$this->view->loginOk) {
			Minz_Error::error (
				403,
				array ('error' => array (Minz_Translate::t ('access_denied')))
			);
		}

		require_once(LIB_PATH . '/lib_opml.php');
	}

	public function indexAction() {
		$catDAO = new FreshRSS_CategoryDAO();
		$this->view->categories = $catDAO->listCategories();

		$feedDAO = new FreshRSS_FeedDAO();
		$this->view->feeds = $feedDAO->listFeeds();

		// au niveau de la vue, permet de ne pas voir un flux sélectionné dans la liste
		$this->view->flux = false;

		Minz_View::prependTitle(Minz_Translate::t('import_export') . ' · ');
	}

	public function importAction() {
		if (Minz_Request::isPost() && $_FILES['file']['error'] == 0) {
			invalidateHttpCache();
			// on parse le fichier OPML pour récupérer les catégories et les flux associés
			try {
				list ($categories, $feeds) = opml_import (
					file_get_contents ($_FILES['file']['tmp_name'])
				);

				// On redirige vers le controller feed qui va se charger d'insérer les flux en BDD
				// les flux sont mis au préalable dans des variables de Request
				Minz_Request::_param ('categories', $categories);
				Minz_Request::_param ('feeds', $feeds);
				Minz_Request::forward (array ('c' => 'feed', 'a' => 'massiveImport'));
			} catch (FreshRSS_Opml_Exception $e) {
				Minz_Log::record ($e->getMessage (), Minz_Log::WARNING);

				$notif = array (
					'type' => 'bad',
					'content' => Minz_Translate::t ('bad_opml_file')
				);
				Minz_Session::_param ('notification', $notif);

				Minz_Request::forward (array (
					'c' => 'configure',
					'a' => 'importExport'
				), true);
			}
		}
	}

	public function exportAction() {
		if (Minz_Request::isPost()) {
			$this->view->_useLayout (false);

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
			$feedDAO = new FreshRSS_FeedDAO ();
			foreach ($export_feeds as $feed_id) {
				$feed = $feedDAO->searchById($feed_id);
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
		$feedDAO = new FreshRSS_FeedDAO ();
		$catDAO = new FreshRSS_CategoryDAO ();

		$list = array ();
		foreach ($catDAO->listCategories () as $key => $cat) {
			$list[$key]['name'] = $cat->name ();
			$list[$key]['feeds'] = $feedDAO->listByCategory ($cat->id ());
		}

		$this->view->categories = $list;
		return $this->view->helperToString('export/opml');
	}

	private function generate_articles($type, $feed = NULL) {
		$entryDAO = new FreshRSS_EntryDAO();

		$catDAO = new FreshRSS_CategoryDAO();
		$this->view->categories = $catDAO->listCategories();

		if ($type == 'starred') {
			$this->view->list_title = Minz_Translate::t("starred_list");
			$this->view->type = 'starred';
			$this->view->entries = $entryDAO->listWhere(
				's', '', 'all', 'ASC',
				$entryDAO->countUnreadReadFavorites()['all']
			);
		} elseif ($type == 'feed' && !is_null($feed)) {
			$this->view->list_title = Minz_Translate::t("feed_list", $feed->name());
			$this->view->type = 'feed/' . $feed->id();
			$this->view->entries = $entryDAO->listWhere(
				'f', $feed->id(), 'all', 'ASC',
				$this->view->conf->posts_per_page
			);
			$this->view->feed = $feed;
		}

		return $this->view->helperToString('export/articles');
	}
}
