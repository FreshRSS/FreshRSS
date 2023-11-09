<?php

class FreshRSS_BadUrl_Exception extends FreshRSS_Feed_Exception {

	public function __construct(string $url) {
		parent::__construct('`' . $url . '` is not a valid URL');
	}

}
