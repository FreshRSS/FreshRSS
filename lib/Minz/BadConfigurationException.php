<?php
class Minz_BadConfigurationException extends Minz_Exception {
	public function __construct ($part_missing, $code = self::ERROR) {
		$message = '`' . $part_missing
		         . '` in the configuration file is missing or is misconfigured';
		
		parent::__construct ($message, $code);
	}
}
