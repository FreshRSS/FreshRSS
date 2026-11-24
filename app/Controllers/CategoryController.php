<?php
declare(strict_types=1);

namespace FreshRss\Controllers;

use FreshRss\Minz\Error;
use FreshRss\Minz\Request;
use FreshRss\Models\ActionController;
use FreshRss\Models\Auth;
use FreshRss\Models\Category;
use FreshRss\Models\CategoryDAO;
use FreshRss\Models\Context;
use FreshRss\Models\Factory;
use FreshRss\Models\Feed;
use FreshRss\Models\UserQuery;
use FreshRss\Models\View;
use FreshRss\Utils\HttpUtil;

/**
 * Controller to handle actions relative to categories.
 * User needs to be connected.
 */
class CategoryController extends ActionController {
	/**
	 * This action is called before every other action in that class. It is
	 * the common boiler plate for every action. It is triggered by the
	 * underlying framework.
	 *
	 */
	#[\Override]
	public function firstAction(): void {
		if (!Auth::hasAccess()) {
			Error::error(403);
		}

		$catDAO = Factory::createCategoryDao();
		$catDAO->checkDefault();
	}

	/**
	 * This action creates a new category.
	 *
	 * Request parameter is:
	 *   - new-category
	 */
	public function createAction(): void {
		$catDAO = Factory::createCategoryDao();
		$tagDAO = Factory::createTagDao();

		$url_redirect = ['c' => 'subscription', 'a' => 'add'];

		$limits = Context::systemConf()->limits;
		$this->view->categories = $catDAO->listCategories(prePopulateFeeds: false);

		if (count($this->view->categories) >= $limits['max_categories']) {
			Request::bad(_t('feedback.sub.category.over_max', $limits['max_categories']), $url_redirect);
		}

		if (Request::isPost()) {
			invalidateHttpCache();

			$cat_name = Request::paramString('new-category');
			if ($cat_name === '') {
				Request::bad(_t('feedback.sub.category.no_name'), $url_redirect);
			}

			$cat = new Category($cat_name);

			if ($catDAO->searchByName($cat->name()) != null) {
				Request::bad(_t('feedback.sub.category.name_exists'), $url_redirect);
			}

			if ($tagDAO->searchByName($cat->name()) != null) {
				Request::bad(_t('feedback.tag.name_exists', $cat->name()), $url_redirect);
			}

			$opml_url = HttpUtil::checkUrl(Request::paramString('opml_url', plaintext: true));
			if ($opml_url != '') {
				$cat->_kind(Category::KIND_DYNAMIC_OPML);
				$cat->_attribute('opml_url', $opml_url);
			} else {
				$cat->_kind(Category::KIND_NORMAL);
				$cat->_attribute('opml_url', null);
			}

			if ($catDAO->addCategoryObject($cat)) {
				$url_redirect['a'] = 'index';
				Request::good(
					_t('feedback.sub.category.created', $cat->name()),
					$url_redirect,
					showNotification: Context::userConf()->good_notification_timeout > 0
				);
			} else {
				Request::bad(_t('feedback.sub.category.error'), $url_redirect);
			}
		}

		Request::forward($url_redirect, true);
	}

