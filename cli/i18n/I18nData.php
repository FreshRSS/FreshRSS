<?php
declare(strict_types=1);

class I18nData {

	/** @var string */
	public const REFERENCE_LANGUAGE = 'en';

	/** @param array<string,array<string,array<string,I18nValue>>> $data */
	public function __construct(private array $data) {
		$this->addMissingKeysFromReference();
		$this->addMissingPluralVariantsFromReference();
		$this->removeExtraKeysFromOtherLanguages();
		$this->processValueStates();
	}

	private static function isPluralVariantKey(string $key): bool {
		return self::parsePluralVariantKey($key) !== null;
	}

	/**
	 * @return array{base:string,index:int}|null
	 */
	private static function parsePluralVariantKey(string $key): ?array {
		if (preg_match('/^(?P<base>.+)\.(?P<index>\d+)$/', $key, $matches) !== 1) {
			return null;
		}

		return [
			'base' => $matches['base'],
			'index' => (int)$matches['index'],
		];
	}

	/**
	 * @return array<string,array<string,array<string,I18nValue>>>
	 */
	public function getData(): array {
		return $this->data;
	}

	private function addMissingKeysFromReference(): void {
		$reference = $this->getReferenceLanguage();
		$languages = $this->getNonReferenceLanguages();

		foreach ($reference as $file => $refValues) {
			foreach ($refValues as $key => $refValue) {
				if (self::isPluralVariantKey($key)) {
					continue;
				}
				foreach ($languages as $language) {
					if (!array_key_exists($file, $this->data[$language]) || !array_key_exists($key, $this->data[$language][$file])) {
						$this->data[$language][$file][$key] = clone $refValue;
					}
					$value = $this->data[$language][$file][$key];
					if ($refValue->equal($value) && !$value->isIgnore()) {
						$value->markAsTodo();
					}
				}
			}
		}
	}

	private function addMissingPluralVariantsFromReference(): void {
		$reference = $this->getReferenceLanguage();

		foreach ($this->getNonReferenceLanguages() as $language) {
			$expectedIndexes = $this->pluralVariantIndexesForLanguage($language);
			foreach ($reference as $file => $refValues) {
				$pluralBases = [];
				foreach ($refValues as $key => $refValue) {
					$parsedKey = self::parsePluralVariantKey($key);
					if ($parsedKey === null) {
						continue;
					}
					$pluralBases[$parsedKey['base']] = true;
				}

				if (!array_key_exists($file, $this->data[$language])) {
					$this->data[$language][$file] = [];
				}

				foreach (array_keys($pluralBases) as $pluralBase) {
					foreach ($expectedIndexes as $index) {
						$pluralKey = $pluralBase . '.' . $index;
						if (array_key_exists($pluralKey, $this->data[$language][$file])) {
							continue;
						}

						$referenceValue = $this->referenceValueForKey($refValues, $pluralKey);
						if ($referenceValue === null) {
							continue;
						}

						$this->data[$language][$file][$pluralKey] = clone $referenceValue;
					}
				}
			}
		}
	}

	private function removeExtraKeysFromOtherLanguages(): void {
		$reference = $this->getReferenceLanguage();
		foreach ($this->getNonReferenceLanguages() as $language) {
			foreach ($this->getLanguage($language) as $file => $values) {
				foreach ($values as $key => $value) {
					if (self::isPluralVariantKey($key)) {
						continue;
					}
					if (!array_key_exists($key, $reference[$file])) {
						unset($this->data[$language][$file][$key]);
					}
				}
			}
		}
	}

	private function processValueStates(): void {
		$reference = $this->getReferenceLanguage();
		$languages = $this->getNonReferenceLanguages();

		foreach ($reference as $file => $refValues) {
			foreach ($refValues as $key => $refValue) {
				foreach ($languages as $language) {
					if (!$this->pluralVariantAppliesToLanguage($language, $key)) {
						continue;
					}

					$value = $this->data[$language][$file][$key];
					$this->syncValueState($refValue, $value);
				}
			}
		}

		foreach ($languages as $language) {
			foreach ($this->getLanguage($language) as $file => $values) {
				$referenceValues = $reference[$file] ?? [];
				foreach ($values as $key => $value) {
					if (!self::isPluralVariantKey($key) || array_key_exists($key, $referenceValues)) {
						continue;
					}

					$referenceValue = $this->referenceValueForKey($referenceValues, $key);
					if ($referenceValue === null) {
						continue;
					}

					$this->syncValueState($referenceValue, $value);
				}
			}
		}
	}

