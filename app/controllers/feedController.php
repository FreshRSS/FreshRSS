<?php

class feedController extends ActionController {
	public function firstAction () {
		$catDAO = new CategoryDAO ();
		$catDAO->checkDefault ();
	}

	public function addAction () {
		if (login_is_conf ($this->view->conf) && !is_logged ()) {
			Error::error (
				403,
				array ('error' => array ('Vous n\'avez pas le droit d\'accéder à cette page'))
			);
		} else {
			if (Request::isPost ()) {
				$url = Request::param ('url_rss');
				$cat = Request::param ('category');
				$params = array ();

				try {
					$feed = new Feed ($url);
					$feed->_category ($cat);
					$feed->load ();

					$feedDAO = new FeedDAO ();
					$values = array (
						'id' => $feed->id (),
						'url' => $feed->url (),
						'category' => $feed->category (),
						'name' => $feed->name (),
						'website' => $feed->website (),
						'description' => $feed->description (),
						'lastUpdate' => time ()
					);

					if ($feedDAO->searchByUrl ($values['url'])) {
						$notif = array (
							'type' => 'bad',
							'content' => 'Vous êtes déjà abonné à <em>' . $feed->name () . '</em>'
						);
						Session::_param ('notification', $notif);
					} elseif ($feedDAO->addFeed ($values)) {
						$entryDAO = new EntryDAO ();
						$entries = $feed->entries ();

						foreach ($entries as $entry) {
							$values = $entry->toArray ();
							$entryDAO->addEntry ($values);
						}

						// notif
						$notif = array (
							'type' => 'good',
							'content' => 'Le flux <em>' . $feed->name () . '</em> a bien été ajouté'
						);
						Session::_param ('notification', $notif);
						$params['id'] = $feed->id ();
					} else {
						// notif
						$notif = array (
							'type' => 'bad',
							'content' => '<em>' . $feed->name () . '</em> n\' a pas pu être ajouté'
						);
						Session::_param ('notification', $notif);
					}
				} catch (FeedException $e) {
					Log::record ($e->getMessage (), Log::ERROR);
					$notif = array (
						'type' => 'bad',
						'content' => 'Un problème interne a été rencontré, le flux n\'a pas pu être ajouté'
					);
					Session::_param ('notification', $notif);
				} catch (FileNotExistException $e) {
					Log::record ($e->getMessage (), Log::ERROR);
					// notif
					$notif = array (
						'type' => 'bad',
						'content' => 'Un problème de configuration a empêché l\'ajout du flux. Voir les logs pour plus d\'informations'
					);
					Session::_param ('notification', $notif);
				} catch (Exception $e) {
					// notif
					$notif = array (
						'type' => 'bad',
						'content' => 'L\'url <em>' . $url . '</em> est invalide'
					);
					Session::_param ('notification', $notif);
				}

				Request::forward (array ('c' => 'configure', 'a' => 'feed', 'params' => $params), true);
			}
		}
	}

	public function actualizeAction () {
		$feedDAO = new FeedDAO ();
		$entryDAO = new EntryDAO ();

		$id = Request::param ('id');
		$feeds = array ();
		if ($id) {
			$feed = $feedDAO->searchById ($id);
			if ($feed) {
				$feeds = array ($feed);
			}
		} else {
			$feeds = $feedDAO->listFeedsOrderUpdate ();
		}

		// pour ne pas ajouter des entrées trop anciennes
		$nb_month_old = $this->view->conf->oldEntries ();
		$date_min = time () - (60 * 60 * 24 * 30 * $nb_month_old);

		$i = 0;
		foreach ($feeds as $feed) {
			try {
				$feed->load ();
				$entries = $feed->entries ();

				foreach ($entries as $entry) {
					if ($entry->date (true) >= $date_min) {
						$values = $entry->toArray ();
						$entryDAO->addEntry ($values);
					}
				}

				$feedDAO->updateLastUpdate ($feed->id ());
			} catch (FeedException $e) {
				Log::record ($e->getMessage (), Log::ERROR);
			}

			$i++;
			if ($i >= 10) {
				break;
			}
		}

		$entryDAO->cleanOldEntries ($nb_month_old);

		// notif
		if ($i == 1) {
			$feed = reset ($feeds);
			$notif = array (
				'type' => 'good',
				'content' => '<em>' . $feed->name () . '</em> a été mis à jour'
			);
		} elseif ($i > 0) {
			$notif = array (
				'type' => 'good',
				'content' => $i . ' flux ont été mis à jour'
			);
		} else {
			$notif = array (
				'type' => 'bad',
				'content' => 'Aucun flux n\'a pu être mis à jour'
			);
		}

		if (Request::param ('ajax', 0) == 0) {
			Session::_param ('notification', $notif);
			Request::forward (array (), true);
		} else {
			$notif = array (
				'type' => 'good',
				'content' => 'Les flux ont été mis à jour'
			);
			Session::_param ('notification', $notif);
			$this->view->_useLayout (false);
		}
	}

	public function massiveImportAction () {
		if (login_is_conf ($this->view->conf) && !is_logged ()) {
			Error::error (
				403,
				array ('error' => array ('Vous n\'avez pas le droit d\'accéder à cette page'))
			);
		} else {
			$entryDAO = new EntryDAO ();
			$feedDAO = new FeedDAO ();

			$categories = Request::param ('categories', array ());
			$feeds = Request::param ('feeds', array ());

			$this->addCategories ($categories);

			$nb_month_old = $this->view->conf->oldEntries ();
			$date_min = time () - (60 * 60 * 24 * 30 * $nb_month_old);

			$i = 0;
			foreach ($feeds as $feed) {
				try {
					$feed->load ();

					// Enregistrement du flux
					$values = array (
						'id' => $feed->id (),
						'url' => $feed->url (),
						'category' => $feed->category (),
						'name' => $feed->name (),
						'website' => $feed->website (),
						'description' => $feed->description (),
						'lastUpdate' => 0
					);

					if (!$feedDAO->searchByUrl ($values['url'])) {
						$feedDAO->addFeed ($values);
					}
				} catch (FeedException $e) {
					Log::record ($e->getMessage (), Log::ERROR);
				}
			}

			Request::forward (array (
				'c' => 'feed',
				'a' => 'actualize'
			));
		}
	}

	public function deleteAction () {
		if (login_is_conf ($this->view->conf) && !is_logged ()) {
			Error::error (
				403,
				array ('error' => array ('Vous n\'avez pas le droit d\'accéder à cette page'))
			);
		} else {
			$id = Request::param ('id');

			$feedDAO = new FeedDAO ();
			$feedDAO->deleteFeed ($id);

			// notif
			$notif = array (
				'type' => 'good',
				'content' => 'Le flux a été supprimé'
			);
			Session::_param ('notification', $notif);

			Request::forward (array ('c' => 'configure', 'a' => 'feed'), true);
		}
	}

	private function addCategories ($categories) {
		$catDAO = new CategoryDAO ();

		foreach ($categories as $cat) {
			if (!$catDAO->searchByName ($cat->name ())) {
				$values = array (
					'id' => $cat->id (),
					'name' => $cat->name (),
					'color' => $cat->color ()
				);
				$catDAO->addCategory ($values);
			}
		}
	}
}
