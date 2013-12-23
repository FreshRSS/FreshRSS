<?php
class Minz_CurrentPagePaginationException extends Minz_Exception {
	public function __construct ($page) {
		$message = 'Page number `' . $page . '` doesn\'t exist';
		
		parent::__construct ($message, self::ERROR);
	}
}
