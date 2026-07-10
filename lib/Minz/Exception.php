<?php
declare(strict_types=1);

namespace FreshRss\Minz;

class Exception extends \Exception {
	public const ERROR = 0;
	public const WARNING = 10;
	public const NOTICE = 20;

	public function __construct(string $message = '', int $code = self::ERROR, ?\Throwable $previous = null) {
		if ($code !== Exception::ERROR
			&& $code !== Exception::WARNING
			&& $code !== Exception::NOTICE) {
			$code = Exception::ERROR;
		}

		parent::__construct($message, $code, $previous);
	}
}
