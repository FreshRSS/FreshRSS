<?php

class feedController extends ActionController {
	public function firstAction () {
		$token = $this->view->conf->token();
		$token_param = Request::param ('token', '');
		$token_is_ok = ($token != '' && $token == $token_param);
		$action = Request::actionName ();

		if (login_is_conf ($this->view->conf) &&
				!is_logged () &&
				!($token_is_ok && $action == 'actualize')) {
			Error::error (
				403,
				array ('error' => array (Translate::t ('access_denied')))
			);
		}

		$this->catDAO = new CategoryDAO ();
		$this->catDAO->checkDefault ();
	}

	private static function entryDateComparer($e1, $e2) {
		$d1 = $e1->date(true);
		$d2 = $e2->date(true);
		if ($d1 === $d2) {
			return 0;
		}
		return ($d1 < $d2) ? -1 : 1;
	}

	public function addAction () {
		@set_time_limit(300);

		if (Request::isPost ()) {
			$url = Request::param ('url_rss');
			$cat = Request::param ('category', false);
			if ($cat === false) {
				$def_cat = $this->catDAO->getDefault ();
				$cat = $def_cat->id ();
			}

			$user = Request::param ('username');
			$pass = Request::param ('password');
			$params = array ();

			$transactionStarted = false;
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
					'url' => $feed->url (),
					'category' => $feed->category (),
					'name' => $feed->name (),
					'website' => $feed->website (),
					'description' => $feed->description (),
					'lastUpdate' => time (),
					'httpAuth' => $feed->httpAuth (),
				);

				if ($feedDAO->searchByUrl ($values['url'])) {
					// on est déjà abonné à ce flux
					$notif = array (
						'type' => 'bad',
						'content' => Translate::t ('already_subscribed', $feed->name ())
					);
					Session::_param ('notification', $notif);
				} else {
					$id = $feedDAO->addFeed ($values);
					if (!$id) {
						// problème au niveau de la base de données
						$notif = array (
							'type' => 'bad',
							'content' => Translate::t ('feed_not_added', $feed->name ())
						);
						Session::_param ('notification', $notif);
					} else {
						$feed->_id ($id);
						$feed->faviconPrepare();

						$is_read = $this->view->conf->markUponReception() === 'yes' ? 1 : 0;

						$entryDAO = new EntryDAO ();
						$entries = $feed->entries ();
						usort($entries, 'self::entryDateComparer');

						// on calcule la date des articles les plus anciens qu'on accepte
						$nb_month_old = $this->view->conf->oldEntries ();
						$date_min = time () - (60 * 60 * 24 * 30 * $nb_month_old);

						$transactionStarted = true;
						$feedDAO->beginTransaction ();
						// on ajoute les articles en masse sans vérification
						foreach ($entries as $entry) {
							if ($entry->date (true) >= $date_min ||
							    $feed->keepHistory ()) {
								$values = $entry->toArray ();
								$values['id_feed'] = $feed->id ();
								$values['id'] = min(time(), $entry->date (true)) . '.' . rand(0, 999999);
								$values['is_read'] = $is_read;
								$entryDAO->addEntry ($values);
							}
						}
						$feedDAO->updateLastUpdate ($feed->id ());
						$feedDAO->commit ();
						$transactionStarted = false;

						// ok, ajout terminé
						$notif = array (
							'type' => 'good',
							'content' => Translate::t ('feed_added', $feed->name ())
						);
						Session::_param ('notification', $notif);

						// permet de rediriger vers la page de conf du flux
						$params['id'] = $feed->id ();
					}
				}
			} catch (BadUrlException $e) {
				Minz_Log::record ($e->getMessage (), Minz_Log::WARNING);
				$notif = array (
					'type' => 'bad',
					'content' => Translate::t ('invalid_url', $url)
				);
				Session::_param ('notification', $notif);
			} catch (FeedException $e) {
				Minz_Log::record ($e->getMessage (), Minz_Log::WARNING);
				$notif = array (
					'type' => 'bad',
					'content' => Translate::t ('internal_problem_feed')
				);
				Session::_param ('notification', $notif);
			} catch (FileNotExistException $e) {
				// Répertoire de cache n'existe pas
				Minz_Log::record ($e->getMessage (), Minz_Log::ERROR);
				$notif = array (
					'type' => 'bad',
					'content' => Translate::t ('internal_problem_feed')
				);
				Session::_param ('notification', $notif);
			}
			if ($transactionStarted) {
				$feedDAO->rollBack ();
			}

