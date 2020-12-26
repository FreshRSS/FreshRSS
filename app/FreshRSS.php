<?php

class FreshRSS extends Minz\FrontController {
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
			Minz\Session::init('FreshRSS');
		}

		// Register the configuration setter for the system configuration
		$configuration_setter = new FreshRSS_ConfigurationSetter();
		$system_conf = Minz\Configuration::get('system');
		$system_conf->_configurationSetter($configuration_setter);

		// Load list of extensions and enable the "system" ones.
		// Minz\ExtensionManager::init();

		// Auth has to be initialized before using currentUser session parameter
		// because it's this part which create this parameter.
		self::initAuth();

		// Then, register the user configuration and use the configuration setter
		// created above.
		$current_user = Minz\Session::param('currentUser', '_');
		Minz\Configuration::register('user',
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
			//Minz\ExtensionManager::enableByList($ext_list);
		}

		if ($system_conf->force_email_validation && !FreshRSS_Auth::hasAccess('admin')) {
			self::checkEmailValidated();
		}

		//Minz\ExtensionManager::callHook('freshrss_init');
	}

	private static function initAuth() {
		FreshRSS_Auth::init();
		if (Minz\Request::isPost()) {
			if (!is_referer_from_same_domain()) {
				// Basic protection against XSRF attacks
				FreshRSS_Auth::removeAccess();
				$http_referer = empty($_SERVER['HTTP_REFERER']) ? '' : $_SERVER['HTTP_REFERER'];
				self::initI18n();
				Minz\Error::error(403, array('error' => array(
						_t('feedback.access.denied'),
						' [HTTP_REFERER=' . htmlspecialchars($http_referer, ENT_NOQUOTES, 'UTF-8') . ']'
					)));
			}
			if (!(FreshRSS_Auth::isCsrfOk() ||
				(Minz\Request::controllerName() === 'auth' && Minz\Request::actionName() === 'login') ||
				(Minz\Request::controllerName() === 'user' && Minz\Request::actionName() === 'create' &&
					!FreshRSS_Auth::hasAccess('admin'))
				)) {
				// Token-based protection against XSRF attacks, except for the login or self-create user forms
				self::initI18n();
				Minz\Error::error(403, array('error' => array(
						_t('feedback.access.denied'),
						' [CSRF]'
					)));
			}
		}
	}

	private static function initI18n() {
		$userLanguage = isset(FreshRSS_Context::$user_conf) ? FreshRSS_Context::$user_conf->language : null;
		$systemLanguage = isset(FreshRSS_Context::$system_conf) ? FreshRSS_Context::$system_conf->language : null;
		$language = Minz\Translate::getLanguage($userLanguage, Minz\Request::getPreferredLanguages(), $systemLanguage);

		Minz\Session::_param('language', $language);
		Minz\Translate::init($language);
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
				if (_t('gen.dir') === 'rtl') {
					$filename = substr($filename, 0, -4);
					$filename = $filename . '.rtl.css';
				}
				$filetime = @filemtime(PUBLIC_PATH . '/themes/' . $theme_id . '/' . $filename);
				$url = '/themes/' . $theme_id . '/' . $filename . '?' . $filetime;
				Minz\View::prependStyle(Minz\Url::display($url));
			}
		}
		//Use prepend to insert before extensions. Added in reverse order.
		if (Minz\Request::controllerName() !== 'index') {
			Minz\View::prependScript(Minz\Url::display('/scripts/extra.js?' . @filemtime(PUBLIC_PATH . '/scripts/extra.js')));
		}
		Minz\View::prependScript(Minz\Url::display('/scripts/main.js?' . @filemtime(PUBLIC_PATH . '/scripts/main.js')));
	}

	private static function loadNotifications() {
		$notif = Minz\Request::getNotification();
		if ($notif) {
			Minz\View::_param('notification', $notif);
		}
	}

	public static function preLayout() {
		header("X-Content-Type-Options: nosniff");

		FreshRSS_Share::load(join_path(APP_PATH, 'shares.php'));
		self::loadStylesAndScripts();
	}

	private static function checkEmailValidated() {
		$email_not_verified = FreshRSS_Auth::hasAccess() && FreshRSS_Context::$user_conf->email_validation_token !== '';
		$action_is_allowed = (
			Minz\Request::is('user', 'validateEmail') ||
			Minz\Request::is('user', 'sendValidationEmail') ||
			Minz\Request::is('user', 'profile') ||
			Minz\Request::is('user', 'delete') ||
			Minz\Request::is('auth', 'logout') ||
			Minz\Request::is('feed', 'actualize') ||
			Minz\Request::is('javascript', 'nonce')
		);
		if ($email_not_verified && !$action_is_allowed) {
			Minz\Request::forward(array(
				'c' => 'user',
				'a' => 'validateEmail',
			), true);
		}
	}
}
