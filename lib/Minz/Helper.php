<?php
/** 
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * La classe Helper représente une aide pour des tâches récurrentes
 */
class Minz_Helper {
	/**
	 * Annule les effets des magic_quotes pour une variable donnée
	 * @param $var variable à traiter (tableau ou simple variable)
	 */
	public static function stripslashes_r($var) {
		if (is_array($var)){
			return array_map(array('Minz_Helper', 'stripslashes_r'), $var);
		} else {
			return stripslashes($var);
		}
	}

	/**
	 * Wrapper for htmlspecialchars.
	 * Force UTf-8 value and can be used on array too.
	 */
	public static function htmlspecialchars_utf8($var) {
		if (is_array($var)) {
			return array_map(array('Minz_Helper', 'htmlspecialchars_utf8'), $var);
		}
		return htmlspecialchars($var, ENT_COMPAT, 'UTF-8');
	}
}
