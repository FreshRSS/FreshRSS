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

	/**
	 * This action handles configuration of a given extension.
	 *
	 * Only administrator can configure a system extension.
	 *
	 * Parameters are:
	 * - e: the extension name (urlencoded)
	 * - additional parameters which should be handle by the extension
	 *   handleConfigureAction() method (POST request).
	 */
	public function configureAction() {
		if (Minz_Request::param('ajax')) {
			$this->view->_useLayout(false);
		}

		$ext_name = urldecode(Minz_Request::param('e'));
		$ext = Minz_ExtensionManager::find_extension($ext_name);

		if (is_null($ext)) {
			Minz_Error::error(404);
		}
		if ($ext->getType() === 'system' && !FreshRSS_Auth::hasAccess('admin')) {
			Minz_Error::error(403);
		}

		$this->view->extension = $ext;

		if (Minz_Request::isPost()) {
			$this->view->extension->handleConfigureAction();
		}
	}

	/**
	 * This action enables a disabled extension for the current user.
	 *
	 * System extensions can only be enabled by an administrator.
	 * This action must be reached by a POST request.
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
				Minz_Request::bad(_t('feedback.extensions.not_found', $ext_name),
				                  $url_redirect);
			}

			if ($ext->is_enabled()) {
				Minz_Request::bad(_t('feedback.extensions.already_enabled', $ext_name),
				                  $url_redirect);
			}

			$conf = null;
			if ($ext->getType() === 'system' && FreshRSS_Auth::hasAccess('admin')) {
				$conf = FreshRSS_Context::$system_conf;
			} elseif ($ext->getType() === 'user') {
				$conf = FreshRSS_Context::$user_conf;
			} else {
				Minz_Request::bad(_t('feedback.extensions.no_access', $ext_name),
				                  $url_redirect);
			}

			$ext->install();

			$ext_list = $conf->extensions_enabled;
			array_push_unique($ext_list, $ext_name);
			$conf->extensions_enabled = $ext_list;
			$conf->save();

			Minz_Request::good(_t('feedback.extensions.enabled', $ext_name),
			                  $url_redirect);
		}

		Minz_Request::forward($url_redirect, true);
	}

	/**
	 * This action disables an enabled extension for the current user.
	 *
	 * System extensions can only be disabled by an administrator.
	 * This action must be reached by a POST request.
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
				Minz_Request::bad(_t('feedback.extensions.not_found', $ext_name),
				                  $url_redirect);
			}

			if (!$ext->is_enabled()) {
				Minz_Request::bad(_t('feedback.extensions.not_enabled', $ext_name),
				                  $url_redirect);
			}

			$conf = null;
			if ($ext->getType() === 'system' && FreshRSS_Auth::hasAccess('admin')) {
				$conf = FreshRSS_Context::$system_conf;
			} elseif ($ext->getType() === 'user') {
				$conf = FreshRSS_Context::$user_conf;
			} else {
				Minz_Request::bad(_t('feedback.extensions.no_access', $ext_name),
				                  $url_redirect);
			}

			$ext->uninstall();

			$ext_list = $conf->extensions_enabled;
			array_remove($ext_list, $ext_name);
			$conf->extensions_enabled = $ext_list;
			$conf->save();

			Minz_Request::good(_t('feedback.extensions.disabled', $ext_name),
			                  $url_redirect);
		}

		Minz_Request::forward($url_redirect, true);
	}

	/**
	 * This action handles deletion of an extension.
	 *
	 * Only administrator can remove an extension.
	 * This action must be reached by a POST request.
	 *
	 * Parameter is:
	 * -e: extension name (urlencoded)
	 */
	public function removeAction() {
		if (!FreshRSS_Auth::hasAccess('admin')) {
			Minz_Error::error(403);
		}

		$url_redirect = array('c' => 'extension', 'a' => 'index');

		if (Minz_Request::isPost()) {
			$ext_name = urldecode(Minz_Request::param('e'));
			$ext = Minz_ExtensionManager::find_extension($ext_name);

			if (is_null($ext)) {
				Minz_Request::bad(_t('feedback.extensions.not_found', $ext_name),
				                  $url_redirect);
			}

			$res = recursive_unlink($ext->getPath());
			if ($res) {
				Minz_Request::good(_t('feedback.extensions.removed', $ext_name),
				                  $url_redirect);
			} else {
				Minz_Request::bad(_t('feedback.extensions.cannot_delete', $ext_name),
				                  $url_redirect);
			}
		}

		Minz_Request::forward($url_redirect, true);
	}
}
