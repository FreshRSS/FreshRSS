<?php

namespace Freshrss\Controllers;

/**
 * Controller to handle every configuration options.
 */
class configure_Controller extends ActionController {
	/**
	 * This action is called before every other action in that class. It is
	 * the common boiler plate for every action. It is triggered by the
	 * underlying framework.
	 */
	public function firstAction() {
		if (!Auth::hasAccess()) {
			Error::error(403);
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
		if (Request::isPost()) {
			Context::$user_conf->language = Request::param('language', 'en');
			Context::$user_conf->theme = Request::param('theme', FreshRSS_Themes::$defaultTheme);
			Context::$user_conf->content_width = Request::param('content_width', 'thin');
			Context::$user_conf->topline_read = Request::param('topline_read', false);
			Context::$user_conf->topline_favorite = Request::param('topline_favorite', false);
			Context::$user_conf->topline_date = Request::param('topline_date', false);
			Context::$user_conf->topline_link = Request::param('topline_link', false);
			Context::$user_conf->topline_display_authors = Request::param('topline_display_authors', false);
			Context::$user_conf->bottomline_read = Request::param('bottomline_read', false);
			Context::$user_conf->bottomline_favorite = Request::param('bottomline_favorite', false);
			Context::$user_conf->bottomline_sharing = Request::param('bottomline_sharing', false);
			Context::$user_conf->bottomline_tags = Request::param('bottomline_tags', false);
			Context::$user_conf->bottomline_date = Request::param('bottomline_date', false);
			Context::$user_conf->bottomline_link = Request::param('bottomline_link', false);
			Context::$user_conf->html5_notif_timeout = Request::param('html5_notif_timeout', 0);
			Context::$user_conf->show_nav_buttons = Request::param('show_nav_buttons', false);
			Context::$user_conf->save();

			Session::_param('language', Context::$user_conf->language);
			Translate::reset(Context::$user_conf->language);
			invalidateHttpCache();

			Request::good(_t('feedback.conf.updated'),
			                   array('c' => 'configure', 'a' => 'display'));
		}

		$this->view->themes = Themes::get();

		View::prependTitle(_t('conf.display.title') . ' · ');
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
		if (Request::isPost()) {
			Context::$user_conf->posts_per_page = Request::param('posts_per_page', 10);
			Context::$user_conf->view_mode = Request::param('view_mode', 'normal');
			Context::$user_conf->default_view = Request::param('default_view', 'adaptive');
			Context::$user_conf->auto_load_more = Request::param('auto_load_more', false);
			Context::$user_conf->display_posts = Request::param('display_posts', false);
			Context::$user_conf->display_categories = Request::param('display_categories', false);
			Context::$user_conf->hide_read_feeds = Request::param('hide_read_feeds', false);
			Context::$user_conf->onread_jump_next = Request::param('onread_jump_next', false);
			Context::$user_conf->lazyload = Request::param('lazyload', false);
			Context::$user_conf->sides_close_article = Request::param('sides_close_article', false);
			Context::$user_conf->sticky_post = Request::param('sticky_post', false);
			Context::$user_conf->reading_confirm = Request::param('reading_confirm', false);
			Context::$user_conf->auto_remove_article = Request::param('auto_remove_article', false);
			Context::$user_conf->mark_updated_article_unread = Request::param('mark_updated_article_unread', false);
			Context::$user_conf->sort_order = Request::param('sort_order', 'DESC');
			Context::$user_conf->mark_when = array(
				'article' => Request::param('mark_open_article', false),
				'site' => Request::param('mark_open_site', false),
				'scroll' => Request::param('mark_scroll', false),
				'reception' => Request::param('mark_upon_reception', false),
			);
			Context::$user_conf->save();
			invalidateHttpCache();

			Request::good(_t('feedback.conf.updated'),
			                   array('c' => 'configure', 'a' => 'reading'));
		}

		View::prependTitle(_t('conf.reading.title') . ' · ');
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
		if (Request::isPost()) {
			$params = Request::fetchPOST();
			Context::$user_conf->sharing = $params['share'];
			Context::$user_conf->save();
			invalidateHttpCache();

			Request::good(_t('feedback.conf.updated'),
			                   array('c' => 'configure', 'a' => 'integration'));
		}

		View::prependTitle(_t('conf.sharing.title') . ' · ');
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

		if (Request::isPost()) {
			Context::$user_conf->shortcuts = validateShortcutList(Request::param('shortcuts'));
			Context::$user_conf->save();
			invalidateHttpCache();

			Request::good(_t('feedback.conf.shortcuts_updated'), array('c' => 'configure', 'a' => 'shortcut'));
		} else {
			Context::$user_conf->shortcuts = validateShortcutList(FreshRSS_Context::$user_conf->shortcuts);
		}

		View::prependTitle(_t('conf.shortcut.title') . ' · ');
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
		if (Request::isPost()) {
			if (!Request::paramBoolean('enable_keep_max')) {
				$keepMax = false;
			} elseif (!$keepMax = Request::param('keep_max')) {
				$keepMax = Feed::ARCHIVING_RETENTION_COUNT_LIMIT;
			}
			if ($enableRetentionPeriod = Request::paramBoolean('enable_keep_period')) {
				$keepPeriod = Feed::ARCHIVING_RETENTION_PERIOD;
				if (is_numeric(Request::param('keep_period_count')) && preg_match('/^PT?1[YMWDH]$/', Minz_Request::param('keep_period_unit'))) {
					$keepPeriod = str_replace('1', Request::param('keep_period_count'), Minz_Request::param('keep_period_unit'));
				}
			} else {
				$keepPeriod = false;
			}

			Context::$user_conf->ttl_default = Request::param('ttl_default', FreshRSS_Feed::TTL_DEFAULT);
			Context::$user_conf->archiving = [
				'keep_period' => $keepPeriod,
				'keep_max' => $keepMax,
				'keep_min' => Request::param('keep_min_default', 0),
				'keep_favourites' => Request::paramBoolean('keep_favourites'),
				'keep_labels' => Request::paramBoolean('keep_labels'),
				'keep_unreads' => Request::paramBoolean('keep_unreads'),
			];
			Context::$user_conf->keep_history_default = null;	//Legacy < FreshRSS 1.15
			Context::$user_conf->old_entries = null;	//Legacy < FreshRSS 1.15
			Context::$user_conf->save();
			invalidateHttpCache();

			Request::good(_t('feedback.conf.updated'),
			                   array('c' => 'configure', 'a' => 'archiving'));
		}

		$volatile = [
				'enable_keep_period' => false,
				'keep_period_count' => '3',
				'keep_period_unit' => 'P1M',
			];
		$keepPeriod = Context::$user_conf->archiving['keep_period'];
		if (preg_match('/^PT?(?P<count>\d+)[YMWDH]$/', $keepPeriod, $matches)) {
			$volatile = [
				'enable_keep_period' => true,
				'keep_period_count' => $matches['count'],
				'keep_period_unit' => str_replace($matches['count'], 1, $keepPeriod),
			];
		}
		Context::$user_conf->volatile = $volatile;

		$entryDAO = Factory::createEntryDao();
		$this->view->nb_total = $entryDAO->count();

		$databaseDAO = Factory::createDatabaseDAO();
		$this->view->size_user = $databaseDAO->size();

		if (Auth::hasAccess('admin')) {
			$this->view->size_total = $databaseDAO->size(true);
		}

		View::prependTitle(_t('conf.archiving.title') . ' · ');
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
		$category_dao = Factory::createCategoryDao();
		$feed_dao = Factory::createFeedDao();
		$tag_dao = Factory::createTagDao();
		if (Request::isPost()) {
			$params = Request::param('queries', array());

			foreach ($params as $key => $query) {
				if (!$query['name']) {
					$query['name'] = _t('conf.query.number', $key + 1);
				}
				$queries[] = new UserQuery($query, $feed_dao, $category_dao);
			}
			Context::$user_conf->queries = $queries;
			Context::$user_conf->save();

			Request::good(_t('feedback.conf.updated'),
			                   array('c' => 'configure', 'a' => 'queries'));
		} else {
			$this->view->queries = array();
			foreach (Context::$user_conf->queries as $key => $query) {
				$this->view->queries[$key] = new UserQuery($query, $feed_dao, $category_dao);
			}
		}

		View::prependTitle(_t('conf.query.title') . ' · ');
	}

	/**
	 * This action handles the creation of a user query.
	 *
	 * It gets the GET parameters and stores them in the configuration query
	 * storage. Before it is saved, the unwanted parameters are unset to keep
	 * lean data.
	 */
	public function addQueryAction() {
		$category_dao = Factory::createCategoryDao();
		$feed_dao = Factory::createFeedDao();
		$tag_dao = Factory::createTagDao();
		$queries = array();
		foreach (Context::$user_conf->queries as $key => $query) {
			$queries[$key] = new UserQuery($query, $feed_dao, $category_dao, $tag_dao);
		}
		$params = Request::fetchGET();
		$params['url'] = Url::display(array('params' => $params));
		$params['name'] = _t('conf.query.number', count($queries) + 1);
		$queries[] = new UserQuery($params, $feed_dao, $category_dao, $tag_dao);

		Context::$user_conf->queries = $queries;
		Context::$user_conf->save();

		Request::good(_t('feedback.conf.query_created', $query['name']),
		                   array('c' => 'configure', 'a' => 'queries'));
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
	 *   - user login duration for form auth (default: 2592000)
	 *
	 * The `force-email-validation` is ignored with PHP < 5.5
	 */
	public function systemAction() {
		if (!Auth::hasAccess('admin')) {
			Error::error(403);
		}

		$can_enable_email_validation = version_compare(PHP_VERSION, '5.5') >= 0;
		$this->view->can_enable_email_validation = $can_enable_email_validation;

		if (Request::isPost()) {
			$limits = Context::$system_conf->limits;
			$limits['max_registrations'] = Request::param('max-registrations', 1);
			$limits['max_feeds'] = Request::param('max-feeds', 16384);
			$limits['max_categories'] = Request::param('max-categories', 16384);
			$limits['cookie_duration'] = Request::param('cookie-duration', 2592000);
			Context::$system_conf->limits = $limits;
			Context::$system_conf->title = Request::param('instance-name', 'FreshRSS');
			Context::$system_conf->auto_update_url = Request::param('auto-update-url', false);
			if ($can_enable_email_validation) {
				Context::$system_conf->force_email_validation = Request::param('force-email-validation', false);
			}
			Context::$system_conf->save();

			invalidateHttpCache();

			Session::_param('notification', array(
				'type' => 'good',
				'content' => _t('feedback.conf.updated')
			));
		}
	}
}
