<?php
declare(strict_types=1);

class Minz_CurrentPagePaginationException extends Minz_Exception {
	public function __construct(int $page) {
		$message = 'Page number `' . $page . '` doesn’t exist';

		parent::__construct($message, self::ERROR);
	}
}
