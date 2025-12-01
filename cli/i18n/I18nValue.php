<?php
declare(strict_types=1);

class I18nValue implements \Stringable {
	private const STATE_DIRTY = 'dirty';
	public const STATE_IGNORE = 'ignore';
	private const STATE_TODO = 'todo';
	private const STATES = [
		self::STATE_DIRTY,
		self::STATE_IGNORE,
		self::STATE_TODO,
	];

	private readonly string $value;
	private ?string $state = null;

	/** @param I18nValue|string $data */
	public function __construct(I18nValue|string $data) {
		if ($data instanceof I18nValue) {
			$data = $data->__toString();
		}
		$data = explode(' -> ', $data);

		$this->value = (string)(array_shift($data) ?? '');
		if (count($data) === 0) {
			return;
		}

		$state = array_shift($data);
		if (in_array($state, self::STATES, true)) {
			$this->state = $state;
		}
	}

	public function __clone(): void {
		$this->markAsTodo();
	}

	public function equal(I18nValue $value): bool {
		return $this->value === $value->getValue();
	}

	public function isIgnore(): bool {
		return $this->state === self::STATE_IGNORE;
	}

	public function isTodo(): bool {
		return $this->state === self::STATE_TODO;
	}

	public function markAsDirty(): void {
		$this->state = self::STATE_DIRTY;
	}

	public function markAsIgnore(): void {
		$this->state = self::STATE_IGNORE;
	}

	public function markAsTodo(): void {
		$this->state = self::STATE_TODO;
	}

	public function unmarkAsIgnore(): void {
		if ($this->state === self::STATE_IGNORE) {
			$this->state = null;
		}
	}

	#[\Override]
	public function __toString(): string {
		if ($this->state === null) {
			return $this->value;
		}

		return "{$this->value} -> {$this->state}";
	}

	public function getValue(): string {
		return $this->value;
	}
}
