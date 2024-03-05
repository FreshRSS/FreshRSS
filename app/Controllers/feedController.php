<?php
declare(strict_types=1);

/**
 * Controller to handle every feed actions.
 */
class FreshRSS_feed_Controller extends FreshRSS_ActionController {
	/**
	 * This action is called before every other action in that class. It is
	 * the common boiler plate for every action. It is triggered by the
	 * underlying framework.
	 */
	public function firstAction(): void {
		if (!FreshRSS_Auth::hasAccess()) {
			// Token is useful in the case that anonymous refresh is forbidden
			// and CRON task cannot be used with php command so the user can
			// set a CRON task to refresh his feeds by using token inside url
			$token = FreshRSS_Context::userConf()->token;
			$token_param = Minz_Request::paramString('token');
			$token_is_ok = ($token != '' && $token == $token_param);
			$action = Minz_Request::actionName();
			$allow_anonymous_refresh = FreshRSS_Context::systemConf()->allow_anonymous_refresh;
			if ($action !== 'actualize' ||
					!($allow_anonymous_refresh || $token_is_ok)) {
				Minz_Error::error(403);
			}
		}
	}

	/**
	 * @param array<string,mixed> $attributes
	 * @throws FreshRSS_AlreadySubscribed_Exception
	 * @throws FreshRSS_BadUrl_Exception
	 * @throws FreshRSS_Feed_Exception
	 * @throws FreshRSS_FeedNotAdded_Exception
	 * @throws Minz_FileNotExistException
	 */
	public static function addFeed(string $url, string $title = '', int $cat_id = 0, string $new_cat_name = '',
		string $http_auth = '', array $attributes = [], int $kind = FreshRSS_Feed::KIND_RSS): FreshRSS_Feed {
		FreshRSS_UserDAO::touch();
		if (function_exists('set_time_limit')) {
			@set_time_limit(300);
		}

		$catDAO = FreshRSS_Factory::createCategoryDao();

		$url = trim($url);

		/** @var string|null $urlHooked */
		$urlHooked = Minz_ExtensionManager::callHook('check_url_before_add', $url);
		if ($urlHooked === null) {
			throw new FreshRSS_FeedNotAdded_Exception($url);
		}
		$url = $urlHooked;

		$cat = null;
		if ($cat_id > 0) {
			$cat = $catDAO->searchById($cat_id);
		}
		if ($cat === null && $new_cat_name != '') {
			$new_cat_id = $catDAO->addCategory(['name' => $new_cat_name]);
			$cat_id = $new_cat_id > 0 ? $new_cat_id : $cat_id;
			$cat = $catDAO->searchById($cat_id);
		}
		if ($cat === null) {
			$catDAO->checkDefault();
		}

		$feed = new FreshRSS_Feed($url);	//Throws FreshRSS_BadUrl_Exception
		$title = trim($title);
		if ($title !== '') {
			$feed->_name($title);
		}
		$feed->_kind($kind);
		$feed->_attributes($attributes);
		$feed->_httpAuth($http_auth);
		if ($cat === null) {
			$feed->_categoryId(FreshRSS_CategoryDAO::DEFAULTCATEGORYID);
		} else {
			$feed->_category($cat);
		}
		switch ($kind) {
			case FreshRSS_Feed::KIND_RSS:
			case FreshRSS_Feed::KIND_RSS_FORCED:
				$feed->load(true);	//Throws FreshRSS_Feed_Exception, Minz_FileNotExistException
				break;
			case FreshRSS_Feed::KIND_HTML_XPATH:
			case FreshRSS_Feed::KIND_XML_XPATH:
				$feed->_website($url);
				break;
		}

		$feedDAO = FreshRSS_Factory::createFeedDao();
		if ($feedDAO->searchByUrl($feed->url())) {
			throw new FreshRSS_AlreadySubscribed_Exception($url, $feed->name());
		}

		/** @var FreshRSS_Feed|null $feed */
		$feed = Minz_ExtensionManager::callHook('feed_before_insert', $feed);
		if ($feed === null) {
			throw new FreshRSS_FeedNotAdded_Exception($url);
		}

		$id = $feedDAO->addFeedObject($feed);
		if (!$id) {
			// There was an error in database… we cannot say what here.
			throw new FreshRSS_FeedNotAdded_Exception($url);
		}
		$feed->_id($id);

		// Ok, feed has been added in database. Now we have to refresh entries.
		[, , $nb_new_articles] = self::actualizeFeeds($id, $url);
		if ($nb_new_articles > 0) {
			self::commitNewEntries();
		}

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
	 *   - http_user (default: false)
	 *   - http_pass (default: false)
	 * It tries to get website information from RSS feed.
	 * If no category is given, feed is added to the default one.
	 *
	 * If url_rss is false, nothing happened.
	 */
	public function addAction(): void {
		$url = Minz_Request::paramString('url_rss');

		if ($url === '') {
			// No url, do nothing
			Minz_Request::forward([
				'c' => 'subscription',
				'a' => 'index',
			], true);
		}

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$url_redirect = [
			'c' => 'subscription',
			'a' => 'add',
			'params' => [],
		];

		$limits = FreshRSS_Context::systemConf()->limits;
		$this->view->feeds = $feedDAO->listFeeds();
		if (count($this->view->feeds) >= $limits['max_feeds']) {
			Minz_Request::bad(_t('feedback.sub.feed.over_max', $limits['max_feeds']), $url_redirect);
		}

		if (Minz_Request::isPost()) {
			$cat = Minz_Request::paramInt('category');

			// HTTP information are useful if feed is protected behind a
			// HTTP authentication
			$user = Minz_Request::paramString('http_user');
			$pass = Minz_Request::paramString('http_pass');
			$http_auth = '';
			if ($user != '' && $pass != '') {	//TODO: Sanitize
				$http_auth = $user . ':' . $pass;
			}

			$cookie = Minz_Request::paramString('curl_params_cookie');
			$cookie_file = Minz_Request::paramBoolean('curl_params_cookiefile');
			$max_redirs = Minz_Request::paramInt('curl_params_redirects');
			$useragent = Minz_Request::paramString('curl_params_useragent');
			$proxy_address = Minz_Request::paramString('curl_params');
			$proxy_type = Minz_Request::paramString('proxy_type');
			$request_method = Minz_Request::paramString('curl_method');
			$request_fields = Minz_Request::paramString('curl_fields', true);

			$opts = [];
			if ($proxy_type !== '') {
				$opts[CURLOPT_PROXY] = $proxy_address;
				$opts[CURLOPT_PROXYTYPE] = (int)$proxy_type;
			}
			if ($cookie !== '') {
				$opts[CURLOPT_COOKIE] = $cookie;
			}
			if ($cookie_file) {
				// Pass empty cookie file name to enable the libcurl cookie engine
				// without reading any existing cookie data.
				$opts[CURLOPT_COOKIEFILE] = '';
			}
			if ($max_redirs !== 0) {
				$opts[CURLOPT_MAXREDIRS] = $max_redirs;
				$opts[CURLOPT_FOLLOWLOCATION] = 1;
			}
			if ($useragent !== '') {
				$opts[CURLOPT_USERAGENT] = $useragent;
			}
			if ($request_method === 'POST') {
				$opts[CURLOPT_POST] = true;
				if ($request_fields !== '') {
					$opts[CURLOPT_POSTFIELDS] = $request_fields;
					if (json_decode($request_fields, true) !== null) {
						$opts[CURLOPT_HTTPHEADER] = ['Content-Type: application/json'];
					}
				}
			}

			$attributes = [
				'curl_params' => empty($opts) ? null : $opts,
			];
			$attributes['ssl_verify'] = Minz_Request::paramTernary('ssl_verify');
			$timeout = Minz_Request::paramInt('timeout');
			$attributes['timeout'] = $timeout > 0 ? $timeout : null;

			$feed_kind = Minz_Request::paramInt('feed_kind') ?: FreshRSS_Feed::KIND_RSS;
			if ($feed_kind === FreshRSS_Feed::KIND_HTML_XPATH || $feed_kind === FreshRSS_Feed::KIND_XML_XPATH) {
				$xPathSettings = [];
				if (Minz_Request::paramString('xPathFeedTitle') !== '') {
					$xPathSettings['feedTitle'] = Minz_Request::paramString('xPathFeedTitle', true);
				}
				if (Minz_Request::paramString('xPathItem') !== '') {
					$xPathSettings['item'] = Minz_Request::paramString('xPathItem', true);
				}
				if (Minz_Request::paramString('xPathItemTitle') !== '') {
					$xPathSettings['itemTitle'] = Minz_Request::paramString('xPathItemTitle', true);
				}
				if (Minz_Request::paramString('xPathItemContent') !== '') {
					$xPathSettings['itemContent'] = Minz_Request::paramString('xPathItemContent', true);
				}
				if (Minz_Request::paramString('xPathItemUri') !== '') {
					$xPathSettings['itemUri'] = Minz_Request::paramString('xPathItemUri', true);
				}
				if (Minz_Request::paramString('xPathItemAuthor') !== '') {
					$xPathSettings['itemAuthor'] = Minz_Request::paramString('xPathItemAuthor', true);
				}
				if (Minz_Request::paramString('xPathItemTimestamp') !== '') {
					$xPathSettings['itemTimestamp'] = Minz_Request::paramString('xPathItemTimestamp', true);
				}
				if (Minz_Request::paramString('xPathItemTimeFormat') !== '') {
					$xPathSettings['itemTimeFormat'] = Minz_Request::paramString('xPathItemTimeFormat', true);
				}
				if (Minz_Request::paramString('xPathItemThumbnail') !== '') {
					$xPathSettings['itemThumbnail'] = Minz_Request::paramString('xPathItemThumbnail', true);
				}
				if (Minz_Request::paramString('xPathItemCategories') !== '') {
					$xPathSettings['itemCategories'] = Minz_Request::paramString('xPathItemCategories', true);
				}
				if (Minz_Request::paramString('xPathItemUid') !== '') {
					$xPathSettings['itemUid'] = Minz_Request::paramString('xPathItemUid', true);
				}
				if (!empty($xPathSettings)) {
					$attributes['xpath'] = $xPathSettings;
				}
			} elseif ($feed_kind === FreshRSS_Feed::KIND_JSON_DOTPATH) {
				$jsonSettings = [];
				if (Minz_Request::paramString('jsonFeedTitle') !== '') {
					$jsonSettings['feedTitle'] = Minz_Request::paramString('jsonFeedTitle', true);
				}
				if (Minz_Request::paramString('jsonItem') !== '') {
					$jsonSettings['item'] = Minz_Request::paramString('jsonItem', true);
				}
				if (Minz_Request::paramString('jsonItemTitle') !== '') {
					$jsonSettings['itemTitle'] = Minz_Request::paramString('jsonItemTitle', true);
				}
				if (Minz_Request::paramString('jsonItemContent') !== '') {
					$jsonSettings['itemContent'] = Minz_Request::paramString('jsonItemContent', true);
				}
				if (Minz_Request::paramString('jsonItemUri') !== '') {
					$jsonSettings['itemUri'] = Minz_Request::paramString('jsonItemUri', true);
				}
				if (Minz_Request::paramString('jsonItemAuthor') !== '') {
					$jsonSettings['itemAuthor'] = Minz_Request::paramString('jsonItemAuthor', true);
				}
				if (Minz_Request::paramString('jsonItemTimestamp') !== '') {
					$jsonSettings['itemTimestamp'] = Minz_Request::paramString('jsonItemTimestamp', true);
				}
				if (Minz_Request::paramString('jsonItemTimeFormat') !== '') {
					$jsonSettings['itemTimeFormat'] = Minz_Request::paramString('jsonItemTimeFormat', true);
				}
				if (Minz_Request::paramString('jsonItemThumbnail') !== '') {
					$jsonSettings['itemThumbnail'] = Minz_Request::paramString('jsonItemThumbnail', true);
				}
				if (Minz_Request::paramString('jsonItemCategories') !== '') {
					$jsonSettings['itemCategories'] = Minz_Request::paramString('jsonItemCategories', true);
				}
				if (Minz_Request::paramString('jsonItemUid') !== '') {
					$jsonSettings['itemUid'] = Minz_Request::paramString('jsonItemUid', true);
				}
				if (!empty($jsonSettings)) {
					$attributes['json_dotpath'] = $jsonSettings;
				}
			}

			try {
				$feed = self::addFeed($url, '', $cat, '', $http_auth, $attributes, $feed_kind);
			} catch (FreshRSS_BadUrl_Exception $e) {
				// Given url was not a valid url!
				Minz_Log::warning($e->getMessage());
				Minz_Request::bad(_t('feedback.sub.feed.invalid_url', $url), $url_redirect);
				return;
			} catch (FreshRSS_Feed_Exception $e) {
				// Something went bad (timeout, server not found, etc.)
				Minz_Log::warning($e->getMessage());
				Minz_Request::bad(_t('feedback.sub.feed.internal_problem', _url('index', 'logs')), $url_redirect);
				return;
			} catch (Minz_FileNotExistException $e) {
				// Cache directory doesn’t exist!
				Minz_Log::error($e->getMessage());
				Minz_Request::bad(_t('feedback.sub.feed.internal_problem', _url('index', 'logs')), $url_redirect);
				return;
			} catch (FreshRSS_AlreadySubscribed_Exception $e) {
				Minz_Request::bad(_t('feedback.sub.feed.already_subscribed', $e->feedName()), $url_redirect);
				return;
			} catch (FreshRSS_FeedNotAdded_Exception $e) {
				Minz_Request::bad(_t('feedback.sub.feed.not_added', $e->url()), $url_redirect);
				return;
			}

			// Entries are in DB, we redirect to feed configuration page.
			$url_redirect['a'] = 'feed';
			$url_redirect['params']['id'] = '' . $feed->id();
			Minz_Request::good(_t('feedback.sub.feed.added', $feed->name()), $url_redirect);
		} else {
			// GET request: we must ask confirmation to user before adding feed.
			FreshRSS_View::prependTitle(_t('sub.feed.title_add') . ' · ');

			$catDAO = FreshRSS_Factory::createCategoryDao();
			$this->view->categories = $catDAO->listCategories(false) ?: [];
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
				$url_redirect['a'] = 'feed';
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
	public function truncateAction(): void {
		$id = Minz_Request::paramInt('id');
		$url_redirect = [
			'c' => 'subscription',
			'a' => 'index',
			'params' => ['id' => $id],
		];

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
	 * @return array{0:int,1:FreshRSS_Feed|null,2:int} Number of updated feeds, first feed or null, number of new articles
	 * @throws FreshRSS_BadUrl_Exception
	 */
	public static function actualizeFeeds(?int $feed_id = null, ?string $feed_url = null, ?int $maxFeeds = null, ?SimplePie $simplePiePush = null): array {
		if (function_exists('set_time_limit')) {
			@set_time_limit(300);
		}

		if (!is_int($feed_id) || $feed_id <= 0) {
			$feed_id = null;
		}
		if (!is_string($feed_url) || trim($feed_url) === '') {
			$feed_url = null;
		}
		if (!is_int($maxFeeds) || $maxFeeds <= 0) {
			$maxFeeds = PHP_INT_MAX;
		}

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$entryDAO = FreshRSS_Factory::createEntryDao();

		// Create a list of feeds to actualize.
		$feeds = [];
		if ($feed_id !== null || $feed_url !== null) {
			$feed = $feed_id !== null ? $feedDAO->searchById($feed_id) : $feedDAO->searchByUrl($feed_url);
			if ($feed !== null && $feed->id() > 0) {
				$feeds[] = $feed;
				$feed_id = $feed->id();
			}
		} else {
			$feeds = $feedDAO->listFeedsOrderUpdate(-1);

			// Hydrate category for each feed to avoid that each feed has to make an SQL request
			$categories = [];
			$catDAO = FreshRSS_Factory::createCategoryDao();
			foreach ($catDAO->listCategories(false, false) as $category) {
				$categories[$category->id()] = $category;
			}
			foreach ($feeds as $feed) {
				$category = $categories[$feed->categoryId()] ?? null;
				if ($category !== null) {
					$feed->_category($category);
				}
			}
		}

		// WebSub (PubSubHubbub) support
		$pubsubhubbubEnabledGeneral = FreshRSS_Context::systemConf()->pubsubhubbub_enabled;
		$pshbMinAge = time() - (3600 * 24);  //TODO: Make a configuration.

		$updated_feeds = 0;
		$nb_new_articles = 0;

		foreach ($feeds as $feed) {
			/** @var FreshRSS_Feed|null $feed */
			$feed = Minz_ExtensionManager::callHook('feed_before_actualize', $feed);
			if (null === $feed) {
				continue;
			}

			$url = $feed->url();	//For detection of HTTP 301

			$pubSubHubbubEnabled = $pubsubhubbubEnabledGeneral && $feed->pubSubHubbubEnabled();
			if ($simplePiePush === null && $feed_id === null && $pubSubHubbubEnabled && ($feed->lastUpdate() > $pshbMinAge)) {
				//$text = 'Skip pull of feed using PubSubHubbub: ' . $url;
				//Minz_Log::debug($text);
				//Minz_Log::debug($text, PSHB_LOG);
				continue;	//When PubSubHubbub is used, do not pull refresh so often
			}

			if ($feed->mute()) {
				continue;	//Feed refresh is disabled
			}
			$mtime = $feed->cacheModifiedTime() ?: 0;
			$ttl = $feed->ttl();
			if ($ttl === FreshRSS_Feed::TTL_DEFAULT) {
				$ttl = FreshRSS_Context::userConf()->ttl_default;
			}
			if ($simplePiePush === null && $feed_id === null && (time() <= $feed->lastUpdate() + $ttl)) {
				//Too early to refresh from source, but check whether the feed was updated by another user
				$ε = 10;	// negligible offset errors in seconds
				if ($mtime <= 0 ||
					$feed->lastUpdate() + $ε >= $mtime ||
					time() + $ε >= $mtime + FreshRSS_Context::systemConf()->limits['cache_duration']) {	// is cache still valid?
					continue;	//Nothing newer from other users
				}
				Minz_Log::debug('Feed ' . $feed->url(false) . ' was updated at ' . date('c', $feed->lastUpdate()) .
					', and at ' . date('c', $mtime) . ' by another user; take advantage of newer cache.');
			}

			if (!$feed->lock()) {
				Minz_Log::notice('Feed already being actualized: ' . $feed->url(false));
				continue;
			}

			$feedIsNew = $feed->lastUpdate() <= 0;
			$feedIsEmpty = false;
			$feedIsUnchanged = false;

			try {
				if ($simplePiePush !== null) {
					$simplePie = $simplePiePush;	//Used by WebSub
				} elseif ($feed->kind() === FreshRSS_Feed::KIND_HTML_XPATH) {
					$simplePie = $feed->loadHtmlXpath();
					if ($simplePie === null) {
						throw new FreshRSS_Feed_Exception('HTML+XPath Web scraping failed for [' . $feed->url(false) . ']');
					}
				} elseif ($feed->kind() === FreshRSS_Feed::KIND_XML_XPATH) {
					$simplePie = $feed->loadHtmlXpath();
					if ($simplePie === null) {
						throw new FreshRSS_Feed_Exception('XML+XPath parsing failed for [' . $feed->url(false) . ']');
					}
				} elseif ($feed->kind() === FreshRSS_Feed::KIND_JSON_DOTPATH) {
					$simplePie = $feed->loadJson();
					if ($simplePie === null) {
						throw new FreshRSS_Feed_Exception('JSON dotpath parsing failed for [' . $feed->url(false) . ']');
					}
				} elseif ($feed->kind() === FreshRSS_Feed::KIND_JSONFEED) {
					$simplePie = $feed->loadJson();
					if ($simplePie === null) {
						throw new FreshRSS_Feed_Exception('JSON Feed parsing failed for [' . $feed->url(false) . ']');
					}
				} else {
					$simplePie = $feed->load(false, $feedIsNew);
				}

				if ($simplePie === null) {
					// Feed is cached and unchanged
					$newGuids = [];
					$entries = [];
					$feedIsEmpty = false;	// We do not know
					$feedIsUnchanged = true;
				} else {
					$newGuids = $feed->loadGuids($simplePie);
					$entries = $feed->loadEntries($simplePie);
					$feedIsEmpty = $simplePiePush !== null && empty($newGuids);
					$feedIsUnchanged = false;
				}
				$mtime = $feed->cacheModifiedTime() ?: time();
			} catch (FreshRSS_Feed_Exception $e) {
				Minz_Log::warning($e->getMessage());
				$feedDAO->updateLastUpdate($feed->id(), true);
				if ($e->getCode() === 410) {
					// HTTP 410 Gone
					Minz_Log::warning('Muting gone feed: ' . $feed->url(false));
					$feedDAO->mute($feed->id(), true);
				}
				$feed->unlock();
				continue;
			}

			$needFeedCacheRefresh = false;
			$nbMarkedUnread = 0;

			if (count($newGuids) > 0) {
				if ($feed->attributeBoolean('read_when_same_title_in_feed') === null) {
					$readWhenSameTitleInFeed = (int)FreshRSS_Context::userConf()->mark_when['same_title_in_feed'];
				} elseif ($feed->attributeBoolean('read_when_same_title_in_feed') === false) {
					$readWhenSameTitleInFeed = 0;
				} else {
					$readWhenSameTitleInFeed = $feed->attributeInt('read_when_same_title_in_feed') ?? 0;
				}
				if ($readWhenSameTitleInFeed > 0) {
					$titlesAsRead = array_flip($feedDAO->listTitles($feed->id(), $readWhenSameTitleInFeed));
				} else {
					$titlesAsRead = [];
				}

				$mark_updated_article_unread = $feed->attributeBoolean('mark_updated_article_unread') ?? FreshRSS_Context::userConf()->mark_updated_article_unread;

				// For this feed, check existing GUIDs already in database.
				$existingHashForGuids = $entryDAO->listHashForFeedGuids($feed->id(), $newGuids) ?: [];
				/** @var array<string,bool> $newGuids */
				$newGuids = [];

				// Add entries in database if possible.
				/** @var FreshRSS_Entry $entry */
				foreach ($entries as $entry) {
					if (isset($newGuids[$entry->guid()])) {
						continue;	//Skip subsequent articles with same GUID
					}
					$newGuids[$entry->guid()] = true;
					$entry->_lastSeen($mtime);

					if (isset($existingHashForGuids[$entry->guid()])) {
						$existingHash = $existingHashForGuids[$entry->guid()];
						if (strcasecmp($existingHash, $entry->hash()) !== 0) {
							//This entry already exists but has been updated
							//Minz_Log::debug('Entry with GUID `' . $entry->guid() . '` updated in feed ' . $feed->url(false) .
								//', old hash ' . $existingHash . ', new hash ' . $entry->hash());
							$entry->_isFavorite(null);	// Do not change favourite state
							$entry->_isRead($mark_updated_article_unread ? false : null);	//Change is_read according to policy.
							if ($mark_updated_article_unread) {
								Minz_ExtensionManager::callHook('entry_auto_unread', $entry, 'updated_article');
							}

							$entry = Minz_ExtensionManager::callHook('entry_before_insert', $entry);
							if (!($entry instanceof FreshRSS_Entry)) {
								// An extension has returned a null value, there is nothing to insert.
								continue;
							}

							if (!$entry->isRead()) {
								$needFeedCacheRefresh = true;	//Maybe
								$nbMarkedUnread++;
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

						$entry = Minz_ExtensionManager::callHook('entry_before_insert', $entry);
						if (!($entry instanceof FreshRSS_Entry)) {
							// An extension has returned a null value, there is nothing to insert.
							continue;
						}

						$entry->applyFilterActions($titlesAsRead);
						if ($readWhenSameTitleInFeed > 0) {
							$titlesAsRead[$entry->title()] = true;
						}

						if ($pubSubHubbubEnabled && !$simplePiePush) {	//We use push, but have discovered an article by pull!
							$text = 'An article was discovered by pull although we use PubSubHubbub!: Feed ' .
								SimplePie_Misc::url_remove_credentials($url) .
								' GUID ' . $entry->guid();
							Minz_Log::warning($text, PSHB_LOG);
							Minz_Log::warning($text);
							$pubSubHubbubEnabled = false;
							$feed->pubSubHubbubError(true);
						}

						if (!$entryDAO->inTransaction()) {
							$entryDAO->beginTransaction();
						}
						$entryDAO->addEntry($entry->toArray(), true);

						$nb_new_articles++;
					}
				}
				// N.B.: Applies to _entry table and not _entrytmp:
				$entryDAO->updateLastSeen($feed->id(), array_keys($newGuids), $mtime);
			} elseif ($feedIsUnchanged) {
				// Feed cache was unchanged, so mark as seen the same entries as last time
				if (!$entryDAO->inTransaction()) {
					$entryDAO->beginTransaction();
				}
				$entryDAO->updateLastSeenUnchanged($feed->id(), $mtime);
			}
			unset($entries);

			if (rand(0, 30) === 1) {	// Remove old entries once in 30.
				if (!$entryDAO->inTransaction()) {
					$entryDAO->beginTransaction();
				}
				$nb = $feed->cleanOldEntries();
				if ($nb > 0) {
					$needFeedCacheRefresh = true;
				}
			}

			$feedDAO->updateLastUpdate($feed->id(), false, $mtime);
			if ($feed->keepMaxUnread() !== null && ($feed->nbNotRead() + $nbMarkedUnread > $feed->keepMaxUnread())) {
				Minz_Log::debug('Existing unread entries (' . ($feed->nbNotRead() + $nbMarkedUnread) . ') exceeding max number of ' .
					$feed->keepMaxUnread() .  ' for [' . $feed->url(false) . ']');
				$needFeedCacheRefresh |= ($feed->markAsReadMaxUnread() != false);
			}
			if ($simplePiePush === null) {
				// Do not call for WebSub events, as we do not know the list of articles still on the upstream feed.
				$needFeedCacheRefresh |= ($feed->markAsReadUponGone($feedIsEmpty, $mtime) != false);
			}
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
						$feedDAO->updateFeed($feed->id(), ['url' => $feed->url()]);
					}
				}
			} elseif ($feed->url() !== $url) {	// HTTP 301 Moved Permanently
				Minz_Log::notice('Feed ' . SimplePie_Misc::url_remove_credentials($url) .
					' moved permanently to ' .  SimplePie_Misc::url_remove_credentials($feed->url(false)));
				$feedProperties['url'] = $feed->url();
			}

			if ($simplePie != null) {
				if ($feed->name(true) === '') {
					//HTML to HTML-PRE	//ENT_COMPAT except '&'
					$name = strtr(html_only_entity_decode($simplePie->get_title()), ['<' => '&lt;', '>' => '&gt;', '"' => '&quot;']);
					$feed->_name($name);
					$feedProperties['name'] = $feed->name(false);
				}
				if (trim($feed->website()) === '') {
					$website = html_only_entity_decode($simplePie->get_link());
					$feed->_website($website == '' ? $feed->url() : $website);
					$feedProperties['website'] = $feed->website();
					$feed->faviconPrepare();
				}
				if (trim($feed->description()) === '') {
					$description = html_only_entity_decode($simplePie->get_description());
					if ($description !== '') {
						$feed->_description($description);
						$feedProperties['description'] = $feed->description();
					}
				}
			}
			if (!empty($feedProperties)) {
				$ok = $feedDAO->updateFeed($feed->id(), $feedProperties);
				if (!$ok && $feedIsNew) {
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

			if ($updated_feeds >= $maxFeeds) {
				break;
			}
		}
		return [$updated_feeds, reset($feeds) ?: null, $nb_new_articles];
	}

	/**
	 * @return int|false The number of articles marked as read, of false if error
	 */
	private static function keepMaxUnreads() {
		$affected = 0;
		$entryDAO = FreshRSS_Factory::createEntryDao();
		$newUnreadEntriesPerFeed = $entryDAO->newUnreadEntriesPerFeed();
		$feedDAO = FreshRSS_Factory::createFeedDao();
		$feeds = $feedDAO->listFeedsOrderUpdate(-1);
		foreach ($feeds as $feed) {
			if (!empty($newUnreadEntriesPerFeed[$feed->id()]) && $feed->keepMaxUnread() !== null &&
				($feed->nbNotRead() + $newUnreadEntriesPerFeed[$feed->id()] > $feed->keepMaxUnread())) {
				Minz_Log::debug('New unread entries (' . ($feed->nbNotRead() + $newUnreadEntriesPerFeed[$feed->id()]) . ') exceeding max number of ' .
					$feed->keepMaxUnread() .  ' for [' . $feed->url(false) . ']');
				$n = $feed->markAsReadMaxUnread();
				if ($n === false) {
					$affected = false;
					break;
				} else {
					$affected += $n;
				}
			}
		}
		if ($feedDAO->updateCachedValues() === false) {
			$affected = false;
		}
		return $affected;
	}

	/**
	 * Auto-add labels to new articles.
	 * @param int $nbNewEntries The number of top recent entries to process.
	 * @return int|false The number of new labels added, or false in case of error.
	 */
	private static function applyLabelActions(int $nbNewEntries) {
		$tagDAO = FreshRSS_Factory::createTagDao();
		$labels = FreshRSS_Context::labels();
		$labels = array_filter($labels, static function (FreshRSS_Tag $label) {
			return !empty($label->filtersAction('label'));
		});
		if (count($labels) <= 0) {
			return 0;
		}

		$entryDAO = FreshRSS_Factory::createEntryDao();
		/** @var array<array{id_tag:int,id_entry:string}> $applyLabels */
		$applyLabels = [];
		foreach (FreshRSS_Entry::fromTraversable($entryDAO->selectAll($nbNewEntries)) as $entry) {
			foreach ($labels as $label) {
				$label->applyFilterActions($entry, $applyLabel);
				if ($applyLabel) {
					$applyLabels[] = [
						'id_tag' => $label->id(),
						'id_entry' => $entry->id(),
					];
				}
			}
		}
		return $tagDAO->tagEntries($applyLabels);
	}

	public static function commitNewEntries(): void {
		$entryDAO = FreshRSS_Factory::createEntryDao();
		['all' => $nbNewEntries, 'unread' => $nbNewUnreadEntries] = $entryDAO->countNewEntries();
		if ($nbNewEntries > 0) {
			if (!$entryDAO->inTransaction()) {
				$entryDAO->beginTransaction();
			}
			if ($entryDAO->commitNewEntries()) {
				self::applyLabelActions($nbNewEntries);
				if ($nbNewUnreadEntries > 0) {
					self::keepMaxUnreads();
				}
			}
			if ($entryDAO->inTransaction()) {
				$entryDAO->commit();
			}
		}
	}

	/**
	 * This action actualizes entries from one or several feeds.
	 *
	 * Parameters are:
	 *   - id (default: null): Feed ID, or set to -1 to commit new articles to the main database
	 *   - url (default: null): Feed URL (instead of feed ID)
	 *   - maxFeeds (default: 10): Max number of feeds to refresh
	 *   - noCommit (default: 0): Set to 1 to prevent committing the new articles to the main database
	 * If id and url are not specified, all the feeds are actualized, within the limits of maxFeeds.
	 */
	public function actualizeAction(): int {
		Minz_Session::_param('actualize_feeds', false);
		$id = Minz_Request::paramInt('id');
		$url = Minz_Request::paramString('url');
		$maxFeeds = Minz_Request::paramInt('maxFeeds') ?: 10;
		$noCommit = ($_POST['noCommit'] ?? 0) == 1;

		if ($id === -1 && !$noCommit) {	//Special request only to commit & refresh DB cache
			$updated_feeds = 0;
			$feed = null;
			self::commitNewEntries();
		} else {
			if ($id === 0 && $url === '') {
				// Case of a batch refresh (e.g. cron)
				$databaseDAO = FreshRSS_Factory::createDatabaseDAO();
				$databaseDAO->minorDbMaintenance();
				Minz_ExtensionManager::callHookVoid('freshrss_user_maintenance');

				FreshRSS_feed_Controller::commitNewEntries();
				FreshRSS_category_Controller::refreshDynamicOpmls();
			}
			[$updated_feeds, $feed, $nbNewArticles] = self::actualizeFeeds($id, $url, $maxFeeds);
			if (!$noCommit && $nbNewArticles > 0) {
				FreshRSS_feed_Controller::commitNewEntries();
			}
		}

		if (Minz_Request::paramBoolean('ajax')) {
			// Most of the time, ajax request is for only one feed. But since
			// there are several parallel requests, we should return that there
			// are several updated feeds.
			Minz_Request::setGoodNotification(_t('feedback.sub.feed.actualizeds'));
			// No layout in ajax request.
			$this->view->_layout(null);
		} elseif ($feed instanceof FreshRSS_Feed) {
			// Redirect to the main page with correct notification.
			Minz_Request::good(_t('feedback.sub.feed.actualized', $feed->name()), [
				'params' => ['get' => 'f_' . $id]
			]);
		} elseif ($updated_feeds >= 1) {
			Minz_Request::good(_t('feedback.sub.feed.n_actualized', $updated_feeds), []);
		} else {
			Minz_Request::good(_t('feedback.sub.feed.no_refresh'), []);
		}
		return $updated_feeds;
	}

	/**
	 * @throws Minz_ConfigurationNamespaceException
	 * @throws Minz_PDOConnectionException
	 */
	public static function renameFeed(int $feed_id, string $feed_name): bool {
		if ($feed_id <= 0 || $feed_name === '') {
			return false;
		}
		FreshRSS_UserDAO::touch();
		$feedDAO = FreshRSS_Factory::createFeedDao();
		return $feedDAO->updateFeed($feed_id, ['name' => $feed_name]) === 1;
	}

	public static function moveFeed(int $feed_id, int $cat_id, string $new_cat_name = ''): bool {
		if ($feed_id <= 0 || ($cat_id <= 0 && $new_cat_name === '')) {
			return false;
		}
		FreshRSS_UserDAO::touch();

		$catDAO = FreshRSS_Factory::createCategoryDao();
		if ($cat_id > 0) {
			$cat = $catDAO->searchById($cat_id);
			$cat_id = $cat === null ? 0 : $cat->id();
		}
		if ($cat_id <= 1 && $new_cat_name != '') {
			$cat_id = $catDAO->addCategory(['name' => $new_cat_name]);
		}
		if ($cat_id <= 1) {
			$catDAO->checkDefault();
			$cat_id = FreshRSS_CategoryDAO::DEFAULTCATEGORYID;
		}

		$feedDAO = FreshRSS_Factory::createFeedDao();
		return $feedDAO->updateFeed($feed_id, ['category' => $cat_id]) === 1;
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
	public function moveAction(): void {
		if (!Minz_Request::isPost()) {
			Minz_Request::forward(['c' => 'subscription'], true);
		}

		$feed_id = Minz_Request::paramInt('f_id');
		$cat_id = Minz_Request::paramInt('c_id');

		if (self::moveFeed($feed_id, $cat_id)) {
			// TODO: return something useful
			// Log a notice to prevent "Empty IF statement" warning in PHP_CodeSniffer
			Minz_Log::notice('Moved feed `' . $feed_id . '` in the category `' . $cat_id . '`');
		} else {
			Minz_Log::warning('Cannot move feed `' . $feed_id . '` in the category `' . $cat_id . '`');
			Minz_Error::error(404);
		}
	}

	public static function deleteFeed(int $feed_id): bool {
		FreshRSS_UserDAO::touch();
		$feedDAO = FreshRSS_Factory::createFeedDao();
		if ($feedDAO->deleteFeed($feed_id)) {
			// TODO: Delete old favicon

			// Remove related queries
			/** @var array<array{'get'?:string,'name'?:string,'order'?:string,'search'?:string,'state'?:int,'url'?:string}> $queries */
			$queries = remove_query_by_get('f_' . $feed_id, FreshRSS_Context::userConf()->queries);
			FreshRSS_Context::userConf()->queries = $queries;
			FreshRSS_Context::userConf()->save();
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
	 */
	public function deleteAction(): void {
		$from = Minz_Request::paramString('from');
		$id = Minz_Request::paramInt('id');

		switch ($from) {
			case 'stats':
				$redirect_url = ['c' => 'stats', 'a' => 'idle'];
				break;
			case 'normal':
				$get = Minz_Request::paramString('get');
				if ($get) {
					$redirect_url = ['c' => 'index', 'a' => 'normal', 'params' => ['get' => $get]];
				} else {
					$redirect_url = ['c' => 'index', 'a' => 'normal'];
				}
				break;
			default:
				$redirect_url = ['c' => 'subscription', 'a' => 'index'];
				if (!Minz_Request::isPost()) {
					Minz_Request::forward($redirect_url, true);
				}
		}

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
	public function clearCacheAction(): void {
		//Get Feed.
		$id = Minz_Request::paramInt('id');

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$feed = $feedDAO->searchById($id);
		if ($feed === null) {
			Minz_Request::bad(_t('feedback.sub.feed.not_found'), []);
			return;
		}

		$feed->clearCache();

		Minz_Request::good(_t('feedback.sub.feed.cache_cleared', $feed->name()), [
			'params' => ['get' => 'f_' . $feed->id()],
		]);
	}

	/**
	 * This action forces reloading the articles of a feed.
	 *
	 * Parameters are:
	 *   - id (mandatory - no default): Feed ID
	 *
	 * @throws FreshRSS_BadUrl_Exception
	 */
	public function reloadAction(): void {
		if (function_exists('set_time_limit')) {
			@set_time_limit(300);
		}

		//Get Feed ID.
		$feed_id = Minz_Request::paramInt('id');
		$limit = Minz_Request::paramInt('reload_limit') ?: 10;

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$entryDAO = FreshRSS_Factory::createEntryDao();

		$feed = $feedDAO->searchById($feed_id);
		if ($feed === null) {
			Minz_Request::bad(_t('feedback.sub.feed.not_found'), []);
			return;
		}

		//Re-fetch articles as if the feed was new.
		$feedDAO->updateFeed($feed->id(), [ 'lastUpdate' => 0 ]);
		[, , $nb_new_articles] = self::actualizeFeeds($feed_id);
		if ($nb_new_articles > 0) {
			FreshRSS_feed_Controller::commitNewEntries();
		}

		//Extract all feed entries from database, load complete content and store them back in database.
		$entries = $entryDAO->listWhere('f', $feed_id, FreshRSS_Entry::STATE_ALL, 'DESC', $limit);

		//We need another DB connection in parallel for unbuffered streaming
		Minz_ModelPdo::$usesSharedPdo = false;
		if (FreshRSS_Context::systemConf()->db['type'] === 'mysql') {
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
		Minz_Request::good(_t('feedback.sub.feed.reloaded', $feed->name()), [
			'params' => ['get' => 'f_' . $feed->id()]
		]);
	}

	/**
	 * This action creates a preview of a content-selector.
	 *
	 * Parameters are:
	 *   - id (mandatory - no default): Feed ID
	 *   - selector (mandatory - no default): Selector to preview
	 *
	 */
	public function contentSelectorPreviewAction(): void {

		//Configure.
		$this->view->fatalError = '';
		$this->view->selectorSuccess = false;
		$this->view->htmlContent = '';

		$this->view->_layout(null);

		$this->_csp([
			'default-src' => "'self'",
			'frame-src' => '*',
			'img-src' => '* data:',
			'media-src' => '*',
		]);

		//Get parameters.
		$feed_id = Minz_Request::paramInt('id');
		$content_selector = Minz_Request::paramString('selector');

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
			$entry = $myEntry;
		}

		if ($entry == null) {
			$this->view->fatalError = _t('feedback.sub.feed.selector_preview.no_entries');
			return;
		}

		//Get feed.
		$feed = $entry->feed();

		if ($feed === null) {
			$this->view->fatalError = _t('feedback.sub.feed.selector_preview.no_feed');
			return;
		}

		$attributes = $feed->attributes();
		$attributes['path_entries_filter'] = Minz_Request::paramString('selector_filter', true);

		//Fetch & select content.
		try {
			$fullContent = FreshRSS_Entry::getContentByParsing(
				htmlspecialchars_decode($entry->link(), ENT_QUOTES),
				htmlspecialchars_decode($content_selector, ENT_QUOTES),
				$attributes
			);

			if ($fullContent != '') {
				$this->view->selectorSuccess = true;
				$this->view->htmlContent = $fullContent;
			} else {
				$this->view->selectorSuccess = false;
				$this->view->htmlContent = $entry->content(false);
			}
		} catch (Exception $e) {
			$this->view->fatalError = _t('feedback.sub.feed.selector_preview.http_error');
		}
	}
}
