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

	public function addAction () {
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
					// on est déjà abonné à ce flux
					$notif = array (
						'type' => 'bad',
						'content' => Translate::t ('already_subscribed', $feed->name ())
					);
					Session::_param ('notification', $notif);
				} elseif (!$feedDAO->addFeed ($values)) {
					// problème au niveau de la base de données
					$notif = array (
						'type' => 'bad',
						'content' => Translate::t ('feed_not_added', $feed->name ())
					);
					Session::_param ('notification', $notif);
				} else {
					$entryDAO = new EntryDAO ();
					$entries = $feed->entries ();

					// on calcule la date des articles les plus anciens qu'on accepte
					$nb_month_old = $this->view->conf->oldEntries ();
					$date_min = time () - (60 * 60 * 24 * 30 * $nb_month_old);

					// on ajoute les articles en masse sans vérification
					foreach ($entries as $entry) {
						if ($entry->date (true) >= $date_min ||
						    $feed->keepHistory ()) {
							$values = $entry->toArray ();
							$entryDAO->addEntry ($values);
						}
					}

					// ok, ajout terminé
					$notif = array (
						'type' => 'good',
						'content' => Translate::t ('feed_added', $feed->name ())
					);
					Session::_param ('notification', $notif);

					// permet de rediriger vers la page de conf du flux
					$params['id'] = $feed->id ();
				}
			} catch (BadUrlException $e) {
				Minz_Log::record ($e->getMessage (), Minz_Log::ERROR);
				$notif = array (
					'type' => 'bad',
					'content' => Translate::t ('invalid_url', $url)
				);
				Session::_param ('notification', $notif);
			} catch (FeedException $e) {
				Minz_Log::record ($e->getMessage (), Minz_Log::ERROR);
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

			Request::forward (array ('c' => 'configure', 'a' => 'feed', 'params' => $params), true);
		}
	}

	public function actualizeAction () {
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

		$i = 0;
		$flux_update = 0;
		foreach ($feeds as $feed) {
			try {
				$feed->load ();
				$entries = $feed->entries ();

				//For this feed, check last n entry IDs already in database
				$existingIds = array_fill_keys ($entryDAO->listLastIdsByFeed ($feed->id (), count($entries) + 2), 1);

				// ajout des articles en masse sans se soucier des erreurs
				// On ne vérifie pas que l'article n'est pas déjà en BDD
				// car demanderait plus de ressources
				// La BDD refusera l'ajout de son côté car l'id doit être
				// unique
				foreach ($entries as $entry) {
					if ((!isset ($existingIds[$entry->id ()])) &&
						($entry->date (true) >= $date_min ||
						$feed->keepHistory ())) {
						$values = $entry->toArray ();
						$entryDAO->addEntry ($values);
					}
				}

				// on indique que le flux vient d'être mis à jour en BDD
				$feedDAO->updateLastUpdate ($feed->id ());
				$flux_update++;
			} catch (FeedException $e) {
				Minz_Log::record ($e->getMessage (), Minz_Log::ERROR);
				$feedDAO->isInError ($feed->id ());
			}

			// On arrête à 10 flux pour ne pas surcharger le serveur
			// sauf si le paramètre $force est à vrai
			$i++;
			if ($i >= 10 && !$force) {
				break;
			}
		}

		$entryDAO->cleanOldEntries ($nb_month_old);

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
				$feed->load ();

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
					if (!$feedDAO->addFeed ($values)) {
						$error = true;
					}
				}
			} catch (FeedException $e) {
				$error = true;
				Minz_Log::record ($e->getMessage (), Minz_Log::ERROR);
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

		// et on redirige vers la page import/export
		Request::forward (array (
			'c' => 'configure',
			'a' => 'importExport'
		), true);
	}

	public function deleteAction () {
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
