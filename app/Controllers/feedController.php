<?php

/**
 * Controller to handle every feed actions.
 */
class FreshRSS_feed_Controller extends Minz_ActionController {
	/**
	 * This action is called before every other action in that class. It is
	 * the common boiler plate for every action. It is triggered by the
	 * underlying framework.
	 */
	public function firstAction() {
		if (!FreshRSS_Auth::hasAccess()) {
			// Token is useful in the case that anonymous refresh is forbidden
			// and CRON task cannot be used with php command so the user can
			// set a CRON task to refresh his feeds by using token inside url
			$token = FreshRSS_Context::$user_conf->token;
			$token_param = Minz_Request::param('token', '');
			$token_is_ok = ($token != '' && $token == $token_param);
			$action = Minz_Request::actionName();
			$allow_anonymous_refresh = FreshRSS_Context::$system_conf->allow_anonymous_refresh;
			if ($action !== 'actualize' ||
					!($allow_anonymous_refresh || $token_is_ok)) {
				Minz_Error::error(403);
			}
		}
	}

	/**
	 * This action subscribes to a feed.
	 *
	 * It can be reached by both GET and POST requests.
	 *
	 * GET request displays a form to add and configure a feed.
	 * Request parameter is:
	 *   - url_rss (default: false)
	 *
	 * POST request adds a feed in database.
	 * Parameters are:
	 *   - url_rss (default: false)
	 *   - category (default: false)
	 *   - new_category (required if category == 'nc')
	 *   - http_user (default: false)
	 *   - http_pass (default: false)
	 * It tries to get website information from RSS feed.
	 * If no category is given, feed is added to the default one.
	 *
	 * If url_rss is false, nothing happened.
	 */
	public function addAction() {
		$url = Minz_Request::param('url_rss');

		if ($url === false) {
			// No url, do nothing
			Minz_Request::forward(array(
				'c' => 'subscription',
				'a' => 'index'
			), true);
		}

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$this->catDAO = new FreshRSS_CategoryDAO();
		$url_redirect = array(
			'c' => 'subscription',
			'a' => 'index',
			'params' => array(),
		);

		$limits = FreshRSS_Context::$system_conf->limits;
		$this->view->feeds = $feedDAO->listFeeds();
		if (count($this->view->feeds) >= $limits['max_feeds']) {
			Minz_Request::bad(_t('feedback.sub.feed.over_max', $limits['max_feeds']),
			                  $url_redirect);
		}

		if (Minz_Request::isPost()) {
			@set_time_limit(300);

			$cat = Minz_Request::param('category');
			if ($cat === 'nc') {
				// User want to create a new category, new_category parameter
				// must exist
				$new_cat = Minz_Request::param('new_category');
				if (empty($new_cat['name'])) {
					$cat = false;
				} else {
					$cat = $this->catDAO->addCategory($new_cat);
				}
			}

			if ($cat === false) {
				// If category was not given or if creating new category failed,
				// get the default category
				$this->catDAO->checkDefault();
				$def_cat = $this->catDAO->getDefault();
				$cat = $def_cat->id();
			}

			// HTTP information are useful if feed is protected behind a
			// HTTP authentication
			$user = trim(Minz_Request::param('http_user', ''));
			$pass = Minz_Request::param('http_pass', '');
			$http_auth = '';
			if ($user != '' && $pass != '') {	//TODO: Sanitize
				$http_auth = $user . ':' . $pass;
			}

			$transaction_started = false;
			try {
				$feed = new FreshRSS_Feed($url);
			} catch (FreshRSS_BadUrl_Exception $e) {
				// Given url was not a valid url!
				Minz_Log::warning($e->getMessage());
				Minz_Request::bad(_t('feedback.sub.feed.invalid_url', $url), $url_redirect);
			}

			$feed->_httpAuth($http_auth);

			try {
				$feed->load(true);
			} catch (FreshRSS_Feed_Exception $e) {
				// Something went bad (timeout, server not found, etc.)
				Minz_Log::warning($e->getMessage());
				Minz_Request::bad(
					_t('feedback.sub.feed.internal_problem', _url('index', 'logs')),
					$url_redirect
				);
			} catch (Minz_FileNotExistException $e) {
				// Cache directory doesn't exist!
				Minz_Log::error($e->getMessage());
				Minz_Request::bad(
					_t('feedback.sub.feed.internal_problem', _url('index', 'logs')),
					$url_redirect
				);
			}

			if ($feedDAO->searchByUrl($feed->url())) {
				Minz_Request::bad(
					_t('feedback.sub.feed.already_subscribed', $feed->name()),
					$url_redirect
				);
			}

			$feed->_category($cat);

			// Call the extension hook
			$name = $feed->name();
			$feed = Minz_ExtensionManager::callHook('feed_before_insert', $feed);
			if ($feed === null) {
				Minz_Request::bad(_t('feedback.sub.feed.not_added', $name), $url_redirect);
			}

			$values = array(
				'url' => $feed->url(),
				'category' => $feed->category(),
				'name' => $feed->name(),
				'website' => $feed->website(),
				'description' => $feed->description(),
				'lastUpdate' => time(),
				'httpAuth' => $feed->httpAuth(),
			);

			$id = $feedDAO->addFeed($values);
			if (!$id) {
				// There was an error in database... we cannot say what here.
				Minz_Request::bad(_t('feedback.sub.feed.not_added', $feed->name()), $url_redirect);
			}

			// Ok, feed has been added in database. Now we have to refresh entries.
			$feed->_id($id);
			$feed->faviconPrepare();
			//$feed->pubSubHubbubPrepare();	//TODO: prepare PubSubHubbub already when adding the feed

			$is_read = FreshRSS_Context::$user_conf->mark_when['reception'] ? 1 : 0;

			$entryDAO = FreshRSS_Factory::createEntryDao();
			// We want chronological order and SimplePie uses reverse order.
			$entries = array_reverse($feed->entries());

			// Calculate date of oldest entries we accept in DB.
			$nb_month_old = FreshRSS_Context::$user_conf->old_entries;
			$date_min = time() - (3600 * 24 * 30 * $nb_month_old);

			// Use a shared statement and a transaction to improve a LOT the
			// performances.
			$feedDAO->beginTransaction();
			foreach ($entries as $entry) {
				// Entries are added without any verification.
				$entry->_feed($feed->id());
				$entry->_id(min(time(), $entry->date(true)) . uSecString());
				$entry->_isRead($is_read);

				$entry = Minz_ExtensionManager::callHook('entry_before_insert', $entry);
				if ($entry === null) {
					// An extension has returned a null value, there is nothing to insert.
					continue;
				}

				$values = $entry->toArray();
				$entryDAO->addEntry($values);
			}
			$feedDAO->updateLastUpdate($feed->id());
			if ($feedDAO->inTransaction()) {
				$feedDAO->commit();
			}

			// Entries are in DB, we redirect to feed configuration page.
			$url_redirect['params']['id'] = $feed->id();
			Minz_Request::good(_t('feedback.sub.feed.added', $feed->name()), $url_redirect);
		} else {
			// GET request: we must ask confirmation to user before adding feed.
			Minz_View::prependTitle(_t('sub.feed.title_add') . ' · ');

			$this->view->categories = $this->catDAO->listCategories(false);
			$this->view->feed = new FreshRSS_Feed($url);
			try {
				// We try to get more information about the feed.
				$this->view->feed->load(true);
				$this->view->load_ok = true;
			} catch (Exception $e) {
				$this->view->load_ok = false;
			}

			$feed = $feedDAO->searchByUrl($this->view->feed->url());
			if ($feed) {
				// Already subscribe so we redirect to the feed configuration page.
				$url_redirect['params']['id'] = $feed->id();
				Minz_Request::good(_t('feedback.sub.feed.already_subscribed', $feed->name()), $url_redirect);
			}
		}
	}

