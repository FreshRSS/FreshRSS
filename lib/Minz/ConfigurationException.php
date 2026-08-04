<?php
declare(strict_types=1);

namespace FreshRss\Minz;

class ConfigurationException extends Exception {
	public function __construct(string $error, int $code = self::ERROR) {
		$message = 'Configuration error: ' . $error;
		parent::__construct($message, $code);
	}
}