	/**
	 * This action updates the given category.
	 */
	public function updateAction(): void {
		if (Request::paramBoolean('ajax')) {
			$this->view->_layout(null);
		}

		$categoryDAO = Factory::createCategoryDao();

		$id = Request::paramInt('id');
		$category = $categoryDAO->searchById($id);
		if ($id === 0 || null === $category) {
			Error::error(404);
			return;
		}
		$this->view->category = $category;

		View::prependTitle($category->name() . ' · ' . _t('sub.title') . ' · ');

		if (Request::isPost()) {
			if (Request::paramBoolean('enable_read_when_same_title_in_category')) {
				$category->_attribute('read_when_same_title_in_category', Request::paramInt('read_when_same_title_in_category'));
			} else {
				$category->_attribute('read_when_same_title_in_category', null);
			}
			if (Request::paramBoolean('enable_read_when_same_guid_in_category')) {
				$category->_attribute('read_when_same_guid_in_category', Request::paramInt('read_when_same_guid_in_category'));
			} else {
				$category->_attribute('read_when_same_guid_in_category', null);
			}

			$category->_filtersAction('read', Request::paramTextToArray('filteractions_read', plaintext: true));

			if (Request::paramBoolean('use_default_purge_options')) {
				$category->_attribute('archiving', null);
			} else {
				if (!Request::paramBoolean('enable_keep_max')) {
					$keepMax = false;
				} elseif (($keepMax = Request::paramInt('keep_max')) === 0) {
					$keepMax = Feed::ARCHIVING_RETENTION_COUNT_LIMIT;
				}
				if (Request::paramBoolean('enable_keep_period')) {
					$keepPeriod = Feed::ARCHIVING_RETENTION_PERIOD;
					if (is_numeric(Request::paramString('keep_period_count')) && preg_match('/^PT?1[YMWDH]$/', Request::paramString('keep_period_unit'))) {
						$keepPeriod = str_replace('1', Request::paramString('keep_period_count'), Request::paramString('keep_period_unit'));
					}
				} else {
					$keepPeriod = false;
				}
				$category->_attribute('archiving', [
					'keep_period' => $keepPeriod,
					'keep_max' => $keepMax,
					'keep_min' => Request::paramInt('keep_min'),
					'keep_favourites' => Request::paramBoolean('keep_favourites'),
					'keep_labels' => Request::paramBoolean('keep_labels'),
					'keep_unreads' => Request::paramBoolean('keep_unreads'),
				]);
			}

			$position = Request::paramInt('position') ?: null;
			$category->_attribute('position', $position);

			$opml_url = HttpUtil::checkUrl(Request::paramString('opml_url', plaintext: true));
			if ($opml_url != '') {
				$category->_kind(Category::KIND_DYNAMIC_OPML);
				$category->_attribute('opml_url', $opml_url);
			} else {
				$category->_kind(Category::KIND_NORMAL);
				$category->_attribute('opml_url', null);
			}

			$defaultSortOrder = Request::paramString('defaultSortOrder', plaintext: true);
			if (str_ends_with($defaultSortOrder, '_asc')) {
				$category->_attribute('defaultOrder', 'ASC');
				$defaultSortOrder = substr($defaultSortOrder, 0, -strlen('_asc'));
			} elseif (str_ends_with($defaultSortOrder, '_desc')) {
				$category->_attribute('defaultOrder', 'DESC');
				$defaultSortOrder = substr($defaultSortOrder, 0, -strlen('_desc'));
			} else {
				$category->_attribute('defaultOrder');
			}
			if (in_array($defaultSortOrder, ['id', 'date', 'link', 'title', 'length', 'f.name', 'rand'], true)) {
				$category->_attribute('defaultSort', $defaultSortOrder);
			} else {
				$category->_attribute('defaultSort');
			}

			$category->_attribute('show_unread_count', Request::paramTernary('show_unread_count'));

			$values = [
				'kind' => $category->kind(),
				'name' => Request::paramString('name'),
				'attributes' => $category->attributes(),
			];

			invalidateHttpCache();

			$from = Request::paramString('from');
			$prev_controller = $from === 'update' ? 'category' : 'subscription';
			$url_redirect = ['c' => $prev_controller, 'a' => $from, 'params' => ['id' => $id, 'type' => 'category']];
			if (false !== $categoryDAO->updateCategory($id, $values)) {
				Request::good(
					_t('feedback.sub.category.updated'),
					$url_redirect,
					showNotification: Context::userConf()->good_notification_timeout > 0
				);
			} else {
				Request::bad(_t('feedback.sub.category.error'), $url_redirect);
			}
		}
	}

	public function viewFilterAction(): void {
		$id = Request::paramInt('id');
		if ($id === 0) {
			Error::error(400);
			return;
		}
		$filteractions = Request::paramTextToArray('filteractions_read', plaintext: true);
		$filteractions = array_map(fn(string $action): string => trim($action), $filteractions);
		$filteractions = array_filter($filteractions, fn(string $action): bool => $action !== '');
		$search = "c:$id (";
		foreach ($filteractions as $action) {
			$search .= "($action) OR ";
		}
		$search = preg_replace('/ OR $/', '', $search);
		$search .= ')';
		Request::forward([
			'c' => 'index',
			'a' => 'index',
			'params' => [
				'search' => $search,
			],
		], redirect: true);
	}

