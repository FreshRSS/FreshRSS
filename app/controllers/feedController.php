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
				array ('error' => array (Translate::t ('access_denied')))
			);
		} else {
			if (Request::isPost ()) {
				$url = Request::param ('url_rss');
				$cat = Request::param ('category');
				$user = Request::param ('username');
				$pass = Request::param ('password');
				$params = array ();

				try {
					$feed = new Feed ($url);
					$feed->_category ($cat);

					$httpAuth = '';
					if ($user != '' || $pass != '') {
						$httpAuth = $user . ':' . $pass;
					}
					$feed->_httpAuth ($httpAuth);

					$feed->load ();

					$feedDAO = new FeedDAO ();
					$values = array (
						'id' => $feed->id (),
						'url' => $feed->url (),
						'category' => $feed->category (),
						'name' => $feed->name (),
						'website' => $feed->website (),
						'description' => $feed->description (),
						'lastUpdate' => time (),
						'httpAuth' => $feed->httpAuth (),
					);

					if ($feedDAO->searchByUrl ($values['url'])) {
						$notif = array (
							'type' => 'bad',
							'content' => Translate::t ('already_subscribed', $feed->name ())
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
							'content' => Translate::t ('feed_added', $feed->name ())
						);
						Session::_param ('notification', $notif);
						$params['id'] = $feed->id ();
					} else {
						// notif
						$notif = array (
							'type' => 'bad',
							'content' => Translate::t ('feed_not_added', $feed->name ())
						);
						Session::_param ('notification', $notif);
					}
				} catch (FeedException $e) {
					Log::record ($e->getMessage (), Log::ERROR);
					$notif = array (
						'type' => 'bad',
						'content' => Translate::t ('internal_problem_feed')
					);
					Session::_param ('notification', $notif);
				} catch (Exception $e) {
					// notif
					$notif = array (
						'type' => 'bad',
						'content' => Translate::t ('invalid_url', $url)
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
		$url = array ();
		if ($i == 1) {
			$feed = reset ($feeds);
			$notif = array (
				'type' => 'good',
				'content' => Translate::t ('feed_actualized', $feed->name ())
			);
			$url['params'] = array ('get' => 'f_' . $feed->id ());
		} elseif ($i > 0) {
			$notif = array (
				'type' => 'good',
				'content' => Translate::t ('n_feeds_actualized', $i)
			);
		} else {
			$notif = array (
				'type' => 'bad',
				'content' => Translate::t ('no_feed_actualized')
			);
		}

		if (Request::param ('ajax', 0) == 0) {
			Session::_param ('notification', $notif);
			Request::forward ($url, true);
		} else {
			$notif = array (
				'type' => 'good',
				'content' => Translate::t ('feeds_actualized')
			);
			Session::_param ('notification', $notif);
			$this->view->_useLayout (false);
		}
	}

	public function massiveImportAction () {
		if (login_is_conf ($this->view->conf) && !is_logged ()) {
			Error::error (
				403,
				array ('error' => array (Translate::t ('access_denied')))
			);
		} else {
			$entryDAO = new EntryDAO ();
			$feedDAO = new FeedDAO ();

			$categories = Request::param ('categories', array ());
			$feeds = Request::param ('feeds', array ());

			$this->addCategories ($categories);

			$nb_month_old = $this->view->conf->oldEntries ();
			$date_min = time () - (60 * 60 * 24 * 30 * $nb_month_old);

			$error = false;
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
						if (!$feedDAO->addFeed ($values)) {
							$error = true;
						}
					}
				} catch (FeedException $e) {
					$error = true;
					Log::record ($e->getMessage (), Log::ERROR);
				}
			}

			if ($error) {
				$res = Translate::t ('feeds_imported_with_errors');
			} else {
				$res = Translate::t ('feeds_imported');
			}
			$notif = array (
				'type' => 'good',
				'content' => $res
			);
			Session::_param ('notification', $notif);

			Request::forward (array (
				'c' => 'configure',
				'a' => 'importExport'
			), true);
		}
	}

	public function deleteAction () {
		if (login_is_conf ($this->view->conf) && !is_logged ()) {
			Error::error (
				403,
				array ('error' => array (Translate::t ('access_denied')))
			);
		} else {
			$type = Request::param ('type', 'feed');
			$id = Request::param ('id');

			$feedDAO = new FeedDAO ();
			if ($type == 'category') {
				if ($feedDAO->deleteFeedByCategory ($id)) {
					$notif = array (
						'type' => 'good',
						'content' => Translate::t ('category_emptied')
					);
				} else {
					$notif = array (
						'type' => 'bad',
						'content' => Translate::t ('error_occured')
					);
				}
			} else {
				if ($feedDAO->deleteFeed ($id)) {
					$notif = array (
						'type' => 'good',
						'content' => Translate::t ('feed_deleted')
					);
				} else {
					$notif = array (
						'type' => 'bad',
						'content' => Translate::t ('error_occured')
					);
				}
			}

			Session::_param ('notification', $notif);

			if ($type == 'category') {
				Request::forward (array ('c' => 'configure', 'a' => 'categorize'), true);
			} else {
				Request::forward (array ('c' => 'configure', 'a' => 'feed'), true);
			}
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
