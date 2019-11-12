<?php

namespace Freshrss\Models;

use Minz\Configuration;
use Minz\Request;
use Minz\Session;

/**
 * This class handles all authentication process.
 */
class Auth {
	/**
	 * Determines if user is connected.
	 */
	private static $login_ok = false;

	/**
	 * This method initializes authentication system.
	 */
	public static function init() {
		if (isset($_SESSION['REMOTE_USER']) && $_SESSION['REMOTE_USER'] !== httpAuthUser()) {
			//HTTP REMOTE_USER has changed
			self::removeAccess();
		}

		self::$login_ok = Session::param('loginOk', false);
		$current_user = Session::param('currentUser', '');
		if ($current_user === '') {
			$conf = Configuration::get('system');
			$current_user = $conf->default_user;
			Session::_param('currentUser', $current_user);
			Session::_param('csrf');
		}

		if (self::$login_ok) {
			self::giveAccess();
		} elseif (self::accessControl() && self::giveAccess()) {
			UserDAO::touch();
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
		$conf = Configuration::get('system');
		$auth_type = $conf->auth_type;
		switch ($auth_type) {
		case 'form':
			$credentials = FormAuth::getCredentialsFromCookie();
			$current_user = '';
			if (isset($credentials[1])) {
				$current_user = trim($credentials[0]);
				Session::_param('currentUser', $current_user);
				Session::_param('passwordHash', trim($credentials[1]));
				Session::_param('csrf');
			}
			return $current_user != '';
		case 'http_auth':
			$current_user = httpAuthUser();
			$login_ok = $current_user != '' && UserDAO::exists($current_user);
			if ($login_ok) {
				Session::_param('currentUser', $current_user);
				Session::_param('csrf');
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
		$current_user = Session::param('currentUser');
		$user_conf = get_user_configuration($current_user);
		if ($user_conf == null) {
			self::$login_ok = false;
			return false;
		}
		$system_conf = Configuration::get('system');

		switch ($system_conf->auth_type) {
		case 'form':
			self::$login_ok = Session::param('passwordHash') === $user_conf->passwordHash;
			break;
		case 'http_auth':
			self::$login_ok = strcasecmp($current_user, httpAuthUser()) === 0;
			break;
		case 'none':
			self::$login_ok = true;
			break;
		default:
			// TODO: extensions
			self::$login_ok = false;
		}

		Session::_param('loginOk', self::$login_ok);
		Session::_param('REMOTE_USER', httpAuthUser());
		return self::$login_ok;
	}

	/**
	 * Returns if current user has access to the given scope.
	 *
	 * @param string $scope general (default) or admin
	 * @return boolean true if user has corresponding access, false else.
	 */
	public static function hasAccess($scope = 'general') {
		$conf = Configuration::get('system');
		$default_user = $conf->default_user;
		$ok = self::$login_ok;
		switch ($scope) {
		case 'general':
			break;
		case 'admin':
			$ok &= Session::param('currentUser') === $default_user;
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
		Session::_param('loginOk');
		Session::_param('csrf');
		Session::_param('REMOTE_USER');
		$system_conf = Configuration::get('system');

		$username = '';
		$token_param = Request::param('token', '');
		if ($token_param != '') {
			$username = trim(Request::param('user', ''));
			if ($username != '') {
				$conf = get_user_configuration($username);
				if ($conf == null) {
					$username = '';
				}
			}
		}
		if ($username == '') {
			$username = $system_conf->default_user;
		}
		Session::_param('currentUser', $username);

		switch ($system_conf->auth_type) {
		case 'form':
			Session::_param('passwordHash');
			FormAuth::deleteCookie();
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
		$conf = Configuration::get('system');
		$auth_type = $conf->auth_type;
		return $auth_type !== 'none';
	}

	/**
	 * Return if authentication requires a PHP action.
	 */
	public static function accessNeedsAction() {
		$conf = Configuration::get('system');
		$auth_type = $conf->auth_type;
		return $auth_type === 'form';
	}

	public static function csrfToken() {
		$csrf = Session::param('csrf');
		if ($csrf == '') {
			$salt = Context::$system_conf->salt;
			$csrf = sha1($salt . uniqid(mt_rand(), true));
			Session::_param('csrf', $csrf);
		}
		return $csrf;
	}
	public static function isCsrfOk($token = null) {
		$csrf = Session::param('csrf');
		if ($token === null) {
			$token = Request::fetchPOST('_csrf');
		}
		return $token != '' && $token === $csrf;
	}
}


class FormAuth {
	public static function checkCredentials($username, $hash, $nonce, $challenge) {
		if (!user_Controller::checkUsername($username) ||
				!ctype_graph($challenge) ||
				!ctype_alnum($nonce)) {
			Log::debug('Invalid credential parameters:' .
			                ' user=' . $username .
			                ' challenge=' . $challenge .
			                ' nonce=' . $nonce);
			return false;
		}

		return password_verify($nonce . $hash, $challenge);
	}

	public static function getCredentialsFromCookie() {
		$token = Session::getLongTermCookie('login');
		if (!ctype_alnum($token)) {
			return array();
		}

		$token_file = DATA_PATH . '/tokens/' . $token . '.txt';
		$mtime = @filemtime($token_file);
		$conf = Configuration::get('system');
		$limits = $conf->limits;
		$cookie_duration = empty($limits['cookie_duration']) ? 2592000 : $limits['cookie_duration'];
		if ($mtime + $cookie_duration < time()) {
			// Token has expired (> cookie_duration) or does not exist.
			@unlink($token_file);
			return array();
		}

		$credentials = @file_get_contents($token_file);
		return $credentials === false ? array() : explode("\t", $credentials, 2);
	}

	public static function makeCookie($username, $password_hash) {
		$conf = Configuration::get('system');
		do {
			$token = sha1($conf->salt . $username . uniqid(mt_rand(), true));
			$token_file = DATA_PATH . '/tokens/' . $token . '.txt';
		} while (file_exists($token_file));

		if (@file_put_contents($token_file, $username . "\t" . $password_hash) === false) {
			return false;
		}

		$limits = $conf->limits;
		$cookie_duration = empty($limits['cookie_duration']) ? 2592000 : $limits['cookie_duration'];
		$expire = time() + $cookie_duration;
		Session::setLongTermCookie('login', $token, $expire);
		return $token;
	}

	public static function deleteCookie() {
		$token = Session::getLongTermCookie('login');
		if (ctype_alnum($token)) {
			Session::deleteLongTermCookie('login');
			@unlink(DATA_PATH . '/tokens/' . $token . '.txt');
		}

		if (rand(0, 10) === 1) {
			self::purgeTokens();
		}
	}

	public static function purgeTokens() {
		$conf = Configuration::get('system');
		$limits = $conf->limits;
		$cookie_duration = empty($limits['cookie_duration']) ? 2592000 : $limits['cookie_duration'];
		$oldest = time() - $cookie_duration;
		foreach (new DirectoryIterator(DATA_PATH . '/tokens/') as $file_info) {
			$extension = $file_info->getExtension();
			if ($extension === 'txt' && $file_info->getMTime() < $oldest) {
				@unlink($file_info->getPathname());
			}
		}
	}
}
