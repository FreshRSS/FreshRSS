<?php

class Minz_ExtensionException extends Minz_Exception {
	public function __construct ($message, $extension_name = false, $code = self::ERROR) {
		if ($extension_name) {
			$message = 'An error occurred in `' . $extension_name . '` extension with the message: ' . $message;
		} else {
			$message = 'An error occurred in an unnamed extension with the message: ' . $message;
		}

		parent::__construct($message, $code);
	}
}
