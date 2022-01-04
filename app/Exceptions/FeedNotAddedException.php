<?php

class FreshRSS_FeedNotAdded_Exception extends Exception {
	private $url = '';

	public function __construct($url) {
		parent::__construct('Feed not added! ' . $url, 2147);
		$this->url = $url;
	}

	public function url() {
		return $this->url;
	}
}
