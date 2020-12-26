<?php

/**
 * Controller to handle every entry actions.
 */
class FreshRSS_entry_Controller extends Minz\ActionController {
	/**
	 * This action is called before every other action in that class. It is
	 * the common boiler plate for every action. It is triggered by the
	 * underlying framework.
	 */
	public function firstAction() {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz\Error::error(403);
		}

		// If ajax request, we do not print layout
		$this->ajax = Minz\Request::param('ajax');
		if ($this->ajax) {
			$this->view->_layout(false);
			Minz\Request::_param('ajax');
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
		$id = Minz\Request::param('id');
		$get = Minz\Request::param('get');
		$next_get = Minz\Request::param('nextGet', $get);
		$id_max = Minz\Request::param('idMax', 0);
		$is_read = (bool)(Minz\Request::param('is_read', true));
		FreshRSS_Context::$search = new FreshRSS_BooleanSearch(Minz\Request::param('search', ''));

		FreshRSS_Context::$state = Minz\Request::param('state', 0);
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
			if (!Minz\Request::isPost()) {
				Minz\Request::bad(_t('feedback.access.not_found'), array('c' => 'index', 'a' => 'index'));
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
			$ids = is_array($id) ? $id : array($id);
			$entryDAO->markRead($ids, $is_read);
			$tagDAO = FreshRSS_Factory::createTagDao();
			$tagsForEntries = $tagDAO->getTagsForEntries($ids);
			$tags = array();
			foreach ($tagsForEntries as $line) {
				$tags['t_' . $line['id_tag']][] = $line['id_entry'];
			}
			$this->view->tags = $tags;
		}

		if (!$this->ajax) {
			Minz\Request::good(_t($is_read ? 'feedback.sub.articles.marked_read' : 'feedback.sub.articles.marked_unread'),
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
		$id = Minz\Request::param('id');
		$is_favourite = (bool)Minz\Request::param('is_favorite', true);
		if ($id !== false) {
			$entryDAO = FreshRSS_Factory::createEntryDao();
			$entryDAO->markFavorite($id, $is_favourite);
		}

		if (!$this->ajax) {
			Minz\Request::forward(array(
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

		if (!Minz\Request::isPost()) {
			Minz\Request::forward($url_redirect, true);
		}

		@set_time_limit(300);

		$databaseDAO = FreshRSS_Factory::createDatabaseDAO();
		$databaseDAO->optimize();

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$feedDAO->updateCachedValues();

		invalidateHttpCache();
		Minz\Request::good(_t('feedback.admin.optimization_complete'), $url_redirect);
	}

	/**
	 * This action purges old entries from feeds.
	 *
	 * @todo should be a POST request
	 * @todo should be in feedController
	 */
	public function purgeAction() {
		@set_time_limit(300);

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$feeds = $feedDAO->listFeeds();
		$nb_total = 0;

		invalidateHttpCache();

		$feedDAO->beginTransaction();

		foreach ($feeds as $feed) {
			$nb_total += $feed->cleanOldEntries();
		}

		$feedDAO->updateCachedValues();
		$feedDAO->commit();

		$databaseDAO = FreshRSS_Factory::createDatabaseDAO();
		$databaseDAO->minorDbMaintenance();

		invalidateHttpCache();
		Minz\Request::good(_t('feedback.sub.purge_completed', $nb_total), array(
			'c' => 'configure',
			'a' => 'archiving'
		));
	}
}
