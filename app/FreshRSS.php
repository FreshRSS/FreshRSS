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

		FreshRSS_Context::initSystem();
		if (FreshRSS_Context::$system_conf == null) {
			$message = 'Error during context system init!';
			Minz_Error::error(500, [$message], false);
			die($message);
		}

		// Load list of extensions and enable the "system" ones.
		Minz_ExtensionManager::init();

		// Auth has to be initialized before using currentUser session parameter
		// because it's this part which create this parameter.
		self::initAuth();
		if (FreshRSS_Context::$user_conf == null) {
			FreshRSS_Context::initUser();
		}
		if (FreshRSS_Context::$user_conf == null) {
			$message = 'Error during context user init!';
			Minz_Error::error(500, [$message], false);
			die($message);
		}

		// Complete initialization of the other FreshRSS / Minz components.
		self::initI18n();
		self::loadNotifications();
		// Enable extensions for the current (logged) user.
		if (FreshRSS_Auth::hasAccess() || FreshRSS_Context::$system_conf->allow_anonymous) {
			$ext_list = FreshRSS_Context::$user_conf->extensions_enabled;
			Minz_ExtensionManager::enableByList($ext_list);
		}

		if (FreshRSS_Context::$system_conf->force_email_validation && !FreshRSS_Auth::hasAccess('admin')) {
			self::checkEmailValidated();
		}

		Minz_ExtensionManager::callHook('freshrss_init');
	}

	private static function initAuth() {
		FreshRSS_Auth::init();
		if (Minz_Request::isPost()) {
			if (!is_referer_from_same_domain()) {
				// Basic protection against XSRF attacks
				FreshRSS_Auth::removeAccess();
				$http_referer = empty($_SERVER['HTTP_REFERER']) ? '' : $_SERVER['HTTP_REFERER'];
				self::initI18n();
				Minz_Error::error(403, array('error' => array(
						_t('feedback.access.denied'),
						' [HTTP_REFERER=' . htmlspecialchars($http_referer, ENT_NOQUOTES, 'UTF-8') . ']'
					)));
			}
			if (!(FreshRSS_Auth::isCsrfOk() ||
				(Minz_Request::controllerName() === 'auth' && Minz_Request::actionName() === 'login') ||
				(Minz_Request::controllerName() === 'user' && Minz_Request::actionName() === 'create' && !FreshRSS_Auth::hasAccess('admin')) ||
				(Minz_Request::controllerName() === 'feed' && Minz_Request::actionName() === 'actualize' && FreshRSS_Context::$system_conf->allow_anonymous_refresh) ||
				(Minz_Request::controllerName() === 'javascript' && Minz_Request::actionName() === 'actualize' && FreshRSS_Context::$system_conf->allow_anonymous)
				)) {
				// Token-based protection against XSRF attacks, except for the login or self-create user forms
				self::initI18n();
				Minz_Error::error(403, array('error' => array(
						_t('feedback.access.denied'),
						' [CSRF]'
					)));
			}
		}
	}

	private static function initI18n() {
		$userLanguage = isset(FreshRSS_Context::$user_conf) ? FreshRSS_Context::$user_conf->language : null;
		$systemLanguage = isset(FreshRSS_Context::$system_conf) ? FreshRSS_Context::$system_conf->language : null;
		$language = Minz_Translate::getLanguage($userLanguage, Minz_Request::getPreferredLanguages(), $systemLanguage);

		Minz_Session::_param('language', $language);
		Minz_Translate::init($language);
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
				Minz_View::prependStyle(Minz_Url::display($url));
			}
		}
		//Use prepend to insert before extensions. Added in reverse order.
		if (Minz_Request::controllerName() !== 'index') {
			Minz_View::prependScript(Minz_Url::display('/scripts/extra.js?' . @filemtime(PUBLIC_PATH . '/scripts/extra.js')));
		}
		Minz_View::prependScript(Minz_Url::display('/scripts/main.js?' . @filemtime(PUBLIC_PATH . '/scripts/main.js')));
	}

	private static function loadNotifications() {
		$notif = Minz_Request::getNotification();
		if ($notif) {
			Minz_View::_param('notification', $notif);
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
			Minz_Request::is('user', 'validateEmail') ||
			Minz_Request::is('user', 'sendValidationEmail') ||
			Minz_Request::is('user', 'profile') ||
			Minz_Request::is('user', 'delete') ||
			Minz_Request::is('auth', 'logout') ||
			Minz_Request::is('feed', 'actualize') ||
			Minz_Request::is('javascript', 'nonce')
		);
		if ($email_not_verified && !$action_is_allowed) {
			Minz_Request::forward(array(
				'c' => 'user',
				'a' => 'validateEmail',
			), true);
		}
	}
}
