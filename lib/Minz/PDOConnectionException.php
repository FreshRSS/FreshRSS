<?php
class Minz_PDOConnectionException extends Minz_Exception {
	public function __construct ($error, $user, $code = self::ERROR) {
		$message = 'Access to database is denied for `' . $user . '`: ' . $error;

		parent::__construct ($message, $code);
	}
}
