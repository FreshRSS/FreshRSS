<?php
class Minz_PermissionDeniedException extends Minz_Exception {
	public function __construct ($file_name, $code = self::ERROR) {
		$message = 'Permission is denied for `' . $file_name.'`';

		parent::__construct ($message, $code);
	}
}
