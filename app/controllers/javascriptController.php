<?php

class javascriptController extends ActionController {
	public function firstAction () {
		$this->view->_useLayout (false);
		header('Content-type: text/javascript');
	}
	
	public function mainAction () {
	
	}
}
