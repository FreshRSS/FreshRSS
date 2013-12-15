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
	public static function stripslashes_r ($var) {
		if (is_array ($var)){
			return array_map (array ('Helper', 'stripslashes_r'), $var);
		} else {
			return stripslashes($var);
		}
	}
}
