<?php

/**
 * Controller to handle actions relative to categories.
 * User needs to be connected.
 */
class FreshRSS_category_Controller extends Minz_ActionController {
	/**
	 * This action is called before every other action in that class. It is
	 * the common boiler plate for every action. It is triggered by the
	 * underlying framework.
	 *
	 */
	public function firstAction() {
		if (!$this->view->loginOk) {
			Minz_Error::error(
				403,
				array('error' => array(_t('access_denied')))
			);
		}

		$catDAO = new FreshRSS_CategoryDAO();
		$catDAO->checkDefault();
	}

	/**
	 * This action creates a new category.
	 *
	 * Request parameter is:
	 *   - new-category
	 */
	public function createAction() {
		$catDAO = new FreshRSS_CategoryDAO();
		$url_redirect = array('c' => 'subscription', 'a' => 'index');

		if (Minz_Request::isPost()) {
			invalidateHttpCache();

			$cat_name = Minz_Request::param('new-category');
			if (!$cat_name) {
				Minz_Request::bad(_t('category_no_name'), $url_redirect);
			}

			$cat = new FreshRSS_Category($cat_name);

			if ($catDAO->searchByName($cat->name()) != null) {
				Minz_Request::bad(_t('category_name_exists'), $url_redirect);
			}

			$values = array(
				'id' => $cat->id(),
				'name' => $cat->name(),
			);

			if ($catDAO->addCategory($values)) {
				Minz_Request::good(_t('category_created', $cat->name()), $url_redirect);
			} else {
				Minz_Request::bad(_t('error_occurred'), $url_redirect);
			}
		}

		Minz_Request::forward($url_redirect, true);
	}

	/**
	 * This action updates the given category.
	 *
	 * Request parameters are:
	 *   - id
	 *   - name
	 */
	public function updateAction() {
		$catDAO = new FreshRSS_CategoryDAO();
		$url_redirect = array('c' => 'subscription', 'a' => 'index');

		if (Minz_Request::isPost()) {
			invalidateHttpCache();

			$id = Minz_Request::param('id');
			$name = Minz_Request::param('name', '');
			if (strlen($name) <= 0) {
				Minz_Request::bad(_t('category_no_name'), $url_redirect);
			}

			if ($catDAO->searchById($id) == null) {
				Minz_Request::bad(_t('category_not_exist'), $url_redirect);
			}

			$cat = new FreshRSS_Category($name);
			$values = array(
				'name' => $cat->name(),
			);

			if ($catDAO->updateCategory($id, $values)) {
				Minz_Request::good(_t('category_updated'), $url_redirect);
			} else {
				Minz_Request::bad(_t('error_occurred'), $url_redirect);
			}
		}

		Minz_Request::forward($url_redirect, true);
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
		$feedDAO = FreshRSS_Factory::createFeedDao();
		$catDAO = new FreshRSS_CategoryDAO();
		$default_category = $catDAO->getDefault();
		$url_redirect = array('c' => 'subscription', 'a' => 'index');

		if (Minz_Request::isPost()) {
			invalidateHttpCache();

			$id = Minz_Request::param('id');
			if (!$id) {
				Minz_Request::bad(_t('category_no_id'), $url_redirect);
			}

			if ($feedDAO->changeCategory($id, $default_category->id()) === false) {
				Minz_Request::bad(_t('error_occurred'), $url_redirect);
			}

			if ($catDAO->deleteCategory($id) === false) {
				Minz_Request::bad(_t('error_occurred'), $url_redirect);
			}

			// Remove related queries.
			$this->view->conf->remove_query_by_get('c_' . $id);
			$this->view->conf->save();

			Minz_Request::good(_t('category_deleted'), $url_redirect);
		}

		Minz_Request::forward($url_redirect, true);
	}

	/**
	 * This action deletes all the feeds relative to a given category.
	 * Feed-related queries are deleted.
	 *
	 * Request parameter is:
	 *   - id (of a category)
	 */
	public function emptyAction() {
		$feedDAO = FreshRSS_Factory::createFeedDao();
		$url_redirect = array('c' => 'subscription', 'a' => 'index');

		if (Minz_Request::isPost()) {
			invalidateHttpCache();

			$id = Minz_Request::param('id');
			if (!$id) {
				Minz_Request::bad(_t('category_no_id'), $url_redirect);
			}

			// List feeds to remove then related user queries.
			$feeds = $feedDAO->listByCategory($id);

			if ($feedDAO->deleteFeedByCategory($id)) {
				// TODO: Delete old favicons

				// Remove related queries
				foreach ($feeds as $feed) {
					$this->view->conf->remove_query_by_get('f_' . $feed->id());
				}
				$this->view->conf->save();

				Minz_Request::good(_t('category_emptied'), $url_redirect);
			} else {
				Minz_Request::bad(_t('error_occurred'), $url_redirect);
			}
		}

		Minz_Request::forward($url_redirect, true);
	}
}
