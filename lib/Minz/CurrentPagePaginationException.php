<?php
declare(strict_types=1);

namespace FreshRss\Minz;

class CurrentPagePaginationException extends Exception {
	public function __construct(int $page) {
		$message = 'Page number `' . $page . '` doesn’t exist';

		parent::__construct($message, self::ERROR);
	}
}
