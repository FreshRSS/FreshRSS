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
			FreshRSS_Context::$user_conf->topline_thumbnail = Minz_Request::param('topline_thumbnail', false);
			FreshRSS_Context::$user_conf->topline_summary = Minz_Request::param('topline_summary', false);
			FreshRSS_Context::$user_conf->topline_display_authors = Minz_Request::param('topline_display_authors', false);
			FreshRSS_Context::$user_conf->bottomline_read = Minz_Request::param('bottomline_read', false);
			FreshRSS_Context::$user_conf->bottomline_favorite = Minz_Request::param('bottomline_favorite', false);
			FreshRSS_Context::$user_conf->bottomline_sharing = Minz_Request::param('bottomline_sharing', false);
			FreshRSS_Context::$user_conf->bottomline_tags = Minz_Request::param('bottomline_tags', false);
			FreshRSS_Context::$user_conf->bottomline_date = Minz_Request::param('bottomline_date', false);
			FreshRSS_Context::$user_conf->bottomline_link = Minz_Request::param('bottomline_link', false);
			FreshRSS_Context::$user_conf->html5_notif_timeout = Minz_Request::param('html5_notif_timeout', 0);
			FreshRSS_Context::$user_conf->show_nav_buttons = Minz_Request::param('show_nav_buttons', false);
			FreshRSS_Context::$user_conf->save();

			Minz_Session::_param('language', FreshRSS_Context::$user_conf->language);
			Minz_Translate::reset(FreshRSS_Context::$user_conf->language);
			invalidateHttpCache();

			Minz_Request::good(_t('feedback.conf.updated'), [ 'c' => 'configure', 'a' => 'display' ]);
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
			FreshRSS_Context::$user_conf->show_fav_unread = Minz_Request::param('show_fav_unread', false);
			FreshRSS_Context::$user_conf->auto_load_more = Minz_Request::param('auto_load_more', false);
			FreshRSS_Context::$user_conf->display_posts = Minz_Request::param('display_posts', false);
			FreshRSS_Context::$user_conf->display_categories = Minz_Request::param('display_categories', 'active');
			FreshRSS_Context::$user_conf->hide_read_feeds = Minz_Request::param('hide_read_feeds', false);
			FreshRSS_Context::$user_conf->onread_jump_next = Minz_Request::param('onread_jump_next', false);
			FreshRSS_Context::$user_conf->no_article_add_feed_link = Minz_Request::param('no_article_add_feed_link', false);
			FreshRSS_Context::$user_conf->lazyload = Minz_Request::param('lazyload', false);
			FreshRSS_Context::$user_conf->sides_close_article = Minz_Request::param('sides_close_article', false);
			FreshRSS_Context::$user_conf->sticky_post = Minz_Request::param('sticky_post', false);
			FreshRSS_Context::$user_conf->reading_confirm = Minz_Request::param('reading_confirm', false);
			FreshRSS_Context::$user_conf->auto_remove_article = Minz_Request::param('auto_remove_article', false);
			FreshRSS_Context::$user_conf->mark_updated_article_unread = Minz_Request::param('mark_updated_article_unread', false);
			FreshRSS_Context::$user_conf->sort_order = Minz_Request::param('sort_order', 'DESC');
			FreshRSS_Context::$user_conf->mark_when = array(
				'article' => Minz_Request::param('mark_open_article', false),
				'max_n_unread' => Minz_Request::paramBoolean('enable_keep_max_n_unread') ? Minz_Request::param('keep_max_n_unread', false) : false,
				'reception' => Minz_Request::param('mark_upon_reception', false),
				'same_title_in_feed' => Minz_Request::paramBoolean('enable_read_when_same_title_in_feed') ?
					Minz_Request::param('read_when_same_title_in_feed', false) : false,
				'scroll' => Minz_Request::param('mark_scroll', false),
				'site' => Minz_Request::param('mark_open_site', false),
			);
			FreshRSS_Context::$user_conf->save();
			invalidateHttpCache();

			Minz_Request::good(_t('feedback.conf.updated'), [ 'c' => 'configure', 'a' => 'reading' ]);
		}

		Minz_View::prependTitle(_t('conf.reading.title') . ' · ');
	}

	/**
	 * This action handles the integration configuration page.
	 *
	 * It displays the integration configuration page.
	 * If this action is reached through a POST request, it stores all
	 * configuration values then sends a notification to the user.
	 *
	 * Before v1.16, we used sharing instead of integration. This has
	 * some unwanted behavior when the end-user was using an ad-blocker.
	 */
	public function integrationAction() {
		Minz_View::appendScript(Minz_Url::display('/scripts/integration.js?' . @filemtime(PUBLIC_PATH . '/scripts/integration.js')));
		Minz_View::appendScript(Minz_Url::display('/scripts/draggable.js?' . @filemtime(PUBLIC_PATH . '/scripts/draggable.js')));

		if (Minz_Request::isPost()) {
			$params = $_POST;
			FreshRSS_Context::$user_conf->sharing = $params['share'];
			FreshRSS_Context::$user_conf->save();
			invalidateHttpCache();

			Minz_Request::good(_t('feedback.conf.updated'), [ 'c' => 'configure', 'a' => 'integration' ]);
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
		$this->view->list_keys = SHORTCUT_KEYS;

		if (Minz_Request::isPost()) {
			$shortcuts = Minz_Request::param('shortcuts');
			if (false !== Minz_Request::param('load_default_shortcuts')) {
				$default = Minz_Configuration::load(FRESHRSS_PATH . '/config-user.default.php');
				$shortcuts = $default['shortcuts'];
			}
			FreshRSS_Context::$user_conf->shortcuts = array_map('trim', $shortcuts);
			FreshRSS_Context::$user_conf->save();
			invalidateHttpCache();

			Minz_Request::good(_t('feedback.conf.shortcuts_updated'), array('c' => 'configure', 'a' => 'shortcut'));
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
	 *   - refresh frequency (default: 0)
	 */
	public function archivingAction() {
		if (Minz_Request::isPost()) {
			if (!Minz_Request::paramBoolean('enable_keep_max')) {
				$keepMax = false;
			} elseif (!$keepMax = Minz_Request::param('keep_max')) {
				$keepMax = FreshRSS_Feed::ARCHIVING_RETENTION_COUNT_LIMIT;
			}
			if (Minz_Request::paramBoolean('enable_keep_period')) {
				$keepPeriod = FreshRSS_Feed::ARCHIVING_RETENTION_PERIOD;
				if (is_numeric(Minz_Request::param('keep_period_count')) && preg_match('/^PT?1[YMWDH]$/', Minz_Request::param('keep_period_unit'))) {
					$keepPeriod = str_replace('1', Minz_Request::param('keep_period_count'), Minz_Request::param('keep_period_unit'));
				}
			} else {
				$keepPeriod = false;
			}

			FreshRSS_Context::$user_conf->ttl_default = Minz_Request::param('ttl_default', FreshRSS_Feed::TTL_DEFAULT);
			FreshRSS_Context::$user_conf->archiving = [
				'keep_period' => $keepPeriod,
				'keep_max' => $keepMax,
				'keep_min' => Minz_Request::param('keep_min_default', 0),
				'keep_favourites' => Minz_Request::paramBoolean('keep_favourites'),
				'keep_labels' => Minz_Request::paramBoolean('keep_labels'),
				'keep_unreads' => Minz_Request::paramBoolean('keep_unreads'),
			];
			FreshRSS_Context::$user_conf->keep_history_default = null;	//Legacy < FreshRSS 1.15
			FreshRSS_Context::$user_conf->old_entries = null;	//Legacy < FreshRSS 1.15
			FreshRSS_Context::$user_conf->save();
			invalidateHttpCache();

			Minz_Request::good(_t('feedback.conf.updated'), [ 'c' => 'configure', 'a' => 'archiving' ]);
		}

		$volatile = [
				'enable_keep_period' => false,
				'keep_period_count' => '3',
				'keep_period_unit' => 'P1M',
			];
		$keepPeriod = FreshRSS_Context::$user_conf->archiving['keep_period'];
		if (preg_match('/^PT?(?P<count>\d+)[YMWDH]$/', $keepPeriod, $matches)) {
			$volatile = [
				'enable_keep_period' => true,
				'keep_period_count' => $matches['count'],
				'keep_period_unit' => str_replace($matches['count'], 1, $keepPeriod),
			];
		}
		FreshRSS_Context::$user_conf->volatile = $volatile;

		$entryDAO = FreshRSS_Factory::createEntryDao();
		$this->view->nb_total = $entryDAO->count();

		$databaseDAO = FreshRSS_Factory::createDatabaseDAO();
		$this->view->size_user = $databaseDAO->size();

		if (FreshRSS_Auth::hasAccess('admin')) {
			$this->view->size_total = $databaseDAO->size(true);
		}

		Minz_View::prependTitle(_t('conf.archiving.title') . ' · ');
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
		Minz_View::appendScript(Minz_Url::display('/scripts/draggable.js?' . @filemtime(PUBLIC_PATH . '/scripts/draggable.js')));

		$category_dao = FreshRSS_Factory::createCategoryDao();
		$feed_dao = FreshRSS_Factory::createFeedDao();
		$tag_dao = FreshRSS_Factory::createTagDao();

		if (Minz_Request::isPost()) {
			$params = Minz_Request::param('queries', array());

			foreach ($params as $key => $query) {
				if (!$query['name']) {
					$query['name'] = _t('conf.query.number', $key + 1);
				}
				if ($query['search']) {
					$query['search'] = urldecode($query['search']);
				}
				$queries[] = new FreshRSS_UserQuery($query, $feed_dao, $category_dao, $tag_dao);
			}
			FreshRSS_Context::$user_conf->queries = $queries;
			FreshRSS_Context::$user_conf->save();

			Minz_Request::good(_t('feedback.conf.updated'), [ 'c' => 'configure', 'a' => 'queries' ]);
		} else {
			$this->view->queries = array();
			foreach (FreshRSS_Context::$user_conf->queries as $key => $query) {
				$this->view->queries[$key] = new FreshRSS_UserQuery($query, $feed_dao, $category_dao, $tag_dao);
			}
		}

		$this->view->categories = $category_dao->listCategories(false);
		$this->view->feeds = $feed_dao->listFeeds();
		$this->view->tags = $tag_dao->listTags();

		$id = Minz_Request::param('id');
		$this->view->displaySlider = false;
		if (false !== $id) {
			$this->view->displaySlider = true;
			$this->view->query = $this->view->queries[$id];
			$this->view->queryId = $id;
		}

		Minz_View::prependTitle(_t('conf.query.title') . ' · ');
	}

	/**
	 * Handles query configuration.
	 * It displays the query configuration page and handles modifications
	 * applied to the selected query.
	 */
	public function queryAction() {
		$this->view->_layout(false);

		$id = Minz_Request::param('id');
		if (false === $id || !isset(FreshRSS_Context::$user_conf->queries[$id])) {
			Minz_Error::error(404);
			return;
		}

		$category_dao = FreshRSS_Factory::createCategoryDao();
		$feed_dao = FreshRSS_Factory::createFeedDao();
		$tag_dao = FreshRSS_Factory::createTagDao();

		$query = new FreshRSS_UserQuery(FreshRSS_Context::$user_conf->queries[$id], $feed_dao, $category_dao, $tag_dao);
		$this->view->query = $query;
		$this->view->queryId = $id;
		$this->view->categories = $category_dao->listCategories(false);
		$this->view->feeds = $feed_dao->listFeeds();
		$this->view->tags = $tag_dao->listTags();

		if (Minz_Request::isPost()) {
			$params = array_filter(Minz_Request::param('query', []));
			if (!empty($params['search'])) {
				$params['search'] = htmlspecialchars_decode($params['search'], ENT_QUOTES);
			}
			if (!empty($params['state'])) {
				$params['state'] = array_sum($params['state']);
			}
			$params['url'] = Minz_Url::display(['params' => $params]);
			$name = Minz_Request::param('name', _t('conf.query.number', $id + 1));
			if ('' === $name) {
				$name = _t('conf.query.number', $id + 1);
			}
			$params['name'] = $name;

			$queries = FreshRSS_Context::$user_conf->queries;
			$queries[$id] = new FreshRSS_UserQuery($params, $feed_dao, $category_dao, $tag_dao);
			FreshRSS_Context::$user_conf->queries = $queries;
			FreshRSS_Context::$user_conf->save();

			Minz_Request::good(_t('feedback.conf.updated'), [ 'c' => 'configure', 'a' => 'queries', 'params' => ['id' => $id] ]);
		}

		Minz_View::prependTitle(_t('conf.query.title') . ' · ' . $query->getName() . ' · ');
	}

	/**
	 * Handles query deletion
	 */
	public function deleteQueryAction() {
		$id = Minz_Request::param('id');
		if (false === $id || !isset(FreshRSS_Context::$user_conf->queries[$id])) {
			Minz_Error::error(404);
			return;
		}

		$queries = FreshRSS_Context::$user_conf->queries;
		unset($queries[$id]);
		FreshRSS_Context::$user_conf->queries = $queries;
		FreshRSS_Context::$user_conf->save();

		Minz_Request::good(_t('feedback.conf.updated'), [ 'c' => 'configure', 'a' => 'queries' ]);
	}

	/**
	 * This action handles the creation of a user query.
	 *
	 * It gets the GET parameters and stores them in the configuration query
	 * storage. Before it is saved, the unwanted parameters are unset to keep
	 * lean data.
	 */
	public function bookmarkQueryAction() {
		$category_dao = FreshRSS_Factory::createCategoryDao();
		$feed_dao = FreshRSS_Factory::createFeedDao();
		$tag_dao = FreshRSS_Factory::createTagDao();
		$queries = array();
		foreach (FreshRSS_Context::$user_conf->queries as $key => $query) {
			$queries[$key] = new FreshRSS_UserQuery($query, $feed_dao, $category_dao, $tag_dao);
		}
		$params = $_GET;
		unset($params['rid']);
		$params['url'] = Minz_Url::display(array('params' => $params));
		$params['name'] = _t('conf.query.number', count($queries) + 1);
		$queries[] = new FreshRSS_UserQuery($params, $feed_dao, $category_dao, $tag_dao);

		FreshRSS_Context::$user_conf->queries = $queries;
		FreshRSS_Context::$user_conf->save();

		Minz_Request::good(_t('feedback.conf.query_created', $params['name']), [ 'c' => 'configure', 'a' => 'queries' ]);
	}

	/**
	 * This action handles the system configuration page.
	 *
	 * It displays the system configuration page.
	 * If this action is reach through a POST request, it stores all new
	 * configuration values then sends a notification to the user.
	 *
	 * The options available on the page are:
	 *   - instance name (default: FreshRSS)
	 *   - auto update URL (default: false)
	 *   - force emails validation (default: false)
	 *   - user limit (default: 1)
	 *   - user category limit (default: 16384)
	 *   - user feed limit (default: 16384)
	 *   - user login duration for form auth (default: FreshRSS_Auth::DEFAULT_COOKIE_DURATION)
	 *
	 * The `force-email-validation` is ignored with PHP < 5.5
	 */
	public function systemAction() {
		if (!FreshRSS_Auth::hasAccess('admin')) {
			Minz_Error::error(403);
		}

		if (Minz_Request::isPost()) {
			$limits = FreshRSS_Context::$system_conf->limits;
			$limits['max_registrations'] = Minz_Request::param('max-registrations', 1);
			$limits['max_feeds'] = Minz_Request::param('max-feeds', 16384);
			$limits['max_categories'] = Minz_Request::param('max-categories', 16384);
			$limits['cookie_duration'] = Minz_Request::param('cookie-duration', FreshRSS_Auth::DEFAULT_COOKIE_DURATION);
			FreshRSS_Context::$system_conf->limits = $limits;
			FreshRSS_Context::$system_conf->title = Minz_Request::param('instance-name', 'FreshRSS');
			FreshRSS_Context::$system_conf->auto_update_url = Minz_Request::param('auto-update-url', false);
			FreshRSS_Context::$system_conf->force_email_validation = Minz_Request::param('force-email-validation', false);
			FreshRSS_Context::$system_conf->save();

			invalidateHttpCache();

			Minz_Request::good(_t('feedback.conf.updated'), [ 'c' => 'configure', 'a' => 'system' ]);
		}
	}
}
