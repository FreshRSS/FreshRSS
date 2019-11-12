<?php

namespace Freshrss\Controllers;

/**
 * This controller handles action about authentication.
 */
class auth_Controller extends ActionController {
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
		if (!Auth::hasAccess('admin')) {
			Error::error(403);
		}

		View::prependTitle(_t('admin.auth.title') . ' · ');

		if (Request::isPost()) {
			$ok = true;

			$anon = Request::param('anon_access', false);
			$anon = ((bool)$anon) && ($anon !== 'no');
			$anon_refresh = Request::param('anon_refresh', false);
			$anon_refresh = ((bool)$anon_refresh) && ($anon_refresh !== 'no');
			$auth_type = Request::param('auth_type', 'none');
			$unsafe_autologin = Request::param('unsafe_autologin', false);
			$api_enabled = Request::param('api_enabled', false);
			if ($anon != Context::$system_conf->allow_anonymous ||
				$auth_type != Context::$system_conf->auth_type ||
				$anon_refresh != Context::$system_conf->allow_anonymous_refresh ||
				$unsafe_autologin != Context::$system_conf->unsafe_autologin_enabled ||
				$api_enabled != Context::$system_conf->api_enabled) {

				// TODO: test values from form
				Context::$system_conf->auth_type = $auth_type;
				Context::$system_conf->allow_anonymous = $anon;
				Context::$system_conf->allow_anonymous_refresh = $anon_refresh;
				Context::$system_conf->unsafe_autologin_enabled = $unsafe_autologin;
				Context::$system_conf->api_enabled = $api_enabled;

				$ok &= Context::$system_conf->save();
			}

			invalidateHttpCache();

			if ($ok) {
				Request::good(_t('feedback.conf.updated'),
				                   array('c' => 'auth', 'a' => 'index'));
			} else {
				Request::bad(_t('feedback.conf.error'),
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
		if (Auth::hasAccess() && Request::param('u', '') == '') {
			Request::forward(array('c' => 'index', 'a' => 'index'), true);
		}

		$auth_type = Context::$system_conf->auth_type;
		switch ($auth_type) {
		case 'form':
			Request::forward(array('c' => 'auth', 'a' => 'formLogin'));
			break;
		case 'http_auth':
			Error::error(403, array('error' => array(_t('feedback.access.denied'),
					' [HTTP Remote-User=' . htmlspecialchars(httpAuthUser(), ENT_NOQUOTES, 'UTF-8') . ']'
				)), false);
			break;
		case 'none':
			// It should not happen!
			Error::error(404);
		default:
			// TODO load plugin instead
			Error::error(404);
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

		View::appendScript(Minz_Url::display('/scripts/bcrypt.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/bcrypt.min.js')));

		$conf = Configuration::get('system');
		$limits = $conf->limits;
		$this->view->cookie_days = round($limits['cookie_duration'] / 86400, 1);

		if (Request::isPost()) {
			$nonce = Session::param('nonce');
			$username = Request::param('username', '');
			$challenge = Request::param('challenge', '');

			$conf = get_user_configuration($username);
			if ($conf == null) {
				Error::error(403, array(_t('feedback.auth.login.invalid')), false);
				return;
			}

			$ok = FormAuth::checkCredentials(
				$username, $conf->passwordHash, $nonce, $challenge
			);
			if ($ok) {
				// Set session parameter to give access to the user.
				Session::_param('currentUser', $username);
				Session::_param('passwordHash', $conf->passwordHash);
				Session::_param('csrf');
				Auth::giveAccess();

				// Set cookie parameter if nedded.
				if (Request::param('keep_logged_in')) {
					FormAuth::makeCookie($username, $conf->passwordHash);
				} else {
					FormAuth::deleteCookie();
				}

				// All is good, go back to the index.
				Request::good(_t('feedback.auth.login.success'),
				                   array('c' => 'index', 'a' => 'index'));
			} else {
				Log::warning('Password mismatch for' .
				                  ' user=' . $username .
				                  ', nonce=' . $nonce .
				                  ', c=' . $challenge);
				Error::error(403, array(_t('feedback.auth.login.invalid')), false);
			}
		} elseif (Context::$system_conf->unsafe_autologin_enabled) {
			$username = Request::param('u', '');
			$password = Request::param('p', '');
			Request::_param('p');

			if (!$username) {
				return;
			}

			FormAuth::deleteCookie();

			$conf = get_user_configuration($username);
			if ($conf == null) {
				return;
			}

			$s = $conf->passwordHash;
			$ok = password_verify($password, $s);
			unset($password);
			if ($ok) {
				Session::_param('currentUser', $username);
				Session::_param('passwordHash', $s);
				Session::_param('csrf');
				Auth::giveAccess();

				Request::good(_t('feedback.auth.login.success'),
				                   array('c' => 'index', 'a' => 'index'));
			} else {
				Log::warning('Unsafe password mismatch for user ' . $username);
				Error::error(403, array(_t('feedback.auth.login.invalid')), false);
			}
		}
	}

	/**
	 * This action removes all accesses of the current user.
	 */
	public function logoutAction() {
		invalidateHttpCache();
		Auth::removeAccess();
		Request::good(_t('feedback.auth.logout.success'),
		                   array('c' => 'index', 'a' => 'index'));
	}

	/**
	 * This action gives possibility to a user to create an account.
	 *
	 * The user is redirected to the home if he's connected.
	 *
	 * A 403 is sent if max number of registrations is reached.
	 */
	public function registerAction() {
		if (Auth::hasAccess()) {
			Request::forward(array('c' => 'index', 'a' => 'index'), true);
		}

		if (max_registrations_reached()) {
			Error::error(403);
		}

		$this->view->show_tos_checkbox = file_exists(join_path(DATA_PATH, 'tos.html'));
		$this->view->show_email_field = Context::$system_conf->force_email_validation;
		View::prependTitle(_t('gen.auth.registration.title') . ' · ');
	}
}
