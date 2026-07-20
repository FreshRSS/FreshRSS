<?php
declare(strict_types=1);

class FreshRSS_Zip_Exception extends Minz_Exception {

	public function __construct(private readonly int $zipErrorCode) {
		parent::__construct('ZIP error!', 2141);
	}

	public function zipErrorCode(): int {
		return $this->zipErrorCode;
	}
}
