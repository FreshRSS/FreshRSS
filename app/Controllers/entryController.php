<?php

/**
 * Controller to handle every entry actions.
 */
class FreshRSS_entry_Controller extends Minz_ActionController {
	/**
	 * This action is called before every other action in that class. It is
	 * the common boiler plate for every action. It is triggered by the
	 * underlying framework.
	 */
	public function firstAction() {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}

		// If ajax request, we do not print layout
		$this->ajax = Minz_Request::param('ajax');
		if ($this->ajax) {
			$this->view->_useLayout(false);
			Minz_Request::_param('ajax');
		}
	}

	/**
	 * Mark one or several entries as read (or not!).
	 *
	 * If request concerns several entries, it MUST be a POST request.
	 * If request concerns several entries, only mark them as read is available.
	 *
	 * Parameters are:
	 *   - id (default: false)
	 *   - get (default: false) /(c_\d+|f_\d+|s|a)/
	 *   - nextGet (default: $get)
	 *   - idMax (default: 0)
	 *   - is_read (default: true)
	 */
	public function readAction() {
		$id = Minz_Request::param('id');
		$get = Minz_Request::param('get');
		$next_get = Minz_Request::param('nextGet', $get);
		$id_max = Minz_Request::param('idMax', 0);
		$is_read = (bool)(Minz_Request::param('is_read', true));
		FreshRSS_Context::$search = new FreshRSS_BooleanSearch(Minz_Request::param('search', ''));

		FreshRSS_Context::$state = Minz_Request::param('state', 0);
		if (FreshRSS_Context::isStateEnabled(FreshRSS_Entry::STATE_FAVORITE)) {
			FreshRSS_Context::$state = FreshRSS_Entry::STATE_FAVORITE;
		} elseif (FreshRSS_Context::isStateEnabled(FreshRSS_Entry::STATE_NOT_FAVORITE)) {
			FreshRSS_Context::$state = FreshRSS_Entry::STATE_NOT_FAVORITE;
		} else {
			FreshRSS_Context::$state = 0;
		}

		$params = array();
		$this->view->tags = array();

		$entryDAO = FreshRSS_Factory::createEntryDao();
		if ($id === false) {
			// id is false? It MUST be a POST request!
			if (!Minz_Request::isPost()) {
				Minz_Request::bad(_t('feedback.access.not_found'), array('c' => 'index', 'a' => 'index'));
				return;
			}

			if (!$get) {
				// No get? Mark all entries as read (from $id_max)
				$entryDAO->markReadEntries($id_max, $is_read);
			} else {
				$type_get = $get[0];
				$get = substr($get, 2);
				switch($type_get) {
				case 'c':
					$entryDAO->markReadCat($get, $id_max, FreshRSS_Context::$search, FreshRSS_Context::$state, $is_read);
					break;
				case 'f':
					$entryDAO->markReadFeed($get, $id_max, FreshRSS_Context::$search, FreshRSS_Context::$state, $is_read);
					break;
				case 's':
					$entryDAO->markReadEntries($id_max, true, 0, FreshRSS_Context::$search, FreshRSS_Context::$state, $is_read);
					break;
				case 'a':
					$entryDAO->markReadEntries($id_max, false, 0, FreshRSS_Context::$search, FreshRSS_Context::$state, $is_read);
					break;
				case 't':
					$entryDAO->markReadTag($get, $id_max, FreshRSS_Context::$search, FreshRSS_Context::$state, $is_read);
					break;
				case 'T':
					$entryDAO->markReadTag('', $id_max, FreshRSS_Context::$search, FreshRSS_Context::$state, $is_read);
					break;
				}

				if ($next_get !== 'a') {
					// Redirect to the correct page (category, feed or starred)
					// Not "a" because it is the default value if nothing is given.
					$params['get'] = $next_get;
				}
			}
		} else {
			$entryDAO->markRead($id, $is_read);

			$tagDAO = FreshRSS_Factory::createTagDao();
			foreach ($tagDAO->getTagsForEntry($id) as $tag) {
				if (!empty($tag['checked'])) {
					$this->view->tags[] = $tag['id'];
				}
			}
		}

		if (!$this->ajax) {
			Minz_Request::good(_t($is_read ? 'feedback.sub.articles.marked_read' : 'feedback.sub.articles.marked_unread'),
			array(
				'c' => 'index',
				'a' => 'index',
				'params' => $params,
			), true);
		}
	}

	/**
	 * This action marks an entry as favourite (bookmark) or not.
	 *
	 * Parameter is:
	 *   - id (default: false)
	 *   - is_favorite (default: true)
	 * If id is false, nothing happened.
	 */
	public function bookmarkAction() {
		$id = Minz_Request::param('id');
		$is_favourite = (bool)Minz_Request::param('is_favorite', true);
		if ($id !== false) {
			$entryDAO = FreshRSS_Factory::createEntryDao();
			$entryDAO->markFavorite($id, $is_favourite);
		}

		if (!$this->ajax) {
			Minz_Request::forward(array(
				'c' => 'index',
				'a' => 'index',
			), true);
		}
	}

	/**
	 * This action optimizes database to reduce its size.
	 *
	 * This action shouldbe reached by a POST request.
	 *
	 * @todo move this action in configure controller.
	 * @todo call this action through web-cron when available
	 */
	public function optimizeAction() {
		$url_redirect = array(
			'c' => 'configure',
			'a' => 'archiving',
		);

		if (!Minz_Request::isPost()) {
			Minz_Request::forward($url_redirect, true);
		}

		@set_time_limit(300);

		$databaseDAO = FreshRSS_Factory::createDatabaseDAO();
		$databaseDAO->optimize();

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$feedDAO->updateCachedValues();

		invalidateHttpCache();
		Minz_Request::good(_t('feedback.admin.optimization_complete'), $url_redirect);
	}

	/**
	 * This action purges old entries from feeds.
	 *
	 * @todo should be a POST request
	 * @todo should be in feedController
	 */
	public function purgeAction() {
		@set_time_limit(300);

		$nb_month_old = max(FreshRSS_Context::$user_conf->old_entries, 1);
		$date_min = time() - (3600 * 24 * 30 * $nb_month_old);

		$entryDAO = FreshRSS_Factory::createEntryDao();
		$feedDAO = FreshRSS_Factory::createFeedDao();
		$feeds = $feedDAO->listFeeds();
		$nb_total = 0;

		invalidateHttpCache();

		foreach ($feeds as $feed) {
			$feed_history = $feed->keepHistory();
			if (FreshRSS_Feed::KEEP_HISTORY_DEFAULT === $feed_history) {
				$feed_history = FreshRSS_Context::$user_conf->keep_history_default;
			}

			if ($feed_history >= 0) {
				$nb = $entryDAO->cleanOldEntries($feed->id(), $date_min, $feed_history);
				if ($nb > 0) {
					$nb_total += $nb;
					Minz_Log::debug($nb . ' old entries cleaned in feed [' . $feed->url(false) . ']');
				}
			}
		}

		$feedDAO->updateCachedValues();

		invalidateHttpCache();
		Minz_Request::good(_t('feedback.sub.purge_completed', $nb_total), array(
			'c' => 'configure',
			'a' => 'archiving'
		));
	}
}
