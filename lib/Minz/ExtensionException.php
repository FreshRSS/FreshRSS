<?php

namespace Minz;

class ExtensionException extends Exception {
	public function __construct ($message, $extension_name = false, $code = self::ERROR) {
		if ($extension_name) {
			$message = 'An error occured in `' . $extension_name
			         . '` extension with the message: ' . $message;
		} else {
			$message = 'An error occured in an unnamed '
			         . 'extension with the message: ' . $message;
		}

		parent::__construct($message, $code);
	}
}
