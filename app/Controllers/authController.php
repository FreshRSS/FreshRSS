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
			Minz_Error::error(403);
		}

		Minz_View::prependTitle(_t('admin.auth.title') . ' · ');

		if (Minz_Request::isPost()) {
			$ok = true;

			$general = FreshRSS_Context::$system_conf->general;
			$current_token = FreshRSS_Context::$user_conf->token;
			$token = Minz_Request::param('token', $current_token);
			FreshRSS_Context::$user_conf->_token($token);
			$ok &= FreshRSS_Context::$user_conf->save();

			$anon = Minz_Request::param('anon_access', false);
			$anon = ((bool)$anon) && ($anon !== 'no');
			$anon_refresh = Minz_Request::param('anon_refresh', false);
			$anon_refresh = ((bool)$anon_refresh) && ($anon_refresh !== 'no');
			$auth_type = Minz_Request::param('auth_type', 'none');
			$unsafe_autologin = Minz_Request::param('unsafe_autologin', false);
			$api_enabled = Minz_Request::param('api_enabled', false);
			if ($anon != $general['allow_anonymous'] ||
				$auth_type != $general['auth_type'] ||
				$anon_refresh != $general['allow_anonymous_refresh'] ||
				$unsafe_autologin != $general['unsafe_autologin_enabled'] ||
				$api_enabled != $general['api_enabled']) {

				// TODO: test values from form
				$general['auth_type'] = $auth_type;
				$general['allow_anonymous'] = $anon;
				$general['allow_anonymous_refresh'] = $anon_refresh;
				$general['unsafe_autologin_enabled'] = $unsafe_autologin;
				$general['api_enabled'] = $api_enabled;

				$system_conf->general = $general;
				$ok &= $system_conf->save();
			}

			invalidateHttpCache();

			if ($ok) {
				Minz_Request::good(_t('feedback.conf.updated'),
				                   array('c' => 'auth', 'a' => 'index'));
			} else {
				Minz_Request::bad(_t('feedback.conf.error'),
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

		$auth_type = FreshRSS_Context::$system_conf->general['auth_type'];
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

			// TODO #730: change the way to get the configuration
			try {
				$conf = new FreshRSS_Configuration($username);
			} catch(Minz_Exception $e) {
				// $username is not a valid user, nor the configuration file!
				Minz_Log::warning('Login failure: ' . $e->getMessage());
				Minz_Request::bad(_t('feedback.auth.login.invalid'),
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
				Minz_Request::good(_t('feedback.auth.login.success'),
				                   array('c' => 'index', 'a' => 'index'));
			} else {
				Minz_Log::warning('Password mismatch for' .
				                  ' user=' . $username .
				                  ', nonce=' . $nonce .
				                  ', c=' . $challenge);
				Minz_Request::bad(_t('feedback.auth.login.invalid'),
				                  array('c' => 'auth', 'a' => 'login'));
			}
		} elseif (FreshRSS_Context::$system_conf->general['unsafe_autologin_enabled']) {
			$username = Minz_Request::param('u', '');
			$password = Minz_Request::param('p', '');
			Minz_Request::_param('p');

			if (!$username) {
				return;
			}

			// TODO #730: change the way to get the configuration
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

				Minz_Request::good(_t('feedback.auth.login.success'),
				                   array('c' => 'index', 'a' => 'index'));
			} else {
				Minz_Log::warning('Unsafe password mismatch for user ' . $username);
				Minz_Request::bad(_t('feedback.auth.login.invalid'),
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
						// TODO #730: change the way to get the configuration
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
				$res['reason'] = _t('feedback.auth.login.invalid');
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
		Minz_Request::good(_t('feedback.auth.logout.success'),
		                   array('c' => 'index', 'a' => 'index'));
	}

	/**
	 * This action resets the authentication system.
	 *
	 * After reseting, form auth is set by default.
	 */
	public function resetAction() {
		Minz_View::prependTitle(_t('admin.auth.title_reset') . ' · ');

		Minz_View::appendScript(Minz_Url::display(
			'/scripts/bcrypt.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/bcrypt.min.js')
		));

		$this->view->no_form = false;
		// Enable changement of auth only if Persona!
		if (FreshRSS_Context::$system_conf->general['auth_type'] != 'persona') {
			$this->view->message = array(
				'status' => 'bad',
				'title' => _t('gen.short.damn'),
				'body' => _t('feedback.auth.not_persona')
			);
			$this->view->no_form = true;
			return;
		}

		// TODO #730
		$conf = new FreshRSS_Configuration(Minz_Configuration::defaultUser());
		// Admin user must have set its master password.
		if (!$conf->passwordHash) {
			$this->view->message = array(
				'status' => 'bad',
				'title' => _t('gen.short.damn'),
				'body' => _t('feedback.auth.no_password_set')
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
				// TODO #730
				Minz_Configuration::_authType('form');
				$ok = Minz_Configuration::writeFile();

				if ($ok) {
					Minz_Request::good(_t('feedback.auth.form.set'));
				} else {
					Minz_Request::bad(_t('feedback.auth.form.not_set'),
				                      array('c' => 'auth', 'a' => 'reset'));
				}
			} else {
				Minz_Log::warning('Password mismatch for' .
				                  ' user=' . $username .
				                  ', nonce=' . $nonce .
				                  ', c=' . $challenge);
				Minz_Request::bad(_t('feedback.auth.login.invalid'),
				                  array('c' => 'auth', 'a' => 'reset'));
			}
		}
	}
}
