<?php

class I18nData {

	const REFERENCE_LANGUAGE = 'en';

	private $data = array();
	private $ignore = array();

	public function __construct($data, $ignore) {
		$this->data = $data;
		$this->ignore = $ignore;

		$this->synchonizeKeys();
	}

	public function getData() {
		$output = array();
		$reference = $this->getReferenceLanguage();
		$languages = $this->getNonReferenceLanguages();

		foreach ($reference as $file => $values) {
			foreach ($values as $key => $value) {
				$output[static::REFERENCE_LANGUAGE][$file][$key] = $value;
				foreach ($languages as $language) {
					if ($this->data[$language][$file][$key] !== $value) {
						// This value is translated, there is no need to flag it.
						$output[$language][$file][$key] = $this->data[$language][$file][$key];
					} elseif (array_key_exists($language, $this->ignore) && in_array($key, $this->ignore[$language])) {
						// This value is ignored, there is no need to flag it.
						$output[$language][$file][$key] = $this->data[$language][$file][$key];
					} else {
						// This value is not translated nor ignored, it must be flagged.
						$output[$language][$file][$key] = "{$value} -> todo";
					}
				}
			}
		}

		return $output;
	}

	public function getIgnore() {
		$ignore = array();

		foreach ($this->ignore as $language => $keys) {
			sort($keys);
			$ignore[$language] = $keys;
		}

		return $ignore;
	}

	private function synchonizeKeys() {
		$this->addMissingKeysFromReference();
		$this->removeExtraKeysFromOtherLanguages();
		$this->removeUnknownIgnoreKeys();
	}

	private function addMissingKeysFromReference() {
		$reference = $this->getReferenceLanguage();
		$languages = $this->getNonReferenceLanguages();

		foreach ($reference as $file => $values) {
			foreach ($values as $key => $value) {
				foreach ($languages as $language) {
					if (!array_key_exists($key, $this->data[$language][$file])) {
						$this->data[$language][$file][$key] = $value;
					}
				}
			}
		}
	}

	private function removeExtraKeysFromOtherLanguages() {
		$reference = $this->getReferenceLanguage();
		foreach ($this->getNonReferenceLanguages() as $language) {
			foreach ($this->getLanguage($language) as $file => $values) {
				foreach ($values as $key => $value) {
					if (!array_key_exists($key, $reference[$file])) {
						unset($this->data[$language][$file][$key]);
					}
				}
			}
		}
	}

	private function removeUnknownIgnoreKeys() {
		$reference = $this->getReferenceLanguage();
		foreach ($this->ignore as $language => $keys) {
			foreach ($keys as $index => $key) {
				if (!array_key_exists($this->getFilenamePrefix($key), $reference) || !array_key_exists($key, $reference[$this->getFilenamePrefix($key)])) {
					unset($this->ignore[$language][$index]);
				}
			}
		}
	}

	/**
	 * Return the available languages
	 *
	 * @return array
	 */
	public function getAvailableLanguages() {
		$languages = array_keys($this->data);
		sort($languages);

		return $languages;
	}

	/**
	 * Return all available languages without the reference language
	 *
	 * @return array
	 */
	public function getNonReferenceLanguages() {
		return array_filter(array_keys($this->data), function ($value) {
			return static::REFERENCE_LANGUAGE !== $value;
		});
	}

	/**
	 * Add a new language. It's a copy of the reference language.
	 *
	 * @param string $language
	 * @param string $reference
	 * @throws Exception
	 */
	public function addLanguage($language, $reference = null) {
		if (array_key_exists($language, $this->data)) {
			throw new Exception('The selected language already exist.');
		}
		if (!is_string($reference) && !array_key_exists($reference, $this->data)) {
			$reference = static::REFERENCE_LANGUAGE;
		}
		$this->data[$language] = $this->data[$reference];
	}

	/**
	 * Check if the key is known.
	 *
	 * @param string $key
	 * @return bool
	 */
	public function isKnown($key) {
		return array_key_exists($this->getFilenamePrefix($key), $this->data[static::REFERENCE_LANGUAGE]) &&
			array_key_exists($key, $this->data[static::REFERENCE_LANGUAGE][$this->getFilenamePrefix($key)]);
	}

	/**
	 * Return the parent key for a specified key.
	 * To get the parent key, you need to remove the last section of the key. Each
	 * is separated into sections. The parent of a section is the concatenation of
	 * all sections before the selected key. For instance, if the key is 'a.b.c.d.e',
	 * the parent key is 'a.b.c.d'.
	 *
	 * @return string
	 */
	private function getParentKey($key) {
		return substr($key, 0, strrpos($key, '.'));
	}

