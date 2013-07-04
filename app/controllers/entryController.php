<?php

class entryController extends ActionController {
	public function firstAction () {
		if (login_is_conf ($this->view->conf) && !is_logged ()) {
			Error::error (
				403,
				array ('error' => array (Translate::t ('access_denied')))
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
				'content' => Translate::t ('feeds_marked_read')
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

	public function optimizeAction() {
		// La table des entrées a tendance à grossir énormément
		// Cette action permet d'optimiser cette table permettant de grapiller un peu de place
		// Cette fonctionnalité n'est à appeler qu'occasionnellement
		$entryDAO = new EntryDAO();
		$entryDAO->optimizeTable();

		$notif = array (
			'type' => 'good',
			'content' => Translate::t ('optimization_complete')
		);
		Session::_param ('notification', $notif);

		Request::forward(array(
			'c' => 'configure',
			'a' => 'display'
		), true);
	}
}
