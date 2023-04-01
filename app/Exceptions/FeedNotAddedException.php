<?php

class FreshRSS_FeedNotAdded_Exception extends Exception {

	/** @var string */
	private $url = '';

	public function __construct(string $url) {
		parent::__construct('Feed not added! ' . $url, 2147);
		$this->url = $url;
	}

	public function url(): string {
		return $this->url;
	}
}
