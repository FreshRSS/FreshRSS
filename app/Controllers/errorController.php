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
	 *   - error_logs (default: array())
	 */
	public function indexAction(): void {
		$code_int = Minz_Session::paramInt('error_code') ?: FreshRSS_HttpResponseCode::HTTP_404_NOT_FOUND;
		/** @var array<string> */
		$error_logs = Minz_Session::paramArray('error_logs');
		Minz_Session::_params([
			'error_code' => false,
			'error_logs' => false,
		]);

		switch ($code_int) {
			case FreshRSS_HttpResponseCode::HTTP_200_OK:
				header('HTTP/1.1 200 OK');
				break;
			case FreshRSS_HttpResponseCode::HTTP_400_BAD_REQUEST:
				header('HTTP/1.1 400 Bad Request');
				$this->view->code = 'Error 400 - Bad Request';
				$this->view->errorMessage = '';
				break;
			case FreshRSS_HttpResponseCode::HTTP_403_FORBIDDEN:
				header('HTTP/1.1 403 Forbidden');
				$this->view->code = 'Error 403 - Forbidden';
				$this->view->errorMessage = _t('feedback.access.denied');
				break;
			case FreshRSS_HttpResponseCode::HTTP_404_NOT_FOUND:
				header('HTTP/1.1 404 Not Found');
				$this->view->code = 'Error 404 - Not found';
				$this->view->errorMessage = _t('feedback.access.not_found');
				break;
			case FreshRSS_HttpResponseCode::HTTP_405_METHOD_NOT_ALLOWED:
				header('HTTP/1.1 405 Method Not Allowed');
				$this->view->code = 'Error 405 - Method Not Allowed';
				$this->view->errorMessage = '';
				break;
			case FreshRSS_HttpResponseCode::HTTP_503_SERVICE_UNAVAILABLE:
				header('HTTP/1.1 503 Service Unavailable');
				$this->view->code = 'Error 503 - Service Unavailable';
				$this->view->errorMessage = 'Error 503 - Service Unavailable';
				break;
			case FreshRSS_HttpResponseCode::HTTP_500_INTERNAL_SERVER_ERROR:
			default:
				header('HTTP/1.1 500 Internal Server Error');
				$this->view->code = 'Error 500 - Internal Server Error';
				$this->view->errorMessage = 'Error 500 - Internal Server Error';
				break;
		}

		$error_message = trim(implode($error_logs));
		if ($error_message !== '') {
			$this->view->errorMessage = $error_message;
		}

		FreshRSS_View::prependTitle($this->view->code . ' · ');
	}
}
