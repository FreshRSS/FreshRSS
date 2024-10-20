<?php
declare(strict_types=1);

class FreshRSS extends Minz_FrontController {
	/**
	 * Initialize the different FreshRSS / Minz components.
	 *
	 * PLEASE DON’T CHANGE THE ORDER OF INITIALIZATIONS UNLESS YOU KNOW WHAT YOU DO!!
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
	 * - Enable user extensions (need all the other initializations)
	 */
	public function init(): void {
		if (!isset($_SESSION)) {
			Minz_Session::init('FreshRSS');
		}

		FreshRSS_Context::initSystem();
		if (!FreshRSS_Context::hasSystemConf()) {
			$message = 'Error during context system init!';
			Minz_Error::error(500, $message, false);
			die($message);
		}

		if (FreshRSS_Context::systemConf()->logo_html != '') {
			// Relax Content Security Policy to allow external images if a custom logo HTML is used
			Minz_ActionController::_defaultCsp([
				'default-src' => "'self'",
				'img-src' => '* data:',
			]);
		}

		// Load list of extensions and enable the "system" ones.
		Minz_ExtensionManager::init();

		// Auth has to be initialized before using currentUser session parameter
		// because it’s this part which create this parameter.
		self::initAuth();
		if (!FreshRSS_Context::hasUserConf()) {
			FreshRSS_Context::initUser();
		}
		if (!FreshRSS_Context::hasUserConf()) {
			$message = 'Error during context user init!';
			Minz_Error::error(500, $message, false);
			die($message);
		}

		// Complete initialization of the other FreshRSS / Minz components.
		self::initI18n();
		// Enable extensions for the current (logged) user.
		if (FreshRSS_Auth::hasAccess() || FreshRSS_Context::systemConf()->allow_anonymous) {
			$ext_list = FreshRSS_Context::userConf()->extensions_enabled;
			Minz_ExtensionManager::enableByList($ext_list, 'user');
		}

		if (FreshRSS_Context::systemConf()->force_email_validation && !FreshRSS_Auth::hasAccess('admin')) {
			self::checkEmailValidated();
		}

		Minz_ExtensionManager::callHookVoid('freshrss_init');
	}

	private static function initAuth(): void {
		FreshRSS_Auth::init();
		if (Minz_Request::isPost()) {
			if (!FreshRSS_Context::hasSystemConf() || !(FreshRSS_Auth::isCsrfOk() ||
				(Minz_Request::controllerName() === 'auth' && Minz_Request::actionName() === 'login') ||
				(Minz_Request::controllerName() === 'user' && Minz_Request::actionName() === 'create' && !FreshRSS_Auth::hasAccess('admin')) ||
				(Minz_Request::controllerName() === 'feed' && Minz_Request::actionName() === 'actualize' &&
					FreshRSS_Context::systemConf()->allow_anonymous_refresh) ||
				(Minz_Request::controllerName() === 'javascript' && Minz_Request::actionName() === 'actualize' &&
					FreshRSS_Context::systemConf()->allow_anonymous)
				)) {
				// Token-based protection against XSRF attacks, except for the login or self-create user forms
				self::initI18n();
				Minz_Error::error(403, ['error' => [_t('feedback.access.denied'), ' [CSRF]']]);
			}
		}
	}

	private static function initI18n(): void {
		$userLanguage = FreshRSS_Context::hasUserConf() ? FreshRSS_Context::userConf()->language : null;
		$systemLanguage = FreshRSS_Context::hasSystemConf() ? FreshRSS_Context::systemConf()->language : null;
		$language = Minz_Translate::getLanguage($userLanguage, Minz_Request::getPreferredLanguages(), $systemLanguage);

		Minz_Session::_param('language', $language);
		Minz_Translate::init($language);

		$timezone = FreshRSS_Context::hasUserConf() ? FreshRSS_Context::userConf()->timezone : '';
		if ($timezone == '') {
			$timezone = FreshRSS_Context::defaultTimeZone();
		}
		date_default_timezone_set($timezone);
	}

	private static function getThemeFileUrl(string $theme_id, string $filename): string {
		$filetime = @filemtime(PUBLIC_PATH . '/themes/' . $theme_id . '/' . $filename);
		return '/themes/' . $theme_id . '/' . $filename . '?' . $filetime;
	}

	public static function loadStylesAndScripts(): void {
		if (!FreshRSS_Context::hasUserConf()) {
			return;
		}
		$theme = FreshRSS_Themes::load(FreshRSS_Context::userConf()->theme);
		if (is_array($theme)) {
			foreach (array_reverse($theme['files']) as $file) {
				switch (substr($file, -3)) {
					case '.js':
						$theme_id = $theme['id'];
						$filename = $file;
						FreshRSS_View::prependScript(Minz_Url::display(FreshRSS::getThemeFileUrl($theme_id, $filename)));
						break;
					case '.css':
					default:
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
						FreshRSS_View::prependStyle(Minz_Url::display(FreshRSS::getThemeFileUrl($theme_id, $filename)));
				}
			}

			if (!empty($theme['theme-color'])) {
				FreshRSS_View::appendThemeColors($theme['theme-color']);
			}
		}
		//Use prepend to insert before extensions. Added in reverse order.
		if (!in_array(Minz_Request::controllerName(), ['index', ''], true)) {
			FreshRSS_View::prependScript(Minz_Url::display('/scripts/extra.js?' . @filemtime(PUBLIC_PATH . '/scripts/extra.js')));
		}
		FreshRSS_View::prependScript(Minz_Url::display('/scripts/main.js?' . @filemtime(PUBLIC_PATH . '/scripts/main.js')));
	}

	public static function preLayout(): void {
		header("X-Content-Type-Options: nosniff");

		FreshRSS_Share::load(join_path(APP_PATH, 'shares.php'));
		self::loadStylesAndScripts();
	}

	private static function checkEmailValidated(): void {
		$email_not_verified = FreshRSS_Auth::hasAccess() &&
			FreshRSS_Context::hasUserConf() && FreshRSS_Context::userConf()->email_validation_token !== '';
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
			Minz_Request::forward([
				'c' => 'user',
				'a' => 'validateEmail',
			], true);
		}
	}
}
