<?php

namespace Freshrss\Controllers;

/**
 * Controller to handle user actions.
 */
class user_Controller extends ActionController {
	// Will also have to be computed client side on mobile devices,
	// so do not use a too high cost
	const BCRYPT_COST = 9;

	public static function hashPassword($passwordPlain) {
		$passwordHash = password_hash($passwordPlain, PASSWORD_BCRYPT, array('cost' => self::BCRYPT_COST));
		$passwordPlain = '';
		$passwordHash = preg_replace('/^\$2[xy]\$/', '\$2a\$', $passwordHash);	//Compatibility with bcrypt.js
		return $passwordHash == '' ? '' : $passwordHash;
	}

	/**
	 * The username is also used as folder name, file name, and part of SQL table name.
	 * '_' is a reserved internal username.
	 */
	const USERNAME_PATTERN = '([0-9a-zA-Z_][0-9a-zA-Z_.@-]{1,38}|[0-9a-zA-Z])';

	public static function checkUsername($username) {
		return preg_match('/^' . self::USERNAME_PATTERN . '$/', $username) === 1;
	}

	public static function deleteFeverKey($username) {
		$userConfig = get_user_configuration($username);
		if ($userConfig !== null && ctype_xdigit($userConfig->feverKey)) {
			return @unlink(DATA_PATH . '/fever/.key-' . sha1(Context::$system_conf->salt) . '-' . $userConfig->feverKey . '.txt');
		}
		return false;
	}

	public static function updateUser($user, $email, $passwordPlain, $apiPasswordPlain, $userConfigUpdated = array()) {
		$userConfig = get_user_configuration($user);
		if ($userConfig === null) {
			return false;
		}

		if ($email !== null && $userConfig->mail_login !== $email) {
			$userConfig->mail_login = $email;

			if (Context::$system_conf->force_email_validation) {
				$salt = Context::$system_conf->salt;
				$userConfig->email_validation_token = sha1($salt . uniqid(mt_rand(), true));
				$mailer = new User_Mailer();
				$mailer->send_email_need_validation($user, $userConfig);
			}
		}

		if ($passwordPlain != '') {
			$passwordHash = self::hashPassword($passwordPlain);
			$userConfig->passwordHash = $passwordHash;
		}

		if ($apiPasswordPlain != '') {
			$apiPasswordHash = self::hashPassword($apiPasswordPlain);
			$userConfig->apiPasswordHash = $apiPasswordHash;

			@mkdir(DATA_PATH . '/fever/', 0770, true);
			self::deleteFeverKey($user);
			$userConfig->feverKey = strtolower(md5($user . ':' . $apiPasswordPlain));
			$ok = file_put_contents(DATA_PATH . '/fever/.key-' . sha1(Context::$system_conf->salt) . '-' . $userConfig->feverKey . '.txt', $user) !== false;

			if (!$ok) {
				Log::warning('Could not save API credentials for fever API', ADMIN_LOG);
				return $ok;
			}
		}

		if (is_array($userConfigUpdated)) {
			foreach ($userConfigUpdated as $configName => $configValue) {
				if ($configValue !== null) {
					$userConfig->_param($configName, $configValue);
				}
			}
		}

		$ok = $userConfig->save();
		return $ok;
	}

	public function updateAction() {
		if (!Auth::hasAccess('admin')) {
			Error::error(403);
		}

		if (Request::isPost()) {
			$passwordPlain = Request::param('newPasswordPlain', '', true);
			Request::_param('newPasswordPlain');	//Discard plain-text password ASAP
			$_POST['newPasswordPlain'] = '';

			$apiPasswordPlain = Request::param('apiPasswordPlain', '', true);

			$username = Request::param('username');
			$ok = self::updateUser($username, null, $passwordPlain, $apiPasswordPlain, array(
				'token' => Request::param('token', null),
			));

			if ($ok) {
				$isSelfUpdate = Session::param('currentUser', '_') === $username;
				if ($passwordPlain == '' || !$isSelfUpdate) {
					Request::good(_t('feedback.user.updated', $username), array('c' => 'user', 'a' => 'manage'));
				} else {
					Request::good(_t('feedback.profile.updated'), array('c' => 'index', 'a' => 'index'));
				}
			} else {
				Request::bad(_t('feedback.user.updated.error', $username),
				                  array('c' => 'user', 'a' => 'manage'));
			}

		}
	}

