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
			if ($output === 'rss' && !$token_is_ok) {
				Minz_Error::error (
					403,
					array ('error' => array (Minz_Translate::t ('access_denied')))
				);
				return;
			} elseif ($output !== 'rss') {
				// "hard" redirection is not required, just ask dispatcher to
				// forward to the login form without 302 redirection
				Minz_Request::forward(array('c' => 'index', 'a' => 'formLogin'));
				return;
			}
		}

		$params = Minz_Request::params ();
		if (isset ($params['search'])) {
			$params['search'] = urlencode ($params['search']);
		}

		$this->view->url = array (
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
		$entryDAO = FreshRSS_Factory::createEntryDao();

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
			Minz_View::prependTitle('(' . formatNumber($this->view->nb_not_read) . ') ');
		}
		Minz_View::prependTitle(
			($this->nb_not_read_cat > 0 ? '(' . formatNumber($this->nb_not_read_cat) . ') ' : '') .
			$this->view->currentName .
			' · '
		);

		// On récupère les différents éléments de filtrage
		$this->view->state = $state = Minz_Request::param ('state', $this->view->conf->default_view);
		$state_param = Minz_Request::param ('state', null);
		$filter = Minz_Request::param ('search', '');
		$this->view->order = $order = Minz_Request::param ('order', $this->view->conf->sort_order);
		$nb = Minz_Request::param ('nb', $this->view->conf->posts_per_page);
		$first = Minz_Request::param ('next', '');

		if ($state === FreshRSS_Entry::STATE_NOT_READ) {	//Any unread article in this category at all?
			switch ($getType) {
				case 'a':
					$hasUnread = $this->view->nb_not_read > 0;
					break;
				case 's':
					// This is deprecated. The favorite button does not exist anymore
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
			if (!$hasUnread && ($state_param === null)) {
				$this->view->state = $state = FreshRSS_Entry::STATE_ALL;
			}
		}

		$today = @strtotime('today');
		$this->view->today = $today;

		// on calcule la date des articles les plus anciens qu'on affiche
		$nb_month_old = $this->view->conf->old_entries;
		$date_min = $today - (3600 * 24 * 30 * $nb_month_old);	//Do not use a fast changing value such as time() to allow SQL caching
		$keepHistoryDefault = $this->view->conf->keep_history_default;

		try {
			$entries = $entryDAO->listWhere($getType, $getId, $state, $order, $nb + 1, $first, $filter, $date_min, true, $keepHistoryDefault);

			// Si on a récupéré aucun article "non lus"
			// on essaye de récupérer tous les articles
			if ($state === FreshRSS_Entry::STATE_NOT_READ && empty($entries) && ($state_param === null) && ($filter == '')) {
				Minz_Log::record('Conflicting information about nbNotRead!', Minz_Log::DEBUG);
				$feedDAO = FreshRSS_Factory::createFeedDao();
				try {
					$feedDAO->updateCachedValues();
				} catch (Exception $ex) {
					Minz_Log::record('Failed to automatically correct nbNotRead! ' + $ex->getMessage(), Minz_Log::NOTICE);
				}
				$this->view->state = FreshRSS_Entry::STATE_ALL;
				$entries = $entryDAO->listWhere($getType, $getId, $this->view->state, $order, $nb, $first, $filter, $date_min, true, $keepHistoryDefault);
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
					$feedDAO = FreshRSS_Factory::createFeedDao();
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
		} elseif (Minz_Configuration::unsafeAutologinEnabled() && isset($_GET['u']) && isset($_GET['p'])) {
			Minz_Session::_param('currentUser');
			Minz_Session::_param('mail');
			Minz_Session::_param('passwordHash');
			$username = ctype_alnum($_GET['u']) ? $_GET['u'] : '';
			$passwordPlain = $_GET['p'];
			Minz_Request::_param('p');	//Discard plain-text password ASAP
			$_GET['p'] = '';
			if (!function_exists('password_verify')) {
				include_once(LIB_PATH . '/password_compat.php');
			}
			try {
				$conf = new FreshRSS_Configuration($username);
				$s = $conf->passwordHash;
				$ok = password_verify($passwordPlain, $s);
				unset($passwordPlain);
				if ($ok) {
					Minz_Session::_param('currentUser', $username);
					Minz_Session::_param('passwordHash', $s);
				} else {
					Minz_Log::record('Unsafe password mismatch for user ' . $username, Minz_Log::WARNING);
				}
			} catch (Minz_Exception $me) {
				Minz_Log::record('Unsafe login failure: ' . $me->getMessage(), Minz_Log::WARNING);
			}
			Minz_Request::forward(array('c' => 'index', 'a' => 'index'), true);
		} elseif (!Minz_Configuration::canLogIn()) {
			Minz_Error::error (
				403,
				array ('error' => array (Minz_Translate::t ('access_denied')))
			);
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
