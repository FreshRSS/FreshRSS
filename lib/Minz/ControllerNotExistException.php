<?php
class Minz_ControllerNotExistException extends Minz_Exception {
	public function __construct ($controller_name, $code = self::ERROR) {
		$message = 'Controller `' . $controller_name
		         . '` doesn\'t exist';
		
		parent::__construct ($message, $code);
	}
}
