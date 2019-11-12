<?php

namespace Minz;

class ControllerNotExistException extends Exception {
	public function __construct ($controller_name, $code = self::ERROR) {
		$message = 'Controller not found!';
		parent::__construct ($message, $code);
	}
}