	/**
	 * This action deletes a category.
	 * Feeds in the given category are moved in the default category.
	 * Related user queries are deleted too.
	 *
	 * Request parameter is:
	 *   - id (of a category)
	 */
	public function deleteAction(): void {
		$feedDAO = Factory::createFeedDao();
		$catDAO = Factory::createCategoryDao();
		$url_redirect = ['c' => 'subscription', 'a' => 'index'];

		if (Request::isPost()) {
			invalidateHttpCache();

			$id = Request::paramInt('id');
			if ($id === 0) {
				Request::bad(_t('feedback.sub.category.no_id'), $url_redirect);
			}

			if ($id === CategoryDAO::DEFAULTCATEGORYID) {
				Request::bad(_t('feedback.sub.category.not_delete_default'), $url_redirect);
			}

			if ($feedDAO->changeCategory($id, CategoryDAO::DEFAULTCATEGORYID) === false) {
				Request::bad(_t('feedback.sub.category.error'), $url_redirect);
			}

			if ($catDAO->deleteCategory($id) === false) {
				Request::bad(_t('feedback.sub.category.error'), $url_redirect);
			}

			// Remove related queries.
			$queries = UserQuery::remove_query_by_get('c_' . $id, Context::userConf()->queries);
			Context::userConf()->queries = $queries;
			Context::userConf()->save();

			Request::good(
				_t('feedback.sub.category.deleted'),
				$url_redirect,
				showNotification: Context::userConf()->good_notification_timeout > 0
			);
		}

		Request::forward($url_redirect, true);
	}

	/**
	 * This action deletes all the feeds relative to a given category.
	 * Feed-related queries are deleted.
	 *
	 * Request parameter is:
	 *   - id (of a category)
	 *   - muted (truthy to remove only muted feeds, or falsy otherwise)
	 */
	public function emptyAction(): void {
		$feedDAO = Factory::createFeedDao();
		$url_redirect = ['c' => 'subscription', 'a' => 'index'];

		if (Request::isPost()) {
			invalidateHttpCache();

			$id = Request::paramInt('id');
			if ($id === 0) {
				Request::bad(_t('feedback.sub.category.no_id'), $url_redirect);
			}

			$muted = Request::paramTernary('muted');
			$errored = Request::paramTernary('errored');

			// List feeds to remove then related user queries.
			$feeds = $feedDAO->listByCategory($id, $muted, $errored);

			if ($feedDAO->deleteFeedByCategory($id, $muted, $errored)) {
				// TODO: Delete old favicons

				// Remove related queries
				foreach ($feeds as $feed) {
					$queries = UserQuery::remove_query_by_get('f_' . $feed->id(), Context::userConf()->queries);
					Context::userConf()->queries = $queries;
				}
				Context::userConf()->save();

				Request::good(
					_t('feedback.sub.category.emptied'),
					$url_redirect,
					showNotification: Context::userConf()->good_notification_timeout > 0
				);
			} else {
				Request::bad(_t('feedback.sub.category.error'), $url_redirect);
			}
		}

		Request::forward($url_redirect, true);
	}

	/**
	 * Request parameter is:
	 * - id (of a category)
	 */
	public function refreshOpmlAction(): void {
		$catDAO = Factory::createCategoryDao();
		$url_redirect = ['c' => 'subscription', 'a' => 'index'];

		if (Request::isPost()) {
			invalidateHttpCache();

			$id = Request::paramInt('id');
			if ($id === 0) {
				Request::bad(_t('feedback.sub.category.no_id'), $url_redirect);
				return;
			}

			$category = $catDAO->searchById($id);
			if ($category === null) {
				Request::bad(_t('feedback.sub.category.not_exist'), $url_redirect);
				return;
			}

			invalidateHttpCache();

			$ok = $category->refreshDynamicOpml();

			if (Request::paramBoolean('ajax')) {
				Request::setGoodNotification(_t('feedback.sub.category.updated'));
				$this->view->_layout(null);
			} else {
				if ($ok) {
					Request::good(
						_t('feedback.sub.category.updated'),
						$url_redirect,
						showNotification: Context::userConf()->good_notification_timeout > 0
					);
				} else {
					Request::bad(_t('feedback.sub.category.error'), $url_redirect);
				}
				Request::forward($url_redirect, true);
			}
		}
	}

	/** @return array<string,int> */
	public static function refreshDynamicOpmls(): array {
		$successes = 0;
		$errors = 0;
		$catDAO = Factory::createCategoryDao();
		$categories = $catDAO->listCategoriesOrderUpdate(Context::userConf()->dynamic_opml_ttl_default ?? 86400);
		foreach ($categories as $category) {
			if ($category->refreshDynamicOpml()) {
				$successes++;
			} else {
				$errors++;
			}
		}
		return [
			'successes' => $successes,
			'errors' => $errors,
		];
	}
}
