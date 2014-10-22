<?php

/**
 * An exception raised when a context is invalid
 */
class FreshRSS_Context_Exception extends Exception {
	public function __construct($message) {
		parent::__construct($message);
	}
}
