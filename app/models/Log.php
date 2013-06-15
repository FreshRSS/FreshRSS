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

		$i = 0;
		while (($line = $this->readLine ()) !== false) {
			$logs[$i] = new Log_Model ();
			$logs[$i]->_date (preg_replace ("'\[(.*?)\] \[(.*?)\] --- (.*?)'U", "\\1", $line));
			$logs[$i]->_level (preg_replace ("'\[(.*?)\] \[(.*?)\] --- (.*?)'U", "\\2", $line));
			$logs[$i]->_info (preg_replace ("'\[(.*?)\] \[(.*?)\] --- (.*?)'U", "\\3", $line));
			$i++;
		}

		return $logs;
	}
}