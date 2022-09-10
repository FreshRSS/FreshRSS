<?php

require_once __DIR__ . '/I18nValidatorInterface.php';

class I18nUsageValidator implements I18nValidatorInterface {

	private $code;
	private $reference;
	private $totalEntries = 0;
	private $failedEntries = 0;
	private $result = '';

	public function __construct($reference, $code) {
		$this->code = $code;
		$this->reference = $reference;
	}

	public function displayReport() {
		return sprintf('%5.1f%% of translation keys are unused.', $this->failedEntries / $this->totalEntries * 100) . PHP_EOL;
	}

	public function displayResult() {
		return $this->result;
	}

	public function validate() {
		foreach ($this->reference as $file => $data) {
			foreach ($data as $key => $value) {
				$this->totalEntries++;
				if (preg_match('/\._$/', $key) && in_array(preg_replace('/\._$/', '', $key), $this->code)) {
					continue;
				}
				if (!in_array($key, $this->code)) {
					$this->result .= sprintf('Unused key %s - %s', $key, $value) . PHP_EOL;
					$this->failedEntries++;
					continue;
				}
			}
		}

		return 0 === $this->failedEntries;
	}

}
