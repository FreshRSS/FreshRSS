<?php
class Minz_FileNotExistException extends Minz_Exception {
	public function __construct ($file_name, $code = self::ERROR) {
		$message = 'File doesn\'t exist : `' . $file_name.'`';
		
		parent::__construct ($message, $code);
	}
}
