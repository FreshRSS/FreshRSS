<?php

/**
 * This class handles main actions of FreshRSS.
 */
class FreshRSS_index_Controller extends Minz_ActionController {

	/**
	 * This action only redirect on the default view mode (normal or global)
	 */
	public function indexAction() {
		$prefered_output = FreshRSS_Context::$user_conf->view_mode;
		Minz_Request::forward(array(
			'c' => 'index',
			'a' => $prefered_output
		));
	}

	/**
	 * This action displays the normal view of FreshRSS.
	 */
	public function normalAction() {
		$allow_anonymous = FreshRSS_Context::$system_conf->allow_anonymous;
		if (!FreshRSS_Auth::hasAccess() && !$allow_anonymous) {
			Minz_Request::forward(array('c' => 'auth', 'a' => 'login'));
			return;
		}

		try {
			$this->updateContext();
		} catch (FreshRSS_Context_Exception $e) {
			Minz_Error::error(404);
		}

		$this->view->categories = FreshRSS_Context::$categories;

		$this->view->rss_title = FreshRSS_Context::$name . ' | ' . Minz_View::title();
		$title = FreshRSS_Context::$name;
		if (FreshRSS_Context::$get_unread > 0) {
			$title = '(' . FreshRSS_Context::$get_unread . ') ' . $title;
		}
		Minz_View::prependTitle($title . ' · ');

		$this->view->callbackBeforeFeeds = function ($view) {
			try {
				$tagDAO = FreshRSS_Factory::createTagDao();
				$view->tags = $tagDAO->listTags(true);
				$view->nbUnreadTags = 0;
				foreach ($view->tags as $tag) {
					$view->nbUnreadTags += $tag->nbUnread();
				}
			} catch (Exception $e) {
				Minz_Log::notice($e->getMessage());
			}
		};

		$this->view->callbackBeforeEntries = function ($view) {
			try {
				FreshRSS_Context::$number++;	//+1 for pagination
				$entries = FreshRSS_index_Controller::listEntriesByContext();
				FreshRSS_Context::$number--;

				$nb_entries = count($entries);
				if ($nb_entries > FreshRSS_Context::$number) {
					// We have more elements for pagination
					$last_entry = array_pop($entries);
					FreshRSS_Context::$next_id = $last_entry->id();
				}

				$first_entry = $nb_entries > 0 ? $entries[0] : null;
				FreshRSS_Context::$id_max = $first_entry === null ? (time() - 1) . '000000' : $first_entry->id();
				if (FreshRSS_Context::$order === 'ASC') {
					// In this case we do not know but we guess id_max
					$id_max = (time() - 1) . '000000';
					if (strcmp($id_max, FreshRSS_Context::$id_max) > 0) {
						FreshRSS_Context::$id_max = $id_max;
					}
				}

				$view->entries = $entries;
			} catch (FreshRSS_EntriesGetter_Exception $e) {
				Minz_Log::notice($e->getMessage());
				Minz_Error::error(404);
			}
		};
	}

	/**
	 * This action displays the reader view of FreshRSS.
	 *
	 * @todo: change this view into specific CSS rules?
	 */
	public function readerAction() {
		$this->normalAction();
	}

	/**
	 * This action displays the global view of FreshRSS.
	 */
	public function globalAction() {
		$allow_anonymous = FreshRSS_Context::$system_conf->allow_anonymous;
		if (!FreshRSS_Auth::hasAccess() && !$allow_anonymous) {
			Minz_Request::forward(array('c' => 'auth', 'a' => 'login'));
			return;
		}

		Minz_View::prependScript(Minz_Url::display('/scripts/jquery.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/jquery.min.js')));
		Minz_View::appendScript(Minz_Url::display('/scripts/extra.js?' . @filemtime(PUBLIC_PATH . '/scripts/extra.js')));
		Minz_View::appendScript(Minz_Url::display('/scripts/global_view.js?' . @filemtime(PUBLIC_PATH . '/scripts/global_view.js')));

		try {
			$this->updateContext();
		} catch (FreshRSS_Context_Exception $e) {
			Minz_Error::error(404);
		}

		$this->view->categories = FreshRSS_Context::$categories;

