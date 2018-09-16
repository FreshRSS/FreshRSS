<?php

class FreshRSS_Tag extends Minz_Model {
	private $id = 0;
	private $name;
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

	public function nbEntries() {
		if ($this->nbEntries < 0) {
			$tagDAO = new FreshRSS_TagDAO();
			$this->nbEntries = $tagDAO->countEntries($this->id());
		}
		return $this->nbFeed;
	}

	public function _nbEntries($value) {
		$this->nbEntries = (int)$value;
	}

	public function nbUnread() {
		if ($this->nbUnread < 0) {
			$tagDAO = new FreshRSS_TagDAO();
			$this->nbUnread = $tagDAO->countNotRead($this->id());
		}
		return $this->nbUnread;
	}

	public function _nbUnread($value) {
		$this->nbUnread = (int)$value;
	}
}
