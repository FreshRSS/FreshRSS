<?php

class I18nData {

	const REFERENCE_LANGUAGE = 'en';

	private $data = array();
	private $originalData = array();

	public function __construct($data) {
		$this->data = $data;
		$this->originalData = $data;
	}

	public function getData() {
		return $this->data;
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
	 * Add a new language. It's a copy of the reference language.
	 *
	 * @param string $language
	 */
	public function addLanguage($language) {
		if (array_key_exists($language, $this->data)) {
			throw new Exception('The selected language already exist.');
		}
		$this->data[$language] = $this->data[static::REFERENCE_LANGUAGE];
	}

	/**
	 * Add a key in the reference language
	 *
	 * @param string $key
	 * @param string $value
	 */
	public function addKey($key, $value) {
		if (array_key_exists($key, $this->data[static::REFERENCE_LANGUAGE][$this->getFilenamePrefix($key)])) {
			throw new Exception('The selected key already exist.');
		}
		$this->data[static::REFERENCE_LANGUAGE][$this->getFilenamePrefix($key)][$key] = $value;
	}

	/**
	 * Duplicate a key from the reference language to all other languages
	 *
	 * @param string $key
	 */
	public function duplicateKey($key) {
		if (!array_key_exists($key, $this->data[static::REFERENCE_LANGUAGE][$this->getFilenamePrefix($key)])) {
			throw new Exception('The selected key does not exist.');
		}
		$value = $this->data[static::REFERENCE_LANGUAGE][$this->getFilenamePrefix($key)][$key];
		foreach ($this->getAvailableLanguages() as $language) {
			if (static::REFERENCE_LANGUAGE === $language) {
				continue;
			}
			if (array_key_exists($key, $this->data[$language][$this->getFilenamePrefix($key)])) {
				throw new Exception(sprintf('The selected key already exist in %s.', $language));
			}
			$this->data[$language][$this->getFilenamePrefix($key)][$key] = $value;
		}
	}

	/**
	 * Remove a key in all languages
	 *
	 * @param string $key
	 */
	public function removeKey($key) {
		if (!array_key_exists($key, $this->data[static::REFERENCE_LANGUAGE][$this->getFilenamePrefix($key)])) {
			throw new Exception('The selected key does not exist.');
		}
		foreach ($this->getAvailableLanguages() as $language) {
			if (array_key_exists($key, $this->data[$language][$this->getFilenamePrefix($key)])) {
				unset($this->data[$language][$this->getFilenamePrefix($key)][$key]);
			}
		}
	}

	/**
	 * Check if the data has changed
	 *
	 * @return bool
	 */
	public function hasChanged() {
		return $this->data !== $this->originalData;
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
