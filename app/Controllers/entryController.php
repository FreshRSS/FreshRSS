<?php

class FreshRSS_entry_Controller extends Minz_ActionController {
	public function firstAction () {
		if (login_is_conf ($this->view->conf) && !is_logged ()) {
			Minz_Error::error (
				403,
				array ('error' => array (Minz_Translate::t ('access_denied')))
			);
		}

		$this->params = array ();
		$this->redirect = false;
		$ajax = Minz_Request::param ('ajax');
		if ($ajax) {
			$this->view->_useLayout (false);
		}
	}
	public function lastAction () {
		$ajax = Minz_Request::param ('ajax');
		if (!$ajax && $this->redirect) {
			Minz_Request::forward (array (
				'c' => 'index',
				'a' => 'index',
				'params' => $this->params
			), true);
		} else {
			Minz_Request::_param ('ajax');
		}
	}

	public function readAction () {
		$this->redirect = true;

		$id = Minz_Request::param ('id');
		$is_read = Minz_Request::param ('is_read');
		$get = Minz_Request::param ('get');
		$nextGet = Minz_Request::param ('nextGet', $get); 
		$idMax = Minz_Request::param ('idMax', 0);

		$is_read = !!$is_read;

		$entryDAO = new FreshRSS_EntryDAO ();
		if ($id == false) {
			if (!$get) {
				$entryDAO->markReadEntries ($idMax);
			} else {
				$typeGet = $get[0];
				$get = substr ($get, 2);
				switch ($typeGet) {
					case 'c':
						$entryDAO->markReadCat ($get, $idMax);
						break;
					case 'f':
						$entryDAO->markReadFeed ($get, $idMax);
						break;
					case 's':
						$entryDAO->markReadEntries ($idMax, true);
						break;
					case 'a':
						$entryDAO->markReadEntries ($idMax);
						break;
				}
				if ($nextGet !== 'a') {
					$this->params = array ('get' => $nextGet);
				}
			}

			$notif = array (
				'type' => 'good',
				'content' => Minz_Translate::t ('feeds_marked_read')
			);
			Minz_Session::_param ('notification', $notif);
		} else {
			$entryDAO->markRead ($id, $is_read);
		}
	}

	public function bookmarkAction () {
		$this->redirect = true;

		$id = Minz_Request::param ('id');
		if ($id) {
			$entryDAO = new FreshRSS_EntryDAO ();
			$entryDAO->markFavorite ($id, Minz_Request::param ('is_favorite'));
		}
	}

	public function optimizeAction() {
		@set_time_limit(300);
		invalidateHttpCache();

		// La table des entrées a tendance à grossir énormément
		// Cette action permet d'optimiser cette table permettant de grapiller un peu de place
		// Cette fonctionnalité n'est à appeler qu'occasionnellement
		$entryDAO = new FreshRSS_EntryDAO();
		$entryDAO->optimizeTable();

		invalidateHttpCache();

		$notif = array (
			'type' => 'good',
			'content' => Minz_Translate::t ('optimization_complete')
		);
		Minz_Session::_param ('notification', $notif);

		Minz_Request::forward(array(
			'c' => 'configure',
			'a' => 'display'
		), true);
	}
}
