<?php

namespace Freshrss\Controllers;

/**
 * This class handles main actions of FreshRSS.
 */
class index_Controller extends ActionController {

	/**
	 * This action only redirect on the default view mode (normal or global)
	 */
	public function indexAction() {
		$prefered_output = Context::$user_conf->view_mode;
		Request::forward(array(
			'c' => 'index',
			'a' => $prefered_output
		));
	}

	/**
	 * This action displays the normal view of FreshRSS.
	 */
	public function normalAction() {
		$allow_anonymous = Context::$system_conf->allow_anonymous;
		if (!Auth::hasAccess() && !$allow_anonymous) {
			Request::forward(array('c' => 'auth', 'a' => 'login'));
			return;
		}

		try {
			$this->updateContext();
		} catch (Context_Exception $e) {
			Error::error(404);
		}

		$this->view->categories = Context::$categories;

		$this->view->rss_title = Context::$name . ' | ' . View::title();
		$title = Context::$name;
		if (Context::$get_unread > 0) {
			$title = '(' . Context::$get_unread . ') ' . $title;
		}
		View::prependTitle($title . ' · ');

		$this->view->callbackBeforeFeeds = function ($view) {
			try {
				$tagDAO = Factory::createTagDao();
				$view->tags = $tagDAO->listTags(true);
				$view->nbUnreadTags = 0;
				foreach ($view->tags as $tag) {
					$view->nbUnreadTags += $tag->nbUnread();
				}
			} catch (Exception $e) {
				Log::notice($e->getMessage());
			}
		};

		$this->view->callbackBeforePagination = function ($view) {
			try {
				Context::$number++;	//+1 for pagination
				$entries = index_Controller::listEntriesByContext();
				Context::$number--;

				$nb_entries = count($entries);
				if ($nb_entries > Context::$number) {
					// We have more elements for pagination
					$last_entry = array_pop($entries);
					Context::$next_id = $last_entry->id();
				}

				$first_entry = $nb_entries > 0 ? $entries[0] : null;
				Context::$id_max = $first_entry === null ? (time() - 1) . '000000' : $first_entry->id();
				if (Context::$order === 'ASC') {
					// In this case we do not know but we guess id_max
					$id_max = (time() - 1) . '000000';
					if (strcmp($id_max, Context::$id_max) > 0) {
						Context::$id_max = $id_max;
					}
				}

				$view->entries = $entries;
			} catch (EntriesGetter_Exception $e) {
				Log::notice($e->getMessage());
				Error::error(404);
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
		$allow_anonymous = Context::$system_conf->allow_anonymous;
		if (!Auth::hasAccess() && !$allow_anonymous) {
			Request::forward(array('c' => 'auth', 'a' => 'login'));
			return;
		}

		View::appendScript(Minz_Url::display('/scripts/extra.js?' . @filemtime(PUBLIC_PATH . '/scripts/extra.js')));
		View::appendScript(Minz_Url::display('/scripts/global_view.js?' . @filemtime(PUBLIC_PATH . '/scripts/global_view.js')));

		try {
			$this->updateContext();
		} catch (Context_Exception $e) {
			Error::error(404);
		}

		$this->view->categories = Context::$categories;

		$this->view->rss_title = Context::$name . ' | ' . View::title();
		$title = _t('index.feed.title_global');
		if (Context::$get_unread > 0) {
			$title = '(' . Context::$get_unread . ') ' . $title;
		}
		View::prependTitle($title . ' · ');
	}

	/**
	 * This action displays the RSS feed of FreshRSS.
	 */
	public function rssAction() {
		$allow_anonymous = Context::$system_conf->allow_anonymous;
		$token = Context::$user_conf->token;
		$token_param = Request::param('token', '');
		$token_is_ok = ($token != '' && $token === $token_param);

		// Check if user has access.
		if (!Auth::hasAccess() &&
				!$allow_anonymous &&
				!$token_is_ok) {
			Error::error(403);
		}

		try {
			$this->updateContext();
		} catch (Context_Exception $e) {
			Error::error(404);
		}

		try {
			$this->view->entries = index_Controller::listEntriesByContext();
		} catch (EntriesGetter_Exception $e) {
			Log::notice($e->getMessage());
			Error::error(404);
		}

		// No layout for RSS output.
		$this->view->url = PUBLIC_TO_INDEX_PATH . '/' . (empty($_SERVER['QUERY_STRING']) ? '' : '?' . $_SERVER['QUERY_STRING']);
		$this->view->rss_title = Context::$name . ' | ' . View::title();
		$this->view->_layout(false);
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
		if (empty(Context::$categories)) {
			$catDAO = Factory::createCategoryDao();
			Context::$categories = $catDAO->listSortedCategories();
		}

		// Update number of read / unread variables.
		$entryDAO = Factory::createEntryDao();
		Context::$total_starred = $entryDAO->countUnreadReadFavorites();
		Context::$total_unread = FreshRSS_CategoryDAO::CountUnreads(
			Context::$categories, 1
		);

		Context::_get(Request::param('get', 'a'));

		Context::$state = Request::param(
			'state', Context::$user_conf->default_state
		);
		$state_forced_by_user = Request::param('state', false) !== false;
		if (Context::$user_conf->default_view === 'adaptive' &&
				Context::$get_unread <= 0 &&
				!Context::isStateEnabled(FreshRSS_Entry::STATE_READ) &&
				!$state_forced_by_user) {
			Context::$state |= FreshRSS_Entry::STATE_READ;
		}

		Context::$search = new FreshRSS_BooleanSearch(Request::param('search', ''));
		Context::$order = Request::param(
			'order', Context::$user_conf->sort_order
		);
		Context::$number = intval(Request::param('nb', FreshRSS_Context::$user_conf->posts_per_page));
		if (Context::$number > FreshRSS_Context::$user_conf->max_posts_per_rss) {
			Context::$number = max(
				Context::$user_conf->max_posts_per_rss,
				Context::$user_conf->posts_per_page);
		}
		Context::$first_id = Request::param('next', '');
		Context::$sinceHours = intval(Request::param('hours', 0));
	}

	/**
	 * This method returns a list of entries based on the Context object.
	 */
	public static function listEntriesByContext() {
		$entryDAO = Factory::createEntryDao();

		$get = Context::currentGet(true);
		if (is_array($get)) {
			$type = $get[0];
			$id = $get[1];
		} else {
			$type = $get;
			$id = '';
		}

		$limit = Context::$number;

		$date_min = 0;
		if (Context::$sinceHours) {
			$date_min = time() - (Context::$sinceHours * 3600);
			$limit = Context::$user_conf->max_posts_per_rss;
		}

		$entries = $entryDAO->listWhere(
			$type, $id, Context::$state, FreshRSS_Context::$order,
			$limit, Context::$first_id,
			Context::$search, $date_min
		);

		if (Context::$sinceHours && (count($entries) < FreshRSS_Context::$user_conf->min_posts_per_rss)) {
			$date_min = 0;
			$limit = Context::$user_conf->min_posts_per_rss;
			$entries = $entryDAO->listWhere(
				$type, $id, Context::$state, FreshRSS_Context::$order,
				$limit, Context::$first_id,
				Context::$search, $date_min
			);
		}

		return $entries;
	}

	/**
	 * This action displays the about page of FreshRSS.
	 */
	public function aboutAction() {
		View::prependTitle(_t('index.about.title') . ' · ');
	}

	/**
	 * This action displays the EULA page of FreshRSS.
	 * This page is enabled only if admin created a data/tos.html file.
	 * The content of the page is the content of data/tos.html.
	 * It returns 404 if there is no EULA.
	 */
	public function tosAction() {
		$terms_of_service = file_get_contents(join_path(DATA_PATH, 'tos.html'));
		if (!$terms_of_service) {
			Error::error(404);
		}

		$this->view->terms_of_service = $terms_of_service;
		$this->view->can_register = !max_registrations_reached();
		View::prependTitle(_t('index.tos.title') . ' · ');
	}

	/**
	 * This action displays logs of FreshRSS for the current user.
	 */
	public function logsAction() {
		if (!Auth::hasAccess()) {
			Error::error(403);
		}

		View::prependTitle(_t('index.log.title') . ' · ');

		if (Request::isPost()) {
			LogDAO::truncate();
		}

		$logs = LogDAO::lines();	//TODO: ask only the necessary lines

		//gestion pagination
		$page = Request::param('page', 1);
		$this->view->logsPaginator = new Paginator($logs);
		$this->view->logsPaginator->_nbItemsPerPage(50);
		$this->view->logsPaginator->_currentPage($page);
	}
}
