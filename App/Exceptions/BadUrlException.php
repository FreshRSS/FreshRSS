<?php

namespace Freshrss\Exceptions;

class BadUrl_Exception extends FreshRSS_Feed_Exception {

	public function __construct($url) {
		parent::__construct('`' . $url . '` is not a valid URL');
	}

}
