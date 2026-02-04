<?php
declare(strict_types=1);

/**
 * Controller to handle error page.
 */
class FreshRSS_error_Controller extends FreshRSS_ActionController {
	/**
	 * This action is the default one for the controller.
	 *
	 * It is called by Minz_Error::error() method.
	 *
	 * Parameters are passed by Minz_Session to have a proper url:
	 *   - error_code (default: 404)
	 *   - error_logs (default: [])
	 */
	public function indexAction(): void {
		$code_int = Minz_Session::paramInt('error_code') ?: 404;
		/** @var array<string> */
		$error_logs = Minz_Session::paramArray('error_logs');
		Minz_Session::_params([
			'error_code' => false,
			'error_logs' => false,
		]);

		switch ($code_int) {
			case 200:
				header('HTTP/1.1 200 OK');
				break;
			case 400:
				header('HTTP/1.1 400 Bad Request');
				$this->view->code = 'Error 400 - Bad Request';
				$this->view->errorMessage = '';
				break;
			case 403:
				header('HTTP/1.1 403 Forbidden');
				$this->view->code = 'Error 403 - Forbidden';
				$this->view->errorMessage = _t('feedback.access.denied');
				break;
			case 404:
				header('HTTP/1.1 404 Not Found');
				$this->view->code = 'Error 404 - Not found';
				$this->view->errorMessage = _t('feedback.access.not_found');
				break;
			case 405:
				header('HTTP/1.1 405 Method Not Allowed');
				$this->view->code = 'Error 405 - Method Not Allowed';
				$this->view->errorMessage = '';
				break;
			case 503:
				header('HTTP/1.1 503 Service Unavailable');
				$this->view->code = 'Error 503 - Service Unavailable';
				$this->view->errorMessage = 'Error 503 - Service Unavailable';
				break;
			case 500:
			default:
				header('HTTP/1.1 500 Internal Server Error');
				$this->view->code = 'Error 500 - Internal Server Error';
				$this->view->errorMessage = 'Error 500 - Internal Server Error';
				break;
		}

		$error_message = trim(implode('', $error_logs));
		if ($error_message !== '') {
			$this->view->errorMessage = $error_message;
		}

		FreshRSS_View::prependTitle($this->view->code . ' · ');
	}
}
