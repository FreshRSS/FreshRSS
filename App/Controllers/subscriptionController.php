<?php

namespace Freshrss\Controllers;

/**
 * Controller to handle subscription actions.
 */
class subscription_Controller extends ActionController {
	/**
	 * This action is called before every other action in that class. It is
	 * the common boiler plate for every action. It is triggered by the
	 * underlying framework.
	 */
	public function firstAction() {
		if (!Auth::hasAccess()) {
			Error::error(403);
		}

		$catDAO = Factory::createCategoryDao();
		$feedDAO = Factory::createFeedDao();

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
		View::appendScript(Minz_Url::display('/scripts/category.js?' . @filemtime(PUBLIC_PATH . '/scripts/category.js')));
		View::prependTitle(_t('sub.title') . ' · ');

		$this->view->onlyFeedsWithError = Request::paramTernary('error');

		$id = Request::param('id');
		$this->view->displaySlider = false;
		if (false !== $id) {
			$type = Request::param('type');
			$this->view->displaySlider = true;
			switch ($type) {
				case 'category':
					$categoryDAO = Factory::createCategoryDao();
					$this->view->category = $categoryDAO->searchById($id);
					break;
				default:
					$feedDAO = Factory::createFeedDao();
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
		if (Request::param('ajax')) {
			$this->view->_layout(false);
		}

		$feedDAO = Factory::createFeedDao();
		$this->view->feeds = $feedDAO->listFeeds();

		$id = Request::param('id');
		if ($id === false || !isset($this->view->feeds[$id])) {
			Error::error(404);
			return;
		}

		$feed = $this->view->feeds[$id];
		$this->view->feed = $feed;

		View::prependTitle(_t('sub.title.feed_management') . ' · ' . $feed->name() . ' · ');

		if (Request::isPost()) {
			$user = trim(Request::param('http_user_feed' . $id, ''));
			$pass = Request::param('http_pass_feed' . $id, '');

			$httpAuth = '';
			if ($user != '' && $pass != '') {	//TODO: Sanitize
				$httpAuth = $user . ':' . $pass;
			}

			$cat = intval(Request::param('category', 0));

			$mute = Request::param('mute', false);
			$ttl = intval(Request::param('ttl', Feed::TTL_DEFAULT));
			if ($mute && Feed::TTL_DEFAULT === $ttl) {
				$ttl = Context::$user_conf->ttl_default;
			}

			$feed->_attributes('mark_updated_article_unread', Request::paramTernary('mark_updated_article_unread'));
			$feed->_attributes('read_upon_reception', Request::paramTernary('read_upon_reception'));
			$feed->_attributes('clear_cache', Request::paramTernary('clear_cache'));

			if (Auth::hasAccess('admin')) {
				$feed->_attributes('ssl_verify', Request::paramTernary('ssl_verify'));
				$timeout = intval(Request::param('timeout', 0));
				$feed->_attributes('timeout', $timeout > 0 ? $timeout : null);
			} else {
				$feed->_attributes('ssl_verify', null);
				$feed->_attributes('timeout', null);
			}

			if (Request::paramBoolean('use_default_purge_options')) {
				$feed->_attributes('archiving', null);
			} else {
				if (!Request::paramBoolean('enable_keep_max')) {
					$keepMax = false;
				} elseif (!$keepMax = Request::param('keep_max')) {
					$keepMax = Feed::ARCHIVING_RETENTION_COUNT_LIMIT;
				}
				if ($enableRetentionPeriod = Request::paramBoolean('enable_keep_period')) {
					$keepPeriod = Feed::ARCHIVING_RETENTION_PERIOD;
					if (is_numeric(Request::param('keep_period_count')) && preg_match('/^PT?1[YMWDH]$/', Minz_Request::param('keep_period_unit'))) {
						$keepPeriod = str_replace(1, Request::param('keep_period_count'), Minz_Request::param('keep_period_unit'));
					}
				} else {
					$keepPeriod = false;
				}
				$feed->_attributes('archiving', [
					'keep_period' => $keepPeriod,
					'keep_max' => $keepMax,
					'keep_min' => intval(Request::param('keep_min', 0)),
					'keep_favourites' => Request::paramBoolean('keep_favourites'),
					'keep_labels' => Request::paramBoolean('keep_labels'),
					'keep_unreads' => Request::paramBoolean('keep_unreads'),
				]);
			}

			$feed->_filtersAction('read', preg_split('/[\n\r]+/', Request::param('filteractions_read', '')));

			$values = array(
				'name' => Request::param('name', ''),
				'description' => sanitizeHTML(Request::param('description', '', true)),
				'website' => checkUrl(Request::param('website', '')),
				'url' => checkUrl(Request::param('url', '')),
				'category' => $cat,
				'pathEntries' => Request::param('path_entries', ''),
				'priority' => intval(Request::param('priority', Feed::PRIORITY_MAIN_STREAM)),
				'httpAuth' => $httpAuth,
				'ttl' => $ttl * ($mute ? -1 : 1),
				'attributes' => $feed->attributes(),
			);

			invalidateHttpCache();

			$url_redirect = array('c' => 'subscription', 'params' => array('id' => $id));
			if ($feedDAO->updateFeed($id, $values) !== false) {
				$feed->_category($cat);
				$feed->faviconPrepare();

				Request::good(_t('feedback.sub.feed.updated'), $url_redirect);
			} else {
				Request::bad(_t('feedback.sub.feed.error'), $url_redirect);
			}
		}
	}

	public function categoryAction() {
		$this->view->_layout(false);

		$categoryDAO = Factory::createCategoryDao();

		$id = Request::param('id');
		$category = $categoryDAO->searchById($id);
		if ($id === false || null === $category) {
			Error::error(404);
			return;
		}
		$this->view->category = $category;

		if (Request::isPost()) {
			if (Request::paramBoolean('use_default_purge_options')) {
				$category->_attributes('archiving', null);
			} else {
				if (!Request::paramBoolean('enable_keep_max')) {
					$keepMax = false;
				} elseif (!$keepMax = Request::param('keep_max')) {
					$keepMax = Feed::ARCHIVING_RETENTION_COUNT_LIMIT;
				}
				if ($enableRetentionPeriod = Request::paramBoolean('enable_keep_period')) {
					$keepPeriod = Feed::ARCHIVING_RETENTION_PERIOD;
					if (is_numeric(Request::param('keep_period_count')) && preg_match('/^PT?1[YMWDH]$/', Minz_Request::param('keep_period_unit'))) {
						$keepPeriod = str_replace(1, Request::param('keep_period_count'), Minz_Request::param('keep_period_unit'));
					}
				} else {
					$keepPeriod = false;
				}
				$category->_attributes('archiving', [
					'keep_period' => $keepPeriod,
					'keep_max' => $keepMax,
					'keep_min' => intval(Request::param('keep_min', 0)),
					'keep_favourites' => Request::paramBoolean('keep_favourites'),
					'keep_labels' => Request::paramBoolean('keep_labels'),
					'keep_unreads' => Request::paramBoolean('keep_unreads'),
				]);
			}

			$position = Request::param('position');
			$category->_attributes('position', '' === $position ? null : (int) $position);

			$values = [
				'name' => Request::param('name', ''),
				'attributes' => $category->attributes(),
			];

			invalidateHttpCache();

			$url_redirect = array('c' => 'subscription', 'params' => array('id' => $id, 'type' => 'category'));
			if (false !== $categoryDAO->updateCategory($id, $values)) {
				Request::good(_t('feedback.sub.category.updated'), $url_redirect);
			} else {
				Request::bad(_t('feedback.sub.category.error'), $url_redirect);
			}
		}
	}

	/**
	 * This action displays the bookmarklet page.
	 */
	public function bookmarkletAction() {
		View::prependTitle(_t('sub.title.subscription_tools') . ' . ');
	}
}
