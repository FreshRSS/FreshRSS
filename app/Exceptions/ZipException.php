<?php
declare(strict_types=1);

namespace FreshRss\Exceptions;

use FreshRss\Minz\Exception;

class ZipException extends Exception {

	public function __construct(private readonly int $zipErrorCode) {
		parent::__construct('ZIP error!', 2141);
	}

	public function zipErrorCode(): int {
		return $this->zipErrorCode;
	}
}
