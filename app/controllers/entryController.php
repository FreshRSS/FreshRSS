<?php

class entryController extends ActionController {
	public function firstAction () {
		if (login_is_conf ($this->view->conf) && !is_logged ()) {
			Error::error (
				403,
				array ('error' => array ('Vous n\'avez pas le droit d\'accéder à cette page'))
			);
		}

		$this->params = array ();
		$this->redirect = false;
		$ajax = Request::param ('ajax');
		if ($ajax) {
			$this->view->_useLayout (false);
		}
	}
	public function lastAction () {
		$ajax = Request::param ('ajax');
		if (!$ajax && $this->redirect) {
			Request::forward (array (
				'c' => 'index',
				'a' => 'index',
				'params' => $this->params
			), true);
		} else {
			Request::_param ('ajax');
		}
	}

	public function readAction () {
		$this->redirect = true;

		$id = Request::param ('id');
		$is_read = Request::param ('is_read');
		$get = Request::param ('get');
		$dateMax = Request::param ('dateMax', time ());

		if ($is_read) {
			$is_read = true;
		} else {
			$is_read = false;
		}

		$entryDAO = new EntryDAO ();
		if ($id == false) {
			if (!$get) {
				$entryDAO->markReadEntries ($is_read, $dateMax);
			} else {
				$typeGet = $get[0];
				$get = substr ($get, 2);

				if ($typeGet == 'c') {
					$entryDAO->markReadCat ($get, $is_read, $dateMax);
					$this->params = array ('get' => 'c_' . $get);
				} elseif ($typeGet == 'f') {
					$entryDAO->markReadFeed ($get, $is_read, $dateMax);
					$this->params = array ('get' => 'f_' . $get);
				}
			}

			// notif
			$notif = array (
				'type' => 'good',
				'content' => 'Les flux ont été marqués comme lu'
			);
			Session::_param ('notification', $notif);
		} else {
			$entryDAO->updateEntry ($id, array ('is_read' => $is_read));
		}
	}

	public function bookmarkAction () {
		$this->redirect = true;

		$id = Request::param ('id');
		$is_fav = Request::param ('is_favorite');

		if ($is_fav) {
			$is_fav = true;
		} else {
			$is_fav = false;
		}

		$entryDAO = new EntryDAO ();
		if ($id != false) {
			$entry = $entryDAO->searchById ($id);

			if ($entry != false) {
				$values = array (
					'is_favorite' => $is_fav,
					'lastUpdate' => time ()
				);

				$entryDAO->updateEntry ($entry->id (), $values);
			}
		}
	}

	public function noteAction () {
		View::appendScript (Url::display (array ('c' => 'javascript', 'a' => 'main')));

		$not_found = false;
		$entryDAO = new EntryDAO ();
		$catDAO = new CategoryDAO ();

		$id = Request::param ('id');
		if ($id) {
			$entry = $entryDAO->searchById ($id);

			if ($entry) {
				$feed = $entry->feed (true);

				if (Request::isPost ()) {
					$note = htmlspecialchars (Request::param ('note', ''));
					$public = Request::param ('public', 'no');
					if ($public == 'yes') {
						$public = true;
					} else {
						$public = false;
					}

					$values = array (
						'annotation' => $note,
						'is_public' => $public,
						'lastUpdate' => time ()
					);

					if ($entryDAO->updateEntry ($id, $values)) {
						$notif = array (
							'type' => 'good',
							'content' => 'Modifications enregistrées'
						);
					} else {
						$notif = array (
							'type' => 'bad',
							'content' => 'Une erreur est survenue'
						);
					}
					Session::_param ('notification', $notif);
					Request::forward (array (
						'c' => 'entry',
						'a' => 'note',
						'params' => array (
							'id' => $id
						)
					), true);
				}
			} else {
				$not_found = true;
			}
		} else {
			$not_found = true;
		}

		if ($not_found) {
			Error::error (
				404,
				array ('error' => array ('La page que vous cherchez n\'existe pas'))
			);
		} else {
			$this->view->entry = $entry;
			$this->view->cat_aside = $catDAO->listCategories ();
			$this->view->nb_favorites = $entryDAO->countFavorites ();
			$this->view->nb_total = $entryDAO->count ();
			$this->view->get_c = $feed->category ();
			$this->view->get_f = $feed->id ();
		}
	}
}
