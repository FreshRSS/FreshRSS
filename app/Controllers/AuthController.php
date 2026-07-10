<?php
declare(strict_types=1);

namespace FreshRss\Controllers;

use FreshRss\Minz\Error;
use FreshRss\Minz\Log;
use FreshRss\Minz\Request;
use FreshRss\Minz\Session;
use FreshRss\Minz\Translate;
use FreshRss\Minz\Url;
use FreshRss\Minz\User;
use FreshRss\Models\ActionController;
use FreshRss\Models\Auth;
use FreshRss\Models\Context;
use FreshRss\Models\FormAuth;
use FreshRss\Models\UserDAO;
use FreshRss\Models\View;
use FreshRss\Utils\HttpUtil;

/**
 * This controller handles action about authentication.
 */
class AuthController extends ActionController {
	/**
	 * This action handles authentication management page.
	 *
	 * Parameters are:
	 *   - token (default: current token)
	 *   - anon_access (default: false)
	 *   - anon_refresh (default: false)
	 *   - auth_type (default: none)
	 *   - api_enabled (default: false)
	 */
	public function indexAction(): void {
		if (!Auth::hasAccess('admin')) {
			Error::error(403);
		}

		if (Auth::requestReauth()) {
			return;
		}

		View::prependTitle(_t('admin.auth.title') . ' · ');

		if (Request::isPost()) {
			$ok = true;

			$anon = Request::paramBoolean('anon_access');
			$anon_refresh = Request::paramBoolean('anon_refresh');
			$auth_type = Request::paramString('auth_type') ?: 'form';
			$api_enabled = Request::paramBoolean('api_enabled');
			if ($anon !== Context::systemConf()->allow_anonymous ||
				$auth_type !== Context::systemConf()->auth_type ||
				$anon_refresh !== Context::systemConf()->allow_anonymous_refresh ||
				$api_enabled !== Context::systemConf()->api_enabled) {
				if (in_array($auth_type, ['form', 'http_auth', 'none'], true)) {
					Context::systemConf()->auth_type = $auth_type;
				} else {
					Context::systemConf()->auth_type = 'form';
				}
				Context::systemConf()->allow_anonymous = $anon;
				Context::systemConf()->allow_anonymous_refresh = $anon_refresh;
				Context::systemConf()->api_enabled = $api_enabled;

				$ok &= Context::systemConf()->save();
			}

			invalidateHttpCache();

			if ($ok) {
				Request::good(
					_t('feedback.conf.updated'),
					[ 'c' => 'auth', 'a' => 'index' ],
					showNotification: Context::userConf()->good_notification_timeout > 0
				);
			} else {
				Request::bad(_t('feedback.conf.error'), [ 'c' => 'auth', 'a' => 'index' ]);
			}
		}
	}

