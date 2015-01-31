<?php

/**
 * La classe Session gère la session utilisateur
 */
class Minz_Session {
	/**
	 * Initialise la session, avec un nom
	 * Le nom de session est utilisé comme nom pour les cookies et les URLs(i.e. PHPSESSID).
	 * Il ne doit contenir que des caractères alphanumériques ; il doit être court et descriptif
	 */
	public static function init($name) {
		$cookie = session_get_cookie_params();
		self::keepCookie($cookie['lifetime']);

		// démarre la session
		session_name($name);
		session_start();
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
		if ($v === false) {
			unset($_SESSION[$p]);
		} else {
			$_SESSION[$p] = $v;
		}
	}


	/**
	 * Permet d'effacer une session
	 * @param $force si à false, n'efface pas le paramètre de langue
	 */
	public static function unset_session($force = false) {
		$language = self::param('language');

		session_destroy();
		$_SESSION = array();

		if (!$force) {
			self::_param('language', $language);
			Minz_Translate::reset($language);
		}
	}


	/**
	 * Spécifie la durée de vie des cookies
	 * @param $l la durée de vie
	 */
	public static function keepCookie($l) {
		// Get the script_name (e.g. /p/i/index.php) and keep only the path.
		$cookie_dir = empty($_SERVER['SCRIPT_NAME']) ? '' : $_SERVER['SCRIPT_NAME'];
		$cookie_dir = dirname($cookie_dir);
		session_set_cookie_params($l, $cookie_dir, '', false, true);
	}


	/**
	 * Régénère un id de session.
	 * Utile pour appeler session_set_cookie_params après session_start()
	 */
	public static function regenerateID() {
		session_regenerate_id(true);
	}

	public static function deleteLongTermCookie($name) {
		setcookie($name, '', 1, '', '', false, true);
	}

	public static function setLongTermCookie($name, $value, $expire) {
		setcookie($name, $value, $expire, '', '', false, true);
	}

	public static function getLongTermCookie($name) {
		return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
	}

}
