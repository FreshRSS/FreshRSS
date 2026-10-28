<?php
declare(strict_types=1);

class FreshRSS_AlreadySubscribed_Exception extends Minz_Exception {

	public function __construct(string $url, private readonly string $feedName) {
		parent::__construct('Already subscribed! ' . $url, 2135);
	}

	public function feedName(): string {
		return $this->feedName;
	}
}
