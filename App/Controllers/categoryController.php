<?php

namespace Freshrss\Controllers;

/**
 * Controller to handle actions relative to categories.
 * User needs to be connected.
 */
class category_Controller extends ActionController {
	/**
	 * This action is called before every other action in that class. It is
	 * the common boiler plate for every action. It is triggered by the
	 * underlying framework.
	 *
	 */
	public function firstAction() {
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
	public function createAction() {
		$catDAO = Factory::createCategoryDao();
		$url_redirect = array('c' => 'subscription', 'a' => 'index');

		$limits = Context::$system_conf->limits;
		$this->view->categories = $catDAO->listCategories(false);

		if (count($this->view->categories) >= $limits['max_categories']) {
			Request::bad(_t('feedback.sub.category.over_max', $limits['max_categories']),
			                  $url_redirect);
		}

		if (Request::isPost()) {
			invalidateHttpCache();

			$cat_name = Request::param('new-category');
			if (!$cat_name) {
				Request::bad(_t('feedback.sub.category.no_name'), $url_redirect);
			}

			$cat = new Category($cat_name);

			if ($catDAO->searchByName($cat->name()) != null) {
				Request::bad(_t('feedback.sub.category.name_exists'), $url_redirect);
			}

			$values = array(
				'id' => $cat->id(),
				'name' => $cat->name(),
			);

			if ($catDAO->addCategory($values)) {
				Request::good(_t('feedback.sub.category.created', $cat->name()), $url_redirect);
			} else {
				Request::bad(_t('feedback.sub.category.error'), $url_redirect);
			}
		}

		Request::forward($url_redirect, true);
	}

	/**
	 * This action updates the given category.
	 *
	 * Request parameters are:
	 *   - id
	 *   - name
	 */
	public function updateAction() {
		$catDAO = Factory::createCategoryDao();
		$url_redirect = array('c' => 'subscription', 'a' => 'index');

		if (Request::isPost()) {
			invalidateHttpCache();

			$id = Request::param('id');
			$name = Request::param('name', '');
			if (strlen($name) <= 0) {
				Request::bad(_t('feedback.sub.category.no_name'), $url_redirect);
			}

			if ($catDAO->searchById($id) == null) {
				Request::bad(_t('feedback.sub.category.not_exist'), $url_redirect);
			}

			$cat = new Category($name);
			$values = array(
				'name' => $cat->name(),
			);

			if ($catDAO->updateCategory($id, $values)) {
				Request::good(_t('feedback.sub.category.updated'), $url_redirect);
			} else {
				Request::bad(_t('feedback.sub.category.error'), $url_redirect);
			}
		}

		Request::forward($url_redirect, true);
	}

	/**
	 * This action deletes a category.
	 * Feeds in the given category are moved in the default category.
	 * Related user queries are deleted too.
	 *
	 * Request parameter is:
	 *   - id (of a category)
	 */
	public function deleteAction() {
		$feedDAO = Factory::createFeedDao();
		$catDAO = Factory::createCategoryDao();
		$url_redirect = array('c' => 'subscription', 'a' => 'index');

		if (Request::isPost()) {
			invalidateHttpCache();

			$id = Request::param('id');
			if (!$id) {
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
			Context::$user_conf->queries = remove_query_by_get(
				'c_' . $id, Context::$user_conf->queries);
			Context::$user_conf->save();

			Request::good(_t('feedback.sub.category.deleted'), $url_redirect);
		}

		Request::forward($url_redirect, true);
	}

	/**
	 * This action deletes all the feeds relative to a given category.
	 * Feed-related queries are deleted.
	 *
	 * Request parameter is:
	 *   - id (of a category)
	 */
	public function emptyAction() {
		$feedDAO = Factory::createFeedDao();
		$url_redirect = array('c' => 'subscription', 'a' => 'index');

		if (Request::isPost()) {
			invalidateHttpCache();

			$id = Request::param('id');
			if (!$id) {
				Request::bad(_t('feedback.sub.category.no_id'), $url_redirect);
			}

			// List feeds to remove then related user queries.
			$feeds = $feedDAO->listByCategory($id);

			if ($feedDAO->deleteFeedByCategory($id)) {
				// TODO: Delete old favicons

				// Remove related queries
				foreach ($feeds as $feed) {
					Context::$user_conf->queries = remove_query_by_get(
						'f_' . $feed->id(), Context::$user_conf->queries);
				}
				Context::$user_conf->save();

				Request::good(_t('feedback.sub.category.emptied'), $url_redirect);
			} else {
				Request::bad(_t('feedback.sub.category.error'), $url_redirect);
			}
		}

		Request::forward($url_redirect, true);
	}
}
