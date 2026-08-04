<?php
declare(strict_types=1);

namespace FreshRss\Controllers;

use FreshRss\Exceptions\FeedException;
use FreshRss\Exceptions\UnsupportedImageFormatException;
use FreshRss\Minz\Error;
use FreshRss\Minz\Log;
use FreshRss\Minz\Request;
use FreshRss\Minz\Url;
use FreshRss\Models\ActionController;
use FreshRss\Models\Auth;
use FreshRss\Models\BooleanSearch;
use FreshRss\Models\Context;
use FreshRss\Models\Factory;
use FreshRss\Models\Feed;
use FreshRss\Models\Search;
use FreshRss\Models\SimplePieCustom;
use FreshRss\Models\View;
use FreshRss\Utils\HttpUtil;

/**
 * Controller to handle subscription actions.
 */
class SubscriptionController extends ActionController {
	/**
	 * This action is called before every other action in that class. It is
	 * the common boilerplate for every action. It is triggered by the
	 * underlying framework.
	 */
	#[\Override]
	public function firstAction(): void {
		if (!Auth::hasAccess()) {
			Error::error(403);
		}

		$catDAO = Factory::createCategoryDao();
		$catDAO->checkDefault();
		$this->view->categories = $catDAO->listSortedCategories(prePopulateFeeds: false, details: true);

		$signalError = false;
		foreach ($this->view->categories as $cat) {
			$feeds = $cat->feeds();
			foreach ($feeds as $feed) {
				if ($feed->inError()) {
					$signalError = true;
				}
			}
			if ($signalError) {
				break;
			}
		}

		$this->view->signalError = $signalError;
	}

	/**
	 * This action handles the main subscription page
	 *
	 * It displays categories and associated feeds.
	 */
	public function indexAction(): void {
		View::appendScript(Url::display('/scripts/category.js?' . @filemtime(PUBLIC_PATH . '/scripts/category.js')));
		View::appendScript(Url::display('/scripts/feed.js?' . @filemtime(PUBLIC_PATH . '/scripts/feed.js')));
		View::prependTitle(_t('sub.title') . ' · ');

		$this->_csp([
			'default-src' => "'self'",
			'frame-ancestors' => Context::systemConf()->attributeString('csp.frame-ancestors') ?? "'none'",
			'img-src' => "'self' data: blob:",
		]);

		$this->view->onlyFeedsWithError = Request::paramBoolean('error');

		$id = Request::paramInt('id');
		$this->view->displaySlider = false;
		if ($id !== 0) {
			$type = Request::paramString('type');
			$this->view->displaySlider = true;
			switch ($type) {
				case 'category':
					$categoryDAO = Factory::createCategoryDao();
					$this->view->category = $categoryDAO->searchById($id);
					break;
				default:
					$feedDAO = Factory::createFeedDao();
					$this->view->feed = $feedDAO->searchById($id) ?? Feed::default();
					break;
			}
		}
	}

