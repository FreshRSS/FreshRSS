<?php
class Minz_ControllerNotActionControllerException extends Minz_Exception {
	public function __construct(string $controller_name, int $code = self::ERROR) {
		$message = 'Controller `' . $controller_name . '` isn’t instance of ActionController';

		parent::__construct ($message, $code);
	}
}
