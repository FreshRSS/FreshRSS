<?php

class FreshRSS_Tag extends Minz_Model {

	private int $id = 0;
	private string $name;
	/**
	 * @var array<string,mixed>
	 */
	private array $attributes = [];
	private int $nbEntries = -1;
	private int $nbUnread = -1;

	public function __construct(string $name = '') {
		$this->_name($name);
	}

	public function id(): int {
		return $this->id;
	}

	/**
	 * @param int|string $value
	 */
	public function _id($value): void {
		$this->id = (int)$value;
	}

	public function name(): string {
		return $this->name;
	}

	public function _name(string $value): void {
		$this->name = trim($value);
	}

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

	public function nbEntries(): int {
		if ($this->nbEntries < 0) {
			$tagDAO = FreshRSS_Factory::createTagDao();
			$this->nbEntries = $tagDAO->countEntries($this->id()) ?: 0;
		}
		return $this->nbEntries;
	}

	/**
	 * @param string|int $value
	 */
	public function _nbEntries($value): void {
		$this->nbEntries = (int)$value;
	}

	public function nbUnread(): int {
		if ($this->nbUnread < 0) {
			$tagDAO = FreshRSS_Factory::createTagDao();
			$this->nbUnread = $tagDAO->countNotRead($this->id()) ?: 0;
		}
		return $this->nbUnread;
	}

	/**
	 * @param string|int $value
	 */
	public function _nbUnread($value): void {
		$this->nbUnread = (int)$value;
	}
}
