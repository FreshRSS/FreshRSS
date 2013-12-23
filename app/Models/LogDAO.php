<?php

class FreshRSS_LogDAO extends Minz_ModelTxt {
	public function __construct () {
		parent::__construct (LOG_PATH . '/application.log', 'r+');
	}

	public function lister () {
		$logs = array ();
		while (($line = $this->readLine ()) !== false) {
			if (preg_match ('/^\[([^\[]+)\] \[([^\[]+)\] --- (.*)$/', $line, $matches)) {
				$myLog = new FreshRSS_Log ();
				$myLog->_date ($matches[1]);
				$myLog->_level ($matches[2]);
				$myLog->_info ($matches[3]);
				$logs[] = $myLog;
			}
		}
		return $logs;
	}
}
