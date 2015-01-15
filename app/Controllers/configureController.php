<?php

/**
 * Controller to handle every configuration options.
 */
class FreshRSS_configure_Controller extends Minz_ActionController {
	/**
	 * This action is called before every other action in that class. It is
	 * the common boiler plate for every action. It is triggered by the
	 * underlying framework.
	 */
	public function firstAction() {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
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
			FreshRSS_Context::$user_conf->language = Minz_Request::param('language', 'en');
			FreshRSS_Context::$user_conf->theme = Minz_Request::param('theme', FreshRSS_Themes::$defaultTheme);
			FreshRSS_Context::$user_conf->content_width = Minz_Request::param('content_width', 'thin');
			FreshRSS_Context::$user_conf->topline_read = Minz_Request::param('topline_read', false);
			FreshRSS_Context::$user_conf->topline_favorite = Minz_Request::param('topline_favorite', false);
			FreshRSS_Context::$user_conf->topline_date = Minz_Request::param('topline_date', false);
			FreshRSS_Context::$user_conf->topline_link = Minz_Request::param('topline_link', false);
			FreshRSS_Context::$user_conf->bottomline_read = Minz_Request::param('bottomline_read', false);
			FreshRSS_Context::$user_conf->bottomline_favorite = Minz_Request::param('bottomline_favorite', false);
			FreshRSS_Context::$user_conf->bottomline_sharing = Minz_Request::param('bottomline_sharing', false);
			FreshRSS_Context::$user_conf->bottomline_tags = Minz_Request::param('bottomline_tags', false);
			FreshRSS_Context::$user_conf->bottomline_date = Minz_Request::param('bottomline_date', false);
			FreshRSS_Context::$user_conf->bottomline_link = Minz_Request::param('bottomline_link', false);
			FreshRSS_Context::$user_conf->html5_notif_timeout = Minz_Request::param('html5_notif_timeout', 0);
			FreshRSS_Context::$user_conf->save();

			Minz_Session::_param('language', FreshRSS_Context::$user_conf->language);
			Minz_Translate::reset(FreshRSS_Context::$user_conf->language);
			invalidateHttpCache();

			Minz_Request::good(_t('feedback.conf.updated'),
			                   array('c' => 'configure', 'a' => 'display'));
		}

		$this->view->themes = FreshRSS_Themes::get();

		Minz_View::prependTitle(_t('conf.display.title') . ' · ');
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
	 *   - auto remove article after reading
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
			FreshRSS_Context::$user_conf->posts_per_page = Minz_Request::param('posts_per_page', 10);
			FreshRSS_Context::$user_conf->view_mode = Minz_Request::param('view_mode', 'normal');
			FreshRSS_Context::$user_conf->default_view = Minz_Request::param('default_view', 'adaptive');
			FreshRSS_Context::$user_conf->auto_load_more = Minz_Request::param('auto_load_more', false);
			FreshRSS_Context::$user_conf->display_posts = Minz_Request::param('display_posts', false);
			FreshRSS_Context::$user_conf->display_categories = Minz_Request::param('display_categories', false);
			FreshRSS_Context::$user_conf->hide_read_feeds = Minz_Request::param('hide_read_feeds', false);
			FreshRSS_Context::$user_conf->onread_jump_next = Minz_Request::param('onread_jump_next', false);
			FreshRSS_Context::$user_conf->lazyload = Minz_Request::param('lazyload', false);
			FreshRSS_Context::$user_conf->sticky_post = Minz_Request::param('sticky_post', false);
			FreshRSS_Context::$user_conf->reading_confirm = Minz_Request::param('reading_confirm', false);
			FreshRSS_Context::$user_conf->auto_remove_article = Minz_Request::param('auto_remove_article', false);
			FreshRSS_Context::$user_conf->sort_order = Minz_Request::param('sort_order', 'DESC');
			FreshRSS_Context::$user_conf->mark_when = array(
				'article' => Minz_Request::param('mark_open_article', false),
				'site' => Minz_Request::param('mark_open_site', false),
				'scroll' => Minz_Request::param('mark_scroll', false),
				'reception' => Minz_Request::param('mark_upon_reception', false),
			);
			FreshRSS_Context::$user_conf->save();
			invalidateHttpCache();

			Minz_Request::good(_t('feedback.conf.updated'),
			                   array('c' => 'configure', 'a' => 'reading'));
		}

		Minz_View::prependTitle(_t('conf.reading.title') . ' · ');
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
			FreshRSS_Context::$user_conf->sharing = $params['share'];
			FreshRSS_Context::$user_conf->save();
			invalidateHttpCache();

			Minz_Request::good(_t('feedback.conf.updated'),
			                   array('c' => 'configure', 'a' => 'sharing'));
		}

		Minz_View::prependTitle(_t('conf.sharing.title') . ' · ');
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

			FreshRSS_Context::$user_conf->shortcuts = $shortcuts_ok;
			FreshRSS_Context::$user_conf->save();
			invalidateHttpCache();

			Minz_Request::good(_t('feedback.conf.shortcuts_updated'),
			                   array('c' => 'configure', 'a' => 'shortcut'));
		}

		Minz_View::prependTitle(_t('conf.shortcut.title') . ' · ');
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
			FreshRSS_Context::$user_conf->old_entries = Minz_Request::param('old_entries', 3);
			FreshRSS_Context::$user_conf->keep_history_default = Minz_Request::param('keep_history_default', 0);
			FreshRSS_Context::$user_conf->ttl_default = Minz_Request::param('ttl_default', -2);
			FreshRSS_Context::$user_conf->save();
			invalidateHttpCache();

			Minz_Request::good(_t('feedback.conf.updated'),
			                   array('c' => 'configure', 'a' => 'archiving'));
		}

		Minz_View::prependTitle(_t('conf.archiving.title') . ' · ');

		$entryDAO = FreshRSS_Factory::createEntryDao();
		$this->view->nb_total = $entryDAO->count();
		$this->view->size_user = $entryDAO->size();

		if (FreshRSS_Auth::hasAccess('admin')) {
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
					$query['name'] = _t('conf.query.number', $key + 1);
				}
			}
			FreshRSS_Context::$user_conf->queries = $queries;
			FreshRSS_Context::$user_conf->save();

			Minz_Request::good(_t('feedback.conf.updated'),
			                   array('c' => 'configure', 'a' => 'queries'));
		} else {
			$this->view->query_get = array();
			$cat_dao = new FreshRSS_CategoryDAO();
			$feed_dao = FreshRSS_Factory::createFeedDao();
			foreach (FreshRSS_Context::$user_conf->queries as $key => $query) {
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

		Minz_View::prependTitle(_t('conf.query.title') . ' · ');
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
		$queries = FreshRSS_Context::$user_conf->queries;
		$query = Minz_Request::params();
		$query['name'] = _t('conf.query.number', count($queries) + 1);
		foreach ($query as $key => $value) {
			if (!in_array($key, $whitelist)) {
				unset($query[$key]);
			}
		}
		$queries[] = $query;
		FreshRSS_Context::$user_conf->queries = $queries;
		FreshRSS_Context::$user_conf->save();

		Minz_Request::good(_t('feedback.conf.query_created', $query['name']),
		                   array('c' => 'configure', 'a' => 'queries'));
	}
}
