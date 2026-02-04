<?php
declare(strict_types=1);

class Minz_PDOConnectionException extends Minz_Exception {
	public function __construct(string $error, string $user, int $code = self::ERROR) {
		$message = 'Access to database is denied for `' . $user . '`: ' . $error;

		parent::__construct($message, $code);
	}
}
