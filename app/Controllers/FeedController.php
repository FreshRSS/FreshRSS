<?php
declare(strict_types=1);

namespace FreshRss\Controllers;

use FreshRss\Exceptions\AlreadySubscribedException;
use FreshRss\Exceptions\BadUrlException;
use FreshRss\Exceptions\FeedException;
use FreshRss\Exceptions\FeedNotAddedException;
use FreshRss\Minz\ConfigurationNamespaceException;
use FreshRss\Minz\Error;
use FreshRss\Minz\ExtensionManager;
use FreshRss\Minz\FileNotExistException;
use FreshRss\Minz\HookType;
use FreshRss\Minz\Log;
use FreshRss\Minz\ModelPdo;
use FreshRss\Minz\PDOConnectionException;
use FreshRss\Minz\Request;
use FreshRss\Minz\Session;
use FreshRss\Models\ActionController;
use FreshRss\Models\Auth;
use FreshRss\Models\CategoryDAO;
use FreshRss\Models\Context;
use FreshRss\Models\Entry;
use FreshRss\Models\Factory;
use FreshRss\Models\Feed;
use FreshRss\Models\SimplePieCustom;
use FreshRss\Models\Tag;
use FreshRss\Models\UserDAO;
use FreshRss\Models\UserQuery;
use FreshRss\Models\View;
use FreshRss\Utils\HttpUtil;

/**
 * Controller to handle every feed actions.
 */
class FeedController extends ActionController {
	/**
	 * This action is called before every other action in that class. It is
	 * the common boilerplate for every action. It is triggered by the
	 * underlying framework.
	 */
	#[\Override]
	public function firstAction(): void {
		if (!Auth::hasAccess()) {
			$action = Request::actionName();
			$allow_anonymous_refresh = Context::systemConf()->allow_anonymous_refresh;

			// Likely coming from bookmarklet, redirect to the login page
			if ($action === 'add') {
				Request::forward(['c' => 'auth', 'a' => 'login']);
				return;
			}

			if ($action !== 'actualize' || (!$allow_anonymous_refresh && !Request::tokenIsOk())) {
				Error::error(403);
			}
		}
	}