	/**
	 * This action remove entries from a given feed.
	 *
	 * It should be reached by a POST action.
	 *
	 * Parameter is:
	 *   - id (default: false)
	 */
	public function truncateAction() {
		$id = Minz_Request::param('id');
		$url_redirect = array(
			'c' => 'subscription',
			'a' => 'index',
			'params' => array('id' => $id)
		);

		if (!Minz_Request::isPost()) {
			Minz_Request::forward($url_redirect, true);
		}

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$n = $feedDAO->truncate($id);

		invalidateHttpCache();
		if ($n === false) {
			Minz_Request::bad(_t('feedback.sub.feed.error'), $url_redirect);
		} else {
			Minz_Request::good(_t('feedback.sub.feed.n_entries_deleted', $n), $url_redirect);
		}
	}

	/**
	 * This action actualizes entries from one or several feeds.
	 *
	 * Parameters are:
	 *   - id (default: false): Feed ID
	 *   - url (default: false): Feed URL
	 *   - force (default: false)
	 * If id and url are not specified, all the feeds are actualized. But if force is
	 * false, process stops at 10 feeds to avoid time execution problem.
	 */
	public function actualizeAction($simplePiePush = null) {
		@set_time_limit(300);

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$entryDAO = FreshRSS_Factory::createEntryDao();

		Minz_Session::_param('actualize_feeds', false);
		$id = Minz_Request::param('id');
		$url = Minz_Request::param('url');
		$force = Minz_Request::param('force');

		// Create a list of feeds to actualize.
		// If id is set and valid, corresponding feed is added to the list but
		// alone in order to automatize further process.
		$feeds = array();
		if ($id || $url) {
			$feed = $id ? $feedDAO->searchById($id) : $feedDAO->searchByUrl($url);
			if ($feed) {
				$feeds[] = $feed;
			}
		} else {
			$feeds = $feedDAO->listFeedsOrderUpdate(FreshRSS_Context::$user_conf->ttl_default);
		}

		// Calculate date of oldest entries we accept in DB.
		$nb_month_old = max(FreshRSS_Context::$user_conf->old_entries, 1);
		$date_min = time() - (3600 * 24 * 30 * $nb_month_old);

		// PubSubHubbub support
		$pubsubhubbubEnabledGeneral = FreshRSS_Context::$system_conf->pubsubhubbub_enabled;
		$pshbMinAge = time() - (3600 * 24);  //TODO: Make a configuration.

		$updated_feeds = 0;
		$is_read = FreshRSS_Context::$user_conf->mark_when['reception'] ? 1 : 0;
		foreach ($feeds as $feed) {
			$url = $feed->url();	//For detection of HTTP 301

			$pubSubHubbubEnabled = $pubsubhubbubEnabledGeneral && $feed->pubSubHubbubEnabled();
			if ((!$simplePiePush) && (!$id) && $pubSubHubbubEnabled && ($feed->lastUpdate() > $pshbMinAge)) {
				//$text = 'Skip pull of feed using PubSubHubbub: ' . $url;
				//Minz_Log::debug($text);
				//file_put_contents(USERS_PATH . '/_/log_pshb.txt', date('c') . "\t" . $text . "\n", FILE_APPEND);
				continue;	//When PubSubHubbub is used, do not pull refresh so often
			}

			if (!$feed->lock()) {
				Minz_Log::notice('Feed already being actualized: ' . $feed->url());
				continue;
			}

			try {
				if ($simplePiePush) {
					$feed->loadEntries($simplePiePush);	//Used by PubSubHubbub
				} else {
					$feed->load(false);
				}
			} catch (FreshRSS_Feed_Exception $e) {
				Minz_Log::warning($e->getMessage());
				$feedDAO->updateLastUpdate($feed->id(), true);
				$feed->unlock();
				continue;
			}

			$feed_history = $feed->keepHistory();
			if ($feed_history == -2) {
				// TODO: -2 must be a constant!
				// -2 means we take the default value from configuration
				$feed_history = FreshRSS_Context::$user_conf->keep_history_default;
			}

			// We want chronological order and SimplePie uses reverse order.
			$entries = array_reverse($feed->entries());
			if (count($entries) > 0) {
				$newGuids = array();
				foreach ($entries as $entry) {
					$newGuids[] = $entry->guid();
				}
				// For this feed, check existing GUIDs already in database.
				$existingHashForGuids = $entryDAO->listHashForFeedGuids($feed->id(), $newGuids);
				unset($newGuids);

				$oldGuids = array();
				// Add entries in database if possible.
				foreach ($entries as $entry) {
					$entry_date = $entry->date(true);
					if (isset($existingHashForGuids[$entry->guid()])) {
						$existingHash = $existingHashForGuids[$entry->guid()];
						if (strcasecmp($existingHash, $entry->hash()) === 0 || trim($existingHash, '0') == '') {
							//This entry already exists and is unchanged. TODO: Remove the test with the zero'ed hash in FreshRSS v1.3
							$oldGuids[] = $entry->guid();
						} else {	//This entry already exists but has been updated
							//Minz_Log::debug('Entry with GUID `' . $entry->guid() . '` updated in feed ' . $feed->id() .
								//', old hash ' . $existingHash . ', new hash ' . $entry->hash());
							//TODO: Make an updated/is_read policy by feed, in addition to the global one.
							$entry->_isRead(FreshRSS_Context::$user_conf->mark_updated_article_unread ? false : null);	//Change is_read according to policy.
							if (!$entryDAO->inTransaction()) {
								$entryDAO->beginTransaction();
							}
							$entryDAO->updateEntry($entry->toArray());
						}
					} elseif ($feed_history == 0 && $entry_date < $date_min) {
						// This entry should not be added considering configuration and date.
						$oldGuids[] = $entry->guid();
					} else {
						if ($entry_date < $date_min) {
							$id = min(time(), $entry_date) . uSecString();
							$entry->_isRead(true);	//Old article that was not in database. Probably an error, so mark as read
						} else {
							$id = uTimeString();
							$entry->_isRead($is_read);
						}
						$entry->_id($id);

						$entry = Minz_ExtensionManager::callHook('entry_before_insert', $entry);
						if ($entry === null) {
							// An extension has returned a null value, there is nothing to insert.
							continue;
						}

						if ($pubSubHubbubEnabled && !$simplePiePush) {	//We use push, but have discovered an article by pull!
							$text = 'An article was discovered by pull although we use PubSubHubbub!: Feed ' . $url . ' GUID ' . $entry->guid();
							file_put_contents(USERS_PATH . '/_/log_pshb.txt', date('c') . "\t" . $text . "\n", FILE_APPEND);
							Minz_Log::warning($text);
							$pubSubHubbubEnabled = false;
							$feed->pubSubHubbubError(true);
						}

						if (!$entryDAO->inTransaction()) {
							$entryDAO->beginTransaction();
						}
						$entryDAO->addEntry($entry->toArray());
					}
				}
				$entryDAO->updateLastSeen($feed->id(), $oldGuids);
			}

			if ($feed_history >= 0 && rand(0, 30) === 1) {
				// TODO: move this function in web cron when available (see entry::purge)
				// Remove old entries once in 30.
				if (!$entryDAO->inTransaction()) {
					$entryDAO->beginTransaction();
				}

				$nb = $feedDAO->cleanOldEntries($feed->id(),
				                                $date_min,
				                                max($feed_history, count($entries) + 10));
				if ($nb > 0) {
					Minz_Log::debug($nb . ' old entries cleaned in feed [' .
					                $feed->url() . ']');
				}
			}

			$feedDAO->updateLastUpdate($feed->id(), 0, $entryDAO->inTransaction());
			if ($entryDAO->inTransaction()) {
				$entryDAO->commit();
			}

			if ($feed->hubUrl() && $feed->selfUrl()) {	//selfUrl has priority for PubSubHubbub
				if ($feed->selfUrl() !== $url) {	//https://code.google.com/p/pubsubhubbub/wiki/MovingFeedsOrChangingHubs
					$selfUrl = checkUrl($feed->selfUrl());
					if ($selfUrl) {
						Minz_Log::debug('PubSubHubbub unsubscribe ' . $feed->url());
						if (!$feed->pubSubHubbubSubscribe(false)) {	//Unsubscribe
							Minz_Log::warning('Error while PubSubHubbub unsubscribing from ' . $feed->url());
						}
						$feed->_url($selfUrl, false);
						Minz_Log::notice('Feed ' . $url . ' canonical address moved to ' . $feed->url());
						$feedDAO->updateFeed($feed->id(), array('url' => $feed->url()));
					}
				}
			}
			elseif ($feed->url() !== $url) {	// HTTP 301 Moved Permanently
				Minz_Log::notice('Feed ' . $url . ' moved permanently to ' . $feed->url());
				$feedDAO->updateFeed($feed->id(), array('url' => $feed->url()));
			}

			$feed->faviconPrepare();
			if ($pubsubhubbubEnabledGeneral && $feed->pubSubHubbubPrepare()) {
				Minz_Log::notice('PubSubHubbub subscribe ' . $feed->url());
				if (!$feed->pubSubHubbubSubscribe(true)) {	//Subscribe
					Minz_Log::warning('Error while PubSubHubbub subscribing to ' . $feed->url());
				}
			}
			$feed->unlock();
			$updated_feeds++;
			unset($feed);

			// No more than 10 feeds unless $force is true to avoid overloading
			// the server.
			if ($updated_feeds >= 10 && !$force) {
				break;
			}
		}

		if (Minz_Request::param('ajax')) {
			// Most of the time, ajax request is for only one feed. But since
			// there are several parallel requests, we should return that there
			// are several updated feeds.
			$notif = array(
				'type' => 'good',
				'content' => _t('feedback.sub.feed.actualizeds')
			);
			Minz_Session::_param('notification', $notif);
			// No layout in ajax request.
			$this->view->_useLayout(false);
		} else {
			// Redirect to the main page with correct notification.
			if ($updated_feeds === 1) {
				$feed = reset($feeds);
				Minz_Request::good(_t('feedback.sub.feed.actualized', $feed->name()), array(
					'params' => array('get' => 'f_' . $feed->id())
				));
			} elseif ($updated_feeds > 1) {
				Minz_Request::good(_t('feedback.sub.feed.n_actualized', $updated_feeds), array());
			} else {
				Minz_Request::good(_t('feedback.sub.feed.no_refresh'), array());
			}
		}
		return $updated_feeds;
	}

