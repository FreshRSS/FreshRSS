<?php
class Minz_ControllerNotActionControllerException extends Minz_Exception {
	public function __construct ($controller_name, $code = self::ERROR) {
		$message = 'Controller `' . $controller_name
		         . '` isn\'t instance of ActionController';

		parent::__construct ($message, $code);
	}
}
