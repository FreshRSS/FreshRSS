<?php
declare(strict_types=1);

namespace FreshRss\Controllers;

use FreshRss\Exceptions\ContextException;
use FreshRss\Exceptions\EntriesGetterException;
use FreshRss\Minz\Error;
use FreshRss\Minz\Log;
use FreshRss\Minz\Paginator;
use FreshRss\Minz\Request;
use FreshRss\Minz\Url;
use FreshRss\Models\ActionController;
use FreshRss\Models\Auth;
use FreshRss\Models\Category;
use FreshRss\Models\CategoryDAO;
use FreshRss\Models\Context;
use FreshRss\Models\Entry;
use FreshRss\Models\Factory;
use FreshRss\Models\Log as LogModel;
use FreshRss\Models\LogDAO;
use FreshRss\Models\Search;
use FreshRss\Models\View;
use FreshRss\Models\ViewMode;

/**
 * This class handles main actions of FreshRSS.
 */
class IndexController extends ActionController {

	#[\Override]
	public function firstAction(): void {
		$this->view->html_url = Url::display(['c' => 'index', 'a' => 'index'], 'html', 'root');
	}

	/**
	 * This action only redirect on the default view mode (normal or global)
	 */
	public function indexAction(): void {
		$preferred_output = Context::userConf()->view_mode;
		$viewMode = ViewMode::getAllModes()[$preferred_output] ?? null;

		// Fallback to 'normal' if the preferred mode was not found
		if ($viewMode === null) {
			Request::setBadNotification(_t('feedback.extensions.invalid_view_mode', $preferred_output));
			$viewMode = ViewMode::getAllModes()['normal'];
		}

		Request::forward([
			'c' => $viewMode->controller(),
			'a' => $viewMode->action(),
		]);
	}

	/**
	 * @return '.future'|'.today'|'.yesterday'|''
	 */
	private static function dayRelative(int $timestamp, bool $mayBeFuture): string {
		static $today = null;
		if (!is_int($today)) {
			$today = strtotime('today') ?: 0;
		}
		if ($today <= 0) {
			return '';
		} elseif ($mayBeFuture && ($timestamp >= $today + 86400)) {
			return '.future';
		} elseif ($timestamp >= $today) {
			return '.today';
		} elseif ($timestamp >= $today - 86400) {
			return '.yesterday';
		}
		return '';
	}

	/**
	 * Content for displaying a transition between entries when sorting by specific criteria.
	 */
	public static function transition(Entry $entry): string {
		return match (Context::$sort) {
			'id' => _t('index.feed.received' . self::dayRelative($entry->dateAdded(raw: true), mayBeFuture: false)) .
				' — ' . timestamptodate($entry->dateAdded(raw: true), hour: false),
			'date' => _t('index.feed.published' . self::dayRelative($entry->date(raw: true), mayBeFuture: true)) .
				' — ' . timestamptodate($entry->date(raw: true), hour: false),
			'lastUserModified' => _t('index.feed.userModified' . self::dayRelative($entry->lastUserModified() ?? 0, mayBeFuture: false)) .
				' — ' . timestamptodate($entry->lastUserModified() ?? 0, hour: false),
			'c.name' => $entry->feed()?->category()?->name() ?? '',
			'f.name' => $entry->feed()?->name() ?? '',
			default => '',
		};
	}

	/**
	 * Produce a hyperlink to the next transition of entries.
	 */
	public static function transitionLink(Entry $entry, int $offset = 0): string {
		if (in_array(Context::$sort, ['c.name', 'f.name'], true)) {
			return Url::display(Request::modifiedCurrentRequest([
				'get' => match (Context::$sort) {
					'c.name' => 'c_' . ($entry->feed()?->category()?->id() ?? '0'),
					'f.name' => 'f_' . ($entry->feed()?->id() ?? '0'),
				},
			]));
		}
		$operator = match (Context::$sort) {
			'id' => 'date',
			'date' => 'pubdate',
			'lastUserModified' => 'userdate',
			default => throw new \InvalidArgumentException('Unsupported sort criterion for transition: ' . Context::$sort),
		};
		$offset = Context::$order === 'ASC' ? $offset : -$offset;
		$timestamp = match (Context::$sort) {
			'id' => $entry->dateAdded(raw: true),
			'date' => $entry->date(raw: true),
			'lastUserModified' => $entry->lastUserModified() ?? 0,
		};
		$searchString = $operator . ':' . ($offset < 0 ? '/' : '') . date('Y-m-d', $timestamp + ($offset * 86400)) . ($offset > 0 ? '/' : '');
		return Url::display(Request::modifiedCurrentRequest([
			'search' => Context::$search->toString() === '' ? $searchString :
				Context::$search->enforce(new Search($searchString))->toString(),
			]));
	}