	/**
	 * @param array<string,mixed> $attributes
	 * @throws AlreadySubscribedException
	 * @throws BadUrlException
	 * @throws FeedException
	 * @throws FeedNotAddedException
	 * @throws FileNotExistException
	 */
	public static function addFeed(string $url, string $title = '', int $cat_id = 0, string $new_cat_name = '',
		string $http_auth = '', array $attributes = [], int $kind = Feed::KIND_RSS): Feed {
		UserDAO::touch();
		if (function_exists('set_time_limit')) {
			@set_time_limit(300);
		}

		$catDAO = Factory::createCategoryDao();

		$url = trim($url);

		/** @var string|null $urlHooked */
		$urlHooked = ExtensionManager::callHook(HookType::CheckUrlBeforeAdd, $url);
		if ($urlHooked === null) {
			throw new FeedNotAddedException($url);
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

		$feed = new Feed($url);	//Throws BadUrlException
		$title = trim($title);
		if ($title !== '') {
			$feed->_name($title);
		}
		$feed->_kind($kind);
		$feed->_attributes($attributes);
		$feed->_httpAuth($http_auth);
		if ($cat === null) {
			$feed->_categoryId(CategoryDAO::DEFAULTCATEGORYID);
		} else {
			$feed->_category($cat);
		}
		switch ($kind) {
			case Feed::KIND_RSS:
			case Feed::KIND_RSS_FORCED:
				if ($feed->load(loadDetails: true) === null) {	// Throws FeedException, FileNotExistException
					throw new FeedNotAddedException($url);
				}
				break;
			case Feed::KIND_HTML_XPATH:
			case Feed::KIND_XML_XPATH:
				$feed->_website($url);
				break;
		}

		$feedDAO = Factory::createFeedDao();
		if ($feedDAO->searchByUrl($feed->url()) !== null) {
			throw new AlreadySubscribedException($url, $feed->name());
		}

		/** @var Feed|null $feed */
		$feed = ExtensionManager::callHook(HookType::FeedBeforeInsert, $feed);
		if ($feed === null) {
			throw new FeedNotAddedException($url);
		}

		$id = $feedDAO->addFeedObject($feed);
		if (!$id) {
			// There was an error in database… we cannot say what here.
			throw new FeedNotAddedException($url);
		}
		$feed->_id($id);

		// Ok, feed has been added in database. Now we have to refresh entries.
		self::actualizeFeedsAndCommit($id, $url);
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
	 *   - cat_id (default: 1)
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
		$url = Request::paramString('url_rss');

		if ($url === '') {
			// No url, do nothing
			Request::forward([
				'c' => 'subscription',
				'a' => 'index',
			], true);
		}

		$feedDAO = Factory::createFeedDao();
		$url_redirect = [
			'c' => 'subscription',
			'a' => 'add',
			'params' => [],
		];

		$limits = Context::systemConf()->limits;
		$this->view->feeds = $feedDAO->listFeeds();
		if (count($this->view->feeds) >= $limits['max_feeds']) {
			Request::bad(_t('feedback.sub.feed.over_max', $limits['max_feeds']), $url_redirect);
		}

		if (Request::isPost()) {
			$cat = Request::paramInt('category');

			// HTTP information are useful if feed is protected behind a
			// HTTP authentication
			$user = Request::paramString('http_user');
			$pass = Request::paramString('http_pass');
			$http_auth = '';
			if ($user != '' && $pass != '') {	//TODO: Sanitize
				$http_auth = $user . ':' . $pass;
			}

			$cookie = Request::paramString('curl_params_cookie', plaintext: true);
			$cookie_file = Request::paramBoolean('curl_params_cookiefile');
			$max_redirs = Request::paramInt('curl_params_redirects');
			$useragent = Request::paramString('curl_params_useragent', plaintext: true);
			$proxy_address = Request::paramString('curl_params', plaintext: true);
			$proxy_type = Request::paramIntNull('proxy_type');
			$request_method = Request::paramString('curl_method', plaintext: true);
			$request_fields = Request::paramString('curl_fields', plaintext: true);
			$headers = Request::paramTextToArray('http_headers', plaintext: true);

			$opts = [];
			if ($proxy_type !== null) {
				$opts[CURLOPT_PROXYTYPE] = $proxy_type;
			}
			if ($proxy_address !== '') {
				$opts[CURLOPT_PROXY] = $proxy_address;
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
				$opts[CURLOPT_FOLLOWLOCATION] = true;
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

			$headers = array_filter($headers, fn(string $header): bool => trim($header) !== '');
			if (!empty($headers)) {
				$opts[CURLOPT_HTTPHEADER] = array_merge($headers, $opts[CURLOPT_HTTPHEADER] ?? []);
				$opts[CURLOPT_HTTPHEADER] = array_unique($opts[CURLOPT_HTTPHEADER]);
			}

			$attributes = [
				'curl_params' => empty($opts) ? null : HttpUtil::sanitizeCurlParams($opts),
			];
			$attributes['ssl_verify'] = Request::paramTernary('ssl_verify');
			$timeout = Request::paramInt('timeout');
			$attributes['timeout'] = $timeout > 0 ? $timeout : null;

			$feed_kind = Request::paramInt('feed_kind') ?: Feed::KIND_RSS;
			if ($feed_kind === Feed::KIND_HTML_XPATH || $feed_kind === Feed::KIND_XML_XPATH) {
				$xPathSettings = [];
				if (Request::paramString('xPathFeedTitle') !== '') {
					$xPathSettings['feedTitle'] = Request::paramString('xPathFeedTitle', true);
				}
				if (Request::paramString('xPathItem') !== '') {
					$xPathSettings['item'] = Request::paramString('xPathItem', true);
				}
				if (Request::paramString('xPathItemTitle') !== '') {
					$xPathSettings['itemTitle'] = Request::paramString('xPathItemTitle', true);
				}
				if (Request::paramString('xPathItemContent') !== '') {
					$xPathSettings['itemContent'] = Request::paramString('xPathItemContent', true);
				}
				if (Request::paramString('xPathItemUri') !== '') {
					$xPathSettings['itemUri'] = Request::paramString('xPathItemUri', true);
				}
				if (Request::paramString('xPathItemAuthor') !== '') {
					$xPathSettings['itemAuthor'] = Request::paramString('xPathItemAuthor', true);
				}
				if (Request::paramString('xPathItemTimestamp') !== '') {
					$xPathSettings['itemTimestamp'] = Request::paramString('xPathItemTimestamp', true);
				}
				if (Request::paramString('xPathItemTimeFormat') !== '') {
					$xPathSettings['itemTimeFormat'] = Request::paramString('xPathItemTimeFormat', true);
				}
				if (Request::paramString('xPathItemThumbnail') !== '') {
					$xPathSettings['itemThumbnail'] = Request::paramString('xPathItemThumbnail', true);
				}
				if (Request::paramString('xPathItemCategories') !== '') {
					$xPathSettings['itemCategories'] = Request::paramString('xPathItemCategories', true);
				}
				if (Request::paramString('xPathItemUid') !== '') {
					$xPathSettings['itemUid'] = Request::paramString('xPathItemUid', true);
				}
				if (!empty($xPathSettings)) {
					$attributes['xpath'] = $xPathSettings;
				}
			} elseif ($feed_kind === Feed::KIND_JSON_DOTNOTATION || $feed_kind === Feed::KIND_HTML_XPATH_JSON_DOTNOTATION) {
				$jsonSettings = [];
				if (Request::paramString('jsonFeedTitle') !== '') {
					$jsonSettings['feedTitle'] = Request::paramString('jsonFeedTitle', true);
				}
				if (Request::paramString('jsonItem') !== '') {
					$jsonSettings['item'] = Request::paramString('jsonItem', true);
				}
				if (Request::paramString('jsonItemTitle') !== '') {
					$jsonSettings['itemTitle'] = Request::paramString('jsonItemTitle', true);
				}
				if (Request::paramString('jsonItemContent') !== '') {
					$jsonSettings['itemContent'] = Request::paramString('jsonItemContent', true);
				}
				if (Request::paramString('jsonItemUri') !== '') {
					$jsonSettings['itemUri'] = Request::paramString('jsonItemUri', true);
				}
				if (Request::paramString('jsonItemAuthor') !== '') {
					$jsonSettings['itemAuthor'] = Request::paramString('jsonItemAuthor', true);
				}
				if (Request::paramString('jsonItemTimestamp') !== '') {
					$jsonSettings['itemTimestamp'] = Request::paramString('jsonItemTimestamp', true);
				}
				if (Request::paramString('jsonItemTimeFormat') !== '') {
					$jsonSettings['itemTimeFormat'] = Request::paramString('jsonItemTimeFormat', true);
				}
				if (Request::paramString('jsonItemThumbnail') !== '') {
					$jsonSettings['itemThumbnail'] = Request::paramString('jsonItemThumbnail', true);
				}
				if (Request::paramString('jsonItemCategories') !== '') {
					$jsonSettings['itemCategories'] = Request::paramString('jsonItemCategories', true);
				}
				if (Request::paramString('jsonItemUid') !== '') {
					$jsonSettings['itemUid'] = Request::paramString('jsonItemUid', true);
				}
				if (!empty($jsonSettings)) {
					$attributes['json_dotnotation'] = $jsonSettings;
				}
				if (Request::paramString('xPathToJson', plaintext: true) !== '') {
					$attributes['xPathToJson'] = Request::paramString('xPathToJson', plaintext: true);
				}
			}

			try {
				$feed = self::addFeed($url, '', $cat, '', $http_auth, $attributes, $feed_kind);
			} catch (BadUrlException $e) {
				// Given url was not a valid url!
				Log::warning($e->getMessage());
				Request::bad(_t('feedback.sub.feed.invalid_url', $url), $url_redirect);
				return;
			} catch (FeedException $e) {
				// Something went bad (timeout, server not found, etc.)
				Log::warning($e->getMessage());
				Request::bad(_t('feedback.sub.feed.internal_problem', _url('index', 'logs')), $url_redirect);
				return;
			} catch (FileNotExistException $e) {
				// Cache directory doesn’t exist!
				Log::error($e->getMessage());
				Request::bad(_t('feedback.sub.feed.internal_problem', _url('index', 'logs')), $url_redirect);
				return;
			} catch (AlreadySubscribedException $e) {
				Request::bad(_t('feedback.sub.feed.already_subscribed', $e->feedName()), $url_redirect);
				return;
			} catch (FeedNotAddedException $e) {
				Request::bad(_t('feedback.sub.feed.not_added', $e->url()), $url_redirect);
				return;
			}

			// Entries are in DB
			$keep_adding_feed = Request::paramBoolean('keep_adding_feed');
			if ($keep_adding_feed) {
				// We stay in add feed while maintaining some fields
				$url_redirect['params']['cat_id'] = $feed->categoryId();
				$url_redirect['params']['keep_adding_feed'] = $keep_adding_feed;
			} else {
				// we redirect to feed configuration page.
				$url_redirect['a'] = 'feed';
				$url_redirect['params']['id'] = '' . $feed->id();
			}
			Request::good(
				_t('feedback.sub.feed.added', $feed->name()),
				$url_redirect,
				showNotification: Context::userConf()->good_notification_timeout > 0
			);
		} else {
			// GET request: we must ask confirmation to user before adding feed.
			View::prependTitle(_t('sub.feed.title_add') . ' · ');

			$catDAO = Factory::createCategoryDao();
			$this->view->categories = $catDAO->listCategories(prePopulateFeeds: false);
			$this->view->feed = new Feed($url);
			try {
				// We try to get more information about the feed.
				$this->view->feed->load(loadDetails: true);
				$this->view->load_ok = true;
			} catch (\Exception) {
				$this->view->load_ok = false;
			}

			$feed = $feedDAO->searchByUrl($this->view->feed->url());
			if ($feed !== null) {
				// Already subscribe so we redirect to the feed configuration page.
				$url_redirect['a'] = 'feed';
				$url_redirect['params']['id'] = $feed->id();
				Request::good(
					_t('feedback.sub.feed.already_subscribed', $feed->name()),
					$url_redirect,
					showNotification: Context::userConf()->good_notification_timeout > 0
				);
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
		if (!Request::isPost()) {
			Request::forward(['c' => 'subscription'], true);
		}
		$id = Request::paramInt('id');
		$url_redirect = [
			'c' => 'subscription',
			'a' => 'index',
			'params' => ['id' => $id],
		];

		if (!Request::isPost()) {
			Request::forward($url_redirect, true);
		}

		$feedDAO = Factory::createFeedDao();
		$n = $feedDAO->truncate($id);

		invalidateHttpCache();
		if ($n === false) {
			Request::bad(_t('feedback.sub.feed.error'), $url_redirect);
		} else {
			Request::good(
				_t('feedback.sub.feed.n_entries_deleted', $n),
				$url_redirect,
				showNotification: Context::userConf()->good_notification_timeout > 0
			);
		}
	}

	/**
	 * @param SimplePieCustom|null $simplePiePush Used by WebSub (PubSubHubbub) to push updates
	 * @param string $selfUrl Used by WebSub (PubSubHubbub) to override the feed URL
	 * @return array{0:int,1:Feed|null,2:int,3:array<Feed>} Number of updated feeds, first feed or null, number of new articles,
	 * 	list of feeds for which a cache refresh is needed
	 * @throws BadUrlException
	 */
	public static function actualizeFeeds(?int $feed_id = null, ?string $feed_url = null, ?int $maxFeeds = null,
		?SimplePieCustom $simplePiePush = null, string $selfUrl = ''): array {
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

		$catDAO = Factory::createCategoryDao();
		$feedDAO = Factory::createFeedDao();
		$entryDAO = Factory::createEntryDao();

		// Create a list of feeds to actualize.
		$feeds = [];
		if ($feed_id !== null || $feed_url !== null) {
			$feed = $feed_id !== null ? $feedDAO->searchById($feed_id) : $feedDAO->searchByUrl($feed_url);
			if ($feed !== null && $feed->id() > 0) {
				if ($selfUrl !== '') {
					$feed->_selfUrl($selfUrl);
				}
				$feeds[] = $feed;
				$feed_id = $feed->id();
			}
		} else {
			$feeds = $feedDAO->listFeedsOrderUpdate(-1);
			// Hydrate category for each feed to avoid that each feed has to make an SQL request
			$categories = $catDAO->listCategories(prePopulateFeeds: false, details: false);
			foreach ($feeds as $feed) {
				$category = $categories[$feed->categoryId()] ?? null;
				if ($category !== null) {
					$feed->_category($category);
				}
			}
		}

		// WebSub (PubSubHubbub) support
		$pubsubhubbubEnabledGeneral = Context::systemConf()->pubsubhubbub_enabled;
		$pshbMinAge = time() - (3600 * 24);  //TODO: Make a configuration.

		$nbUpdatedFeeds = 0;
		$nbNewArticles = 0;
		$feedsCacheToRefresh = [];
		/** @var array<int,array<string,true>> */
		$categoriesEntriesTitle = [];
		/** @var array<int,array<string,true>> */
		$categoriesEntriesGuid = [];

		$feeds = ExtensionManager::callHook(HookType::FeedsListBeforeActualize, $feeds);
		if (!is_iterable($feeds)) {
			$feeds = [];
		}

		$firstFeed = null;
		foreach ($feeds as $feed) {
			if (!($feed instanceof Feed)) {
				continue;
			}
			if (null === $firstFeed) {
				$firstFeed = $feed;
			}
			$feed = ExtensionManager::callHook(HookType::FeedBeforeActualize, $feed);
			if (!($feed instanceof Feed)) {
				continue;
			}

			$url = $feed->url();	//For detection of HTTP 301
			$oldSimplePieHash = $feed->attributeString('SimplePieHash');

			$pubSubHubbubEnabled = $pubsubhubbubEnabledGeneral && $feed->pubSubHubbubEnabled();
			if ($simplePiePush === null && $feed_id === null && $pubSubHubbubEnabled && ($feed->lastUpdate() > $pshbMinAge)) {
				//$text = 'Skip pull of feed using PubSubHubbub: ' . $url;
				//Log::debug($text);
				//Log::debug($text, PSHB_LOG);
				continue;	//When PubSubHubbub is used, do not pull refresh so often
			}

			if ($feed->mute() && ($feed_id === null || $simplePiePush !== null)) {
				continue;	// If the feed is disabled, only allow refresh if manually requested for that specific feed
			}
			$mtime = $feed->cacheModifiedTime() ?: 0;
			$ttl = $feed->ttl();
			if ($ttl === Feed::TTL_DEFAULT) {
				$ttl = Context::userConf()->ttl_default;
			}
			if ($simplePiePush === null && $feed_id === null && (time() <= $feed->lastUpdate() + $ttl)) {
				//Too early to refresh from source, but check whether the feed was updated by another user
				$ε = 10;	// negligible offset errors in seconds
				if ($mtime <= 0 ||
					$feed->lastUpdate() + $ε >= $mtime ||
					time() + $ε >= $mtime + Context::systemConf()->limits['cache_duration']) {	// is cache still valid?
					continue;	//Nothing newer from other users
				}
				Log::debug('Feed ' . $feed->url(false) . ' was updated at ' . date('c', $feed->lastUpdate()) .
					', and at ' . date('c', $mtime) . ' by another user; take advantage of newer cache.');
			}

			if (!$feed->lock()) {
				Log::notice('Feed already being actualized: ' . $feed->url(false));
				continue;
			}

			$feedIsNew = $feed->lastUpdate() <= 0;

			try {
				if ($simplePiePush !== null) {
					$simplePie = $simplePiePush;	//Used by WebSub
				} elseif ($feed->kind() === Feed::KIND_HTML_XPATH) {
					$simplePie = $feed->loadHtmlXpath();
					if ($simplePie === null) {
						throw new FeedException('HTML+XPath Web scraping failed for [' . $feed->url(false) . ']');
					}
				} elseif ($feed->kind() === Feed::KIND_XML_XPATH) {
					$simplePie = $feed->loadHtmlXpath();
					if ($simplePie === null) {
						throw new FeedException('XML+XPath parsing failed for [' . $feed->url(false) . ']');
					}
				} elseif ($feed->kind() === Feed::KIND_JSON_DOTNOTATION) {
					$simplePie = $feed->loadJson();
					if ($simplePie === null) {
						throw new FeedException('JSON dot notation parsing failed for [' . $feed->url(false) . ']');
					}
				} elseif ($feed->kind() === Feed::KIND_JSONFEED) {
					$simplePie = $feed->loadJson();
					if ($simplePie === null) {
						throw new FeedException('JSON Feed parsing failed for [' . $feed->url(false) . ']');
					}
				} elseif ($feed->kind() === Feed::KIND_HTML_XPATH_JSON_DOTNOTATION) {
					$simplePie = $feed->loadJson();
					if ($simplePie === null) {
						throw new FeedException('HTML+XPath+JSON parsing failed for [' . $feed->url(false) . ']');
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
					$feedIsEmpty = $simplePiePush === null && empty($newGuids);
					$feedIsUnchanged = false;
				}
				$mtime = $feed->cacheModifiedTime() ?: time();
			} catch (FeedException $e) {
				Log::warning($e->getMessage());
				$feedDAO->updateLastError($feed->id());
				$feed->_error(time());
				if ($e->getCode() === 410) {
					// HTTP 410 Gone
					Log::warning('Muting gone feed: ' . $feed->url(false));
					$feedDAO->mute($feed->id(), true);
					$feed->_ttl(-abs($feed->ttl())); // Replicate behavior of line above which acts directly into the DB
				}
				$feed->unlock();
				continue;
			}

			$needFeedCacheRefresh = false;
			$nbMarkedUnread = 0;

			if (count($newGuids) > 0) {
				if (!$feed->hasAttribute('read_when_same_title_in_feed')) {
					$readWhenSameTitleInFeed = (int)Context::userConf()->mark_when['same_title_in_feed'];
				} elseif ($feed->attributeBoolean('read_when_same_title_in_feed') === false) {
					$readWhenSameTitleInFeed = 0;
				} else {
					$readWhenSameTitleInFeed = $feed->attributeInt('read_when_same_title_in_feed') ?? 0;
				}
				if ($readWhenSameTitleInFeed > 0) {
					$titlesAsRead = array_fill_keys($feedDAO->listTitles($feed->id(), $readWhenSameTitleInFeed), true);
				} else {
					$titlesAsRead = [];
				}

				$category = $feed->category();
				if (!isset($categoriesEntriesTitle[$feed->categoryId()]) && $category !== null && $category->hasAttribute('read_when_same_title_in_category')) {
					$categoriesEntriesTitle[$feed->categoryId()] = array_fill_keys(
						$catDAO->listTitles($feed->categoryId(), $category->attributeInt('read_when_same_title_in_category') ?? 0),
						true
					);
				}
				if (!isset($categoriesEntriesGuid[$feed->categoryId()]) && $category !== null && $category->hasAttribute('read_when_same_guid_in_category')) {
					$categoriesEntriesGuid[$feed->categoryId()] = array_fill_keys(
						$catDAO->listGuids($feed->categoryId(), $category->attributeInt('read_when_same_guid_in_category') ?? 0),
						true
					);
				}

				$mark_updated_article_unread = $feed->attributeBoolean('mark_updated_article_unread') ?? Context::userConf()->mark_updated_article_unread;

				// For this feed, check existing GUIDs already in database.
				$existingHashForGuids = $entryDAO->listHashForFeedGuids($feed->id(), $newGuids);
				/** @var array<string,bool> $newGuids */
				$newGuids = [];

				// Add entries in database if possible.
				/** @var Entry $entry */
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
							$entry->_isUpdated(true);
							$entry->_lastModified($mtime);
							//Log::debug('Entry with GUID `' . $entry->guid() . '` updated in feed ' . $feed->url(false) .
								//', old hash ' . $existingHash . ', new hash ' . $entry->hash());
							$entry->_isFavorite(null);	// Do not change favourite state
							$entry->_isRead($mark_updated_article_unread ? false : null);	//Change is_read according to policy.
							if ($mark_updated_article_unread) {
								ExtensionManager::callHook(HookType::EntryAutoUnread, $entry, 'updated_article');
							}

							$entry = ExtensionManager::callHook(HookType::EntryBeforeInsert, $entry);
							if (!($entry instanceof Entry)) {
								// An extension has returned a null value, there is nothing to insert.
								continue;
							}

							// NB: Do not mark updated articles as read based on their title, as the duplicate title maybe be from the same article.
							$entry->applyFilterActions([]);
							if ($readWhenSameTitleInFeed > 0) {
								$titlesAsRead[$entry->title()] = true;
							}
							if (isset($categoriesEntriesTitle[$feed->categoryId()])) {
								$categoriesEntriesTitle[$feed->categoryId()][$entry->title()] = true;
							}
							if (isset($categoriesEntriesGuid[$feed->categoryId()])) {
								$categoriesEntriesGuid[$feed->categoryId()][$entry->guid()] = true;
							}

							if (!$entry->isRead()) {
								$needFeedCacheRefresh = true;	//Maybe
								$nbMarkedUnread++;
							}

							// If the entry has changed, there is a good chance for the full content to have changed as well.
							$entry->loadCompleteContent(true);

							$entry = ExtensionManager::callHook(HookType::EntryBeforeUpdate, $entry);
							if (!($entry instanceof Entry)) {
								// An extension has returned a null value, there is nothing to insert.
								continue;
							}

							$entryDAO->updateEntry($entry->toArray());
						}
					} else {
						$entry->_isUpdated(false);
						$id = uTimeString();
						$entry->_id($id);

						$entry = ExtensionManager::callHook(HookType::EntryBeforeInsert, $entry);
						if (!($entry instanceof Entry)) {
							// An extension has returned a null value, there is nothing to insert.
							continue;
						}

						$entry->applyFilterActions(array_merge($titlesAsRead, $categoriesEntriesTitle[$feed->categoryId()] ?? []),
							$categoriesEntriesGuid[$feed->categoryId()] ?? []);
						if ($readWhenSameTitleInFeed > 0) {
							$titlesAsRead[$entry->title()] = true;
						}
						if (isset($categoriesEntriesTitle[$feed->categoryId()])) {
							$categoriesEntriesTitle[$feed->categoryId()][$entry->title()] = true;
						}
						if (isset($categoriesEntriesGuid[$feed->categoryId()])) {
							$categoriesEntriesGuid[$feed->categoryId()][$entry->guid()] = true;
						}

						$needFeedCacheRefresh = true;

						if ($pubSubHubbubEnabled && $simplePiePush === null) {	//We use push, but have discovered an article by pull!
							$text = 'An article was discovered by pull although we use PubSubHubbub!: Feed ' .
								\SimplePie\Misc::url_remove_credentials($url) .
								' GUID ' . $entry->guid();
							Log::warning($text, PSHB_LOG);
							Log::warning($text);
							$pubSubHubbubEnabled = false;
							$feed->pubSubHubbubError(true);
						}

						$entry = ExtensionManager::callHook(HookType::EntryBeforeAdd, $entry);
						if (!($entry instanceof Entry)) {
							// An extension has returned a null value, there is nothing to insert.
							continue;
						}

						if ($entryDAO->addEntry($entry->toArray(), true)) {
							$nbNewArticles++;
						}
					}
				}
				// N.B.: Applies to _entry table and not _entrytmp:
				$entryDAO->updateLastSeen($feed->id(), array_keys($newGuids), $mtime);
			} elseif ($feedIsUnchanged) {
				// Feed cache was unchanged, so mark as seen the same entries as last time
				$entryDAO->updateLastSeenUnchanged($feed->id(), $mtime);
			}
			unset($entries);

			if (rand(0, 30) === 1) {	// Remove old entries once in 30.
				$nb = $feed->cleanOldEntries();
				if ($nb > 0) {
					$needFeedCacheRefresh = true;
				}
			}

			if ($simplePiePush === null) {	// Not WebSub
				$feedDAO->updateLastUpdate($feed->id(), $mtime);
				$feed->_lastUpdate($mtime);
				// Do not call for WebSub events, as we do not know the list of articles still on the upstream feed.
				$needFeedCacheRefresh |= ($feed->markAsReadUponGone($feedIsEmpty, $mtime) != false);
			} elseif ($feed->inError()) {
				// Reset feed error state in case of successful WebSub push
				$feedDAO->updateLastError($feed->id(), 0);
				$feed->_error(0);
			}
			if ($needFeedCacheRefresh) {
				$feedsCacheToRefresh[] = $feed;
			}

			$feedProperties = [];
			if ($oldSimplePieHash !== $feed->attributeString('SimplePieHash')) {
				$feedProperties['attributes'] = $feed->attributes();
			}

			if ($feed->url() !== $url) {	// HTTP 301 Moved Permanently
				Log::warning('Feed ' . \SimplePie\Misc::url_remove_credentials($url) .
					' moved permanently to ' . $feed->url(includeCredentials: false));
				$feedProperties['url'] = $feed->url();
			} elseif ($simplePiePush !== null && $selfUrl !== '' && $selfUrl !== $feed->url()) {	// selfUrl has priority for WebSub
				// https://github.com/pubsubhubbub/PubSubHubbub/wiki/Moving-Feeds-or-changing-Hubs
				Log::debug('WebSub unsubscribe ' . $feed->url(includeCredentials: false));
				if (!$feed->pubSubHubbubSubscribe(false)) {	//Unsubscribe
					Log::warning('Error while WebSub unsubscribing from ' . $feed->url(includeCredentials: false));
				}
				$feed->_url($selfUrl);
				Log::warning('Feed ' . \SimplePie\Misc::url_remove_credentials($url) .
					' canonical address moved to ' . $feed->url(includeCredentials: false));
				$feedProperties['url'] = $feed->url();
			}

			if ($simplePie != null) {
				$feedImageUrl = htmlspecialchars_decode($simplePie->get_icon_url() ?? '', ENT_QUOTES);
				$feedImageUrl = $feedImageUrl !== '' ? (HttpUtil::checkUrl($feedImageUrl) ?: '') : '';
				if ($feedImageUrl !== ($feed->attributeString('feedIconUrl') ?? '')) {
					$feed->_attribute('feedIconUrl', $feedImageUrl !== '' ? $feedImageUrl : null);
					$feed->resetFaviconHash();
					$feedProperties['attributes'] = $feed->attributes();
				}

				if ($feed->name(true) === '') {
					//HTML to HTML-PRE	//ENT_COMPAT except '&'
					$name = strtr(html_only_entity_decode($simplePie->get_title()), ['<' => '&lt;', '>' => '&gt;', '"' => '&quot;']);
					$feed->_name($name);
					$feedProperties['name'] = $feed->name(false);
				}
				if ($feed->website() === '' || $feed->website() === $feed->url()) {
					$website = html_only_entity_decode($simplePie->get_link());
					if ($website !== $feed->website()) {
						$feed->_website($website);
						$feedProperties['website'] = $feed->website();
						$feed->faviconPrepare();
					}
				}
				if (trim($feed->description()) === '') {
					$description = html_only_entity_decode($simplePie->get_description());
					if ($description !== '') {
						$feed->_description($description);
						$feedProperties['description'] = $feed->description();
					}
				}
			}
			if (!empty($feedProperties) || $feedIsNew) {
				$feedProperties['attributes'] = $feed->attributes();
				$ok = $feedDAO->updateFeed($feed->id(), $feedProperties);
				// No need to update $feed object, since $feedProperties are taken from the object itself
				if (!$ok && $feedIsNew) {
					//Cancel adding new feed in case of database error at first actualize
					$feedDAO->deleteFeed($feed->id());
					// TODO: Reflect in the $feed object the feed has been deleted.
					$feed->unlock();
					break;
				}
			}

			$feed->faviconPrepare();
			if ($pubsubhubbubEnabledGeneral && $feed->pubSubHubbubPrepare() != false) {
				Log::notice('WebSub subscribe ' . $feed->url(false));
				if (!$feed->pubSubHubbubSubscribe(true)) {	//Subscribe
					Log::warning('Error while WebSub subscribing to ' . $feed->url(false));
				}
			}
			$feed->unlock();
			$nbUpdatedFeeds++;
			unset($feed);
			gc_collect_cycles();

			if ($nbUpdatedFeeds >= $maxFeeds) {
				break;
			}
		}
		return [$nbUpdatedFeeds, $firstFeed, $nbNewArticles, $feedsCacheToRefresh];
	}

	/**
	 * Feeds on which to apply a the keep max unreads policy, or all feeds if none specified.
	 * @return int The number of articles marked as read
	 */
	private static function keepMaxUnreads(Feed ...$feeds): int {
		$affected = 0;

		if (empty($feeds)) {
			$feedDAO = Factory::createFeedDao();
			$feeds = $feedDAO->listFeedsOrderUpdate(-1);
		}

		foreach ($feeds as $feed) {
			$n = $feed->markAsReadMaxUnread();
			if ($n !== false && $n > 0) {
				Log::debug($n . ' unread entries exceeding max number of ' . $feed->keepMaxUnread() .  ' for [' . $feed->url(false) . ']');
				$affected += $n;
			}
		}

		return $affected;
	}

	/**
	 * Auto-add labels to new articles.
	 * @param int $nbNewEntries The number of top recent entries to process.
	 * @return int|false The number of new labels added, or false in case of error.
	 */
	private static function applyLabelActions(int $nbNewEntries): int|false {
		$tagDAO = Factory::createTagDao();
		$labels = Context::labels();
		$labels = array_filter($labels, static fn(Tag $label) => !empty($label->filtersAction('label')));
		if (count($labels) <= 0) {
			return 0;
		}

		$entryDAO = Factory::createEntryDao();
		$applyLabels = [];
		foreach (Entry::fromTraversable($entryDAO->selectAll(order: 'DESC', limit: $nbNewEntries)) as $entry) {
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

	public static function commitNewEntries(): int {
		$entryDAO = Factory::createEntryDao();
		$nbNewEntries = $entryDAO->countNewEntries();
		if ($nbNewEntries > 0) {
			if ($entryDAO->commitNewEntries()) {
				self::applyLabelActions($nbNewEntries);
			}
		}
		return $nbNewEntries;
	}

	/**
	 * @param SimplePieCustom|null $simplePiePush Used by WebSub (PubSubHubbub) to push updates
	 * @param string $selfUrl Used by WebSub (PubSubHubbub) to override the feed URL
	 * @return array{0:int,1:Feed|null,2:int,3:array<Feed>} Number of updated feeds, first feed or null, number of new articles,
	 * 	list of feeds for which a cache refresh is needed
	 * @throws BadUrlException
	 */
	public static function actualizeFeedsAndCommit(?int $feed_id = null, ?string $feed_url = null, ?int $maxFeeds = null,
		?SimplePieCustom $simplePiePush = null, string $selfUrl = ''): array {
		$entryDAO = Factory::createEntryDao();
		[$nbUpdatedFeeds, $feed, $nbNewArticles, $feedsCacheToRefresh] =
			FeedController::actualizeFeeds($feed_id, $feed_url, $maxFeeds, $simplePiePush, $selfUrl);
		if ($nbNewArticles > 0) {
			$entryDAO->beginTransaction();
			FeedController::commitNewEntries();
		}
		if (count($feedsCacheToRefresh) > 0) {
			$feedDAO = Factory::createFeedDao();
			self::keepMaxUnreads(...$feedsCacheToRefresh);
			$feedDAO->updateCachedValues(...array_map(fn(Feed $f) => $f->id(), $feedsCacheToRefresh));
		}
		if ($entryDAO->inTransaction()) {
			$entryDAO->commit();
		}
		if (rand(0, 30) === 1) {	// Remove old cache once in a while
			cleanCache(CLEANCACHE_HOURS);
		}
		return [$nbUpdatedFeeds, $feed, $nbNewArticles, $feedsCacheToRefresh];
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
		Session::_param('actualize_feeds', false);
		$id = Request::paramInt('id');
		$url = Request::paramString('url');
		$maxFeeds = Request::paramInt('maxFeeds') ?: 10;
		$noCommit = ($_POST['noCommit'] ?? 0) == 1;

		if ($id === -1 && !$noCommit) {	//Special request only to commit & refresh DB cache
			$nbUpdatedFeeds = 0;
			$feed = null;
			FeedController::commitNewEntries();
			$feedDAO = Factory::createFeedDao();
			$feedDAO->updateCachedValues();
		} else {
			if (!$noCommit) {
				$databaseDAO = Factory::createDatabaseDAO();
				$databaseDAO->minorDbMaintenance();
				ExtensionManager::callHookVoid(HookType::FreshrssUserMaintenance);
			}
			if ($id === 0 && $url === '') {
				// Case of a batch refresh (e.g. cron)
				FeedController::commitNewEntries();
				$feedDAO = Factory::createFeedDao();
				$feedDAO->updateCachedValues();
				CategoryController::refreshDynamicOpmls();
			}
			$entryDAO = Factory::createEntryDao();
			[$nbUpdatedFeeds, $feed, $nbNewArticles, $feedsCacheToRefresh] = self::actualizeFeeds($id, $url, $maxFeeds);
			if (!$noCommit) {
				if ($nbNewArticles > 0) {
					$entryDAO->beginTransaction();
					FeedController::commitNewEntries();
				}
				$feedDAO = Factory::createFeedDao();
				if ($id !== 0 && $id !== -1) {
					if ($feed instanceof Feed) {
						self::keepMaxUnreads($feed);
					}
					// Case of single feed refreshed, always update its cache
					$feedDAO->updateCachedValues($id);
				} elseif (count($feedsCacheToRefresh) > 0) {
					self::keepMaxUnreads(...$feedsCacheToRefresh);
					// Case of multiple feeds refreshed, only update cache of affected feeds
					$feedDAO->updateCachedValues(...array_map(fn(Feed $f) => $f->id(), $feedsCacheToRefresh));
				}
			}
			if ($entryDAO->inTransaction()) {
				$entryDAO->commit();
			}
		}

		if (Request::paramBoolean('ajax')) {
			// Most of the time, ajax request is for only one feed. But since
			// there are several parallel requests, we should return that there
			// are several updated feeds.
			Request::setGoodNotification(_t('feedback.sub.feed.actualizeds'));
			// No layout in ajax request.
			$this->view->_layout(null);
		} elseif ($feed instanceof Feed && $id > 0) {
			// Redirect to the main page with correct notification.
			Request::good(
				_t('feedback.sub.feed.actualized', $feed->name()),
				['params' => ['get' => 'f_' . $id, 'id' => $id]],
				notificationName: 'actualizeAction',
				showNotification: Context::userConf()->good_notification_timeout > 0);
		} elseif ($nbUpdatedFeeds >= 1) {
			Request::good(
				_t('feedback.sub.feed.n_actualized', $nbUpdatedFeeds),
				[],
				showNotification: Context::userConf()->good_notification_timeout > 0
			);
		} else {
			Request::good(
				_t('feedback.sub.feed.no_refresh'),
				[],
				showNotification: Context::userConf()->good_notification_timeout > 0
			);
		}
		return $nbUpdatedFeeds;
	}

	/**
	 * @throws ConfigurationNamespaceException
	 * @throws PDOConnectionException
	 */
	public static function renameFeed(int $feed_id, string $feed_name): bool {
		if ($feed_id <= 0 || $feed_name === '') {
			return false;
		}
		UserDAO::touch();
		$feedDAO = Factory::createFeedDao();
		return $feedDAO->updateFeed($feed_id, ['name' => $feed_name]);
	}

	public static function moveFeed(int $feed_id, int $cat_id, string $new_cat_name = ''): bool {
		if ($feed_id <= 0 || ($cat_id <= 0 && $new_cat_name === '')) {
			return false;
		}
		UserDAO::touch();

		$catDAO = Factory::createCategoryDao();
		if ($cat_id > 0) {
			$cat = $catDAO->searchById($cat_id);
			$cat_id = $cat === null ? 0 : $cat->id();
		}
		if ($cat_id <= 1 && $new_cat_name != '') {
			$cat_id = $catDAO->addCategory(['name' => $new_cat_name]);
		}
		if ($cat_id <= 1) {
			$catDAO->checkDefault();
			$cat_id = CategoryDAO::DEFAULTCATEGORYID;
		}

		$feedDAO = Factory::createFeedDao();
		return $feedDAO->updateFeed($feed_id, ['category' => $cat_id]);
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
		if (!Request::isPost()) {
			Request::forward(['c' => 'subscription'], true);
		}

		$feed_id = Request::paramInt('f_id');
		$cat_id = Request::paramInt('c_id');

		if (self::moveFeed($feed_id, $cat_id)) {
			// TODO: return something useful
			// Log a notice to prevent "Empty IF statement" warning in PHP_CodeSniffer
			Log::notice('Moved feed `' . $feed_id . '` in the category `' . $cat_id . '`');
		} else {
			Log::warning('Cannot move feed `' . $feed_id . '` in the category `' . $cat_id . '`');
			Error::error(404);
		}
	}

	public static function deleteFeed(int $feed_id): bool {
		UserDAO::touch();
		$feedDAO = Factory::createFeedDao();
		$feed = $feedDAO->searchById($feed_id);
		if ($feed === null) {
			return false;
		}

		if ($feedDAO->deleteFeed($feed_id)) {
			// TODO: Delete old favicon (non-custom)
			if ($feed->customFavicon() && !$feed->attributeBoolean('customFaviconDisallowDel')) {
				Feed::faviconDelete($feed->hashFavicon());
			}

			// Remove related queries
			$queries = UserQuery::remove_query_by_get('f_' . $feed_id, Context::userConf()->queries);
			Context::userConf()->queries = $queries;
			Context::userConf()->save();
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
		if (!Request::isPost()) {
			Request::forward(['c' => 'subscription'], true);
		}
		$from = Request::paramString('from');
		$id = Request::paramInt('id');

		switch ($from) {
			case 'stats':
				$redirect_url = ['c' => 'stats', 'a' => 'idle'];
				break;
			case 'normal':
				$get = Request::paramString('get');
				if ($get !== '') {
					$redirect_url = ['c' => 'index', 'a' => 'normal', 'params' => ['get' => $get]];
				} else {
					$redirect_url = ['c' => 'index', 'a' => 'normal'];
				}
				break;
			default:
				$redirect_url = ['c' => 'subscription', 'a' => 'index'];
				if (!Request::isPost()) {
					Request::forward($redirect_url, true);
				}
		}

		if (self::deleteFeed($id)) {
			Request::good(
				_t('feedback.sub.feed.deleted'),
				$redirect_url,
				showNotification: Context::userConf()->good_notification_timeout > 0
			);
		} else {
			Request::bad(_t('feedback.sub.feed.error'), $redirect_url);
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
		if (!Request::isPost()) {
			Request::forward(['c' => 'subscription'], true);
		}
		//Get Feed.
		$id = Request::paramInt('id');

		$feedDAO = Factory::createFeedDao();
		$feed = $feedDAO->searchById($id);
		if ($feed === null) {
			Request::bad(_t('feedback.sub.feed.not_found'), []);
			return;
		}

		$feed->clearCache();

		Request::good(
			_t('feedback.sub.feed.cache_cleared', $feed->name()),
			['params' => ['get' => 'f_' . $feed->id(), 'id' => $feed->id()]],
			showNotification: Context::userConf()->good_notification_timeout > 0
		);
	}

	/**
	 * This action forces reloading the articles of a feed.
	 *
	 * Parameters are:
	 *   - id (mandatory - no default): Feed ID
	 *
	 * @throws BadUrlException
	 */
	public function reloadAction(): void {
		if (!Request::isPost()) {
			Request::forward(['c' => 'subscription'], true);
		}
		if (function_exists('set_time_limit')) {
			@set_time_limit(300);
		}

		//Get Feed ID.
		$feed_id = Request::paramInt('id');
		$limit = Request::paramInt('reload_limit') ?: 10;

		$feedDAO = Factory::createFeedDao();
		$feed = $feedDAO->searchById($feed_id);
		if ($feed === null) {
			Request::bad(_t('feedback.sub.feed.not_found'), []);
			return;
		}

		//Re-fetch articles as if the feed was new.
		$feedDAO->updateFeed($feed->id(), [ 'lastUpdate' => 0 ]);
		self::actualizeFeedsAndCommit($feed_id);

		//Extract all feed entries from database, load complete content and store them back in database.
		$entryDAO = Factory::createEntryDao();
		$entries = $entryDAO->listWhere('f', $feed_id, Entry::STATE_ALL, order: 'DESC', limit: $limit);

		//We need another DB connection in parallel for unbuffered streaming
		ModelPdo::$usesSharedPdo = false;
		if (Context::systemConf()->db['type'] === 'mysql') {
			// Second parallel connection for unbuffered streaming: MySQL
			$entryDAO2 = Factory::createEntryDao();
		} else {
			// Single connection for buffered queries (in memory): SQLite, PostgreSQL
			//TODO: Consider an unbuffered query for PostgreSQL
			$entryDAO2 = $entryDAO;
		}

		foreach ($entries as $entry) {
			$oldContent = $entry->content(withEnclosures: false);
			if ($entry->loadCompleteContent(true)) {
				$entry->_lastModified(time());
				if ($entry->content(withEnclosures: false) !== $oldContent) {
					$entryDAO2->updateEntry($entry->toArray());
				}
			}
		}

		ModelPdo::$usesSharedPdo = true;

		//Give feedback to user.
		Request::good(
			_t('feedback.sub.feed.reloaded', $feed->name()),
			['params' => ['get' => 'f_' . $feed->id(), 'id' => $feed->id()]],
			showNotification: Context::userConf()->good_notification_timeout > 0
		);
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
			'frame-ancestors' => "'self'",
			'frame-src' => '*',
			'img-src' => '* data:',
			'media-src' => '*',
		]);

		//Get parameters.
		$feed_id = Request::paramInt('id');
		$content_selector = Request::paramString('selector');

		if ($content_selector === '') {
			$this->view->fatalError = _t('feedback.sub.feed.selector_preview.selector_empty');
			return;
		}

		//Check Feed ID validity.
		$entryDAO = Factory::createEntryDao();
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
		$feed->_pathEntries($content_selector);
		$feed->_attribute('path_entries_filter', Request::paramString('selector_filter', true));

		//Fetch & select content.
		try {
			$fullContent = $entry->getContentByParsing();

			if ($fullContent != '') {
				$this->view->selectorSuccess = true;
				$this->view->htmlContent = $fullContent;
			} else {
				$this->view->selectorSuccess = false;
				$this->view->htmlContent = $entry->content(false);
			}
		} catch (\Exception) {
			$this->view->fatalError = _t('feedback.sub.feed.selector_preview.http_error');
		}
	}
}
