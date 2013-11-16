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
		$nextGet = Request::param ('nextGet', $get); 
		$dateMax = Request::param ('dateMax', 0);

		$is_read = !!$is_read;

		$entryDAO = new EntryDAO ();
		if ($id == false) {
			if (!$get) {
				$entryDAO->markReadEntries ($dateMax);
			} else {
				$typeGet = $get[0];
				$get = substr ($get, 2);

				if ($typeGet == 'c') {
					$entryDAO->markReadCat ($get, $dateMax);
					$this->params = array ('get' => $nextGet); 
				} elseif ($typeGet == 'f') {
					$entryDAO->markReadFeed ($get, $dateMax);
					$this->params = array ('get' => $nextGet);
				}
			}

			$notif = array (
				'type' => 'good',
				'content' => Translate::t ('feeds_marked_read')
			);
			Session::_param ('notification', $notif);
		} else {
			$entryDAO->markRead ($id, $is_read);
		}
	}

	public function bookmarkAction () {
		$this->redirect = true;

		$id = Request::param ('id');
		if ($id) {
			$entryDAO = new EntryDAO ();
			$entryDAO->markFavorite ($id, Request::param ('is_favorite'));
		}
	}

	public function optimizeAction() {
		// La table des entrées a tendance à grossir énormément
		// Cette action permet d'optimiser cette table permettant de grapiller un peu de place
		// Cette fonctionnalité n'est à appeler qu'occasionnellement
		$entryDAO = new EntryDAO();
		$entryDAO->optimizeTable();

		touch(PUBLIC_PATH . '/data/touch.txt');

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
