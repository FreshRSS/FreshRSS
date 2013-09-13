<?php

class indexController extends ActionController {
	private $get = false;
	private $nb_not_read = 0;
	private $mode = 'all';

	public function indexAction () {
		$output = Request::param ('output');

		if ($output == 'rss') {
			$this->view->_useLayout (false);
		} else {
			View::appendScript (Url::display (array ('c' => 'javascript', 'a' => 'actualize')));

			if(!$output) {
				$output = $this->view->conf->viewMode();
				Request::_param ('output', $output);
			}

			View::appendScript (Url::display ('/scripts/shortcut.js'));
			View::appendScript (Url::display (array ('c' => 'javascript', 'a' => 'main')));
			View::appendScript (Url::display ('/scripts/endless_mode.js'));

			if ($output == 'global') {
				View::appendScript (Url::display ('/scripts/global_view.js'));
			}
		}

		$nb_not_read = $this->view->nb_not_read;
		if($nb_not_read > 0) {
			View::appendTitle (' (' . $nb_not_read . ')');
		}
		View::prependTitle (' - ');

		$entryDAO = new EntryDAO ();
		$feedDAO = new FeedDAO ();
		$catDAO = new CategoryDAO ();

		$this->view->cat_aside = $catDAO->listCategories ();
		$this->view->nb_favorites = $entryDAO->countFavorites ();
		$this->view->nb_total = $entryDAO->count ();

		$this->view->get_c = '';
		$this->view->get_f = '';

		$type = $this->getType ();
		$error = $this->checkAndProcessType ($type);
		if (!$error) {
			// On récupère les différents éléments de filtrage
			$this->view->state = $state = Request::param ('state', $this->view->conf->defaultView ());
			$filter = Request::param ('search', '');
			$this->view->order = $order = Request::param ('order', $this->view->conf->sortOrder ());
			$nb = Request::param ('nb', $this->view->conf->postsPerPage ());
			$first = Request::param ('next', '');

			try {
				// EntriesGetter permet de déporter la complexité du filtrage
				$getter = new EntriesGetter ($type, $state, $filter, $order, $nb, $first);
				$getter->execute ();
				$entries = $getter->getPaginator ();

				// Si on a récupéré aucun article "non lus"
				// on essaye de récupérer tous les articles
				if ($state == 'not_read' && $entries->isEmpty ()) {
					$this->view->state = 'all';
					$getter->_state ('all');
					$getter->execute ();
					$entries = $getter->getPaginator ();
				}

				$this->view->entryPaginator = $entries;
			} catch(EntriesGetterException $e) {
				Minz_Log::record ($e->getMessage (), Minz_Log::NOTICE);
				Error::error (
					404,
					array ('error' => array (Translate::t ('page_not_found')))
				);
			}
		} else {
			Error::error (
				404,
				array ('error' => array (Translate::t ('page_not_found')))
			);
		}
	}

	/*
	 * Détermine le type d'article à récupérer :
	 * "tous", "favoris", "public", "catégorie" ou "flux"
	 */
	private function getType () {
		$get = Request::param ('get', 'all');
		$typeGet = $get[0];
		$id = substr ($get, 2);

		$type = null;
		if ($get == 'all' || $get == 'favoris' || $get == 'public') {
			$type = array (
				'type' => $get,
				'id' => $get
			);
		} elseif ($typeGet == 'f' || $typeGet == 'c') {
			$type = array (
				'type' => $typeGet,
				'id' => $id
			);
		}

		return $type;
	}
	/*
	 * Vérifie que la catégorie / flux sélectionné existe
	 * + Initialise correctement les variables de vue get_c et get_f
	 * + Initialise le titre
	 */
	private function checkAndProcessType ($type) {
		if ($type['type'] == 'all') {
			View::prependTitle (Translate::t ('your_rss_feeds'));
			$this->view->get_c = $type['type'];
			return false;
		} elseif ($type['type'] == 'favoris') {
			View::prependTitle (Translate::t ('your_favorites'));
			$this->view->get_c = $type['type'];
			return false;
		} elseif ($type['type'] == 'public') {
			View::prependTitle (Translate::t ('public'));
			$this->view->get_c = $type['type'];
			return false;
		} elseif ($type['type'] == 'c') {
			$catDAO = new CategoryDAO ();
			$cat = $catDAO->searchById ($type['id']);
			if ($cat) {
				$nbnr = $cat->nbNotRead ();
				View::prependTitle ($cat->name () . ($nbnr > 0 ? ' (' . $nbnr . ')' : ''));
				$this->view->get_c = $type['id'];
				return false;
			} else {
				return true;
			}
		} elseif ($type['type'] == 'f') {
			$feedDAO = new FeedDAO ();
			$feed = $feedDAO->searchById ($type['id']);
			if ($feed) {
				$nbnr = $feed->nbNotRead ();
				View::prependTitle ($feed->name () . ($nbnr > 0 ? ' (' . $nbnr . ')' : ''));
				$this->view->get_f = $type['id'];
				$this->view->get_c = $feed->category ();
				return false;
			} else {
				return true;
			}
		} else {
			return true;
		}
	}

	public function aboutAction () {
		View::prependTitle (Translate::t ('about') . ' - ');
	}

	public function logsAction () {
		if (login_is_conf ($this->view->conf) && !is_logged ()) {
			Error::error (
				403,
				array ('error' => array (Translate::t ('access_denied')))
			);
		}

		View::prependTitle (Translate::t ('logs') . ' - ');

		$logs = array();
		try {
			$logDAO = new LogDAO ();
			$logs = $logDAO->lister ();
			$logs = array_reverse ($logs);
		} catch(FileNotExistException $e) {

		}

		//gestion pagination
		$page = Request::param ('page', 1);
		$this->view->logsPaginator = new Paginator ($logs);
		$this->view->logsPaginator->_nbItemsPerPage (50);
		$this->view->logsPaginator->_currentPage ($page);
	}

	public function loginAction () {
		$this->view->_useLayout (false);

		$url = 'https://verifier.login.persona.org/verify';
		$assert = Request::param ('assertion');
		$params = 'assertion=' . $assert . '&audience=' .
			  urlencode (Url::display () . ':80');
		$ch = curl_init ();
		$options = array (
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_POST => 2,
			CURLOPT_POSTFIELDS => $params
		);
		curl_setopt_array ($ch, $options);
		$result = curl_exec ($ch);
		curl_close ($ch);

		$res = json_decode ($result, true);
		if ($res['status'] == 'okay' && $res['email'] == $this->view->conf->mailLogin ()) {
			Session::_param ('mail', $res['email']);
		} else {
			$res = array ();
			$res['status'] = 'failure';
			$res['reason'] = Translate::t ('invalid_login');
		}

		$this->view->res = json_encode ($res);
	}

	public function logoutAction () {
		$this->view->_useLayout (false);
		Session::_param ('mail');
	}
}
