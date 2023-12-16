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

	/** @return array<string,mixed> */
	public function attributes() {
		return $this->attributes;
	}

	/**
	 * @param non-empty-string $key
	 * @return array<string,mixed>|mixed|null
	 */
	public function attribute(string $key) {
		return $this->attributes[$key] ?? null;
	}

	/** @param non-empty-string $key */
	public function attributeString(string $key): string {
		$s = $this->attributes[$key] ?? null;
		return is_string($s) ? $s : '';
	}

	/** @param string|array<string,mixed> $values Values, not HTML-encoded */
	public function _attributes($values): void {
		if (is_string($values)) {
			$values = json_decode($values, true);
		}
		if (is_array($values)) {
			$this->attributes = $values;
		}
	}

	/**
	 * @param non-empty-string $key
	 * @param array<string,mixed>|mixed|null $value Value, not HTML-encoded
	 */
	public function _attribute(string $key, $value = null): void {
		if ($value === null) {
			unset($this->attributes[$key]);
		} else {
			$this->attributes[$key] = $value;
		}
	}
}
