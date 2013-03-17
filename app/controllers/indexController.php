<?php

class indexController extends ActionController {
	private $get = false;
	private $nb_not_read = 0;
	private $mode = 'all';

	public function indexAction () {
		View::appendScript (Url::display ('/scripts/shortcut.js'));
		View::appendScript (Url::display (array ('c' => 'javascript', 'a' => 'main')));

		$entryDAO = new EntryDAO ();
		$feedDAO = new FeedDAO ();
		$catDAO = new CategoryDAO ();

		$error = false;

		// pour optimiser
		$page = Request::param ('page', 1);
		$entryDAO->_nbItemsPerPage ($this->view->conf->postsPerPage ());
		$entryDAO->_currentPage ($page);

		// récupération de la catégorie/flux à filtrer
		$this->initFilter ();
		// Compte le nombre d'articles non lus en prenant en compte le filtre
		$this->countNotRead ();
		// mode de vue (tout ou seulement non lus)
		$this->initCurrentMode ();
		// ordre de listage des flux
		$order = Session::param ('order', $this->view->conf->sortOrder ());
		// recherche sur les titres (pour le moment)
		$search = Request::param ('search');

		// Récupère les flux par catégorie, favoris ou tous
		if ($this->get['type'] == 'all') {
			$entries = $entryDAO->listEntries ($this->mode, $search, $order);
			View::prependTitle ('Vos flux RSS - ');
		} elseif ($this->get['type'] == 'favoris') {
			$entries = $entryDAO->listFavorites ($this->mode, $search, $order);
			View::prependTitle ('Vos favoris - ');
		} elseif ($this->get != false) {
			if ($this->get['type'] == 'c') {
				$cat = $catDAO->searchById ($this->get['filter']);

				if ($cat) {
					$entries = $entryDAO->listByCategory ($this->get['filter'], $this->mode, $search, $order);
					View::prependTitle ($cat->name () . ' - ');
				} else {
					$error = true;
				}
			} elseif ($this->get['type'] == 'f') {
				$feed = $feedDAO->searchById ($this->get['filter']);

				if ($feed) {
					$entries = $entryDAO->listByFeed ($this->get['filter'], $this->mode, $search, $order);
					$this->view->get_c = $feed->category ();
					View::prependTitle ($feed->name () . ' - ');
				} else {
					$error = true;
				}
			} else {
				$error = true;
			}
		} else {
			$error = true;
		}

		if ($error) {
			Error::error (
				404,
				array ('error' => array ('La page que vous cherchez n\'existe pas'))
			);
		} else {
			$this->view->mode = $this->mode;
			$this->view->order = $order;

			try {
				$this->view->entryPaginator = $entryDAO->getPaginator ($entries);
			} catch (CurrentPagePaginationException $e) {

			}

			$this->view->cat_aside = $catDAO->listCategories ();
			$this->view->nb_favorites = $entryDAO->countFavorites ();
			$this->view->nb_total = $entryDAO->count ();
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
	public function changeOrderAction () {
		$order = Request::param ('order');

		if ($order == 'low_to_high') {
			Session::_param ('order', 'low_to_high');
		} else {
			Session::_param ('order', 'high_to_low');
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

	private function initFilter () {
		$get = Request::param ('get');
		$this->view->get_c = false;
		$this->view->get_f = false;

		$typeGet = $get[0];
		$filter = substr ($get, 2);

		if ($get == 'favoris') {
			$this->view->get_c = $get;

			$this->get = array (
				'type' => $get,
				'filter' => $get
			);
		} elseif ($get == false) {
			$this->get = array (
				'type' => 'all',
				'filter' => 'all'
			);
		} else {
			if ($typeGet == 'f') {
				$this->view->get_f = $filter;

				$this->get = array (
					'type' => $typeGet,
					'filter' => $filter
				);
			} elseif ($typeGet == 'c') {
				$this->view->get_c = $filter;

				$this->get = array (
					'type' => $typeGet,
					'filter' => $filter
				);
			} else {
				$this->get = false;
			}
		}
	}

	private function countNotRead () {
		$entryDAO = new EntryDAO ();

		if ($this->get != false) {
			if ($this->get['type'] == 'all') {
				$this->nb_not_read = $this->view->nb_not_read;
			} elseif ($this->get['type'] == 'favoris') {
				$this->nb_not_read = $entryDAO->countNotReadFavorites ();
			} elseif ($this->get['type'] == 'c') {
				$this->nb_not_read = $entryDAO->countNotReadByCat ($this->get['filter']);
			} elseif ($this->get['type'] == 'f') {
				$this->nb_not_read = $entryDAO->countNotReadByFeed ($this->get['filter']);
			}
		}
	}

	private function initCurrentMode () {
		$default_view = $this->view->conf->defaultView ();
		$mode = Session::param ('mode');
		if ($mode == false) {
			if ($default_view == 'not_read' && $this->nb_not_read < 1) {
				$mode = 'all';
			} else {
				$mode = $default_view;
			}
		}

		$this->mode = $mode;
	}
}
