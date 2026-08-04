<?php
declare(strict_types=1);

namespace FreshRss\Minz;

class FileNotExistException extends Exception {
	public function __construct(string $file_name, int $code = self::ERROR) {
		$message = 'File not found: `' . $file_name . '`';

		parent::__construct($message, $code);
	}
}
