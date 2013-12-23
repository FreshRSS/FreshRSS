<?php
class Minz_Exception extends Exception {
	const ERROR = 0;
	const WARNING = 10;
	const NOTICE = 20;

	public function __construct ($message, $code = self::ERROR) {
		if ($code != Minz_Exception::ERROR
		 && $code != Minz_Exception::WARNING
		 && $code != Minz_Exception::NOTICE) {
			$code = Minz_Exception::ERROR;
		}

		parent::__construct ($message, $code);
	}
}
