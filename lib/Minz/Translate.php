<?php
/** 
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
 */

/**
 * La classe Translate se charge de la traduction
 * Utilise les fichiers du répertoire /app/i18n/
 */
class Minz_Translate {
	/**
	 * $language est la langue à afficher
	 */
	private static $language;
	
	/**
	 * $translates est le tableau de correspondance
	 * 	$key => $traduction
	 */
	private static $translates = array();
	
	/**
	 * Inclus le fichier de langue qui va bien
	 * l'enregistre dans $translates
	 */
	public static function init() {
		$l = Minz_Configuration::language();
		self::$language = Minz_Session::param('language', $l);
		
		$l_path = APP_PATH . '/i18n/' . self::$language . '.php';
		
		if (file_exists($l_path)) {
			self::$translates = include($l_path);
		}
	}
	
	/**
	 * Alias de init
	 */
	public static function reset() {
		self::init();
	}
	
	/**
	 * Traduit une clé en sa valeur du tableau $translates
	 * @param $key la clé à traduire
	 * @return la valeur correspondante à la clé
	 *       > si non présente dans le tableau, on retourne la clé elle-même
	 */ 
	public static function t($key) {
		$translate = $key;
		
		if (isset(self::$translates[$key])) {
			$translate = self::$translates[$key];
		}

		$args = func_get_args();
		unset($args[0]);
		
		return vsprintf($translate, $args);
	}
	
	/**
	 * Retourne la langue utilisée actuellement
	 * @return la langue
	 */
	public static function language() {
		return self::$language;
	}
}

function _t($key) {
	$args = func_get_args();
	unset($args[0]);
	array_unshift($args, $key);

	return call_user_func_array("Minz_Translate::t", $args);
}
