<?php

class FreshRSS_feed_Controller extends Minz_ActionController {
	public function firstAction () {
		if (!$this->view->loginOk) {
			// Token is useful in the case that anonymous refresh is forbidden
			// and CRON task cannot be used with php command so the user can
			// set a CRON task to refresh his feeds by using token inside url
			$token = $this->view->conf->token;
			$token_param = Minz_Request::param ('token', '');
			$token_is_ok = ($token != '' && $token == $token_param);
			$action = Minz_Request::actionName ();
			if (!(($token_is_ok || Minz_Configuration::allowAnonymousRefresh()) &&
				$action === 'actualize')
			) {
				Minz_Error::error (
					403,
					array ('error' => array (Minz_Translate::t ('access_denied')))
				);
			}
		}
	}

	public function addAction () {
		@set_time_limit(300);

		if (Minz_Request::isPost ()) {
			$this->catDAO = new FreshRSS_CategoryDAO ();
			$this->catDAO->checkDefault ();

			$url = Minz_Request::param ('url_rss');
			$cat = Minz_Request::param ('category', false);
			if ($cat === false) {
				$def_cat = $this->catDAO->getDefault ();
				$cat = $def_cat->id ();
			}

			$user = Minz_Request::param ('http_user');
			$pass = Minz_Request::param ('http_pass');
			$params = array ();

			$transactionStarted = false;
			try {
				$feed = new FreshRSS_Feed ($url);
				$feed->_category ($cat);

				$httpAuth = '';
				if ($user != '' || $pass != '') {
					$httpAuth = $user . ':' . $pass;
				}
				$feed->_httpAuth ($httpAuth);

				$feed->load(true);

				$feedDAO = new FreshRSS_FeedDAO ();
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
						'content' => Minz_Translate::t ('already_subscribed', $feed->name ())
					);
					Minz_Session::_param ('notification', $notif);
				} else {
					$id = $feedDAO->addFeed ($values);
					if (!$id) {
						// problème au niveau de la base de données
						$notif = array (
							'type' => 'bad',
							'content' => Minz_Translate::t ('feed_not_added', $feed->name ())
						);
						Minz_Session::_param ('notification', $notif);
					} else {
						$feed->_id ($id);
						$feed->faviconPrepare();

						$is_read = $this->view->conf->mark_when['reception'] ? 1 : 0;

						$entryDAO = new FreshRSS_EntryDAO ();
						$entries = array_reverse($feed->entries());	//We want chronological order and SimplePie uses reverse order

						// on calcule la date des articles les plus anciens qu'on accepte
						$nb_month_old = $this->view->conf->old_entries;
						$date_min = time () - (3600 * 24 * 30 * $nb_month_old);

						$transactionStarted = true;
						$feedDAO->beginTransaction ();
						// on ajoute les articles en masse sans vérification
						foreach ($entries as $entry) {
							$values = $entry->toArray ();
							$values['id_feed'] = $feed->id ();
							$values['id'] = min(time(), $entry->date (true)) . uSecString();
							$values['is_read'] = $is_read;
							$entryDAO->addEntry ($values);
						}
						$feedDAO->updateLastUpdate ($feed->id ());
						$feedDAO->commit ();
						$transactionStarted = false;

						// ok, ajout terminé
						$notif = array (
							'type' => 'good',
							'content' => Minz_Translate::t ('feed_added', $feed->name ())
						);
						Minz_Session::_param ('notification', $notif);

						// permet de rediriger vers la page de conf du flux
						$params['id'] = $feed->id ();
					}
				}
			} catch (FreshRSS_BadUrl_Exception $e) {
				Minz_Log::record ($e->getMessage (), Minz_Log::WARNING);
				$notif = array (
					'type' => 'bad',
					'content' => Minz_Translate::t ('invalid_url', $url)
				);
				Minz_Session::_param ('notification', $notif);
			} catch (FreshRSS_Feed_Exception $e) {
				Minz_Log::record ($e->getMessage (), Minz_Log::WARNING);
				$notif = array (
					'type' => 'bad',
					'content' => Minz_Translate::t ('internal_problem_feed')
				);
				Minz_Session::_param ('notification', $notif);
			} catch (Minz_FileNotExistException $e) {
				// Répertoire de cache n'existe pas
				Minz_Log::record ($e->getMessage (), Minz_Log::ERROR);
				$notif = array (
					'type' => 'bad',
					'content' => Minz_Translate::t ('internal_problem_feed')
				);
				Minz_Session::_param ('notification', $notif);
			}
			if ($transactionStarted) {
				$feedDAO->rollBack ();
			}

