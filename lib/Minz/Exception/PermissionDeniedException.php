<?php

namespace Minz\Exception;

class PermissionDeniedException extends Exception {
	public function __construct ($file_name, $code = self::ERROR) {
		$message = 'Permission is denied for `' . $file_name.'`';

		parent::__construct ($message, $code);
	}
}