			Request::forward (array ('c' => 'configure', 'a' => 'feed', 'params' => $params), true);
		}
	}

	public function truncateAction () {
		if (Request::isPost ()) {
			$id = Request::param ('id');
			$feedDAO = new FeedDAO ();
			$n = $feedDAO->truncate($id);
			$notif = array(
				'type' => $n === false ? 'bad' : 'good',
				'content' => Translate::t ('n_entries_deleted', $n)
			);
			Session::_param ('notification', $notif);
			invalidateHttpCache();
			Request::forward (array ('c' => 'configure', 'a' => 'feed', 'params' => array('id' => $id)), true);
		}
	}

	public function actualizeAction () {
		@set_time_limit(300);

		$feedDAO = new FeedDAO ();
		$entryDAO = new EntryDAO ();

		$id = Request::param ('id');
		$force = Request::param ('force', false);

		// on créé la liste des flux à mettre à actualiser
		// si on veut mettre un flux à jour spécifiquement, on le met
		// dans la liste, mais seul (permet d'automatiser le traitement)
		$feeds = array ();
		if ($id) {
			$feed = $feedDAO->searchById ($id);
			if ($feed) {
				$feeds = array ($feed);
			}
		} else {
			$feeds = $feedDAO->listFeedsOrderUpdate ();
		}

		// on calcule la date des articles les plus anciens qu'on accepte
		$nb_month_old = $this->view->conf->oldEntries ();
		$date_min = time () - (60 * 60 * 24 * 30 * $nb_month_old);
		if (rand(0, 30) === 1) {
			$nb = $entryDAO->cleanOldEntries ($date_min);
			Minz_Log::record ($nb . ' old entries cleaned.', Minz_Log::DEBUG);
			if ($nb > 0) {
				$nb = $feedDAO->updateCachedValues ();
				Minz_Log::record ($nb . ' cached values updated.', Minz_Log::DEBUG);
			}
		}

		$i = 0;
		$flux_update = 0;
		foreach ($feeds as $feed) {
			try {
				$feed->load ();
				$feed->faviconPrepare();
				$entries = $feed->entries ();
				usort($entries, 'self::entryDateComparer');

				$is_read = $this->view->conf->markUponReception() === 'yes' ? 1 : 0;

				//For this feed, check last n entry GUIDs already in database
				$existingGuids = array_fill_keys ($entryDAO->listLastGuidsByFeed ($feed->id (), count($entries) + 10), 1);

				// On ne vérifie pas strictement que l'article n'est pas déjà en BDD
				// La BDD refusera l'ajout car (id_feed, guid) doit être unique
				$feedDAO->beginTransaction ();
				foreach ($entries as $entry) {
					if ((!isset ($existingGuids[$entry->guid ()])) &&
						($entry->date (true) >= $date_min ||
						$feed->keepHistory ())) {
						$values = $entry->toArray ();
						//Use declared date at first import, otherwise use discovery date
						$values['id'] = empty($existingGuids) ? min(time(), $entry->date (true)) . '.' . rand(0, 999999) : microtime(true);
						$values['is_read'] = $is_read;
						$entryDAO->addEntry ($values);
					}
				}

				// on indique que le flux vient d'être mis à jour en BDD
				$feedDAO->updateLastUpdate ($feed->id ());
				$feedDAO->commit ();
				$flux_update++;
			} catch (FeedException $e) {
				Minz_Log::record ($e->getMessage (), Minz_Log::NOTICE);
				$feedDAO->updateLastUpdate ($feed->id (), 1);
			}

			// On arrête à 10 flux pour ne pas surcharger le serveur
			// sauf si le paramètre $force est à vrai
			$i++;
			if ($i >= 10 && !$force) {
				break;
			}
		}

		$url = array ();
		if ($flux_update === 1) {
			// on a mis un seul flux à jour
			$notif = array (
				'type' => 'good',
				'content' => Translate::t ('feed_actualized', $feed->name ())
			);
		} elseif ($flux_update > 1) {
			// plusieurs flux on été mis à jour
			$notif = array (
				'type' => 'good',
				'content' => Translate::t ('n_feeds_actualized', $flux_update)
			);
		} else {
			// aucun flux n'a été mis à jour, oups
			$notif = array (
				'type' => 'bad',
				'content' => Translate::t ('no_feed_actualized')
			);
		}

		if ($i === 1) {
			// Si on a voulu mettre à jour qu'un flux
			// on filtre l'affichage par ce flux
			$feed = reset ($feeds);
			$url['params'] = array ('get' => 'f_' . $feed->id ());
		}

		if (Request::param ('ajax', 0) === 0) {
			Session::_param ('notification', $notif);
			Request::forward ($url, true);
		} else {
			// Une requête Ajax met un seul flux à jour.
			// Comme en principe plusieurs requêtes ont lieu,
			// on indique que "plusieurs flux ont été mis à jour".
			// Cela permet d'avoir une notification plus proche du
			// ressenti utilisateur
			$notif = array (
				'type' => 'good',
				'content' => Translate::t ('feeds_actualized')
			);
			Session::_param ('notification', $notif);
			// et on désactive le layout car ne sert à rien
			$this->view->_useLayout (false);
		}
	}

	public function massiveImportAction () {
		@set_time_limit(300);

		$entryDAO = new EntryDAO ();
		$feedDAO = new FeedDAO ();

		$categories = Request::param ('categories', array (), true);
		$feeds = Request::param ('feeds', array (), true);

		// on ajoute les catégories en masse dans une fonction à part
		$this->addCategories ($categories);

		// on calcule la date des articles les plus anciens qu'on accepte
		$nb_month_old = $this->view->conf->oldEntries ();
		$date_min = time () - (60 * 60 * 24 * 30 * $nb_month_old);

		// la variable $error permet de savoir si une erreur est survenue
		// Le but est de ne pas arrêter l'import même en cas d'erreur
		// L'utilisateur sera mis au courant s'il y a eu des erreurs, mais
		// ne connaîtra pas les détails. Ceux-ci seront toutefois logguées
		$error = false;
		$i = 0;
		foreach ($feeds as $feed) {
			try {
				$values = array (
					'id' => $feed->id (),
					'url' => $feed->url (),
					'category' => $feed->category (),
					'name' => $feed->name (),
					'website' => $feed->website (),
					'description' => $feed->description (),
					'lastUpdate' => 0,
					'httpAuth' => $feed->httpAuth ()
				);

				// ajout du flux que s'il n'est pas déjà en BDD
				if (!$feedDAO->searchByUrl ($values['url'])) {
					$id = $feedDAO->addFeed ($values);
					if ($id) {
						$feed->_id ($id);
						$feed->faviconPrepare();
					} else {
						$error = true;
					}
				}
			} catch (FeedException $e) {
				$error = true;
				Minz_Log::record ($e->getMessage (), Minz_Log::WARNING);
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
		Session::_param ('actualize_feeds', true);

		// et on redirige vers la page d'accueil
		Request::forward (array (
			'c' => 'index',
			'a' => 'index'
		), true);
	}

	public function deleteAction () {
		if (Request::isPost ()) {
			$type = Request::param ('type', 'feed');
			$id = Request::param ('id');

			$feedDAO = new FeedDAO ();
			if ($type == 'category') {
				if ($feedDAO->deleteFeedByCategory ($id)) {
					$notif = array (
						'type' => 'good',
						'content' => Translate::t ('category_emptied')
					);
					//TODO: Delete old favicons
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
					Feed::faviconDelete($id);
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
