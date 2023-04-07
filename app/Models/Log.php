<?php

class FreshRSS_Log extends Minz_Model {
	/** @var string */
	private $date;
	/** @var string */
	private $level;
	/** @var string */
	private $information;

	public function date(): string {
		return $this->date;
	}
	public function level(): string {
		return $this->level;
	}
	public function info(): string {
		return $this->information;
	}
	public function _date(string $date): void {
		$this->date = $date;
	}
	public function _level(string $level): void {
		$this->level = $level;
	}
	public function _info(string $information): void {
		$this->information = $information;
	}
}
