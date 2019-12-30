<?php
class Minz_FileNotExistException extends Minz_Exception {
	public function __construct ($file_name, $code = self::ERROR) {
		$message = 'File not found: `' . $file_name.'`';

		parent::__construct ($message, $code);
	}
}
