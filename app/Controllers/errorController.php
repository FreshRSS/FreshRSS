<?php

class FreshRSS_error_Controller extends Minz_ActionController {
	public function indexAction () {
		switch (Minz_Request::param ('code')) {
		case 403:
			$this->view->code = 'Error 403 - Forbidden';
			break;
		case 404:
			$this->view->code = 'Error 404 - Not found';
			break;
		case 500:
			$this->view->code = 'Error 500 - Internal Server Error';
			break;
		case 503:
			$this->view->code = 'Error 503 - Service Unavailable';
			break;
		default:
			$this->view->code = 'Error 404 - Not found';
		}
		
		$this->view->logs = Minz_Request::param ('logs');
		
		Minz_View::prependTitle ($this->view->code . ' · ');
	}
}
