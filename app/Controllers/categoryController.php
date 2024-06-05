<?php
declare(strict_types=1);

/**
 * Controller to handle actions relative to categories.
 * User needs to be connected.
 */
class FreshRSS_category_Controller extends FreshRSS_ActionController {
	/**
	 * This action is called before every other action in that class. It is
	 * the common boiler plate for every action. It is triggered by the
	 * underlying framework.
	 *
	 */
	#[\Override]
	public function firstAction(): void {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}

		$catDAO = FreshRSS_Factory::createCategoryDao();
		$catDAO->checkDefault();
	}

	/**
	 * This action creates a new category.
	 *
	 * Request parameter is:
	 *   - new-category
	 */
	public function createAction() :void {
		$catDAO = FreshRSS_Factory::createCategoryDao();
		$tagDAO = FreshRSS_Factory::createTagDao();

		$url_redirect = ['c' => 'subscription', 'a' => 'add'];

		$limits = FreshRSS_Context::systemConf()->limits;
		$this->view->categories = $catDAO->listCategories(false) ?: [];

		if (count($this->view->categories) >= $limits['max_categories']) {
			Minz_Request::bad(_t('feedback.sub.category.over_max', $limits['max_categories']), $url_redirect);
		}

		if (Minz_Request::isPost()) {
			invalidateHttpCache();

			$cat_name = Minz_Request::paramString('new-category');
			if ($cat_name === '') {
				Minz_Request::bad(_t('feedback.sub.category.no_name'), $url_redirect);
			}

			$cat = new FreshRSS_Category($cat_name);

			if ($catDAO->searchByName($cat->name()) != null) {
				Minz_Request::bad(_t('feedback.sub.category.name_exists'), $url_redirect);
			}

			if ($tagDAO->searchByName($cat->name()) != null) {
				Minz_Request::bad(_t('feedback.tag.name_exists', $cat->name()), $url_redirect);
			}

			$opml_url = checkUrl(Minz_Request::paramString('opml_url'));
			if ($opml_url != '') {
				$cat->_kind(FreshRSS_Category::KIND_DYNAMIC_OPML);
				$cat->_attribute('opml_url', $opml_url);
			} else {
				$cat->_kind(FreshRSS_Category::KIND_NORMAL);
				$cat->_attribute('opml_url', null);
			}

			if ($catDAO->addCategoryObject($cat)) {
				$url_redirect['a'] = 'index';
				Minz_Request::good(_t('feedback.sub.category.created', $cat->name()), $url_redirect);
			} else {
				Minz_Request::bad(_t('feedback.sub.category.error'), $url_redirect);
			}
		}

		Minz_Request::forward($url_redirect, true);
	}

	/**
	 * This action updates the given category.
	 */
	public function updateAction(): void {
		if (Minz_Request::paramBoolean('ajax')) {
			$this->view->_layout(null);
		}

		$categoryDAO = FreshRSS_Factory::createCategoryDao();

		$id = Minz_Request::paramInt('id');
		$category = $categoryDAO->searchById($id);
		if ($id === 0 || null === $category) {
			Minz_Error::error(404);
			return;
		}
		$this->view->category = $category;

		FreshRSS_View::prependTitle($category->name() . ' · ' . _t('sub.title') . ' · ');

		if (Minz_Request::isPost()) {
			$category->_filtersAction('read', Minz_Request::paramTextToArray('filteractions_read'));

			if (Minz_Request::paramBoolean('use_default_purge_options')) {
				$category->_attribute('archiving', null);
			} else {
				if (!Minz_Request::paramBoolean('enable_keep_max')) {
					$keepMax = false;
				} elseif (($keepMax = Minz_Request::paramInt('keep_max')) !== 0) {
					$keepMax = FreshRSS_Feed::ARCHIVING_RETENTION_COUNT_LIMIT;
				}
				if (Minz_Request::paramBoolean('enable_keep_period')) {
					$keepPeriod = FreshRSS_Feed::ARCHIVING_RETENTION_PERIOD;
					if (is_numeric(Minz_Request::paramString('keep_period_count')) && preg_match('/^PT?1[YMWDH]$/', Minz_Request::paramString('keep_period_unit'))) {
						$keepPeriod = str_replace('1', Minz_Request::paramString('keep_period_count'), Minz_Request::paramString('keep_period_unit'));
					}
				} else {
					$keepPeriod = false;
				}
				$category->_attribute('archiving', [
					'keep_period' => $keepPeriod,
					'keep_max' => $keepMax,
					'keep_min' => Minz_Request::paramInt('keep_min'),
					'keep_favourites' => Minz_Request::paramBoolean('keep_favourites'),
					'keep_labels' => Minz_Request::paramBoolean('keep_labels'),
					'keep_unreads' => Minz_Request::paramBoolean('keep_unreads'),
				]);
			}

			$position = Minz_Request::paramInt('position') ?: null;
			$category->_attribute('position', $position);

			$opml_url = checkUrl(Minz_Request::paramString('opml_url'));
			if ($opml_url != '') {
				$category->_kind(FreshRSS_Category::KIND_DYNAMIC_OPML);
				$category->_attribute('opml_url', $opml_url);
			} else {
				$category->_kind(FreshRSS_Category::KIND_NORMAL);
				$category->_attribute('opml_url', null);
			}

			$values = [
				'kind' => $category->kind(),
				'name' => Minz_Request::paramString('name'),
				'attributes' => $category->attributes(),
			];

			invalidateHttpCache();

			$url_redirect = ['c' => 'subscription', 'params' => ['id' => $id, 'type' => 'category']];
			if (false !== $categoryDAO->updateCategory($id, $values)) {
				Minz_Request::good(_t('feedback.sub.category.updated'), $url_redirect);
			} else {
				Minz_Request::bad(_t('feedback.sub.category.error'), $url_redirect);
			}
		}
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
		$feedDAO = FreshRSS_Factory::createFeedDao();
		$catDAO = FreshRSS_Factory::createCategoryDao();
		$url_redirect = ['c' => 'subscription', 'a' => 'index'];

		if (Minz_Request::isPost()) {
			invalidateHttpCache();

			$id = Minz_Request::paramInt('id');
			if ($id === 0) {
				Minz_Request::bad(_t('feedback.sub.category.no_id'), $url_redirect);
			}

			if ($id === FreshRSS_CategoryDAO::DEFAULTCATEGORYID) {
				Minz_Request::bad(_t('feedback.sub.category.not_delete_default'), $url_redirect);
			}

			if ($feedDAO->changeCategory($id, FreshRSS_CategoryDAO::DEFAULTCATEGORYID) === false) {
				Minz_Request::bad(_t('feedback.sub.category.error'), $url_redirect);
			}

			if ($catDAO->deleteCategory($id) === false) {
				Minz_Request::bad(_t('feedback.sub.category.error'), $url_redirect);
			}

			// Remove related queries.
			/** @var array<array{'get'?:string,'name'?:string,'order'?:string,'search'?:string,'state'?:int,'url'?:string}> $queries */
			$queries = remove_query_by_get('c_' . $id, FreshRSS_Context::userConf()->queries);
			FreshRSS_Context::userConf()->queries = $queries;
			FreshRSS_Context::userConf()->save();

			Minz_Request::good(_t('feedback.sub.category.deleted'), $url_redirect);
		}

		Minz_Request::forward($url_redirect, true);
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
		$feedDAO = FreshRSS_Factory::createFeedDao();
		$url_redirect = ['c' => 'subscription', 'a' => 'index'];

		if (Minz_Request::isPost()) {
			invalidateHttpCache();

			$id = Minz_Request::paramInt('id');
			if ($id === 0) {
				Minz_Request::bad(_t('feedback.sub.category.no_id'), $url_redirect);
			}

			$muted = Minz_Request::paramTernary('muted');

			// List feeds to remove then related user queries.
			$feeds = $feedDAO->listByCategory($id, $muted);

			if ($feedDAO->deleteFeedByCategory($id, $muted)) {
				// TODO: Delete old favicons

				// Remove related queries
				foreach ($feeds as $feed) {
					/** @var array<array{'get'?:string,'name'?:string,'order'?:string,'search'?:string,'state'?:int,'url'?:string}> */
					$queries = remove_query_by_get('f_' . $feed->id(), FreshRSS_Context::userConf()->queries);
					FreshRSS_Context::userConf()->queries = $queries;
				}
				FreshRSS_Context::userConf()->save();

				Minz_Request::good(_t('feedback.sub.category.emptied'), $url_redirect);
			} else {
				Minz_Request::bad(_t('feedback.sub.category.error'), $url_redirect);
			}
		}

		Minz_Request::forward($url_redirect, true);
	}

	/**
	 * Request parameter is:
	 * - id (of a category)
	 */
	public function refreshOpmlAction(): void {
		$catDAO = FreshRSS_Factory::createCategoryDao();
		$url_redirect = ['c' => 'subscription', 'a' => 'index'];

		if (Minz_Request::isPost()) {
			invalidateHttpCache();

			$id = Minz_Request::paramInt('id');
			if ($id === 0) {
				Minz_Request::bad(_t('feedback.sub.category.no_id'), $url_redirect);
				return;
			}

			$category = $catDAO->searchById($id);
			if ($category === null) {
				Minz_Request::bad(_t('feedback.sub.category.not_exist'), $url_redirect);
				return;
			}

			invalidateHttpCache();

			$ok = $category->refreshDynamicOpml();

			if (Minz_Request::paramBoolean('ajax')) {
				Minz_Request::setGoodNotification(_t('feedback.sub.category.updated'));
				$this->view->_layout(null);
			} else {
				if ($ok) {
					Minz_Request::good(_t('feedback.sub.category.updated'), $url_redirect);
				} else {
					Minz_Request::bad(_t('feedback.sub.category.error'), $url_redirect);
				}
				Minz_Request::forward($url_redirect, true);
			}
		}
	}

	/** @return array<string,int> */
	public static function refreshDynamicOpmls(): array {
		$successes = 0;
		$errors = 0;
		$catDAO = FreshRSS_Factory::createCategoryDao();
		$categories = $catDAO->listCategoriesOrderUpdate(FreshRSS_Context::userConf()->dynamic_opml_ttl_default ?? 86400);
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
