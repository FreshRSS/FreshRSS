<?php

class indexController extends ActionController {
	private $get = false;
	private $nb_not_read_cat = 0;

	public function indexAction () {
		$output = Request::param ('output');

		$token = $this->view->conf->token();
		$token_param = Request::param ('token', '');
		$token_is_ok = ($token != '' && $token == $token_param);

		// check if user is log in
		if(login_is_conf ($this->view->conf) &&
				!is_logged() &&
				$this->view->conf->anonAccess() == 'no' &&
				!($output == 'rss' && $token_is_ok)) {
			return;
		}

		// construction of RSS url of this feed
		$params = Request::params ();
		$params['output'] = 'rss';
		if (isset ($params['search'])) {
			$params['search'] = urlencode ($params['search']);
		}
		if (login_is_conf($this->view->conf) &&
				$this->view->conf->anonAccess() == 'no' &&
				$token != '') {
			$params['token'] = $token;
		}
		$this->view->rss_url = array (
			'c' => 'index',
			'a' => 'index',
			'params' => $params
		);

		$this->view->rss_title = View::title();

		if ($output == 'rss') {
			// no layout for RSS output
			$this->view->_useLayout (false);
			header('Content-Type: application/rss+xml; charset=utf-8');
		} else {
			if(!$output) {
				$output = $this->view->conf->viewMode();
				Request::_param ('output', $output);
			}

			View::appendScript (Url::display ('/scripts/shortcut.js?' . @filemtime(PUBLIC_PATH . '/scripts/shortcut.js')));

			if ($output == 'global') {
				View::appendScript (Url::display ('/scripts/global_view.js?' . @filemtime(PUBLIC_PATH . '/scripts/global_view.js')));
			}
		}

		$entryDAO = new EntryDAO ();
		$feedDAO = new FeedDAO ();
		$catDAO = new CategoryDAO ();

		$this->view->cat_aside = $catDAO->listCategories ();
		$this->view->nb_favorites = $entryDAO->countUnreadReadFavorites ();
		$this->view->currentName = '';

		$this->view->get_c = '';
		$this->view->get_f = '';

		$type = $this->getType ();
		$error = $this->checkAndProcessType ($type);

		// mise à jour des titres
		$this->view->nb_not_read = HelperCategory::CountUnreads($this->view->cat_aside, 1);
		if ($this->view->nb_not_read > 0) {
			View::appendTitle (' (' . $this->view->nb_not_read . ')');
		}
		View::prependTitle (' - ');

		$this->view->rss_title = $this->view->currentName . ' - ' . $this->view->rss_title;
		View::prependTitle (
			$this->view->currentName .
			($this->nb_not_read_cat > 0 ? ' (' . $this->nb_not_read_cat . ')' : '')
		);

		if (!$error) {
			// On récupère les différents éléments de filtrage
			$this->view->state = $state = Request::param ('state', $this->view->conf->defaultView ());
			$filter = Request::param ('search', '');
			$this->view->order = $order = Request::param ('order', $this->view->conf->sortOrder ());
			$nb = Request::param ('nb', $this->view->conf->postsPerPage ());
			$first = Request::param ('next', '');

			if ($state === 'not_read') {	//Any unread article in this category at all?
				switch ($type['type']) {
					case 'all':
						$hasUnread = $this->view->nb_not_read > 0;
						break;
					case 'favoris':
						$hasUnread = $this->view->nb_favorites['unread'] > 0;
						break;
					case 'c':
						$hasUnread = (!isset($this->view->cat_aside[$type['id']])) || ($this->view->cat_aside[$type['id']]->nbNotRead() > 0);
						break;
					case 'f':
						$myFeed = HelperCategory::findFeed($this->view->cat_aside, $type['id']);
						$hasUnread = ($myFeed === null) || ($myFeed->nbNotRead() > 0);
						break;
					default:
						$hasUnread = true;
						break;
				}
				if (!$hasUnread) {
					$this->view->state = $state = 'all';
				}
			}

			try {
				// EntriesGetter permet de déporter la complexité du filtrage
				$getter = new EntriesGetter ($type, $state, $filter, $order, $nb, $first);
				$getter->execute ();
				$entries = $getter->getPaginator ();

				// Si on a récupéré aucun article "non lus"
				// on essaye de récupérer tous les articles
				if ($state === 'not_read' && $entries->isEmpty ()) {	//TODO: Remove in v0.8
					Minz_Log::record ('Conflicting information about nbNotRead!', Minz_Log::NOTICE);	//TODO: Consider adding a Minz_Log::DEBUG level
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
	 * + Met à jour la variable $this->nb_not_read_cat
	 */
	private function checkAndProcessType ($type) {
		if ($type['type'] == 'all') {
			$this->view->currentName = Translate::t ('your_rss_feeds');
			$this->view->get_c = $type['type'];
			return false;
		} elseif ($type['type'] == 'favoris') {
			$this->view->currentName = Translate::t ('your_favorites');
			$this->view->get_c = $type['type'];
			return false;
		} elseif ($type['type'] == 'public') {
			$this->view->currentName = Translate::t ('public');
			$this->view->get_c = $type['type'];
			return false;
		} elseif ($type['type'] == 'c') {
			$cat = isset($this->view->cat_aside[$type['id']]) ? $this->view->cat_aside[$type['id']] : null;
			if ($cat === null) {
				$catDAO = new CategoryDAO ();
				$cat = $catDAO->searchById ($type['id']);
			}
			if ($cat) {
				$this->view->currentName = $cat->name ();
				$this->nb_not_read_cat = $cat->nbNotRead ();
				$this->view->get_c = $type['id'];
				return false;
			} else {
				return true;
			}
		} elseif ($type['type'] == 'f') {
			$feed = HelperCategory::findFeed($this->view->cat_aside, $type['id']);
			if (empty($feed)) {
				$feedDAO = new FeedDAO ();
				$feed = $feedDAO->searchById ($type['id']);
			}
			if ($feed) {
				$this->view->currentName = $feed->name ();
				$this->nb_not_read_cat = $feed->nbNotRead ();
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

		if (Request::isPost ()) {
			file_put_contents(LOG_PATH . '/application.log', '');
		}

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
			  urlencode (Url::display (null, 'php', true));
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
			touch(PUBLIC_PATH . '/data/touch.txt');
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
		touch(PUBLIC_PATH . '/data/touch.txt');
	}
}
