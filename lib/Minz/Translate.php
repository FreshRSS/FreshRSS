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
	 * $path_list is the list of registered base path to search translations.
	 */
	private static $path_list = array();

	/**
	 * $lang_name is the name of the current language to use.
	 */
	private static $lang_name;

	/**
	 * $lang_files is a list of registered i18n files.
	 */
	private static $lang_files = array();

	/**
	 * $translates is a cache for i18n translation.
	 */
	private static $translates = array();

	/**
	 * Init the translation object.
	 * @param $lang_name the lang to show.
	 */
	public static function init($lang_name = null) {
		self::$lang_name = $lang_name;
		self::$lang_files = array();
		self::$translates = array();
		self::registerPath(APP_PATH . '/i18n');
		foreach (self::$path_list as $path) {
			self::loadLang($path);
		}
	}

	/**
	 * Reset the translation object with a new language.
	 * @param $lang_name the new language to use
	 */
	public static function reset($lang_name) {
		self::$lang_name = $lang_name;
		self::$lang_files = array();
		self::$translates = array();
		foreach (self::$path_list as $path) {
			self::loadLang($path);
		}
	}

	/**
	 * Return the list of available languages.
	 * @return array containing langs found in different registered paths.
	 */
	public static function availableLanguages() {
		$list_langs = array();

		self::registerPath(APP_PATH . '/i18n');

		foreach (self::$path_list as $path) {
			$scan = scandir($path);
			if (is_array($scan)) {
				$path_langs = array_values(array_diff(
					$scan,
					array('..', '.')
				));
				if (is_array($path_langs)) {
					$list_langs = array_merge($list_langs, $path_langs);
				}
			}
		}

		return array_unique($list_langs);
	}

	/**
	 * Return the language to use in the application.
	 * It returns the connected language if it exists then returns the first match from the
	 * preferred languages then returns the default language
	 * @param $user the connected user language (nullable)
	 * @param $preferred an array of the preferred languages
	 * @param $default the preferred language to use
	 * @return string containing the language to use
	 */
	public static function getLanguage($user, $preferred, $default) {
		if (null !== $user) {
			return $user;
		}

		$languages = Minz_Translate::availableLanguages();
		foreach ($preferred as $language) {
			$language = strtolower($language);
			if (in_array($language, $languages, true)) {
				return $language;
			}
		}

		return $default ? $default : 'en';
	}

	/**
	 * Register a new path.
	 * @param $path a path containing i18n directories (e.g. ./en/, ./fr/).
	 */
	public static function registerPath($path) {
		if (!in_array($path, self::$path_list) && is_dir($path)) {
			self::$path_list[] = $path;
			self::loadLang($path);
		}
	}

	/**
	 * Load translations of the current language from the given path.
	 * @param $path the path containing i18n directories.
	 */
	private static function loadLang($path) {
		$lang_path = $path . '/' . self::$lang_name;
		if (!file_exists($lang_path) || self::$lang_name == '') {
			// The lang path does not exist, nothing more to do.
			return;
		}

		$list_i18n_files = array_values(array_diff(
			scandir($lang_path),
			array('..', '.')
		));

		// Each file basename correspond to a top-level i18n key. For each of
		// these keys we store the file pathname and mark translations must be
		// reloaded (by setting $translates[$i18n_key] to null).
		foreach ($list_i18n_files as $i18n_filename) {
			$i18n_key = basename($i18n_filename, '.php');
			if (!isset(self::$lang_files[$i18n_key])) {
				self::$lang_files[$i18n_key] = array();
			}
			self::$lang_files[$i18n_key][] = $lang_path . '/' . $i18n_filename;
			self::$translates[$i18n_key] = null;
		}
	}

	/**
	 * Load the files associated to $key into $translates.
	 * @param $key the top level i18n key we want to load.
	 */
	private static function loadKey($key) {
		// The top level key is not in $lang_files, it means it does not exist!
		if (!isset(self::$lang_files[$key])) {
			Minz_Log::debug($key . ' is not a valid top level key');
			return false;
		}

		self::$translates[$key] = array();

		foreach (self::$lang_files[$key] as $lang_pathname) {
			$i18n_array = include($lang_pathname);
			if (!is_array($i18n_array)) {
				Minz_Log::warning('`' . $lang_pathname . '` does not contain a PHP array');
				continue;
			}

			// We must avoid to erase previous data so we just override them if
			// needed.
			self::$translates[$key] = array_replace_recursive(
				self::$translates[$key], $i18n_array
			);
		}

		return true;
	}

	/**
	 * Translate a key into its corresponding value based on selected language.
	 * @param $key the key to translate.
	 * @param additional parameters for variable keys.
	 * @return string value corresponding to the key.
	 *         If no value is found, return the key itself.
	 */
	public static function t($key) {
		$group = explode('.', $key);

		if (count($group) < 2) {
			Minz_Log::debug($key . ' is not in a valid format');
			$top_level = 'gen';
		} else {
			$top_level = array_shift($group);
		}

		// If $translates[$top_level] is null it means we have to load the
		// corresponding files.
		if (!isset(self::$translates[$top_level]) ||
				is_null(self::$translates[$top_level])) {
			$res = self::loadKey($top_level);
			if (!$res) {
				return $key;
			}
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
