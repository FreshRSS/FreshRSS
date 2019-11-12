<?php

namespace Minz;

class FileNotExistException extends Exception {
	public function __construct ($file_name, $code = self::ERROR) {
		$message = 'File not found: `' . $file_name.'`';

		parent::__construct ($message, $code);
	}
}
