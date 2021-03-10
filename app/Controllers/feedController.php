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
		$this->updateTTL();
	}

	/**
	 * @param $url
	 * @param string $title
	 * @param int $cat_id
	 * @param string $new_cat_name
	 * @param string $http_auth
	 * @return FreshRSS_Feed|the
	 * @throws FreshRSS_AlreadySubscribed_Exception
	 * @throws FreshRSS_FeedNotAdded_Exception
	 * @throws FreshRSS_Feed_Exception
	 * @throws Minz_FileNotExistException
	 */
	public static function addFeed($url, $title = '', $cat_id = 0, $new_cat_name = '', $http_auth = '', $attributes = array()) {
		FreshRSS_UserDAO::touch();
		@set_time_limit(300);

		$catDAO = FreshRSS_Factory::createCategoryDao();

		$url = trim($url);

		/** @var $url */
		$url = Minz_ExtensionManager::callHook('check_url_before_add', $url);
		if (null === $url) {
			throw new FreshRSS_FeedNotAdded_Exception($url, $title);
		}

		$cat = null;
		if ($cat_id > 0) {
			$cat = $catDAO->searchById($cat_id);
		}
		if ($cat == null && $new_cat_name != '') {
			$new_cat_id = $catDAO->addCategory(array('name' => $new_cat_name));
			$cat_id = $new_cat_id > 0 ? $new_cat_id : $cat_id;
			$cat = $catDAO->searchById($cat_id);
		}
		if ($cat == null) {
			$catDAO->checkDefault();
		}
		$cat_id = $cat == null ? FreshRSS_CategoryDAO::DEFAULTCATEGORYID : $cat->id();

		$feed = new FreshRSS_Feed($url);	//Throws FreshRSS_BadUrl_Exception
		$feed->_attributes('', $attributes);
		$feed->_httpAuth($http_auth);
		$feed->load(true);	//Throws FreshRSS_Feed_Exception, Minz_FileNotExistException
		$feed->_category($cat_id);

		$feedDAO = FreshRSS_Factory::createFeedDao();
		if ($feedDAO->searchByUrl($feed->url())) {
			throw new FreshRSS_AlreadySubscribed_Exception($url, $feed->name());
		}

		/** @var FreshRSS_Feed $feed */
		$feed = Minz_ExtensionManager::callHook('feed_before_insert', $feed);
		if ($feed === null) {
			throw new FreshRSS_FeedNotAdded_Exception($url, $feed->name());
		}

		$values = array(
			'url' => $feed->url(),
			'category' => $feed->category(),
			'name' => $title != '' ? $title : $feed->name(),
			'website' => $feed->website(),
			'description' => $feed->description(),
			'lastUpdate' => 0,
			'httpAuth' => $feed->httpAuth(),
			'attributes' => $feed->attributes(),
		);

		$id = $feedDAO->addFeed($values);
		if (!$id) {
			// There was an error in database... we cannot say what here.
			throw new FreshRSS_FeedNotAdded_Exception($url, $feed->name());
		}
		$feed->_id($id);

		// Ok, feed has been added in database. Now we have to refresh entries.
		self::actualizeFeed($id, $url, false, null);

		return $feed;
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
		$url_redirect = array(
			'c' => 'subscription',
			'a' => 'add',
			'params' => array(),
		);

		$limits = FreshRSS_Context::$system_conf->limits;
		$this->view->feeds = $feedDAO->listFeeds();
		if (count($this->view->feeds) >= $limits['max_feeds']) {
			Minz_Request::bad(_t('feedback.sub.feed.over_max', $limits['max_feeds']), $url_redirect);
		}

		if (Minz_Request::isPost()) {
			$cat = Minz_Request::param('category');

			// HTTP information are useful if feed is protected behind a
			// HTTP authentication
			$user = trim(Minz_Request::param('http_user', ''));
			$pass = trim(Minz_Request::param('http_pass', ''));
			$http_auth = '';
			if ($user != '' && $pass != '') {	//TODO: Sanitize
				$http_auth = $user . ':' . $pass;
			}

			$useragent = Minz_Request::param('curl_params_useragent', '');
			$proxy_address = Minz_Request::param('curl_params', '');
			$proxy_type = Minz_Request::param('proxy_type', '');
			$opts = [];
			if ($proxy_address !== '' && $proxy_type !== '' && in_array($proxy_type, [0, 2, 4, 5, 6, 7])) {
				$opts[CURLOPT_PROXY] = $proxy_address;
				$opts[CURLOPT_PROXYTYPE] = intval($proxy_type);
			}
			if ($cookie !== '') {
				$opts[CURLOPT_COOKIE] = $cookie;
			}
			if ($useragent !== '') {
				$opts[CURLOPT_USERAGENT] = $useragent;
			}

			$attributes = array(
				'ssl_verify' => null,
				'timeout' => null,
				'curl_params' => empty($opts) ? null : $opts,
			);
			if (FreshRSS_Auth::hasAccess('admin')) {
				$attributes['ssl_verify'] = Minz_Request::paramTernary('ssl_verify');
				$timeout = intval(Minz_Request::param('timeout', 0));
				$attributes['timeout'] = $timeout > 0 ? $timeout : null;
			}

			try {
				$feed = self::addFeed($url, '', $cat, null, $http_auth, $attributes);
			} catch (FreshRSS_BadUrl_Exception $e) {
				// Given url was not a valid url!
				Minz_Log::warning($e->getMessage());
				Minz_Request::bad(_t('feedback.sub.feed.invalid_url', $url), $url_redirect);
			} catch (FreshRSS_Feed_Exception $e) {
				// Something went bad (timeout, server not found, etc.)
				Minz_Log::warning($e->getMessage());
				Minz_Request::bad(_t('feedback.sub.feed.internal_problem', _url('index', 'logs')), $url_redirect);
			} catch (Minz_FileNotExistException $e) {
				// Cache directory doesn't exist!
				Minz_Log::error($e->getMessage());
				Minz_Request::bad(_t('feedback.sub.feed.internal_problem', _url('index', 'logs')), $url_redirect);
			} catch (FreshRSS_AlreadySubscribed_Exception $e) {
				Minz_Request::bad(_t('feedback.sub.feed.already_subscribed', $e->feedName()), $url_redirect);
			} catch (FreshRSS_FeedNotAdded_Exception $e) {
				Minz_Request::bad(_t('feedback.sub.feed.not_added', $e->feedName()), $url_redirect);
			}

			// Entries are in DB, we redirect to feed configuration page.
			$url_redirect['a'] = 'index';
			$url_redirect['params']['id'] = $feed->id();
			Minz_Request::good(_t('feedback.sub.feed.added', $feed->name()), $url_redirect);
		} else {
			// GET request: we must ask confirmation to user before adding feed.
			Minz_View::prependTitle(_t('sub.feed.title_add') . ' · ');

			$this->catDAO = FreshRSS_Factory::createCategoryDao();
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
				$url_redirect['a'] = 'index';
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

	public static function actualizeFeed($feed_id, $feed_url, $force, $simplePiePush = null, $noCommit = false, $maxFeeds = 10) {
		@set_time_limit(300);

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$entryDAO = FreshRSS_Factory::createEntryDao();

		// Create a list of feeds to actualize.
		// If feed_id is set and valid, corresponding feed is added to the list but
		// alone in order to automatize further process.
		$feeds = array();
		if ($feed_id > 0 || $feed_url) {
			$feed = $feed_id > 0 ? $feedDAO->searchById($feed_id) : $feedDAO->searchByUrl($feed_url);
			if ($feed) {
				$feeds[] = $feed;
			}
		} else {
			$feeds = $feedDAO->listFeedsOrderUpdate(-1);
		}

		// Set maxFeeds to a minimum of 10
		if (!is_int($maxFeeds) || $maxFeeds < 10) {
			$maxFeeds = 10;
		}

		// WebSub (PubSubHubbub) support
		$pubsubhubbubEnabledGeneral = FreshRSS_Context::$system_conf->pubsubhubbub_enabled;
		$pshbMinAge = time() - (3600 * 24);  //TODO: Make a configuration.

		$updated_feeds = 0;
		$nb_new_articles = 0;
		foreach ($feeds as $feed) {
			/** @var FreshRSS_Feed $feed */
			$feed = Minz_ExtensionManager::callHook('feed_before_actualize', $feed);
			if (null === $feed) {
				continue;
			}

			$url = $feed->url();	//For detection of HTTP 301

			$pubSubHubbubEnabled = $pubsubhubbubEnabledGeneral && $feed->pubSubHubbubEnabled();
			if ((!$simplePiePush) && (!$feed_id) && $pubSubHubbubEnabled && ($feed->lastUpdate() > $pshbMinAge)) {
				//$text = 'Skip pull of feed using PubSubHubbub: ' . $url;
				//Minz_Log::debug($text);
				//Minz_Log::debug($text, PSHB_LOG);
				continue;	//When PubSubHubbub is used, do not pull refresh so often
			}

			$mtime = 0;
			if ($feed->mute()) {
				continue;	//Feed refresh is disabled
			}
			$ttl = $feed->ttl();
			if ((!$simplePiePush) && (!$feed_id) &&
				($feed->lastUpdate() + 10 >= time() - (
					$ttl == FreshRSS_Feed::TTL_DEFAULT ? FreshRSS_Context::$user_conf->ttl_default : $ttl))) {
				//Too early to refresh from source, but check whether the feed was updated by another user
				$mtime = $feed->cacheModifiedTime();
				if ($feed->lastUpdate() + 10 >= $mtime) {
					continue;	//Nothing newer from other users
				}
				//Minz_Log::debug($feed->url(false) . ' was updated at ' . date('c', $mtime) . ' by another user');
				//Will take advantage of the newer cache
			}

			if (!$feed->lock()) {
				Minz_Log::notice('Feed already being actualized: ' . $feed->url(false));
				continue;
			}

			$isNewFeed = $feed->lastUpdate() <= 0;

			try {
				if ($simplePiePush) {
					$simplePie = $simplePiePush;	//Used by WebSub
				} else {
					$simplePie = $feed->load(false, $isNewFeed);
				}
				$newGuids = $simplePie == null ? [] : $feed->loadGuids($simplePie);
				$entries = $simplePie == null ? [] : $feed->loadEntries($simplePie);
			} catch (FreshRSS_Feed_Exception $e) {
				Minz_Log::warning($e->getMessage());
				$feedDAO->updateLastUpdate($feed->id(), true);
				$feed->unlock();
				continue;
			}

			$needFeedCacheRefresh = false;

			if (count($newGuids) > 0) {
				// For this feed, check existing GUIDs already in database.
				$existingHashForGuids = $entryDAO->listHashForFeedGuids($feed->id(), $newGuids);
				$newGuids = array();

				$oldGuids = array();
				// Add entries in database if possible.
				foreach ($entries as $entry) {
					if (isset($newGuids[$entry->guid()])) {
						continue;	//Skip subsequent articles with same GUID
					}
					$newGuids[$entry->guid()] = true;

					$entry_date = $entry->date(true);
					if (isset($existingHashForGuids[$entry->guid()])) {
						$existingHash = $existingHashForGuids[$entry->guid()];
						if (strcasecmp($existingHash, $entry->hash()) === 0) {
							//This entry already exists and is unchanged.
							$oldGuids[] = $entry->guid();
						} else {	//This entry already exists but has been updated
							//Minz_Log::debug('Entry with GUID `' . $entry->guid() . '` updated in feed ' . $feed->url(false) .
								//', old hash ' . $existingHash . ', new hash ' . $entry->hash());
							$mark_updated_article_unread = $feed->attributes('mark_updated_article_unread') !== null ?
								$feed->attributes('mark_updated_article_unread') :
								FreshRSS_Context::$user_conf->mark_updated_article_unread;
							$needFeedCacheRefresh = $mark_updated_article_unread;
							$entry->_isRead($mark_updated_article_unread ? false : null);	//Change is_read according to policy.

							$entry = Minz_ExtensionManager::callHook('entry_before_insert', $entry);
							if ($entry === null) {
								// An extension has returned a null value, there is nothing to insert.
								continue;
							}

							// If the entry has changed, there is a good chance for the full content to have changed as well.
							$entry->loadCompleteContent(true);

							if (!$entryDAO->inTransaction()) {
								$entryDAO->beginTransaction();
							}
							$entryDAO->updateEntry($entry->toArray());
						}
					} else {
						$id = uTimeString();
						$entry->_id($id);

						$entry->applyFilterActions();

						$entry = Minz_ExtensionManager::callHook('entry_before_insert', $entry);
						if ($entry === null) {
							// An extension has returned a null value, there is nothing to insert.
							continue;
						}

						if ($pubSubHubbubEnabled && !$simplePiePush) {	//We use push, but have discovered an article by pull!
							$text = 'An article was discovered by pull although we use PubSubHubbub!: Feed ' . $url .
								' GUID ' . $entry->guid();
							Minz_Log::warning($text, PSHB_LOG);
							Minz_Log::warning($text);
							$pubSubHubbubEnabled = false;
							$feed->pubSubHubbubError(true);
						}

						if (!$entryDAO->inTransaction()) {
							$entryDAO->beginTransaction();
						}
						$entryDAO->addEntry($entry->toArray());
						$nb_new_articles++;
					}
				}
				$entryDAO->updateLastSeen($feed->id(), $oldGuids, $mtime);
			}
			unset($entries);

			if (mt_rand(0, 30) === 1) {	// Remove old entries once in 30.
				if (!$entryDAO->inTransaction()) {
					$entryDAO->beginTransaction();
				}
				$nb = $feed->cleanOldEntries();
				if ($nb > 0) {
					$needFeedCacheRefresh = true;
				}
			}

			$feedDAO->updateLastUpdate($feed->id(), false, $mtime);
			if ($needFeedCacheRefresh) {
				$feedDAO->updateCachedValues($feed->id());
			}
			if ($entryDAO->inTransaction()) {
				$entryDAO->commit();
			}

			$feedProperties = [];

			if ($pubsubhubbubEnabledGeneral && $feed->hubUrl() && $feed->selfUrl()) {	//selfUrl has priority for WebSub
				if ($feed->selfUrl() !== $url) {	// https://github.com/pubsubhubbub/PubSubHubbub/wiki/Moving-Feeds-or-changing-Hubs
					$selfUrl = checkUrl($feed->selfUrl());
					if ($selfUrl) {
						Minz_Log::debug('WebSub unsubscribe ' . $feed->url(false));
						if (!$feed->pubSubHubbubSubscribe(false)) {	//Unsubscribe
							Minz_Log::warning('Error while WebSub unsubscribing from ' . $feed->url(false));
						}
						$feed->_url($selfUrl, false);
						Minz_Log::notice('Feed ' . $url . ' canonical address moved to ' . $feed->url(false));
						$feedDAO->updateFeed($feed->id(), array('url' => $feed->url()));
					}
				}
			} elseif ($feed->url() !== $url) {	// HTTP 301 Moved Permanently
				Minz_Log::notice('Feed ' . $url . ' moved permanently to ' . $feed->url(false));
				$feedProperties['url'] = $feed->url();
			}

			if ($simplePie != null) {
				if (trim($feed->name()) == '') {
					//HTML to HTML-PRE	//ENT_COMPAT except '&'
					$name = strtr(html_only_entity_decode($simplePie->get_title()), array('<' => '&lt;', '>' => '&gt;', '"' => '&quot;'));
					$feedProperties['name'] = $name == '' ? $feed->url() : $name;
				}
				if (trim($feed->website()) == '') {
					$website = html_only_entity_decode($simplePie->get_link());
					$feedProperties['website'] = $website == '' ? $feed->url() : $website;
				}
				if (trim($feed->description()) == '') {
					$description = html_only_entity_decode($simplePie->get_description());
					if ($description != '') {
						$feedProperties['description'] = $description;
					}
				}
			}
			if (!empty($feedProperties)) {
				$ok = $feedDAO->updateFeed($feed->id(), $feedProperties);
				if (!$ok && $isNewFeed) {
					//Cancel adding new feed in case of database error at first actualize
					$feedDAO->deleteFeed($feed->id());
					$feed->unlock();
					break;
				}
			}

			$feed->faviconPrepare();
			if ($pubsubhubbubEnabledGeneral && $feed->pubSubHubbubPrepare()) {
				Minz_Log::notice('WebSub subscribe ' . $feed->url(false));
				if (!$feed->pubSubHubbubSubscribe(true)) {	//Subscribe
					Minz_Log::warning('Error while WebSub subscribing to ' . $feed->url(false));
				}
			}
			$feed->unlock();
			$updated_feeds++;
			unset($feed);
			gc_collect_cycles();

			// No more than $maxFeeds feeds unless $force is true to avoid overloading
			// the server.
			if ($updated_feeds >= $maxFeeds && !$force) {
				break;
			}
		}
		if (!$noCommit && ($nb_new_articles > 0 || $updated_feeds > 0)) {
			if (!$entryDAO->inTransaction()) {
				$entryDAO->beginTransaction();
			}
			$entryDAO->commitNewEntries();
			$feedDAO->updateCachedValues();
			if ($entryDAO->inTransaction()) {
				$entryDAO->commit();
			}

			$databaseDAO = FreshRSS_Factory::createDatabaseDAO();
			$databaseDAO->minorDbMaintenance();
		}
		return array($updated_feeds, reset($feeds), $nb_new_articles);
	}

	/**
	 * This action actualizes entries from one or several feeds.
	 *
	 * Parameters are:
	 *   - id (default: false): Feed ID
	 *   - url (default: false): Feed URL
	 *   - force (default: false)
	 *   - noCommit (default: 0): Set to 1 to prevent committing the new articles to the main database
	 * If id and url are not specified, all the feeds are actualized. But if force is
	 * false, process stops at 10 feeds to avoid time execution problem.
	 */
	public function actualizeAction() {
		Minz_Session::_param('actualize_feeds', false);
		$id = Minz_Request::param('id');
		$url = Minz_Request::param('url');
		$force = Minz_Request::param('force');
		$maxFeeds = (int)Minz_Request::param('maxFeeds');
		$noCommit = Minz_Request::fetchPOST('noCommit', 0) == 1;

		if ($id == -1 && !$noCommit) {	//Special request only to commit & refresh DB cache
			$updated_feeds = 0;
			$entryDAO = FreshRSS_Factory::createEntryDao();
			$feedDAO = FreshRSS_Factory::createFeedDao();
			$entryDAO->beginTransaction();
			$entryDAO->commitNewEntries();
			$feedDAO->updateCachedValues();
			$entryDAO->commit();

			$databaseDAO = FreshRSS_Factory::createDatabaseDAO();
			$databaseDAO->minorDbMaintenance();
		} else {
			list($updated_feeds, $feed, $nb_new_articles) = self::actualizeFeed($id, $url, $force, null, $noCommit, $maxFeeds);
		}

		if (Minz_Request::param('ajax')) {
			// Most of the time, ajax request is for only one feed. But since
			// there are several parallel requests, we should return that there
			// are several updated feeds.
			Minz_Request::setGoodNotification(_t('feedback.sub.feed.actualizeds'));
			// No layout in ajax request.
			$this->view->_layout(false);
		} else {
			// Redirect to the main page with correct notification.
			if ($updated_feeds === 1) {
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

	public static function renameFeed($feed_id, $feed_name) {
		if ($feed_id <= 0 || $feed_name == '') {
			return false;
		}
		FreshRSS_UserDAO::touch();
		$feedDAO = FreshRSS_Factory::createFeedDao();
		return $feedDAO->updateFeed($feed_id, array('name' => $feed_name));
	}

	public static function moveFeed($feed_id, $cat_id, $new_cat_name = '') {
		if ($feed_id <= 0 || ($cat_id <= 0 && $new_cat_name == '')) {
			return false;
		}
		FreshRSS_UserDAO::touch();

		$catDAO = FreshRSS_Factory::createCategoryDao();
		if ($cat_id > 0) {
			$cat = $catDAO->searchById($cat_id);
			$cat_id = $cat == null ? 0 : $cat->id();
		}
		if ($cat_id <= 1 && $new_cat_name != '') {
			$cat_id = $catDAO->addCategory(array('name' => $new_cat_name));
		}
		if ($cat_id <= 1) {
			$catDAO->checkDefault();
			$cat_id = FreshRSS_CategoryDAO::DEFAULTCATEGORYID;
		}

		$feedDAO = FreshRSS_Factory::createFeedDao();
		return $feedDAO->updateFeed($feed_id, array('category' => $cat_id));
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

		if (self::moveFeed($feed_id, $cat_id)) {
			// TODO: return something useful
			// Log a notice to prevent "Empty IF statement" warning in PHP_CodeSniffer
			Minz_Log::notice('Moved feed `' . $feed_id . '` in the category `' . $cat_id . '`');
		} else {
			Minz_Log::warning('Cannot move feed `' . $feed_id . '` in the category `' . $cat_id . '`');
			Minz_Error::error(404);
		}
	}

	public static function deleteFeed($feed_id) {
		FreshRSS_UserDAO::touch();
		$feedDAO = FreshRSS_Factory::createFeedDao();
		if ($feedDAO->deleteFeed($feed_id)) {
			// TODO: Delete old favicon

			// Remove related queries
			FreshRSS_Context::$user_conf->queries = remove_query_by_get(
				'f_' . $feed_id, FreshRSS_Context::$user_conf->queries);
			FreshRSS_Context::$user_conf->save();

			return true;
		}
		return false;
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

		if (self::deleteFeed($id)) {
			Minz_Request::good(_t('feedback.sub.feed.deleted'), $redirect_url);
		} else {
			Minz_Request::bad(_t('feedback.sub.feed.error'), $redirect_url);
		}
	}

	/**
	 * This action force clears the cache of a feed.
	 *
	 * Parameters are:
	 *   - id (mandatory - no default): Feed ID
	 *
	 */
	public function clearCacheAction() {
		//Get Feed.
		$id = Minz_Request::param('id');

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$feed = $feedDAO->searchById($id);

		if (!$feed) {
			Minz_Request::bad(_t('feedback.sub.feed.not_found'), array());
			return;
		}

		$feed->clearCache();

		Minz_Request::good(_t('feedback.sub.feed.cache_cleared', $feed->name()), array(
			'params' => array('get' => 'f_' . $feed->id())
		));
	}

	/**
	 * This action forces reloading the articles of a feed.
	 *
	 * Parameters are:
	 *   - id (mandatory - no default): Feed ID
	 *
	 */
	public function reloadAction() {
		@set_time_limit(300);

		//Get Feed ID.
		$feed_id = Minz_Request::param('id');

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$entryDAO = FreshRSS_Factory::createEntryDao();

		$feed = $feedDAO->searchById($feed_id);

		if (!$feed) {
			Minz_Request::bad(_t('feedback.sub.feed.not_found'), array());
			return;
		}

		//Re-fetch articles as if the feed was new.
		$feedDAO->updateFeed($feed->id(), [ 'lastUpdate' => 0 ]);
		self::actualizeFeed($feed_id, null, false, null, true);

		//Extract all feed entries from database, load complete content and store them back in database.
		$entries = $entryDAO->listWhere('f', $feed_id, FreshRSS_Entry::STATE_ALL, 'DESC', 0);
		//TODO: Parameter to limit the number of articles to reload

		//We need another DB connection in parallel for unbuffered streaming
		Minz_ModelPdo::$usesSharedPdo = false;
		if (FreshRSS_Context::$system_conf->db['type'] === 'mysql') {
			// Second parallel connection for unbuffered streaming: MySQL
			$entryDAO2 = FreshRSS_Factory::createEntryDao();
		} else {
			// Single connection for buffered queries (in memory): SQLite, PostgreSQL
			//TODO: Consider an unbuffered query for PostgreSQL
			$entryDAO2 = $entryDAO;
		}

		foreach ($entries as $entry) {
			if ($entry->loadCompleteContent(true)) {
				$entryDAO2->updateEntry($entry->toArray());
			}
		}

		Minz_ModelPdo::$usesSharedPdo = true;

		//Give feedback to user.
		Minz_Request::good(_t('feedback.sub.feed.reloaded', $feed->name()), array(
			'params' => array('get' => 'f_' . $feed->id())
		));
	}

	/**
	 * This action creates a preview of a content-selector.
	 *
	 * Parameters are:
	 *   - id (mandatory - no default): Feed ID
	 *   - selector (mandatory - no default): Selector to preview
	 *
	 */
	public function contentSelectorPreviewAction() {

		//Configure.
		$this->view->fatalError = '';
		$this->view->selectorSuccess = false;
		$this->view->htmlContent = '';

		$this->view->_layout(false);

		$this->_csp([
			'default-src' => "'self'",
			'frame-src' => '*',
			'img-src' => '* data:',
			'media-src' => '*',
		]);

		//Get parameters.
		$feed_id = Minz_Request::param('id');
		$content_selector = trim(Minz_Request::param('selector'));

		if (!$content_selector) {
			$this->view->fatalError = _t('feedback.sub.feed.selector_preview.selector_empty');
			return;
		}

		//Check Feed ID validity.
		$entryDAO = FreshRSS_Factory::createEntryDao();
		$entries = $entryDAO->listWhere('f', $feed_id);
		$entry = null;

		//Get first entry (syntax robust for Generator or Array)
		foreach ($entries as $myEntry) {
			if ($entry == null) {
				$entry = $myEntry;
			}
		}

		if ($entry == null) {
			$this->view->fatalError = _t('feedback.sub.feed.selector_preview.no_entries');
			return;
		}

		//Get feed.
		$feed = $entry->feed(true);

		if (!$feed) {
			$this->view->fatalError = _t('feedback.sub.feed.selector_preview.no_feed');
			return;
		}

		//Fetch & select content.
		try {
			$fullContent = FreshRSS_Entry::getContentByParsing(
				htmlspecialchars_decode($entry->link(), ENT_QUOTES),
				$content_selector,
				$feed->attributes()
			);

			if ($fullContent != '') {
				$this->view->selectorSuccess = true;
				$this->view->htmlContent = $fullContent;
			} else {
				$this->view->selectorSuccess = false;
				$this->view->htmlContent = $entry->content();
			}
		} catch (Exception $e) {
			$this->view->fatalError = _t('feedback.sub.feed.selector_preview.http_error');
		}
	}

	/**
	 * This method update TTL values for feeds if needed.
	 * It changes the old default value (-2) to the new default value (0).
	 * It changes the old disabled value (-1) to the default disabled value.
	 */
	private function updateTTL() {
		$feedDAO = FreshRSS_Factory::createFeedDao();
		$feedDAO->updateTTL();
	}
}