	/**
	 * This action displays the normal view of FreshRSS.
	 */
	public function normalAction(): void {
		$allow_anonymous = Context::systemConf()->allow_anonymous;
		if (!Auth::hasAccess() && !$allow_anonymous) {
			Request::forward(['c' => 'auth', 'a' => 'login']);
			return;
		}

		$id = Request::paramInt('id');
		if ($id !== 0) {
			if (Request::paramString('type') === 'tag') {
				$tagDAO = Factory::createTagDao();
				$tag = $tagDAO->searchById($id);
				$this->view->tag = $tag;
			} else {
				$feedDAO = Factory::createFeedDao();
				$feed = $feedDAO->searchById($id);
				$this->view->feed = $feed;
			}
			$this->view->displaySlider = true;
			$this->view->cfrom = Request::actionName();
		}

		try {
			Context::updateUsingRequest(true);
		} catch (ContextException $e) {
			Error::error(404);
		}

		$this->_csp([
			'default-src' => "'self'",
			'frame-src' => '*',
			'img-src' => '* data: blob:',
			'frame-ancestors' => Context::systemConf()->attributeString('csp.frame-ancestors') ?? "'none'",
			'media-src' => '*',
		]);

		$this->view->categories = Context::categories();

		$this->view->rss_title = Context::$name . ' | ' . View::title();
		$title = Context::$name;
		$search = Context::$search->toString(expandUserQueries: false);
		if ($search !== '') {
			$title = '“' . htmlspecialchars($search, ENT_COMPAT, 'UTF-8') . '”';
		}
		if (Context::userConf()->show_title_unread && Context::$get_unread > 0) {
			$title = '(' . Context::$get_unread . ') ' . $title;
		}
		if (strlen($title) > 0) {
			View::prependTitle($title . ' · ');
		}

		if (Context::$id_max === '0') {
			Context::$id_max = uTimeString();
		}

		$this->view->callbackBeforeFeeds = static function (View $view) {
			$view->nbUnreadTags = 0;
			if (Request::paramBoolean('ajax')) {
				// Disable label counts for AJAX requests: faster and not needed
				$view->tags = Context::labels(precounts: false);
				return;
			}
			$view->tags = Context::labels(precounts: true);
			foreach ($view->tags as $tag) {
				$view->nbUnreadTags += $tag->nbUnread();
			}
		};

		$this->view->callbackBeforeEntries = static function (View $view) {
			try {
				// +1 to account for paging logic
				$view->entries = IndexController::listEntriesByContext(Context::$number + 1);
				if (!$view->entries->valid()) {	// Init the generator to catch potential exceptions
					$view->entries = new \EmptyIterator();
				}
				ob_start();	//Buffer "one entry at a time"
			} catch (EntriesGetterException $e) {
				Log::notice($e->getMessage());
				Error::error(404);
			}
		};

		$this->view->callbackBeforePagination = static function (?View $view, int $nbEntries, Entry $lastEntry) {
			if ($nbEntries > Context::$number) {
				//We have enough entries: we discard the last one to use it for the next articles' page
				ob_clean();
				Context::$continuation_id = $lastEntry->id();
			} else {
				Context::$continuation_id = '0';
			}
			ob_end_flush();
		};
	}

	/**
	 * This action displays the reader view of FreshRSS.
	 *
	 * @todo: change this view into specific CSS rules?
	 */
	public function readerAction(): void {
		$this->normalAction();
	}

