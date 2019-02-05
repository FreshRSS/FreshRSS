<?php
class Minz_ActionException extends Minz_Exception {
	public function __construct ($controller_name, $action_name, $code = self::ERROR) {
		$message = 'Invalid action name for controller ' . $controller_name;
		parent::__construct ($message, $code);
	}
}
