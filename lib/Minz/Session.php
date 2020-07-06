<?php

/**
 * La classe Session gère la session utilisateur
 */
class Minz_Session {
	private static $volatile = false;
	
	/**
	 * Initialise la session, avec un nom
	 * Le nom de session est utilisé comme nom pour les cookies et les URLs(i.e. PHPSESSID).
	 * Il ne doit contenir que des caractères alphanumériques ; il doit être court et descriptif.
	 * If the volatile parameter is true, then no cookie and not session storage are used.
	 * Volatile is especially useful for API calls without cookie / Web session.
	 */
	public static function init($name, $volatile = false) {
		self::$volatile = $volatile;
		if (self::$volatile) {
			$_SESSION = [];
			return;
		}

		$cookie = session_get_cookie_params();
		self::keepCookie($cookie['lifetime']);

		// démarre la session
		session_name($name);
		session_start();
		session_write_close();
		//Use cookie only the first time the session is started
		ini_set('session.use_cookies', '0');
	}


	/**
	 * Permet de récupérer une variable de session
	 * @param $p le paramètre à récupérer
	 * @return la valeur de la variable de session, false si n'existe pas
	 */
	public static function param($p, $default = false) {
		return isset($_SESSION[$p]) ? $_SESSION[$p] : $default;
	}


	/**
	 * Permet de créer ou mettre à jour une variable de session
	 * @param $p le paramètre à créer ou modifier
	 * @param $v la valeur à attribuer, false pour supprimer
	 */
	public static function _param($p, $v = false) {
		if (!self::$volatile) {
			session_start();
		}
		if ($v === false) {
			unset($_SESSION[$p]);
		} else {
			$_SESSION[$p] = $v;
		}
		if (!self::$volatile) {
			session_write_close();
		}
	}

	public static function _params($keyValues) {
		if (!self::$volatile) {
			session_start();
		}
		foreach ($keyValues as $k => $v) {
			if ($v === false) {
				unset($_SESSION[$k]);
			} else {
				$_SESSION[$k] = $v;
			}
		}
		if (!self::$volatile) {
			session_write_close();
		}
	}

	/**
	 * Permet d'effacer une session
	 * @param $force si à false, n'efface pas le paramètre de langue
	 */
	public static function unset_session($force = false) {
		$language = self::param('language');

		if (!self::$volatile) {
			session_destroy();
		}
		$_SESSION = array();

		if (!$force) {
			self::_param('language', $language);
			Minz_Translate::reset($language);
		}
	}

	public static function getCookieDir() {
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
	 * Spécifie la durée de vie des cookies
	 * @param $l la durée de vie
	 */
	public static function keepCookie($l) {
		session_set_cookie_params($l, self::getCookieDir(), '', Minz_Request::isHttps(), true);
	}


	/**
	 * Régénère un id de session.
	 * Utile pour appeler session_set_cookie_params après session_start()
	 */
	public static function regenerateID() {
		session_regenerate_id(true);
	}

	public static function deleteLongTermCookie($name) {
		setcookie($name, '', 1, '', '', Minz_Request::isHttps(), true);
	}

	public static function setLongTermCookie($name, $value, $expire) {
		setcookie($name, $value, $expire, '', '', Minz_Request::isHttps(), true);
	}

	public static function getLongTermCookie($name) {
		return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
	}

}
