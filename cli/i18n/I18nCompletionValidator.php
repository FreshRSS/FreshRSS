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

	public function validate() {
		foreach ($this->reference as $file => $data) {
			foreach ($data as $refKey => $refValue) {
				$this->totalEntries++;
				if (!array_key_exists($refKey, $this->language[$file])) {
					$this->result .= "Missing key $refKey" . PHP_EOL;
					continue;
				}

				$value = $this->language[$file][$refKey];
				if ($value->isIgnore()) {
					$this->passEntries++;
					continue;
				}
				if ($refValue->equal($value)) {
					$this->result .= "Untranslated key $refKey - $refValue" . PHP_EOL;
					continue;
				}
				$this->passEntries++;
			}
		}

		return $this->totalEntries === $this->passEntries;
	}

}
