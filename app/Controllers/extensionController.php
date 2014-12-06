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

	/**
	 * This action enables a disabled extension for the current user.
	 *
	 * System extensions can only be enabled by an administrator.
	 *
	 * Parameter is:
	 * - e: the extension name (urlencoded).
	 */
	public function enableAction() {
		$url_redirect = array('c' => 'extension', 'a' => 'index');

		if (Minz_Request::isPost()) {
			$ext_name = urldecode(Minz_Request::param('e'));
			$ext = Minz_ExtensionManager::find_extension($ext_name);

			if (is_null($ext)) {
				Minz_Request::bad('feedback.extension.not_found', $url_redirect);
			}

			if ($ext->is_enabled()) {
				Minz_Request::bad('feedback.extension.already_enabled', $url_redirect);
			}

			if ($ext->getType() === 'system' && FreshRSS_Auth::hasAccess('admin')) {
				$ext->install();

				Minz_Configuration::addExtension($ext_name);
				Minz_Configuration::writeFile();

				Minz_Request::good('feedback.extension.enabled', $url_redirect);
			} elseif ($ext->getType() === 'user') {
				$ext->install();

				FreshRSS_Context::$conf->addExtension($ext_name);
				FreshRSS_Context::$conf->save();

				Minz_Request::good('feedback.extension.enabled', $url_redirect);
			} else {
				Minz_Request::bad('feedback.extension.no_access', $url_redirect);
			}
		}

		Minz_Request::forward($url_redirect, true);
	}

	/**
	 * This action disables an enabled extension for the current user.
	 *
	 * System extensions can only be disabled by an administrator.
	 *
	 * Parameter is:
	 * - e: the extension name (urlencoded).
	 */
	public function disableAction() {
		$url_redirect = array('c' => 'extension', 'a' => 'index');

		if (Minz_Request::isPost()) {
			$ext_name = urldecode(Minz_Request::param('e'));
			$ext = Minz_ExtensionManager::find_extension($ext_name);

			if (is_null($ext)) {
				Minz_Request::bad('feedback.extension.not_found', $url_redirect);
			}

			if (!$ext->is_enabled()) {
				Minz_Request::bad('feedback.extension.not_enabled', $url_redirect);
			}

			if ($ext->getType() === 'system' && FreshRSS_Auth::hasAccess('admin')) {
				$ext->uninstall();

				Minz_Configuration::removeExtension($ext_name);
				Minz_Configuration::writeFile();

				Minz_Request::good('feedback.extension.disabled', $url_redirect);
			} elseif ($ext->getType() === 'user') {
				$ext->uninstall();

				FreshRSS_Context::$conf->removeExtension($ext_name);
				FreshRSS_Context::$conf->save();

				Minz_Request::good('feedback.extension.disabled', $url_redirect);
			} else {
				Minz_Request::bad('feedback.extension.no_access', $url_redirect);
			}
		}

		Minz_Request::forward($url_redirect, true);
	}

	public function removeAction() {
		
	}
}
