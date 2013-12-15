<?php
class Minz_ActionException extends Minz_Exception {
	public function __construct ($controller_name, $action_name, $code = self::ERROR) {
		$message = '`' . $action_name . '` cannot be invoked on `'
		         . $controller_name . '`';
		
		parent::__construct ($message, $code);
	}
}
