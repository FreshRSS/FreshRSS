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

	private static bool $plural_catalogue_loaded = false;

	private static ?string $plural_forms = null;

	private static bool $plural_rule_loaded = false;

	private static ?int $plural_count = null;

	/** @var array<string,mixed>|null */
	private static ?array $plural_expression_tree = null;

	/**
	 * Init the translation object.
	 * @param string $lang_name the lang to show.
	 */
	public static function init(string $lang_name = ''): void {
		self::$lang_name = $lang_name;
		self::$lang_files = [];
		self::$plural_files = [];
		self::$translates = [];
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
		if (self::$lang_name === '' || !$uses_selected_language) {
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

		if (empty(self::$translates[$top_level])) {
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
		self::$plural_forms = null;
		self::$plural_rule_loaded = false;
		self::$plural_count = null;
		self::$plural_expression_tree = null;
	}

	/**
	 * Load the plural catalogue for the current language.
	 */
	private static function loadPluralCatalogue(): void {
		if (self::$plural_catalogue_loaded) {
			return;
		}

		self::$plural_catalogue_loaded = true;
		$fallbackPluralForms = null;

		foreach (self::$plural_files as $pluralFile) {
			$pluralData = include $pluralFile['path'];
			if (!is_array($pluralData)) {
				Minz_Log::warning('`' . $pluralFile['path'] . '` does not contain a PHP array');
				continue;
			}

			$pluralForms = $pluralData['plural-forms'] ?? null;
			if (!is_string($pluralForms) || $pluralForms === '') {
				continue;
			}

			if ($pluralFile['use_formula']) {
				if (self::$plural_forms === null) {
					self::$plural_forms = $pluralForms;
				} elseif (self::$plural_forms !== $pluralForms) {
					Minz_Log::warning('Conflicting plural formula in `' . $pluralFile['path'] . '`');
				}
			} elseif ($fallbackPluralForms === null) {
				$fallbackPluralForms = $pluralForms;
			}
		}

		if (self::$plural_forms === null) {
			self::$plural_forms = $fallbackPluralForms;
		}
	}

	/**
	 * Parse the plural rule into an evaluable syntax tree.
	 */
	private static function loadPluralRule(): bool {
		if (self::$plural_rule_loaded) {
			return self::$plural_count !== null && self::$plural_expression_tree !== null;
		}

		self::$plural_rule_loaded = true;
		self::loadPluralCatalogue();

		if (!is_string(self::$plural_forms) || self::$plural_forms === '') {
			return false;
		}

		if (!preg_match('/^\s*nplurals\s*=\s*(\d+)\s*;\s*plural\s*=\s*(.+?)\s*;\s*$/', self::$plural_forms, $matches)) {
			Minz_Log::warning('Invalid plural formula: ' . self::$plural_forms);
			return false;
		}

		self::$plural_count = max(1, (int)$matches[1]);
		self::$plural_expression_tree = self::parsePluralExpression($matches[2]);

		return true;
	}

	/**
	 * Tokenise and parse a gettext plural expression.
	 * @return array<string,mixed>
	 */
	private static function parsePluralExpression(string $expression): array {
		$tokens = [];
		$offset = 0;
		$length = strlen($expression);
		$pattern = '/\G\s*(\d+|n|==|!=|<=|>=|\|\||&&|[?:()!%+\-*\/<>=])\s*/A';

		while ($offset < $length) {
			if (preg_match($pattern, $expression, $matches, 0, $offset) !== 1) {
				throw new RuntimeException('Unable to parse plural expression near `' . substr($expression, $offset) . '`');
			}
			$tokens[] = $matches[1];
			$offset += strlen($matches[0]);
		}

		$position = 0;
		$tree = self::parsePluralTernary($tokens, $position, $expression);
		if ($position !== count($tokens)) {
			throw new RuntimeException('Unexpected token in plural expression `' . $expression . '`');
		}

		return $tree;
	}

	/**
	 * @param array<string,mixed> $node
	 * @return array<string,mixed>
	 */
	private static function childPluralNode(array $node, string $key): array {
		$child = $node[$key] ?? [];
		if (!is_array($child)) {
			return [];
		}

		/** @var array<string,mixed> $child */
		return $child;
	}

	/**
	 * @param list<string> $tokens
	 * @return array<string,mixed>
	 */
	private static function parsePluralTernary(array $tokens, int &$position, string $expression): array {
		$condition = self::parsePluralLogicalOr($tokens, $position, $expression);
		if (($tokens[$position] ?? null) !== '?') {
			return $condition;
		}

		$position++;
		$ifTrue = self::parsePluralTernary($tokens, $position, $expression);
		if (($tokens[$position] ?? null) !== ':') {
			throw new RuntimeException('Missing `:` in plural expression `' . $expression . '`');
		}
		$position++;
		$ifFalse = self::parsePluralTernary($tokens, $position, $expression);

		return [
			'type' => 'ternary',
			'condition' => $condition,
			'if_true' => $ifTrue,
			'if_false' => $ifFalse,
		];
	}

	/**
	 * @param list<string> $tokens
	 * @return array<string,mixed>
	 */
	private static function parsePluralLogicalOr(array $tokens, int &$position, string $expression): array {
		$node = self::parsePluralLogicalAnd($tokens, $position, $expression);
		while (($tokens[$position] ?? null) === '||') {
			$position++;
			$node = [
				'type' => 'binary',
				'operator' => '||',
				'left' => $node,
				'right' => self::parsePluralLogicalAnd($tokens, $position, $expression),
			];
		}

		return $node;
	}

	/**
	 * @param list<string> $tokens
	 * @return array<string,mixed>
	 */
	private static function parsePluralLogicalAnd(array $tokens, int &$position, string $expression): array {
		$node = self::parsePluralEquality($tokens, $position, $expression);
		while (($tokens[$position] ?? null) === '&&') {
			$position++;
			$node = [
				'type' => 'binary',
				'operator' => '&&',
				'left' => $node,
				'right' => self::parsePluralEquality($tokens, $position, $expression),
			];
		}

		return $node;
	}

	/**
	 * @param list<string> $tokens
	 * @return array<string,mixed>
	 */
	private static function parsePluralEquality(array $tokens, int &$position, string $expression): array {
		$node = self::parsePluralRelational($tokens, $position, $expression);
		while (in_array($tokens[$position] ?? null, ['==', '!='], true)) {
			$operator = $tokens[$position] ?? '';
			$position++;
			$node = [
				'type' => 'binary',
				'operator' => $operator,
				'left' => $node,
				'right' => self::parsePluralRelational($tokens, $position, $expression),
			];
		}

		return $node;
	}

	/**
	 * @param list<string> $tokens
	 * @return array<string,mixed>
	 */
	private static function parsePluralRelational(array $tokens, int &$position, string $expression): array {
		$node = self::parsePluralAdditive($tokens, $position, $expression);
		while (in_array($tokens[$position] ?? null, ['<', '<=', '>', '>='], true)) {
			$operator = $tokens[$position] ?? '';
			$position++;
			$node = [
				'type' => 'binary',
				'operator' => $operator,
				'left' => $node,
				'right' => self::parsePluralAdditive($tokens, $position, $expression),
			];
		}

		return $node;
	}

	/**
	 * @param list<string> $tokens
	 * @return array<string,mixed>
	 */
	private static function parsePluralAdditive(array $tokens, int &$position, string $expression): array {
		$node = self::parsePluralMultiplicative($tokens, $position, $expression);
		while (in_array($tokens[$position] ?? null, ['+', '-'], true)) {
			$operator = $tokens[$position] ?? '';
			$position++;
			$node = [
				'type' => 'binary',
				'operator' => $operator,
				'left' => $node,
				'right' => self::parsePluralMultiplicative($tokens, $position, $expression),
			];
		}

		return $node;
	}

	/**
	 * @param list<string> $tokens
	 * @return array<string,mixed>
	 */
	private static function parsePluralMultiplicative(array $tokens, int &$position, string $expression): array {
		$node = self::parsePluralUnary($tokens, $position, $expression);
		while (in_array($tokens[$position] ?? null, ['*', '/', '%'], true)) {
			$operator = $tokens[$position] ?? '';
			$position++;
			$node = [
				'type' => 'binary',
				'operator' => $operator,
				'left' => $node,
				'right' => self::parsePluralUnary($tokens, $position, $expression),
			];
		}

		return $node;
	}

	/**
	 * @param list<string> $tokens
	 * @return array<string,mixed>
	 */
	private static function parsePluralUnary(array $tokens, int &$position, string $expression): array {
		$token = $tokens[$position] ?? null;
		if ($token === '!' || $token === '-') {
			$position++;
			return [
				'type' => 'unary',
				'operator' => $token,
				'operand' => self::parsePluralUnary($tokens, $position, $expression),
			];
		}

		return self::parsePluralPrimary($tokens, $position, $expression);
	}

	/**
	 * @param list<string> $tokens
	 * @return array<string,mixed>
	 */
	private static function parsePluralPrimary(array $tokens, int &$position, string $expression): array {
		$token = $tokens[$position] ?? null;
		if ($token === null) {
			throw new RuntimeException('Unexpected end of plural expression `' . $expression . '`');
		}

		if (ctype_digit($token)) {
			$position++;
			return ['type' => 'number', 'value' => (int)$token];
		}

		if ($token === 'n') {
			$position++;
			return ['type' => 'variable'];
		}

		if ($token === '(') {
			$position++;
			$node = self::parsePluralTernary($tokens, $position, $expression);
			if (($tokens[$position] ?? null) !== ')') {
				throw new RuntimeException('Missing `)` in plural expression `' . $expression . '`');
			}
			$position++;
			return $node;
		}

		throw new RuntimeException('Unexpected token `' . $token . '` in plural expression `' . $expression . '`');
	}

	/**
	 * @param array<string,mixed> $node
	 */
	private static function evaluatePluralExpression(array $node, int $value): int {
		switch ($node['type'] ?? null) {
			case 'number':
				return is_int($node['value'] ?? null) ? $node['value'] : 0;
			case 'variable':
				return $value;
			case 'unary':
				$operand = self::evaluatePluralExpression(self::childPluralNode($node, 'operand'), $value);
				return ($node['operator'] ?? '') === '!' ? ($operand === 0 ? 1 : 0) : -$operand;
			case 'ternary':
				$condition = self::evaluatePluralExpression(self::childPluralNode($node, 'condition'), $value);
				return self::evaluatePluralExpression(self::childPluralNode($node, $condition !== 0 ? 'if_true' : 'if_false'), $value);
			case 'binary':
				$left = self::evaluatePluralExpression(self::childPluralNode($node, 'left'), $value);
				$right = self::evaluatePluralExpression(self::childPluralNode($node, 'right'), $value);
				return match ($node['operator'] ?? '') {
					'||' => $left !== 0 || $right !== 0 ? 1 : 0,
					'&&' => $left !== 0 && $right !== 0 ? 1 : 0,
					'==' => $left === $right ? 1 : 0,
					'!=' => $left !== $right ? 1 : 0,
					'<' => $left < $right ? 1 : 0,
					'<=' => $left <= $right ? 1 : 0,
					'>' => $left > $right ? 1 : 0,
					'>=' => $left >= $right ? 1 : 0,
					'+' => $left + $right,
					'-' => $left - $right,
					'*' => $left * $right,
					'/' => $right === 0 ? 0 : intdiv($left, $right),
					'%' => $right === 0 ? 0 : $left % $right,
					default => 0,
				};
			default:
				return 0;
		}
	}

	private static function pluralIndex(int $value): ?int {
		if (!self::loadPluralRule() || self::$plural_count === null || self::$plural_expression_tree === null) {
			return null;
		}

		$index = self::evaluatePluralExpression(self::$plural_expression_tree, $value);
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
