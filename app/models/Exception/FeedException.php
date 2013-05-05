<?php

class FeedException extends Exception {
	public function __construct ($message) {
		parent::__construct ($message);
	}
}

class BadUrlException extends FeedException {
	public function __construct ($url) {
		parent::__construct ('`' . $url . '` is not a valid URL');
	}
}
