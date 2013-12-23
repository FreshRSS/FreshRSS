<?php
class Minz_PDOConnectionException extends Minz_Exception {
	public function __construct ($string_connection, $user, $code = self::ERROR) {
		$message = 'Access to database is denied for `' . $user . '`'
		         . ' (`' . $string_connection . '`)';
		
		parent::__construct ($message, $code);
	}
}
