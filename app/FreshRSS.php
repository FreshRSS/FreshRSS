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
		self::initAuth();

		// Then, register the user configuration and use the configuration setter
		// created above.
		$current_user = Minz_Session::param('currentUser', '_');
		Minz_Configuration::register('user',
		                             join_path(USERS_PATH, $current_user, 'config.php'),
		                             join_path(FRESHRSS_PATH, 'config-user.default.php'),
		                             $configuration_setter);

		// Finish to initialize the other FreshRSS / Minz components.
		FreshRSS_Context::init();
		self::initI18n();
		self::loadNotifications();
		// Enable extensions for the current (logged) user.
		if (FreshRSS_Auth::hasAccess() || $system_conf->allow_anonymous) {
			$ext_list = FreshRSS_Context::$user_conf->extensions_enabled;
			Minz_ExtensionManager::enableByList($ext_list);
		}
	}

	private static function initAuth() {
		FreshRSS_Auth::init();
		if (Minz_Request::isPost() && !(is_referer_from_same_domain() && FreshRSS_Auth::isCsrfOk())) {
			// Basic protection against XSRF attacks
			FreshRSS_Auth::removeAccess();
			$http_referer = empty($_SERVER['HTTP_REFERER']) ? '' : $_SERVER['HTTP_REFERER'];
			Minz_Translate::init('en');	//TODO: Better choice of fallback language
			Minz_Error::error(
				403,
				array('error' => array(
					_t('feedback.access.denied'),
					' [HTTP_REFERER=' . htmlspecialchars($http_referer, ENT_NOQUOTES, 'UTF-8') . ']'
				))
			);
		}
	}

	private static function initI18n() {
		Minz_Session::_param('language', FreshRSS_Context::$user_conf->language);
		Minz_Translate::init(FreshRSS_Context::$user_conf->language);
	}

	public static function loadStylesAndScripts() {
		$theme = FreshRSS_Themes::load(FreshRSS_Context::$user_conf->theme);
		if ($theme) {
			foreach(array_reverse($theme['files']) as $file) {
				if ($file[0] === '_') {
					$theme_id = 'base-theme';
					$filename = substr($file, 1);
				} else {
					$theme_id = $theme['id'];
					$filename = $file;
				}
				$filetime = @filemtime(PUBLIC_PATH . '/themes/' . $theme_id . '/' . $filename);
				$url = '/themes/' . $theme_id . '/' . $filename . '?' . $filetime;
				Minz_View::prependStyle(Minz_Url::display($url));
			}
		}
		//Use prepend to insert before extensions. Added in reverse order.
		Minz_View::prependScript(Minz_Url::display('/scripts/main.js?' . @filemtime(PUBLIC_PATH . '/scripts/main.js')));
		Minz_View::prependScript(Minz_Url::display('/scripts/shortcut.js?' . @filemtime(PUBLIC_PATH . '/scripts/shortcut.js')));
		Minz_View::prependScript(Minz_Url::display('/scripts/jquery.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/jquery.min.js')));
	}

	private static function loadNotifications() {
		$notif = Minz_Session::param('notification');
		if ($notif) {
			Minz_View::_param('notification', $notif);
			Minz_Session::_param('notification');
		}
	}

	public static function preLayout() {
		switch (Minz_Request::controllerName()) {
			case 'index':
				$urlToAuthorize = array_filter(array_map(function ($a) {
					if (isset($a['method']) && $a['method'] === 'POST') {
						return $a['url'];
					}
				}, FreshRSS_Context::$user_conf->sharing));
				$connectSrc = count($urlToAuthorize) ? sprintf("; connect-src 'self' %s", implode(' ', $urlToAuthorize)) : '';
				header(sprintf("Content-Security-Policy: default-src 'self'; child-src *; frame-src *; img-src * data:; media-src *%s", $connectSrc));
				break;
			case 'stats':
				header("Content-Security-Policy: default-src 'self'; style-src 'self' 'unsafe-inline'");
				break;
			default:
				header("Content-Security-Policy: default-src 'self'");
				break;
		}
		header("X-Content-Type-Options: nosniff");

		FreshRSS_Share::load(join_path(APP_PATH, 'shares.php'));
		self::loadStylesAndScripts();
	}
}
