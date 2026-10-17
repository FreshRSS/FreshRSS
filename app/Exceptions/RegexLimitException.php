<?php
declare(strict_types=1);

class FreshRSS_RegexLimit_Exception extends Minz_Exception {
	public function __construct(string $pattern, string $preg_error_msg) {
		parent::__construct('Regex search with pattern `' . $pattern . '` halted: ' . $preg_error_msg, Minz_Exception::WARNING);
	}
}