		$this->view->rss_title = FreshRSS_Context::$name . ' | ' . Minz_View::title();
		$title = _t('index.feed.title_global');
		if (FreshRSS_Context::$get_unread > 0) {
			$title = '(' . FreshRSS_Context::$get_unread . ') ' . $title;
		}
		Minz_View::prependTitle($title . ' · ');
	}

	/**
	 * This action displays the RSS feed of FreshRSS.
	 */
	public function rssAction() {
		$allow_anonymous = FreshRSS_Context::$system_conf->allow_anonymous;
		$token = FreshRSS_Context::$user_conf->token;
		$token_param = Minz_Request::param('token', '');
		$token_is_ok = ($token != '' && $token === $token_param);

		// Check if user has access.
		if (!FreshRSS_Auth::hasAccess() &&
				!$allow_anonymous &&
				!$token_is_ok) {
			Minz_Error::error(403);
		}

		try {
			$this->updateContext();
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
		$this->view->url = PUBLIC_TO_INDEX_PATH . '/' . (empty($_SERVER['QUERY_STRING']) ? '' : '?' . $_SERVER['QUERY_STRING']);
		$this->view->rss_title = FreshRSS_Context::$name . ' | ' . Minz_View::title();
		$this->view->_useLayout(false);
		header('Content-Type: application/rss+xml; charset=utf-8');
	}

	/**
	 * This action updates the Context object by using request parameters.
	 *
	 * Parameters are:
	 *   - state (default: conf->default_view)
	 *   - search (default: empty string)
	 *   - order (default: conf->sort_order)
	 *   - nb (default: conf->posts_per_page)
	 *   - next (default: empty string)
	 *   - hours (default: 0)
	 */
	private function updateContext() {
		if (empty(FreshRSS_Context::$categories)) {
			$catDAO = FreshRSS_Factory::createCategoryDao();
			FreshRSS_Context::$categories = $catDAO->listCategories();
		}

		// Update number of read / unread variables.
		$entryDAO = FreshRSS_Factory::createEntryDao();
		FreshRSS_Context::$total_starred = $entryDAO->countUnreadReadFavorites();
		FreshRSS_Context::$total_unread = FreshRSS_CategoryDAO::CountUnreads(
			FreshRSS_Context::$categories, 1
		);

		FreshRSS_Context::_get(Minz_Request::param('get', 'a'));

		FreshRSS_Context::$state = Minz_Request::param(
			'state', FreshRSS_Context::$user_conf->default_state
		);
		$state_forced_by_user = Minz_Request::param('state', false) !== false;
		if (FreshRSS_Context::$user_conf->default_view === 'adaptive' &&
				FreshRSS_Context::$get_unread <= 0 &&
				!FreshRSS_Context::isStateEnabled(FreshRSS_Entry::STATE_READ) &&
				!$state_forced_by_user) {
			FreshRSS_Context::$state |= FreshRSS_Entry::STATE_READ;
		}

		FreshRSS_Context::$search = new FreshRSS_BooleanSearch(Minz_Request::param('search', ''));
		FreshRSS_Context::$order = Minz_Request::param(
			'order', FreshRSS_Context::$user_conf->sort_order
		);
		FreshRSS_Context::$number = intval(Minz_Request::param('nb', FreshRSS_Context::$user_conf->posts_per_page));
		if (FreshRSS_Context::$number > FreshRSS_Context::$user_conf->max_posts_per_rss) {
			FreshRSS_Context::$number = max(
				FreshRSS_Context::$user_conf->max_posts_per_rss,
				FreshRSS_Context::$user_conf->posts_per_page);
		}
		FreshRSS_Context::$first_id = Minz_Request::param('next', '');
		FreshRSS_Context::$sinceHours = intval(Minz_Request::param('hours', 0));
	}

	/**
	 * This method returns a list of entries based on the Context object.
	 */
	public static function listEntriesByContext() {
		$entryDAO = FreshRSS_Factory::createEntryDao();

		$get = FreshRSS_Context::currentGet(true);
		if (is_array($get)) {
			$type = $get[0];
			$id = $get[1];
		} else {
			$type = $get;
			$id = '';
		}

		$limit = FreshRSS_Context::$number;

		$date_min = 0;
		if (FreshRSS_Context::$sinceHours) {
			$date_min = time() - (FreshRSS_Context::$sinceHours * 3600);
			$limit = FreshRSS_Context::$user_conf->max_posts_per_rss;
		}

		$entries = $entryDAO->listWhere(
			$type, $id, FreshRSS_Context::$state, FreshRSS_Context::$order,
			$limit, FreshRSS_Context::$first_id,
			FreshRSS_Context::$search, $date_min
		);

		if (FreshRSS_Context::$sinceHours && (count($entries) < FreshRSS_Context::$user_conf->min_posts_per_rss)) {
			$date_min = 0;
			$limit = FreshRSS_Context::$user_conf->min_posts_per_rss;
			$entries = $entryDAO->listWhere(
				$type, $id, FreshRSS_Context::$state, FreshRSS_Context::$order,
				$limit, FreshRSS_Context::$first_id,
				FreshRSS_Context::$search, $date_min
			);
		}

		return $entries;
	}

	/**
	 * This action displays the about page of FreshRSS.
	 */
	public function aboutAction() {
		Minz_View::prependTitle(_t('index.about.title') . ' · ');
	}

	/**
	 * This action displays logs of FreshRSS for the current user.
	 */
	public function logsAction() {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}

		Minz_View::prependTitle(_t('index.log.title') . ' · ');

		if (Minz_Request::isPost()) {
			FreshRSS_LogDAO::truncate();
		}

		$logs = FreshRSS_LogDAO::lines();	//TODO: ask only the necessary lines

		//gestion pagination
		$page = Minz_Request::param('page', 1);
		$this->view->logsPaginator = new Minz_Paginator($logs);
		$this->view->logsPaginator->_nbItemsPerPage(50);
		$this->view->logsPaginator->_currentPage($page);
	}
}
