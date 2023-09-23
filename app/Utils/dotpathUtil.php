<?php
// functions from https://stackoverflow.com/a/39118759
final class FreshRSS_dotpath_Util
{

	/**
	 * Get an item from an array using "dot" notation.
	 *
	 * @param  \ArrayAccess<string,mixed>|array<string,mixed>  $array
	 * @param  string  $key
	 * @param  mixed   $default
	 * @return mixed
	 */
	public static function get($array, $key, $default = null) {
		if (!static::accessible($array)) {
			return static::value($default);
		}
		if (is_null($key)) {
			return $array;
		}
		if (static::exists($array, $key)) {
			return $array[$key];
		}
		if (strpos($key, '.') === false) {
			return $array[$key] ?? static::value($default);
		}
		foreach (explode('.', $key) as $segment) {
			if (static::accessible($array) && static::exists($array, $segment)) {
				$array = $array[$segment];
			} else {
				return static::value($default);
			}
		}
		return $array;
	}

	/**
	 * Determine whether the given value is array accessible.
	 *
	 * @param  mixed  $value
	 * @return bool
	 */
	private static function accessible($value) {
		return is_array($value) || $value instanceof ArrayAccess;
	}

	/**
	 * Determine if the given key exists in the provided array.
	 *
	 * @param  \ArrayAccess<string,mixed>|array<string,mixed>  $array
	 * @param  string  $key
	 * @return bool
	 */
	private static function exists($array, $key) {
		if ($array instanceof ArrayAccess) {
			return $array->offsetExists($key);
		}
		return array_key_exists($key, $array);
	}

	private static function value(mixed $value):mixed {
		return $value instanceof Closure ? $value() : $value;
	}
}
