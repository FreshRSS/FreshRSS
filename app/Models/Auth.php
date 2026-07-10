<?php
declare(strict_types=1);

namespace FreshRss\Models;

use FreshRss\Controllers\UserController;
use FreshRss\Minz\Error;
use FreshRss\Minz\Request;
use FreshRss\Minz\Session;
use FreshRss\Minz\Translate;
use FreshRss\Minz\Url;
use FreshRss\Minz\User;
use FreshRss\Utils\HttpUtil;

/**
 * This class handles all authentication process.
 */
class Auth {
	/**
	 * Determines if user is connected.
	 */
	public const DEFAULT_COOKIE_DURATION = 7_776_000;

	private static bool $login_ok = false;

	/**
	 * This method initializes authentication system.
	 */
	public static function init(): bool {
		if (isset($_SESSION['REMOTE_USER']) && $_SESSION['REMOTE_USER'] !== HttpUtil::httpAuthUser()) {
			//HTTP REMOTE_USER has changed
			self::removeAccess();
		}

		self::$login_ok = Session::paramBoolean('loginOk');
		$current_user = User::name();
		if ($current_user === null) {
			$current_user = Context::systemConf()->default_user;
			Session::_params([
				User::CURRENT_USER => $current_user,
				'csrf' => false,
			]);
		}

		if (self::$login_ok && self::giveAccess()) {
			return self::$login_ok;
		}
		if (self::accessControl() && self::giveAccess()) {
			UserDAO::touch();
			return self::$login_ok;
		}
		// Be sure all accesses are removed!
		self::removeAccess();
		return false;
	}

	/**
	 * This method checks if user is allowed to connect.
	 *
	 * Required session parameters are also set in this method (such as
	 * currentUser).
	 *
	 * @return bool true if user can be connected, false otherwise.
	 */
	private static function accessControl(): bool {
		$auth_type = Context::systemConf()->auth_type;
		switch ($auth_type) {
			case 'form':
				$credentials = FormAuth::getCredentialsFromCookie();
				$current_user = '';
				if (isset($credentials[1])) {
					$current_user = trim($credentials[0]);
					Session::_params([
					User::CURRENT_USER => $current_user,
					'passwordHash' => trim($credentials[1]),
					'csrf' => false,
					]);
				}
				return $current_user != '';
			case 'http_auth':
				$current_user = HttpUtil::httpAuthUser();
				if ($current_user == '') {
					return false;
				}
				$login_ok = UserDAO::exists($current_user);
				if (!$login_ok && Context::systemConf()->http_auth_auto_register) {
					$email = null;
					if (Context::systemConf()->http_auth_auto_register_email_field !== '' &&
						is_string($_SERVER[Context::systemConf()->http_auth_auto_register_email_field] ?? null)) {
						$email = $_SERVER[Context::systemConf()->http_auth_auto_register_email_field];
					}
					$language = Translate::getLanguage(null, Request::getPreferredLanguages(), Context::systemConf()->language);
					Translate::init($language);
					$login_ok = UserController::createUser($current_user, $email, '', [
					'language' => $language,
					]);
				}
				if ($login_ok) {
					Session::_params([
					User::CURRENT_USER => $current_user,
					'csrf' => false,
					]);
				}
				return $login_ok;
			case 'none':
				return true;
			default:
				// TODO load extension
				return false;
		}
	}

	/**
	 * Gives access to the current user.
	 */
	public static function giveAccess(): bool {
		Context::initUser();
		if (!Context::hasUserConf() || !Context::userConf()->enabled) {
			self::$login_ok = false;
			return false;
		}

		switch (Context::systemConf()->auth_type) {
			case 'form':
				self::$login_ok = Session::paramString('passwordHash') === Context::userConf()->passwordHash;
				break;
			case 'http_auth':
				$current_user = User::name() ?? '';
				self::$login_ok = strcasecmp($current_user, HttpUtil::httpAuthUser()) === 0;
				break;
			case 'none':
				self::$login_ok = true;
				break;
			default:
				// TODO: extensions
				self::$login_ok = false;
		}

		Session::_params([
			'loginOk' => self::$login_ok,
			'REMOTE_USER' => HttpUtil::httpAuthUser(),
		]);
		return self::$login_ok;
	}

