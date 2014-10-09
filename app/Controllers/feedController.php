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
		$url = Minz_Request::param('url_rss', false);

		if ($url === false) {
			Minz_Request::forward(array(
				'c' => 'configure',
				'a' => 'feed'
			), true);
		}

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$this->catDAO = new FreshRSS_CategoryDAO ();
		$this->catDAO->checkDefault ();

		if (Minz_Request::isPost()) {
			@set_time_limit(300);


			$cat = Minz_Request::param ('category', false);
			if ($cat === 'nc') {
				$new_cat = Minz_Request::param ('new_category');
				if (empty($new_cat['name'])) {
					$cat = false;
				} else {
					$cat = $this->catDAO->addCategory($new_cat);
				}
			}
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

						$entryDAO = FreshRSS_Factory::createEntryDao();
						$entries = array_reverse($feed->entries());	//We want chronological order and SimplePie uses reverse order

						// on calcule la date des articles les plus anciens qu'on accepte
						$nb_month_old = $this->view->conf->old_entries;
						$date_min = time () - (3600 * 24 * 30 * $nb_month_old);

						//MySQL: http://docs.oracle.com/cd/E17952_01/refman-5.5-en/optimizing-innodb-transaction-management.html
						//SQLite: http://stackoverflow.com/questions/1711631/how-do-i-improve-the-performance-of-sqlite
						$preparedStatement = $entryDAO->addEntryPrepare();
						$transactionStarted = true;
						$feedDAO->beginTransaction();
						// on ajoute les articles en masse sans vérification
						foreach ($entries as $entry) {
							$values = $entry->toArray();
							$values['id_feed'] = $feed->id();
							$values['id'] = min(time(), $entry->date(true)) . uSecString();
							$values['is_read'] = $is_read;
							$entryDAO->addEntry($values, $preparedStatement);
						}
						$feedDAO->updateLastUpdate($feed->id());
						if ($transactionStarted) {
							$feedDAO->commit();
						}
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
					'content' => Minz_Translate::t ('internal_problem_feed', Minz_Url::display(array('a' => 'logs')))
				);
				Minz_Session::_param ('notification', $notif);
			} catch (Minz_FileNotExistException $e) {
				// Répertoire de cache n'existe pas
				Minz_Log::record ($e->getMessage (), Minz_Log::ERROR);
				$notif = array (
					'type' => 'bad',
					'content' => Minz_Translate::t ('internal_problem_feed', Minz_Url::display(array('a' => 'logs')))
				);
				Minz_Session::_param ('notification', $notif);
			}
			if ($transactionStarted) {
				$feedDAO->rollBack ();
			}

			Minz_Request::forward (array ('c' => 'configure', 'a' => 'feed', 'params' => $params), true);
		} else {

			// GET request so we must ask confirmation to user
			Minz_View::prependTitle(Minz_Translate::t('add_rss_feed') . ' · ');
			$this->view->categories = $this->catDAO->listCategories(false);
			$this->view->feed = new FreshRSS_Feed($url);
			try {
				// We try to get some more information about the feed
				$this->view->feed->load(true);
				$this->view->load_ok = true;
			} catch (Exception $e) {
				$this->view->load_ok = false;
			}

			$feed = $feedDAO->searchByUrl($this->view->feed->url());
			if ($feed) {
				// Already subscribe so we redirect to the feed configuration page
				$notif = array(
					'type' => 'bad',
					'content' => Minz_Translate::t(
						'already_subscribed', $feed->name()
					)
				);
				Minz_Session::_param('notification', $notif);

				Minz_Request::forward(array(
					'c' => 'configure',
					'a' => 'feed',
					'params' => array(
						'id' => $feed->id()
					)
				), true);
			}
		}
	}

	public function truncateAction () {
		if (Minz_Request::isPost ()) {
			$id = Minz_Request::param ('id');
			$feedDAO = FreshRSS_Factory::createFeedDao();
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

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$entryDAO = FreshRSS_Factory::createEntryDao();

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
			$feeds = $feedDAO->listFeedsOrderUpdate($this->view->conf->ttl_default);
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

					$preparedStatement = $entryDAO->addEntryPrepare();
					$hasTransaction = true;
					$feedDAO->beginTransaction();

					// On ne vérifie pas strictement que l'article n'est pas déjà en BDD
					// La BDD refusera l'ajout car (id_feed, guid) doit être unique
					foreach ($entries as $entry) {
						$eDate = $entry->date(true);
						if ((!isset($existingGuids[$entry->guid()])) &&
							(($feedHistory != 0) || ($eDate  >= $date_min))) {
							$values = $entry->toArray();
							//Use declared date at first import, otherwise use discovery date
							$values['id'] = ($useDeclaredDate || $eDate < $date_min) ?
								min(time(), $eDate) . uSecString() :
								uTimeString();
							$values['is_read'] = $is_read;
							$entryDAO->addEntry($values, $preparedStatement);
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
				if (($feed->url() !== $url)) {	//HTTP 301 Moved Permanently
					Minz_Log::record('Feed ' . $url . ' moved permanently to ' . $feed->url(), Minz_Log::NOTICE);
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

	public function deleteAction () {
		if (Minz_Request::isPost ()) {
			$type = Minz_Request::param ('type', 'feed');
			$id = Minz_Request::param ('id');

			$feedDAO = FreshRSS_Factory::createFeedDao();
			if ($type == 'category') {
				// List feeds to remove then related user queries.
				$feeds = $feedDAO->listByCategory($id);

				if ($feedDAO->deleteFeedByCategory ($id)) {
					// Remove related queries
					foreach ($feeds as $feed) {
						$this->view->conf->remove_query_by_get('f_' . $feed->id());
					}
					$this->view->conf->save();

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
					// Remove related queries
					$this->view->conf->remove_query_by_get('f_' . $id);
					$this->view->conf->save();

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

			$redirect_url = Minz_Request::param('r', false, true);
			if ($redirect_url) {
				Minz_Request::forward($redirect_url);
			} elseif ($type == 'category') {
				Minz_Request::forward(array ('c' => 'configure', 'a' => 'categorize'), true);
			} else {
				Minz_Request::forward(array ('c' => 'configure', 'a' => 'feed'), true);
			}
		}
	}
}
