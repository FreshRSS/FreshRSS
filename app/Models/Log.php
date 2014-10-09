<?php

class FreshRSS_Log extends Minz_Model {
	private $date;
	private $level;
	private $information;

	public function date () {
		return $this->date;
	}
	public function level () {
		return $this->level;
	}
	public function info () {
		return $this->information;
	}
	public function _date ($date) {
		$this->date = $date;
	}
	public function _level ($level) {
		$this->level = $level;
	}
	public function _info ($information) {
		$this->information = $information;
	}
}