	/**
	 * Return the siblings for a specified key.
	 * To get the siblings, we need to find all matches with the parent.
	 */
	private function getSiblings($key) {
		if (!array_key_exists($this->getFilenamePrefix($key), $this->data[static::REFERENCE_LANGUAGE])) {
			return [];
		}

		$keys = array_keys($this->data[static::REFERENCE_LANGUAGE][$this->getFilenamePrefix($key)]);
		$parent = $this->getParentKey($key);

		return array_values(array_filter($keys, function ($element) use ($parent) {
			return false !== strpos($element, $parent);
		}));
	}

	/**
	 * Check if the key is an only child.
	 * To be an only child, there must be only one sibling and that sibling must
	 * be the empty sibling. The empty sibling is the parent.
	 *
	 * @return bool
	 */
	private function isOnlyChild($key) {
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
	private function getEmptySibling($key) {
		return "{$key}._";
	}

	/**
	 * Add a new key to all languages.
	 *
	 * @param string $key
	 * @param string $value
	 * @throws Exception
	 */
	public function addKey($key, $value) {
		if ($this->isKnown($key)) {
			throw new Exception('The selected key already exist.');
		}

		$parentKey = $this->getParentKey($key);
		if ($this->isKnown($parentKey)) {
			// The parent key exists, that means that we need to convert it to an array.
			// To create an array, we need to change the key by appending an empty section.
			foreach ($this->getAvailableLanguages() as $language) {
				$parentValue = $this->data[$language][$this->getFilenamePrefix($parentKey)][$parentKey];
				$this->data[$language][$this->getFilenamePrefix($this->getEmptySibling($parentKey))][$this->getEmptySibling($parentKey)] = $parentValue;
			}
		}

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
	 * Add a value for a key for the selected language.
	 *
	 * @param string $key
	 * @param string $value
	 * @param string $language
	 * @throws Exception
	 */
	public function addValue($key, $value, $language) {
		if (!in_array($language, $this->getAvailableLanguages())) {
			throw new Exception('The selected language does not exist.');
		}
		if (!array_key_exists($this->getFilenamePrefix($key), $this->data[static::REFERENCE_LANGUAGE]) ||
			!array_key_exists($key, $this->data[static::REFERENCE_LANGUAGE][$this->getFilenamePrefix($key)])) {
			throw new Exception('The selected key does not exist for the selected language.');
		}
		if (static::REFERENCE_LANGUAGE === $language) {
			$previousValue = $this->data[static::REFERENCE_LANGUAGE][$this->getFilenamePrefix($key)][$key];
			foreach ($this->getAvailableLanguages() as $lang) {
				if ($this->data[$lang][$this->getFilenamePrefix($key)][$key] === $previousValue) {
					$this->data[$lang][$this->getFilenamePrefix($key)][$key] = $value;
				}
			}
		} else {
			$this->data[$language][$this->getFilenamePrefix($key)][$key] = $value;
		}
	}

	/**
	 * Remove a key in all languages
	 *
	 * @param string $key
	 * @throws Exception
	 */
	public function removeKey($key) {
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
			if (array_key_exists($language, $this->ignore) && $position = array_search($key, $this->ignore[$language])) {
				unset($this->ignore[$language][$position]);
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
	 * Ignore a key from a language, or reverse it.
	 *
	 * @param string $key
	 * @param string $language
	 * @param boolean $reverse
	 */
	public function ignore($key, $language, $reverse = false) {
		if (!array_key_exists($language, $this->ignore)) {
			$this->ignore[$language] = array();
		}

		$index = array_search($key, $this->ignore[$language]);
		if (false !== $index && $reverse) {
			unset($this->ignore[$language][$index]);
			return;
		}
		if (false !== $index && !$reverse) {
			return;
		}

		$this->ignore[$language][] = $key;
	}

	/**
	 *Ignore all unmodified keys from a language, or reverse it.
	 *
	 * @param string $language
	 * @param boolean $reverse
	 */
	public function ignore_unmodified($language, $reverse = false) {
		$my_language = $this->getLanguage($language);
		foreach ($this->getReferenceLanguage() as $file => $ref_language) {
			foreach ($ref_language as $key => $ref_value) {
				if (array_key_exists($key, $my_language[$file])) {
					if($ref_value == $my_language[$file][$key]) {
						$this->ignore($key, $language, $reverse);
					}
				}
			}
		}
	}

	public function getLanguage($language) {
		return $this->data[$language];
	}

	public function getReferenceLanguage() {
		return $this->getLanguage(static::REFERENCE_LANGUAGE);
	}

	/**
	 * @param string $key
	 * @return string
	 */
	private function getFilenamePrefix($key) {
		return preg_replace('/\..*/', '.php', $key);
	}

}
