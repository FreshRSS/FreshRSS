<?php

class indexController extends ActionController {
	public function indexAction () {
		View::appendScript (Url::display ('/scripts/smoothscroll.js'));
		View::appendScript (Url::display ('/scripts/shortcut.js'));
		View::appendScript (Url::display (array ('c' => 'javascript', 'a' => 'main')));

		$entryDAO = new EntryDAO ();
		$feedDAO = new FeedDAO ();
		$catDAO = new CategoryDAO ();

		// pour optimiser
		$page = Request::param ('page', 1);
		$entryDAO->_nbItemsPerPage ($this->view->conf->postsPerPage ());
		$entryDAO->_currentPage ($page);

		$default_view = $this->view->conf->defaultView ();
		$mode = Session::param ('mode');
		if ($mode == false) {
			if ($default_view == 'not_read' && $this->view->nb_not_read < 1) {
				$mode = 'all';
			} else {
				$mode = $default_view;
			}
		}

		$get = Request::param ('get');
		$this->view->get_c = false;
		$this->view->get_f = false;
		$order = $this->view->conf->sortOrder ();

		$search = Request::param ('search');

		$error = false;

		// Récupère les flux par catégorie, favoris ou tous
		if ($get == 'favoris') {
			$entries = $entryDAO->listFavorites ($mode, $search, $order);
			$this->view->get_c = $get;
			View::prependTitle ('Vos favoris - ');
		} elseif ($get != false) {
			$typeGet = $get[0];
			$get = substr ($get, 2);

			if ($typeGet == 'c') {
				$entries = $entryDAO->listByCategory ($get, $mode, $search, $order);
				$cat = $catDAO->searchById ($get);

				if ($cat) {
					$this->view->get_c = $get;
					View::prependTitle ($cat->name () . ' - ');
				} else {
					$error = true;
				}
			} elseif ($typeGet == 'f') {
				$entries = $entryDAO->listByFeed ($get, $mode, $search, $order);
				$feed = $feedDAO->searchById ($get);

				if ($feed) {
					$this->view->get_f = $get;
					$this->view->get_c = $feed->category ();
					View::prependTitle ($feed->name () . ' - ');
				} else {
					$error = true;
				}
			} else {
				$error = true;
			}
		} else {
			View::prependTitle ('Vos flux RSS - ');
		}

		$this->view->mode = $mode;

		// Cas où on ne choisie ni catégorie ni les favoris
		// ou si la catégorie ne correspond à aucune
		if (!isset ($entries)) {
			$entries = $entryDAO->listEntries ($mode, $search, $order);
		}

		try {
			$this->view->entryPaginator = $entryDAO->getPaginator ($entries);
		} catch (CurrentPagePaginationException $e) { }

		$this->view->cat_aside = $catDAO->listCategories ();
		$this->view->nb_favorites = $entryDAO->countFavorites ();
		$this->view->nb_total = $entryDAO->count ();

		if ($error) {
			Error::error (
				404,
				array ('error' => array ('La page que vous cherchez n\'existe pas'))
			);
		}
	}

	public function aboutAction () {
		View::prependTitle ('À propos - ');
	}

	public function changeModeAction () {
		$mode = Request::param ('mode');

		if ($mode == 'not_read') {
			Session::_param ('mode', 'not_read');
		} else {
			Session::_param ('mode', 'all');
		}

		Request::forward (array (), true);
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
			$res['reason'] = 'L\'identifiant est invalide';
		}

		$this->view->res = json_encode ($res);
	}

	public function logoutAction () {
		$this->view->_useLayout (false);
		Session::_param ('mail');
	}
}
