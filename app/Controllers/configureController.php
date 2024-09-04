<?php
declare(strict_types=1);

/**
 * Controller to handle every configuration options.
 */
class FreshRSS_configure_Controller extends FreshRSS_ActionController {
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
	 *   - darkMode (default: auto)
	 *   - content width (default: thin)
	 *   - display of read action in header
	 *   - display of favorite action in header
	 *   - display of date in header
	 *   - display of open action in header
	 *   - display of read action in footer
	 *   - display of favorite action in footer
	 *   - display of sharing action in footer
	 *   - display of article tags in footer
	 *   - display of my Labels in footer
	 *   - display of date in footer
	 *   - display of open action in footer
	 *   - html5 notification timeout (default: 0)
	 * Default values are false unless specified.
	 */
	public function displayAction(): void {
		if (Minz_Request::isPost()) {
			FreshRSS_Context::userConf()->language = Minz_Request::paramString('language') ?: 'en';
			FreshRSS_Context::userConf()->timezone = Minz_Request::paramString('timezone');
			FreshRSS_Context::userConf()->theme = Minz_Request::paramString('theme') ?: FreshRSS_Themes::$defaultTheme;
			FreshRSS_Context::userConf()->darkMode = Minz_Request::paramString('darkMode') ?: 'auto';
			FreshRSS_Context::userConf()->content_width = Minz_Request::paramString('content_width') ?: 'thin';
			FreshRSS_Context::userConf()->topline_read = Minz_Request::paramBoolean('topline_read');
			FreshRSS_Context::userConf()->topline_favorite = Minz_Request::paramBoolean('topline_favorite');
			FreshRSS_Context::userConf()->topline_sharing = Minz_Request::paramBoolean('topline_sharing');
			FreshRSS_Context::userConf()->topline_date = Minz_Request::paramBoolean('topline_date');
			FreshRSS_Context::userConf()->topline_link = Minz_Request::paramBoolean('topline_link');
			FreshRSS_Context::userConf()->topline_website = Minz_Request::paramString('topline_website');
			FreshRSS_Context::userConf()->topline_thumbnail = Minz_Request::paramString('topline_thumbnail');
			FreshRSS_Context::userConf()->topline_summary = Minz_Request::paramBoolean('topline_summary');
			FreshRSS_Context::userConf()->topline_display_authors = Minz_Request::paramBoolean('topline_display_authors');
			FreshRSS_Context::userConf()->bottomline_read = Minz_Request::paramBoolean('bottomline_read');
			FreshRSS_Context::userConf()->bottomline_favorite = Minz_Request::paramBoolean('bottomline_favorite');
			FreshRSS_Context::userConf()->bottomline_sharing = Minz_Request::paramBoolean('bottomline_sharing');
			FreshRSS_Context::userConf()->bottomline_tags = Minz_Request::paramBoolean('bottomline_tags');
			FreshRSS_Context::userConf()->bottomline_myLabels = Minz_Request::paramBoolean('bottomline_myLabels');
			FreshRSS_Context::userConf()->bottomline_date = Minz_Request::paramBoolean('bottomline_date');
			FreshRSS_Context::userConf()->bottomline_link = Minz_Request::paramBoolean('bottomline_link');
			FreshRSS_Context::userConf()->show_nav_buttons = Minz_Request::paramBoolean('show_nav_buttons');
			FreshRSS_Context::userConf()->html5_notif_timeout = Minz_Request::paramInt('html5_notif_timeout');
			FreshRSS_Context::userConf()->save();

			Minz_Session::_param('language', FreshRSS_Context::userConf()->language);
			Minz_Translate::reset(FreshRSS_Context::userConf()->language);
			invalidateHttpCache();

			Minz_Request::good(_t('feedback.conf.updated'), [ 'c' => 'configure', 'a' => 'display' ]);
		}

		$this->view->themes = FreshRSS_Themes::get();

		FreshRSS_View::prependTitle(_t('conf.display.title') . ' · ');
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
	 *       - focus
	 * Default values are false unless specified.
	 */
	public function readingAction(): void {
		if (Minz_Request::isPost()) {
			FreshRSS_Context::userConf()->posts_per_page = Minz_Request::paramInt('posts_per_page') ?: 10;
			FreshRSS_Context::userConf()->view_mode = Minz_Request::paramStringNull('view_mode', true) ?? 'normal';
			FreshRSS_Context::userConf()->default_view = Minz_Request::paramStringNull('default_view') ?? 'adaptive';
			FreshRSS_Context::userConf()->show_fav_unread = Minz_Request::paramBoolean('show_fav_unread');
			FreshRSS_Context::userConf()->auto_load_more = Minz_Request::paramBoolean('auto_load_more');
			FreshRSS_Context::userConf()->display_posts = Minz_Request::paramBoolean('display_posts');
			FreshRSS_Context::userConf()->display_categories = Minz_Request::paramStringNull('display_categories') ?? 'active';
			FreshRSS_Context::userConf()->show_tags = Minz_Request::paramStringNull('show_tags') ?? '0';
			FreshRSS_Context::userConf()->show_tags_max = Minz_Request::paramInt('show_tags_max');
			FreshRSS_Context::userConf()->show_author_date = Minz_Request::paramStringNull('show_author_date') ?? '0';
			FreshRSS_Context::userConf()->show_feed_name = Minz_Request::paramStringNull('show_feed_name') ?? 't';
			FreshRSS_Context::userConf()->show_article_icons = Minz_Request::paramStringNull('show_article_icons') ?? 't';
			FreshRSS_Context::userConf()->hide_read_feeds = Minz_Request::paramBoolean('hide_read_feeds');
			FreshRSS_Context::userConf()->onread_jump_next = Minz_Request::paramBoolean('onread_jump_next');
			FreshRSS_Context::userConf()->lazyload = Minz_Request::paramBoolean('lazyload');
			FreshRSS_Context::userConf()->sides_close_article = Minz_Request::paramBoolean('sides_close_article');
			FreshRSS_Context::userConf()->sticky_post = Minz_Request::paramBoolean('sticky_post');
			FreshRSS_Context::userConf()->reading_confirm = Minz_Request::paramBoolean('reading_confirm');
			FreshRSS_Context::userConf()->auto_remove_article = Minz_Request::paramBoolean('auto_remove_article');
			FreshRSS_Context::userConf()->mark_updated_article_unread = Minz_Request::paramBoolean('mark_updated_article_unread');
			if (in_array(Minz_Request::paramString('sort_order'), ['ASC', 'DESC'], true)) {
				FreshRSS_Context::userConf()->sort_order = Minz_Request::paramString('sort_order');
			} else {
				FreshRSS_Context::userConf()->sort_order = 'DESC';
			}
			FreshRSS_Context::userConf()->mark_when = [
				'article' => Minz_Request::paramBoolean('mark_open_article'),
				'gone' => Minz_Request::paramBoolean('read_upon_gone'),
				'max_n_unread' => Minz_Request::paramBoolean('enable_keep_max_n_unread') ? Minz_Request::paramInt('keep_max_n_unread') : false,
				'reception' => Minz_Request::paramBoolean('mark_upon_reception'),
				'same_title_in_feed' => Minz_Request::paramBoolean('enable_read_when_same_title_in_feed') ?
					Minz_Request::paramInt('read_when_same_title_in_feed') : false,
				'scroll' => Minz_Request::paramBoolean('mark_scroll'),
				'site' => Minz_Request::paramBoolean('mark_open_site'),
				'focus' => Minz_Request::paramBoolean('mark_focus'),
			];
			FreshRSS_Context::userConf()->_filtersAction('read', Minz_Request::paramTextToArray('filteractions_read'));
			FreshRSS_Context::userConf()->_filtersAction('star', Minz_Request::paramTextToArray('filteractions_star'));
			FreshRSS_Context::userConf()->save();
			invalidateHttpCache();

			Minz_Request::good(_t('feedback.conf.updated'), [ 'c' => 'configure', 'a' => 'reading' ]);
		}

		FreshRSS_View::prependTitle(_t('conf.reading.title') . ' · ');
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
	public function integrationAction(): void {
		FreshRSS_View::appendScript(Minz_Url::display('/scripts/integration.js?' . @filemtime(PUBLIC_PATH . '/scripts/integration.js')));
		FreshRSS_View::appendScript(Minz_Url::display('/scripts/draggable.js?' . @filemtime(PUBLIC_PATH . '/scripts/draggable.js')));

		if (Minz_Request::isPost()) {
			$params = $_POST;
			FreshRSS_Context::userConf()->sharing = $params['share'];
			FreshRSS_Context::userConf()->save();
			invalidateHttpCache();

			Minz_Request::good(_t('feedback.conf.updated'), [ 'c' => 'configure', 'a' => 'integration' ]);
		}

		FreshRSS_View::prependTitle(_t('conf.sharing.title') . ' · ');
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
	public function shortcutAction(): void {
		$this->view->list_keys = SHORTCUT_KEYS;

		if (Minz_Request::isPost()) {
			$shortcuts = Minz_Request::paramArray('shortcuts');
			if (Minz_Request::paramBoolean('load_default_shortcuts')) {
				$default = Minz_Configuration::load(FRESHRSS_PATH . '/config-user.default.php');
				$shortcuts = $default['shortcuts'];
			}
			/** @var array<string,string> $shortcuts */
			FreshRSS_Context::userConf()->shortcuts = array_map('trim', $shortcuts);
			FreshRSS_Context::userConf()->save();
			invalidateHttpCache();

			Minz_Request::good(_t('feedback.conf.shortcuts_updated'), ['c' => 'configure', 'a' => 'shortcut']);
		}

		FreshRSS_View::prependTitle(_t('conf.shortcut.title') . ' · ');
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
	public function archivingAction(): void {
		if (Minz_Request::isPost()) {
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

			FreshRSS_Context::userConf()->ttl_default = Minz_Request::paramInt('ttl_default') ?: FreshRSS_Feed::TTL_DEFAULT;
			FreshRSS_Context::userConf()->archiving = [
				'keep_period' => $keepPeriod,
				'keep_max' => $keepMax,
				'keep_min' => Minz_Request::paramInt('keep_min_default'),
				'keep_favourites' => Minz_Request::paramBoolean('keep_favourites'),
				'keep_labels' => Minz_Request::paramBoolean('keep_labels'),
				'keep_unreads' => Minz_Request::paramBoolean('keep_unreads'),
			];
			FreshRSS_Context::userConf()->keep_history_default = null;	//Legacy < FreshRSS 1.15
			FreshRSS_Context::userConf()->old_entries = null;	//Legacy < FreshRSS 1.15
			FreshRSS_Context::userConf()->save();
			invalidateHttpCache();

			Minz_Request::good(_t('feedback.conf.updated'), [ 'c' => 'configure', 'a' => 'archiving' ]);
		}

		$volatile = [
				'enable_keep_period' => false,
				'keep_period_count' => '3',
				'keep_period_unit' => 'P1M',
			];
		if (!empty(FreshRSS_Context::userConf()->archiving['keep_period'])) {
			$keepPeriod = FreshRSS_Context::userConf()->archiving['keep_period'];
			if (preg_match('/^PT?(?P<count>\d+)[YMWDH]$/', $keepPeriod, $matches)) {
				$volatile = [
					'enable_keep_period' => true,
					'keep_period_count' => $matches['count'],
					'keep_period_unit' => str_replace($matches['count'], '1', $keepPeriod),
				];
			}
		}
		FreshRSS_Context::userConf()->volatile = $volatile;

		$entryDAO = FreshRSS_Factory::createEntryDao();
		$this->view->nb_total = $entryDAO->count();

		$databaseDAO = FreshRSS_Factory::createDatabaseDAO();
		$this->view->size_user = $databaseDAO->size();

		if (FreshRSS_Auth::hasAccess('admin')) {
			$this->view->size_total = $databaseDAO->size(true);
		}

		FreshRSS_View::prependTitle(_t('conf.archiving.title') . ' · ');
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
	public function queriesAction(): void {
		FreshRSS_View::appendScript(Minz_Url::display('/scripts/draggable.js?' . @filemtime(PUBLIC_PATH . '/scripts/draggable.js')));

		if (Minz_Request::isPost()) {
			/** @var array<int,array{'get'?:string,'name'?:string,'order'?:string,'search'?:string,'state'?:int,'url'?:string,'token'?:string}> $params */
			$params = Minz_Request::paramArray('queries');

			$queries = [];
			foreach ($params as $key => $query) {
				$key = (int)$key;
				if (empty($query['name'])) {
					$query['name'] = _t('conf.query.number', $key + 1);
				}
				if (!empty($query['search'])) {
					$query['search'] = urldecode($query['search']);
				}
				$queries[$key] = (new FreshRSS_UserQuery($query, FreshRSS_Context::categories(), FreshRSS_Context::labels()))->toArray();
			}
			FreshRSS_Context::userConf()->queries = $queries;
			FreshRSS_Context::userConf()->save();

			Minz_Request::good(_t('feedback.conf.updated'), [ 'c' => 'configure', 'a' => 'queries' ]);
		} else {
			$this->view->queries = [];
			foreach (FreshRSS_Context::userConf()->queries as $key => $query) {
				$this->view->queries[intval($key)] = new FreshRSS_UserQuery($query, FreshRSS_Context::categories(), FreshRSS_Context::labels());
			}
		}

		$this->view->categories = FreshRSS_Context::categories();
		$this->view->feeds = FreshRSS_Context::feeds();
		$this->view->tags = FreshRSS_Context::labels();

		if (Minz_Request::paramTernary('id') !== null) {
			$id = Minz_Request::paramInt('id');
			$this->view->query = $this->view->queries[$id];
			$this->view->queryId = $id;
			$this->view->displaySlider = true;
		} else {
			$this->view->displaySlider = false;
		}

		FreshRSS_View::prependTitle(_t('conf.query.title') . ' · ');
	}

	/**
	 * Handles query configuration.
	 * It displays the query configuration page and handles modifications
	 * applied to the selected query.
	 */
	public function queryAction(): void {
		if (Minz_Request::paramBoolean('ajax')) {
			$this->view->_layout(null);
		}

		$id = Minz_Request::paramInt('id');
		if (Minz_Request::paramTernary('id') === null || empty(FreshRSS_Context::userConf()->queries[$id])) {
			Minz_Error::error(404);
			return;
		}

		$query = new FreshRSS_UserQuery(FreshRSS_Context::userConf()->queries[$id], FreshRSS_Context::categories(), FreshRSS_Context::labels());
		$this->view->query = $query;
		$this->view->queryId = $id;
		$this->view->categories = FreshRSS_Context::categories();
		$this->view->feeds = FreshRSS_Context::feeds();
		$this->view->tags = FreshRSS_Context::labels();

		if (Minz_Request::isPost()) {
			$params = array_filter(Minz_Request::paramArray('query'));
			$queryParams = [];
			$name = Minz_Request::paramString('name') ?: _t('conf.query.number', $id + 1);
			if ('' === $name) {
				$name = _t('conf.query.number', $id + 1);
			}
			if (!empty($params['get']) && is_string($params['get'])) {
				$queryParams['get'] = htmlspecialchars_decode($params['get'], ENT_QUOTES);
			}
			if (!empty($params['order']) && is_string($params['order'])) {
				$queryParams['order'] = htmlspecialchars_decode($params['order'], ENT_QUOTES);
			}
			if (!empty($params['search']) && is_string($params['search'])) {
				$queryParams['search'] = htmlspecialchars_decode($params['search'], ENT_QUOTES);
			}
			if (!empty($params['state']) && is_array($params['state'])) {
				$queryParams['state'] = (int)array_sum($params['state']);
			}
			if (empty($params['token']) || !is_string($params['token'])) {
				$queryParams['token'] = FreshRSS_UserQuery::generateToken($name);
			} else {
				$queryParams['token'] = $params['token'];
			}
			$queryParams['url'] = Minz_Url::display(['params' => $queryParams]);
			$queryParams['name'] = $name;
			if (!empty($params['description']) && is_string($params['description'])) {
				$queryParams['description'] = htmlspecialchars_decode($params['description'], ENT_QUOTES);
			}
			if (!empty($params['imageUrl']) && is_string($params['imageUrl'])) {
				$queryParams['imageUrl'] = $params['imageUrl'];
			}
			if (!empty($params['shareOpml']) && ctype_digit($params['shareOpml'])) {
				$queryParams['shareOpml'] = (bool)$params['shareOpml'];
			}
			if (!empty($params['shareRss']) && ctype_digit($params['shareRss'])) {
				$queryParams['shareRss'] = (bool)$params['shareRss'];
			}

			$queries = FreshRSS_Context::userConf()->queries;
			$queries[$id] = (new FreshRSS_UserQuery($queryParams, FreshRSS_Context::categories(), FreshRSS_Context::labels()))->toArray();
			FreshRSS_Context::userConf()->queries = $queries;
			FreshRSS_Context::userConf()->save();

			Minz_Request::good(_t('feedback.conf.updated'), [ 'c' => 'configure', 'a' => 'queries', 'params' => ['id' => (string)$id] ]);
		}

		FreshRSS_View::prependTitle($query->getName() . ' · ' . _t('conf.query.title') . ' · ');
	}

	/**
	 * Handles query deletion
	 */
	public function deleteQueryAction(): void {
		$id = Minz_Request::paramInt('id');
		if (Minz_Request::paramTernary('id') === null || empty(FreshRSS_Context::userConf()->queries[$id])) {
			Minz_Error::error(404);
			return;
		}

		$queries = FreshRSS_Context::userConf()->queries;
		unset($queries[$id]);
		FreshRSS_Context::userConf()->queries = $queries;
		FreshRSS_Context::userConf()->save();

		Minz_Request::good(_t('feedback.conf.updated'), [ 'c' => 'configure', 'a' => 'queries' ]);
	}

	/**
	 * This action handles the creation of a user query.
	 *
	 * It gets the GET parameters and stores them in the configuration query
	 * storage. Before it is saved, the unwanted parameters are unset to keep
	 * lean data.
	 */
	public function bookmarkQueryAction(): void {
		$queries = [];
		foreach (FreshRSS_Context::userConf()->queries as $key => $query) {
			$queries[$key] = (new FreshRSS_UserQuery($query, FreshRSS_Context::categories(), FreshRSS_Context::labels()))->toArray();
		}
		$params = $_GET;
		unset($params['name']);
		unset($params['rid']);
		$params['url'] = Minz_Url::display(['params' => $params]);
		$params['name'] = _t('conf.query.number', count($queries) + 1);
		$queries[] = (new FreshRSS_UserQuery($params, FreshRSS_Context::categories(), FreshRSS_Context::labels()))->toArray();

		FreshRSS_Context::userConf()->queries = $queries;
		FreshRSS_Context::userConf()->save();

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
	public function systemAction(): void {
		if (!FreshRSS_Auth::hasAccess('admin')) {
			Minz_Error::error(403);
		}

		if (Minz_Request::isPost()) {
			$limits = FreshRSS_Context::systemConf()->limits;
			$limits['max_registrations'] = Minz_Request::paramInt('max-registrations') ?: 1;
			$limits['max_feeds'] = Minz_Request::paramInt('max-feeds') ?: 16384;
			$limits['max_categories'] = Minz_Request::paramInt('max-categories') ?: 16384;
			$limits['cookie_duration'] = Minz_Request::paramInt('cookie-duration') ?: FreshRSS_Auth::DEFAULT_COOKIE_DURATION;
			FreshRSS_Context::systemConf()->limits = $limits;
			FreshRSS_Context::systemConf()->title = Minz_Request::paramString('instance-name') ?: 'FreshRSS';
			FreshRSS_Context::systemConf()->auto_update_url = Minz_Request::paramString('auto-update-url');
			FreshRSS_Context::systemConf()->force_email_validation = Minz_Request::paramBoolean('force-email-validation');
			FreshRSS_Context::systemConf()->save();

			invalidateHttpCache();

			Minz_Request::good(_t('feedback.conf.updated'), [ 'c' => 'configure', 'a' => 'system' ]);
		}
	}
}
