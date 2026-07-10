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
use FreshRss\Models\UserConfiguration;
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
			return;
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
	 * Redirect back to the login form, while replying to the login request with an HTTP error status code (403, 500),
	 * e.g. for fail2ban, which a normal HTTP redirection (3xx) cannot do.
	 * The HTML redirection (POST->GET) also prevents browsers from offering to resubmit the password when reloading the page.
	 */
	private static function loginFailed(int $httpCode, string $notification): void {
		$redirect = [
			'c' => 'auth',
			'a' => 'login',
			'params' => ['original_request' => Request::paramString('original_request')],
		];
		if (Request::is('auth', 'reauth')) {
			$redirect = [
				'c' => 'auth',
				'a' => 'reauth',
				'params' => ['r' => Request::paramString('original_request')],
			];
		}
		Request::setBadNotification($notification);
		Request::forward($redirect, redirect: true, httpCode: $httpCode);
	}

	/**
	 * This action handles form login page.
	 *
	 * If this action is reached through a POST request, username and password
	 * are compared against the bcrypt password hash stored in the user configuration file
	 * to authenticate the current user.
	 *
	 * Parameters are:
	 *   - username (default: '')
	 *   - passwordPlain (default: '')
	 *   - keep_logged_in (default: false)
	 *
	 * @throws \Exception
	 */
	public function formLoginAction(): void {
		if (Auth::hasAccess()) {
			Request::forward(['c' => 'index', 'a' => 'index'], true);
			return;
		}

		invalidateHttpCache();

		View::prependTitle(_t('gen.auth.login') . ' · ');
		$this->view->auth_autofills = FormAuth::getAutofilledFields();

		$limits = Context::systemConf()->limits;
		$this->view->cookie_days = (int)round($limits['cookie_duration'] / 86400, 1);

		if (Request::isPost()) {
			$username = Request::paramString('username');
			$passwordPlain = Request::paramString('passwordPlain', plaintext: true, trim: false);
			$ip_address = Request::connectionRemoteAddress();

			if (!Session::paramBoolean('sessionOk')) {
				Log::warning("Invalid session during login for user={$username}, ip_address={$ip_address}");
				self::loginFailed(403, _t('install.session.nok'));
				return;
			}

			usleep(random_int(100, 10000));	// Primitive mitigation of timing attacks, in μs

			// Do not use `Context::initUser()` before the password is verified
			$userConf = UserController::checkUsername($username) && UserController::userExists($username) ?
				UserConfiguration::getForUser($username) : null;
			if ($userConf === null) {
				self::loginFailed(403, _t('feedback.auth.login.invalid'));
				return;
			}

			if (!$userConf->enabled || $userConf->passwordHash == '') {
				usleep(random_int(100, 5000));	// Primitive mitigation of timing attacks, in μs
				self::loginFailed(403, _t('feedback.auth.login.invalid'));
				return;
			}

			$ok = FormAuth::checkCredentials(
				$username, $userConf->passwordHash, $passwordPlain
			);
			if ($ok) {
				try {
					Session::regenerateID('FreshRSS');
				} catch (\RuntimeException $e) {
					Log::error("Session could not be regenerated during login for user={$username}, ip_address={$ip_address}: {$e->getMessage()}");
					self::loginFailed(500, _t('install.session.nok'));
					return;
				}
				// Set session parameters to give access to the user.
				Session::_params([
					User::CURRENT_USER => $username,
					'passwordHash' => $userConf->passwordHash,
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
				Log::warning("Password mismatch for user={$username}, ip_address={$ip_address}");
				self::loginFailed(403, _t('feedback.auth.login.invalid'));
				return;
			}
		} else {
			Session::deleteLegacyCookie('FreshRSS');	// Delete legacy cookie (before 1.29.0)
			Session::_param('sessionOk', true);	// To be checked in the POST login request.
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
			$passwordPlain = Request::paramString('passwordPlain', plaintext: true, trim: false);
			if (!FormAuth::checkCredentials(
				$username, Context::userConf()->passwordHash, $passwordPlain
			)) {
				self::loginFailed(403, _t('feedback.auth.login.invalid'));
				return;
			} else {
				try {
					Session::regenerateID('FreshRSS');
					Session::_param('lastReauth', time());
					Request::forward($redirect, redirect: true);
					return;
				} catch (\RuntimeException $e) {
					Log::error("Session could not be regenerated during reauthentication! {$e->getMessage()}");
					Session::_param('lastReauth', 0);
					self::loginFailed(500, _t('install.session.nok'));
					return;
				}
			}
		}
		View::prependTitle(_t('gen.auth.reauth.title') . ' · ');
		$this->view->auth_autofills = FormAuth::getAutofilledFields();
	}

	/**
	 * This action removes all accesses of the current user.
	 */
	public function logoutAction(): void {
		if (Request::isPost()) {
			invalidateHttpCache();
			Auth::removeAccess();
			Session::_param('csrf', false);
			try {
				Session::regenerateID('FreshRSS');
			} catch (\RuntimeException $e) {
				Log::error('Session could not be regenerated during logout! ' . $e->getMessage());
			}
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
		$this->view->auth_autofills = FormAuth::getAutofilledFields();
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
