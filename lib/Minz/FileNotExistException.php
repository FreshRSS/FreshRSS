<?php
declare(strict_types=1);

class Minz_FileNotExistException extends Minz_Exception {
	public function __construct(string $file_name, int $code = self::ERROR) {
		$message = 'File not found: `' . $file_name . '`';

		parent::__construct($message, $code);
	}
}
