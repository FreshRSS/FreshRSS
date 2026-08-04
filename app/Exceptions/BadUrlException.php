<?php
declare(strict_types=1);

namespace FreshRss\Exceptions;

class BadUrlException extends FeedException {
	public function __construct(string $url) {
		parent::__construct('`' . $url . '` is not a valid URL');
	}
}
