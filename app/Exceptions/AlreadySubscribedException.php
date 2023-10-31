<?php

class FreshRSS_AlreadySubscribed_Exception extends Exception {

	private string $feedName = '';

	public function __construct(string $url, string $feedName) {
		parent::__construct('Already subscribed! ' . $url, 2135);
		$this->feedName = $feedName;
	}

	public function feedName(): string {
		return $this->feedName;
	}
}
