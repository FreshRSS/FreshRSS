<?php

require_once __DIR__ . '/I18nValidatorInterface.php';

class I18nCompletionValidator implements I18nValidatorInterface {

	private $reference;
	private $language;
	private $totalEntries = 0;
	private $passEntries = 0;
	private $result = '';

	public function __construct($reference, $language) {
		$this->reference = $reference;
		$this->language = $language;
	}

	public function displayReport() {
		return sprintf('Translation is %5.1f%% complete.', $this->passEntries / $this->totalEntries * 100) . PHP_EOL;
	}

	public function displayResult() {
		return $this->result;
	}

	/**
	 * @param array<string>|null $ignore
	 */
	public function validate($ignore) {
		foreach ($this->reference as $file => $data) {
			foreach ($data as $key => $value) {
				$this->totalEntries++;
				if (is_array($ignore) && in_array($key, $ignore)) {
					$this->passEntries++;
					continue;
				}
				if (!array_key_exists($key, $this->language[$file])) {
					$this->result .= sprintf('Missing key %s', $key) . PHP_EOL;
					continue;
				}
				if ($value === $this->language[$file][$key]) {
					$this->result .= sprintf('Untranslated key %s - %s', $key, $value) . PHP_EOL;
					continue;
				}
				$this->passEntries++;
			}
		}

		return $this->totalEntries === $this->passEntries;
	}

}
