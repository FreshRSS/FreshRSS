<?php

/**
 * Controller to handle user actions.
 */
class FreshRSS_user_Controller extends Minz_ActionController {
	// Will also have to be computed client side on mobile devices,
	// so do not use a too high cost
	const BCRYPT_COST = 9;

	public static function hashPassword($passwordPlain) {
		if (!function_exists('password_hash')) {
			include_once(LIB_PATH . '/password_compat.php');
		}
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
			return @unlink(DATA_PATH . '/fever/.key-' . sha1(FreshRSS_Context::$system_conf->salt) . '-' . $userConfig->feverKey . '.txt');
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

			if (FreshRSS_Context::$system_conf->force_email_validation) {
				$salt = FreshRSS_Context::$system_conf->salt;
				$userConfig->email_validation_token = sha1($salt . uniqid(mt_rand(), true));
				$mailer = new FreshRSS_User_Mailer();
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
			$ok = file_put_contents(DATA_PATH . '/fever/.key-' . sha1(FreshRSS_Context::$system_conf->salt) . '-' . $userConfig->feverKey . '.txt', $user) !== false;

			if (!$ok) {
				Minz_Log::warning('Could not save API credentials for fever API', ADMIN_LOG);
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
		if (!FreshRSS_Auth::hasAccess('admin')) {
			Minz_Error::error(403);
		}

		if (Minz_Request::isPost()) {
			$passwordPlain = Minz_Request::param('newPasswordPlain', '', true);
			Minz_Request::_param('newPasswordPlain');	//Discard plain-text password ASAP
			$_POST['newPasswordPlain'] = '';

			$apiPasswordPlain = Minz_Request::param('apiPasswordPlain', '', true);

			$username = Minz_Request::param('username');
			$ok = self::updateUser($username, null, $passwordPlain, $apiPasswordPlain, array(
				'token' => Minz_Request::param('token', null),
			));

			if ($ok) {
				$isSelfUpdate = Minz_Session::param('currentUser', '_') === $username;
				if ($passwordPlain == '' || !$isSelfUpdate) {
					Minz_Request::good(_t('feedback.user.updated', $username), array('c' => 'user', 'a' => 'manage'));
				} else {
					Minz_Request::good(_t('feedback.profile.updated'), array('c' => 'index', 'a' => 'index'));
				}
			} else {
				Minz_Request::bad(_t('feedback.user.updated.error', $username),
				                  array('c' => 'user', 'a' => 'manage'));
			}

		}
	}

	/**
	 * This action displays the user profile page.
	 */
	public function profileAction() {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}

		$email_not_verified = FreshRSS_Context::$user_conf->email_validation_token !== '';
		if ($email_not_verified) {
			$this->view->_layout('simple');
			$this->view->disable_aside = true;
		}

		Minz_View::prependTitle(_t('conf.profile.title') . ' · ');

		Minz_View::appendScript(Minz_Url::display('/scripts/bcrypt.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/bcrypt.min.js')));

		if (Minz_Request::isPost()) {
			$system_conf = FreshRSS_Context::$system_conf;
			$user_config = FreshRSS_Context::$user_conf;
			$old_email = $user_config->mail_login;

			$email = trim(Minz_Request::param('email', ''));
			$passwordPlain = Minz_Request::param('newPasswordPlain', '', true);
			Minz_Request::_param('newPasswordPlain');	//Discard plain-text password ASAP
			$_POST['newPasswordPlain'] = '';

			$apiPasswordPlain = Minz_Request::param('apiPasswordPlain', '', true);

			if ($system_conf->force_email_validation && empty($email)) {
				Minz_Request::bad(
					_t('user.email.feedback.required'),
					array('c' => 'user', 'a' => 'profile')
				);
			}

			if (!empty($email) && !validateEmailAddress($email)) {
				Minz_Request::bad(
					_t('user.email.feedback.invalid'),
					array('c' => 'user', 'a' => 'profile')
				);
			}

			$ok = self::updateUser(
				Minz_Session::param('currentUser'),
				$email,
				$passwordPlain,
				$apiPasswordPlain,
				array(
					'token' => Minz_Request::param('token', null),
				)
			);

			Minz_Session::_param('passwordHash', FreshRSS_Context::$user_conf->passwordHash);

			if ($ok) {
				if ($system_conf->force_email_validation && $email !== $old_email) {
					Minz_Request::good(_t('feedback.profile.updated'), array('c' => 'user', 'a' => 'validateEmail'));
				} elseif ($passwordPlain == '') {
					Minz_Request::good(_t('feedback.profile.updated'), array('c' => 'user', 'a' => 'profile'));
				} else {
					Minz_Request::good(_t('feedback.profile.updated'), array('c' => 'index', 'a' => 'index'));
				}
			} else {
				Minz_Request::bad(_t('feedback.profile.error'),
				                  array('c' => 'user', 'a' => 'profile'));
			}
		}
	}

