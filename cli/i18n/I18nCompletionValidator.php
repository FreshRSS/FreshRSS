<?php

require_once __DIR__ . '/I18nValidatorInterface.php';

class I18nCompletionValidator implements I18nValidatorInterface {

	/** @var array<string,array<string,I18nValue>> */
	private $reference;
	/** @var array<string,array<string,I18nValue>> */
	private $language;
	/** @var int */
	private $totalEntries = 0;
	/** @var int */
	private $passEntries = 0;
	/** @var string */
	private $result = '';

	/**
	 * @param array<string,array<string,I18nValue>> $reference
	 * @param array<string,array<string,I18nValue>> $language
	 */
	public function __construct(array $reference, array $language) {
		$this->reference = $reference;
		$this->language = $language;
	}

	public function displayReport(): string {
		if ($this->passEntries > $this->totalEntries) {
			throw new \RuntimeException('The number of translated strings cannot be higher than the number of strings');
		}
		if ($this->totalEntries === 0) {
			return 'There is no data.' . PHP_EOL;
		}
		return sprintf('Translation is %5.1f%% complete.', $this->passEntries / $this->totalEntries * 100) . PHP_EOL;
	}

	public function displayResult(): string {
		return $this->result;
	}

	public function validate(): bool {
		foreach ($this->reference as $file => $data) {
			foreach ($data as $refKey => $refValue) {
				$this->totalEntries++;
				if (!array_key_exists($file, $this->language) || !array_key_exists($refKey, $this->language[$file])) {
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
