<?php
declare(strict_types=1);

class Minz_ControllerNotExistException extends Minz_Exception {
	public function __construct(int $code = self::ERROR) {
		$message = 'Controller not found!';
		parent::__construct($message, $code);
	}
}
