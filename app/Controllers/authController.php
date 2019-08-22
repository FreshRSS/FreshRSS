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

			$anon = Minz_Request::param('anon_access', false);
			$anon = ((bool)$anon) && ($anon !== 'no');
			$anon_refresh = Minz_Request::param('anon_refresh', false);
			$anon_refresh = ((bool)$anon_refresh) && ($anon_refresh !== 'no');
			$auth_type = Minz_Request::param('auth_type', 'none');
			$unsafe_autologin = Minz_Request::param('unsafe_autologin', false);
			$api_enabled = Minz_Request::param('api_enabled', false);
			if ($anon != FreshRSS_Context::$system_conf->allow_anonymous ||
				$auth_type != FreshRSS_Context::$system_conf->auth_type ||
				$anon_refresh != FreshRSS_Context::$system_conf->allow_anonymous_refresh ||
				$unsafe_autologin != FreshRSS_Context::$system_conf->unsafe_autologin_enabled ||
				$api_enabled != FreshRSS_Context::$system_conf->api_enabled) {

				// TODO: test values from form
				FreshRSS_Context::$system_conf->auth_type = $auth_type;
				FreshRSS_Context::$system_conf->allow_anonymous = $anon;
				FreshRSS_Context::$system_conf->allow_anonymous_refresh = $anon_refresh;
				FreshRSS_Context::$system_conf->unsafe_autologin_enabled = $unsafe_autologin;
				FreshRSS_Context::$system_conf->api_enabled = $api_enabled;

				$ok &= FreshRSS_Context::$system_conf->save();
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
	 * It forwards to the correct login page (form) or main page if
	 * the user is already connected.
	 */
	public function loginAction() {
		if (FreshRSS_Auth::hasAccess() && Minz_Request::param('u', '') == '') {
			Minz_Request::forward(array('c' => 'index', 'a' => 'index'), true);
		}

		$auth_type = FreshRSS_Context::$system_conf->auth_type;
		switch ($auth_type) {
		case 'form':
			Minz_Request::forward(array('c' => 'auth', 'a' => 'formLogin'));
			break;
		case 'http_auth':
			Minz_Error::error(403, array('error' => array(_t('feedback.access.denied'),
					' [HTTP Remote-User=' . htmlspecialchars(httpAuthUser(), ENT_NOQUOTES, 'UTF-8') . ']'
				)), false);
			break;
		case 'none':
			// It should not happen!
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

		Minz_View::appendScript(Minz_Url::display('/scripts/bcrypt.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/bcrypt.min.js')));

		$conf = Minz_Configuration::get('system');
		$limits = $conf->limits;
		$this->view->cookie_days = round($limits['cookie_duration'] / 86400, 1);

		if (Minz_Request::isPost()) {
			$nonce = Minz_Session::param('nonce');
			$username = Minz_Request::param('username', '');
			$challenge = Minz_Request::param('challenge', '');

			$conf = get_user_configuration($username);
			if ($conf == null) {
				Minz_Error::error(403, array(_t('feedback.auth.login.invalid')), false);
				return;
			}

			$ok = FreshRSS_FormAuth::checkCredentials(
				$username, $conf->passwordHash, $nonce, $challenge
			);
			if ($ok) {
				// Set session parameter to give access to the user.
				Minz_Session::_param('currentUser', $username);
				Minz_Session::_param('passwordHash', $conf->passwordHash);
				Minz_Session::_param('csrf');
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
				Minz_Error::error(403, array(_t('feedback.auth.login.invalid')), false);
			}
		} elseif (FreshRSS_Context::$system_conf->unsafe_autologin_enabled) {
			$username = Minz_Request::param('u', '');
			$password = Minz_Request::param('p', '');
			Minz_Request::_param('p');

			if (!$username) {
				return;
			}

			FreshRSS_FormAuth::deleteCookie();

			$conf = get_user_configuration($username);
			if ($conf == null) {
				return;
			}

			$s = $conf->passwordHash;
			$ok = password_verify($password, $s);
			unset($password);
			if ($ok) {
				Minz_Session::_param('currentUser', $username);
				Minz_Session::_param('passwordHash', $s);
				Minz_Session::_param('csrf');
				FreshRSS_Auth::giveAccess();

				Minz_Request::good(_t('feedback.auth.login.success'),
				                   array('c' => 'index', 'a' => 'index'));
			} else {
				Minz_Log::warning('Unsafe password mismatch for user ' . $username);
				Minz_Error::error(403, array(_t('feedback.auth.login.invalid')), false);
			}
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
	 * This action gives possibility to a user to create an account.
	 */
	public function registerAction() {
		if (max_registrations_reached()) {
			Minz_Error::error(403);
		}

		Minz_View::prependTitle(_t('gen.auth.registration.title') . ' · ');
	}
}
