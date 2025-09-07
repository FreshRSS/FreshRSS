<?php
declare(strict_types=1);

/**
 * Controller to handle every entry actions.
 */
class FreshRSS_entry_Controller extends FreshRSS_ActionController {

	/**
	 * JavaScript request or not.
	 */
	private bool $ajax = false;

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

		// If ajax request, we do not print layout
		$this->ajax = Minz_Request::paramBoolean('ajax');
		if ($this->ajax) {
			$this->view->_layout(null);
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
	public function readAction(): void {
		$get = Minz_Request::paramString('get');
		$next_get = Minz_Request::paramString('nextGet') ?: $get;
		$id_max = Minz_Request::paramString('idMax');
		if (!ctype_digit($id_max)) {
			$id_max = '0';
		}
		$is_read = Minz_Request::paramTernary('is_read') ?? true;
		FreshRSS_Context::$search = new FreshRSS_BooleanSearch(Minz_Request::paramString('search'));

		FreshRSS_Context::$state = Minz_Request::paramInt('state');
		if (FreshRSS_Context::isStateEnabled(FreshRSS_Entry::STATE_FAVORITE)) {
			if (!FreshRSS_Context::isStateEnabled(FreshRSS_Entry::STATE_NOT_FAVORITE)) {
				FreshRSS_Context::$state = FreshRSS_Entry::STATE_FAVORITE;
			}
		} elseif (FreshRSS_Context::isStateEnabled(FreshRSS_Entry::STATE_NOT_FAVORITE)) {
			FreshRSS_Context::$state = FreshRSS_Entry::STATE_NOT_FAVORITE;
		} else {
			FreshRSS_Context::$state = 0;
		}

		$params = [];
		$this->view->tagsForEntries = [];

		$entryDAO = FreshRSS_Factory::createEntryDao();
		if (!Minz_Request::hasParam('id')) {
			// No id, then it MUST be a POST request
			if (!Minz_Request::isPost()) {
				Minz_Request::bad(_t('feedback.access.not_found'), ['c' => 'index', 'a' => 'index']);
				return;
			}

			if ($get === '') {
				// No get? Mark all entries as read (from $id_max)
				$entryDAO->markReadEntries($id_max, false, FreshRSS_Feed::PRIORITY_MAIN_STREAM, FreshRSS_Feed::PRIORITY_IMPORTANT, null, 0, $is_read);
			} else {
				$type_get = $get[0];
				$get = (int)substr($get, 2);
				switch ($type_get) {
					case 'c':
						$entryDAO->markReadCat($get, $id_max, FreshRSS_Context::$search, FreshRSS_Context::$state, $is_read);
						break;
					case 'f':
						$entryDAO->markReadFeed($get, $id_max, FreshRSS_Context::$search, FreshRSS_Context::$state, $is_read);
						break;
					case 's':
						$entryDAO->markReadEntries($id_max, true, null, FreshRSS_Feed::PRIORITY_IMPORTANT,
							FreshRSS_Context::$search, FreshRSS_Context::$state, $is_read);
						break;
					case 'a':
						$entryDAO->markReadEntries($id_max, false, FreshRSS_Feed::PRIORITY_MAIN_STREAM, FreshRSS_Feed::PRIORITY_IMPORTANT,
							FreshRSS_Context::$search, FreshRSS_Context::$state, $is_read);
						break;
					case 'A':
						$entryDAO->markReadEntries($id_max, false, FreshRSS_Feed::PRIORITY_CATEGORY, FreshRSS_Feed::PRIORITY_IMPORTANT,
							FreshRSS_Context::$search, FreshRSS_Context::$state, $is_read);
						break;
					case 'Z':
						$entryDAO->markReadEntries($id_max, false, FreshRSS_Feed::PRIORITY_ARCHIVED, FreshRSS_Feed::PRIORITY_IMPORTANT,
							FreshRSS_Context::$search, FreshRSS_Context::$state, $is_read);
						break;
					case 'i':
						$entryDAO->markReadEntries($id_max, false, FreshRSS_Feed::PRIORITY_IMPORTANT, null,
							FreshRSS_Context::$search, FreshRSS_Context::$state, $is_read);
						break;
					case 't':
						$entryDAO->markReadTag($get, $id_max, FreshRSS_Context::$search, FreshRSS_Context::$state, $is_read);
						// Marking all entries in a tag as read can result in other tags also having all entries marked as read,
						// so the next unread tag calculation is deferred by passing next_get = 'a' instead of the current get ID.
						if ($next_get === 'a' && $is_read) {
							$tagDAO = FreshRSS_Factory::createTagDao();
							$tagsList = $tagDAO->listTags();
							$found_tag = false;
							foreach ($tagsList as $tag) {
								if ($found_tag) {
									// Found the tag matching our current ID already, so now we're just looking for the first unread
									if ($tag->nbUnread() > 0) {
										$next_get = 't_' . $tag->id();
										break;
									}
								} else {
									// Still looking for the tag ID matching our $get that was just marked as read
									if ($tag->id() === $get) {
										$found_tag = true;
									}
								}
							}
							// Didn't find any unread tags after the current one? Start over from the beginning.
							if ($next_get === 'a') {
								foreach ($tagsList as $tag) {
									// Check this first so we can return to the current tag if it's the only one that's unread
									if ($tag->nbUnread() > 0) {
										$next_get = 't_' . $tag->id();
										break;
									}
									// Give up if reached our first tag again
									if ($tag->id() === $get) {
										break;
									}
								}
							}
							// If we still haven't found any unread tags, fallback to the full tag list
							if ($next_get === 'a') {
								$next_get = 'T';
							}
						}
						break;
					case 'T':
						$entryDAO->markReadTag(0, $id_max, FreshRSS_Context::$search, FreshRSS_Context::$state, $is_read);
						break;
				}

				if ($next_get !== 'a') {
					// Redirect to the correct page (category, feed or starred)
					// Not "a" because it is the default value if nothing is given.
					$params['get'] = $next_get;
				}
			}
		} else {
			/** @var list<numeric-string> $idArray */
			$idArray = Minz_Request::paramArrayString('id');
			$idString = Minz_Request::paramString('id');
			if (count($idArray) > 0) {
				$ids = $idArray;
			} elseif (ctype_digit($idString)) {
				$ids = [$idString];
			} else {
				$ids = [];
			}
			$entryDAO->markRead($ids, $is_read);
			$tagDAO = FreshRSS_Factory::createTagDao();
			$tagsForEntries = $tagDAO->getTagsForEntries($ids) ?? [];
			$tags = [];
			foreach ($tagsForEntries as $line) {
				$tags['t_' . $line['id_tag']][] = (string)$line['id_entry'];
			}
			$this->view->tagsForEntries = $tags;
		}

		if (!$this->ajax) {
			Minz_Request::good(
				$is_read ? _t('feedback.sub.articles.marked_read') : _t('feedback.sub.articles.marked_unread'),
				[
					'c' => 'index',
					'a' => 'index',
					'params' => $params,
				],
				'readAction'
			);
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
	public function bookmarkAction(): void {
		$id = Minz_Request::paramString('id');
		$is_favourite = Minz_Request::paramTernary('is_favorite') ?? true;
		if ($id != '' && ctype_digit($id)) {
			$entryDAO = FreshRSS_Factory::createEntryDao();
			$entryDAO->markFavorite($id, $is_favourite);
		}

		if (!$this->ajax) {
			Minz_Request::forward([
				'c' => 'index',
				'a' => 'index',
			], true);
		}
	}

	/**
	 * This action optimizes database to reduce its size.
	 *
	 * This action should be reached by a POST request.
	 *
	 * @todo move this action in configure controller.
	 * @todo call this action through web-cron when available
	 */
	public function optimizeAction(): void {
		$url_redirect = [
			'c' => 'configure',
			'a' => 'archiving',
		];

		if (!Minz_Request::isPost()) {
			Minz_Request::forward($url_redirect, true);
		}

		if (function_exists('set_time_limit')) {
			@set_time_limit(300);
		}

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
	public function purgeAction(): void {
		if (function_exists('set_time_limit')) {
			@set_time_limit(300);
		}

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$feeds = $feedDAO->listFeeds();
		$nb_total = 0;

		invalidateHttpCache();

		$feedDAO->beginTransaction();

		foreach ($feeds as $feed) {
			$nb_total += ($feed->cleanOldEntries() ?: 0);
		}

		$feedDAO->updateCachedValues();
		$feedDAO->commit();

		$databaseDAO = FreshRSS_Factory::createDatabaseDAO();
		$databaseDAO->minorDbMaintenance();

		invalidateHttpCache();
		Minz_Request::good(_t('feedback.sub.purge_completed', $nb_total), [
			'c' => 'configure',
			'a' => 'archiving',
		]);
	}
}
