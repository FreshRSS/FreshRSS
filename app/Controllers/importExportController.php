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
		$catDAO = new FreshRSS_CategoryDAO ();
		$this->view->categories = $catDAO->listCategories ();

		$feedDAO = new FreshRSS_FeedDAO ();
		$this->view->feeds = $feedDAO->listFeeds ();

		// au niveau de la vue, permet de ne pas voir un flux sélectionné dans la liste
		$this->view->flux = false;

		Minz_View::prependTitle (Minz_Translate::t ('import_export') . ' · ');
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
		Minz_View::_title ('freshrss_feeds.opml');

		$this->view->_useLayout (false);
		header('Content-Type: application/xml; charset=utf-8');
		header('Content-disposition: attachment; filename=freshrss_feeds.opml');

		$feedDAO = new FreshRSS_FeedDAO ();
		$catDAO = new FreshRSS_CategoryDAO ();

		$list = array ();
		foreach ($catDAO->listCategories () as $key => $cat) {
			$list[$key]['name'] = $cat->name ();
			$list[$key]['feeds'] = $feedDAO->listByCategory ($cat->id ());
		}

		$this->view->categories = $list;
	}
}