	private function syncValueState(I18nValue $referenceValue, I18nValue $value): void {
		if ($referenceValue->equal($value) && !$value->isIgnore()) {
			$value->markAsTodo();
			return;
		}

		if (!$referenceValue->equal($value) && $value->isTodo()) {
			$value->markAsDirty();
		}
	}

	private function pluralVariantAppliesToLanguage(string $language, string $key): bool {
		$parsedKey = self::parsePluralVariantKey($key);
		if ($parsedKey === null) {
			return true;
		}

		return in_array($parsedKey['index'], $this->pluralVariantIndexesForLanguage($language), true);
	}

	/**
	 * @param array<string,I18nValue> $referenceValues
	 */
	private function referenceValueForKey(array $referenceValues, string $key): ?I18nValue {
		if (array_key_exists($key, $referenceValues)) {
			return $referenceValues[$key];
		}

		$parsedKey = self::parsePluralVariantKey($key);
		if ($parsedKey === null) {
			return null;
		}

		$pluralKey = $parsedKey['base'] . '.1';
		if (array_key_exists($pluralKey, $referenceValues)) {
			return $referenceValues[$pluralKey];
		}

		$singularKey = $parsedKey['base'] . '.0';
		return $referenceValues[$singularKey] ?? null;
	}

	/**
	 * @return list<int>
	 */
	private function pluralVariantIndexesForLanguage(string $language): array {
		$pluralCount = $this->pluralCountForLanguage($language);
		if ($pluralCount !== null) {
			return range(0, $pluralCount - 1);
		}

		$indexes = [];
		foreach ($this->data[$language] as $values) {
			foreach (array_keys($values) as $key) {
				$parsedKey = self::parsePluralVariantKey($key);
				if ($parsedKey === null) {
					continue;
				}
				$indexes[$parsedKey['index']] = true;
			}
		}

		if ($indexes === []) {
			return [0];
		}

		ksort($indexes, SORT_NUMERIC);
		return array_map('intval', array_keys($indexes));
	}

	private function pluralCountForLanguage(string $language): ?int {
		if (!defined('I18N_PATH')) {
			return null;
		}

		$pluralFile = I18N_PATH . '/' . $language . '/plurals.php';
		if (!is_file($pluralFile)) {
			return null;
		}

		$pluralData = include $pluralFile;
		$pluralCount = is_array($pluralData) ? ($pluralData['nplurals'] ?? null) : null;
		return is_int($pluralCount) && $pluralCount > 0 ? $pluralCount : null;
	}

	/**
	 * Return the available languages
	 * @return list<string>
	 */
	public function getAvailableLanguages(): array {
		$languages = array_keys($this->data);
		sort($languages);
		return $languages;
	}

	/**
	 * Return all available languages without the reference language
	 * @return list<string>
	 */
	private function getNonReferenceLanguages(): array {
		return array_values(array_filter(array_keys($this->data),
			static fn(string $value) => static::REFERENCE_LANGUAGE !== $value));
	}

	/**
	 * Add a new language. It’s a copy of the reference language.
	 * @throws Exception
	 */
	public function addLanguage(string $language, ?string $reference = null): void {
		if (array_key_exists($language, $this->data)) {
			throw new Exception('The selected language already exists.');
		}
		if (!is_string($reference) || !array_key_exists($reference, $this->data)) {
			$reference = static::REFERENCE_LANGUAGE;
		}
		$this->data[$language] = $this->data[$reference];
	}

	/**
	 * Check if the key is known.
	 */
	public function isKnown(string $key): bool {
		return $this->exists($key) &&
			array_key_exists($key, $this->data[static::REFERENCE_LANGUAGE][$this->getFilenamePrefix($key)]);
	}

	/**
	 * Check if the file exists
	 */
	public function exists(string $file): bool {
		return array_key_exists($this->getFilenamePrefix($file), $this->data[static::REFERENCE_LANGUAGE]);
	}

