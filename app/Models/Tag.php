<?php

class FreshRSS_Tag extends Minz_Model {
	/**
	 * @var int
	 */
	private $id = 0;
	private $name;
	private $attributes = [];
	private $nbEntries = -1;
	private $nbUnread = -1;

	public function __construct(string $name = '') {
		$this->_name($name);
	}

	public function id(): int {
		return $this->id;
	}

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
	 * @return array|mixed|null
	 */
	public function attributes($key = '') {
		if ($key == '') {
			return $this->attributes;
		} else {
			return $this->attributes[$key] ?? null;
		}
	}

	public function _attributes($key, $value): void {
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

	public function nbEntries() {
		if ($this->nbEntries < 0) {
			$tagDAO = FreshRSS_Factory::createTagDao();
			$this->nbEntries = $tagDAO->countEntries($this->id());
		}
		return $this->nbEntries;
	}

	public function _nbEntries($value): void {
		$this->nbEntries = (int)$value;
	}

	/**
	 * @return mixed
	 */
	public function nbUnread() {
		if ($this->nbUnread < 0) {
			$tagDAO = FreshRSS_Factory::createTagDao();
			$this->nbUnread = $tagDAO->countNotRead($this->id());
		}
		return $this->nbUnread;
	}

	public function _nbUnread($value): void {
		$this->nbUnread = (int)$value;
	}
}
