<?php

class FreshRSS_Zip_Exception extends Exception {
	private $zipErrorCode = 0;

	public function __construct($zipErrorCode, $url) {
		parent::__construct('ZIP error! ' . $url, 2141);
		$this->zipErrorCode = $zipErrorCode;
	}

	public function zipErrorCode() {
		return $this->zipErrorCode;
	}
}