	/**
	 * This action handles the login page.
	 *
	 * It forwards to the correct login page (form) or main page if
	 * the user is already connected.
	 */
	public function loginAction(): void {
		if (Auth::hasAccess()) {
			Request::forward(['c' => 'index', 'a' => 'index'], true);
		}

		$auth_type = Context::systemConf()->auth_type;
		Context::initUser(User::INTERNAL_USER, false);
		match ($auth_type) {
			'form' => Request::forward(['c' => 'auth', 'a' => 'formLogin']),
			'http_auth' => Error::error(403, [
					'error' => [
						_t('feedback.access.denied'),
						' [HTTP Remote-User=' . htmlspecialchars(HttpUtil::httpAuthUser(onlyTrusted: false), ENT_NOQUOTES, 'UTF-8') .
						' ; Remote IP address=' . Request::connectionRemoteAddress() . ']'
					]
				], false),
			'none' => Error::error(404),	// It should not happen!
			default => Error::error(404),	// TODO load plugin instead
		};
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
	 * @throws \Exception
	 */
	public function formLoginAction(): void {
		invalidateHttpCache();

		View::prependTitle(_t('gen.auth.login') . ' · ');
		View::appendScript(Url::display('/scripts/vendor/bcrypt.js?' . @filemtime(PUBLIC_PATH . '/scripts/vendor/bcrypt.js')));

		$limits = Context::systemConf()->limits;
		$this->view->cookie_days = (int)round($limits['cookie_duration'] / 86400, 1);

		$isPOST = Request::isPost() && !Session::paramBoolean('POST_to_GET');
		Session::_param('POST_to_GET');

		if ($isPOST) {
			$nonce = Session::paramString('nonce');
			$username = Request::paramString('username');
			$challenge = Request::paramString('challenge');

			$ip_address = Request::connectionRemoteAddress();

			if ($nonce === '') {
				Log::warning("Invalid session during login for user={$username}, nonce={$nonce}, ip_address={$ip_address}");
				header('HTTP/1.1 403 Forbidden');
				Session::_param('POST_to_GET', true);	//Prevent infinite internal redirect
				Request::setBadNotification(_t('install.session.nok'));
				Request::forward(['c' => 'auth', 'a' => 'login'], false);
				return;
			}

			usleep(random_int(100, 10000));	//Primitive mitigation of timing attacks, in μs

			Context::initUser($username);
			if (!Context::hasUserConf()) {
				// Initialise the default user to be able to display the error page
				Context::initUser(Context::systemConf()->default_user);
				Error::error(403, _t('feedback.auth.login.invalid'), false);
				return;
			}

			if (!Context::userConf()->enabled || Context::userConf()->passwordHash == '') {
				usleep(random_int(100, 5000));	//Primitive mitigation of timing attacks, in μs
				Error::error(403, _t('feedback.auth.login.invalid'), false);
				return;
			}

			$ok = FormAuth::checkCredentials(
				$username, Context::userConf()->passwordHash, $nonce, $challenge
			);
			if ($ok) {
				// Set session parameter to give access to the user.
				Session::regenerateID('FreshRSS');
				Session::_params([
					User::CURRENT_USER => $username,
					'passwordHash' => Context::userConf()->passwordHash,
					'csrf' => false,
				]);
				Auth::giveAccess();

				// Set cookie parameter if needed.
				if (Request::paramBoolean('keep_logged_in')) {
					FormAuth::makeCookie($username, Context::userConf()->passwordHash);
				} else {
					FormAuth::deleteCookie();
				}

				Translate::init(Context::userConf()->language);

				UserDAO::touch();

				// All is good, go back to the original request or the index.
				$url = Url::unserialize(Request::paramString('original_request'));
				if (empty($url)) {
					$url = [ 'c' => 'index', 'a' => 'index' ];
				}
				Request::good(
					_t('feedback.auth.login.success'),
					$url,
					showNotification: Context::userConf()->good_notification_timeout > 0
				);
			} else {
				Log::warning("Password mismatch for user={$username}, nonce={$nonce}, c={$challenge}, ip_address={$ip_address}");
				header('HTTP/1.1 403 Forbidden');
				Session::_param('POST_to_GET', true);	//Prevent infinite internal redirect
				Request::setBadNotification(_t('feedback.auth.login.invalid'));
				Request::forward(['c' => 'auth', 'a' => 'login'], false);
			}
		} else {
			Session::deleteLegacyCookie('FreshRSS');	// Delete legacy cookie (before 1.29.0)
		}
	}

	public function reauthAction(): void {
		if (!Auth::hasAccess()) {
			Error::error(403);
			return;
		}
		/** @var array{c?: string, a?: string, params?: array<string, mixed>} $redirect */
		$redirect = Url::unserialize(Request::paramString('r'));
		if (!Auth::needsReauth()) {
			Request::forward($redirect, true);
			return;
		}
		if (Request::isPost()) {
			$username = User::name() ?? '';
			$nonce = Session::paramString('nonce');
			$challenge = Request::paramString('challenge');
			if (!FormAuth::checkCredentials(
				$username, Context::userConf()->passwordHash, $nonce, $challenge
				)) {
				Request::setBadNotification(_t('feedback.auth.login.invalid'));
			} else {
				Session::regenerateID('FreshRSS');
				Session::_param('lastReauth', time());
				Request::forward($redirect, true);
				return;
			}
		}
		View::prependTitle(_t('gen.auth.reauth.title') . ' · ');
		View::appendScript(Url::display('/scripts/vendor/bcrypt.js?' . @filemtime(PUBLIC_PATH . '/scripts/vendor/bcrypt.js')));
	}

	/**
	 * This action removes all accesses of the current user.
	 */
	public function logoutAction(): void {
		if (Request::isPost()) {
			invalidateHttpCache();
			Auth::removeAccess();
			Session::regenerateID('FreshRSS');
			Request::good(
				_t('feedback.auth.logout.success'),
				[ 'c' => 'index', 'a' => 'index' ],
				showNotification: Context::userConf()->good_notification_timeout > 0
			);
		} else {
			Error::error(403);
		}
	}

	/**
	 * This action gives possibility to a user to create an account.
	 *
	 * The user is redirected to the home when logged in.
	 *
	 * A 403 is sent if max number of registrations is reached.
	 */
	public function registerAction(): void {
		if (Auth::hasAccess()) {
			Request::forward(['c' => 'index', 'a' => 'index'], true);
		}

		if (UserController::max_registrations_reached()) {
			Error::error(403);
		}

		$this->view->show_tos_checkbox = file_exists(TOS_FILENAME);
		$this->view->show_email_field = Context::systemConf()->force_email_validation;
		$this->view->preferred_language = Translate::getLanguage(null, Request::getPreferredLanguages(), Context::systemConf()->language);
		View::prependTitle(_t('gen.auth.registration.title') . ' · ');
	}

	public static function getLogoutUrl(): string {
		if (($_SERVER['AUTH_TYPE'] ?? '') === 'openid-connect') {
			$url_string = urlencode(Request::guessBaseUrl());
			return './oidc/?logout=' . $url_string . '/';
			# The trailing slash is necessary so that we don’t redirect to http://.
			# https://bz.apache.org/bugzilla/show_bug.cgi?id=61355#c13
		} else {
			return _url('auth', 'logout');
		}
	}
}
