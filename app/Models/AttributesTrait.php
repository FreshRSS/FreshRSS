<?php
declare(strict_types=1);

/**
 * Logic to work with (JSON) attributes (for entries, feeds, categories, tags...).
 */
trait FreshRSS_AttributesTrait {
	/**
	 * @var array<string,mixed>
	 */
	private array $attributes = [];

	/**
	 * @phpstan-return ($key is non-empty-string ? mixed : array<string,mixed>)
	 * @return array<string,mixed>|mixed|null
	 */
	public function attributes(string $key = '') {
		if ($key === '') {
			return $this->attributes;
		} else {
			return $this->attributes[$key] ?? null;
		}
	}

	/** @param string|array<mixed>|bool|int|null $value Value, not HTML-encoded */
	public function _attributes(string $key, $value = null): void {
		if ($key == '') {
			if (is_string($value)) {
				$value = json_decode($value, true);
			}
			if (is_array($value)) {
				$this->attributes = $value;
			}
		} elseif ($value === null) {
			unset($this->attributes[$key]);
		} else {
			$this->attributes[$key] = $value;
		}
	}
}
