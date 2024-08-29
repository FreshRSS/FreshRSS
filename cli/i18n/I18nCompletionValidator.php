<?php
declare(strict_types=1);

require_once __DIR__ . '/I18nValidatorInterface.php';

class I18nCompletionValidator implements I18nValidatorInterface {

	private int $totalEntries = 0;
	private int $passEntries = 0;
	private string $result = '';

	/**
	 * @param array<string,array<string,I18nValue>> $reference
	 * @param array<string,array<string,I18nValue>> $language
	 */
	public function __construct(
		private readonly array $reference,
		private array $language,
	) {
	}

	#[\Override]
	public function displayReport(): string {
		if ($this->passEntries > $this->totalEntries) {
			throw new \RuntimeException('The number of translated strings cannot be higher than the number of strings');
		}
		if ($this->totalEntries === 0) {
			return 'There is no data.' . PHP_EOL;
		}
		return sprintf('Translation is %5.1f%% complete.', $this->passEntries / $this->totalEntries * 100) . PHP_EOL;
	}

	#[\Override]
	public function displayResult(): string {
		return $this->result;
	}

	#[\Override]
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
