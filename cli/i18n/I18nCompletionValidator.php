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

	private static function isPluralVariantKey(string $key): bool {
		return preg_match('/\.\d+$/', $key) === 1;
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

	#[\Override]
	public function displayReport(bool $percentage_only = false): string {
		if ($this->passEntries > $this->totalEntries) {
			throw new \RuntimeException('The number of translated strings cannot be higher than the number of strings');
		}
		if ($this->totalEntries === 0) {
			return 'There is no data.' . PHP_EOL;
		}
		$percentage = sprintf('%5.1f%%', $this->passEntries / $this->totalEntries * 100);
		if ($percentage_only) {
			return trim($percentage);
		}
		return 'Translation is ' . $percentage . ' complete.' . PHP_EOL;
	}

	#[\Override]
	public function displayResult(): string {
		return $this->result;
	}

	#[\Override]
	public function validate(): bool {
		foreach ($this->reference as $file => $data) {
			foreach ($data as $refKey => $refValue) {
				if (!$this->pluralVariantAppliesToLanguage($file, $refKey)) {
					continue;
				}

				$this->totalEntries++;
				if (!array_key_exists($file, $this->language) || !array_key_exists($refKey, $this->language[$file])) {
					$this->result .= "Missing key $refKey" . PHP_EOL;
					continue;
				}

				$this->validateValue($refKey, $refValue, $this->language[$file][$refKey]);
			}
		}

		foreach ($this->language as $file => $data) {
			$referenceValues = $this->reference[$file] ?? [];
			foreach ($data as $key => $value) {
				if (!self::isPluralVariantKey($key) || array_key_exists($key, $referenceValues)) {
					continue;
				}

				$referenceValue = $this->referenceValueForKey($referenceValues, $key);
				if ($referenceValue === null) {
					continue;
				}

				$this->totalEntries++;
				$this->validateValue($key, $referenceValue, $value);
			}
		}

		return $this->totalEntries === $this->passEntries;
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

	private function validateValue(string $key, I18nValue $referenceValue, I18nValue $value): void {
		if ($value->isIgnore()) {
			$this->passEntries++;
			return;
		}

		if ($referenceValue->equal($value)) {
			$this->result .= "Untranslated key $key - $referenceValue" . PHP_EOL;
			return;
		}

		$this->passEntries++;
	}

	private function pluralVariantAppliesToLanguage(string $file, string $key): bool {
		$parsedKey = self::parsePluralVariantKey($key);
		if ($parsedKey === null) {
			return true;
		}

		$indexes = [];
		foreach ($this->language[$file] ?? [] as $languageKey => $value) {
			$parsedLanguageKey = self::parsePluralVariantKey($languageKey);
			if ($parsedLanguageKey === null || $parsedLanguageKey['base'] !== $parsedKey['base']) {
				continue;
			}

			$indexes[$parsedLanguageKey['index']] = true;
		}

		if ($indexes === []) {
			return true;
		}

		return array_key_exists($parsedKey['index'], $indexes);
	}

}
