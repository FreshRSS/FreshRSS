<?php
declare(strict_types=1);

namespace FreshRss\Exceptions;

use FreshRss\Minz\Exception;

class FeedNotAddedException extends Exception {

	private string $url = '';

	public function __construct(string $url) {
		parent::__construct('Feed not added! ' . $url, 2147);
		$this->url = $url;
	}

	public function url(): string {
		return $this->url;
	}
}
