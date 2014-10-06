<?php

class FreshRSS_index_Controller extends Minz_ActionController {
	private $nb_not_read_cat = 0;

	public function indexAction() {
		$output = Minz_Request::param('output');
		$token = $this->view->conf->token;

		// check if user is logged in
		if (!FreshRSS_Auth::hasAccess() && !Minz_Configuration::allowAnonymous()) {
			$token_param = Minz_Request::param('token', '');
			$token_is_ok = ($token != '' && $token === $token_param);
			if ($output === 'rss' && !$token_is_ok) {
				Minz_Error::error(
					403,
					array('error' => array(_t('access_denied')))
				);
				return;
			} elseif ($output !== 'rss') {
				// "hard" redirection is not required, just ask dispatcher to
				// forward to the login form without 302 redirection
				Minz_Request::forward(array('c' => 'index', 'a' => 'login'));
				return;
			}
		}

		$params = Minz_Request::params();
		if (isset($params['search'])) {
			$params['search'] = urlencode($params['search']);
		}

		$this->view->url = array(
			'c' => 'index',
			'a' => 'index',
			'params' => $params
		);

		if ($output === 'rss') {
			// no layout for RSS output
			$this->view->_useLayout(false);
			header('Content-Type: application/rss+xml; charset=utf-8');
		} elseif ($output === 'global') {
			Minz_View::appendScript(Minz_Url::display('/scripts/global_view.js?' . @filemtime(PUBLIC_PATH . '/scripts/global_view.js')));
		}

		$catDAO = new FreshRSS_CategoryDAO();
		$entryDAO = FreshRSS_Factory::createEntryDao();

		$this->view->cat_aside = $catDAO->listCategories();
		$this->view->nb_favorites = $entryDAO->countUnreadReadFavorites();
		$this->view->nb_not_read = FreshRSS_CategoryDAO::CountUnreads($this->view->cat_aside, 1);
		$this->view->currentName = '';

		$this->view->get_c = '';
		$this->view->get_f = '';

		$get = Minz_Request::param('get', 'a');
		$getType = $get[0];
		$getId = substr($get, 2);
		if (!$this->checkAndProcessType($getType, $getId)) {
			Minz_Log::debug('Not found [' . $getType . '][' . $getId . ']');
			Minz_Error::error(
				404,
				array('error' => array(_t('page_not_found')))
			);
			return;
		}

		// mise à jour des titres
		$this->view->rss_title = $this->view->currentName . ' | ' . Minz_View::title();
		Minz_View::prependTitle(
			($this->nb_not_read_cat > 0 ? '(' . formatNumber($this->nb_not_read_cat) . ') ' : '') .
			$this->view->currentName .
			' · '
		);

		// On récupère les différents éléments de filtrage
		$this->view->state = Minz_Request::param('state', $this->view->conf->default_view);
		$state_param = Minz_Request::param('state', null);
		$filter = Minz_Request::param('search', '');
		$this->view->order = $order = Minz_Request::param('order', $this->view->conf->sort_order);
		$nb = Minz_Request::param('nb', $this->view->conf->posts_per_page);
		$first = Minz_Request::param('next', '');

		$ajax_request = Minz_Request::param('ajax', false);
		if ($output === 'reader') {
			$nb = max(1, round($nb / 2));
		}

		if ($this->view->state === FreshRSS_Entry::STATE_NOT_READ) {	//Any unread article in this category at all?
			switch ($getType) {
			case 'a':
				$hasUnread = $this->view->nb_not_read > 0;
				break;
			case 's':
				// This is deprecated. The favorite button does not exist anymore
				$hasUnread = $this->view->nb_favorites['unread'] > 0;
				break;
			case 'c':
				$hasUnread = (!isset($this->view->cat_aside[$getId]) ||
				              $this->view->cat_aside[$getId]->nbNotRead() > 0);
				break;
			case 'f':
				$myFeed = FreshRSS_CategoryDAO::findFeed($this->view->cat_aside, $getId);
				$hasUnread = ($myFeed === null) || ($myFeed->nbNotRead() > 0);
				break;
			default:
				$hasUnread = true;
				break;
			}
			if (!$hasUnread && ($state_param === null)) {
				$this->view->state = FreshRSS_Entry::STATE_ALL;
			}
		}

		$this->view->today = @strtotime('today');

		try {
			$entries = $entryDAO->listWhere($getType, $getId, $this->view->state, $order, $nb + 1, $first, $filter);

			// Si on a récupéré aucun article "non lus"
			// on essaye de récupérer tous les articles
			if ($this->view->state === FreshRSS_Entry::STATE_NOT_READ && empty($entries) && ($state_param === null) && ($filter == '')) {
				Minz_Log::debug('Conflicting information about nbNotRead!');
				$feedDAO = FreshRSS_Factory::createFeedDao();
				try {
					$feedDAO->updateCachedValues();
				} catch (Exception $ex) {
					Minz_Log::notice('Failed to automatically correct nbNotRead! ' + $ex->getMessage());
				}
				$this->view->state = FreshRSS_Entry::STATE_ALL;
				$entries = $entryDAO->listWhere($getType, $getId, $this->view->state, $order, $nb, $first, $filter);
			}
			Minz_Request::_param('state', $this->view->state);

			if (count($entries) <= $nb) {
				$this->view->nextId  = '';
			} else {	//We have more elements for pagination
				$lastEntry = array_pop($entries);
				$this->view->nextId  = $lastEntry->id();
			}

			$this->view->entries = $entries;
		} catch (FreshRSS_EntriesGetter_Exception $e) {
			Minz_Log::notice($e->getMessage());
			Minz_Error::error(
				404,
				array('error' => array(_t('page_not_found')))
			);
		}
	}

