<?php

/**
 * Controller to handle every configuration options.
 */
class FreshRSS_configure_Controller extends Minz_ActionController {
	/**
	 * This action is called before every other action in that class. It is
	 * the common boiler plate for every action. It is triggered by the
	 * underlying framework.
	 *
	 * @todo see if the category default configuration is needed here or if
	 *       we can move it to the categorize action
	 */
	public function firstAction() {
		if (!$this->view->loginOk) {
			Minz_Error::error(
				403,
				array('error' => array(_t('access_denied')))
			);
		}

		$catDAO = new FreshRSS_CategoryDAO();
		$catDAO->checkDefault();
	}

	/**
	 * This action handles the category configuration page
	 *
	 * It displays the category configuration page.
	 * If this action is reached through a POST request, it loops through
	 * every category to check for modification then add a new category if
	 * needed then sends a notification to the user.
	 * If a category name is emptied, the category is deleted and all
	 * related feeds are moved to the default category. Related user queries
	 * are deleted too.
	 * If a category name is changed, it is updated.
	 */
	public function categorizeAction() {
		$feedDAO = FreshRSS_Factory::createFeedDao();
		$catDAO = new FreshRSS_CategoryDAO();
		$defaultCategory = $catDAO->getDefault();
		$defaultId = $defaultCategory->id();

		if (Minz_Request::isPost()) {
			$cats = Minz_Request::param('categories', array());
			$ids = Minz_Request::param('ids', array());
			$newCat = trim(Minz_Request::param('new_category', ''));

			foreach ($cats as $key => $name) {
				if (strlen($name) > 0) {
					$cat = new FreshRSS_Category($name);
					$values = array(
						'name' => $cat->name(),
					);
					$catDAO->updateCategory($ids[$key], $values);
				} elseif ($ids[$key] != $defaultId) {
					$feedDAO->changeCategory($ids[$key], $defaultId);
					$catDAO->deleteCategory($ids[$key]);

					// Remove related queries.
					$this->view->conf->remove_query_by_get('c_' . $ids[$key]);
					$this->view->conf->save();
				}
			}

			if ($newCat != '') {
				$cat = new FreshRSS_Category($newCat);
				$values = array(
					'id' => $cat->id(),
					'name' => $cat->name(),
				);

				if ($catDAO->searchByName($newCat) == null) {
					$catDAO->addCategory($values);
				}
			}
			invalidateHttpCache();

			Minz_Request::good(_t('categories_updated'),
			                   array('c' => 'configure', 'a' => 'categorize'));
		}

		$this->view->categories = $catDAO->listCategories(false);
		$this->view->defaultCategory = $catDAO->getDefault();
		$this->view->feeds = $feedDAO->listFeeds();

		Minz_View::prependTitle(_t('categories_management') . ' · ');
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
					Minz_Request::forward(array('c' => 'configure', 'a' => 'feed', 'params' => array('id' => $id)), true);
				}

