<?php

/**
 * Controller to handle error page.
 */
class FreshRSS_error_Controller extends Minz_ActionController {
	/**
	 * This action is the default one for the controller.
	 *
	 * It is called by Minz_Error::error() method.
	 *
	 * Parameters are:
	 *   - code (default: 404)
	 *   - logs (default: array())
	 */
	public function indexAction() {
		$code_int = Minz_Request::param('code', 404);
		switch ($code_int) {
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

		$errors = Minz_Request::param('logs', array());
		$this->view->errorMessage = trim(implode($errors));
		if ($this->view->errorMessage == '') {
			switch($code_int) {
			case 403:
				$this->view->errorMessage = _t('forbidden_access');
				break;
			case 404:
			default:
				$this->view->errorMessage = _t('page_not_found');
				break;
			}
		}

		Minz_View::prependTitle($this->view->code . ' · ');
	}
}
