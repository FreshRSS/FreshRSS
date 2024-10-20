<?php
declare(strict_types=1);

/**
 * This class handles main actions of FreshRSS.
 */
class FreshRSS_index_Controller extends FreshRSS_ActionController {

	#[\Override]
	public function firstAction(): void {
		$this->view->html_url = Minz_Url::display(['c' => 'index', 'a' => 'index'], 'html', 'root');
	}

	/**
	 * This action only redirect on the default view mode (normal or global)
	 */
	public function indexAction(): void {
		$preferred_output = FreshRSS_Context::userConf()->view_mode;
		Minz_Request::forward([
			'c' => 'index',
			'a' => $preferred_output,
		]);
	}

	/**
	 * This action displays the normal view of FreshRSS.
	 */
	public function normalAction(): void {
		$allow_anonymous = FreshRSS_Context::systemConf()->allow_anonymous;
		if (!FreshRSS_Auth::hasAccess() && !$allow_anonymous) {
			Minz_Request::forward(['c' => 'auth', 'a' => 'login']);
			return;
		}

		$id = Minz_Request::paramInt('id');
		if ($id !== 0) {
			$view = Minz_Request::paramString('a');
			$url_redirect = ['c' => 'subscription', 'a' => 'feed', 'params' => ['id' => (string)$id, 'from' => $view]];
			Minz_Request::forward($url_redirect, true);
			return;
		}

		try {
			FreshRSS_Context::updateUsingRequest(true);
		} catch (FreshRSS_Context_Exception $e) {
			Minz_Error::error(404);
		}

		$this->_csp([
			'default-src' => "'self'",
			'frame-src' => '*',
			'img-src' => '* data:',
			'media-src' => '*',
		]);

		$this->view->categories = FreshRSS_Context::categories();

		$this->view->rss_title = FreshRSS_Context::$name . ' | ' . FreshRSS_View::title();
		$title = FreshRSS_Context::$name;
		if (FreshRSS_Context::$get_unread > 0) {
			$title = '(' . FreshRSS_Context::$get_unread . ') ' . $title;
		}
		FreshRSS_View::prependTitle($title . ' · ');

		FreshRSS_Context::$id_max = time() . '000000';

		$this->view->callbackBeforeFeeds = static function (FreshRSS_View $view) {
			$view->tags = FreshRSS_Context::labels(true);
			$view->nbUnreadTags = 0;
			foreach ($view->tags as $tag) {
				$view->nbUnreadTags += $tag->nbUnread();
			}
		};

		$this->view->callbackBeforeEntries = static function (FreshRSS_View $view) {
			try {
				// +1 to account for paging logic
				$view->entries = FreshRSS_index_Controller::listEntriesByContext(FreshRSS_Context::$number + 1);
				ob_start();	//Buffer "one entry at a time"
			} catch (FreshRSS_EntriesGetter_Exception $e) {
				Minz_Log::notice($e->getMessage());
				Minz_Error::error(404);
			}
		};

		$this->view->callbackBeforePagination = static function (?FreshRSS_View $view, int $nbEntries, FreshRSS_Entry $lastEntry) {
			if ($nbEntries >= FreshRSS_Context::$number) {
				//We have enough entries: we discard the last one to use it for the next articles' page
				ob_clean();
				FreshRSS_Context::$next_id = $lastEntry->id();
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
		$allow_anonymous = FreshRSS_Context::systemConf()->allow_anonymous;
		if (!FreshRSS_Auth::hasAccess() && !$allow_anonymous) {
			Minz_Request::forward(['c' => 'auth', 'a' => 'login']);
			return;
		}

		FreshRSS_View::appendScript(Minz_Url::display('/scripts/extra.js?' . @filemtime(PUBLIC_PATH . '/scripts/extra.js')));
		FreshRSS_View::appendScript(Minz_Url::display('/scripts/global_view.js?' . @filemtime(PUBLIC_PATH . '/scripts/global_view.js')));

		try {
			FreshRSS_Context::updateUsingRequest(true);
		} catch (FreshRSS_Context_Exception $e) {
			Minz_Error::error(404);
		}

		$this->view->categories = FreshRSS_Context::categories();

		$this->view->rss_title = FreshRSS_Context::$name . ' | ' . FreshRSS_View::title();
		$title = _t('index.feed.title_global');
		if (FreshRSS_Context::$get_unread > 0) {
			$title = '(' . FreshRSS_Context::$get_unread . ') ' . $title;
		}
		FreshRSS_View::prependTitle($title . ' · ');

		$this->_csp([
			'default-src' => "'self'",
			'frame-src' => '*',
			'img-src' => '* data:',
			'media-src' => '*',
		]);
	}

	/**
	 * This action displays the RSS feed of FreshRSS.
	 * @deprecated See user query RSS sharing instead
	 */
	public function rssAction(): void {
		$allow_anonymous = FreshRSS_Context::systemConf()->allow_anonymous;
		$token = FreshRSS_Context::userConf()->token;
		$token_param = Minz_Request::paramString('token');
		$token_is_ok = ($token != '' && $token === $token_param);

		// Check if user has access.
		if (!FreshRSS_Auth::hasAccess() &&
				!$allow_anonymous &&
				!$token_is_ok) {
			Minz_Error::error(403);
		}

		try {
			FreshRSS_Context::updateUsingRequest(false);
		} catch (FreshRSS_Context_Exception $e) {
			Minz_Error::error(404);
		}

		try {
			$this->view->entries = FreshRSS_index_Controller::listEntriesByContext();
		} catch (FreshRSS_EntriesGetter_Exception $e) {
			Minz_Log::notice($e->getMessage());
			Minz_Error::error(404);
		}

		$this->view->html_url = Minz_Url::display('', 'html', true);
		$this->view->rss_title = FreshRSS_Context::$name . ' | ' . FreshRSS_View::title();
		$this->view->rss_url = htmlspecialchars(
			PUBLIC_TO_INDEX_PATH . '/' . (empty($_SERVER['QUERY_STRING']) ? '' : '?' . $_SERVER['QUERY_STRING']), ENT_COMPAT, 'UTF-8');

		// No layout for RSS output.
		$this->view->_layout(null);
		header('Content-Type: application/rss+xml; charset=utf-8');
	}

	/**
	 * @deprecated See user query OPML sharing instead
	 */
	public function opmlAction(): void {
		$allow_anonymous = FreshRSS_Context::systemConf()->allow_anonymous;
		$token = FreshRSS_Context::userConf()->token;
		$token_param = Minz_Request::paramString('token');
		$token_is_ok = ($token != '' && $token === $token_param);

		// Check if user has access.
		if (!FreshRSS_Auth::hasAccess() && !$allow_anonymous && !$token_is_ok) {
			Minz_Error::error(403);
		}

		try {
			FreshRSS_Context::updateUsingRequest(false);
		} catch (FreshRSS_Context_Exception $e) {
			Minz_Error::error(404);
		}

		$get = FreshRSS_Context::currentGet(true);
		$type = (string)$get[0];
		$id = (int)$get[1];

		$this->view->excludeMutedFeeds = $type !== 'f';	// Exclude muted feeds except when we focus on a feed

		switch ($type) {
			case 'a':
				$this->view->categories = FreshRSS_Context::categories();
				break;
			case 'c':
				$cat = FreshRSS_Context::categories()[$id] ?? null;
				if ($cat == null) {
					Minz_Error::error(404);
					return;
				}
				$this->view->categories = [ $cat->id() => $cat ];
				break;
			case 'f':
				// We most likely already have the feed object in cache
				$feed = FreshRSS_Category::findFeed(FreshRSS_Context::categories(), $id);
				if ($feed === null) {
					$feedDAO = FreshRSS_Factory::createFeedDao();
					$feed = $feedDAO->searchById($id);
					if ($feed == null) {
						Minz_Error::error(404);
						return;
					}
				}
				$this->view->feeds = [ $feed->id() => $feed ];
				break;
			case 's':
			case 't':
			case 'T':
			default:
				Minz_Error::error(404);
				return;
		}

		// No layout for OPML output.
		$this->view->_layout(null);
		header('Content-Type: application/xml; charset=utf-8');
	}

	/**
	 * This method returns a list of entries based on the Context object.
	 * @param int $postsPerPage override `FreshRSS_Context::$number`
	 * @return Traversable<FreshRSS_Entry>
	 * @throws FreshRSS_EntriesGetter_Exception
	 */
	public static function listEntriesByContext(?int $postsPerPage = null): Traversable {
		$entryDAO = FreshRSS_Factory::createEntryDao();

		$get = FreshRSS_Context::currentGet(true);
		if (is_array($get)) {
			$type = $get[0];
			$id = (int)($get[1]);
		} else {
			$type = $get;
			$id = 0;
		}

		$date_min = 0;
		if (FreshRSS_Context::$sinceHours > 0) {
			$date_min = time() - (FreshRSS_Context::$sinceHours * 3600);
		}

		foreach ($entryDAO->listWhere(
					$type, $id, FreshRSS_Context::$state, FreshRSS_Context::$order,
					$postsPerPage ?? FreshRSS_Context::$number, FreshRSS_Context::$offset, FreshRSS_Context::$first_id,
					FreshRSS_Context::$search, $date_min
				) as $entry) {
			yield $entry;
		}
	}

	/**
	 * This action displays the about page of FreshRSS.
	 */
	public function aboutAction(): void {
		FreshRSS_View::prependTitle(_t('index.about.title') . ' · ');
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
			Minz_Error::error(404);
			return;
		}

		$this->view->terms_of_service = $terms_of_service;
		$this->view->can_register = !max_registrations_reached();
		FreshRSS_View::prependTitle(_t('index.tos.title') . ' · ');
	}

	/**
	 * This action displays logs of FreshRSS for the current user.
	 */
	public function logsAction(): void {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}

		FreshRSS_View::prependTitle(_t('index.log.title') . ' · ');

		if (Minz_Request::isPost()) {
			FreshRSS_LogDAO::truncate();
		}

		$logs = FreshRSS_LogDAO::lines();	//TODO: ask only the necessary lines

		//gestion pagination
		$page = Minz_Request::paramInt('page') ?: 1;
		$this->view->logsPaginator = new Minz_Paginator($logs);
		$this->view->logsPaginator->_nbItemsPerPage(50);
		$this->view->logsPaginator->_currentPage($page);
	}
}
