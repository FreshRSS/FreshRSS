<?php
declare(strict_types=1);

class Minz_Exception extends Exception {
	public const ERROR = 0;
	public const WARNING = 10;
	public const NOTICE = 20;

	public function __construct(string $message = '', int $code = self::ERROR, ?Throwable $previous = null) {
		if ($code !== Minz_Exception::ERROR
			&& $code !== Minz_Exception::WARNING
			&& $code !== Minz_Exception::NOTICE) {
			$code = Minz_Exception::ERROR;
		}

		parent::__construct($message, $code, $previous);
	}
}
