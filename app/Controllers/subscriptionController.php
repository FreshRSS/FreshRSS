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
		if (!$this->view->loginOk) {
			Minz_Error::error(
				403,
				array('error' => array(_t('access_denied')))
			);
		}
	}

	/**
	 * This action handles the main subscription page
	 *
	 * It displays categories and associated feeds.
	 */
	public function indexAction() {
		$catDAO = new FreshRSS_CategoryDAO();

		$this->view->categories = $catDAO->listCategories(false);
		$this->view->default_category = $catDAO->getDefault();

		Minz_View::prependTitle(_t('subscription_management') . ' · ');
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
	 *   - refresh frequency (default: -2)
	 * Default values are empty strings unless specified.
	 */
	public function feedAction() {
		if (Minz_Request::param('ajax')) {
			$this->view->_useLayout(false);
		}

		$catDAO = new FreshRSS_CategoryDAO();
		$this->view->categories = $catDAO->listCategories(false);

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$this->view->feeds = $feedDAO->listFeeds();

		$id = Minz_Request::param('id');
		if ($id == false && !empty($this->view->feeds)) {
			$id = current($this->view->feeds)->id();
		}

		$this->view->flux = false;
		if ($id != false) {
			$this->view->flux = $this->view->feeds[$id];

			if (!$this->view->flux) {
				Minz_Error::error(
					404,
					array('error' => array(_t('page_not_found')))
				);
			} else {
				if (Minz_Request::isPost() && $this->view->flux) {
					$user = Minz_Request::param('http_user', '');
					$pass = Minz_Request::param('http_pass', '');

					$httpAuth = '';
					if ($user != '' || $pass != '') {
						$httpAuth = $user . ':' . $pass;
					}

					$cat = intval(Minz_Request::param('category', 0));

					$values = array(
						'name' => Minz_Request::param('name', ''),
						'description' => sanitizeHTML(Minz_Request::param('description', '', true)),
						'website' => Minz_Request::param('website', ''),
						'url' => Minz_Request::param('url', ''),
						'category' => $cat,
						'pathEntries' => Minz_Request::param('path_entries', ''),
						'priority' => intval(Minz_Request::param('priority', 0)),
						'httpAuth' => $httpAuth,
						'keep_history' => intval(Minz_Request::param('keep_history', -2)),
						'ttl' => intval(Minz_Request::param('ttl', -2)),
					);

					if ($feedDAO->updateFeed($id, $values)) {
						$this->view->flux->_category($cat);
						$this->view->flux->faviconPrepare();
						$notif = array(
							'type' => 'good',
							'content' => _t('feed_updated')
						);
					} else {
						$notif = array(
							'type' => 'bad',
							'content' => _t('error_occurred_update')
						);
					}
					invalidateHttpCache();

					Minz_Session::_param('notification', $notif);
					Minz_Request::forward(array('c' => 'subscription'), true);
				}

				Minz_View::prependTitle(_t('rss_feed_management') . ' · ' . $this->view->flux->name() . ' · ');
			}
		} else {
			Minz_View::prependTitle(_t('rss_feed_management') . ' · ');
		}
	}
}
