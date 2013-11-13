<?php

class Log_Model extends Model {
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

class LogDAO extends Model_txt {
	public function __construct () {
		parent::__construct (LOG_PATH . '/application.log', 'r+');
	}

	public function lister () {
		$logs = array ();
		while (($line = $this->readLine ()) !== false) {
			if (preg_match ('/^\[([^\[]+)\] \[([^\[]+)\] --- (.*)$/', $line, $matches)) {
				$myLog = new Log_Model ();
				$myLog->_date ($matches[1]);
				$myLog->_level ($matches[2]);
				$myLog->_info ($matches[3]);
				$logs[] = $myLog;
			}
		}
		return $logs;
	}
}