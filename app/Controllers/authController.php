<?php

use Minz\Controller\ActionController;

/**
 * This controller handles action about authentication.
 */
class FreshRSS_auth_Controller extends ActionController {
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
			Minz\Error::error(403);
		}

		Minz\View::prependTitle(_t('admin.auth.title') . ' · ');

		if (Minz\Request::isPost()) {
			$ok = true;

			$anon = Minz\Request::param('anon_access', false);
			$anon = ((bool)$anon) && ($anon !== 'no');
			$anon_refresh = Minz\Request::param('anon_refresh', false);
			$anon_refresh = ((bool)$anon_refresh) && ($anon_refresh !== 'no');
			$auth_type = Minz\Request::param('auth_type', 'none');
			$unsafe_autologin = Minz\Request::param('unsafe_autologin', false);
			$api_enabled = Minz\Request::param('api_enabled', false);
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
				Minz\Request::good(_t('feedback.conf.updated'),
				                   array('c' => 'auth', 'a' => 'index'));
			} else {
				Minz\Request::bad(_t('feedback.conf.error'),
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
		if (FreshRSS_Auth::hasAccess() && Minz\Request::param('u', '') == '') {
			Minz\Request::forward(array('c' => 'index', 'a' => 'index'), true);
		}

		$auth_type = FreshRSS_Context::$system_conf->auth_type;
		switch ($auth_type) {
		case 'form':
			Minz\Request::forward(array('c' => 'auth', 'a' => 'formLogin'));
			break;
		case 'http_auth':
			Minz\Error::error(403, array('error' => array(_t('feedback.access.denied'),
					' [HTTP Remote-User=' . htmlspecialchars(httpAuthUser(), ENT_NOQUOTES, 'UTF-8') . ']'
				)), false);
			break;
		case 'none':
			// It should not happen!
			Minz\Error::error(404);
		default:
			// TODO load plugin instead
			Minz\Error::error(404);
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

		Minz\View::prependTitle(_t('gen.auth.login') . ' · ');
		Minz\View::appendScript(Minz\Url::display('/scripts/bcrypt.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/bcrypt.min.js')));

		$conf = Minz\Configuration::get('system');
		$limits = $conf->limits;
		$this->view->cookie_days = round($limits['cookie_duration'] / 86400, 1);

		$isPOST = Minz\Request::isPost() && !Minz\Session::param('POST_to_GET');
		Minz\Session::_param('POST_to_GET');

		if ($isPOST) {
			$nonce = Minz\Session::param('nonce');
			$username = Minz\Request::param('username', '');
			$challenge = Minz\Request::param('challenge', '');

			$conf = get_user_configuration($username);
			if ($conf == null) {
				//We do not test here whether the user exists, so most likely an internal error.
				Minz\Error::error(403, array(_t('feedback.auth.login.invalid')), false);
				return;
			}

			if (!$conf->enabled) {
				Minz\Error::error(403, array(_t('feedback.auth.login.invalid')), false);
				return;
			}

			$ok = FreshRSS_FormAuth::checkCredentials(
				$username, $conf->passwordHash, $nonce, $challenge
			);
			if ($ok) {
				// Set session parameter to give access to the user.
				Minz\Session::_params([
					'currentUser' => $username,
					'passwordHash' => $conf->passwordHash,
					'csrf' => false,
				]);
				FreshRSS_Auth::giveAccess();

				// Set cookie parameter if nedded.
				if (Minz\Request::param('keep_logged_in')) {
					FreshRSS_FormAuth::makeCookie($username, $conf->passwordHash);
				} else {
					FreshRSS_FormAuth::deleteCookie();
				}

				Minz\Translate::init($conf->language);

				// All is good, go back to the index.
				Minz\Request::good(_t('feedback.auth.login.success'),
				                   array('c' => 'index', 'a' => 'index'));
			} else {
				Minz\Log::warning('Password mismatch for' .
				                  ' user=' . $username .
				                  ', nonce=' . $nonce .
				                  ', c=' . $challenge);

				header('HTTP/1.1 403 Forbidden');
				Minz\Session::_param('POST_to_GET', true);	//Prevent infinite internal redirect
				Minz\Request::setBadNotification(_t('feedback.auth.login.invalid'));
				Minz\Request::forward(['c' => 'auth', 'a' => 'login'], false);
				return;
			}
		} elseif (FreshRSS_Context::$system_conf->unsafe_autologin_enabled) {
			$username = Minz\Request::param('u', '');
			$password = Minz\Request::param('p', '');
			Minz\Request::_param('p');

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
				Minz\Session::_params([
					'currentUser' => $username,
					'passwordHash' => $s,
					'csrf' => false,
				]);
				FreshRSS_Auth::giveAccess();

				Minz\Translate::init($conf->language);

				Minz\Request::good(_t('feedback.auth.login.success'),
				                   array('c' => 'index', 'a' => 'index'));
			} else {
				Minz\Log::warning('Unsafe password mismatch for user ' . $username);
				Minz\Request::bad(
					_t('feedback.auth.login.invalid'),
					array('c' => 'auth', 'a' => 'login')
				);
			}
		}
	}

	/**
	 * This action removes all accesses of the current user.
	 */
	public function logoutAction() {
		invalidateHttpCache();
		FreshRSS_Auth::removeAccess();
		Minz\Request::good(_t('feedback.auth.logout.success'),
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
		if (FreshRSS_Auth::hasAccess()) {
			Minz\Request::forward(array('c' => 'index', 'a' => 'index'), true);
		}

		if (max_registrations_reached()) {
			Minz\Error::error(403);
		}

		$this->view->show_tos_checkbox = file_exists(join_path(DATA_PATH, 'tos.html'));
		$this->view->show_email_field = FreshRSS_Context::$system_conf->force_email_validation;
		$this->view->preferred_language = Minz\Translate::getLanguage(null, Minz\Request::getPreferredLanguages(), FreshRSS_Context::$system_conf->language);
		Minz\View::prependTitle(_t('gen.auth.registration.title') . ' · ');
	}
}