	/**
	 * This action displays the user profile page.
	 */
	public function profileAction() {
		if (!Auth::hasAccess()) {
			Error::error(403);
		}

		$email_not_verified = Context::$user_conf->email_validation_token !== '';
		$this->view->disable_aside = false;
		if ($email_not_verified) {
			$this->view->_layout('simple');
			$this->view->disable_aside = true;
		}

		View::prependTitle(_t('conf.profile.title') . ' · ');

		View::appendScript(Minz_Url::display('/scripts/bcrypt.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/bcrypt.min.js')));

		if (Request::isPost()) {
			$system_conf = Context::$system_conf;
			$user_config = Context::$user_conf;
			$old_email = $user_config->mail_login;

			$email = trim(Request::param('email', ''));
			$passwordPlain = Request::param('newPasswordPlain', '', true);
			Request::_param('newPasswordPlain');	//Discard plain-text password ASAP
			$_POST['newPasswordPlain'] = '';

			$apiPasswordPlain = Request::param('apiPasswordPlain', '', true);

			if ($system_conf->force_email_validation && empty($email)) {
				Request::bad(
					_t('user.email.feedback.required'),
					array('c' => 'user', 'a' => 'profile')
				);
			}

			if (!empty($email) && !validateEmailAddress($email)) {
				Request::bad(
					_t('user.email.feedback.invalid'),
					array('c' => 'user', 'a' => 'profile')
				);
			}

			$ok = self::updateUser(
				Session::param('currentUser'),
				$email,
				$passwordPlain,
				$apiPasswordPlain,
				array(
					'token' => Request::param('token', null),
				)
			);

			Session::_param('passwordHash', Context::$user_conf->passwordHash);

			if ($ok) {
				if ($system_conf->force_email_validation && $email !== $old_email) {
					Request::good(_t('feedback.profile.updated'), array('c' => 'user', 'a' => 'validateEmail'));
				} elseif ($passwordPlain == '') {
					Request::good(_t('feedback.profile.updated'), array('c' => 'user', 'a' => 'profile'));
				} else {
					Request::good(_t('feedback.profile.updated'), array('c' => 'index', 'a' => 'index'));
				}
			} else {
				Request::bad(_t('feedback.profile.error'),
				                  array('c' => 'user', 'a' => 'profile'));
			}
		}
	}

	/**
	 * This action displays the user management page.
	 */
	public function manageAction() {
		if (!Auth::hasAccess('admin')) {
			Error::error(403);
		}

		View::prependTitle(_t('admin.user.title') . ' · ');

		$this->view->show_email_field = Context::$system_conf->force_email_validation;
		$this->view->current_user = Request::param('u');

		$this->view->nb_articles = 0;
		$this->view->size_user = 0;
		if ($this->view->current_user) {
			// Get information about the current user.
			$entryDAO = Factory::createEntryDao($this->view->current_user);
			$this->view->nb_articles = $entryDAO->count();

			$databaseDAO = Factory::createDatabaseDAO($this->view->current_user);
			$this->view->size_user = $databaseDAO->size();
		}
	}

	public static function createUser($new_user_name, $email, $passwordPlain, $apiPasswordPlain = '', $userConfigOverride = [], $insertDefaultFeeds = true) {
		$userConfig = [];

		$customUserConfigPath = join_path(DATA_PATH, 'config-user.custom.php');
		if (file_exists($customUserConfigPath)) {
			$customUserConfig = include($customUserConfigPath);
			if (is_array($customUserConfig)) {
				$userConfig = $customUserConfig;
			}
		}

		if (is_array($userConfigOverride)) {
			$userConfig = array_merge($userConfig, $userConfigOverride);
		}

		$ok = self::checkUsername($new_user_name);
		$homeDir = join_path(DATA_PATH, 'users', $new_user_name);

		if ($ok) {
			$languages = Translate::availableLanguages();
			if (empty($userConfig['language']) || !in_array($userConfig['language'], $languages)) {
				$userConfig['language'] = 'en';
			}

			$ok &= !in_array(strtoupper($new_user_name), array_map('strtoupper', listUsers()));	//Not an existing user, case-insensitive

			$configPath = join_path($homeDir, 'config.php');
			$ok &= !file_exists($configPath);
		}
		if ($ok) {
			if (!is_dir($homeDir)) {
				mkdir($homeDir);
			}
			$ok &= (file_put_contents($configPath, "<?php\n return " . var_export($userConfig, true) . ';') !== false);
		}
		if ($ok) {
			$newUserDAO = Factory::createUserDao($new_user_name);
			$ok &= $newUserDAO->createUser();

			if ($ok && $insertDefaultFeeds) {
				$opmlPath = DATA_PATH . '/opml.xml';
				if (!file_exists($opmlPath)) {
					$opmlPath = FRESHRSS_PATH . '/opml.default.xml';
				}
				$importController = new importExport_Controller();
				try {
					$importController->importFile($opmlPath, $opmlPath, $new_user_name);
				} catch (Exception $e) {
					Log::error('Error while importing default OPML for user ' . $new_user_name . ': ' . $e->getMessage());
				}
			}

			$ok &= self::updateUser($new_user_name, $email, $passwordPlain, $apiPasswordPlain);
		}
		return $ok;
	}

	/**
	 * This action creates a new user.
	 *
	 * Request parameters are:
	 *   - new_user_language
	 *   - new_user_name
	 *   - new_user_email
	 *   - new_user_passwordPlain
	 *   - r (i.e. a redirection url, optional)
	 *
	 * @todo clean up this method. Idea: write a method to init a user with basic information.
	 * @todo handle r redirection in Request::forward directly?
	 */
	public function createAction() {
		if (!Auth::hasAccess('admin') && max_registrations_reached()) {
			Error::error(403);
		}

		if (Request::isPost()) {
			$system_conf = Context::$system_conf;

			$new_user_name = Request::param('new_user_name');
			$email = Request::param('new_user_email', '');
			$passwordPlain = Request::param('new_user_passwordPlain', '', true);
			$new_user_language = Request::param('new_user_language', Context::$user_conf->language);

			$tos_enabled = file_exists(join_path(DATA_PATH, 'tos.html'));
			$accept_tos = Request::param('accept_tos', false);

			if ($system_conf->force_email_validation && empty($email)) {
				Request::bad(
					_t('user.email.feedback.required'),
					array('c' => 'auth', 'a' => 'register')
				);
			}

			if (!empty($email) && !validateEmailAddress($email)) {
				Request::bad(
					_t('user.email.feedback.invalid'),
					array('c' => 'auth', 'a' => 'register')
				);
			}

			if ($tos_enabled && !$accept_tos) {
				Request::bad(
					_t('user.tos.feedback.invalid'),
					array('c' => 'auth', 'a' => 'register')
				);
			}

			$ok = self::createUser($new_user_name, $email, $passwordPlain, '', array('language' => $new_user_language));
			Request::_param('new_user_passwordPlain');	//Discard plain-text password ASAP
			$_POST['new_user_passwordPlain'] = '';
			invalidateHttpCache();

			// If the user has admin access, it means he's already logged in
			// and we don't want to login with the new account. Otherwise, the
			// user just created its account himself so he probably wants to
			// get started immediately.
			if ($ok && !Auth::hasAccess('admin')) {
				$user_conf = get_user_configuration($new_user_name);
				Session::_param('currentUser', $new_user_name);
				Session::_param('passwordHash', $user_conf->passwordHash);
				Session::_param('csrf');
				Auth::giveAccess();
			}

			$notif = array(
				'type' => $ok ? 'good' : 'bad',
				'content' => _t('feedback.user.created' . (!$ok ? '.error' : ''), $new_user_name)
			);
			Session::_param('notification', $notif);
		}

		$redirect_url = urldecode(Request::param('r', false, true));
		if (!$redirect_url) {
			$redirect_url = array('c' => 'user', 'a' => 'manage');
		}
		Request::forward($redirect_url, true);
	}

	public static function deleteUser($username) {
		$ok = self::checkUsername($username);
		if ($ok) {
			$default_user = Context::$system_conf->default_user;
			$ok &= (strcasecmp($username, $default_user) !== 0);	//It is forbidden to delete the default user
		}
		$user_data = join_path(DATA_PATH, 'users', $username);
		$ok &= is_dir($user_data);
		if ($ok) {
			self::deleteFeverKey($username);
			$oldUserDAO = Factory::createUserDao($username);
			$ok &= $oldUserDAO->deleteUser();
			$ok &= recursive_unlink($user_data);
			array_map('unlink', glob(PSHB_PATH . '/feeds/*/' . $username . '.txt'));
		}
		return $ok;
	}

	/**
	 * This action validates an email address, based on the token sent by email.
	 * It also serves the main page when user is blocked.
	 *
	 * Request parameters are:
	 *   - username
	 *   - token
	 *
	 * This route works with GET requests since the URL is provided by email.
	 * The security risks (e.g. forged URL by an attacker) are not very high so
	 * it's ok.
	 *
	 * It returns 404 error if `force_email_validation` is disabled or if the
	 * user doesn't exist.
	 *
	 * It returns 403 if user isn't logged in and `username` param isn't passed.
	 */
	public function validateEmailAction() {
		if (!Context::$system_conf->force_email_validation) {
			Error::error(404);
		}

		View::prependTitle(_t('user.email.validation.title') . ' · ');
		$this->view->_layout('simple');

		$username = Request::param('username');
		$token = Request::param('token');

		if ($username) {
			$user_config = get_user_configuration($username);
		} elseif (Auth::hasAccess()) {
			$user_config = Context::$user_conf;
		} else {
			Error::error(403);
		}

		if (!UserDAO::exists($username) || $user_config === null) {
			Error::error(404);
		}

		if ($user_config->email_validation_token === '') {
			Request::good(
				_t('user.email.validation.feedback.unnecessary'),
				array('c' => 'index', 'a' => 'index')
			);
		}

		if ($token) {
			if ($user_config->email_validation_token !== $token) {
				Request::bad(
					_t('user.email.validation.feedback.wrong_token'),
					array('c' => 'user', 'a' => 'validateEmail')
				);
			}

			$user_config->email_validation_token = '';
			if ($user_config->save()) {
				Request::good(
					_t('user.email.validation.feedback.ok'),
					array('c' => 'index', 'a' => 'index')
				);
			} else {
				Request::bad(
					_t('user.email.validation.feedback.error'),
					array('c' => 'user', 'a' => 'validateEmail')
				);
			}
		}
	}

	/**
	 * This action resends a validation email to the current user.
	 *
	 * It only acts on POST requests but doesn't require any param (except the
	 * CSRF token).
	 *
	 * It returns 403 error if the user is not logged in or 404 if request is
	 * not POST. Else it redirects silently to the index if user has already
	 * validated its email, or to the user#validateEmail route.
	 */
	public function sendValidationEmailAction() {
		if (!Auth::hasAccess()) {
			Error::error(403);
		}

		if (!Request::isPost()) {
			Error::error(404);
		}

		$username = Session::param('currentUser', '_');
		$user_config = Context::$user_conf;

		if ($user_config->email_validation_token === '') {
			Request::forward(array(
				'c' => 'index',
				'a' => 'index',
			), true);
		}

		$mailer = new User_Mailer();
		$ok = $mailer->send_email_need_validation($username, $user_config);

		$redirect_url = array('c' => 'user', 'a' => 'validateEmail');
		if ($ok) {
			Request::good(
				_t('user.email.validation.feedback.email_sent'),
				$redirect_url
			);
		} else {
			Request::bad(
				_t('user.email.validation.feedback.email_failed'),
				$redirect_url
			);
		}
	}

	/**
	 * This action delete an existing user.
	 *
	 * Request parameter is:
	 *   - username
	 *
	 * @todo clean up this method. Idea: create a User->clean() method.
	 */
	public function deleteAction() {
		$username = Request::param('username');
		$self_deletion = Session::param('currentUser', '_') === $username;

		if (!Auth::hasAccess('admin') && !$self_deletion) {
			Error::error(403);
		}

		$redirect_url = urldecode(Request::param('r', false, true));
		if (!$redirect_url) {
			$redirect_url = array('c' => 'user', 'a' => 'manage');
		}

		if (Request::isPost()) {
			$ok = true;
			if ($ok && $self_deletion) {
				// We check the password if it's a self-destruction
				$nonce = Session::param('nonce');
				$challenge = Request::param('challenge', '');

				$ok &= FormAuth::checkCredentials(
					$username, Context::$user_conf->passwordHash,
					$nonce, $challenge
				);
			}
			if ($ok) {
				$ok &= self::deleteUser($username);
			}
			if ($ok && $self_deletion) {
				Auth::removeAccess();
				$redirect_url = array('c' => 'index', 'a' => 'index');
			}
			invalidateHttpCache();

			$notif = array(
				'type' => $ok ? 'good' : 'bad',
				'content' => _t('feedback.user.deleted' . (!$ok ? '.error' : ''), $username)
			);
			Session::_param('notification', $notif);
		}

		Request::forward($redirect_url, true);
	}
}
