<?php

/**
 * Controller to handle error page.
 */
class FreshRSS_error_Controller extends Minz\ActionController {
	/**
	 * This action is the default one for the controller.
	 *
	 * It is called by Minz\Error::error() method.
	 *
	 * Parameters are passed by Minz\Session to have a proper url:
	 *   - error_code (default: 404)
	 *   - error_logs (default: array())
	 */
	public function indexAction() {
		$code_int = Minz\Session::param('error_code', 404);
		$error_logs = Minz\Session::param('error_logs', array());
		Minz\Session::_params([
			'error_code' => false,
			'error_logs' => false,
		]);

		switch ($code_int) {
		case 200 :
			header('HTTP/1.1 200 OK');
			break;
		case 403:
			header('HTTP/1.1 403 Forbidden');
			$this->view->code = 'Error 403 - Forbidden';
			$this->view->errorMessage = _t('feedback.access.denied');
			break;
		case 500:
			header('HTTP/1.1 500 Internal Server Error');
			$this->view->code = 'Error 500 - Internal Server Error';
			break;
		case 503:
			header('HTTP/1.1 503 Service Unavailable');
			$this->view->code = 'Error 503 - Service Unavailable';
			break;
		case 404:
		default:
			header('HTTP/1.1 404 Not Found');
			$this->view->code = 'Error 404 - Not found';
			$this->view->errorMessage = _t('feedback.access.not_found');
		}

		$error_message = trim(implode($error_logs));
		if ($error_message !== '') {
			$this->view->errorMessage = $error_message;
		}

		Minz\View::prependTitle($this->view->code . ' · ');
	}
}
