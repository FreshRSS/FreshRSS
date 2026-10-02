<?php
declare(strict_types=1);

class FreshRSS_Feed_Exception extends Minz_Exception {

	/**
	 * @param int $code The HTTP status code when known, e.g. 410 Gone, which mutes the feed
	 */
	public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null) {
		parent::__construct($message, previous: $previous);
		$this->code = $code;	// Minz_Exception would reset it, keeping only its own error levels
	}
}
