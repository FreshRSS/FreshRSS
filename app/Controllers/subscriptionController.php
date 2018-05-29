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

		$catDAO = new FreshRSS_CategoryDAO();
		$feedDAO = FreshRSS_Factory::createFeedDao();

		$catDAO->checkDefault();
		$feedDAO->updateTTL();
		$this->view->categories = $catDAO->listCategories(false);
		$this->view->default_category = $catDAO->getDefault();
	}

	/**
	 * This action handles the main subscription page
	 *
	 * It displays categories and associated feeds.
	 */
	public function indexAction() {
		Minz_View::appendScript(Minz_Url::display('/scripts/category.js?' .
		                        @filemtime(PUBLIC_PATH . '/scripts/category.js')));
		Minz_View::prependTitle(_t('sub.title') . ' · ');

		$id = Minz_Request::param('id');
		if ($id !== false) {
			$feedDAO = FreshRSS_Factory::createFeedDao();
			$this->view->feed = $feedDAO->searchById($id);
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
			$this->view->_useLayout(false);
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

			if (FreshRSS_Auth::hasAccess('admin')) {
				$feed->_attributes('ssl_verify', Minz_Request::paramTernary('ssl_verify'));
				$timeout = intval(Minz_Request::param('timeout', 0));
				$feed->_attributes('timeout', $timeout > 0 ? $timeout : null);
			} else {
				$feed->_attributes('ssl_verify', null);
				$feed->_attributes('timeout', null);
			}

			$values = array(
				'name' => Minz_Request::param('name', ''),
				'description' => sanitizeHTML(Minz_Request::param('description', '', true)),
				'website' => checkUrl(Minz_Request::param('website', '')),
				'url' => checkUrl(Minz_Request::param('url', '')),
				'category' => $cat,
				'pathEntries' => Minz_Request::param('path_entries', ''),
				'priority' => intval(Minz_Request::param('priority', FreshRSS_Feed::PRIORITY_MAIN_STREAM)),
				'httpAuth' => $httpAuth,
				'keep_history' => intval(Minz_Request::param('keep_history', FreshRSS_Feed::KEEP_HISTORY_DEFAULT)),
				'ttl' => $ttl * ($mute ? -1 : 1),
				'attributes' => $feed->attributes()
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

	/**
	 * This action displays the bookmarklet page.
	 */
	public function bookmarkletAction() {
		Minz_View::prependTitle(_t('sub.title.subscription_tools') . ' . ');
	}
}
