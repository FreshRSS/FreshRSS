<?php

class FreshRSS_Zip_Exception extends Exception {

	/** @var int */
	private $zipErrorCode = 0;

	public function __construct(int $zipErrorCode) {
		parent::__construct('ZIP error!', 2141);
		$this->zipErrorCode = $zipErrorCode;
	}

	public function zipErrorCode(): int {
		return $this->zipErrorCode;
	}
}