	/**
	 * Return the parent key for a specified key.
	 * To get the parent key, you need to remove the last section of the key. Each
	 * is separated into sections. The parent of a section is the concatenation of
	 * all sections before the selected key. For instance, if the key is 'a.b.c.d.e',
	 * the parent key is 'a.b.c.d'.
	 */
	private function getParentKey(string $key): string {
		return substr($key, 0, strrpos($key, '.') ?: null);
	}

	/**
	 * Return the siblings for a specified key.
	 * To get the siblings, we need to find all matches with the parent.
	 *
	 * @return list<string>
	 */
	private function getSiblings(string $key): array {
		if (!array_key_exists($this->getFilenamePrefix($key), $this->data[static::REFERENCE_LANGUAGE])) {
			return [];
		}

		$keys = array_keys($this->data[static::REFERENCE_LANGUAGE][$this->getFilenamePrefix($key)]);
		$parent = $this->getParentKey($key);

		return array_values(array_filter($keys, static fn(string $element) => str_contains($element, $parent)));
	}

	/**
	 * Check if the key is an only child.
	 * To be an only child, there must be only one sibling and that sibling must
	 * be the empty sibling. The empty sibling is the parent.
	 */
	private function isOnlyChild(string $key): bool {
		$siblings = $this->getSiblings($key);

		if (1 !== count($siblings)) {
			return false;
		}
		return '_' === $siblings[0][-1];
	}

	/**
	 * Return the parent key as an empty sibling.
	 * When a key has children, it cannot have its value directly. The value
	 * needs to be attached to an empty sibling represented by "_".
	 */
	private function getEmptySibling(string $key): string {
		return "{$key}._";
	}

	/**
	 * Check if a key is a parent key.
	 * To be a parent key, there must be at least one key starting with the key
	 * under test. Of course, it cannot be itself.
	 */
	private function isParent(string $key): bool {
		if (!array_key_exists($this->getFilenamePrefix($key), $this->data[static::REFERENCE_LANGUAGE])) {
			return false;
		}

		$keys = array_keys($this->data[static::REFERENCE_LANGUAGE][$this->getFilenamePrefix($key)]);
		$children = array_values(array_filter($keys, static function (string $element) use ($key) {
			if ($element === $key) {
				return false;
			}
			return str_contains($element, $key);
		}));

		return count($children) !== 0;
	}

	/**
	 * Add a new translation file to all languages
	 * @throws Exception
	 */
	public function addFile(string $file): void {
		$file = strtolower($file);
		if (!str_ends_with($file, '.php')) {
			throw new Exception('The selected file name is not supported.');
		}
		if ($this->exists($file)) {
			throw new Exception('The selected file exists already.');
		}

		foreach ($this->getAvailableLanguages() as $language) {
			$this->data[$language][$this->getFilenamePrefix($file)] = [];
		}
	}

	/**
	 * Add a new key to all languages.
	 * @throws Exception
	 */
	public function addKey(string $key, string $value): void {
		if ($this->isParent($key)) {
			$key = $this->getEmptySibling($key);
		}

		if ($this->isKnown($key)) {
			throw new Exception('The selected key already exists.');
		}

		$parentKey = $this->getParentKey($key);
		if ($this->isKnown($parentKey)) {
			// The parent key exists, that means that we need to convert it to an array.
			// To create an array, we need to change the key by appending an empty section.
			foreach ($this->getAvailableLanguages() as $language) {
				$parentValue = $this->data[$language][$this->getFilenamePrefix($parentKey)][$parentKey];
				$this->data[$language][$this->getFilenamePrefix($this->getEmptySibling($parentKey))][$this->getEmptySibling($parentKey)] =
					new I18nValue($parentValue);
			}
		}

		$value = new I18nValue($value);
		$value->markAsTodo();
		foreach ($this->getAvailableLanguages() as $language) {
			if (!array_key_exists($key, $this->data[$language][$this->getFilenamePrefix($key)])) {
				$this->data[$language][$this->getFilenamePrefix($key)][$key] = $value;
			}
		}

		if ($this->isKnown($parentKey)) {
			$this->removeKey($parentKey);
		}
	}

