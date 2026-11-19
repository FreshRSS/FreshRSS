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
	public function attributes(): array {
		return $this->attributes;
	}

	/** @param non-empty-string $key */
	public function hasAttribute(string $key): bool {
		return isset($this->attributes[$key]);
	}

	/**
	 * @param non-empty-string $key
	 * @return array<int|string,mixed>|null
	 */
	public function attributeArray(string $key): ?array {
		$a = $this->attributes[$key] ?? null;
		return is_array($a) ? $a : null;
	}

	/** @param non-empty-string $key */
	public function attributeBoolean(string $key): ?bool {
		$a = $this->attributes[$key] ?? null;
		return is_bool($a) ? $a : null;
	}

	/** @param non-empty-string $key */
	public function attributeInt(string $key): ?int {
		$a = $this->attributes[$key] ?? null;
		return is_int($a) ? $a : null;
	}

	/** @param non-empty-string $key */
	public function attributeString(string $key): ?string {
		$a = $this->attributes[$key] ?? null;
		return is_string($a) ? $a : null;
	}

	/** @param string|array<string,mixed> $values Values, not HTML-encoded */
	public function _attributes(string|array $values): void {
		if (is_string($values)) {
			$values = json_decode($values, true);
		}
		if (is_array($values)) {
			$values = array_filter($values, 'is_string', ARRAY_FILTER_USE_KEY);
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
