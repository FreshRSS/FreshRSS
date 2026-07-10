<?php
declare(strict_types=1);

namespace FreshRss\Exceptions;

use FreshRss\Minz\Exception;

class FeedException extends Exception {

	/**
	 * @param int $code The HTTP status code when known, e.g. 410 Gone, which mutes the feed
	 */
	public function __construct(string $message = '', int $code = 0, ?\Throwable $previous = null) {
		parent::__construct($message, previous: $previous);
		$this->code = $code;	// Exception would reset it, keeping only its own error levels
	}
}
