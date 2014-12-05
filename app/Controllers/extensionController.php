<?php

/**
 * The controller to manage extensions.
 */
class FreshRSS_extension_Controller extends Minz_ActionController {
	/**
	 * This action is called before every other action in that class. It is
	 * the common boiler plate for every action. It is triggered by the
	 * underlying framework.
	 */
	public function firstAction() {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}
	}

	/**
	 * This action lists all the extensions available to the current user.
	 */
	public function indexAction() {
		Minz_View::prependTitle(_t('admin.extensions.title') . ' · ');
		$this->view->extension_list = Minz_ExtensionManager::list_extensions();
	}

	public function configureAction() {
		if (Minz_Request::param('ajax')) {
			$this->view->_useLayout(false);
		}
	}

	public function enableAction() {
		
	}

	public function disableAction() {
		
	}

	public function removeAction() {
		
	}
}
