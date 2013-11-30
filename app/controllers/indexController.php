<?php

class indexController extends ActionController {
	private $get = false;
	private $nb_not_read_cat = 0;
	private $entryDAO;
	private $feedDAO;
	private $catDAO;

	function __construct($router) {
		parent::__construct($router);
		$this->entryDAO = new EntryDAO ();
		$this->feedDAO = new FeedDAO ();
		$this->catDAO = new CategoryDAO ();
	}

	public function indexAction () {
		$output = Request::param ('output');

		$token = $this->view->conf->token();
		$token_param = Request::param ('token', '');
		$token_is_ok = ($token != '' && $token === $token_param);

		// check if user is log in
		if(login_is_conf ($this->view->conf) &&
				!is_logged() &&
				$this->view->conf->anonAccess() === 'no' &&
				!($output === 'rss' && $token_is_ok)) {
			return;
		}

		// construction of RSS url of this feed
		$params = Request::params ();
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

		$this->view->rss_title = View::title();

		if ($output === 'rss') {
			// no layout for RSS output
			$this->view->_useLayout (false);
			header('Content-Type: application/rss+xml; charset=utf-8');
		} else {
			View::appendScript (Url::display ('/scripts/shortcut.js?' . @filemtime(PUBLIC_PATH . '/scripts/shortcut.js')));

			if ($output === 'global') {
				View::appendScript (Url::display ('/scripts/global_view.js?' . @filemtime(PUBLIC_PATH . '/scripts/global_view.js')));
			}
		}

		$this->view->cat_aside = $this->catDAO->listCategories ();
		$this->view->nb_favorites = $this->entryDAO->countUnreadReadFavorites ();
		$this->view->currentName = '';

		$this->view->get_c = '';
		$this->view->get_f = '';

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

		$get = Request::param ('get', 'a');
		$getType = $get[0];
		$getId = substr ($get, 2);
		if (!$this->checkAndProcessType ($getType, $getId)) {
			Minz_Log::record ('Not found [' . $getType . '][' . $getId . ']', Minz_Log::DEBUG);
			Error::error (
				404,
				array ('error' => array (Translate::t ('page_not_found')))
			);
			return;
		}

		// On récupère les différents éléments de filtrage
		$this->view->state = $state = Request::param ('state', $this->view->conf->defaultView ());
		$filter = Request::param ('search', '');
		if (!empty($filter)) {
			$state = 'all';	//Search always in read and unread articles
		}
		$this->view->order = $order = Request::param ('order', $this->view->conf->sortOrder ());
		$nb = Request::param ('nb', $this->view->conf->postsPerPage ());
		$first = Request::param ('next', '');

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
					$myFeed = HelperCategory::findFeed($this->view->cat_aside, $getId);
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
			$entries = $this->entryDAO->listWhere($getType, $getId, $state, $order, $nb + 1, $first, $filter);

			// Si on a récupéré aucun article "non lus"
			// on essaye de récupérer tous les articles
			if ($state === 'not_read' && empty($entries)) {	//TODO: Remove in v0.8
				Minz_Log::record ('Conflicting information about nbNotRead!', Minz_Log::DEBUG);
				$this->view->state = 'all';
				$entries = $this->entryDAO->listWhere($getType, $getId, 'all', $order, $nb, $first, $filter);
			}

			if (count($entries) <= $nb) {
				$next = '';
			} else {	//We have more elements for pagination
				$lastEntry = array_pop($entries);
				$next = $lastEntry->id();
			}

			$this->view->entryPaginator = new RSSPaginator ($entries, $next);
		} catch (EntriesGetterException $e) {
			Minz_Log::record ($e->getMessage (), Minz_Log::NOTICE);
			Error::error (
				404,
				array ('error' => array (Translate::t ('page_not_found')))
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
				$this->view->currentName = Translate::t ('your_rss_feeds');
				$this->view->get_c = $getType;
				return true;
			case 's':
				$this->view->currentName = Translate::t ('your_favorites');
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
				$feed = HelperCategory::findFeed($this->view->cat_aside, $getId);
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
		if ($res['status'] === 'okay' && $res['email'] === $this->view->conf->mailLogin ()) {
			Session::_param ('mail', $res['email']);
			invalidateHttpCache();
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
		invalidateHttpCache();
	}
}