	/**
	 * This action displays the global view of FreshRSS.
	 */
	public function globalAction(): void {
		$allow_anonymous = Context::systemConf()->allow_anonymous;
		if (!Auth::hasAccess() && !$allow_anonymous) {
			Request::forward(['c' => 'auth', 'a' => 'login']);
			return;
		}

		View::appendScript(Url::display('/scripts/extra.js?' . @filemtime(PUBLIC_PATH . '/scripts/extra.js')));
		View::appendScript(Url::display('/scripts/global_view.js?' . @filemtime(PUBLIC_PATH . '/scripts/global_view.js')));

		try {
			Context::updateUsingRequest(true);
		} catch (ContextException) {
			Error::error(404);
		}

		$this->view->categories = Context::categories();
		// Filter feed list when searching or when a restrictive state filter is active
		if (Context::$search->toString() !== '' || Context::isStateConsequential(Context::$state)) {
			$entryDAO = Factory::createEntryDao();
			$this->view->feedIdsMatching = $entryDAO->listFeedIdsMatching(Context::$state, Context::$search);
		}

		$this->view->rss_title = Context::$name . ' | ' . View::title();
		$title = _t('index.feed.title_global');
		if (Context::userConf()->show_title_unread && Context::$get_unread > 0) {
			$title = '(' . Context::$get_unread . ') ' . $title;
		}
		View::prependTitle($title . ' · ');

		$this->_csp([
			'default-src' => "'self'",
			'frame-src' => '*',
			'img-src' => '* data: blob:',
			'frame-ancestors' => Context::systemConf()->attributeString('csp.frame-ancestors') ?? "'none'",
			'media-src' => '*',
		]);
	}

	/**
	 * This action displays the RSS feed of FreshRSS.
	 * @deprecated See user query RSS sharing instead
	 */
	public function rssAction(): void {
		$allow_anonymous = Context::systemConf()->allow_anonymous;

		// Check if user has access.
		if (!Auth::hasAccess() && !$allow_anonymous && !Request::tokenIsOk()) {
			Error::error(403, redirect: false);
			return;
		}

		try {
			Context::updateUsingRequest(false);
		} catch (ContextException $e) {
			Error::error(404);
		}

		try {
			$this->view->entries = IndexController::listEntriesByContext();
			if (!$this->view->entries->valid()) {	// Init the generator to catch potential exceptions
				$this->view->entries = new \EmptyIterator();
			}
		} catch (EntriesGetterException $e) {
			Log::notice($e->getMessage());
			Error::error(404);
		}

		$this->view->html_url = Url::display('', 'html', true);
		$this->view->rss_title = Context::$name . ' | ' . View::title();

		$queryString = $_SERVER['QUERY_STRING'] ?? '';
		$this->view->rss_url = htmlspecialchars(
			PUBLIC_TO_INDEX_PATH . '/' . ($queryString === '' || !is_string($queryString) ? '' : '?' . $queryString), ENT_COMPAT, 'UTF-8');

		// No layout for RSS output.
		$this->view->_layout(null);
		header('Content-Type: application/rss+xml; charset=utf-8');
	}

	public function opmlAction(): void {
		$allow_anonymous = Context::systemConf()->allow_anonymous;

		// Check if user has access.
		if (!Auth::hasAccess() && !$allow_anonymous && !Request::tokenIsOk()) {
			Error::error(403, redirect: false);
			return;
		}

		try {
			Context::updateUsingRequest(false);
		} catch (ContextException) {
			Error::error(404);
		}

		$get = Context::currentGet(true);
		$type = (string)$get[0];
		$id = (int)$get[1];

		$this->view->excludeMutedFeeds = $type !== 'f';	// Exclude muted feeds except when we focus on a feed

		switch ($type) {
			case 'a':	// All PRIORITY_MAIN_STREAM
			case 'A':	// All except PRIORITY_HIDDEN
			case 'Z':	// All including PRIORITY_HIDDEN
				$this->view->categories = Context::categories();
				break;
			case 'c':	// Category
				$cat = Context::categories()[$id] ?? null;
				if ($cat == null) {
					Error::error(404);
					return;
				}
				$this->view->categories = [$cat->id() => $cat];
				break;
			case 'f':	// Feed
				// We most likely already have the feed object in cache
				$feed = Category::findFeed(Context::categories(), $id);
				if ($feed === null) {
					$feedDAO = Factory::createFeedDao();
					$feed = $feedDAO->searchById($id);
					if ($feed == null) {
						Error::error(404);
						return;
					}
				}
				$this->view->feeds = [$feed->id() => $feed];
				break;
			default:
				Error::error(404);
				return;
		}

		// No layout for OPML output.
		$this->view->_layout(null);
		header('Content-Type: application/xml; charset=utf-8');
	}