	/**
	 * This action handles the feed configuration page.
	 *
	 * It displays the feed configuration page.
	 * If this action is reached through a POST request, it stores all new
	 * configuration values then sends a notification to the user.
	 *
	 * The options available on the page are:
	 *   - name
	 *   - description
	 *   - website URL
	 *   - feed URL
	 *   - category id (default: default category id)
	 *   - CSS path to article on website
	 *   - favicon
	 *   - display in main stream (default: 0)
	 *   - HTTP authentication
	 *   - number of article to retain (default: -2)
	 *   - refresh frequency (default: 0)
	 * Default values are empty strings unless specified.
	 */
	public function feedAction(): void {
		if (Request::paramBoolean('ajax')) {
			$this->view->_layout(null);
		} else {
			View::appendScript(Url::display('/scripts/feed.js?' . @filemtime(PUBLIC_PATH . '/scripts/feed.js')));
		}

		$id = Request::paramInt('id');
		if ($id === 0) {
			Error::error(400);
			return;
		}

		$feedDAO = Factory::createFeedDao();
		$feed = $feedDAO->searchById($id);
		if ($feed === null) {
			Error::error(404);
			return;
		}
		$this->view->feed = $feed;

		View::prependTitle($feed->name() . ' · ' . _t('sub.title.feed_management') . ' · ');

		$this->_csp([
			'default-src' => "'self'",
			'frame-ancestors' => Context::systemConf()->attributeString('csp.frame-ancestors') ?? "'none'",
			'img-src' => "'self' data: blob:",
		]);

		if (Request::isPost()) {
			$unicityCriteria = Request::paramString('unicityCriteria');
			if (in_array($unicityCriteria, ['id', '', null], strict: true)) {
				$unicityCriteria = null;
			}
			if ($unicityCriteria === null && $feed->attributeBoolean('hasBadGuids')) {	// Legacy
				$unicityCriteria = 'link';
			}
			$feed->_attribute('hasBadGuids', null);	// Remove legacy
			$feed->_attribute('unicityCriteria', $unicityCriteria);

			$feed->_attribute('unicityCriteriaForced', Request::paramBoolean('unicityCriteriaForced') ? true : null);

			$user = Request::paramString('http_user_feed' . $id);
			$pass = Request::paramString('http_pass_feed' . $id);

			$httpAuth = '';
			if ($user !== '' && $pass !== '') {	//TODO: Sanitize
				$httpAuth = $user . ':' . $pass;
			}

			$feed->_ttl(Request::paramInt('ttl') ?: Feed::TTL_DEFAULT);
			$feed->_mute(Request::paramBoolean('mute'));

			$feed->_attribute('read_upon_gone', Request::paramTernary('read_upon_gone'));
			$feed->_attribute('mark_updated_article_unread', Request::paramTernary('mark_updated_article_unread'));
			$feed->_attribute('read_upon_reception', Request::paramTernary('read_upon_reception'));
			$feed->_attribute('clear_cache', Request::paramTernary('clear_cache'));
			if (Request::hasParam('show_unread_count')) {
				$feed->_attribute('show_unread_count', Request::paramTernary('show_unread_count'));
			}
			$feed->_attribute('display_enclosures', Request::paramTernary('display_enclosures'));

			$keep_max_n_unread = Request::paramTernary('keep_max_n_unread') === true ? Request::paramInt('keep_max_n_unread') : null;
			$feed->_attribute('keep_max_n_unread', $keep_max_n_unread >= 0 ? $keep_max_n_unread : null);

			$read_when_same_title_in_feed = Request::paramString('read_when_same_title_in_feed');
			if ($read_when_same_title_in_feed === '') {
				$read_when_same_title_in_feed = null;
			} else {
				$read_when_same_title_in_feed = (int)$read_when_same_title_in_feed;
				if ($read_when_same_title_in_feed <= 0) {
					$read_when_same_title_in_feed = false;
				}
			}
			$feed->_attribute('read_when_same_title_in_feed', $read_when_same_title_in_feed);

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
			if ($max_redirs != 0) {
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

			$feed->_attribute('curl_params', empty($opts) ? null : HttpUtil::sanitizeCurlParams($opts));

			$feed->_attribute('content_action', Request::paramString('content_action', true) ?: 'replace');

			$feed->_attribute('ssl_verify', Request::paramTernary('ssl_verify'));
			$timeout = Request::paramInt('timeout');
			$feed->_attribute('timeout', $timeout > 0 ? $timeout : null);

			if (Request::paramBoolean('use_default_purge_options')) {
				$feed->_attribute('archiving', null);
			} else {
				if (Request::paramBoolean('enable_keep_max')) {
					$keepMax = Request::paramInt('keep_max') ?: Feed::ARCHIVING_RETENTION_COUNT_LIMIT;
				} else {
					$keepMax = false;
				}
				if (Request::paramBoolean('enable_keep_period')) {
					$keepPeriod = Feed::ARCHIVING_RETENTION_PERIOD;
					if (is_numeric(Request::paramString('keep_period_count')) && preg_match('/^PT?1[YMWDH]$/', Request::paramString('keep_period_unit'))) {
						$keepPeriod = str_replace('1', Request::paramString('keep_period_count'), Request::paramString('keep_period_unit'));
					}
				} else {
					$keepPeriod = false;
				}
				$feed->_attribute('archiving', [
					'keep_period' => $keepPeriod,
					'keep_max' => $keepMax,
					'keep_min' => Request::paramInt('keep_min'),
					'keep_favourites' => Request::paramBoolean('keep_favourites'),
					'keep_labels' => Request::paramBoolean('keep_labels'),
					'keep_unreads' => Request::paramBoolean('keep_unreads'),
				]);
			}

			$feed->_filtersAction('read', Request::paramTextToArray('filteractions_read', plaintext: true));

			$feed->_kind(Request::paramInt('feed_kind') ?: Feed::KIND_RSS);
			if ($feed->kind() === Feed::KIND_HTML_XPATH || $feed->kind() === Feed::KIND_XML_XPATH) {
				$xPathSettings = [];
				if (Request::paramString('xPathItem') != '')
					$xPathSettings['item'] = Request::paramString('xPathItem', true);
				if (Request::paramString('xPathItemTitle') != '')
					$xPathSettings['itemTitle'] = Request::paramString('xPathItemTitle', true);
				if (Request::paramString('xPathItemContent') != '')
					$xPathSettings['itemContent'] = Request::paramString('xPathItemContent', true);
				if (Request::paramString('xPathItemUri') != '')
					$xPathSettings['itemUri'] = Request::paramString('xPathItemUri', true);
				if (Request::paramString('xPathItemAuthor') != '')
					$xPathSettings['itemAuthor'] = Request::paramString('xPathItemAuthor', true);
				if (Request::paramString('xPathItemTimestamp') != '')
					$xPathSettings['itemTimestamp'] = Request::paramString('xPathItemTimestamp', true);
				if (Request::paramString('xPathItemTimeFormat') != '')
					$xPathSettings['itemTimeFormat'] = Request::paramString('xPathItemTimeFormat', true);
				if (Request::paramString('xPathItemThumbnail') != '')
					$xPathSettings['itemThumbnail'] = Request::paramString('xPathItemThumbnail', true);
				if (Request::paramString('xPathItemCategories') != '')
					$xPathSettings['itemCategories'] = Request::paramString('xPathItemCategories', true);
				if (Request::paramString('xPathItemUid') != '')
					$xPathSettings['itemUid'] = Request::paramString('xPathItemUid', true);
				if (!empty($xPathSettings))
					$feed->_attribute('xpath', $xPathSettings);
			} elseif ($feed->kind() === Feed::KIND_JSON_DOTNOTATION || $feed->kind() === Feed::KIND_HTML_XPATH_JSON_DOTNOTATION) {
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
					$feed->_attribute('json_dotnotation', $jsonSettings);
				}
				if (Request::paramString('xPathToJson', plaintext: true) !== '') {
					$feed->_attribute('xPathToJson', Request::paramString('xPathToJson', plaintext: true));
				}
			}

			$conditions = Request::paramTextToArray('path_entries_conditions', plaintext: true);
			$conditions = array_filter($conditions, fn(string $condition): bool => trim($condition) !== '');
			$feed->_attribute('path_entries_conditions', empty($conditions) ? null : $conditions);
			$feed->_attribute('path_entries_filter', Request::paramString('path_entries_filter', true));

			// @phpstan-ignore offsetAccess.nonOffsetAccessible
			$favicon_path = isset($_FILES['newFavicon']) ? $_FILES['newFavicon']['tmp_name'] : '';
			// @phpstan-ignore offsetAccess.nonOffsetAccessible
			$favicon_size = isset($_FILES['newFavicon']) ? $_FILES['newFavicon']['size'] : 0;

			$favicon_uploaded = $favicon_path !== '';

			$resetFavicon = Request::paramBoolean('resetFavicon');
			if ($resetFavicon) {
				$feed->resetCustomFavicon();
			}

			$defaultSortOrder = Request::paramString('defaultSortOrder', plaintext: true);
			if (str_ends_with($defaultSortOrder, '_asc')) {
				$feed->_attribute('defaultOrder', 'ASC');
				$defaultSortOrder = substr($defaultSortOrder, 0, -strlen('_asc'));
			} elseif (str_ends_with($defaultSortOrder, '_desc')) {
				$feed->_attribute('defaultOrder', 'DESC');
				$defaultSortOrder = substr($defaultSortOrder, 0, -strlen('_desc'));
			} else {
				$feed->_attribute('defaultOrder');
			}
			if (in_array($defaultSortOrder, ['id', 'date', 'link', 'title', 'length', 'rand'], true)) {
				$feed->_attribute('defaultSort', $defaultSortOrder);
			} else {
				$feed->_attribute('defaultSort');
			}

			$values = [
				'name' => Request::paramString('name'),
				'kind' => $feed->kind(),
				'description' => SimplePieCustom::sanitizeHTML(Request::paramString('description', true)),
				'website' => HttpUtil::checkUrl(Request::paramString('website')) ?: '',
				'url' => HttpUtil::checkUrl(Request::paramString('url')) ?: '',
				'category' => Request::paramInt('category'),
				'pathEntries' => Request::paramString('path_entries'),
				'priority' => Request::paramTernary('priority') === null ? Feed::PRIORITY_MAIN_STREAM : Request::paramInt('priority'),
				'httpAuth' => $httpAuth,
				'ttl' => $feed->ttl(true),
				'attributes' => $feed->attributes(),
			];

			invalidateHttpCache();

			$from = Request::paramString('from');
			switch ($from) {
				case 'stats':
					$url_redirect = ['c' => 'stats', 'a' => 'idle', 'params' => ['id' => $id, 'from' => 'stats']];
					break;
				case 'normal':
				case 'reader':
					$get = Request::paramString('get');
					if ($get !== '') {
						$url_redirect = ['c' => 'index', 'a' => $from, 'params' => ['id' => $id, 'get' => $get]];
					} else {
						$url_redirect = ['c' => 'index', 'a' => $from, 'params' => ['id' => $id]];
					}
					break;
				case 'index':
					$url_redirect = ['c' => 'subscription', 'params' => ['id' => $id, 'error' => Request::paramBoolean('error') ? 1 : 0]];
					break;
				default:
					$url_redirect = ['c' => 'subscription', 'a' => 'feed', 'params' => ['id' => $id]];
			}

			if ($favicon_uploaded && !$resetFavicon) {
				$max_size = Context::systemConf()->limits['max_favicon_upload_size'];
				if ($favicon_size > $max_size) {
					Request::bad(_t('feedback.sub.feed.favicon.too_large', format_bytes($max_size)), $url_redirect);
					return;
				}
				try {
					$feed->setCustomFavicon(tmpPath: is_string($favicon_path) ? $favicon_path : '', values: $values);
				} catch (UnsupportedImageFormatException $_) {
					Request::bad(_t('feedback.sub.feed.favicon.unsupported_format'), $url_redirect);
					return;
				} catch (FeedException $_) {
					Request::bad(_t('feedback.sub.feed.error'), $url_redirect);
					return;
				}
				Request::good(
					_t('feedback.sub.feed.updated'),
					$url_redirect,
					showNotification: Context::userConf()->good_notification_timeout > 0
				);
			} elseif ($values['url'] != '' && $feedDAO->updateFeed($id, $values) !== false) {
				$feed->_categoryId($values['category']);
				// update url and website values for faviconPrepare
				$feed->_url($values['url'], false);
				$feed->_website($values['website'], false);
				$feed->faviconPrepare();

				Request::good(
					_t('feedback.sub.feed.updated'),
					$url_redirect,
					showNotification: Context::userConf()->good_notification_timeout > 0
				);
			} else {
				if ($values['url'] == '') {
					Log::warning('Invalid feed URL!');
				}
				Request::bad(_t('feedback.sub.feed.error'), $url_redirect);
			}
		}
	}

