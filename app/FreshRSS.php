<?php

class FreshRSS extends Minz_FrontController {
	/**
	 * Initialize the different FreshRSS / Minz components.
	 *
	 * PLEASE DON'T CHANGE THE ORDER OF INITIALIZATIONS UNLESS YOU KNOW WHAT
	 * YOU DO!!
	 *
	 * Here is the list of components:
	 * - Create a configuration setter and register it to system conf
	 * - Init extension manager and enable system extensions (has to be done asap)
	 * - Init authentication system
	 * - Init user configuration (need auth system)
	 * - Init FreshRSS context (need user conf)
	 * - Init i18n (need context)
	 * - Init sharing system (need user conf and i18n)
	 * - Init generic styles and scripts (need user conf)
	 * - Init notifications
	 * - Enable user extensions (need all the other initializations)
	 */
	public function init() {
		if (!isset($_SESSION)) {
			Minz_Session::init('FreshRSS');
		}

		// Register the configuration setter for the system configuration
		$configuration_setter = new FreshRSS_ConfigurationSetter();
		$system_conf = Minz_Configuration::get('system');
		$system_conf->_configurationSetter($configuration_setter);

		// Load list of extensions and enable the "system" ones.
		Minz_ExtensionManager::init();

		// Auth has to be initialized before using currentUser session parameter
		// because it's this part which create this parameter.
		$this->initAuth();

		// Then, register the user configuration and use the configuration setter
		// created above.
		$current_user = Minz_Session::param('currentUser', '_');
		Minz_Configuration::register('user',
		                             join_path(USERS_PATH, $current_user, 'config.php'),
		                             join_path(USERS_PATH, '_', 'config.default.php'),
		                             $configuration_setter);

		// Finish to initialize the other FreshRSS / Minz components.
		FreshRSS_Context::init();
		$this->initI18n();
		FreshRSS_Share::load(join_path(DATA_PATH, 'shares.php'));
		$this->loadStylesAndScripts();
		$this->loadNotifications();
		// Enable extensions for the current (logged) user.
		if (FreshRSS_Auth::hasAccess()) {
			$ext_list = FreshRSS_Context::$user_conf->extensions_enabled;
			Minz_ExtensionManager::enableByList($ext_list);
		}
	}

	private function initAuth() {
		FreshRSS_Auth::init();
		if (Minz_Request::isPost() && !is_referer_from_same_domain()) {
			// Basic protection against XSRF attacks
			FreshRSS_Auth::removeAccess();
			$http_referer = empty($_SERVER['HTTP_REFERER']) ? '' : $_SERVER['HTTP_REFERER'];
			Minz_Translate::init('en');	//TODO: Better choice of fallback language
			Minz_Error::error(
				403,
				array('error' => array(
					_t('feedback.access.denied'),
					' [HTTP_REFERER=' . htmlspecialchars($http_referer) . ']'
				))
			);
		}
	}

	private function initI18n() {
		Minz_Session::_param('language', FreshRSS_Context::$user_conf->language);
		Minz_Translate::init(FreshRSS_Context::$user_conf->language);
	}

	private function loadStylesAndScripts() {
		$theme = FreshRSS_Themes::load(FreshRSS_Context::$user_conf->theme);
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

		if (FreshRSS_Context::$system_conf->auth_type === 'persona') {
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
