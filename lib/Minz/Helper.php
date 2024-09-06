<?php
declare(strict_types=1);

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * The Minz_Helper class contains some misc. help functions
 */
final class Minz_Helper {

	/**
	 * Wrapper for htmlspecialchars.
	 * Force UTF-8 value and can be used on array too.
	 *
	 * @phpstan-template T of mixed
	 * @phpstan-param T $var
	 * @phpstan-return T
	 */
	public static function htmlspecialchars_utf8(mixed $var): mixed {
		if (is_array($var)) {
			// @phpstan-ignore argument.type, return.type
			return array_map([self::class, 'htmlspecialchars_utf8'], $var);
		} elseif (is_string($var)) {
			// @phpstan-ignore return.type
			return htmlspecialchars($var, ENT_COMPAT, 'UTF-8');
		} else {
			return $var;
		}
	}
}
