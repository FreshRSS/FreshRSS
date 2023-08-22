<?php

/**
 * This class handles main actions of FreshRSS.
 */
class FreshRSS_index_Controller extends FreshRSS_ActionController {

	/**
	 * This action only redirect on the default view mode (normal or global)
	 */
	public function indexAction(): void {
		$preferred_output = FreshRSS_Context::$user_conf->view_mode;
		Minz_Request::forward([
			'c' => 'index',
			'a' => $preferred_output,
		]);
	}

	/**
	 * This action displays the normal view of FreshRSS.
	 */
	public function normalAction(): void {
		$allow_anonymous = FreshRSS_Context::$system_conf->allow_anonymous;
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
			FreshRSS_Context::updateUsingRequest();
		} catch (FreshRSS_Context_Exception $e) {
			Minz_Error::error(404);
		}

		$this->_csp([
			'default-src' => "'self'",
			'frame-src' => '*',
			'img-src' => '* data:',
			'media-src' => '*',
		]);

		$this->view->categories = FreshRSS_Context::$categories;

		$this->view->rss_title = FreshRSS_Context::$name . ' | ' . FreshRSS_View::title();
		$title = FreshRSS_Context::$name;
		if (FreshRSS_Context::$get_unread > 0) {
			$title = '(' . FreshRSS_Context::$get_unread . ') ' . $title;
		}
		FreshRSS_View::prependTitle($title . ' · ');

		FreshRSS_Context::$id_max = time() . '000000';

		$this->view->callbackBeforeFeeds = static function (FreshRSS_View $view) {
			try {
				$tagDAO = FreshRSS_Factory::createTagDao();
				$view->tags = $tagDAO->listTags(true) ?: [];
				$view->nbUnreadTags = 0;
				foreach ($view->tags as $tag) {
					$view->nbUnreadTags += $tag->nbUnread();
				}
			} catch (Exception $e) {
				Minz_Log::notice($e->getMessage());
			}
		};

		$this->view->callbackBeforeEntries = static function (FreshRSS_View $view) {
			try {
				FreshRSS_Context::$number++;	//+1 for articles' page
				$view->entries = FreshRSS_index_Controller::listEntriesByContext();
				FreshRSS_Context::$number--;
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
		$allow_anonymous = FreshRSS_Context::$system_conf->allow_anonymous;
		if (!FreshRSS_Auth::hasAccess() && !$allow_anonymous) {
			Minz_Request::forward(['c' => 'auth', 'a' => 'login']);
			return;
		}

		FreshRSS_View::appendScript(Minz_Url::display('/scripts/extra.js?' . @filemtime(PUBLIC_PATH . '/scripts/extra.js')));
		FreshRSS_View::appendScript(Minz_Url::display('/scripts/global_view.js?' . @filemtime(PUBLIC_PATH . '/scripts/global_view.js')));

		try {
			FreshRSS_Context::updateUsingRequest();
		} catch (FreshRSS_Context_Exception $e) {
			Minz_Error::error(404);
		}

		$this->view->categories = FreshRSS_Context::$categories;

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
	 */
	public function rssAction(): void {
		$allow_anonymous = FreshRSS_Context::$system_conf->allow_anonymous;
		$token = FreshRSS_Context::$user_conf->token;
		$token_param = Minz_Request::paramString('token');
		$token_is_ok = ($token != '' && $token === $token_param);

		// Check if user has access.
		if (!FreshRSS_Auth::hasAccess() &&
				!$allow_anonymous &&
				!$token_is_ok) {
			Minz_Error::error(403);
		}

		try {
			FreshRSS_Context::updateUsingRequest();
		} catch (FreshRSS_Context_Exception $e) {
			Minz_Error::error(404);
		}

		try {
			$this->view->entries = FreshRSS_index_Controller::listEntriesByContext();
		} catch (FreshRSS_EntriesGetter_Exception $e) {
			Minz_Log::notice($e->getMessage());
			Minz_Error::error(404);
		}

		// No layout for RSS output.
		$this->view->rss_url = PUBLIC_TO_INDEX_PATH . '/' . (empty($_SERVER['QUERY_STRING']) ? '' : '?' . $_SERVER['QUERY_STRING']);
		$this->view->rss_title = FreshRSS_Context::$name . ' | ' . FreshRSS_View::title();
		$this->view->_layout(null);
		header('Content-Type: application/rss+xml; charset=utf-8');
	}

	public function opmlAction(): void {
		$allow_anonymous = FreshRSS_Context::$system_conf->allow_anonymous;
		$token = FreshRSS_Context::$user_conf->token;
		$token_param = Minz_Request::paramString('token');
		$token_is_ok = ($token != '' && $token === $token_param);

		// Check if user has access.
		if (!FreshRSS_Auth::hasAccess() && !$allow_anonymous && !$token_is_ok) {
			Minz_Error::error(403);
		}

		try {
			FreshRSS_Context::updateUsingRequest();
		} catch (FreshRSS_Context_Exception $e) {
			Minz_Error::error(404);
		}

		$get = FreshRSS_Context::currentGet(true);
		$type = (string)$get[0];
		$id = (int)$get[1];

		$catDAO = FreshRSS_Factory::createCategoryDao();
		$categories = $catDAO->listCategories(true, true);
		$this->view->excludeMutedFeeds = true;

		switch ($type) {
			case 'a':
				$this->view->categories = $categories;
				break;
			case 'c':
				$cat = $categories[$id] ?? null;
				if ($cat == null) {
					Minz_Error::error(404);
					return;
				}
				$this->view->categories = [ $cat ];
				break;
			case 'f':
				// We most likely already have the feed object in cache
				$feed = FreshRSS_CategoryDAO::findFeed($categories, $id);
				if ($feed === null) {
					$feedDAO = FreshRSS_Factory::createFeedDao();
					$feed = $feedDAO->searchById($id);
					if ($feed == null) {
						Minz_Error::error(404);
						return;
					}
				}
				$this->view->feeds = [ $feed ];
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
	 * @return Traversable<FreshRSS_Entry>
	 */
	public static function listEntriesByContext(): Traversable {
		$entryDAO = FreshRSS_Factory::createEntryDao();

		$get = FreshRSS_Context::currentGet(true);
		if (is_array($get)) {
			$type = $get[0];
			$id = (int)($get[1]);
		} else {
			$type = $get;
			$id = 0;
		}

		$limit = FreshRSS_Context::$number;

		$date_min = 0;
		if (FreshRSS_Context::$sinceHours) {
			$date_min = time() - (FreshRSS_Context::$sinceHours * 3600);
			$limit = FreshRSS_Context::$user_conf->max_posts_per_rss;
		}

		foreach ($entryDAO->listWhere(
					$type, $id, FreshRSS_Context::$state, FreshRSS_Context::$order,
					$limit, FreshRSS_Context::$first_id,
					FreshRSS_Context::$search, $date_min)
				as $entry) {
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
