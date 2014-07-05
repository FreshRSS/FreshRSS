<?php

class FreshRSS_entry_Controller extends Minz_ActionController {
	public function firstAction () {
		if (!$this->view->loginOk) {
			Minz_Error::error (
				403,
				array ('error' => array (Minz_Translate::t ('access_denied')))
			);
		}

		$this->params = array ();
		$output = Minz_Request::param('output', '');
		if (($output != '') && ($this->view->conf->view_mode !== $output)) {
			$this->params['output'] = $output;
		}

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
		$get = Minz_Request::param ('get');
		$nextGet = Minz_Request::param ('nextGet', $get); 
		$idMax = Minz_Request::param ('idMax', 0);

		$entryDAO = FreshRSS_Factory::createEntryDao();
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
					$this->params['get'] = $nextGet;
				}
			}

			$notif = array (
				'type' => 'good',
				'content' => Minz_Translate::t ('feeds_marked_read')
			);
			Minz_Session::_param ('notification', $notif);
		} else {
			$is_read = (bool)(Minz_Request::param ('is_read', true));
			$entryDAO->markRead ($id, $is_read);
		}
	}

	public function bookmarkAction () {
		$this->redirect = true;

		$id = Minz_Request::param ('id');
		if ($id) {
			$entryDAO = FreshRSS_Factory::createEntryDao();
			$entryDAO->markFavorite ($id, (bool)(Minz_Request::param ('is_favorite', true)));
		}
	}

	public function optimizeAction() {
		if (Minz_Request::isPost()) {
			@set_time_limit(300);

			// La table des entrées a tendance à grossir énormément
			// Cette action permet d'optimiser cette table permettant de grapiller un peu de place
			// Cette fonctionnalité n'est à appeler qu'occasionnellement
			$entryDAO = FreshRSS_Factory::createEntryDao();
			$entryDAO->optimizeTable();

			$feedDAO = FreshRSS_Factory::createFeedDao();
			$feedDAO->updateCachedValues();

			invalidateHttpCache();

			$notif = array (
				'type' => 'good',
				'content' => Minz_Translate::t ('optimization_complete')
			);
			Minz_Session::_param ('notification', $notif);
		}

		Minz_Request::forward(array(
			'c' => 'configure',
			'a' => 'archiving'
		), true);
	}

	public function purgeAction() {
		@set_time_limit(300);

		$nb_month_old = max($this->view->conf->old_entries, 1);
		$date_min = time() - (3600 * 24 * 30 * $nb_month_old);

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$feeds = $feedDAO->listFeeds();
		$nbTotal = 0;

		invalidateHttpCache();

		foreach ($feeds as $feed) {
			$feedHistory = $feed->keepHistory();
			if ($feedHistory == -2) {	//default
				$feedHistory = $this->view->conf->keep_history_default;
			}
			if ($feedHistory >= 0) {
				$nb = $feedDAO->cleanOldEntries($feed->id(), $date_min, $feedHistory);
				if ($nb > 0) {
					$nbTotal += $nb;
					Minz_Log::record($nb . ' old entries cleaned in feed [' . $feed->url() . ']', Minz_Log::DEBUG);
					//$feedDAO->updateLastUpdate($feed->id());
				}
			}
		}

		$feedDAO->updateCachedValues();

		invalidateHttpCache();

		$notif = array(
			'type' => 'good',
			'content' => Minz_Translate::t('purge_completed', $nbTotal)
		);
		Minz_Session::_param('notification', $notif);

		Minz_Request::forward(array(
			'c' => 'configure',
			'a' => 'archiving'
		), true);
	}
}