	/*
	 * Vérifie que la catégorie / flux sélectionné existe
	 * + Initialise correctement les variables de vue get_c et get_f
	 * + Met à jour la variable $this->nb_not_read_cat
	 */
	private function checkAndProcessType($getType, $getId) {
		switch($getType) {
		case 'a':
			$this->view->currentName = _t('your_rss_feeds');
			$this->nb_not_read_cat = $this->view->nb_not_read;
			$this->view->get_c = $getType;
			return true;
		case 's':
			$this->view->currentName = _t('your_favorites');
			$this->nb_not_read_cat = $this->view->nb_favorites['unread'];
			$this->view->get_c = $getType;
			return true;
		case 'c':
			$cat = isset($this->view->cat_aside[$getId]) ? $this->view->cat_aside[$getId] : null;
			if ($cat === null) {
				$catDAO = new FreshRSS_CategoryDAO();
				$cat = $catDAO->searchById($getId);
			}
			if ($cat) {
				$this->view->currentName = $cat->name();
				$this->nb_not_read_cat = $cat->nbNotRead();
				$this->view->get_c = $getId;
				return true;
			} else {
				return false;
			}
		case 'f':
			$feed = FreshRSS_CategoryDAO::findFeed($this->view->cat_aside, $getId);
			if (empty($feed)) {
				$feedDAO = FreshRSS_Factory::createFeedDao();
				$feed = $feedDAO->searchById($getId);
			}
			if ($feed) {
				$this->view->currentName = $feed->name();
				$this->nb_not_read_cat = $feed->nbNotRead();
				$this->view->get_f = $getId;
				$this->view->get_c = $feed->category();
				return true;
			} else {
				return false;
			}
		default:
			return false;
		}
	}
	
	public function aboutAction() {
		Minz_View::prependTitle(_t('about') . ' · ');
	}

	public function logsAction() {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(
				403,
				array('error' => array(_t('access_denied')))
			);
		}

		Minz_View::prependTitle(_t('logs') . ' · ');

		if (Minz_Request::isPost()) {
			FreshRSS_LogDAO::truncate();
		}

		$logs = FreshRSS_LogDAO::lines();	//TODO: ask only the necessary lines

		//gestion pagination
		$page = Minz_Request::param('page', 1);
		$this->view->logsPaginator = new Minz_Paginator($logs);
		$this->view->logsPaginator->_nbItemsPerPage(50);
		$this->view->logsPaginator->_currentPage($page);
	}

	/**
	 * This action handles the login page.
	 */
	public function loginAction() {
		if (FreshRSS_Auth::hasAccess()) {
			Minz_Request::forward(array('c' => 'index', 'a' => 'index'), true);
		}

		invalidateHttpCache();

		$auth_type = Minz_Configuration::authType();
		switch ($auth_type) {
		case 'form':
			Minz_Request::forward(array('c' => 'index', 'a' => 'formLogin'));
			break;
		case 'http_auth':
		case 'none':
			// It should not happened!
			Minz_Error::error(404);
		default:
			// TODO load plugin instead
			Minz_Error::error(404);
		}
	}

	/**
	 *
	 */
	public function formLoginAction() {
		if (FreshRSS_Auth::hasAccess()) {
			Minz_Request::forward(array('c' => 'index', 'a' => 'index'), true);
		}

		invalidateHttpCache();

		$file_mtime = @filemtime(PUBLIC_PATH . '/scripts/bcrypt.min.js');
		Minz_View::appendScript(Minz_Url::display('/scripts/bcrypt.min.js?' . $file_mtime));

		if (Minz_Request::isPost()) {
			$nonce = Minz_Session::param('nonce');
			$username = Minz_Request::param('username', '');
			$challenge = Minz_Request::param('challenge', '');
			try {
				$conf = new FreshRSS_Configuration($username);
			} catch(Minz_Exception $e) {
				// $username is not a valid user, nor the configuration file!
				Minz_Log::warning('Login failure: ' . $e->getMessage());
				Minz_Request::bad(_t('invalid_login'),
				                  array('c' => 'index', 'a' => 'login'));
			}

			$ok = FreshRSS_FormAuth::checkCredentials(
				$username, $conf->passwordHash, $nonce, $challenge
			);
			if ($ok) {
				// Set session parameter to give access to the user.
				Minz_Session::_param('currentUser', $username);
				Minz_Session::_param('passwordHash', $conf->passwordHash);
				FreshRSS_Auth::giveAccess();

				// Set cookie parameter if nedded.
				if (Minz_Request::param('keep_logged_in', false)) {
					FreshRSS_FormAuth::makeCookie($username, $conf->passwordHash);
				} else {
					FreshRSS_FormAuth::deleteCookie();
				}

				// All is good, go back to the index.
				Minz_Request::good(_t('login'),
				                   array('c' => 'index', 'a' => 'index'));
			} else {
				Minz_Log::warning('Password mismatch for' .
				                  ' user=' . $username .
				                  ', nonce=' . $nonce .
				                  ', c=' . $challenge);
				Minz_Request::bad(_t('invalid_login'),
				                  array('c' => 'index', 'a' => 'login'));
			}
		}
	}

	public function logoutAction() {
		invalidateHttpCache();
		FreshRSS_Auth::removeAccess();
		Minz_Request::good(_t('disconnected'),
		                   array('c' => 'index', 'a' => 'index'));
	}
}
