<?php
/** 
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
 */

/**
 * This class is used for the internationalization.
 * It uses files in `./app/i18n/`
 */
class Minz_Translate {
	/**
	 * $lang_name is the name of the current language to use.
	 */
	private static $lang_name;

	/**
	 * $lang_path is the pathname of i18n files (e.g. ./app/i18n/en/).
	 */
	private static $lang_path;

	/**
	 * $translates is a cache for i18n translation.
	 */
	private static $translates = array();

	/**
	 * Load $lang_name and $lang_path based on configuration and selected language.
	 */
	public static function init() {
		$l = Minz_Configuration::language();
		self::$lang_name = Minz_Session::param('language', $l);
		self::$lang_path = APP_PATH . '/i18n/' . self::$lang_name . '/';
	}

	/**
	 * Alias for init().
	 */
	public static function reset() {
		self::init();
	}

	/**
	 * Translate a key into its corresponding value based on selected language.
	 * @param $key the key to translate.
	 * @param additional parameters for variable keys.
	 * @return the value corresponding to the key.
	 *         If no value is found, return the key itself.
	 */ 
	public static function t($key) {
		$group = explode('.', $key);

		if (count($group) < 2) {
			// Minz_Log::debug($key . ' is not in a valid format');
			$top_level = 'gen';
		} else {
			$top_level = array_shift($group);
		}

		$filename = self::$lang_path . $top_level . '.php';

		// Try to load the i18n file if it's not done yet.
		if (!isset(self::$translates[$top_level])) {
			if (!file_exists($filename)) {
				Minz_Log::debug($top_level . ' is not a valid top level key');
				return $key;
			}

			self::$translates[$top_level] = include($filename);
		}

		// Go through the i18n keys to get the correct translation value.
		$translates = self::$translates[$top_level];
		$size_group = count($group);
		$level_processed = 0;
		$translation_value = $key;
		foreach ($group as $i18n_level) {
			$level_processed++;
			if (!isset($translates[$i18n_level])) {
				Minz_Log::debug($key . ' is not a valid key');
				return $key;
			}

			if ($level_processed < $size_group) {
				$translates = $translates[$i18n_level];
			} else {
				$translation_value = $translates[$i18n_level];
			}
		}

		if (is_array($translation_value)) {
			if (isset($translation_value['_'])) {
				$translation_value = $translation_value['_'];
			} else {
				Minz_Log::debug($key . ' is not a valid key');
				return $key;
			}
		}

		// Get the facultative arguments to replace i18n variables.
		$args = func_get_args();
		unset($args[0]);

		return vsprintf($translation_value, $args);
	}

	/**
	 * Return the current language.
	 */
	public static function language() {
		return self::$lang_name;
	}
}


/**
 * Alias for Minz_Translate::t()
 */
function _t($key) {
	$args = func_get_args();
	unset($args[0]);
	array_unshift($args, $key);

	return call_user_func_array('Minz_Translate::t', $args);
}
