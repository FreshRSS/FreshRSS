<?php
declare(strict_types=1);

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
 */

/**
 * This class is used for the internationalization.
 * It uses files in `./app/i18n/`
 */
class Minz_Translate {
	public const DEFAULT_LANGUAGE = 'en';

	/**
	 * $path_list is the list of registered base path to search translations.
	 * @var array<string>
	 */
	private static array $path_list = [];

	/**
	 * $lang_name is the name of the current language to use.
	 */
	private static string $lang_name = '';

	/**
	 * $lang_files is a list of registered i18n files.
	 * @var array<string,array<string>>
	 */
	private static array $lang_files = [];

	/**
	 * Dedicated plural catalogue files registered for the current language.
	 * @var array<int,array{path:string,use_formula:bool}>
	 */
	private static array $plural_files = [];

	/**
	 * $translates is a cache for i18n translation.
	 * @var array<string,mixed>
	 */
	private static array $translates = [];

	/**
	 * Cache of normalised plural message families by i18n key.
	 * @var array<string,array<int,string>>
	 */
	private static array $plural_message_families = [];

	private static bool $plural_catalogue_loaded = false;

	private static ?int $plural_count = null;

	private static ?\Closure $plural_function = null;

	/**
	 * Init the translation object.
	 * @param string $lang_name the lang to show.
	 */
	public static function init(string $lang_name = ''): void {
		self::$lang_name = $lang_name;
		self::$lang_files = [];
		self::$plural_files = [];
		self::$translates = [];
		self::$plural_message_families = [];
		self::resetPluralCache();
		self::registerPath(APP_PATH . '/i18n');
		foreach (self::$path_list as $path) {
			self::loadLang($path);
		}
	}

	/**
	 * Reset the translation object with a new language.
	 * @param string $lang_name the new language to use
	 */
	public static function reset(string $lang_name): void {
		self::$lang_name = $lang_name;
		self::$lang_files = [];
		self::$plural_files = [];
		self::$translates = [];
		self::$plural_message_families = [];
		self::resetPluralCache();
		foreach (self::$path_list as $path) {
			self::loadLang($path);
		}
	}

	/**
	 * Return the list of available languages.
	 * @return list<string> containing langs found in different registered paths.
	 */
	public static function availableLanguages(): array {
		$list_langs = [];

		self::registerPath(APP_PATH . '/i18n');

		foreach (self::$path_list as $path) {
			$scan = scandir($path);
			if (is_array($scan)) {
				$path_langs = array_values(array_diff(
					$scan,
					['..', '.']
				));
				$list_langs = array_merge($list_langs, $path_langs);
			}
		}

		return array_values(array_unique($list_langs));
	}

	public static function exists(string $lang): bool {
		return in_array($lang, Minz_Translate::availableLanguages(), true);
	}

	/**
	 * Return the language to use in the application.
	 * It returns the connected language if it exists then returns the first match from the
	 * preferred languages then returns the default language
	 * @param string|null $user the connected user language (nullable)
	 * @param array<string> $preferred an array of the preferred languages
	 * @param string|null $default the preferred language to use
	 * @return string containing the language to use
	 */
	public static function getLanguage(?string $user, array $preferred, ?string $default): string {
		if (null !== $user) {
			if (!self::exists($user)) return self::DEFAULT_LANGUAGE;
			return $user;
		}

		$languages = Minz_Translate::availableLanguages();
		foreach ($preferred as $language) {
			$language = strtolower($language);
			if (in_array($language, $languages, true)) {
				return $language;
			}
		}

		return $default ?: self::DEFAULT_LANGUAGE;
	}

	/**
	 * Register a new path.
	 * @param string $path a path containing i18n directories (e.g. ./en/, ./fr/).
	 */
	public static function registerPath(string $path): void {
		if (!in_array($path, self::$path_list, true) && is_dir($path)) {
			self::$path_list[] = $path;
			self::loadLang($path);
		}
	}