	/**
	 * Move an existing key into a new location
	 * @throws Exception
	 */
	public function moveKey(string $key, string $newKey): void {
		if (!$this->isKnown($key) && !$this->isKnown($this->getEmptySibling($key))) {
			throw new Exception('The selected key does not exist');
		}
		if ($this->isKnown($newKey)) {
			throw new Exception('Cannot move key to a location that already exists.');
		}

		$keyPrefix = $this->isParent($key) ? $key . '.' : $key;
		foreach ($this->getAvailableLanguages() as $language) {
			foreach ($this->data[$language][$this->getFilenamePrefix($key)] as $k => $v) {
				if (str_starts_with($k, $keyPrefix)) {
					$this->data[$language][$this->getFilenamePrefix($newKey)][str_replace($key, $newKey, $k)] = $v;
					unset($this->data[$language][$this->getFilenamePrefix($key)][$k]);
				}
			}
		}
	}

	/**
	 * Add a value for a key for the selected language.
	 *
	 * @throws Exception
	 */
	public function addValue(string $key, string $value, string $language): void {
		if (!in_array($language, $this->getAvailableLanguages(), true)) {
			throw new Exception('The selected language does not exist.');
		}
		if (!array_key_exists($this->getFilenamePrefix($key), $this->data[static::REFERENCE_LANGUAGE]) ||
			!array_key_exists($key, $this->data[static::REFERENCE_LANGUAGE][$this->getFilenamePrefix($key)])) {
			throw new Exception('The selected key does not exist for the selected language.');
		}

		$value = new I18nValue($value);
		if (static::REFERENCE_LANGUAGE === $language) {
			$previousValue = $this->data[static::REFERENCE_LANGUAGE][$this->getFilenamePrefix($key)][$key];
			foreach ($this->getAvailableLanguages() as $lang) {
				$currentValue = $this->data[$lang][$this->getFilenamePrefix($key)][$key];
				if ($currentValue->equal($previousValue)) {
					$this->data[$lang][$this->getFilenamePrefix($key)][$key] = $value;
				}
			}
		} else {
			$this->data[$language][$this->getFilenamePrefix($key)][$key] = $value;
		}
	}

	/**
	 * Remove a key in all languages
	 */
	public function removeKey(string $key): void {
		if (!$this->isKnown($key) && !$this->isKnown($this->getEmptySibling($key))) {
			throw new Exception('The selected key does not exist.');
		}
		if (!$this->isKnown($key)) {
			// The key has children, it needs to be appended with an empty section.
			$key = $this->getEmptySibling($key);
		}

		foreach ($this->getAvailableLanguages() as $language) {
			if (array_key_exists($key, $this->data[$language][$this->getFilenamePrefix($key)])) {
				unset($this->data[$language][$this->getFilenamePrefix($key)][$key]);
			}
		}

		if ($this->isOnlyChild($key)) {
			$parentKey = $this->getParentKey($key);
			foreach ($this->getAvailableLanguages() as $language) {
				$parentValue = $this->data[$language][$this->getFilenamePrefix($this->getEmptySibling($parentKey))][$this->getEmptySibling($parentKey)];
				$this->data[$language][$this->getFilenamePrefix($parentKey)][$parentKey] = $parentValue;
			}
			$this->removeKey($this->getEmptySibling($parentKey));
		}
	}

	/**
	 * Ignore a key from a language, or revert an existing ignore on a key.
	 */
	public function ignore(string $key, string $language, bool $revert = false): void {
		$value = $this->data[$language][$this->getFilenamePrefix($key)][$key];
		if ($revert) {
			$value->unmarkAsIgnore();
		} else {
			$value->markAsIgnore();
		}
	}

	/**
	 * Ignore all unmodified keys from a language, or revert all existing ignores on unmodified keys.
	 */
	public function ignore_unmodified(string $language, bool $revert = false): void {
		$my_language = $this->getLanguage($language);
		foreach ($this->getReferenceLanguage() as $file => $ref_language) {
			foreach ($ref_language as $key => $ref_value) {
				if (array_key_exists($key, $my_language[$file])) {
					if ($ref_value->equal($my_language[$file][$key])) {
						$this->ignore($key, $language, $revert);
					}
				}
			}
		}
	}

	/**
	 * @return array<string,array<string,I18nValue>>
	 */
	public function getLanguage(string $language): array {
		return $this->data[$language];
	}

	/**
	 * @return array<string,array<string,I18nValue>>
	 */
	public function getReferenceLanguage(): array {
		return $this->getLanguage(static::REFERENCE_LANGUAGE);
	}

	private function getFilenamePrefix(string $key): string {
		return preg_replace('/\..*/', '.php', $key) ?? '';
	}

}
