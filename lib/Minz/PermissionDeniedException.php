<?php
declare(strict_types=1);

class Minz_PermissionDeniedException extends Minz_Exception {
	public function __construct(string $file_name, int $code = self::ERROR) {
		$message = 'Permission is denied for `' . $file_name . '`';

		parent::__construct($message, $code);
	}
}
