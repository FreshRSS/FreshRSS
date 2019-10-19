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
		$this->view->extension_list = array(
			'system' => array(),
			'user' => array(),
		);

		$this->view->extensions_installed = array();

		$extensions = Minz_ExtensionManager::listExtensions();
		foreach ($extensions as $ext) {
			$this->view->extension_list[$ext->getType()][] = $ext;
			$this->view->extensions_installed[$ext->getEntrypoint()] = $ext->getVersion();
		}

		$availableExtensions = $this->getAvailableExtensionList();
		$this->view->available_extensions = $availableExtensions;
	}

	/**
	 * fetch extension list from GitHub
	 */
	protected function getAvailableExtensionList() {
		$extensionListUrl = 'https://raw.githubusercontent.com/FreshRSS/Extensions/master/extensions.json';
		$json = file_get_contents($extensionListUrl);

		// we ran into problems, simply ignore them
		if ($json === false) {
			Minz_Log::error('Could not fetch available extension from GitHub');
			return array();
		}

		// fetch the list as an array
		$list = json_decode($json, true);
		if (empty($list)) {
			Minz_Log::warning('Failed to convert extension file list');
			return array();
		}

		// we could use that for comparing and caching later
		$version = $list['version'];

		// By now, all the needed data is kept in the main extension file.
		// In the future we could fetch detail information from the extensions metadata.json, but I tend to stick with
		// the current implementation for now, unless it becomes too much effort maintain the extension list manually
		$extensions = $list['extensions'];

		return $extensions;
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
			$this->view->_layout(false);
		} else {
			$this->indexAction();
			$this->view->_path('extension/index.phtml');
		}

		$ext_name = urldecode(Minz_Request::param('e'));
		$ext = Minz_ExtensionManager::findExtension($ext_name);

		if (is_null($ext)) {
			Minz_Error::error(404);
		}
		if ($ext->getType() === 'system' && !FreshRSS_Auth::hasAccess('admin')) {
			Minz_Error::error(403);
		}

		$this->view->extension = $ext;
		$this->view->extension->handleConfigureAction();
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
			$ext = Minz_ExtensionManager::findExtension($ext_name);

			if (is_null($ext)) {
				Minz_Request::bad(_t('feedback.extensions.not_found', $ext_name),
				                  $url_redirect);
			}

			if ($ext->isEnabled()) {
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

			$res = $ext->install();

			if ($res === true) {
				$ext_list = $conf->extensions_enabled;
				$ext_list[$ext_name] = true;
				$conf->extensions_enabled = $ext_list;
				$conf->save();

				Minz_Request::good(_t('feedback.extensions.enable.ok', $ext_name),
				                   $url_redirect);
			} else {
				Minz_Log::warning('Can not enable extension ' . $ext_name . ': ' . $res);
				Minz_Request::bad(_t('feedback.extensions.enable.ko', $ext_name, _url('index', 'logs')),
				                  $url_redirect);
			}
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
			$ext = Minz_ExtensionManager::findExtension($ext_name);

			if (is_null($ext)) {
				Minz_Request::bad(_t('feedback.extensions.not_found', $ext_name),
				                  $url_redirect);
			}

			if (!$ext->isEnabled()) {
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

			$res = $ext->uninstall();

			if ($res === true) {
				$ext_list = $conf->extensions_enabled;
				$legacyKey = array_search($ext_name, $ext_list, true);
				if ($legacyKey !== false) {	//Legacy format FreshRSS < 1.11.1
					unset($ext_list[$legacyKey]);
				}
				$ext_list[$ext_name] = false;
				$conf->extensions_enabled = $ext_list;
				$conf->save();

				Minz_Request::good(_t('feedback.extensions.disable.ok', $ext_name),
				                   $url_redirect);
			} else {
				Minz_Log::warning('Can not unable extension ' . $ext_name . ': ' . $res);
				Minz_Request::bad(_t('feedback.extensions.disable.ko', $ext_name, _url('index', 'logs')),
				                  $url_redirect);
			}
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
			$ext = Minz_ExtensionManager::findExtension($ext_name);

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
