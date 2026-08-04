<?php
declare(strict_types=1);

use FreshRss\Minz\ActionController;
use FreshRss\Minz\Error;
use FreshRss\Minz\ExtensionManager;
use FreshRss\Minz\FrontController;
use FreshRss\Minz\HookType;
use FreshRss\Minz\Request;
use FreshRss\Minz\Session;
use FreshRss\Minz\Translate;
use FreshRss\Minz\Url;
use FreshRss\Models\Auth;
use FreshRss\Models\Context;
use FreshRss\Models\Share;
use FreshRss\Models\Themes;
use FreshRss\Models\View;

class FreshRSS extends FrontController {
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
			Session::init('FreshRSS');
		}

		Context::initSystem();
		if (!Context::hasSystemConf()) {
			$message = 'Error during context system init!';
			Error::error(500, $message, false);
			die($message);
		}

		if (Context::systemConf()->logo_html != '') {
			// Relax Content Security Policy to allow external images if a custom logo HTML is used
			ActionController::_defaultCsp([
				'default-src' => "'self'",
				'frame-ancestors' => Context::systemConf()->attributeString('csp.frame-ancestors') ?? "'none'",
				'img-src' => '* data:',
			]);
		}

		// Load list of extensions and enable the "system" ones.
		ExtensionManager::init();

		// Auth has to be initialized before using currentUser session parameter
		// because it’s this part which create this parameter.
		self::initAuth();
		if (!Context::hasUserConf()) {
			Context::initUser();
		}
		if (!Context::hasUserConf()) {
			$message = 'Error during context user init!';
			Error::error(500, $message, false);
			die($message);
		}

		// Complete initialization of the other FreshRSS / Minz components.
		self::initI18n();
		// Enable extensions for the current (logged) user.
		if (Auth::hasAccess() || Context::systemConf()->allow_anonymous) {
			$ext_list = Context::userConf()->extensions_enabled;
			ExtensionManager::enableByList($ext_list, 'user');
		}

		if (Context::systemConf()->force_email_validation && !Auth::hasAccess('admin')) {
			self::checkEmailValidated();
		}

		ExtensionManager::callHookVoid(HookType::FreshrssInit);
	}

	private static function initAuth(): void {
		Auth::init();
		if (Request::isPost()) {
			if (!Context::hasSystemConf() || !(Auth::isCsrfOk() ||
				(Request::controllerName() === 'auth' && Request::actionName() === 'login') ||
				(Request::controllerName() === 'user' && Request::actionName() === 'create' && !Auth::hasAccess('admin')) ||
				(Request::controllerName() === 'feed' && Request::actionName() === 'actualize' &&
					Context::systemConf()->allow_anonymous_refresh) ||
				(Request::controllerName() === 'javascript' && Request::actionName() === 'actualize' &&
					Context::systemConf()->allow_anonymous)
				)) {
				// Token-based protection against XSRF attacks, except for the login or self-create user forms
				self::initI18n();
				Error::error(403, ['error' => [_t('feedback.access.denied'), ' [CSRF]']]);
			}
		}
	}

	private static function initI18n(): void {
		$userLanguage = Context::hasUserConf() ? Context::userConf()->language : null;
		$systemLanguage = Context::hasSystemConf() ? Context::systemConf()->language : null;
		$language = Translate::getLanguage($userLanguage, Request::getPreferredLanguages(), $systemLanguage);

		Session::_param('language', $language);
		Translate::init($language);

		$timezone = Context::hasUserConf() ? Context::userConf()->timezone : '';
		if ($timezone == '') {
			$timezone = Context::defaultTimeZone();
		}
		date_default_timezone_set($timezone);
	}

	private static function getThemeFileUrl(string $theme_id, string $filename): string {
		$filetime = @filemtime(PUBLIC_PATH . '/themes/' . $theme_id . '/' . $filename);
		return '/themes/' . $theme_id . '/' . $filename . '?' . $filetime;
	}

	public static function loadStylesAndScripts(): void {
		if (!Context::hasUserConf()) {
			return;
		}
		$theme = Themes::load(Context::userConf()->theme);
		if (is_array($theme)) {
			foreach (array_reverse($theme['files']) as $file) {
				switch (substr($file, -3)) {
					case '.js':
						$theme_id = $theme['id'];
						$filename = $file;
						View::prependScript(Url::display(FreshRSS::getThemeFileUrl($theme_id, $filename)));
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
						View::prependStyle(Url::display(FreshRSS::getThemeFileUrl($theme_id, $filename)));
				}
			}

			if (!empty($theme['theme-color'])) {
				View::appendThemeColors($theme['theme-color']);
			}
		}
		//Use prepend to insert before extensions. Added in reverse order.
		if (!in_array(Request::controllerName(), ['index', ''], true)) {
			View::prependScript(Url::display('/scripts/extra.js?' . @filemtime(PUBLIC_PATH . '/scripts/extra.js')));
		}
		View::prependScript(Url::display('/scripts/main.js?' . @filemtime(PUBLIC_PATH . '/scripts/main.js')));
	}

	public static function preLayout(): void {
		header('X-Content-Type-Options: nosniff');

		Share::load(join_path(APP_PATH, 'shares.php'));
		self::loadStylesAndScripts();
	}

	private static function checkEmailValidated(): void {
		$email_not_verified = Auth::hasAccess() &&
			Context::hasUserConf() && Context::userConf()->email_validation_token !== '';
		$action_is_allowed = (
			Request::is('user', 'validateEmail') ||
			Request::is('user', 'sendValidationEmail') ||
			Request::is('user', 'profile') ||
			Request::is('user', 'delete') ||
			Request::is('auth', 'logout') ||
			Request::is('feed', 'actualize') ||
			Request::is('javascript', 'nonce') ||
			Request::is('error', 'index')
		);
		if ($email_not_verified && !$action_is_allowed) {
			Request::forward([
				'c' => 'user',
				'a' => 'validateEmail',
			], true);
		}
	}
}
