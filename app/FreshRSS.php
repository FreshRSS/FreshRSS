<?php

class FreshRSS extends Minz_FrontController {
	public function init() {
		if (!isset($_SESSION)) {
			Minz_Session::init('FreshRSS');
		}

		// Load list of extensions and enable the "system" ones.
		Minz_ExtensionManager::init();

		// Need to be called just after session init because it initializes
		// current user.
		FreshRSS_Auth::init();

		if (Minz_Request::isPost() && !is_referer_from_same_domain()) {
			// Basic protection against XSRF attacks
			FreshRSS_Auth::removeAccess();
			$http_referer = empty($_SERVER['HTTP_REFERER']) ? '' : $_SERVER['HTTP_REFERER'];
			Minz_Error::error(
				403,
				array('error' => array(
					_t('access_denied'),
					' [HTTP_REFERER=' . htmlspecialchars($http_referer) . ']'
				))
			);
		}

		// Load context and configuration.
		FreshRSS_Context::init();

		// Enable extensions for the current (logged) user.
		if (FreshRSS_Auth::hasAccess()) {
			$ext_list = FreshRSS_Context::$conf->extensions_enabled;
			Minz_ExtensionManager::enable_by_list($ext_list);
		}

		// Init i18n.
		Minz_Session::_param('language', FreshRSS_Context::$conf->language);
		Minz_Translate::init();

		$this->loadStylesAndScripts();
		$this->loadNotifications();
	}

	private function loadStylesAndScripts() {
		$theme = FreshRSS_Themes::load(FreshRSS_Context::$conf->theme);
		if ($theme) {
			foreach($theme['files'] as $file) {
				if ($file[0] === '_') {
					$theme_id = 'base-theme';
					$filename = substr($file, 1);
				} else {
					$theme_id = $theme['id'];
					$filename = $file;
				}
				$filetime = @filemtime(PUBLIC_PATH . '/themes/' . $theme_id . '/' . $filename);
				Minz_View::appendStyle(Minz_Url::display(
					'/themes/' . $theme_id . '/' . $filename . '?' . $filetime
				));
			}
		}

		Minz_View::appendScript(Minz_Url::display('/scripts/jquery.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/jquery.min.js')));
		Minz_View::appendScript(Minz_Url::display('/scripts/shortcut.js?' . @filemtime(PUBLIC_PATH . '/scripts/shortcut.js')));
		Minz_View::appendScript(Minz_Url::display('/scripts/main.js?' . @filemtime(PUBLIC_PATH . '/scripts/main.js')));

		if (Minz_Configuration::authType() === 'persona') {
			// TODO move it in a plugin
			// Needed for login AND logout with Persona.
			Minz_View::appendScript('https://login.persona.org/include.js');
			$file_mtime = @filemtime(PUBLIC_PATH . '/scripts/persona.js');
			Minz_View::appendScript(Minz_Url::display('/scripts/persona.js?' . $file_mtime));
		}
	}

	private function loadNotifications() {
		$notif = Minz_Session::param('notification');
		if ($notif) {
			Minz_View::_param('notification', $notif);
			Minz_Session::_param('notification');
		}
	}
}
