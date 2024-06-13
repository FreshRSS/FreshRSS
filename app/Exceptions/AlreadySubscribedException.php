<?php
declare(strict_types=1);

class FreshRSS_AlreadySubscribed_Exception extends Minz_Exception {

	private string $feedName = '';

	public function __construct(string $url, string $feedName) {
		parent::__construct('Already subscribed! ' . $url, 2135);
		$this->feedName = $feedName;
	}

	public function feedName(): string {
		return $this->feedName;
	}
}