	public function viewFilterAction(): void {
		$id = Request::paramInt('id');
		if ($id === 0) {
			Error::error(400);
			return;
		}
		$filteractions = Request::paramTextToArray('filteractions_read', plaintext: true);
		$filteractions = array_map(fn(string $action): string => trim($action), $filteractions);
		$filteractions = array_filter($filteractions, fn(string $action): bool => $action !== '');
		$actionsSearch = new BooleanSearch('', operator: 'AND');
		foreach ($filteractions as $action) {
			$actionSearch = new BooleanSearch($action, operator: 'OR');
			if ($actionSearch->toString() === '') {
				continue;
			}
			$actionsSearch->add($actionSearch);
		}
		$search = new BooleanSearch('');
		$search->add(new Search("f:$id"));
		$search->add($actionsSearch);
		Request::forward([
			'c' => 'index',
			'a' => 'index',
			'params' => [
				'search' => $search->toString(),
			],
		], redirect: true);
	}

	/**
	 * This action displays the bookmarklet page.
	 */
	public function bookmarkletAction(): void {
		View::prependTitle(_t('sub.title.subscription_tools') . ' . ');
	}

	/**
	 * This action displays the page to add a new feed
	 */
	public function addAction(): void {
		View::appendScript(Url::display('/scripts/feed.js?' . @filemtime(PUBLIC_PATH . '/scripts/feed.js')));
		View::prependTitle(_t('sub.title.add') . ' . ');
	}
}
