<?php

class I18nValue {
	const STATE_DIRTY = 'dirty';
	const STATE_IGNORE = 'ignore';
	const STATE_TODO = 'todo';
	const STATES = [
		self::STATE_DIRTY,
		self::STATE_IGNORE,
		self::STATE_TODO,
	];

	private $value;
	private $state;

	public function __construct(string $data) {
		$data = explode(' -> ', $data);

		$this->value = array_shift($data);
		if (count($data) === 0) {
			return;
		}

		$state = array_shift($data);
		if (in_array($state, self::STATES)) {
			$this->state = $state;
		}
	}

	public function __clone() {
		$this->markAsTodo();
	}

	public function equal(I18nValue $value) {
		return $this->value === $value->getValue();
	}

	public function isIgnore() {
		return $this->state === self::STATE_IGNORE;
	}

	public function isTodo() {
		return $this->state === self::STATE_TODO;
	}

	public function markAsDirty() {
		$this->state = self::STATE_DIRTY;
	}

	public function markAsIgnore() {
		$this->state = self::STATE_IGNORE;
	}

	public function markAsTodo() {
		$this->state = self::STATE_TODO;
	}

	public function unmarkAsIgnore() {
		if ($this->state === self::STATE_IGNORE) {
			$this->state = null;
		}
	}

	public function __toString() {
		if ($this->state === null) {
			return $this->value;
		}

		return "{$this->value} -> {$this->state}";
	}

	public function getValue() {
		return $this->value;
	}
}
