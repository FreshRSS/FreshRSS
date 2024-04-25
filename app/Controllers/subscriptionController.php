<?php
declare(strict_types=1);

/**
 * Controller to handle subscription actions.
 */
class FreshRSS_subscription_Controller extends FreshRSS_ActionController {
	/**
	 * This action is called before every other action in that class. It is
	 * the common boilerplate for every action. It is triggered by the
	 * underlying framework.
	 */
	#[\Override]
	public function firstAction(): void {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}

		$catDAO = FreshRSS_Factory::createCategoryDao();
		$catDAO->checkDefault();
		$this->view->categories = $catDAO->listSortedCategories(false, true) ?: [];

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
		FreshRSS_View::appendScript(Minz_Url::display('/scripts/category.js?' . @filemtime(PUBLIC_PATH . '/scripts/category.js')));
		FreshRSS_View::appendScript(Minz_Url::display('/scripts/feed.js?' . @filemtime(PUBLIC_PATH . '/scripts/feed.js')));
		FreshRSS_View::prependTitle(_t('sub.title') . ' · ');

		$this->view->onlyFeedsWithError = Minz_Request::paramBoolean('error');

		$id = Minz_Request::paramInt('id');
		$this->view->displaySlider = false;
		if ($id !== 0) {
			$type = Minz_Request::paramString('type');
			$this->view->displaySlider = true;
			switch ($type) {
				case 'category':
					$categoryDAO = FreshRSS_Factory::createCategoryDao();
					$this->view->category = $categoryDAO->searchById($id);
					break;
				default:
					$feedDAO = FreshRSS_Factory::createFeedDao();
					$this->view->feed = $feedDAO->searchById($id) ?? FreshRSS_Feed::default();
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
	 *   - display in main stream (default: 0)
	 *   - HTTP authentication
	 *   - number of article to retain (default: -2)
	 *   - refresh frequency (default: 0)
	 * Default values are empty strings unless specified.
	 */
	public function feedAction(): void {
		if (Minz_Request::paramBoolean('ajax')) {
			$this->view->_layout(null);
		} else {
			FreshRSS_View::appendScript(Minz_Url::display('/scripts/feed.js?' . @filemtime(PUBLIC_PATH . '/scripts/feed.js')));
		}

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$this->view->feeds = $feedDAO->listFeeds();

		$id = Minz_Request::paramInt('id');
		if ($id === 0 || !isset($this->view->feeds[$id])) {
			Minz_Error::error(404);
			return;
		}

		$feed = $this->view->feeds[$id];
		$this->view->feed = $feed;

		FreshRSS_View::prependTitle($feed->name() . ' · ' . _t('sub.title.feed_management') . ' · ');

		if (Minz_Request::isPost()) {
			$user = Minz_Request::paramString('http_user_feed' . $id);
			$pass = Minz_Request::paramString('http_pass_feed' . $id);

			$httpAuth = '';
			if ($user !== '' && $pass !== '') {	//TODO: Sanitize
				$httpAuth = $user . ':' . $pass;
			}

			$feed->_ttl(Minz_Request::paramInt('ttl') ?: FreshRSS_Feed::TTL_DEFAULT);
			$feed->_mute(Minz_Request::paramBoolean('mute'));

			$feed->_attribute('read_upon_gone', Minz_Request::paramTernary('read_upon_gone'));
			$feed->_attribute('mark_updated_article_unread', Minz_Request::paramTernary('mark_updated_article_unread'));
			$feed->_attribute('read_upon_reception', Minz_Request::paramTernary('read_upon_reception'));
			$feed->_attribute('clear_cache', Minz_Request::paramTernary('clear_cache'));

			$keep_max_n_unread = Minz_Request::paramTernary('keep_max_n_unread') === true ? Minz_Request::paramInt('keep_max_n_unread') : null;
			$feed->_attribute('keep_max_n_unread', $keep_max_n_unread >= 0 ? $keep_max_n_unread : null);

			$read_when_same_title_in_feed = Minz_Request::paramString('read_when_same_title_in_feed');
			if ($read_when_same_title_in_feed === '') {
				$read_when_same_title_in_feed = null;
			} else {
				$read_when_same_title_in_feed = (int)$read_when_same_title_in_feed;
				if ($read_when_same_title_in_feed <= 0) {
					$read_when_same_title_in_feed = false;
				}
			}
			$feed->_attribute('read_when_same_title_in_feed', $read_when_same_title_in_feed);

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
			if ($max_redirs != 0) {
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

			$feed->_attribute('curl_params', empty($opts) ? null : $opts);

			$feed->_attribute('content_action', Minz_Request::paramString('content_action', true) ?: 'replace');

			$feed->_attribute('ssl_verify', Minz_Request::paramTernary('ssl_verify'));
			$timeout = Minz_Request::paramInt('timeout');
			$feed->_attribute('timeout', $timeout > 0 ? $timeout : null);

			if (Minz_Request::paramBoolean('use_default_purge_options')) {
				$feed->_attribute('archiving', null);
			} else {
				if (Minz_Request::paramBoolean('enable_keep_max')) {
					$keepMax = Minz_Request::paramInt('keep_max') ?: FreshRSS_Feed::ARCHIVING_RETENTION_COUNT_LIMIT;
				} else {
					$keepMax = false;
				}
				if (Minz_Request::paramBoolean('enable_keep_period')) {
					$keepPeriod = FreshRSS_Feed::ARCHIVING_RETENTION_PERIOD;
					if (is_numeric(Minz_Request::paramString('keep_period_count')) && preg_match('/^PT?1[YMWDH]$/', Minz_Request::paramString('keep_period_unit'))) {
						$keepPeriod = str_replace('1', Minz_Request::paramString('keep_period_count'), Minz_Request::paramString('keep_period_unit'));
					}
				} else {
					$keepPeriod = false;
				}
				$feed->_attribute('archiving', [
					'keep_period' => $keepPeriod,
					'keep_max' => $keepMax,
					'keep_min' => Minz_Request::paramInt('keep_min'),
					'keep_favourites' => Minz_Request::paramBoolean('keep_favourites'),
					'keep_labels' => Minz_Request::paramBoolean('keep_labels'),
					'keep_unreads' => Minz_Request::paramBoolean('keep_unreads'),
				]);
			}

			$feed->_filtersAction('read', Minz_Request::paramTextToArray('filteractions_read'));

			$feed->_kind(Minz_Request::paramInt('feed_kind') ?: FreshRSS_Feed::KIND_RSS);
			if ($feed->kind() === FreshRSS_Feed::KIND_HTML_XPATH || $feed->kind() === FreshRSS_Feed::KIND_XML_XPATH) {
				$xPathSettings = [];
				if (Minz_Request::paramString('xPathItem') != '')
					$xPathSettings['item'] = Minz_Request::paramString('xPathItem', true);
				if (Minz_Request::paramString('xPathItemTitle') != '')
					$xPathSettings['itemTitle'] = Minz_Request::paramString('xPathItemTitle', true);
				if (Minz_Request::paramString('xPathItemContent') != '')
					$xPathSettings['itemContent'] = Minz_Request::paramString('xPathItemContent', true);
				if (Minz_Request::paramString('xPathItemUri') != '')
					$xPathSettings['itemUri'] = Minz_Request::paramString('xPathItemUri', true);
				if (Minz_Request::paramString('xPathItemAuthor') != '')
					$xPathSettings['itemAuthor'] = Minz_Request::paramString('xPathItemAuthor', true);
				if (Minz_Request::paramString('xPathItemTimestamp') != '')
					$xPathSettings['itemTimestamp'] = Minz_Request::paramString('xPathItemTimestamp', true);
				if (Minz_Request::paramString('xPathItemTimeFormat') != '')
					$xPathSettings['itemTimeFormat'] = Minz_Request::paramString('xPathItemTimeFormat', true);
				if (Minz_Request::paramString('xPathItemThumbnail') != '')
					$xPathSettings['itemThumbnail'] = Minz_Request::paramString('xPathItemThumbnail', true);
				if (Minz_Request::paramString('xPathItemCategories') != '')
					$xPathSettings['itemCategories'] = Minz_Request::paramString('xPathItemCategories', true);
				if (Minz_Request::paramString('xPathItemUid') != '')
					$xPathSettings['itemUid'] = Minz_Request::paramString('xPathItemUid', true);
				if (!empty($xPathSettings))
					$feed->_attribute('xpath', $xPathSettings);
			} elseif ($feed->kind() === FreshRSS_Feed::KIND_JSON_DOTNOTATION) {
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
					$feed->_attribute('json_dotnotation', $jsonSettings);
				}
			}

			$feed->_attribute('path_entries_filter', Minz_Request::paramString('path_entries_filter', true));

			$values = [
				'name' => Minz_Request::paramString('name'),
				'kind' => $feed->kind(),
				'description' => sanitizeHTML(Minz_Request::paramString('description', true)),
				'website' => checkUrl(Minz_Request::paramString('website')) ?: '',
				'url' => checkUrl(Minz_Request::paramString('url')) ?: '',
				'category' => Minz_Request::paramInt('category'),
				'pathEntries' => Minz_Request::paramString('path_entries'),
				'priority' => Minz_Request::paramTernary('priority') === null ? FreshRSS_Feed::PRIORITY_MAIN_STREAM : Minz_Request::paramInt('priority'),
				'httpAuth' => $httpAuth,
				'ttl' => $feed->ttl(true),
				'attributes' => $feed->attributes(),
			];

			invalidateHttpCache();

			$from = Minz_Request::paramString('from');
			switch ($from) {
				case 'stats':
					$url_redirect = ['c' => 'stats', 'a' => 'idle', 'params' => ['id' => $id, 'from' => 'stats']];
					break;
				case 'normal':
				case 'reader':
					$get = Minz_Request::paramString('get');
					if ($get) {
						$url_redirect = ['c' => 'index', 'a' => $from, 'params' => ['get' => $get]];
					} else {
						$url_redirect = ['c' => 'index', 'a' => $from];
					}
					break;
				default:
					$url_redirect = ['c' => 'subscription', 'params' => ['id' => $id]];
			}

			if ($values['url'] != '' && $feedDAO->updateFeed($id, $values) !== false) {
				$feed->_categoryId($values['category']);
				// update url and website values for faviconPrepare
				$feed->_url($values['url'], false);
				$feed->_website($values['website'], false);
				$feed->faviconPrepare();

				Minz_Request::good(_t('feedback.sub.feed.updated'), $url_redirect);
			} else {
				if ($values['url'] == '') {
					Minz_Log::warning('Invalid feed URL!');
				}
				Minz_Request::bad(_t('feedback.sub.feed.error'), $url_redirect);
			}
		}
	}

	/**
	 * This action displays the bookmarklet page.
	 */
	public function bookmarkletAction(): void {
		FreshRSS_View::prependTitle(_t('sub.title.subscription_tools') . ' . ');
	}

	/**
	 * This action displays the page to add a new feed
	 */
	public function addAction(): void {
		FreshRSS_View::appendScript(Minz_Url::display('/scripts/feed.js?' . @filemtime(PUBLIC_PATH . '/scripts/feed.js')));
		FreshRSS_View::prependTitle(_t('sub.title.add') . ' . ');
	}
}
