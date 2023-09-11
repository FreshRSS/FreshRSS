<?php

/**
 * This controller handles action about authentication.
 */
class FreshRSS_auth_Controller extends FreshRSS_ActionController {
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
	 */
	public function indexAction(): void {
		if (!FreshRSS_Auth::hasAccess('admin')) {
			Minz_Error::error(403);
		}

		FreshRSS_View::prependTitle(_t('admin.auth.title') . ' · ');

		if (Minz_Request::isPost()) {
			$ok = true;

			$anon = Minz_Request::paramBoolean('anon_access');
			$anon_refresh = Minz_Request::paramBoolean('anon_refresh');
			$auth_type = Minz_Request::paramString('auth_type') ?: 'none';
			$unsafe_autologin = Minz_Request::paramBoolean('unsafe_autologin');
			$api_enabled = Minz_Request::paramBoolean('api_enabled');
			if ($anon !== FreshRSS_Context::$system_conf->allow_anonymous ||
				$auth_type !== FreshRSS_Context::$system_conf->auth_type ||
				$anon_refresh !== FreshRSS_Context::$system_conf->allow_anonymous_refresh ||
				$unsafe_autologin !== FreshRSS_Context::$system_conf->unsafe_autologin_enabled ||
				$api_enabled !== FreshRSS_Context::$system_conf->api_enabled) {

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
				Minz_Request::good(_t('feedback.conf.updated'), [ 'c' => 'auth', 'a' => 'index' ]);
			} else {
				Minz_Request::bad(_t('feedback.conf.error'), [ 'c' => 'auth', 'a' => 'index' ]);
			}
		}
	}