	/**
	 * Returns if current user has access to the given scope.
	 *
	 * @param string $scope general (default) or admin
	 * @return bool true if user has corresponding access, false else.
	 */
	public static function hasAccess(string $scope = 'general'): bool {
		if (!Context::hasUserConf()) {
			return false;
		}
		$currentUser = User::name();
		$isAdmin = Context::userConf()->is_admin;
		$default_user = Context::systemConf()->default_user;
		$ok = self::$login_ok;
		switch ($scope) {
			case 'general':
				break;
			case 'admin':
				$ok &= $default_user === $currentUser || $isAdmin;
				break;
			default:
				$ok = false;
		}
		return (bool)$ok;
	}

	/**
	 * Removes all accesses for the current user.
	 */
	public static function removeAccess(): void {
		self::$login_ok = false;
		Session::_params([
			'loginOk' => false,
			'lastReauth' => false,
			'csrf' => false,
			'REMOTE_USER' => false,
		]);

		$username = Request::paramString('user');
		if (!Request::tokenIsOk()) {
			$username = Context::systemConf()->default_user;
		}
		User::change($username);

		switch (Context::systemConf()->auth_type) {
			case 'form':
				Session::_param('passwordHash');
				FormAuth::deleteCookie();
				break;
			case 'http_auth':
			case 'none':
				// Nothing to do…
				break;
			default:
				// TODO: extensions
		}
	}

	/**
	 * Return if authentication is enabled on this instance of FRSS.
	 */
	public static function accessNeedsLogin(): bool {
		return Context::systemConf()->auth_type !== 'none';
	}

	/**
	 * Return if authentication requires a PHP action.
	 */
	public static function accessNeedsAction(): bool {
		return Context::systemConf()->auth_type === 'form';
	}

	public static function csrfToken(): string {
		$csrf = Session::paramString('csrf');
		if ($csrf == '') {
			$csrf = hash('sha256', Context::systemConf()->salt . random_bytes(32));
			Session::_param('csrf', $csrf);
		}
		return $csrf;
	}

	public static function isCsrfOk(?string $token = null): bool {
		$csrf = Session::paramString('csrf');
		if ($token === null) {
			$token = is_string($_POST['_csrf'] ?? null) ? $_POST['_csrf'] : '';
		}
		return $token != '' && hash_equals($csrf, $token);
	}

	public static function needsReauth(): bool {
		$auth_type = Context::systemConf()->auth_type;
		$reauth_required = Context::systemConf()->reauth_required;
		$reauth_time = Context::systemConf()->reauth_time;

		if (!$reauth_required) {
			return false;
		}

		$last_reauth = Session::paramInt('lastReauth');

		if ($auth_type !== 'none' && time() - $last_reauth > $reauth_time) {
			if ($auth_type === 'http_auth') {
				// TODO: not implemented - just let the user through
				return false;
			}
			return true;
		}
		return false;
	}

	/**
	 * Return if user needs reauth and got redirected to login page.
	 *
	 * @param array{c?: string, a?: string, params?: array<string, mixed>}|null $redirect
	 */
	public static function requestReauth(?array $redirect = null): bool {
		if (self::needsReauth()) {
			if (Request::paramBoolean('ajax')) {
				// Send 403 and exit instead of redirect with Error::error()
				header('HTTP/1.1 403 Forbidden');
				exit();
			}

			$redirect = Url::serialize($redirect ?? Request::currentRequest());

			Request::forward([
				'c' => 'auth',
				'a' => 'reauth',
				'params' => [
					'r' => $redirect,
				],
			], true);

			return true;
		}

		return false;
	}
}
