<?php

namespace Minz;

class PDOConnectionException extends Exception {
	public function __construct ($string_connection, $user, $code = self::ERROR) {
		$message = 'Access to database is denied for `' . $user . '`'
		         . ' (`' . $string_connection . '`)';

		parent::__construct ($message, $code);
	}
}
