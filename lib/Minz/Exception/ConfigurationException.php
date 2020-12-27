<?php

namespace Minz\Exception;

class ConfigurationException extends Exception {
	public function __construct($error, $code = self::ERROR) {
		$message = 'Configuration error: ' . $error;
		parent::__construct($message, $code);
	}
}
