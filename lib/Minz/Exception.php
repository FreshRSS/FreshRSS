<?php

namespace Minz;

class Exception extends Exception {
	const ERROR = 0;
	const WARNING = 10;
	const NOTICE = 20;

	public function __construct ($message, $code = self::ERROR) {
		if ($code != Exception::ERROR
		 && $code != Exception::WARNING
		 && $code != Exception::NOTICE) {
			$code = Exception::ERROR;
		}

		parent::__construct ($message, $code);
	}
}
