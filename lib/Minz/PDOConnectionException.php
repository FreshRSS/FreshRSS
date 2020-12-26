<?php

namespace Minz;

class PDOConnectionException extends Exception {
	public function __construct ($error, $user, $code = self::ERROR) {
		$message = 'Access to database is denied for `' . $user . '`: ' . $error;

		parent::__construct ($message, $code);
	}
}
