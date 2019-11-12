<?php

namespace Freshrss\Exceptions;

class FeedNotAdded_Exception extends \Exception {
	private $feedName = '';

	public function __construct($url, $feedName) {
		parent::__construct('Feed not added! ' . $url, 2147);
		$this->feedName = $feedName;
	}

	public function feedName() {
		return $this->feedName;
	}
}
