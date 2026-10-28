<?php
declare(strict_types=1);

class FreshRSS_Log extends Minz_Model {

	private string $date;
	/** @property 'error'|'warning'|'notice'|'debug'|'info' $level */
	private string $level;
	private string $information;

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
		if (!in_array($level, ['error', 'warning', 'notice', 'debug', 'info'], true)) {
			$this->level = 'info';
			return;
		}
		$this->level = $level;
	}
	public function _info(string $information): void {
		$this->information = $information;
	}
}
