<?php
declare(strict_types=1);

require_once __DIR__ . '/I18nValidatorInterface.php';

class I18nUsageValidator implements I18nValidatorInterface {

	private int $totalEntries = 0;
	private int $failedEntries = 0;
	private string $result = '';

	/**
	 * @param array<string,array<string,I18nValue>> $reference
	 * @param array<string> $code
	 * @param array<string> $codePrefixes
	 */
	public function __construct(
		private readonly array $reference,
		private readonly array $code,
		private readonly array $codePrefixes = [],
	) {
	}

	private function isUsed(string $key): bool {
		if (preg_match('/\._$/', $key) === 1 && in_array(preg_replace('/\._$/', '', $key), $this->code, true)) {
			return true;
		}

		if (in_array($key, $this->code, true)) {
			return true;
		}

		foreach ($this->codePrefixes as $prefix) {
			if (str_starts_with($key, $prefix)) {
				return true;
			}
		}

		return false;
	}

	#[\Override]
	public function displayReport(bool $percentage_only = false): string {
		if ($this->failedEntries > $this->totalEntries) {
			throw new \RuntimeException('The number of unused strings cannot be higher than the number of strings');
		}
		if ($this->totalEntries === 0) {
			return 'There is no data.' . PHP_EOL;
		}
		if ($percentage_only) {
			return '100%';
		}
		return sprintf('%5.1f%% of translation keys are unused.', $this->failedEntries / $this->totalEntries * 100) . PHP_EOL;
	}

	#[\Override]
	public function displayResult(): string {
		return $this->result;
	}

	#[\Override]
	public function validate(): bool {
		foreach ($this->reference as $file => $data) {
			foreach ($data as $key => $value) {
				$this->totalEntries++;
				if (!$this->isUsed($key)) {
					$this->result .= sprintf('Unused key %s - %s', $key, $value) . PHP_EOL;
					$this->failedEntries++;
					continue;
				}
			}
		}

		return 0 === $this->failedEntries;
	}

}
