<?php

class FreshRSS_javascript_Controller extends FreshRSS_ActionController {
	public function firstAction() {
		$this->view->_layout(false);
	}

	public function actualizeAction() {
		header('Content-Type: application/json; charset=UTF-8');
		Minz_Session::_param('actualize_feeds', false);
		$feedDAO = FreshRSS_Factory::createFeedDao();
		$this->view->feeds = $feedDAO->listFeedsOrderUpdate(FreshRSS_Context::$user_conf->ttl_default);
	}

	public function nbUnreadsPerFeedAction() {
		header('Content-Type: application/json; charset=UTF-8');
		$catDAO = FreshRSS_Factory::createCategoryDao();
		$this->view->categories = $catDAO->listCategories(true, false);
		$tagDAO = FreshRSS_Factory::createTagDao();
		$this->view->tags = $tagDAO->listTags(true);
	}

	//For Web-form login
	public function nonceAction() {
		header('Content-Type: application/json; charset=UTF-8');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s \G\M\T'));
		header('Expires: 0');
		header('Cache-Control: private, no-cache, no-store, must-revalidate');
		header('Pragma: no-cache');

		$user = isset($_GET['user']) ? $_GET['user'] : '';
		if (FreshRSS_Context::initUser($user)) {
			try {
				$salt = FreshRSS_Context::$system_conf->salt;
				$s = FreshRSS_Context::$user_conf->passwordHash;
				if (strlen($s) >= 60) {
					//CRYPT_BLOWFISH Salt: "$2a$", a two digit cost parameter, "$", and 22 characters from the alphabet "./0-9A-Za-z".
					$this->view->salt1 = substr($s, 0, 29);
					$this->view->nonce = sha1($salt . uniqid('' . mt_rand(), true));
					Minz_Session::_param('nonce', $this->view->nonce);
					return;	//Success
				}
			} catch (Minz_Exception $me) {
				Minz_Log::warning('Nonce failure: ' . $me->getMessage());
			}
		} else {
			Minz_Log::notice('Nonce failure due to invalid username!');
		}
		//Failure: Return random data.
		$this->view->salt1 = sprintf('$2a$%02d$', FreshRSS_password_Util::BCRYPT_COST);
		$alphabet = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		for ($i = 22; $i > 0; $i--) {
			$this->view->salt1 .= $alphabet[mt_rand(0, 63)];
		}
		$this->view->nonce = sha1('' . mt_rand());
	}
}