	/**
	 * This action handles the login page.
	 *
	 * It forwards to the correct login page (form) or main page if
	 * the user is already connected.
	 * @throws Minz_ConfigurationParamException
	 */
	public function loginAction(): void {
		if (FreshRSS_Auth::hasAccess() && Minz_Request::paramString('u') === '') {
			Minz_Request::forward(['c' => 'index', 'a' => 'index'], true);
		}

		$auth_type = FreshRSS_Context::$system_conf->auth_type;
		FreshRSS_Context::initUser(Minz_User::INTERNAL_USER, false);
		switch ($auth_type) {
			case 'form':
				Minz_Request::forward(['c' => 'auth', 'a' => 'formLogin']);
				break;
			case 'http_auth':
				Minz_Error::error(403, [
					'error' => [
						_t('feedback.access.denied'),
						' [HTTP Remote-User=' . htmlspecialchars(httpAuthUser(false), ENT_NOQUOTES, 'UTF-8') .
						' ; Remote IP address=' . connectionRemoteAddress() . ']'
					]
				], false);
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
	 * @throws Exception
	 */
	public function formLoginAction(): void {
		invalidateHttpCache();

		FreshRSS_View::prependTitle(_t('gen.auth.login') . ' · ');
		FreshRSS_View::appendScript(Minz_Url::display('/scripts/bcrypt.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/bcrypt.min.js')));

		$limits = FreshRSS_Context::$system_conf->limits;
		$this->view->cookie_days = (int)round($limits['cookie_duration'] / 86400, 1);

		$isPOST = Minz_Request::isPost() && !Minz_Session::param('POST_to_GET');
		Minz_Session::_param('POST_to_GET');

		if ($isPOST) {
			$nonce = Minz_Session::param('nonce', '');
			$username = Minz_Request::paramString('username');
			$challenge = Minz_Request::paramString('challenge');

			usleep(random_int(100, 10000));	//Primitive mitigation of timing attacks, in μs

			FreshRSS_Context::initUser($username);
			if (FreshRSS_Context::$user_conf == null) {
				// Initialise the default user to be able to display the error page
				FreshRSS_Context::initUser(FreshRSS_Context::$system_conf->default_user);
				Minz_Error::error(403, _t('feedback.auth.login.invalid'), false);
				return;
			}

			if (!FreshRSS_Context::$user_conf->enabled || FreshRSS_Context::$user_conf->passwordHash == '') {
				usleep(random_int(100, 5000));	//Primitive mitigation of timing attacks, in μs
				Minz_Error::error(403, _t('feedback.auth.login.invalid'), false);
				return;
			}

			$ok = FreshRSS_FormAuth::checkCredentials(
				$username, FreshRSS_Context::$user_conf->passwordHash, $nonce, $challenge
			);
			if ($ok) {
				// Set session parameter to give access to the user.
				Minz_Session::_params([
					Minz_User::CURRENT_USER => $username,
					'passwordHash' => FreshRSS_Context::$user_conf->passwordHash,
					'csrf' => false,
				]);
				FreshRSS_Auth::giveAccess();

				// Set cookie parameter if needed.
				if (Minz_Request::paramBoolean('keep_logged_in')) {
					FreshRSS_FormAuth::makeCookie($username, FreshRSS_Context::$user_conf->passwordHash);
				} else {
					FreshRSS_FormAuth::deleteCookie();
				}

				Minz_Translate::init(FreshRSS_Context::$user_conf->language);

				// All is good, go back to the original request or the index.
				$url = Minz_Url::unserialize(Minz_Request::paramString('original_request'));
				if (empty($url)) {
					$url = [ 'c' => 'index', 'a' => 'index' ];
				}
				Minz_Request::good(_t('feedback.auth.login.success'), $url);
			} else {
				Minz_Log::warning("Password mismatch for user={$username}, nonce={$nonce}, c={$challenge}");

				header('HTTP/1.1 403 Forbidden');
				Minz_Session::_param('POST_to_GET', true);	//Prevent infinite internal redirect
				Minz_Request::setBadNotification(_t('feedback.auth.login.invalid'));
				Minz_Request::forward(['c' => 'auth', 'a' => 'login'], false);
			}
		} elseif (FreshRSS_Context::$system_conf->unsafe_autologin_enabled) {
			$username = Minz_Request::paramString('u');
			$password = Minz_Request::paramString('p');
			Minz_Request::_param('p');

			if (!$username) {
				return;
			}

			FreshRSS_FormAuth::deleteCookie();

			FreshRSS_Context::initUser($username);
			if (FreshRSS_Context::$user_conf == null) {
				return;
			}

			$s = FreshRSS_Context::$user_conf->passwordHash;
			$ok = password_verify($password, $s);
			unset($password);
			if ($ok) {
				Minz_Session::_params([
					Minz_User::CURRENT_USER => $username,
					'passwordHash' => $s,
					'csrf' => false,
				]);
				FreshRSS_Auth::giveAccess();

				Minz_Translate::init(FreshRSS_Context::$user_conf->language);

				Minz_Request::good(_t('feedback.auth.login.success'), ['c' => 'index', 'a' => 'index']);
			} else {
				Minz_Log::warning('Unsafe password mismatch for user ' . $username);
				Minz_Request::bad(
					_t('feedback.auth.login.invalid'),
					['c' => 'auth', 'a' => 'login']
				);
			}
		}
	}

	/**
	 * This action removes all accesses of the current user.
	 */
	public function logoutAction(): void {
		invalidateHttpCache();
		FreshRSS_Auth::removeAccess();
		Minz_Request::good(_t('feedback.auth.logout.success'), [ 'c' => 'index', 'a' => 'index' ]);
	}

	/**
	 * This action gives possibility to a user to create an account.
	 *
	 * The user is redirected to the home when logged in.
	 *
	 * A 403 is sent if max number of registrations is reached.
	 */
	public function registerAction(): void {
		if (FreshRSS_Auth::hasAccess()) {
			Minz_Request::forward(['c' => 'index', 'a' => 'index'], true);
		}

		if (max_registrations_reached()) {
			Minz_Error::error(403);
		}

		$this->view->show_tos_checkbox = file_exists(TOS_FILENAME);
		$this->view->show_email_field = FreshRSS_Context::$system_conf->force_email_validation;
		$this->view->preferred_language = Minz_Translate::getLanguage(null, Minz_Request::getPreferredLanguages(), FreshRSS_Context::$system_conf->language);
		FreshRSS_View::prependTitle(_t('gen.auth.registration.title') . ' · ');
	}
}