			Minz_Request::forward (array ('c' => 'configure', 'a' => 'feed', 'params' => $params), true);
		}
	}

	public function truncateAction () {
		if (Minz_Request::isPost ()) {
			$id = Minz_Request::param ('id');
			$feedDAO = new FreshRSS_FeedDAO ();
			$n = $feedDAO->truncate($id);
			$notif = array(
				'type' => $n === false ? 'bad' : 'good',
				'content' => Minz_Translate::t ('n_entries_deleted', $n)
			);
			Minz_Session::_param ('notification', $notif);
			invalidateHttpCache();
			Minz_Request::forward (array ('c' => 'configure', 'a' => 'feed', 'params' => array('id' => $id)), true);
		}
	}

	public function actualizeAction () {
		@set_time_limit(300);

		$feedDAO = new FreshRSS_FeedDAO ();
		$entryDAO = new FreshRSS_EntryDAO ();

		Minz_Session::_param('actualize_feeds', false);
		$id = Minz_Request::param ('id');
		$force = Minz_Request::param ('force', false);

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
		$nb_month_old = max($this->view->conf->old_entries, 1);
		$date_min = time () - (3600 * 24 * 30 * $nb_month_old);

		$i = 0;
		$flux_update = 0;
		$is_read = $this->view->conf->mark_when['reception'] ? 1 : 0;
		foreach ($feeds as $feed) {
			if (!$feed->lock()) {
				Minz_Log::record('Feed already being actualized: ' . $feed->url(), Minz_Log::NOTICE);
				continue;
			}
			try {
				$url = $feed->url();
				$feedHistory = $feed->keepHistory();

				$feed->load(false);
				$entries = array_reverse($feed->entries());	//We want chronological order and SimplePie uses reverse order
				$hasTransaction = false;

				if (count($entries) > 0) {
					//For this feed, check last n entry GUIDs already in database
					$existingGuids = array_fill_keys ($entryDAO->listLastGuidsByFeed ($feed->id (), count($entries) + 10), 1);
					$useDeclaredDate = empty($existingGuids);

					if ($feedHistory == -2) {	//default
						$feedHistory = $this->view->conf->keep_history_default;
					}

					$hasTransaction = true;
					$feedDAO->beginTransaction();

					// On ne vérifie pas strictement que l'article n'est pas déjà en BDD
					// La BDD refusera l'ajout car (id_feed, guid) doit être unique
					foreach ($entries as $entry) {
						$eDate = $entry->date (true);
						if ((!isset ($existingGuids[$entry->guid ()])) &&
							(($feedHistory != 0) || ($eDate  >= $date_min))) {
							$values = $entry->toArray ();
							//Use declared date at first import, otherwise use discovery date
							$values['id'] = ($useDeclaredDate || $eDate < $date_min) ?
								min(time(), $eDate) . uSecString() :
								uTimeString();
							$values['is_read'] = $is_read;
							$entryDAO->addEntry ($values);
						}
					}
				}

				if (($feedHistory >= 0) && (rand(0, 30) === 1)) {
					if (!$hasTransaction) {
						$feedDAO->beginTransaction();
					}
					$nb = $feedDAO->cleanOldEntries ($feed->id (), $date_min, max($feedHistory, count($entries) + 10));
					if ($nb > 0) {
						Minz_Log::record ($nb . ' old entries cleaned in feed [' . $feed->url() . ']', Minz_Log::DEBUG);
					}
				}

				// on indique que le flux vient d'être mis à jour en BDD
				$feedDAO->updateLastUpdate ($feed->id (), 0, $hasTransaction);
				if ($hasTransaction) {
					$feedDAO->commit();
				}
				$flux_update++;
				if ($feed->url() !== $url) {	//URL has changed (auto-discovery)
					$feedDAO->updateFeed($feed->id(), array('url' => $feed->url()));
				}
			} catch (FreshRSS_Feed_Exception $e) {
				Minz_Log::record ($e->getMessage (), Minz_Log::NOTICE);
				$feedDAO->updateLastUpdate ($feed->id (), 1);
			}

			$feed->faviconPrepare();
			$feed->unlock();
			unset($feed);

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
			$feed = reset ($feeds);
			$notif = array (
				'type' => 'good',
				'content' => Minz_Translate::t ('feed_actualized', $feed->name ())
			);
		} elseif ($flux_update > 1) {
			// plusieurs flux on été mis à jour
			$notif = array (
				'type' => 'good',
				'content' => Minz_Translate::t ('n_feeds_actualized', $flux_update)
			);
		} else {
			// aucun flux n'a été mis à jour, oups
			$notif = array (
				'type' => 'good',
				'content' => Minz_Translate::t ('no_feed_to_refresh')
			);
		}

		if ($i === 1) {
			// Si on a voulu mettre à jour qu'un flux
			// on filtre l'affichage par ce flux
			$feed = reset ($feeds);
			$url['params'] = array ('get' => 'f_' . $feed->id ());
		}

		if (Minz_Request::param ('ajax', 0) === 0) {
			Minz_Session::_param ('notification', $notif);
			Minz_Request::forward ($url, true);
		} else {
			// Une requête Ajax met un seul flux à jour.
			// Comme en principe plusieurs requêtes ont lieu,
			// on indique que "plusieurs flux ont été mis à jour".
			// Cela permet d'avoir une notification plus proche du
			// ressenti utilisateur
			$notif = array (
				'type' => 'good',
				'content' => Minz_Translate::t ('feeds_actualized')
			);
			Minz_Session::_param ('notification', $notif);
			// et on désactive le layout car ne sert à rien
			$this->view->_useLayout (false);
		}
	}

	public function massiveImportAction () {
		@set_time_limit(300);

		$this->catDAO = new FreshRSS_CategoryDAO ();
		$this->catDAO->checkDefault ();

		$entryDAO = new FreshRSS_EntryDAO ();
		$feedDAO = new FreshRSS_FeedDAO ();

		$categories = Minz_Request::param ('categories', array (), true);
		$feeds = Minz_Request::param ('feeds', array (), true);

		// on ajoute les catégories en masse dans une fonction à part
		$this->addCategories ($categories);

		// on calcule la date des articles les plus anciens qu'on accepte
		$nb_month_old = $this->view->conf->old_entries;
		$date_min = time () - (3600 * 24 * 30 * $nb_month_old);

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
			} catch (FreshRSS_Feed_Exception $e) {
				$error = true;
				Minz_Log::record ($e->getMessage (), Minz_Log::WARNING);
			}
		}

		if ($error) {
			$res = Minz_Translate::t ('feeds_imported_with_errors');
		} else {
			$res = Minz_Translate::t ('feeds_imported');
		}

		$notif = array (
			'type' => 'good',
			'content' => $res
		);
		Minz_Session::_param ('notification', $notif);
		Minz_Session::_param ('actualize_feeds', true);

		// et on redirige vers la page d'accueil
		Minz_Request::forward (array (
			'c' => 'index',
			'a' => 'index'
		), true);
	}

	public function deleteAction () {
		if (Minz_Request::isPost ()) {
			$type = Minz_Request::param ('type', 'feed');
			$id = Minz_Request::param ('id');

			$feedDAO = new FreshRSS_FeedDAO ();
			if ($type == 'category') {
				if ($feedDAO->deleteFeedByCategory ($id)) {
					$notif = array (
						'type' => 'good',
						'content' => Minz_Translate::t ('category_emptied')
					);
					//TODO: Delete old favicons
				} else {
					$notif = array (
						'type' => 'bad',
						'content' => Minz_Translate::t ('error_occured')
					);
				}
			} else {
				if ($feedDAO->deleteFeed ($id)) {
					$notif = array (
						'type' => 'good',
						'content' => Minz_Translate::t ('feed_deleted')
					);
					//TODO: Delete old favicon
				} else {
					$notif = array (
						'type' => 'bad',
						'content' => Minz_Translate::t ('error_occured')
					);
				}
			}

			Minz_Session::_param ('notification', $notif);

			if ($type == 'category') {
				Minz_Request::forward (array ('c' => 'configure', 'a' => 'categorize'), true);
			} else {
				Minz_Request::forward (array ('c' => 'configure', 'a' => 'feed'), true);
			}
		}
	}

	private function addCategories ($categories) {
		foreach ($categories as $cat) {
			if (!$this->catDAO->searchByName ($cat->name ())) {
				$values = array (
					'id' => $cat->id (),
					'name' => $cat->name (),
				);
				$catDAO->addCategory ($values);
			}
		}
	}
}
