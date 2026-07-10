<?php
declare(strict_types=1);

namespace FreshRss\Minz;

class ActionException extends Exception {
	public function __construct(string $controller_name, string $action_name, int $code = self::ERROR) {
		// Just for security, as we are not supposed to get non-alphanumeric characters.
		$action_name = rawurlencode($action_name);

		$message = "Invalid action name “{$action_name}” for controller “{$controller_name}”.";
		parent::__construct($message, $code);
	}
}
