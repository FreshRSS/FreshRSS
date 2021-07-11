<?php
class Minz_ActionException extends Minz_Exception {
	public function __construct ($controller_name, $action_name, $code = self::ERROR) {
		// Just for security, as we are not supposed to get non-alphanumeric characters.
		$action_name = rawurlencode($action_name);

		$message = "Invalid action name “${action_name}” for controller “${controller_name}”.";
		parent::__construct ($message, $code);
	}
}
