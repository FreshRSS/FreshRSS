<?php

namespace Minz\Exception;

class CurrentPagePaginationException extends Exception {
	public function __construct ($page) {
		$message = 'Page number `' . $page . '` doesn\'t exist';

		parent::__construct ($message, self::ERROR);
	}
}
