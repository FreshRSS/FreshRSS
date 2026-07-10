<?php
declare(strict_types=1);

namespace FreshRss\Minz;

class ControllerNotExistException extends Exception {
	public function __construct(int $code = self::ERROR) {
		$message = 'Controller not found!';
		parent::__construct($message, $code);
	}
}