	/**
	 * This action displays the user management page.
	 */
	public function manageAction() {
		if (!FreshRSS_Auth::hasAccess('admin')) {
			Minz_Error::error(403);
		}

		Minz_View::prependTitle(_t('admin.user.title') . ' · ');

		$this->view->show_email_field = FreshRSS_Context::$system_conf->force_email_validation;
		$this->view->current_user = Minz_Request::param('u');

		$this->view->nb_articles = 0;
		$this->view->size_user = 0;
		if ($this->view->current_user) {
			// Get information about the current user.
			$entryDAO = FreshRSS_Factory::createEntryDao($this->view->current_user);
			$this->view->nb_articles = $entryDAO->count();

			$databaseDAO = FreshRSS_Factory::createDatabaseDAO($this->view->current_user);
			$this->view->size_user = $databaseDAO->size();
		}
	}

	public static function createUser($new_user_name, $email, $passwordPlain, $apiPasswordPlain, $userConfig = array(), $insertDefaultFeeds = true) {
		if (!is_array($userConfig)) {
			$userConfig = array();
		}

		$ok = self::checkUsername($new_user_name);
		$homeDir = join_path(DATA_PATH, 'users', $new_user_name);

		if ($ok) {
			$languages = Minz_Translate::availableLanguages();
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
			$userDAO = new FreshRSS_UserDAO();
			$ok &= $userDAO->createUser($new_user_name, $userConfig['language'], $insertDefaultFeeds);
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
	 * @todo handle r redirection in Minz_Request::forward directly?
	 */
	public function createAction() {
		if (!FreshRSS_Auth::hasAccess('admin') && max_registrations_reached()) {
			Minz_Error::error(403);
		}

		if (Minz_Request::isPost()) {
			$system_conf = FreshRSS_Context::$system_conf;

			$new_user_name = Minz_Request::param('new_user_name');
			$email = Minz_Request::param('new_user_email', '');
			$passwordPlain = Minz_Request::param('new_user_passwordPlain', '', true);
			$new_user_language = Minz_Request::param('new_user_language', FreshRSS_Context::$user_conf->language);

			if ($system_conf->force_email_validation && empty($email)) {
				Minz_Request::bad(
					_t('user.email.feedback.required'),
					array('c' => 'auth', 'a' => 'register')
				);
			}

			if (!empty($email) && !validateEmailAddress($email)) {
				Minz_Request::bad(
					_t('user.email.feedback.invalid'),
					array('c' => 'auth', 'a' => 'register')
				);
			}

			$ok = self::createUser($new_user_name, $email, $passwordPlain, '', array('language' => $new_user_language));
			Minz_Request::_param('new_user_passwordPlain');	//Discard plain-text password ASAP
			$_POST['new_user_passwordPlain'] = '';
			invalidateHttpCache();

			// If the user has admin access, it means he's already logged in
			// and we don't want to login with the new account. Otherwise, the
			// user just created its account himself so he probably wants to
			// get started immediately.
			if ($ok && !FreshRSS_Auth::hasAccess('admin')) {
				$user_conf = get_user_configuration($new_user_name);
				Minz_Session::_param('currentUser', $new_user_name);
				Minz_Session::_param('passwordHash', $user_conf->passwordHash);
				Minz_Session::_param('csrf');
				FreshRSS_Auth::giveAccess();
			}

			$notif = array(
				'type' => $ok ? 'good' : 'bad',
				'content' => _t('feedback.user.created' . (!$ok ? '.error' : ''), $new_user_name)
			);
			Minz_Session::_param('notification', $notif);
		}

		$redirect_url = urldecode(Minz_Request::param('r', false, true));
		if (!$redirect_url) {
			$redirect_url = array('c' => 'user', 'a' => 'manage');
		}
		Minz_Request::forward($redirect_url, true);
	}

	public static function deleteUser($username) {
		$db = FreshRSS_Context::$system_conf->db;
		require_once(APP_PATH . '/SQL/install.sql.' . $db['type'] . '.php');

		$ok = self::checkUsername($username);
		if ($ok) {
			$default_user = FreshRSS_Context::$system_conf->default_user;
			$ok &= (strcasecmp($username, $default_user) !== 0);	//It is forbidden to delete the default user
		}
		$user_data = join_path(DATA_PATH, 'users', $username);
		$ok &= is_dir($user_data);
		if ($ok) {
			self::deleteFeverKey($username);
			$userDAO = new FreshRSS_UserDAO();
			$ok &= $userDAO->deleteUser($username);
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
		if (!FreshRSS_Context::$system_conf->force_email_validation) {
			Minz_Error::error(404);
		}

		Minz_View::prependTitle(_t('user.email.validation.title') . ' · ');
		$this->view->_layout('simple');

		$username = Minz_Request::param('username');
		$token = Minz_Request::param('token');

		if ($username) {
			$user_config = get_user_configuration($username);
		} elseif (FreshRSS_Auth::hasAccess()) {
			$user_config = FreshRSS_Context::$user_conf;
		} else {
			Minz_Error::error(403);
		}

		if (!FreshRSS_UserDAO::exists($username) || $user_config === null) {
			Minz_Error::error(404);
		}

		if ($user_config->email_validation_token === '') {
			Minz_Request::good(
				_t('user.email.validation.feedback.unnecessary'),
				array('c' => 'index', 'a' => 'index')
			);
		}

		if ($token) {
			if ($user_config->email_validation_token !== $token) {
				Minz_Request::bad(
					_t('user.email.validation.feedback.wrong_token'),
					array('c' => 'user', 'a' => 'validateEmail')
				);
			}

			$user_config->email_validation_token = '';
			if ($user_config->save()) {
				Minz_Request::good(
					_t('user.email.validation.feedback.ok'),
					array('c' => 'index', 'a' => 'index')
				);
			} else {
				Minz_Request::bad(
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
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}

		if (!Minz_Request::isPost()) {
			Minz_Error::error(404);
		}

		$username = Minz_Session::param('currentUser', '_');
		$user_config = FreshRSS_Context::$user_conf;

		if ($user_config->email_validation_token === '') {
			Minz_Request::forward(array(
				'c' => 'index',
				'a' => 'index',
			), true);
		}

		$mailer = new FreshRSS_User_Mailer();
		$ok = $mailer->send_email_need_validation($username, $user_config);

		$redirect_url = array('c' => 'user', 'a' => 'validateEmail');
		if ($ok) {
			Minz_Request::good(
				_t('user.email.validation.feedback.email_sent'),
				$redirect_url
			);
		} else {
			Minz_Request::bad(
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
		$username = Minz_Request::param('username');
		$self_deletion = Minz_Session::param('currentUser', '_') === $username;

		if (!FreshRSS_Auth::hasAccess('admin') && !$self_deletion) {
			Minz_Error::error(403);
		}

		$redirect_url = urldecode(Minz_Request::param('r', false, true));
		if (!$redirect_url) {
			$redirect_url = array('c' => 'user', 'a' => 'manage');
		}

		if (Minz_Request::isPost()) {
			$ok = true;
			if ($ok && $self_deletion) {
				// We check the password if it's a self-destruction
				$nonce = Minz_Session::param('nonce');
				$challenge = Minz_Request::param('challenge', '');

				$ok &= FreshRSS_FormAuth::checkCredentials(
					$username, FreshRSS_Context::$user_conf->passwordHash,
					$nonce, $challenge
				);
			}
			if ($ok) {
				$ok &= self::deleteUser($username);
			}
			if ($ok && $self_deletion) {
				FreshRSS_Auth::removeAccess();
				$redirect_url = array('c' => 'index', 'a' => 'index');
			}
			invalidateHttpCache();

			$notif = array(
				'type' => $ok ? 'good' : 'bad',
				'content' => _t('feedback.user.deleted' . (!$ok ? '.error' : ''), $username)
			);
			Minz_Session::_param('notification', $notif);
		}

		Minz_Request::forward($redirect_url, true);
	}
}
