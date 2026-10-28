<?php
declare(strict_types=1);
class Minz_ConfigurationException extends Minz_Exception {
	public function __construct(string $error, int $code = self::ERROR) {
		$message = 'Configuration error: ' . $error;
		parent::__construct($message, $code);
	}
}
