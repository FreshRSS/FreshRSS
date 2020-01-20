<?php
class Minz_ContentException extends Minz_Exception {
	public function __construct ($controller_name, $action_name, $code = self::ERROR) {
		$message = 'Invalid content name for controller ' . $controller_name;
		parent::__construct ($message, $code);
	}
}
