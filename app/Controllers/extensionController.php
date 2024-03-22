<?php
declare(strict_types=1);

/**
 * The controller to manage extensions.
 */
class FreshRSS_extension_Controller extends FreshRSS_ActionController {
	/**
	 * This action is called before every other action in that class. It is
	 * the common boiler plate for every action. It is triggered by the
	 * underlying framework.
	 */
	public function firstAction(): void {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}
	}

	/**
	 * This action lists all the extensions available to the current user.
	 */
	public function indexAction(): void {
		FreshRSS_View::prependTitle(_t('admin.extensions.title') . ' · ');
		$this->view->extension_list = [
			'system' => [],
			'user' => [],
		];

		$this->view->extensions_installed = [];

		$extensions = Minz_ExtensionManager::listExtensions();
		foreach ($extensions as $ext) {
			$this->view->extension_list[$ext->getType()][] = $ext;
			$this->view->extensions_installed[$ext->getEntrypoint()] = $ext->getVersion();
		}

		$this->view->available_extensions = $this->getAvailableExtensionList();
	}

	/**
	 * fetch extension list from GitHub
	 * @return array<array{'name':string,'author':string,'description':string,'version':string,'entrypoint':string,'type':'system'|'user','url':string,'method':string,'directory':string}>
	 */
	protected function getAvailableExtensionList(): array {
		$extensionListUrl = 'https://raw.githubusercontent.com/FreshRSS/Extensions/master/extensions.json';
		$json = @file_get_contents($extensionListUrl);

		// we ran into problems, simply ignore them
		if ($json === false) {
			Minz_Log::error('Could not fetch available extension from GitHub');
			return [];
		}

		// fetch the list as an array
		/** @var array<string,mixed> $list*/
		$list = json_decode($json, true);
		if (!is_array($list) || empty($list['extensions']) || !is_array($list['extensions'])) {
			Minz_Log::warning('Failed to convert extension file list');
			return [];
		}

		// By now, all the needed data is kept in the main extension file.
		// In the future we could fetch detail information from the extensions metadata.json, but I tend to stick with
		// the current implementation for now, unless it becomes too much effort maintain the extension list manually
		$extensions = [];
		foreach ($list['extensions'] as $extension) {
			if (isset($extension['version']) && is_numeric($extension['version'])) {
				$extension['version'] = (string)$extension['version'];
			}
			foreach (['author', 'description', 'directory', 'entrypoint', 'method', 'name', 'type', 'url', 'version'] as $key) {
				if (empty($extension[$key]) || !is_string($extension[$key])) {
					continue 2;
				}
			}
			if (!in_array($extension['type'], ['system', 'user'], true)) {
				continue;
			}
			$extensions[] = $extension;
		}
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
	public function configureAction(): void {
		if (Minz_Request::paramBoolean('ajax')) {
			$this->view->_layout(null);
		} elseif (Minz_Request::paramBoolean('slider')) {
			$this->indexAction();
			$this->view->_path('extension/index.phtml');
		}

		$ext_name = urldecode(Minz_Request::paramString('e'));
		$ext = Minz_ExtensionManager::findExtension($ext_name);

		if ($ext === null) {
			Minz_Error::error(404);
			return;
		}
		if ($ext->getType() === 'system' && !FreshRSS_Auth::hasAccess('admin')) {
			Minz_Error::error(403);
			return;
		}

		FreshRSS_View::prependTitle($ext->getName() . ' · ' . _t('admin.extensions.title') . ' · ');
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
	public function enableAction(): void {
		$url_redirect = ['c' => 'extension', 'a' => 'index'];

		if (Minz_Request::isPost()) {
			$ext_name = urldecode(Minz_Request::paramString('e'));
			$ext = Minz_ExtensionManager::findExtension($ext_name);

			if (is_null($ext)) {
				Minz_Request::bad(_t('feedback.extensions.not_found', $ext_name), $url_redirect);
				return;
			}

			if ($ext->isEnabled()) {
				Minz_Request::bad(_t('feedback.extensions.already_enabled', $ext_name), $url_redirect);
			}

			$type = $ext->getType();
			if ($type !== 'user' && !FreshRSS_Auth::hasAccess('admin')) {
				Minz_Request::bad(_t('feedback.extensions.no_access', $ext_name), $url_redirect);
				return;
			}

			$conf = null;
			if ($type === 'system') {
				$conf = FreshRSS_Context::systemConf();
			} elseif ($type === 'user') {
				$conf = FreshRSS_Context::userConf();
			}

			$res = $ext->install();

			if ($conf !== null && $res === true) {
				$ext_list = $conf->extensions_enabled;
				$ext_list = array_filter($ext_list, static function(string $key) use($type) {
					// Remove from list the extensions that have disappeared or changed type
					$extension = Minz_ExtensionManager::findExtension($key);
					return $extension !== null && $extension->getType() === $type;
				}, ARRAY_FILTER_USE_KEY);

				$ext_list[$ext_name] = true;
				$conf->extensions_enabled = $ext_list;
				$conf->save();

				Minz_Request::good(_t('feedback.extensions.enable.ok', $ext_name), $url_redirect);
			} else {
				Minz_Log::warning('Cannot enable extension ' . $ext_name . ': ' . $res);
				Minz_Request::bad(_t('feedback.extensions.enable.ko', $ext_name, _url('index', 'logs')), $url_redirect);
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
	public function disableAction(): void {
		$url_redirect = ['c' => 'extension', 'a' => 'index'];

		if (Minz_Request::isPost()) {
			$ext_name = urldecode(Minz_Request::paramString('e'));
			$ext = Minz_ExtensionManager::findExtension($ext_name);

			if (is_null($ext)) {
				Minz_Request::bad(_t('feedback.extensions.not_found', $ext_name), $url_redirect);
				return;
			}

			if (!$ext->isEnabled()) {
				Minz_Request::bad(_t('feedback.extensions.not_enabled', $ext_name), $url_redirect);
			}

			$type = $ext->getType();
			if ($type !== 'user' && !FreshRSS_Auth::hasAccess('admin')) {
				Minz_Request::bad(_t('feedback.extensions.no_access', $ext_name), $url_redirect);
				return;
			}

			$conf = null;
			if ($type === 'system') {
				$conf = FreshRSS_Context::systemConf();
			} elseif ($type === 'user') {
				$conf = FreshRSS_Context::userConf();
			}

			$res = $ext->uninstall();

			if ($conf !== null && $res === true) {
				$ext_list = $conf->extensions_enabled;
				$ext_list = array_filter($ext_list, static function(string $key) use($type) {
					// Remove from list the extensions that have disappeared or changed type
					$extension = Minz_ExtensionManager::findExtension($key);
					return $extension !== null && $extension->getType() === $type;
				}, ARRAY_FILTER_USE_KEY);

				$ext_list[$ext_name] = false;
				$conf->extensions_enabled = $ext_list;
				$conf->save();

				Minz_Request::good(_t('feedback.extensions.disable.ok', $ext_name), $url_redirect);
			} else {
				Minz_Log::warning('Cannot disable extension ' . $ext_name . ': ' . $res);
				Minz_Request::bad(_t('feedback.extensions.disable.ko', $ext_name, _url('index', 'logs')), $url_redirect);
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
	public function removeAction(): void {
		if (!FreshRSS_Auth::hasAccess('admin')) {
			Minz_Error::error(403);
		}

		$url_redirect = ['c' => 'extension', 'a' => 'index'];

		if (Minz_Request::isPost()) {
			$ext_name = urldecode(Minz_Request::paramString('e'));
			$ext = Minz_ExtensionManager::findExtension($ext_name);

			if (is_null($ext)) {
				Minz_Request::bad(_t('feedback.extensions.not_found', $ext_name), $url_redirect);
				return;
			}

			$res = recursive_unlink($ext->getPath());
			if ($res) {
				Minz_Request::good(_t('feedback.extensions.removed', $ext_name), $url_redirect);
			} else {
				Minz_Request::bad(_t('feedback.extensions.cannot_remove', $ext_name), $url_redirect);
			}
		}

		Minz_Request::forward($url_redirect, true);
	}
}
