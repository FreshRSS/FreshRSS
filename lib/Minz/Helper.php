<?php
/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * The Minz_Helper class contains some misc. help functions
 */
class Minz_Helper {

	/**
	 * Wrapper for htmlspecialchars.
	 * Force UTf-8 value and can be used on array too.
	 *
	 * @phpstan-template T of string|array<mixed>
	 * @phpstan-param T $var
	 * @phpstan-return T
	 *
	 * @param string|array<string> $var
	 * @return string|array<string>
	 */
	public static function htmlspecialchars_utf8($var) {
		if (is_array($var)) {
			return array_map(array('Minz_Helper', 'htmlspecialchars_utf8'), $var);
		} elseif (is_string($var)) {
			return htmlspecialchars($var, ENT_COMPAT, 'UTF-8');
		} else {
			return $var;
		}
	}
}
