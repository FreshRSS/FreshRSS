<?php

require_once __DIR__ . '/I18nValidatorInterface.php';

class I18nUsageValidator implements I18nValidatorInterface {

	/** @var array<string> */
	private $code;
	/** @var array<string,array<string,string>> */
	private $reference;
	/** @var int */
	private $totalEntries = 0;
	/** @var int */
	private $failedEntries = 0;
	/** @var string */
	private $result = '';

	/**
	 * @param array<string,array<string,string>> $reference
	 * @param array<string> $code
	 */
	public function __construct(array $reference, array $code) {
		$this->code = $code;
		$this->reference = $reference;
	}

	public function displayReport(): string {
		if ($this->failedEntries > $this->totalEntries) {
			throw new \RuntimeException('The number of unused strings cannot be higher than the number of strings');
		}
		if ($this->totalEntries === 0) {
			return 'There is no data.' . PHP_EOL;
		}
		return sprintf('%5.1f%% of translation keys are unused.', $this->failedEntries / $this->totalEntries * 100) . PHP_EOL;
	}

	public function displayResult(): string {
		return $this->result;
	}

	public function validate(): bool {
		foreach ($this->reference as $file => $data) {
			foreach ($data as $key => $value) {
				$this->totalEntries++;
				if (preg_match('/\._$/', $key) === 1 && in_array(preg_replace('/\._$/', '', $key), $this->code, true)) {
					continue;
				}
				if (!in_array($key, $this->code, true)) {
					$this->result .= sprintf('Unused key %s - %s', $key, $value) . PHP_EOL;
					$this->failedEntries++;
					continue;
				}
			}
		}

		return 0 === $this->failedEntries;
	}

}
