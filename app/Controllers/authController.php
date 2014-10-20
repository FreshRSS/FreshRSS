<?php

/**
 * This controller handles action about authentication.
 */
class FreshRSS_auth_Controller extends Minz_ActionController {
	/**
	 * This action handles authentication management page.
	 *
	 * Parameters are:
	 *   - token (default: current token)
	 *   - anon_access (default: false)
	 *   - anon_refresh (default: false)
	 *   - auth_type (default: none)
	 *   - unsafe_autologin (default: false)
	 *   - api_enabled (default: false)
	 *
	 * @todo move unsafe_autologin in an extension.
	 */
	public function indexAction() {
		if (!FreshRSS_Auth::hasAccess('admin')) {
			Minz_Error::error(403,
			                  array('error' => array(_t('access_denied'))));
		}

		if (Minz_Request::isPost()) {
			$ok = true;

			$current_token = $this->view->conf->token;
			$token = Minz_Request::param('token', $current_token);
			$this->view->conf->_token($token);
			$ok &= $this->view->conf->save();

			$anon = Minz_Request::param('anon_access', false);
			$anon = ((bool)$anon) && ($anon !== 'no');
			$anon_refresh = Minz_Request::param('anon_refresh', false);
			$anon_refresh = ((bool)$anon_refresh) && ($anon_refresh !== 'no');
			$auth_type = Minz_Request::param('auth_type', 'none');
			$unsafe_autologin = Minz_Request::param('unsafe_autologin', false);
			$api_enabled = Minz_Request::param('api_enabled', false);
			if ($anon != Minz_Configuration::allowAnonymous() ||
				$auth_type != Minz_Configuration::authType() ||
				$anon_refresh != Minz_Configuration::allowAnonymousRefresh() ||
				$unsafe_autologin != Minz_Configuration::unsafeAutologinEnabled() ||
				$api_enabled != Minz_Configuration::apiEnabled()) {

				Minz_Configuration::_authType($auth_type);
				Minz_Configuration::_allowAnonymous($anon);
				Minz_Configuration::_allowAnonymousRefresh($anon_refresh);
				Minz_Configuration::_enableAutologin($unsafe_autologin);
				Minz_Configuration::_enableApi($api_enabled);
				$ok &= Minz_Configuration::writeFile();
			}

			invalidateHttpCache();

			if ($ok) {
				Minz_Request::good('configuration_updated',
				                   array('c' => 'auth', 'a' => 'index'));
			} else {
				Minz_Request::bad('error_occurred',
				                  array('c' => 'auth', 'a' => 'index'));
			}
		}
	}

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
	 *
	 * @todo move unsafe autologin in an extension.
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
		} elseif (Minz_Configuration::unsafeAutologinEnabled()) {
			$username = Minz_Request::param('u', '');
			$password = Minz_Request::param('p', '');
			Minz_Request::_param('p');

			if (!$username) {
				return;
			}

			try {
				$conf = new FreshRSS_Configuration($username);
			} catch(Minz_Exception $e) {
				// $username is not a valid user, nor the configuration file!
				Minz_Log::warning('Login failure: ' . $e->getMessage());
				return;
			}

			if (!function_exists('password_verify')) {
				include_once(LIB_PATH . '/password_compat.php');
			}

			$s = $conf->passwordHash;
			$ok = password_verify($password, $s);
			unset($password);
			if ($ok) {
				Minz_Session::_param('currentUser', $username);
				Minz_Session::_param('passwordHash', $s);
				FreshRSS_Auth::giveAccess();

				Minz_Request::good(_t('login'),
				                   array('c' => 'index', 'a' => 'index'));
			} else {
				Minz_Log::warning('Unsafe password mismatch for user ' . $username);
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

	/**
	 * This action resets the authentication system.
	 *
	 * After reseting, form auth is set by default.
	 */
	public function resetAction() {
		Minz_View::prependTitle(_t('auth_reset') . ' · ');

		Minz_View::appendScript(Minz_Url::display(
			'/scripts/bcrypt.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/bcrypt.min.js')
		));

		$this->view->no_form = false;
		// Enable changement of auth only if Persona!
		if (Minz_Configuration::authType() != 'persona') {
			$this->view->message = array(
				'status' => 'bad',
				'title' => _t('damn'),
				'body' => _t('auth_not_persona')
			);
			$this->view->no_form = true;
			return;
		}

		$conf = new FreshRSS_Configuration(Minz_Configuration::defaultUser());
		// Admin user must have set its master password.
		if (!$conf->passwordHash) {
			$this->view->message = array(
				'status' => 'bad',
				'title' => _t('damn'),
				'body' => _t('auth_no_password_set')
			);
			$this->view->no_form = true;
			return;
		}

		invalidateHttpCache();

		if (Minz_Request::isPost()) {
			$nonce = Minz_Session::param('nonce');
			$username = Minz_Request::param('username', '');
			$challenge = Minz_Request::param('challenge', '');

			$ok = FreshRSS_FormAuth::checkCredentials(
				$username, $conf->passwordHash, $nonce, $challenge
			);

			if ($ok) {
				Minz_Configuration::_authType('form');
				$ok = Minz_Configuration::writeFile();

				if ($ok) {
					Minz_Request::good(_t('auth_form_set'));
				} else {
					Minz_Request::bad(_t('auth_form_not_set'),
				                      array('c' => 'auth', 'a' => 'reset'));
				}
			} else {
				Minz_Log::warning('Password mismatch for' .
				                  ' user=' . $username .
				                  ', nonce=' . $nonce .
				                  ', c=' . $challenge);
				Minz_Request::bad(_t('invalid_login'),
				                  array('c' => 'auth', 'a' => 'reset'));
			}
		}
	}
}
