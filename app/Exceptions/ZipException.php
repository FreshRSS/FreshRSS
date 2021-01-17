<?php

class FreshRSS_Zip_Exception extends Exception {
	private $zipErrorCode = 0;

	public function __construct($zipErrorCode) {
		parent::__construct('ZIP error!', 2141);
		$this->zipErrorCode = $zipErrorCode;
	}

	public function zipErrorCode() {
		return $this->zipErrorCode;
	}
}
