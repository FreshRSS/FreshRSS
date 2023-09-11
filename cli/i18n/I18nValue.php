<?php

class I18nValue {
	private const STATE_DIRTY = 'dirty';
	public const STATE_IGNORE = 'ignore';
	private const STATE_TODO = 'todo';
	private const STATES = [
		self::STATE_DIRTY,
		self::STATE_IGNORE,
		self::STATE_TODO,
	];

	/** @var string */
	private $value;
	/**	@var string|null */
	private $state;

	public function __construct(string $data) {
		$data = explode(' -> ', $data);

		$this->value = array_shift($data);
		if (count($data) === 0) {
			return;
		}

		$state = array_shift($data);
		if (in_array($state, self::STATES, true)) {
			$this->state = $state;
		}
	}

	public function __clone() {
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
