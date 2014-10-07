<?php

/**
 * This controller handles action about authentication.
 */
class FreshRSS_auth_Controller extends Minz_ActionController {
	/**
	 * This action handles the login page.
	 *
	 * It forwards to the correct login page (form or Persona) or main page if
	 * the user is already connected.
	 */
	public function loginAction() {
		if (FreshRSS_Auth::hasAccess()) {
			Minz_Request::forward(array('c' => 'index', 'a' => 'index'), true);
		}

		$auth_type = Minz_Configuration::authType();
		switch ($auth_type) {
		case 'form':
			Minz_Request::forward(array('c' => 'auth', 'a' => 'formLogin'));
			break;
		case 'persona':
			Minz_Request::forward(array('c' => 'auth', 'a' => 'personaLogin'));
			break;
		case 'http_auth':
		case 'none':
			// It should not happened!
			Minz_Error::error(404);
		default:
			// TODO load plugin instead
			Minz_Error::error(404);
		}
	}

	/**
	 * This action handles form login page.
	 *
	 * If this action is reached through a POST request, username and password
	 * are compared to login the current user.
	 *
	 * Parameters are:
	 *   - nonce (default: false)
	 *   - username (default: '')
	 *   - challenge (default: '')
	 *   - keep_logged_in (default: false)
	 */
	public function formLoginAction() {
		invalidateHttpCache();

		$file_mtime = @filemtime(PUBLIC_PATH . '/scripts/bcrypt.min.js');
		Minz_View::appendScript(Minz_Url::display('/scripts/bcrypt.min.js?' . $file_mtime));

		if (Minz_Request::isPost()) {
			$nonce = Minz_Session::param('nonce');
			$username = Minz_Request::param('username', '');
			$challenge = Minz_Request::param('challenge', '');
			try {
				$conf = new FreshRSS_Configuration($username);
			} catch(Minz_Exception $e) {
				// $username is not a valid user, nor the configuration file!
				Minz_Log::warning('Login failure: ' . $e->getMessage());
				Minz_Request::bad(_t('invalid_login'),
				                  array('c' => 'auth', 'a' => 'login'));
			}

			$ok = FreshRSS_FormAuth::checkCredentials(
				$username, $conf->passwordHash, $nonce, $challenge
			);
			if ($ok) {
				// Set session parameter to give access to the user.
				Minz_Session::_param('currentUser', $username);
				Minz_Session::_param('passwordHash', $conf->passwordHash);
				FreshRSS_Auth::giveAccess();

				// Set cookie parameter if nedded.
				if (Minz_Request::param('keep_logged_in')) {
					FreshRSS_FormAuth::makeCookie($username, $conf->passwordHash);
				} else {
					FreshRSS_FormAuth::deleteCookie();
				}

				// All is good, go back to the index.
				Minz_Request::good(_t('login'),
				                   array('c' => 'index', 'a' => 'index'));
			} else {
				Minz_Log::warning('Password mismatch for' .
				                  ' user=' . $username .
				                  ', nonce=' . $nonce .
				                  ', c=' . $challenge);
				Minz_Request::bad(_t('invalid_login'),
				                  array('c' => 'auth', 'a' => 'login'));
			}
		}
	}

	/**
	 * This action handles Persona login page.
	 *
	 * If this action is reached through a POST request, assertion from Persona
	 * is verificated and user connected if all is ok.
	 *
	 * Parameter is:
	 *   - assertion (default: false)
	 *
	 * @todo: Persona system should be moved to a plugin
	 */
	public function personaLoginAction() {
		$this->view->res = false;

		if (Minz_Request::isPost()) {
			$this->view->_useLayout(false);

			$assert = Minz_Request::param('assertion');
			$url = 'https://verifier.login.persona.org/verify';
			$params = 'assertion=' . $assert . '&audience=' .
			          urlencode(Minz_Url::display(null, 'php', true));
			$ch = curl_init();
			$options = array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_POST => 2,
				CURLOPT_POSTFIELDS => $params
			);
			curl_setopt_array($ch, $options);
			$result = curl_exec($ch);
			curl_close($ch);

			$res = json_decode($result, true);

			$login_ok = false;
			$reason = '';
			if ($res['status'] === 'okay') {
				$email = filter_var($res['email'], FILTER_VALIDATE_EMAIL);
				if ($email != '') {
					$persona_file = DATA_PATH . '/persona/' . $email . '.txt';
					if (($current_user = @file_get_contents($persona_file)) !== false) {
						$current_user = trim($current_user);
						try {
							$conf = new FreshRSS_Configuration($current_user);
							$login_ok = strcasecmp($email, $conf->mail_login) === 0;
						} catch (Minz_Exception $e) {
							//Permission denied or conf file does not exist
							$reason = 'Invalid configuration for user ' .
							          '[' . $current_user . '] ' . $e->getMessage();
						}
					}
				} else {
					$reason = 'Invalid email format [' . $res['email'] . ']';
				}
			} else {
				$reason = $res['reason'];
			}

			if ($login_ok) {
				Minz_Session::_param('currentUser', $current_user);
				Minz_Session::_param('mail', $email);
				FreshRSS_Auth::giveAccess();
				invalidateHttpCache();
			} else {
				Minz_Log::error($reason);

				$res = array();
				$res['status'] = 'failure';
				$res['reason'] = _t('invalid_login');
			}

			header('Content-Type: application/json; charset=UTF-8');
			$this->view->res = $res;
		}
	}

	/**
	 * This action removes all accesses of the current user.
	 */
	public function logoutAction() {
		invalidateHttpCache();
		FreshRSS_Auth::removeAccess();
		Minz_Request::good(_t('disconnected'),
		                   array('c' => 'index', 'a' => 'index'));
	}
}
