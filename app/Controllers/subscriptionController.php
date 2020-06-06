<?php

/**
 * Controller to handle subscription actions.
 */
class FreshRSS_subscription_Controller extends Minz_ActionController {
	/**
	 * This action is called before every other action in that class. It is
	 * the common boiler plate for every action. It is triggered by the
	 * underlying framework.
	 */
	public function firstAction() {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}

		$catDAO = FreshRSS_Factory::createCategoryDao();
		$feedDAO = FreshRSS_Factory::createFeedDao();

		$catDAO->checkDefault();
		$feedDAO->updateTTL();
		$this->view->categories = $catDAO->listSortedCategories(false);
		$this->view->default_category = $catDAO->getDefault();
	}

	/**
	 * This action handles the main subscription page
	 *
	 * It displays categories and associated feeds.
	 */
	public function indexAction() {
		Minz_View::appendScript(Minz_Url::display('/scripts/category.js?' . @filemtime(PUBLIC_PATH . '/scripts/category.js')));
		Minz_View::prependTitle(_t('sub.title') . ' · ');

		$this->view->onlyFeedsWithError = Minz_Request::paramTernary('error');

		$id = Minz_Request::param('id');
		$this->view->displaySlider = false;
		if (false !== $id) {
			$type = Minz_Request::param('type');
			$this->view->displaySlider = true;
			switch ($type) {
				case 'category':
					$categoryDAO = FreshRSS_Factory::createCategoryDao();
					$this->view->category = $categoryDAO->searchById($id);
					break;
				default:
					$feedDAO = FreshRSS_Factory::createFeedDao();
					$this->view->feed = $feedDAO->searchById($id);
					break;
			}
		}
	}

	/**
	 * This action handles the feed configuration page.
	 *
	 * It displays the feed configuration page.
	 * If this action is reached through a POST request, it stores all new
	 * configuraiton values then sends a notification to the user.
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
	public function feedAction() {
		if (Minz_Request::param('ajax')) {
			$this->view->_layout(false);
		}

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$this->view->feeds = $feedDAO->listFeeds();

		$id = Minz_Request::param('id');
		if ($id === false || !isset($this->view->feeds[$id])) {
			Minz_Error::error(404);
			return;
		}

		$feed = $this->view->feeds[$id];
		$this->view->feed = $feed;

		Minz_View::prependTitle(_t('sub.title.feed_management') . ' · ' . $feed->name() . ' · ');

		if (Minz_Request::isPost()) {
			$user = trim(Minz_Request::param('http_user_feed' . $id, ''));
			$pass = Minz_Request::param('http_pass_feed' . $id, '');

			$httpAuth = '';
			if ($user != '' && $pass != '') {	//TODO: Sanitize
				$httpAuth = $user . ':' . $pass;
			}

			$cat = intval(Minz_Request::param('category', 0));

			$mute = Minz_Request::param('mute', false);
			$ttl = intval(Minz_Request::param('ttl', FreshRSS_Feed::TTL_DEFAULT));
			if ($mute && FreshRSS_Feed::TTL_DEFAULT === $ttl) {
				$ttl = FreshRSS_Context::$user_conf->ttl_default;
			}

			$feed->_attributes('mark_updated_article_unread', Minz_Request::paramTernary('mark_updated_article_unread'));
			$feed->_attributes('read_upon_reception', Minz_Request::paramTernary('read_upon_reception'));
			$feed->_attributes('clear_cache', Minz_Request::paramTernary('clear_cache'));

			if (FreshRSS_Auth::hasAccess('admin')) {
				$feed->_attributes('ssl_verify', Minz_Request::paramTernary('ssl_verify'));
				$timeout = intval(Minz_Request::param('timeout', 0));
				$feed->_attributes('timeout', $timeout > 0 ? $timeout : null);
			} else {
				$feed->_attributes('ssl_verify', null);
				$feed->_attributes('timeout', null);
			}

			if (Minz_Request::paramBoolean('use_default_purge_options')) {
				$feed->_attributes('archiving', null);
			} else {
				if (!Minz_Request::paramBoolean('enable_keep_max')) {
					$keepMax = false;
				} elseif (!$keepMax = Minz_Request::param('keep_max')) {
					$keepMax = FreshRSS_Feed::ARCHIVING_RETENTION_COUNT_LIMIT;
				}
				if ($enableRetentionPeriod = Minz_Request::paramBoolean('enable_keep_period')) {
					$keepPeriod = FreshRSS_Feed::ARCHIVING_RETENTION_PERIOD;
					if (is_numeric(Minz_Request::param('keep_period_count')) && preg_match('/^PT?1[YMWDH]$/', Minz_Request::param('keep_period_unit'))) {
						$keepPeriod = str_replace(1, Minz_Request::param('keep_period_count'), Minz_Request::param('keep_period_unit'));
					}
				} else {
					$keepPeriod = false;
				}
				$feed->_attributes('archiving', [
					'keep_period' => $keepPeriod,
					'keep_max' => $keepMax,
					'keep_min' => intval(Minz_Request::param('keep_min', 0)),
					'keep_favourites' => Minz_Request::paramBoolean('keep_favourites'),
					'keep_labels' => Minz_Request::paramBoolean('keep_labels'),
					'keep_unreads' => Minz_Request::paramBoolean('keep_unreads'),
				]);
			}

			$feed->_filtersAction('read', preg_split('/[\n\r]+/', Minz_Request::param('filteractions_read', '')));

			$values = array(
				'name' => Minz_Request::param('name', ''),
				'description' => sanitizeHTML(Minz_Request::param('description', '', true)),
				'website' => checkUrl(Minz_Request::param('website', '')),
				'url' => checkUrl(Minz_Request::param('url', '')),
				'category' => $cat,
				'pathEntries' => Minz_Request::param('path_entries', ''),
				'priority' => intval(Minz_Request::param('priority', FreshRSS_Feed::PRIORITY_MAIN_STREAM)),
				'httpAuth' => $httpAuth,
				'ttl' => $ttl * ($mute ? -1 : 1),
				'attributes' => $feed->attributes(),
			);

			invalidateHttpCache();

			$url_redirect = array('c' => 'subscription', 'params' => array('id' => $id));
			if ($feedDAO->updateFeed($id, $values) !== false) {
				$feed->_category($cat);
				$feed->faviconPrepare();

				Minz_Request::good(_t('feedback.sub.feed.updated'), $url_redirect);
			} else {
				Minz_Request::bad(_t('feedback.sub.feed.error'), $url_redirect);
			}
		}
	}

	public function categoryAction() {
		$this->view->_layout(false);

		$categoryDAO = FreshRSS_Factory::createCategoryDao();

		$id = Minz_Request::param('id');
		$category = $categoryDAO->searchById($id);
		if ($id === false || null === $category) {
			Minz_Error::error(404);
			return;
		}
		$this->view->category = $category;

		if (Minz_Request::isPost()) {
			if (Minz_Request::paramBoolean('use_default_purge_options')) {
				$category->_attributes('archiving', null);
			} else {
				if (!Minz_Request::paramBoolean('enable_keep_max')) {
					$keepMax = false;
				} elseif (!$keepMax = Minz_Request::param('keep_max')) {
					$keepMax = FreshRSS_Feed::ARCHIVING_RETENTION_COUNT_LIMIT;
				}
				if ($enableRetentionPeriod = Minz_Request::paramBoolean('enable_keep_period')) {
					$keepPeriod = FreshRSS_Feed::ARCHIVING_RETENTION_PERIOD;
					if (is_numeric(Minz_Request::param('keep_period_count')) && preg_match('/^PT?1[YMWDH]$/', Minz_Request::param('keep_period_unit'))) {
						$keepPeriod = str_replace(1, Minz_Request::param('keep_period_count'), Minz_Request::param('keep_period_unit'));
					}
				} else {
					$keepPeriod = false;
				}
				$category->_attributes('archiving', [
					'keep_period' => $keepPeriod,
					'keep_max' => $keepMax,
					'keep_min' => intval(Minz_Request::param('keep_min', 0)),
					'keep_favourites' => Minz_Request::paramBoolean('keep_favourites'),
					'keep_labels' => Minz_Request::paramBoolean('keep_labels'),
					'keep_unreads' => Minz_Request::paramBoolean('keep_unreads'),
				]);
			}

			$position = Minz_Request::param('position');
			$category->_attributes('position', '' === $position ? null : (int) $position);

			$values = [
				'name' => Minz_Request::param('name', ''),
				'attributes' => $category->attributes(),
			];

			invalidateHttpCache();

			$url_redirect = array('c' => 'subscription', 'params' => array('id' => $id, 'type' => 'category'));
			if (false !== $categoryDAO->updateCategory($id, $values)) {
				Minz_Request::good(_t('feedback.sub.category.updated'), $url_redirect);
			} else {
				Minz_Request::bad(_t('feedback.sub.category.error'), $url_redirect);
			}
		}
	}

	/**
	 * This action displays the bookmarklet page.
	 */
	public function bookmarkletAction() {
		Minz_View::prependTitle(_t('sub.title.subscription_tools') . ' . ');
	}

	/**
	 * This action displays the page to add a new feed
	 */
	public function addAction() {
		Minz_View::prependTitle(_t('sub.title.add') . ' . ');
	}
}
