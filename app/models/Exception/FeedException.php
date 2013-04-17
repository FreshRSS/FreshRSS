<?php

class FeedException extends Exception {
	public function __construct ($message) {
		parent::__construct ($message);
	}
}
