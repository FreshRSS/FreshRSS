<?php
declare(strict_types=1);

namespace FreshRss\Controllers;

use FreshRss\Minz\Configuration;
use FreshRss\Minz\Error;
use FreshRss\Minz\Request;
use FreshRss\Minz\Session;
use FreshRss\Minz\Translate;
use FreshRss\Minz\Url;
use FreshRss\Models\ActionController;
use FreshRss\Models\Auth;
use FreshRss\Models\Context;
use FreshRss\Models\Factory;
use FreshRss\Models\Feed;
use FreshRss\Models\Themes;
use FreshRss\Models\UserQuery;
use FreshRss\Models\View;
use FreshRss\Models\ViewMode;

/**
 * Controller to handle every configuration options.
 */
class ConfigureController extends ActionController {
	/**
	 * This action is called before every other action in that class. It is
	 * the common boilerplate for every action. It is triggered by the
	 * underlying framework.
	 */
	#[\Override]
	public function firstAction(): void {
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
	 *   - display of feed title (default: above title)
	 *   - display of authors and date (default: none)
	 *   - display of article icons position (default: above title)
	 *   - display of tags (default: none)
	 *   - html5 notification timeout (default: 0)
	 * Default values are false unless specified.
	 */
	public function displayAction(): void {
		if (Request::isPost()) {
			$language = Request::paramString('language') ?: Translate::DEFAULT_LANGUAGE;
			if (Translate::exists($language)) {
				Context::userConf()->language = $language;
			}
			Context::userConf()->timezone = Request::paramString('timezone');
			$theme = Request::paramString('theme') ?: Themes::$defaultTheme;
			if (Themes::exists($theme)) {
				Context::userConf()->theme = $theme;
			}
			Context::userConf()->darkMode = Request::paramString('darkMode') ?: 'auto';
			Context::userConf()->content_width = Request::paramString('content_width') ?: 'thin';
			Context::userConf()->topline_read = Request::paramBoolean('topline_read');
			Context::userConf()->topline_favorite = Request::paramBoolean('topline_favorite');
			Context::userConf()->topline_myLabels = Request::paramBoolean('topline_myLabels');
			Context::userConf()->topline_sharing = Request::paramBoolean('topline_sharing');
			Context::userConf()->topline_date = Request::paramBoolean('topline_date');
			Context::userConf()->topline_link = Request::paramBoolean('topline_link');
			Context::userConf()->topline_website = Request::paramString('topline_website');
			Context::userConf()->topline_thumbnail = Request::paramString('topline_thumbnail');
			Context::userConf()->topline_summary = Request::paramBoolean('topline_summary');
			Context::userConf()->topline_display_authors = Request::paramBoolean('topline_display_authors');
			Context::userConf()->show_tags = Request::paramStringNull('show_tags') ?? '0';
			Context::userConf()->show_tags_max = Request::paramInt('show_tags_max');
			Context::userConf()->show_author_date = Request::paramStringNull('show_author_date') ?? '0';
			Context::userConf()->show_feed_name = Request::paramStringNull('show_feed_name') ?? 't';
			Context::userConf()->show_article_icons = Request::paramStringNull('show_article_icons') ?? 't';
			Context::userConf()->bottomline_read = Request::paramBoolean('bottomline_read');
			Context::userConf()->bottomline_favorite = Request::paramBoolean('bottomline_favorite');
			Context::userConf()->bottomline_sharing = Request::paramBoolean('bottomline_sharing');
			Context::userConf()->bottomline_tags = Request::paramBoolean('bottomline_tags');
			Context::userConf()->bottomline_myLabels = Request::paramBoolean('bottomline_myLabels');
			Context::userConf()->bottomline_date = Request::paramBoolean('bottomline_date');
			Context::userConf()->bottomline_link = Request::paramBoolean('bottomline_link');
			Context::userConf()->show_nav_buttons = Request::paramBoolean('show_nav_buttons');
			Context::userConf()->show_title_unread = Request::paramBoolean('show_title_unread');
			$showUnreadCount = Request::paramString('show_unread_count');
			if (in_array($showUnreadCount, ['all', 'important', 'none'], true)) {
				Context::userConf()->show_unread_count = $showUnreadCount;
			}
			Context::userConf()->sidebar_hidden_by_default = Request::paramBoolean('sidebar_hidden_by_default');
			Context::userConf()->html5_notif_timeout = max(0, Request::paramInt('html5_notif_timeout'));
			Context::userConf()->html5_enable_notif = Request::paramBoolean('html5_enable_notif');
			Context::userConf()->good_notification_timeout = max(0, Request::paramInt('good_notification_timeout'));
			Context::userConf()->bad_notification_timeout = max(1, Request::paramInt('bad_notification_timeout'));
			Context::userConf()->save();

			Session::_param('language', Context::userConf()->language);
			Translate::reset(Context::userConf()->language);
			invalidateHttpCache();

			Request::good(
				_t('feedback.conf.updated'),
				[ 'c' => 'configure', 'a' => 'display' ],
				notificationName: 'displayAction',
				showNotification: Context::userConf()->good_notification_timeout > 0);
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
	 *       - focus
	 * Default values are false unless specified.
	 */
	public function readingAction(): void {
		if (Request::isPost()) {
			Context::userConf()->posts_per_page = Request::paramInt('posts_per_page') ?: 10;
			Context::userConf()->view_mode = Request::paramStringNull('view_mode', true) ?? 'normal';
			Context::userConf()->default_view = Request::paramStringNull('default_view') ?? 'adaptive';
			Context::userConf()->show_fav_unread = Request::paramBoolean('show_fav_unread');
			Context::userConf()->auto_load_more = Request::paramBoolean('auto_load_more');
			Context::userConf()->display_posts = Request::paramBoolean('display_posts');
			Context::userConf()->display_categories = Request::paramStringNull('display_categories') ?? 'active';
			Context::userConf()->hide_read_feeds = Request::paramBoolean('hide_read_feeds');
			Context::userConf()->onread_jump_next = Request::paramBoolean('onread_jump_next');
			Context::userConf()->lazyload = Request::paramBoolean('lazyload');
			Context::userConf()->sides_close_article = Request::paramBoolean('sides_close_article');
			Context::userConf()->sticky_post = Request::paramBoolean('sticky_post');
			Context::userConf()->sticky_sort = Request::paramBoolean('sticky_sort');
			$markReadButton = Request::paramStringNull('mark_read_button', plaintext: true);
			Context::userConf()->mark_read_button = in_array($markReadButton, ['big', 'small', 'none'], true) ? $markReadButton : 'big';
			Context::userConf()->reading_confirm = Request::paramBoolean('reading_confirm');
			Context::userConf()->auto_remove_article = Request::paramBoolean('auto_remove_article');
			Context::userConf()->mark_updated_article_unread = Request::paramBoolean('mark_updated_article_unread');

			$sorting = Request::paramString('primary_sort', plaintext: true);
			if (str_ends_with($sorting, '_asc')) {
				Context::userConf()->sort_order = 'ASC';
				$sorting = substr($sorting, 0, -strlen('_asc'));
			} elseif (str_ends_with($sorting, '_desc')) {
				Context::userConf()->sort_order = 'DESC';
				$sorting = substr($sorting, 0, -strlen('_desc'));
			} else {
				Context::userConf()->sort_order = 'DESC';
			}
			if (in_array($sorting, ['id', 'c.name', 'date', 'f.name', 'length', 'link', 'title', 'rand'], true)) {
				Context::userConf()->sort = $sorting;
			} else {
				Context::userConf()->sort = 'id';
			}

			$sorting = Request::paramString('secondary_sort', plaintext: true);
			if (str_ends_with($sorting, '_asc')) {
				Context::userConf()->secondary_sort_order = 'ASC';
				$sorting = substr($sorting, 0, -strlen('_asc'));
			} elseif (str_ends_with($sorting, '_desc')) {
				Context::userConf()->secondary_sort_order = 'DESC';
				$sorting = substr($sorting, 0, -strlen('_desc'));
			} else {
				Context::userConf()->secondary_sort_order = 'DESC';
			}
			if (in_array($sorting, ['id', 'date', 'link', 'title'], true)) {
				Context::userConf()->secondary_sort = $sorting;
			} else {
				Context::userConf()->secondary_sort = 'id';
			}

			Context::userConf()->mark_when = [
				'article' => Request::paramBoolean('mark_open_article'),
				'gone' => Request::paramBoolean('read_upon_gone'),
				'max_n_unread' => Request::paramBoolean('enable_keep_max_n_unread') ? Request::paramInt('keep_max_n_unread') : false,
				'reception' => Request::paramBoolean('mark_upon_reception'),
				'same_title_in_feed' => Request::paramBoolean('enable_read_when_same_title_in_feed') ?
					Request::paramInt('read_when_same_title_in_feed') : false,
				'scroll' => Request::paramBoolean('mark_scroll'),
				'site' => Request::paramBoolean('mark_open_site'),
				'focus' => Request::paramBoolean('mark_focus'),
			];
			Context::userConf()->_filtersAction('read', Request::paramTextToArray('filteractions_read', plaintext: true));
			Context::userConf()->_filtersAction('star', Request::paramTextToArray('filteractions_star', plaintext: true));
			Context::userConf()->save();
			invalidateHttpCache();

			Request::good(
				_t('feedback.conf.updated'),
				[ 'c' => 'configure', 'a' => 'reading' ],
				showNotification: Context::userConf()->good_notification_timeout > 0
			);
		}

		$this->view->viewModes = ViewMode::getAllModes();
		View::prependTitle(_t('conf.reading.title') . ' · ');
	}

	public function viewFilterAction(): void {
		$search = '';
		$filters_name = Request::paramString('filters_name', plaintext: true);
		$filteractions = Request::paramTextToArray($filters_name, plaintext: true);
		$filteractions = array_map(fn(string $action): string => trim($action), $filteractions);
		$filteractions = array_filter($filteractions, fn(string $action): bool => $action !== '');
		foreach ($filteractions as $action) {
			$search .= "($action) OR ";
		}
		$search = preg_replace('/ OR $/', '', $search);
		Request::forward([
			'c' => 'index',
			'a' => 'index',
			'params' => [
				'search' => $search,
			],
		], redirect: true);
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
		View::appendScript(Url::display('/scripts/integration.js?' . @filemtime(PUBLIC_PATH . '/scripts/integration.js')));
		View::appendScript(Url::display('/scripts/draggable.js?' . @filemtime(PUBLIC_PATH . '/scripts/draggable.js')));

		if (Request::isPost()) {
			$share = $_POST['share'] ?? [];
			if (is_array($share)) {
				$share = array_filter($share, fn($value, $key): bool =>
					is_int($key) && is_array($value) &&
					is_array_values_string($value),
					ARRAY_FILTER_USE_BOTH);
				/** @var array<int,array<string,string>> $share */
				Context::userConf()->sharing = $share;
				Context::userConf()->save();
				invalidateHttpCache();
			}

			Request::good(
				_t('feedback.conf.updated'),
				[ 'c' => 'configure', 'a' => 'integration' ],
				showNotification: Context::userConf()->good_notification_timeout > 0
			);
		}

		View::prependTitle(_t('conf.sharing.title') . ' · ');
	}

	private const SHORTCUT_KEYS = [
			'0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
			'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
			'F1', 'F2', 'F3', 'F4', 'F5', 'F6', 'F7', 'F8', 'F9', 'F10', 'F11', 'F12',
			'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowUp', 'Backspace', 'Delete',
			'End', 'Enter', 'Escape', 'Home', 'Insert', 'PageDown', 'PageUp', 'Space', 'Tab',
		];

	/**
	 * @param array<string> $shortcuts
	 * @return list<string>
	 */
	public static function getNonStandardShortcuts(array $shortcuts): array {
		$standard = strtolower(implode(' ', self::SHORTCUT_KEYS));

		$nonStandard = array_filter($shortcuts, static function (string $shortcut) use ($standard) {
			$shortcut = trim($shortcut);
			return $shortcut !== '' && stripos($standard, $shortcut) === false;
		});

		return array_values($nonStandard);
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
		$this->view->list_keys = self::SHORTCUT_KEYS;

		if (Request::isPost()) {
			$shortcuts = Request::paramArray('shortcuts', plaintext: true);
			if (Request::paramBoolean('load_default_shortcuts')) {
				$default = Configuration::load(FRESHRSS_PATH . '/config-user.default.php');
				$shortcuts = $default['shortcuts'];
			}
			/** @var array<string,string> $shortcuts */
			Context::userConf()->shortcuts = array_map('trim', $shortcuts);
			Context::userConf()->save();
			invalidateHttpCache();

			Request::good(
				_t('feedback.conf.shortcuts_updated'),
				['c' => 'configure', 'a' => 'shortcut'],
				showNotification: Context::userConf()->good_notification_timeout > 0
			);
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
	public function archivingAction(): void {
		if (Request::isPost()) {
			if (Request::paramBoolean('enable_keep_max')) {
				$keepMax = Request::paramInt('keep_max') ?: Feed::ARCHIVING_RETENTION_COUNT_LIMIT;
			} else {
				$keepMax = false;
			}
			if (Request::paramBoolean('enable_keep_period')) {
				$keepPeriod = Feed::ARCHIVING_RETENTION_PERIOD;
				if (is_numeric(Request::paramString('keep_period_count')) && preg_match('/^PT?1[YMWDH]$/', Request::paramString('keep_period_unit'))) {
					$keepPeriod = str_replace('1', Request::paramString('keep_period_count'), Request::paramString('keep_period_unit'));
				}
			} else {
				$keepPeriod = false;
			}

			Context::userConf()->ttl_default = Request::paramInt('ttl_default') ?: Feed::TTL_DEFAULT;
			Context::userConf()->archiving = [
				'keep_period' => $keepPeriod,
				'keep_max' => $keepMax,
				'keep_min' => Request::paramInt('keep_min_default'),
				'keep_favourites' => Request::paramBoolean('keep_favourites'),
				'keep_labels' => Request::paramBoolean('keep_labels'),
				'keep_unreads' => Request::paramBoolean('keep_unreads'),
			];
			Context::userConf()->keep_history_default = null;	//Legacy < FreshRSS 1.15
			Context::userConf()->old_entries = null;	//Legacy < FreshRSS 1.15
			Context::userConf()->save();
			invalidateHttpCache();

			Request::good(
				_t('feedback.conf.updated'),
				[ 'c' => 'configure', 'a' => 'archiving' ],
				showNotification: Context::userConf()->good_notification_timeout > 0
			);
		}

		$volatile = [
				'enable_keep_period' => false,
				'keep_period_count' => '3',
				'keep_period_unit' => 'P1M',
			];
		if (!empty(Context::userConf()->archiving['keep_period'])) {
			$keepPeriod = Context::userConf()->archiving['keep_period'];
			if (preg_match('/^PT?(?P<count>\d+)[YMWDH]$/', $keepPeriod, $matches)) {
				$volatile = [
					'enable_keep_period' => true,
					'keep_period_count' => $matches['count'],
					'keep_period_unit' => str_replace($matches['count'], '1', $keepPeriod),
				];
			}
		}
		Context::userConf()->volatile = $volatile;

		$entryDAO = Factory::createEntryDao();
		$this->view->nb_total = $entryDAO->count();

		$databaseDAO = Factory::createDatabaseDAO();
		$this->view->size_user = $databaseDAO->size();

		if (Auth::hasAccess('admin')) {
			$this->view->size_total = $databaseDAO->size(all: true);
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
	 * configuration page and verifies that every user query is runnable by
	 * checking if categories and feeds are still in use.
	 */
	public function queriesAction(): void {
		View::appendScript(Url::display('/scripts/draggable.js?' . @filemtime(PUBLIC_PATH . '/scripts/draggable.js')));

		if (Request::isPost()) {
			/** @var array<int,array{get?:string,name?:string,order?:string,search?:string,state?:int,url?:string,token?:string,
			 * 		shareRss?:bool|numeric-string,shareOpml?:bool|numeric-string,description?:string,imageUrl?:string}> $params */
			$params = Request::paramArray('queries');

			$queries = [];
			foreach ($params as $key => $query) {
				$key = (int)$key;
				if (empty($query['name'])) {
					$query['name'] = _t('conf.query.number', $key + 1);
				}
				if (!empty($query['search'])) {
					$query['search'] = urldecode($query['search']);
				}
				$shareRss = $query['shareRss'] ?? null;
				$query['shareRss'] = (is_string($shareRss) && ctype_digit($shareRss)) ? (bool)$shareRss : false;
				$shareOpml = $query['shareOpml'] ?? null;
				$query['shareOpml'] = (is_string($shareOpml) && ctype_digit($shareOpml)) ? (bool)$shareOpml : false;
				$queries[$key] = (new UserQuery($query, Context::categories(), Context::labels()))->toArray();
			}
			Context::userConf()->queries = $queries;
			Context::userConf()->save();

			Request::good(
				_t('feedback.conf.updated'),
				[ 'c' => 'configure', 'a' => 'queries' ],
				showNotification: Context::userConf()->good_notification_timeout > 0
			);
		} else {
			$this->view->queries = [];
			foreach (Context::userConf()->queries as $key => $query) {
				$this->view->queries[intval($key)] = new UserQuery($query, Context::categories(), Context::labels());
			}
		}

		$this->view->categories = Context::categories();
		$this->view->feeds = Context::feeds();
		$this->view->tags = Context::labels();

		if (Request::paramTernary('id') !== null) {
			$id = Request::paramInt('id');
			$this->view->query = $this->view->queries[$id];
			$this->view->queryId = $id;
			$this->view->displaySlider = true;
		} else {
			$this->view->displaySlider = false;
		}

		View::prependTitle(_t('conf.query.title') . ' · ');
	}

	/**
	 * Handles query configuration.
	 * It displays the query configuration page and handles modifications
	 * applied to the selected query.
	 */
	public function queryAction(): void {
		if (Request::paramBoolean('ajax')) {
			$this->view->_layout(null);
		}

		$id = Request::paramInt('id');
		if (Request::paramTernary('id') === null || empty(Context::userConf()->queries[$id])) {
			Error::error(404);
			return;
		}

		$query = new UserQuery(Context::userConf()->queries[$id], Context::categories(), Context::labels());
		$this->view->query = $query;
		$this->view->queryId = $id;
		$this->view->categories = Context::categories();
		$this->view->feeds = Context::feeds();
		$this->view->tags = Context::labels();

		if (Request::isPost()) {
			$params = Request::paramArray('query');
			$queryParams = [];
			$name = Request::paramString('name') ?: _t('conf.query.number', $id + 1);
			if ('' === $name) {
				$name = _t('conf.query.number', $id + 1);
			}
			if (!empty($params['get']) && is_string($params['get'])) {
				$queryParams['get'] = $params['get'];
			}
			if (!empty($params['order']) && is_string($params['order'])) {
				$queryParams['order'] = $params['order'];
			}
			if (!empty($params['search']) && is_string($params['search'])) {
				// Search must be as plain text to be XML-encoded or URL-encoded depending on the situation
				$queryParams['search'] = htmlspecialchars_decode($params['search'], ENT_QUOTES);
			}
			if (!empty($params['state']) && is_array($params['state'])) {
				$queryParams['state'] = (int)array_sum(array_map('intval', $params['state']));
			}
			if (empty($params['token']) || !is_string($params['token'])) {
				$queryParams['token'] = UserQuery::generateToken($name);
			} else {
				$queryParams['token'] = $params['token'];
			}
			$queryParams['url'] = Url::display(['params' => $queryParams]);
			$queryParams['name'] = $name;
			if (!empty($params['description']) && is_string($params['description'])) {
				$queryParams['description'] = $params['description'];
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
			if (!empty($params['publishLabelsInsteadOfTags']) && ctype_digit($params['publishLabelsInsteadOfTags'])) {
				$queryParams['publishLabelsInsteadOfTags'] = (bool)$params['publishLabelsInsteadOfTags'];
			}

			$queries = Context::userConf()->queries;
			$queries[$id] = (new UserQuery($queryParams, Context::categories(), Context::labels()))->toArray();
			Context::userConf()->queries = $queries;
			Context::userConf()->save();

			Request::good(
				_t('feedback.conf.updated'),
				[ 'c' => 'configure', 'a' => Request::paramStringNull('from') ?? 'queries', 'params' => ['id' => (string)$id] ],
				showNotification: Context::userConf()->good_notification_timeout > 0);
		}

		View::prependTitle($query->getName() . ' · ' . _t('conf.query.title') . ' · ');
	}

	/**
	 * Handles query deletion
	 */
	public function deleteQueryAction(): void {
		if (!Request::isPost()) {
			Error::error(403);
			return;
		}
		$id = Request::paramInt('id');
		if (Request::paramTernary('id') === null || empty(Context::userConf()->queries[$id])) {
			Error::error(404);
			return;
		}

		$queries = Context::userConf()->queries;
		unset($queries[$id]);
		Context::userConf()->queries = $queries;
		Context::userConf()->save();

		Request::good(
			_t('feedback.conf.updated'),
			[ 'c' => 'configure', 'a' => 'queries' ],
			showNotification: Context::userConf()->good_notification_timeout > 0
		);
	}

	/**
	 * This action handles the creation of a user query.
	 *
	 * It gets the GET or POST parameters and stores them in the configuration query
	 * storage.
	 */
	public function bookmarkQueryAction(): void {
		if (!Request::isPost()) {
			Error::error(403);
			return;
		}

		$queries = Context::userConf()->queries;
		$id = count($queries);

		/** @var array{get?:string,name?:string,order?:string,search?:string,state?:int,shareRss?:bool,shareOpml?:bool,description?:string,imageUrl?:string} $params */
		$params = Request::paramArray('query') ?: array_filter($_GET, 'is_string', ARRAY_FILTER_USE_KEY);
		$name = ($params['name'] ?? '') ?: _t('conf.query.number', $id + 1);
		$queryParams = [];

		if (is_string($params['get'] ?? null)) {
			$queryParams['get'] = $params['get'];
		}
		if (is_string($params['order'] ?? null)) {
			$queryParams['order'] = $params['order'];
		}
		if (is_string($params['search'] ?? null)) {
			// Search must be as plain text to be XML-encoded or URL-encoded depending on the situation
			$queryParams['search'] = htmlspecialchars_decode($params['search'], ENT_QUOTES);
		}
		if (is_array($params['state'] ?? null)) {
			$queryParams['state'] = (int)array_sum(array_map('intval', $params['state']));
		}
		$queryParams['token'] = UserQuery::generateToken($name);
		$queryParams['url'] = Url::display(['params' => $queryParams]);
		$queryParams['name'] = $name;
		if (is_string($params['description'] ?? null)) {
			$queryParams['description'] = $params['description'];
		}
		if (is_string($params['imageUrl'] ?? null)) {
			$queryParams['imageUrl'] = $params['imageUrl'];
		}
		if (ctype_digit($params['shareOpml'] ?? '')) {
			$queryParams['shareOpml'] = (bool)$params['shareOpml'];
		}
		if (ctype_digit($params['shareRss'] ?? '')) {
			$queryParams['shareRss'] = (bool)$params['shareRss'];
		}

		$queries[$id] = (new UserQuery($queryParams, Context::categories(), Context::labels()))->toArray();

		Context::userConf()->queries = $queries;
		Context::userConf()->save();

		Request::good(
			_t('feedback.conf.query_created', $name),
			[ 'c' => 'configure', 'a' => 'queries' ],
			showNotification: Context::userConf()->good_notification_timeout > 0
		);
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
	 *   - user login duration for form auth (default: Auth::DEFAULT_COOKIE_DURATION)
	 *   - internal host allowlist
	 */
	public function systemAction(): void {
		if (!Auth::hasAccess('admin')) {
			Error::error(403);
		}

		if (Request::isPost()) {
			$limits = Context::systemConf()->limits;
			$limits['max_registrations'] = Request::paramIntNull('max-registrations') ?? 1;
			$limits['max_feeds'] = Request::paramInt('max-feeds') ?: 16384;
			$limits['max_categories'] = Request::paramInt('max-categories') ?: 16384;
			$limits['cookie_duration'] = Request::paramInt('cookie-duration') ?: Auth::DEFAULT_COOKIE_DURATION;
			Context::systemConf()->limits = $limits;
			Context::systemConf()->title = Request::paramString('instance-name') ?: 'FreshRSS';
			Context::systemConf()->force_email_validation = Request::paramBoolean('force-email-validation');
			$internal_host_allowlist = Request::paramTextToArrayNull('internal-host-allowlist');
			if ($internal_host_allowlist !== null) {
				Context::systemConf()->internal_host_allowlist = Request::paramTextToArray('internal-host-allowlist');
			}
			Context::systemConf()->closed_registration_message = Request::paramString('closed_registration_message') ?: '';
			Context::systemConf()->save();

			invalidateHttpCache();

			Request::good(
				_t('feedback.conf.updated'),
				[ 'c' => 'configure', 'a' => 'system' ],
				showNotification: Context::userConf()->good_notification_timeout > 0
			);
		}
	}

	public function privacyAction(): void {
		if (Request::isPost()) {
			Context::userConf()->retrieve_extension_list = Request::paramBoolean('retrieve_extension_list');
			Context::userConf()->send_referrer_allowlist = Request::paramTextToArray('send_referrer_allowlist');
			Context::userConf()->save();
			invalidateHttpCache();

			Request::good(
				_t('feedback.conf.updated'),
				['c' => 'configure', 'a' => 'privacy'],
				showNotification: Context::userConf()->good_notification_timeout > 0
			);
		}

		View::prependTitle(_t('conf.privacy') . ' · ');
	}
}
