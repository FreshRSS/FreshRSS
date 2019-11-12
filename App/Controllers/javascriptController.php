<?php

namespace Freshrss\Controllers;

class javascript_Controller extends ActionController {
	public function firstAction() {
		$this->view->_layout(false);
	}

	public function actualizeAction() {
		header('Content-Type: application/json; charset=UTF-8');
		Session::_param('actualize_feeds', false);
		$feedDAO = Factory::createFeedDao();
		$this->view->feeds = $feedDAO->listFeedsOrderUpdate(Context::$user_conf->ttl_default);
	}

	public function nbUnreadsPerFeedAction() {
		header('Content-Type: application/json; charset=UTF-8');
		$catDAO = Factory::createCategoryDao();
		$this->view->categories = $catDAO->listCategories(true, false);
		$tagDAO = Factory::createTagDao();
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
		if (user_Controller::checkUsername($user)) {
			try {
				$salt = Context::$system_conf->salt;
				$conf = get_user_configuration($user);
				$s = $conf->passwordHash;
				if (strlen($s) >= 60) {
					$this->view->salt1 = substr($s, 0, 29);	//CRYPT_BLOWFISH Salt: "$2a$", a two digit cost parameter, "$", and 22 characters from the alphabet "./0-9A-Za-z".
					$this->view->nonce = sha1($salt . uniqid(mt_rand(), true));
					Session::_param('nonce', $this->view->nonce);
					return;	//Success
				}
			} catch (Exception $me) {
				Log::warning('Nonce failure: ' . $me->getMessage());
			}
		} else {
			Log::notice('Nonce failure due to invalid username!');
		}
		//Failure: Return random data.
		$this->view->salt1 = sprintf('$2a$%02d$', user_Controller::BCRYPT_COST);
		$alphabet = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		for ($i = 22; $i > 0; $i--) {
			$this->view->salt1 .= $alphabet[mt_rand(0, 63)];
		}
		$this->view->nonce = sha1(mt_rand());
	}
}