	/**
	 * Load translations of the current language from the given path.
	 * @param string $path the path containing i18n directories.
	 */
	private static function loadLang(string $path): void {
		$selected_lang_path = $path . '/' . self::$lang_name;
		$lang_path = $path . '/' . self::$lang_name;
		$uses_selected_language = self::$lang_name !== '' && is_dir($selected_lang_path);
		if (!$uses_selected_language) {
			// The lang path does not exist, fallback to English ('en')
			$lang_path = $path . '/en';
			if (!is_dir($lang_path)) {
				// English ('en') i18n files not provided. Stop here. The keys will be shown.
				return;
			}
		}

		$list_i18n_files = array_values(array_diff(
			scandir($lang_path) ?: [],
			['..', '.']
		));
		self::$plural_message_families = [];

		// Each file basename correspond to a top-level i18n key. For each of
		// these keys we store the file pathname and mark translations must be
		// reloaded (by setting $translates[$i18n_key] to null).
		foreach ($list_i18n_files as $i18n_filename) {
			if ($i18n_filename === 'plurals.php') {
				self::$plural_files[] = [
					'path' => $lang_path . '/' . $i18n_filename,
					'use_formula' => $uses_selected_language || self::$lang_name === '',
				];
				self::resetPluralCache();
				continue;
			}
			$i18n_key = basename($i18n_filename, '.php');
			if (!isset(self::$lang_files[$i18n_key])) {
				self::$lang_files[$i18n_key] = [];
			}
			self::$lang_files[$i18n_key][] = $lang_path . '/' . $i18n_filename;
			self::$translates[$i18n_key] = null;
		}
	}

