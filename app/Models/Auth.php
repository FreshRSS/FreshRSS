<?php
declare(strict_types=1);

/**
 * This class handles all authentication process.
 */
class FreshRSS_Auth {
	/**
	 * Determines if user is connected.
	 */
	public const DEFAULT_COOKIE_DURATION = 7_776_000;

	private static bool $login_ok = false;

	/**
	 * This method initializes authentication system.
	 */
	public static function init(): bool {
		if (isset($_SESSION['REMOTE_USER']) && $_SESSION['REMOTE_USER'] !== httpAuthUser()) {
			//HTTP REMOTE_USER has changed
			self::removeAccess();
		}

		self::$login_ok = Minz_Session::paramBoolean('loginOk');
		$current_user = Minz_User::name();
		if ($current_user === null) {
			$current_user = FreshRSS_Context::systemConf()->default_user;
			Minz_Session::_params([
				Minz_User::CURRENT_USER => $current_user,
				'csrf' => false,
			]);
		}

		if (self::$login_ok && self::giveAccess()) {
			return self::$login_ok;
		}
		if (self::accessControl() && self::giveAccess()) {
			FreshRSS_UserDAO::touch();
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
		$auth_type = FreshRSS_Context::systemConf()->auth_type;
		switch ($auth_type) {
			case 'form':
				$credentials = FreshRSS_FormAuth::getCredentialsFromCookie();
				$current_user = '';
				if (isset($credentials[1])) {
					$current_user = trim($credentials[0]);
					Minz_Session::_params([
					Minz_User::CURRENT_USER => $current_user,
					'passwordHash' => trim($credentials[1]),
					'csrf' => false,
					]);
				}
				return $current_user != '';
			case 'http_auth':
				$current_user = httpAuthUser();
				if ($current_user == '') {
					return false;
				}
				$login_ok = FreshRSS_UserDAO::exists($current_user);
				if (!$login_ok && FreshRSS_Context::systemConf()->http_auth_auto_register) {
					$email = null;
					if (FreshRSS_Context::systemConf()->http_auth_auto_register_email_field !== '' &&
						is_string($_SERVER[FreshRSS_Context::systemConf()->http_auth_auto_register_email_field] ?? null)) {
						$email = $_SERVER[FreshRSS_Context::systemConf()->http_auth_auto_register_email_field];
					}
					$language = Minz_Translate::getLanguage(null, Minz_Request::getPreferredLanguages(), FreshRSS_Context::systemConf()->language);
					Minz_Translate::init($language);
					$login_ok = FreshRSS_user_Controller::createUser($current_user, $email, '', [
					'language' => $language,
					]);
				}
				if ($login_ok) {
					Minz_Session::_params([
					Minz_User::CURRENT_USER => $current_user,
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
		FreshRSS_Context::initUser();
		if (!FreshRSS_Context::hasUserConf() || !FreshRSS_Context::userConf()->enabled) {
			self::$login_ok = false;
			return false;
		}

		switch (FreshRSS_Context::systemConf()->auth_type) {
			case 'form':
				self::$login_ok = Minz_Session::paramString('passwordHash') === FreshRSS_Context::userConf()->passwordHash;
				break;
			case 'http_auth':
				$current_user = Minz_User::name() ?? '';
				self::$login_ok = strcasecmp($current_user, httpAuthUser()) === 0;
				break;
			case 'none':
				self::$login_ok = true;
				break;
			default:
				// TODO: extensions
				self::$login_ok = false;
		}

		Minz_Session::_params([
			'loginOk' => self::$login_ok,
			'REMOTE_USER' => httpAuthUser(),
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
		if (!FreshRSS_Context::hasUserConf()) {
			return false;
		}
		$currentUser = Minz_User::name();
		$isAdmin = FreshRSS_Context::userConf()->is_admin;
		$default_user = FreshRSS_Context::systemConf()->default_user;
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
		Minz_Session::_params([
			'loginOk' => false,
			'lastReauth' => false,
			'csrf' => false,
			'REMOTE_USER' => false,
		]);

		$username = '';
		$token_param = Minz_Request::paramString('token');
		if ($token_param != '') {
			$username = Minz_Request::paramString('user');
			if ($username != '') {
				$conf = get_user_configuration($username);
				if ($conf == null) {
					$username = '';
				}
			}
		}
		if ($username == '') {
			$username = FreshRSS_Context::systemConf()->default_user;
		}
		Minz_User::change($username);

		switch (FreshRSS_Context::systemConf()->auth_type) {
			case 'form':
				Minz_Session::_param('passwordHash');
				FreshRSS_FormAuth::deleteCookie();
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
		return FreshRSS_Context::systemConf()->auth_type !== 'none';
	}

	/**
	 * Return if authentication requires a PHP action.
	 */
	public static function accessNeedsAction(): bool {
		return FreshRSS_Context::systemConf()->auth_type === 'form';
	}

	public static function csrfToken(): string {
		$csrf = Minz_Session::paramString('csrf');
		if ($csrf == '') {
			$salt = FreshRSS_Context::systemConf()->salt;
			$csrf = sha1($salt . uniqid('' . random_int(0, mt_getrandmax()), true));
			Minz_Session::_param('csrf', $csrf);
		}
		return $csrf;
	}

	public static function isCsrfOk(?string $token = null): bool {
		$csrf = Minz_Session::paramString('csrf');
		if ($token === null) {
			$token = $_POST['_csrf'] ?? '';
		}
		return $token != '' && $token === $csrf;
	}

	public static function needsReauth(): bool {
		$auth_type = FreshRSS_Context::systemConf()->auth_type;
		$reauth_required = FreshRSS_Context::systemConf()->reauth_required;
		$reauth_time = FreshRSS_Context::systemConf()->reauth_time;

		if (!$reauth_required) {
			return false;
		}

		$last_reauth = Minz_Session::paramInt('lastReauth');

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
			if (Minz_Request::paramBoolean('ajax')) {
				// Send 403 and exit instead of redirect with Minz_Error::error()
				header('HTTP/1.1 403 Forbidden');
				exit();
			}

			$redirect = Minz_Url::serialize($redirect ?? Minz_Request::currentRequest());

			Minz_Request::forward([
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
