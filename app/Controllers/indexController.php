<?php

class FreshRSS_index_Controller extends Minz_ActionController {
	private $get = false;
	private $nb_not_read_cat = 0;
	private $entryDAO;
	private $feedDAO;
	private $catDAO;

	function __construct($router) {
		parent::__construct($router);
		$this->entryDAO = new FreshRSS_EntryDAO ();
		$this->feedDAO = new FreshRSS_FeedDAO ();
		$this->catDAO = new FreshRSS_CategoryDAO ();
	}

	public function indexAction () {
		$output = Minz_Request::param ('output');

		$token = $this->view->conf->token();
		$token_param = Minz_Request::param ('token', '');
		$token_is_ok = ($token != '' && $token === $token_param);

		// check if user is log in
		if(login_is_conf ($this->view->conf) &&
				!is_logged() &&
				$this->view->conf->anonAccess() === 'no' &&
				!($output === 'rss' && $token_is_ok)) {
			return;
		}

		// construction of RSS url of this feed
		$params = Minz_Request::params ();
		$params['output'] = 'rss';
		if (isset ($params['search'])) {
			$params['search'] = urlencode ($params['search']);
		}
		if (login_is_conf($this->view->conf) &&
				$this->view->conf->anonAccess() === 'no' &&
				$token != '') {
			$params['token'] = $token;
		}
		$this->view->rss_url = array (
			'c' => 'index',
			'a' => 'index',
			'params' => $params
		);

		if ($output === 'rss') {
			// no layout for RSS output
			$this->view->_useLayout (false);
			header('Content-Type: application/rss+xml; charset=utf-8');
		} else {
			Minz_View::appendScript (Minz_Url::display ('/scripts/shortcut.js?' . @filemtime(PUBLIC_PATH . '/scripts/shortcut.js')));

			if ($output === 'global') {
				Minz_View::appendScript (Minz_Url::display ('/scripts/global_view.js?' . @filemtime(PUBLIC_PATH . '/scripts/global_view.js')));
			}
		}

		$this->view->cat_aside = $this->catDAO->listCategories ();
		$this->view->nb_favorites = $this->entryDAO->countUnreadReadFavorites ();
		$this->view->currentName = '';

		$this->view->get_c = '';
		$this->view->get_f = '';

		$get = Minz_Request::param ('get', 'a');
		$getType = $get[0];
		$getId = substr ($get, 2);
		if (!$this->checkAndProcessType ($getType, $getId)) {
			Minz_Log::record ('Not found [' . $getType . '][' . $getId . ']', Minz_Log::DEBUG);
			Minz_Error::error (
				404,
				array ('error' => array (Minz_Translate::t ('page_not_found')))
			);
			return;
		}

		$this->view->nb_not_read = FreshRSS_CategoryDAO::CountUnreads($this->view->cat_aside, 1);

		// mise à jour des titres
		$this->view->rss_title = $this->view->currentName . ' | ' . Minz_View::title();
		if ($this->view->nb_not_read > 0) {
			Minz_View::appendTitle (' (' . $this->view->nb_not_read . ')');
		}
		Minz_View::prependTitle (
			$this->view->currentName .
			($this->nb_not_read_cat > 0 ? ' (' . $this->nb_not_read_cat . ')' : '') .
			' - '
		);

		// On récupère les différents éléments de filtrage
		$this->view->state = $state = Minz_Request::param ('state', $this->view->conf->defaultView ());
		$filter = Minz_Request::param ('search', '');
		if (!empty($filter)) {
			$state = 'all';	//Search always in read and unread articles
		}
		$this->view->order = $order = Minz_Request::param ('order', $this->view->conf->sortOrder ());
		$nb = Minz_Request::param ('nb', $this->view->conf->postsPerPage ());
		$first = Minz_Request::param ('next', '');

		if ($state === 'not_read') {	//Any unread article in this category at all?
			switch ($getType) {
				case 'a':
					$hasUnread = $this->view->nb_not_read > 0;
					break;
				case 's':
					$hasUnread = $this->view->nb_favorites['unread'] > 0;
					break;
				case 'c':
					$hasUnread = (!isset($this->view->cat_aside[$getId])) || ($this->view->cat_aside[$getId]->nbNotRead() > 0);
					break;
				case 'f':
					$myFeed = FreshRSS_CategoryDAO::findFeed($this->view->cat_aside, $getId);
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

		$today = @strtotime('today');
		$this->view->today = $today;

		// on calcule la date des articles les plus anciens qu'on affiche
		$nb_month_old = $this->view->conf->oldEntries ();
		$date_min = $today - (3600 * 24 * 30 * $nb_month_old);	//Do not use a fast changing value such as time() to allow SQL caching
		$keepHistoryDefault = $this->view->conf->keepHistoryDefault();

		try {
			$entries = $this->entryDAO->listWhere($getType, $getId, $state, $order, $nb + 1, $first, $filter, $date_min, $keepHistoryDefault);

			// Si on a récupéré aucun article "non lus"
			// on essaye de récupérer tous les articles
			if ($state === 'not_read' && empty($entries)) {	//TODO: Remove in v0.8
				Minz_Log::record ('Conflicting information about nbNotRead!', Minz_Log::DEBUG);
				$this->view->state = 'all';
				$entries = $this->entryDAO->listWhere($getType, $getId, 'all', $order, $nb, $first, $filter, $date_min, $keepHistoryDefault);
			}

			if (count($entries) <= $nb) {
				$this->view->nextId  = '';
			} else {	//We have more elements for pagination
				$lastEntry = array_pop($entries);
				$this->view->nextId  = $lastEntry->id();
			}

			$this->view->entries = $entries;
		} catch (FreshRSS_EntriesGetter_Exception $e) {
			Minz_Log::record ($e->getMessage (), Minz_Log::NOTICE);
			Minz_Error::error (
				404,
				array ('error' => array (Minz_Translate::t ('page_not_found')))
			);
		}
	}

	/*
	 * Vérifie que la catégorie / flux sélectionné existe
	 * + Initialise correctement les variables de vue get_c et get_f
	 * + Met à jour la variable $this->nb_not_read_cat
	 */
	private function checkAndProcessType ($getType, $getId) {
		switch ($getType) {
			case 'a':
				$this->view->currentName = Minz_Translate::t ('your_rss_feeds');
				$this->view->get_c = $getType;
				return true;
			case 's':
				$this->view->currentName = Minz_Translate::t ('your_favorites');
				$this->view->get_c = $getType;
				return true;
			case 'c':
				$cat = isset($this->view->cat_aside[$getId]) ? $this->view->cat_aside[$getId] : null;
				if ($cat === null) {
					$cat = $this->catDAO->searchById ($getId);
				}
				if ($cat) {
					$this->view->currentName = $cat->name ();
					$this->nb_not_read_cat = $cat->nbNotRead ();
					$this->view->get_c = $getId;
					return true;
				} else {
					return false;
				}
			case 'f':
				$feed = FreshRSS_CategoryDAO::findFeed($this->view->cat_aside, $getId);
				if (empty($feed)) {
					$feed = $this->feedDAO->searchById ($getId);
				}
				if ($feed) {
					$this->view->currentName = $feed->name ();
					$this->nb_not_read_cat = $feed->nbNotRead ();
					$this->view->get_f = $getId;
					$this->view->get_c = $feed->category ();
					return true;
				} else {
					return false;
				}
			default:
				return false;
		}
	}

	public function aboutAction () {
		Minz_View::prependTitle (Minz_Translate::t ('about') . ' - ');
	}

	public function logsAction () {
		if (login_is_conf ($this->view->conf) && !is_logged ()) {
			Minz_Error::error (
				403,
				array ('error' => array (Minz_Translate::t ('access_denied')))
			);
		}

		Minz_View::prependTitle (Minz_Translate::t ('logs') . ' - ');

		if (Minz_Request::isPost ()) {
			file_put_contents(LOG_PATH . '/application.log', '');
		}

		$logs = array();
		try {
			$logDAO = new FreshRSS_LogDAO ();
			$logs = $logDAO->lister ();
			$logs = array_reverse ($logs);
		} catch (Minz_FileNotExistException $e) {

		}

		//gestion pagination
		$page = Minz_Request::param ('page', 1);
		$this->view->logsPaginator = new Minz_Paginator ($logs);
		$this->view->logsPaginator->_nbItemsPerPage (50);
		$this->view->logsPaginator->_currentPage ($page);
	}

	public function loginAction () {
		$this->view->_useLayout (false);

		$url = 'https://verifier.login.persona.org/verify';
		$assert = Minz_Request::param ('assertion');
		$params = 'assertion=' . $assert . '&audience=' .
			  urlencode (Minz_Url::display (null, 'php', true));
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
		if ($res['status'] === 'okay' && $res['email'] === $this->view->conf->mailLogin ()) {
			Minz_Session::_param ('mail', $res['email']);
			invalidateHttpCache();
		} else {
			$res = array ();
			$res['status'] = 'failure';
			$res['reason'] = Minz_Translate::t ('invalid_login');
		}

		header('Content-Type: application/json; charset=UTF-8');
		$this->view->res = json_encode ($res);
	}

	public function logoutAction () {
		$this->view->_useLayout (false);
		Minz_Session::_param ('mail');
		invalidateHttpCache();
	}
}
