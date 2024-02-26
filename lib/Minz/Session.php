<?php
declare(strict_types=1);

/**
 * The Minz_Session class handles user’s session
 */
class Minz_Session {

	private static bool $volatile = false;

	/**
	 * For mutual exclusion.
	 */
	private static bool $locked = false;

	public static function lock(): bool {
		if (!self::$volatile && !self::$locked) {
			session_start();
			self::$locked = true;
		}
		return self::$locked;
	}

	public static function unlock(): bool {
		if (!self::$volatile) {
			session_write_close();
			self::$locked = false;
		}
		return self::$locked;
	}

	/**
	 * Initialize the session, with a name
	 * The session name is used as the name for cookies and URLs (i.e. PHPSESSID).
	 * It should contain only alphanumeric characters; it should be short and descriptive
	 * If the volatile parameter is true, then no cookie and not session storage are used.
	 * Volatile is especially useful for API calls without cookie / Web session.
	 */
	public static function init(string $name, bool $volatile = false): void {
		self::$volatile = $volatile;
		if (self::$volatile) {
			$_SESSION = [];
			return;
		}

		$cookie = session_get_cookie_params();
		self::keepCookie($cookie['lifetime']);

		// start session
		session_name($name);
		//When using cookies (default value), session_stars() sends HTTP headers
		session_start();
		session_write_close();
		//Use cookie only the first time the session is started to avoid resending HTTP headers
		ini_set('session.use_cookies', '0');
	}


	/**
	 * Allows you to retrieve a session variable
	 * @param string $p the parameter to retrieve
	 * @param mixed|false $default the default value if the parameter doesn’t exist
	 * @return mixed|false the value of the session variable, false if doesn’t exist
	 * @deprecated Use typed versions instead
	 */
	public static function param(string $p, $default = false) {
		return $_SESSION[$p] ?? $default;
	}

	/** @return array<string|int,string|array<string,mixed>> */
	public static function paramArray(string $key): array {
		if (empty($_SESSION[$key]) || !is_array($_SESSION[$key])) {
			return [];
		}
		return $_SESSION[$key];
	}

	public static function paramTernary(string $key): ?bool {
		if (isset($_SESSION[$key])) {
			$p = $_SESSION[$key];
			$tp = is_string($p) ? trim($p) : true;
			if ($tp === '' || $tp === 'null') {
				return null;
			} elseif ($p == false || $tp == '0' || $tp === 'false' || $tp === 'no') {
				return false;
			}
			return true;
		}
		return null;
	}

	public static function paramBoolean(string $key): bool {
		if (null === $value = self::paramTernary($key)) {
			return false;
		}
		return $value;
	}

	public static function paramInt(string $key): int {
		if (!empty($_SESSION[$key])) {
			return intval($_SESSION[$key]);
		}
		return 0;
	}

	public static function paramString(string $key): string {
		if (isset($_SESSION[$key])) {
			$s = $_SESSION[$key];
			if (is_string($s)) {
				return $s;
			}
			if (is_int($s) || is_bool($s)) {
				return (string)$s;
			}
		}
		return '';
	}

	/**
	 * Allows you to create or update a session variable
	 * @param string $parameter the parameter to create or modify
	 * @param mixed|false $value the value to assign, false to delete
	 */
	public static function _param(string $parameter, $value = false): void {
		if (!self::$volatile && !self::$locked) {
			session_start();
		}
		if ($value === false) {
			unset($_SESSION[$parameter]);
		} else {
			$_SESSION[$parameter] = $value;
		}
		if (!self::$volatile && !self::$locked) {
			session_write_close();
		}
	}

	/**
	 * @param array<string,string|bool|int|array<string>> $keyValues
	 */
	public static function _params(array $keyValues): void {
		if (!self::$volatile && !self::$locked) {
			session_start();
		}
		foreach ($keyValues as $key => $value) {
			if ($value === false) {
				unset($_SESSION[$key]);
			} else {
				$_SESSION[$key] = $value;
			}
		}
		if (!self::$volatile && !self::$locked) {
			session_write_close();
		}
	}

	/**
	 * Allows to delete a session
	 * @param bool $force if false, does not clear the language parameter
	 */
	public static function unset_session(bool $force = false): void {
		$language = self::paramString('language');

		if (!self::$volatile) {
			session_destroy();
		}
		$_SESSION = array();

		if (!$force) {
			self::_param('language', $language);
			Minz_Translate::reset($language);
		}
	}

	public static function getCookieDir(): string {
		// Get the script_name (e.g. /p/i/index.php) and keep only the path.
		$cookie_dir = '';
		if (!empty($_SERVER['HTTP_X_FORWARDED_PREFIX'])) {
			$cookie_dir .= rtrim($_SERVER['HTTP_X_FORWARDED_PREFIX'], '/ ');
		}
		$cookie_dir .= empty($_SERVER['REQUEST_URI']) ? '/' : $_SERVER['REQUEST_URI'];
		if (substr($cookie_dir, -1) !== '/') {
			$cookie_dir = dirname($cookie_dir) . '/';
		}
		return $cookie_dir;
	}

	/**
	 * Specifies the lifetime of the cookies
	 * @param int $l the lifetime
	 */
	public static function keepCookie(int $l): void {
		session_set_cookie_params($l, self::getCookieDir(), '', Minz_Request::isHttps(), true);
	}

	/**
	 * Regenerate a session id.
	 * Useful to call session_set_cookie_params after session_start()
	 */
	public static function regenerateID(): void {
		session_regenerate_id(true);
	}

	public static function deleteLongTermCookie(string $name): void {
		setcookie($name, '', 1, '', '', Minz_Request::isHttps(), true);
	}

	public static function setLongTermCookie(string $name, string $value, int $expire): void {
		setcookie($name, $value, $expire, '', '', Minz_Request::isHttps(), true);
	}

	public static function getLongTermCookie(string $name): string {
		return $_COOKIE[$name] ?? '';
	}

}
