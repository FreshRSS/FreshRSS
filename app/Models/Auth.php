<?php

/**
 * This class handles all authentication process.
 */
class FreshRSS_Auth {
	/**
	 * Determines if user is connected.
	 */
	const DEFAULT_COOKIE_DURATION = 7776000;

	private static $login_ok = false;

	/**
	 * This method initializes authentication system.
	 */
	public static function init() {
		if (isset($_SESSION['REMOTE_USER']) && $_SESSION['REMOTE_USER'] !== httpAuthUser()) {
			//HTTP REMOTE_USER has changed
			self::removeAccess();
		}

		self::$login_ok = Minz_Session::param('loginOk', false);
		$current_user = Minz_Session::param('currentUser', '');
		if ($current_user == '') {
			$current_user = FreshRSS_Context::$system_conf->default_user;
			Minz_Session::_params([
				'currentUser' => $current_user,
				'csrf' => false,
			]);
		}

		if (self::$login_ok) {
			self::giveAccess();
		} elseif (self::accessControl() && self::giveAccess()) {
			FreshRSS_UserDAO::touch();
		} else {
			// Be sure all accesses are removed!
			self::removeAccess();
		}
		return self::$login_ok;
	}

	/**
	 * This method checks if user is allowed to connect.
	 *
	 * Required session parameters are also set in this method (such as
	 * currentUser).
	 *
	 * @return boolean true if user can be connected, false else.
	 */
	private static function accessControl() {
		$auth_type = FreshRSS_Context::$system_conf->auth_type;
		switch ($auth_type) {
		case 'form':
			$credentials = FreshRSS_FormAuth::getCredentialsFromCookie();
			$current_user = '';
			if (isset($credentials[1])) {
				$current_user = trim($credentials[0]);
				Minz_Session::_params([
					'currentUser' => $current_user,
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
			if (!$login_ok && FreshRSS_Context::$system_conf->http_auth_auto_register) {
				$email = null;
				if (FreshRSS_Context::$system_conf->http_auth_auto_register_email_field !== '' &&
					isset($_SERVER[FreshRSS_Context::$system_conf->http_auth_auto_register_email_field])) {
					$email = $_SERVER[FreshRSS_Context::$system_conf->http_auth_auto_register_email_field];
				}
				$language = Minz_Translate::getLanguage(null, Minz_Request::getPreferredLanguages(), FreshRSS_Context::$system_conf->language);
				Minz_Translate::init($language);
				$login_ok = FreshRSS_user_Controller::createUser($current_user, $email, '', [
					'language' => $language,
				]);
			}
			if ($login_ok) {
				Minz_Session::_params([
					'currentUser' => $current_user,
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
	public static function giveAccess() {
		FreshRSS_Context::initUser();
		if (FreshRSS_Context::$user_conf == null) {
			self::$login_ok = false;
			return false;
		}

		switch (FreshRSS_Context::$system_conf->auth_type) {
		case 'form':
			self::$login_ok = Minz_Session::param('passwordHash') === FreshRSS_Context::$user_conf->passwordHash;
			break;
		case 'http_auth':
			$current_user = Minz_Session::param('currentUser');
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
	 * @return boolean true if user has corresponding access, false else.
	 */
	public static function hasAccess($scope = 'general') {
		if (FreshRSS_Context::$user_conf == null) {
			return false;
		}
		$currentUser = Minz_Session::param('currentUser');
		$isAdmin = FreshRSS_Context::$user_conf->is_admin;
		$default_user = FreshRSS_Context::$system_conf->default_user;
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
		return $ok;
	}

	/**
	 * Removes all accesses for the current user.
	 */
	public static function removeAccess() {
		self::$login_ok = false;
		Minz_Session::_params([
			'loginOk' => false,
			'csrf' => false,
			'REMOTE_USER' => false,
		]);

		$username = '';
		$token_param = Minz_Request::param('token', '');
		if ($token_param != '') {
			$username = trim(Minz_Request::param('user', ''));
			if ($username != '') {
				$conf = get_user_configuration($username);
				if ($conf == null) {
					$username = '';
				}
			}
		}
		if ($username == '') {
			$username = FreshRSS_Context::$system_conf->default_user;
		}
		Minz_Session::_param('currentUser', $username);

		switch (FreshRSS_Context::$system_conf->auth_type) {
		case 'form':
			Minz_Session::_param('passwordHash');
			FreshRSS_FormAuth::deleteCookie();
			break;
		case 'http_auth':
		case 'none':
			// Nothing to do...
			break;
		default:
			// TODO: extensions
		}
	}

	/**
	 * Return if authentication is enabled on this instance of FRSS.
	 */
	public static function accessNeedsLogin() {
		return FreshRSS_Context::$system_conf->auth_type !== 'none';
	}

	/**
	 * Return if authentication requires a PHP action.
	 */
	public static function accessNeedsAction() {
		return FreshRSS_Context::$system_conf->auth_type === 'form';
	}

	public static function csrfToken() {
		$csrf = Minz_Session::param('csrf');
		if ($csrf == '') {
			$salt = FreshRSS_Context::$system_conf->salt;
			$csrf = sha1($salt . uniqid(mt_rand(), true));
			Minz_Session::_param('csrf', $csrf);
		}
		return $csrf;
	}
	public static function isCsrfOk($token = null) {
		$csrf = Minz_Session::param('csrf');
		if ($token === null) {
			$token = Minz_Request::fetchPOST('_csrf');
		}
		return $token != '' && $token === $csrf;
	}
}
