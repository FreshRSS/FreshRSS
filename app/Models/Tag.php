<?php

class FreshRSS_Tag extends Minz_Model {
	private $id = 0;
	private $name;
	private $attributes = array();
	private $nbEntries = -1;
	private $nbUnread = -1;

	public function __construct($name = '') {
		$this->_name($name);
	}

	public function id() {
		return $this->id;
	}

	public function _id($value) {
		$this->id = (int)$value;
	}

	public function name() {
		return $this->name;
	}

	public function _name($value) {
		$this->name = trim($value);
	}

	public function attributes($key = '') {
		if ($key == '') {
			return $this->attributes;
		} else {
			return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
		}
	}

	public function _attributes($key, $value) {
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
		return $this->nbFeed;
	}

	public function _nbEntries($value) {
		$this->nbEntries = (int)$value;
	}

	public function nbUnread() {
		if ($this->nbUnread < 0) {
			$tagDAO = FreshRSS_Factory::createTagDao();
			$this->nbUnread = $tagDAO->countNotRead($this->id());
		}
		return $this->nbUnread;
	}

	public function _nbUnread($value) {
		$this->nbUnread = (int)$value;
	}
}
