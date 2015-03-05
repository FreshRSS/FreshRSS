<?php

class FreshRSS_BadUrl_Exception extends \Exception {

	public function __construct($url) {
		parent::__construct('`' . $url . '` is not a valid URL');
	}

}
