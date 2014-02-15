<?php

class FreshRSS_index_Controller extends Minz_ActionController {
	private $nb_not_read_cat = 0;

	public function indexAction () {
		$output = Minz_Request::param ('output');
		$token = $this->view->conf->token;

		// check if user is logged in
		if (!$this->view->loginOk && !Minz_Configuration::allowAnonymous()) {
			$token_param = Minz_Request::param ('token', '');
			$token_is_ok = ($token != '' && $token === $token_param);
			if (!($output === 'rss' && $token_is_ok)) {
				return;
			}
		}

		// construction of RSS url of this feed
		$params = Minz_Request::params ();
		$params['output'] = 'rss';
		if (isset ($params['search'])) {
			$params['search'] = urlencode ($params['search']);
		}
		if (!Minz_Configuration::allowAnonymous()) {
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
		} elseif ($output === 'global') {
			Minz_View::appendScript (Minz_Url::display ('/scripts/global_view.js?' . @filemtime(PUBLIC_PATH . '/scripts/global_view.js')));
		}

		$catDAO = new FreshRSS_CategoryDAO();
		$entryDAO = new FreshRSS_EntryDAO();

		$this->view->cat_aside = $catDAO->listCategories ();
		$this->view->nb_favorites = $entryDAO->countUnreadReadFavorites ();
		$this->view->nb_not_read = FreshRSS_CategoryDAO::CountUnreads($this->view->cat_aside, 1);
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

		// mise à jour des titres
		$this->view->rss_title = $this->view->currentName . ' | ' . Minz_View::title();
		if ($this->view->nb_not_read > 0) {
			Minz_View::appendTitle (' (' . formatNumber($this->view->nb_not_read) . ')');
		}
		Minz_View::prependTitle (
			$this->view->currentName .
			($this->nb_not_read_cat > 0 ? ' (' . formatNumber($this->nb_not_read_cat) . ')' : '') .
			' · '
		);

		// On récupère les différents éléments de filtrage
		$this->view->state = $state = Minz_Request::param ('state', $this->view->conf->default_view);
		$filter = Minz_Request::param ('search', '');
		if (!empty($filter)) {
			$state = 'all';	//Search always in read and unread articles
		}
		$this->view->order = $order = Minz_Request::param ('order', $this->view->conf->sort_order);
		$nb = Minz_Request::param ('nb', $this->view->conf->posts_per_page);
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
		$nb_month_old = $this->view->conf->old_entries;
		$date_min = $today - (3600 * 24 * 30 * $nb_month_old);	//Do not use a fast changing value such as time() to allow SQL caching
		$keepHistoryDefault = $this->view->conf->keep_history_default;

		try {
			$entries = $entryDAO->listWhere($getType, $getId, $state, $order, $nb + 1, $first, $filter, $date_min, $keepHistoryDefault);

			// Si on a récupéré aucun article "non lus"
			// on essaye de récupérer tous les articles
			if ($state === 'not_read' && empty($entries)) {
				Minz_Log::record ('Conflicting information about nbNotRead!', Minz_Log::DEBUG);
				$this->view->state = 'all';
				$entries = $entryDAO->listWhere($getType, $getId, 'all', $order, $nb, $first, $filter, $date_min, $keepHistoryDefault);
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
				$this->nb_not_read_cat = $this->view->nb_not_read;
				$this->view->get_c = $getType;
				return true;
			case 's':
				$this->view->currentName = Minz_Translate::t ('your_favorites');
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
					$feedDAO = new FreshRSS_FeedDAO();
					$feed = $feedDAO->searchById($getId);
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
	
	public function statsAction () {
		if (!$this->view->loginOk) {
			Minz_Error::error (
				403,
				array ('error' => array (Minz_Translate::t ('access_denied')))
			);
		}

		Minz_View::prependTitle (Minz_Translate::t ('stats') . ' · ');

		$statsDAO = new FreshRSS_StatsDAO ();
		Minz_View::appendScript (Minz_Url::display ('/scripts/flotr2.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/flotr2.min.js')));
		$this->view->repartition = $statsDAO->calculateEntryRepartition();
		$this->view->count = ($statsDAO->calculateEntryCount());
		$this->view->feedByCategory = $statsDAO->calculateFeedByCategory();
		$this->view->entryByCategory = $statsDAO->calculateEntryByCategory();
		$this->view->topFeed = $statsDAO->calculateTopFeed();
	}

	public function aboutAction () {
		Minz_View::prependTitle (Minz_Translate::t ('about') . ' · ');
	}

	public function logsAction () {
		if (!$this->view->loginOk) {
			Minz_Error::error (
				403,
				array ('error' => array (Minz_Translate::t ('access_denied')))
			);
		}

		Minz_View::prependTitle (Minz_Translate::t ('logs') . ' · ');

		if (Minz_Request::isPost ()) {
			FreshRSS_LogDAO::truncate();
		}

		$logs = FreshRSS_LogDAO::lines();	//TODO: ask only the necessary lines

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

		$loginOk = false;
		$reason = '';
		if ($res['status'] === 'okay') {
			$email = filter_var($res['email'], FILTER_VALIDATE_EMAIL);
			if ($email != '') {
				$personaFile = DATA_PATH . '/persona/' . $email . '.txt';
				if (($currentUser = @file_get_contents($personaFile)) !== false) {
					$currentUser = trim($currentUser);
					if (ctype_alnum($currentUser)) {
						try {
							$this->conf = new FreshRSS_Configuration($currentUser);
							$loginOk = strcasecmp($email, $this->conf->mail_login) === 0;
						} catch (Minz_Exception $e) {
							$reason = 'Invalid configuration for user [' . $currentUser . ']! ' . $e->getMessage();	//Permission denied or conf file does not exist
						}
					} else {
						$reason = 'Invalid username format [' . $currentUser . ']!';
					}
				}
			} else {
				$reason = 'Invalid email format [' . $res['email'] . ']!';
			}
		}
		if ($loginOk) {
			Minz_Session::_param('currentUser', $currentUser);
			Minz_Session::_param ('mail', $email);
			$this->view->loginOk = true;
			invalidateHttpCache();
		} else {
			$res = array ();
			$res['status'] = 'failure';
			$res['reason'] = $reason == '' ? Minz_Translate::t ('invalid_login') : $reason;
			Minz_Log::record ('Persona: ' . $res['reason'], Minz_Log::WARNING);
		}

		header('Content-Type: application/json; charset=UTF-8');
		$this->view->res = json_encode ($res);
	}

	public function logoutAction () {
		$this->view->_useLayout(false);
		invalidateHttpCache();
		Minz_Session::_param('currentUser');
		Minz_Session::_param('mail');
		Minz_Session::_param('passwordHash');
	}

	public function formLoginAction () {
		if (Minz_Request::isPost()) {
			$ok = false;
			$nonce = Minz_Session::param('nonce');
			$username = Minz_Request::param('username', '');
			$c = Minz_Request::param('challenge', '');
			if (ctype_alnum($username) && ctype_graph($c) && ctype_alnum($nonce)) {
				if (!function_exists('password_verify')) {
					include_once(LIB_PATH . '/password_compat.php');
				}
				try {
					$conf = new FreshRSS_Configuration($username);
					$s = $conf->passwordHash;
					$ok = password_verify($nonce . $s, $c);
					if ($ok) {
						Minz_Session::_param('currentUser', $username);
						Minz_Session::_param('passwordHash', $s);
					} else {
						Minz_Log::record('Password mismatch for user ' . $username . ', nonce=' . $nonce . ', c=' . $c, Minz_Log::WARNING);
					}
				} catch (Minz_Exception $me) {
					Minz_Log::record('Login failure: ' . $me->getMessage(), Minz_Log::WARNING);
				}
			} else {
				Minz_Log::record('Invalid credential parameters: user=' . $username . ' challenge=' . $c . ' nonce=' . $nonce, Minz_Log::DEBUG);
			}
			if (!$ok) {
				$notif = array(
					'type' => 'bad',
					'content' => Minz_Translate::t('invalid_login')
				);
				Minz_Session::_param('notification', $notif);
			}
			$this->view->_useLayout(false);
			Minz_Request::forward(array('c' => 'index', 'a' => 'index'), true);
		}
		invalidateHttpCache();
	}

	public function formLogoutAction () {
		$this->view->_useLayout(false);
		invalidateHttpCache();
		Minz_Session::_param('currentUser');
		Minz_Session::_param('mail');
		Minz_Session::_param('passwordHash');
		Minz_Request::forward(array('c' => 'index', 'a' => 'index'), true);
	}
}