				Minz_View::prependTitle(_t('rss_feed_management') . ' — ' . $this->view->flux->name() . ' · ');
			}
		} else {
			Minz_View::prependTitle(_t('rss_feed_management') . ' · ');
		}
	}

	/**
	 * This action handles the display configuration page.
	 *
	 * It displays the display configuration page.
	 * If this action is reached through a POST request, it stores all new
	 * configuration values then sends a notification to the user.
	 *
	 * The options available on the page are:
	 *   - language (default: en)
	 *   - theme (default: Origin)
	 *   - content width (default: thin)
	 *   - display of read action in header
	 *   - display of favorite action in header
	 *   - display of date in header
	 *   - display of open action in header
	 *   - display of read action in footer
	 *   - display of favorite action in footer
	 *   - display of sharing action in footer
	 *   - display of tags in footer
	 *   - display of date in footer
	 *   - display of open action in footer
	 *   - html5 notification timeout (default: 0)
	 * Default values are false unless specified.
	 */
	public function displayAction() {
		if (Minz_Request::isPost()) {
			$this->view->conf->_language(Minz_Request::param('language', 'en'));
			$this->view->conf->_theme(Minz_Request::param('theme', FreshRSS_Themes::$defaultTheme));
			$this->view->conf->_content_width(Minz_Request::param('content_width', 'thin'));
			$this->view->conf->_topline_read(Minz_Request::param('topline_read', false));
			$this->view->conf->_topline_favorite(Minz_Request::param('topline_favorite', false));
			$this->view->conf->_topline_date(Minz_Request::param('topline_date', false));
			$this->view->conf->_topline_link(Minz_Request::param('topline_link', false));
			$this->view->conf->_bottomline_read(Minz_Request::param('bottomline_read', false));
			$this->view->conf->_bottomline_favorite(Minz_Request::param('bottomline_favorite', false));
			$this->view->conf->_bottomline_sharing(Minz_Request::param('bottomline_sharing', false));
			$this->view->conf->_bottomline_tags(Minz_Request::param('bottomline_tags', false));
			$this->view->conf->_bottomline_date(Minz_Request::param('bottomline_date', false));
			$this->view->conf->_bottomline_link(Minz_Request::param('bottomline_link', false));
			$this->view->conf->_html5_notif_timeout(Minz_Request::param('html5_notif_timeout', 0));
			$this->view->conf->save();

			Minz_Session::_param('language', $this->view->conf->language);
			Minz_Translate::reset();
			invalidateHttpCache();

			Minz_Request::good(_t('configuration_updated'),
			                   array('c' => 'configure', 'a' => 'display'));
		}

		$this->view->themes = FreshRSS_Themes::get();

		Minz_View::prependTitle(_t('display_configuration') . ' · ');
	}

	/**
	 * This action handles the reading configuration page.
	 *
	 * It displays the reading configuration page.
	 * If this action is reached through a POST request, it stores all new
	 * configuration values then sends a notification to the user.
	 *
	 * The options available on the page are:
	 *   - number of posts per page (default: 10)
	 *   - view mode (default: normal)
	 *   - default article view (default: all)
	 *   - load automatically articles
	 *   - display expanded articles
	 *   - display expanded categories
	 *   - hide categories and feeds without unread articles
	 *   - jump on next category or feed when marked as read
	 *   - image lazy loading
	 *   - stick open articles to the top
	 *   - display a confirmation when reading all articles
	 *   - article order (default: DESC)
	 *   - mark articles as read when:
	 *       - displayed
	 *       - opened on site
	 *       - scrolled
	 *       - received
	 * Default values are false unless specified.
	 */
	public function readingAction() {
		if (Minz_Request::isPost()) {
			$this->view->conf->_posts_per_page(Minz_Request::param('posts_per_page', 10));
			$this->view->conf->_view_mode(Minz_Request::param('view_mode', 'normal'));
			$this->view->conf->_default_view((int)Minz_Request::param('default_view', FreshRSS_Entry::STATE_ALL));
			$this->view->conf->_auto_load_more(Minz_Request::param('auto_load_more', false));
			$this->view->conf->_display_posts(Minz_Request::param('display_posts', false));
			$this->view->conf->_display_categories(Minz_Request::param('display_categories', false));
			$this->view->conf->_hide_read_feeds(Minz_Request::param('hide_read_feeds', false));
			$this->view->conf->_onread_jump_next(Minz_Request::param('onread_jump_next', false));
			$this->view->conf->_lazyload(Minz_Request::param('lazyload', false));
			$this->view->conf->_sticky_post(Minz_Request::param('sticky_post', false));
			$this->view->conf->_reading_confirm(Minz_Request::param('reading_confirm', false));
			$this->view->conf->_sort_order(Minz_Request::param('sort_order', 'DESC'));
			$this->view->conf->_mark_when(array(
				'article' => Minz_Request::param('mark_open_article', false),
				'site' => Minz_Request::param('mark_open_site', false),
				'scroll' => Minz_Request::param('mark_scroll', false),
				'reception' => Minz_Request::param('mark_upon_reception', false),
			));
			$this->view->conf->save();

			Minz_Session::_param('language', $this->view->conf->language);
			Minz_Translate::reset();
			invalidateHttpCache();

			Minz_Request::good(_t('configuration_updated'),
			                   array('c' => 'configure', 'a' => 'reading'));
		}

		Minz_View::prependTitle(_t('reading_configuration') . ' · ');
	}

	/**
	 * This action handles the sharing configuration page.
	 *
	 * It displays the sharing configuration page.
	 * If this action is reached through a POST request, it stores all
	 * configuration values then sends a notification to the user.
	 */
	public function sharingAction() {
		if (Minz_Request::isPost()) {
			$params = Minz_Request::params();
			$this->view->conf->_sharing($params['share']);
			$this->view->conf->save();
			invalidateHttpCache();

			Minz_Request::good(_t('configuration_updated'),
			                   array('c' => 'configure', 'a' => 'sharing'));
		}

		Minz_View::prependTitle(_t('sharing') . ' · ');
	}

	/**
	 * This action handles the shortcut configuration page.
	 *
	 * It displays the shortcut configuration page.
	 * If this action is reached through a POST request, it stores all new
	 * configuration values then sends a notification to the user.
	 *
	 * The authorized values for shortcuts are letters (a to z), numbers (0
	 * to 9), function keys (f1 to f12), backspace, delete, down, end, enter,
	 * escape, home, insert, left, page down, page up, return, right, space,
	 * tab and up.
	 */
	public function shortcutAction() {
		$list_keys = array('a', 'b', 'backspace', 'c', 'd', 'delete', 'down', 'e', 'end', 'enter',
		                    'escape', 'f', 'g', 'h', 'home', 'i', 'insert', 'j', 'k', 'l', 'left',
		                    'm', 'n', 'o', 'p', 'page_down', 'page_up', 'q', 'r', 'return', 'right',
		                    's', 'space', 't', 'tab', 'u', 'up', 'v', 'w', 'x', 'y',
		                    'z', 'f1', 'f2', 'f3', 'f4', 'f5', 'f6', 'f7', 'f8', 'f9',
		                    'f10', 'f11', 'f12');
		$this->view->list_keys = $list_keys;

		if (Minz_Request::isPost()) {
			$shortcuts = Minz_Request::param('shortcuts');
			$shortcuts_ok = array();

			foreach ($shortcuts as $key => $value) {
				if (in_array($value, $list_keys)) {
					$shortcuts_ok[$key] = $value;
				}
			}

			$this->view->conf->_shortcuts($shortcuts_ok);
			$this->view->conf->save();
			invalidateHttpCache();

			Minz_Request::good(_t('shortcuts_updated'),
			                   array('c' => 'configure', 'a' => 'shortcut'));
		}

		Minz_View::prependTitle(_t('shortcuts') . ' · ');
	}

	/**
	 * This action display the user configuration page
	 *
	 * @todo move that action in the user controller
	 */
	public function usersAction() {
		Minz_View::prependTitle(_t('users') . ' · ');
	}

	/**
	 * This action handles the archive configuration page.
	 *
	 * It displays the archive configuration page.
	 * If this action is reached through a POST request, it stores all new
	 * configuration values then sends a notification to the user.
	 *
	 * The options available on that page are:
	 *   - duration to retain old article (default: 3)
	 *   - number of article to retain per feed (default: 0)
	 *   - refresh frequency (default: -2)
	 *
	 * @todo explain why the default value is -2 but this value does not
	 *       exist in the drop-down list
	 */
	public function archivingAction() {
		if (Minz_Request::isPost()) {
			$this->view->conf->_old_entries(Minz_Request::param('old_entries', 3));
			$this->view->conf->_keep_history_default(Minz_Request::param('keep_history_default', 0));
			$this->view->conf->_ttl_default(Minz_Request::param('ttl_default', -2));
			$this->view->conf->save();
			invalidateHttpCache();

			Minz_Request::good(_t('configuration_updated'),
			                   array('c' => 'configure', 'a' => 'archiving'));
		}

		Minz_View::prependTitle(_t('archiving_configuration') . ' · ');

		$entryDAO = FreshRSS_Factory::createEntryDao();
		$this->view->nb_total = $entryDAO->count();
		$this->view->size_user = $entryDAO->size();

		if (Minz_Configuration::isAdmin(Minz_Session::param('currentUser', '_'))) {
			$this->view->size_total = $entryDAO->size(true);
		}
	}

	/**
	 * This action handles the user queries configuration page.
	 *
	 * If this action is reached through a POST request, it stores all new
	 * configuration values then sends a notification to the user then
	 * redirect to the same page.
	 * If this action is not reached through a POST request, it displays the
	 * configuration page and verifies that every user query is runable by
	 * checking if categories and feeds are still in use.
	 */
	public function queriesAction() {
		if (Minz_Request::isPost()) {
			$queries = Minz_Request::param('queries', array());

			foreach ($queries as $key => $query) {
				if (!$query['name']) {
					$query['name'] = _t('query_number', $key + 1);
				}
			}
			$this->view->conf->_queries($queries);
			$this->view->conf->save();

			Minz_Request::good(_t('configuration_updated'),
			                   array('c' => 'configure', 'a' => 'queries'));
		} else {
			$this->view->query_get = array();
			$cat_dao = new FreshRSS_CategoryDAO();
			$feed_dao = FreshRSS_Factory::createFeedDao();
			foreach ($this->view->conf->queries as $key => $query) {
				if (!isset($query['get'])) {
					continue;
				}

				switch ($query['get'][0]) {
				case 'c':
					$category = $cat_dao->searchById(substr($query['get'], 2));

					$deprecated = true;
					$cat_name = '';
					if ($category) {
						$cat_name = $category->name();
						$deprecated = false;
					}

					$this->view->query_get[$key] = array(
						'type' => 'category',
						'name' => $cat_name,
						'deprecated' => $deprecated,
					);
					break;
				case 'f':
					$feed = $feed_dao->searchById(substr($query['get'], 2));

					$deprecated = true;
					$feed_name = '';
					if ($feed) {
						$feed_name = $feed->name();
						$deprecated = false;
					}

					$this->view->query_get[$key] = array(
						'type' => 'feed',
						'name' => $feed_name,
						'deprecated' => $deprecated,
					);
					break;
				case 's':
					$this->view->query_get[$key] = array(
						'type' => 'favorite',
						'name' => 'favorite',
						'deprecated' => false,
					);
					break;
				case 'a':
					$this->view->query_get[$key] = array(
						'type' => 'all',
						'name' => 'all',
						'deprecated' => false,
					);
					break;
				}
			}
		}

		Minz_View::prependTitle(_t('queries') . ' · ');
	}

	/**
	 * This action handles the creation of a user query.
	 *
	 * It gets the GET parameters and stores them in the configuration query
	 * storage. Before it is saved, the unwanted parameters are unset to keep
	 * lean data.
	 */
	public function addQueryAction() {
		$whitelist = array('get', 'order', 'name', 'search', 'state');
		$queries = $this->view->conf->queries;
		$query = Minz_Request::params();
		$query['name'] = _t('query_number', count($queries) + 1);
		foreach ($query as $key => $value) {
			if (!in_array($key, $whitelist)) {
				unset($query[$key]);
			}
		}
		if (!empty($query['state']) && $query['state'] & FreshRSS_Entry::STATE_STRICT) {
			$query['state'] -= FreshRSS_Entry::STATE_STRICT;
		}
		$queries[] = $query;
		$this->view->conf->_queries($queries);
		$this->view->conf->save();

		Minz_Request::good(_t('query_created', $query['name']),
		                   array('c' => 'configure', 'a' => 'queries'));
	}
}
