<?php

namespace Freshrss\Exceptions;

class AlreadySubscribed_Exception extends \Exception {
	private $feedName = '';

	public function __construct($url, $feedName) {
		parent::__construct('Already subscribed! ' . $url, 2135);
		$this->feedName = $feedName;
	}

	public function feedName() {
		return $this->feedName;
	}
}
