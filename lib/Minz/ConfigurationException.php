<?php

class Minz_ConfigurationException extends Minz_Exception {
	public function __construct($error, $code = self::ERROR) {
		$message = 'Configuration error: ' . $error;
		parent::__construct($message, $code);
	}
}