	/**
	 * This action changes the category of a feed.
	 *
	 * This page must be reached by a POST request.
	 *
	 * Parameters are:
	 *   - f_id (default: false)
	 *   - c_id (default: false)
	 * If c_id is false, default category is used.
	 *
	 * @todo should handle order of the feed inside the category.
	 */
	public function moveAction() {
		if (!Minz_Request::isPost()) {
			Minz_Request::forward(array('c' => 'subscription'), true);
		}

		$feed_id = Minz_Request::param('f_id');
		$cat_id = Minz_Request::param('c_id');

		if ($cat_id === false) {
			// If category was not given get the default one.
			$catDAO = new FreshRSS_CategoryDAO();
			$catDAO->checkDefault();
			$def_cat = $catDAO->getDefault();
			$cat_id = $def_cat->id();
		}

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$values = array('category' => $cat_id);

		$feed = $feedDAO->searchById($feed_id);
		if ($feed && ($feed->category() == $cat_id ||
		              $feedDAO->updateFeed($feed_id, $values))) {
			// TODO: return something useful
		} else {
			Minz_Log::warning('Cannot move feed `' . $feed_id . '` ' .
			                  'in the category `' . $cat_id . '`');
			Minz_Error::error(404);
		}
	}

	/**
	 * This action deletes a feed.
	 *
	 * This page must be reached by a POST request.
	 * If there are related queries, they are deleted too.
	 *
	 * Parameters are:
	 *   - id (default: false)
	 *   - r (default: false)
	 * r permits to redirect to a given page at the end of this action.
	 *
	 * @todo handle "r" redirection in Minz_Request::forward()?
	 */
	public function deleteAction() {
		$redirect_url = Minz_Request::param('r', false, true);
		if (!$redirect_url) {
			$redirect_url = array('c' => 'subscription', 'a' => 'index');
		}

		if (!Minz_Request::isPost()) {
			Minz_Request::forward($redirect_url, true);
		}

		$id = Minz_Request::param('id');
		$feedDAO = FreshRSS_Factory::createFeedDao();
		if ($feedDAO->deleteFeed($id)) {
			// TODO: Delete old favicon

			// Remove related queries
			FreshRSS_Context::$user_conf->queries = remove_query_by_get(
				'f_' . $id, FreshRSS_Context::$user_conf->queries);
			FreshRSS_Context::$user_conf->save();

			Minz_Request::good(_t('feedback.sub.feed.deleted'), $redirect_url);
		} else {
			Minz_Request::bad(_t('feedback.sub.feed.error'), $redirect_url);
		}
	}
}
