<?php
declare(strict_types=1);

namespace FreshRss\Minz;

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * The Helper class contains some misc. help functions
 */
final class Helper {

	/**
	 * Wrapper for htmlspecialchars.
	 * Force UTF-8 value and can be used on array too.
	 *
	 * @phpstan-template T of mixed
	 * @phpstan-param T $var
	 * @phpstan-return T
	 */
	public static function htmlspecialchars_utf8(mixed $var, int $flags = ENT_COMPAT): mixed {
		if (is_array($var)) {
			// @phpstan-ignore return.type
			return array_map(fn($v) => self::htmlspecialchars_utf8($v, $flags), $var);
		} elseif (is_string($var)) {
			// @phpstan-ignore return.type
			return htmlspecialchars($var, $flags, 'UTF-8');
		} else {
			return $var;
		}
	}
}
