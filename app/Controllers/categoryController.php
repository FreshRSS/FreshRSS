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
	 * URL parameter is:
	 *   - new-category
	 */
	public function createAction() {
		$catDAO = new FreshRSS_CategoryDAO();
		$url_redirect = array('c' => 'configure', 'a' => 'categorize');

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
				Minz_Request::bad(_t('category_not_created'), $url_redirect);
			}
		}

		Minz_Request::forward($url_redirect, true);
	}
}