	/**
	 * This method returns a list of entries based on the Context object.
	 * @param int $postsPerPage override `Context::$number`
	 * @return \Generator<Entry>
	 * @throws EntriesGetterException
	 */
	public static function listEntriesByContext(?int $postsPerPage = null): \Generator {
		$entryDAO = Factory::createEntryDao();

		$get = Context::currentGet(true);
		if (is_array($get)) {
			$type = $get[0];
			$id = (int)($get[1]);
		} else {
			$type = $get;
			$id = 0;
		}

		$id_min = '0';
		if (Context::$sinceHours > 0) {
			$id_min = (time() - (Context::$sinceHours * 3600)) . '000000';
		}

		$continuation_values = [];
		if (Context::$continuation_id !== '0') {
			if (in_array(Context::$sort, ['c.name', 'date', 'f.name', 'link', 'title', 'lastUserModified', 'length'], true)) {
				$pagingEntry = $entryDAO->searchById(Context::$continuation_id);

				if ($pagingEntry !== null && in_array(Context::$sort, ['c.name', 'f.name'], true)) {
					// We most likely already have the feed object in cache
					$feed = Category::findFeed(Context::categories(), $pagingEntry->feedId());
					if ($feed !== null) {
						$pagingEntry->_feed($feed);
					}
				}

				$continuation_values[] = $pagingEntry === null ? 0 : match (Context::$sort) {
					'c.name' => $pagingEntry->feed()?->categoryId() === CategoryDAO::DEFAULTCATEGORYID ?
						CategoryDAO::DEFAULT_CATEGORY_NAME : $pagingEntry->feed()?->category()?->name() ?? '',
					'date' => $pagingEntry->date(raw: true),
					'f.name' => $pagingEntry->feed()?->name(raw: true) ?? '',
					'link' => $pagingEntry->link(raw: true),
					'title' => $pagingEntry->title(),
					'lastUserModified' => $pagingEntry->lastUserModified() ?? 0,
					'length' => $pagingEntry->sqlContentLength() ?? 0,
				};
				if (Context::$sort === 'c.name') {
					// Internal secondary sort criterion for category name
					$continuation_values[] = $pagingEntry?->feed()?->name(raw: true) ?? '';
				}
				if (in_array(Context::$sort, ['c.name', 'f.name'], true)) {
					// User secondary sort criterion
					$continuation_values[] = $pagingEntry === null ? 0 : match (Context::$secondary_sort) {
						'id' => $pagingEntry->id(),
						'date' => $pagingEntry->date(raw: true),
						'link' => $pagingEntry->link(raw: true),
						'title' => $pagingEntry->title(),
					};
				}
			} elseif (Context::$sort === 'rand') {
				Context::$continuation_id = '0';
			}
		}

		yield from $entryDAO->listWhere(
			$type, $id, Context::$state, Context::$search,
			id_min: $id_min, id_max: Context::$id_max, sort: Context::$sort, order: Context::$order,
			continuation_id: Context::$continuation_id, continuation_values: $continuation_values,
			limit: $postsPerPage ?? Context::$number, offset: Context::$offset,
			secondary_sort: Context::$secondary_sort, secondary_sort_order: Context::$secondary_sort_order);
	}

	/**
	 * This action displays the about page of FreshRSS.
	 */
	public function aboutAction(): void {
		View::prependTitle(_t('index.about.title') . ' · ');
	}

	/**
	 * This action displays the EULA/TOS (Terms of Service) page of FreshRSS.
	 * This page is enabled only if admin created a data/tos.html file.
	 * The content of the page is the content of data/tos.html.
	 * It returns 404 if there is no EULA/TOS.
	 */
	public function tosAction(): void {
		$terms_of_service = file_get_contents(TOS_FILENAME);
		if ($terms_of_service === false) {
			Error::error(404);
			return;
		}

		$this->view->terms_of_service = $terms_of_service;
		$this->view->can_register = !UserController::max_registrations_reached();
		View::prependTitle(_t('index.tos.title') . ' · ');
	}

	/**
	 * This action displays logs of FreshRSS for the current user.
	 */
	public function logsAction(): void {
		if (!Auth::hasAccess()) {
			Error::error(403);
		}

		View::prependTitle(_t('index.log.title') . ' · ');

		if (Request::isPost()) {
			LogDAO::truncate();
		}

		$logs = LogDAO::lines();	//TODO: ask only the necessary lines

		$search = trim(Request::paramString('search', plaintext: true));
		if ($search !== '') {
			$logs = array_values(array_filter($logs, static fn(LogModel $log): bool =>
				stripos($log->level(), $search) !== false ||
				stripos($log->date(), $search) !== false ||
				stripos($log->info(), $search) !== false));
		}
		$this->view->logSearch = $search;

		//gestion pagination
		$page = Request::paramInt('page') ?: 1;
		$this->view->logsPaginator = new Paginator($logs);
		$this->view->logsPaginator->_nbItemsPerPage(50);
		$this->view->logsPaginator->_currentPage($page);
	}
}