	/**
	 * Load the files associated to $key into $translates.
	 * @param string $key the top level i18n key we want to load.
	 */
	private static function loadKey(string $key): bool {
		// The top level key is not in $lang_files, it means it does not exist!
		if (!isset(self::$lang_files[$key])) {
			Minz_Log::debug($key . ' is not a valid top level key');
			return false;
		}

		self::$translates[$key] = [];

		foreach (self::$lang_files[$key] as $lang_pathname) {
			$i18n_array = include $lang_pathname;
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
	 * @param string $key the key to translate.
	 * @param bool|float|int|string ...$args additional parameters for variable keys.
	 * @return string value corresponding to the key.
	 *         If no value is found, return the key itself.
	 */
	public static function t(string $key, ...$args): string {
		$translation_value = self::resolveKey($key);
		if ($translation_value === null) {
			return $key;
		}

		if (!is_string($translation_value)) {
			$translation_value = $translation_value['_'] ?? null;
			if (!is_string($translation_value)) {
				Minz_Log::debug($key . ' is not a valid key');
				return $key;
			}
		}

		// Get the facultative arguments to replace i18n variables.
		return empty($args) ? $translation_value : vsprintf($translation_value, $args);
	}

	/**
	 * Resolve a translation key to its raw string or array value.
	 * @return array<mixed>|string|null
	 */
	private static function resolveKey(string $key): array|string|null {
		$group = explode('.', $key);

		if (count($group) < 2) {
			Minz_Log::debug($key . ' is not in a valid format');
			$top_level = 'gen';
		} else {
			$top_level = array_shift($group) ?? '';
		}

		if ((self::$translates[$top_level] ?? null) === null) {
			$res = self::loadKey($top_level);
			if (!$res) {
				return null;
			}
		}

		$translationValue = self::$translates[$top_level] ?? null;
		if (!is_array($translationValue)) {
			return null;
		}

		foreach ($group as $i18n_level) {
			if (!is_array($translationValue) || !array_key_exists($i18n_level, $translationValue)) {
				Minz_Log::debug($key . ' is not a valid key');
				return null;
			}
			$translationValue = $translationValue[$i18n_level];
		}

		if (!is_array($translationValue) && !is_string($translationValue)) {
			return null;
		}

		return $translationValue;
	}

	/**
	 * Return the current language.
	 */
	public static function language(): string {
		return self::$lang_name;
	}

	/**
	 * Reset all cached plural data.
	 */
	private static function resetPluralCache(): void {
		self::$plural_catalogue_loaded = false;
		self::$plural_count = null;
		self::$plural_function = null;
	}

	/**
	 * Load the plural catalogue for the current language.
	 */
	private static function loadPluralCatalogue(): void {
		if (self::$plural_catalogue_loaded) {
			return;
		}

		self::$plural_catalogue_loaded = true;
		$fallbackPluralCount = null;
		$fallbackPluralFunction = null;

		foreach (self::$plural_files as $pluralFile) {
			$pluralData = include $pluralFile['path'];
			if (!is_array($pluralData)) {
				Minz_Log::warning('`' . $pluralFile['path'] . '` does not contain a PHP array');
				continue;
			}

			$pluralCount = $pluralData['nplurals'] ?? null;
			$pluralFunction = $pluralData['plural'] ?? null;
			if (!is_int($pluralCount) || $pluralCount < 1 || !($pluralFunction instanceof \Closure)) {
				Minz_Log::warning('Invalid compiled plural data in `' . $pluralFile['path'] . '`. Run `make fix-all`.');
				continue;
			}

			if ($pluralFile['use_formula']) {
				if (self::$plural_function === null) {
					self::$plural_count = $pluralCount;
					self::$plural_function = $pluralFunction;
				} elseif (self::$plural_count !== $pluralCount) {
					Minz_Log::warning('Conflicting compiled plural count in `' . $pluralFile['path'] . '`');
				}
			} elseif ($fallbackPluralFunction === null) {
				$fallbackPluralCount = $pluralCount;
				$fallbackPluralFunction = $pluralFunction;
			}
		}

		if (self::$plural_function === null) {
			self::$plural_count = $fallbackPluralCount;
			self::$plural_function = $fallbackPluralFunction;
		}
	}

	private static function pluralIndex(int $value): ?int {
		if (self::$plural_count === null || self::$plural_function === null) {
			return null;
		}

		$index = (self::$plural_function)($value);
		if (!is_int($index)) {
			return null;
		}
		$index = max(0, $index);
		return min($index, self::$plural_count - 1);
	}

	/**
	 * Translate a count-based key using gettext plural indexes.
	 * @param string $baseKey Base i18n key without plural suffix (e.g. `gen.interval.second`).
	 * @param int $value Count used for plural category and `%d` substitution.
	 * @return string|null Translated string or null if no translation is found.
	 */
	public static function plural(string $baseKey, int $value): ?string {
		self::loadPluralCatalogue();

		if (!isset(self::$plural_message_families[$baseKey])) {
			$rawMessageFamily = self::resolveKey($baseKey);
			if (!is_array($rawMessageFamily) || $rawMessageFamily === []) {
				Minz_Log::debug($baseKey . ' is not a valid plural key');
				return null;
			}

			/** @var array<int,string> $messageFamily */
			$messageFamily = [];
			foreach ($rawMessageFamily as $index => $message) {
				if (is_int($index)) {
					$integerIndex = $index;
				} elseif (ctype_digit($index)) {
					$integerIndex = (int)$index;
				} else {
					$integerIndex = null;
				}
				if ($integerIndex === null) {
					continue;
				}
				if (!is_string($message)) {
					continue;
				}
				$messageFamily[$integerIndex] = $message;
			}

			if ($messageFamily === []) {
				Minz_Log::debug($baseKey . ' is not a valid plural key');
				return null;
			}

			ksort($messageFamily);
			self::$plural_message_families[$baseKey] = $messageFamily;
		}

		$messageFamily = self::$plural_message_families[$baseKey];

		$index = self::pluralIndex($value);
		if ($index !== null && isset($messageFamily[$index]) && $messageFamily[$index] !== '') {
			return vsprintf($messageFamily[$index], [$value]);
		}

		$lastMessage = end($messageFamily);
		if ($lastMessage === false || $lastMessage === '') {
			return null;
		}

		return vsprintf($lastMessage, [$value]);
	}
}


/**
 * Alias for Minz_Translate::t()
 */
function _t(string $key, bool|float|int|string ...$args): string {
	return Minz_Translate::t($key, ...$args);
}
