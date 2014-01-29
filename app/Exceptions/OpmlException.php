<?php
class FreshRSS_Opml_Exception extends FreshRSS_Feed_Exception {
	public function __construct ($name_file) {
		parent::__construct ('OPML file is invalid');
	}
}
