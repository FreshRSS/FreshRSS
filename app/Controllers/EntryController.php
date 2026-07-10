<?php
declare(strict_types=1);

namespace FreshRss\Controllers;

use FreshRss\Minz\Error;
use FreshRss\Minz\Request;
use FreshRss\Models\ActionController;
use FreshRss\Models\Auth;
use FreshRss\Models\BooleanSearch;
use FreshRss\Models\Context;
use FreshRss\Models\Entry;
use FreshRss\Models\Factory;
use FreshRss\Models\Feed;
use FreshRss\Models\Search;

/**
 * Controller to handle every entry actions.
 */
class EntryController extends ActionController {

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
		if (!Auth::hasAccess()) {
			Error::error(403);
		}

		// If ajax request, we do not print layout
		$this->ajax = Request::paramBoolean('ajax');
		if ($this->ajax) {
			$this->view->_layout(null);
			Request::_param('ajax');
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
	 *   - idMax (default: '0')
	 *   - maxPubDate (default: 0)
	 *   - is_read (default: true)
	 */
	public function readAction(): void {
		$get = Request::paramString('get', plaintext: true);
		$next_get = Request::paramString('nextGet', plaintext: true) ?: $get;
		$id_max = Request::paramString('idMax', plaintext: true);
		if (!ctype_digit($id_max)) {
			$id_max = '0';
		}
		$is_read = Request::paramTernary('is_read') ?? true;
		Context::$search = new BooleanSearch(Request::paramString('search', plaintext: true));
		$maxPubDate = Request::paramInt('maxPubDate');
		if ($maxPubDate > 0) {
			$search = new Search('');
			$search->setMaxPubdate($maxPubDate);
			Context::$search->prepend($search);
		}

		Context::$state = Request::paramInt('state');
		if (Context::isStateEnabled(Entry::STATE_FAVORITE)) {
			if (!Context::isStateEnabled(Entry::STATE_NOT_FAVORITE)) {
				Context::$state = Entry::STATE_FAVORITE;
			}
		} elseif (Context::isStateEnabled(Entry::STATE_NOT_FAVORITE)) {
			Context::$state = Entry::STATE_NOT_FAVORITE;
		} else {
			Context::$state = 0;
		}

		$params = [];
		$this->view->tagsForEntries = [];

		$entryDAO = Factory::createEntryDao();
		if (!Request::hasParam('id')) {
			// No id, then it MUST be a POST request
			if (!Request::isPost()) {
				Request::bad(_t('feedback.access.not_found'), ['c' => 'index', 'a' => 'index']);
				return;
			}

			if ($get === '') {
				// No get? Mark all entries as read (from $id_max)
				$entryDAO->markReadEntries($id_max, false, Feed::PRIORITY_MAIN_STREAM, Feed::PRIORITY_IMPORTANT, null, 0, $is_read);
			} else {
				$type_get = $get[0];
				$get = (int)substr($get, 2);
				switch ($type_get) {
					case 'c':	// Category
						$entryDAO->markReadCat($get, $id_max,
							priorityMin: min(Feed::PRIORITY_CATEGORY, Context::$search->needVisibility() ?? Feed::PRIORITY_IMPORTANT),
							filters: Context::$search, state: Context::$state, is_read: $is_read);
						break;
					case 'f':	// Feed
						$entryDAO->markReadFeed($get, $id_max, Context::$search, Context::$state, $is_read);
						break;
					case 's':	// Starred. Deprecated: use $state instead
						$entryDAO->markReadEntries($id_max, onlyFavorites: true,
							priorityMin: null,
							priorityMax: null,
							filters: Context::$search, state: Context::$state, is_read: $is_read);
						break;
					case 'a':	// All PRIORITY_MAIN_STREAM
						$entryDAO->markReadEntries($id_max, onlyFavorites: false,
							priorityMin: min(Feed::PRIORITY_MAIN_STREAM, Context::$search->needVisibility() ?? Feed::PRIORITY_IMPORTANT),
							priorityMax: null,
							filters: Context::$search, state: Context::$state, is_read: $is_read);
						break;
					case 'A':	// All except PRIORITY_HIDDEN
						$entryDAO->markReadEntries($id_max, onlyFavorites: false,
							priorityMin: min(Feed::PRIORITY_CATEGORY, Context::$search->needVisibility() ?? Feed::PRIORITY_IMPORTANT),
							priorityMax: null,
							filters: Context::$search, state: Context::$state, is_read: $is_read);
						break;
					case 'Z':	// All including PRIORITY_HIDDEN
						$entryDAO->markReadEntries($id_max, onlyFavorites: false,
							priorityMin: Feed::PRIORITY_HIDDEN,
							priorityMax: null,
							filters: Context::$search, state: Context::$state, is_read: $is_read);
						break;
					case 'i':	// Priority important feeds
						$entryDAO->markReadEntries($id_max, onlyFavorites: false,
							priorityMin: min(Feed::PRIORITY_IMPORTANT, Context::$search->needVisibility() ?? Feed::PRIORITY_IMPORTANT),
							priorityMax: null,
							filters: Context::$search, state: Context::$state, is_read: $is_read);
						break;
					case 't':	// Tag (label)
						$entryDAO->markReadTag($get, $id_max, Context::$search, Context::$state, $is_read);
						// Marking all entries in a tag as read can result in other tags also having all entries marked as read,
						// so the next unread tag calculation is deferred by passing next_get = 'a' instead of the current get ID.
						if ($next_get === 'a' && $is_read) {
							$tagDAO = Factory::createTagDao();
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
					case 'T':	// Any tag (label)
						$entryDAO->markReadTag(0, $id_max, Context::$search, Context::$state, $is_read);
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
			$idArray = Request::paramArrayString('id', plaintext: true);
			$idString = Request::paramString('id', plaintext: true);
			if (count($idArray) > 0) {
				$ids = $idArray;
			} elseif (ctype_digit($idString)) {
				$ids = [$idString];
			} else {
				$ids = [];
			}
			$entryDAO->markRead($ids, $is_read);
			$tagDAO = Factory::createTagDao();
			$tagsForEntries = $tagDAO->getTagsForEntries($ids) ?? [];
			$tags = [];
			foreach ($tagsForEntries as $line) {
				$tags['t_' . $line['id_tag']][] = (string)$line['id_entry'];
			}
			$this->view->tagsForEntries = $tags;
		}

		if (!$this->ajax) {
			// Preserve the active search and read/favourite state filters across the redirect
			$search = Request::paramString('search', plaintext: true);
			if ($search !== '') {
				$params['search'] = $search;
			}
			$stateParam = Request::paramInt('state');
			if ($stateParam !== 0) {
				$params['state'] = $stateParam;
			}
			if (Context::userConf()->sticky_sort) {
				if (Request::hasParam('order')) {
					$params['order'] = Request::paramString('order', plaintext: true);
				}
				if (Request::hasParam('sort')) {
					$params['sort'] = Request::paramString('sort', plaintext: true);
				}
			}
			Request::good(
				$is_read ? _t('feedback.sub.articles.marked_read') : _t('feedback.sub.articles.marked_unread'),
				[
					'c' => 'index',
					'a' => Request::paramStringNull('from') ?? 'index',
					'params' => $params,
				],
				notificationName: 'readAction ',
				showNotification: Context::userConf()->good_notification_timeout > 0
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
		$id = Request::paramString('id', plaintext: true);
		$is_favourite = Request::paramTernary('is_favorite') ?? true;
		if ($id != '' && ctype_digit($id)) {
			$entryDAO = Factory::createEntryDao();
			$entryDAO->markFavorite($id, $is_favourite);
		}

		if (!$this->ajax) {
			Request::forward([
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

		if (!Request::isPost()) {
			Request::forward($url_redirect, true);
		}

		if (function_exists('set_time_limit')) {
			@set_time_limit(300);
		}

		$databaseDAO = Factory::createDatabaseDAO();
		$databaseDAO->minorDbMaintenance();
		$databaseDAO->optimize();

		$feedDAO = Factory::createFeedDao();
		$feedDAO->updateCachedValues();

		invalidateHttpCache();
		Request::good(
			_t('feedback.admin.optimization_complete'),
			$url_redirect,
			showNotification: Context::userConf()->good_notification_timeout > 0
		);
	}

	/**
	 * This action purges old entries from feeds.
	 *
	 * @todo should be in feedController
	 */
	public function purgeAction(): void {
		if (!Request::isPost()) {
			Error::error(403);
			return;
		}
		if (function_exists('set_time_limit')) {
			@set_time_limit(300);
		}

		$databaseDAO = Factory::createDatabaseDAO();
		$databaseDAO->minorDbMaintenance();

		$feedDAO = Factory::createFeedDao();
		$feeds = $feedDAO->listFeeds();
		$nb_total = 0;

		invalidateHttpCache();

		$feedDAO->beginTransaction();

		foreach ($feeds as $feed) {
			$nb_total += ($feed->cleanOldEntries() ?: 0);
		}

		$feedDAO->updateCachedValues();
		$feedDAO->commit();

		invalidateHttpCache();
		Request::good(
			_t('feedback.sub.purge_completed', $nb_total),
			['c' => 'configure', 'a' => 'archiving'],
			showNotification: Context::userConf()->good_notification_timeout > 0
		);
	}
}
