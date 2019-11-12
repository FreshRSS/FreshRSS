<?php

namespace Freshrss\Exceptions;

class Zip_Exception extends \Exception {
	private $zipErrorCode = 0;

	public function __construct($zipErrorCode) {
		parent::__construct('ZIP error! ' . $url, 2141);
		$this->zipErrorCode = $zipErrorCode;
	}

	public function zipErrorCode() {
		return $this->zipErrorCode;
	}
}
