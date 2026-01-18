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
	 * Initialize and start the session, with a name
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

		$params = session_get_cookie_params();
		// Sanitize lifetime of session cookies from PHP ini `session.cookie_lifetime` (default 0)
		$params['lifetime'] = ($params['lifetime'] <= 0 || $params['lifetime'] > 86400) ? 0 : $params['lifetime'];
		$params['path'] = '';	// Current directory
		$params['domain'] = '';	// Current domain
		$params['secure'] = Minz_Request::isHttps();
		$params['httponly'] = true;
		$params['samesite'] = 'Lax';
		session_set_cookie_params($params);

		session_name($name);
		// When using cookies (default value), session_start() sends HTTP headers
		session_start();
		session_write_close();
		// Use cookie only the first time the session is started to avoid resending HTTP headers
		ini_set('session.use_cookies', '0');
	}

	/**
	 * Allows you to retrieve a session variable
	 * @param string $p the parameter to retrieve
	 * @param mixed|false $default the default value if the parameter doesn’t exist
	 * @return mixed|false the value of the session variable, false if doesn’t exist
	 */
	#[Deprecated('Use typed versions instead')]
	public static function param(string $p, $default = false): mixed {
		return $_SESSION[$p] ?? $default;
	}

	/** @return array<string|int,string|array<string,mixed>> */
	public static function paramArray(string $key): array {
		if (empty($_SESSION[$key]) || !is_array($_SESSION[$key])) {
			return [];
		}
		$result = [];
		foreach ($_SESSION[$key] as $k => $v) {
			if (is_string($v) || (is_array($v) && is_array_keys_string($v))) {
				$result[$k] = $v;
			}
		}
		return $result;
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
		return empty($_SESSION[$key]) || !is_numeric($_SESSION[$key]) ? 0 : (int)$_SESSION[$key];
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
		$_SESSION = [];

		if (!$force) {
			self::_param('language', $language);
			Minz_Translate::reset($language);
		}
	}

	/**
	 * Regenerate a session id.
	 */
	public static function regenerateID(string $name): void {
		if (self::$volatile || self::$locked) {
			return;
		}
		// Ensure that regenerating the session won't send multiple cookies so we can send one ourselves instead
		ini_set('session.use_cookies', '0');
		session_name($name);
		session_start();
		session_regenerate_id(true);
		session_write_close();
		$newId = session_id();
		if ($newId === false) {
			Minz_Error::error(500);
			return;
		}
		$params = session_get_cookie_params();
		$params['expires'] = $params['lifetime'] > 0 ? time() + $params['lifetime'] : 0;
		unset($params['lifetime']);
		setcookie($name, $newId, $params);
	}

	public static function deleteLongTermCookie(string $name): void {
		$params = session_get_cookie_params();
		$params['expires'] = 1;
		unset($params['lifetime']);
		setcookie($name, '', $params);
	}

	public static function setLongTermCookie(string $name, string $value, int $expire): void {
		$params = session_get_cookie_params();
		$params['expires'] = $expire;
		unset($params['lifetime']);
		setcookie($name, $value, $params);
	}

	public static function getLongTermCookie(string $name): string {
		return is_string($_COOKIE[$name] ?? null) ? $_COOKIE[$name] : '';
	}
}
