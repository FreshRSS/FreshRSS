<?php

namespace Minz;

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * La classe Helper représente une aide pour des tâches récurrentes
 */
class Helper {

	/**
	 * Wrapper for htmlspecialchars.
	 * Force UTf-8 value and can be used on array too.
	 */
	public static function htmlspecialchars_utf8($var) {
		if (is_array($var)) {
			return array_map(array('Helper', 'htmlspecialchars_utf8'), $var);
		}
		return htmlspecialchars($var, ENT_COMPAT, 'UTF-8');
	}
}
