<?php

class FreshRSS_javascript_Controller extends Minz_ActionController {
	public function firstAction () {
		$this->view->_useLayout (false);
	}

	public function actualizeAction () {
		header('Content-Type: text/javascript; charset=UTF-8');
		$feedDAO = FreshRSS_Factory::createFeedDao();
		$this->view->feeds = $feedDAO->listFeedsOrderUpdate($this->view->conf->ttl_default);
	}

	public function nbUnreadsPerFeedAction() {
		header('Content-Type: application/json; charset=UTF-8');
		$catDAO = new FreshRSS_CategoryDAO();
		$this->view->categories = $catDAO->listCategories(true, false);
	}

	//For Web-form login
	public function nonceAction() {
		header('Content-Type: application/json; charset=UTF-8');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s \G\M\T'));
		header('Expires: 0');
		header('Cache-Control: private, no-cache, no-store, must-revalidate');
		header('Pragma: no-cache');

		$user = isset($_GET['user']) ? $_GET['user'] : '';
		if (ctype_alnum($user)) {
			try {
				$conf = new FreshRSS_Configuration($user);
				$s = $conf->passwordHash;
				if (strlen($s) >= 60) {
					$this->view->salt1 = substr($s, 0, 29);	//CRYPT_BLOWFISH Salt: "$2a$", a two digit cost parameter, "$", and 22 characters from the alphabet "./0-9A-Za-z".
					$this->view->nonce = sha1(Minz_Configuration::salt() . uniqid(mt_rand(), true));
					Minz_Session::_param('nonce', $this->view->nonce);
					return;	//Success
				}
			} catch (Minz_Exception $me) {
				Minz_Log::record('Nonce failure: ' . $me->getMessage(), Minz_Log::WARNING);
			}
		}
		$this->view->nonce = '';	//Failure
		$this->view->salt1 = '';
	}
}
