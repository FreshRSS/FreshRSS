<?php

/**
 * Controller to handle user actions.
 */
class FreshRSS_user_Controller extends Minz_ActionController {
	/**
	 * The username is also used as folder name, file name, and part of SQL table name.
	 * '_' is a reserved internal username.
	 */
	const USERNAME_PATTERN = '([0-9a-zA-Z_][0-9a-zA-Z_.@-]{1,38}|[0-9a-zA-Z])';

	public static function checkUsername($username) {
		return preg_match('/^' . self::USERNAME_PATTERN . '$/', $username) === 1;
	}

	public static function userExists($username) {
		return @file_exists(USERS_PATH . '/' . $username . '/config.php');
	}

	public static function updateUser($user, $email, $passwordPlain, $userConfigUpdated = array()) {
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
			$passwordHash = FreshRSS_password_Util::hash($passwordPlain);
			$userConfig->passwordHash = $passwordHash;
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

			$username = Minz_Request::param('username');
			$ok = self::updateUser($username, null, $passwordPlain, array(
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
				Minz_Request::bad(_t('feedback.user.updated.error', $username), [ 'c' => 'user', 'a' => 'manage' ]);
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

		$email_not_verified = FreshRSS_Context::$user_conf->email_validation_token != '';
		$this->view->disable_aside = false;
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
				Minz_Request::bad(_t('feedback.profile.error'), [ 'c' => 'user', 'a' => 'profile' ]);
			}
		}
	}

	public function purgeAction() {
		if (!FreshRSS_Auth::hasAccess('admin')) {
			Minz_Error::error(403);
		}

		if (Minz_Request::isPost()) {
			$username = Minz_Request::param('username');

			if (!FreshRSS_UserDAO::exists($username)) {
				Minz_Error::error(404);
			}

			$feedDAO = FreshRSS_Factory::createFeedDao($username);
			$feedDAO->purge();
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

		if (Minz_Request::isPost()) {
			$action = Minz_Request::param('action');
			switch ($action) {
				case 'delete':
					$this->deleteAction();
					break;
				case 'update':
					$this->updateAction();
					break;
				case 'purge':
					$this->purgeAction();
					break;
				case 'promote':
					$this->promoteAction();
					break;
				case 'demote':
					$this->demoteAction();
					break;
				case 'enable':
					$this->enableAction();
					break;
				case 'disable':
					$this->disableAction();
					break;
			}
		}

		$this->view->show_email_field = FreshRSS_Context::$system_conf->force_email_validation;
		$this->view->current_user = Minz_Request::param('u');

		foreach (listUsers() as $user) {
			$this->view->users[$user] = $this->retrieveUserDetails($user);
		}
	}

	public static function createUser($new_user_name, $email, $passwordPlain, $userConfigOverride = [], $insertDefaultFeeds = true) {
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
			$newUserDAO = FreshRSS_Factory::createUserDao($new_user_name);
			$ok &= $newUserDAO->createUser();

			if ($ok && $insertDefaultFeeds) {
				$opmlPath = DATA_PATH . '/opml.xml';
				if (!file_exists($opmlPath)) {
					$opmlPath = FRESHRSS_PATH . '/opml.default.xml';
				}
				$importController = new FreshRSS_importExport_Controller();
				try {
					$importController->importFile($opmlPath, $opmlPath, $new_user_name);
				} catch (Exception $e) {
					Minz_Log::error('Error while importing default OPML for user ' . $new_user_name . ': ' . $e->getMessage());
				}
			}

			$ok &= self::updateUser($new_user_name, $email, $passwordPlain);
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
			$badRedirectUrl = [
				'c' => Minz_Request::param('originController', 'auth'),
				'a' => Minz_Request::param('originAction', 'register'),
			];

			if (!self::checkUsername($new_user_name)) {
				Minz_Request::bad(
					_t('user.username.invalid'),
					$badRedirectUrl
				);
			}

			if (FreshRSS_UserDAO::exists($new_user_name)) {
				Minz_Request::bad(
					_t('user.username.taken', $new_user_name),
					$badRedirectUrl
				);
			}

			if (!FreshRSS_password_Util::check($passwordPlain)) {
				Minz_Request::bad(
					_t('user.password.invalid'),
					$badRedirectUrl
				);
			}

			$tos_enabled = file_exists(join_path(DATA_PATH, 'tos.html'));
			$accept_tos = Minz_Request::param('accept_tos', false);

			if ($system_conf->force_email_validation && empty($email)) {
				Minz_Request::bad(
					_t('user.email.feedback.required'),
					$badRedirectUrl
				);
			}

			if (!empty($email) && !validateEmailAddress($email)) {
				Minz_Request::bad(
					_t('user.email.feedback.invalid'),
					$badRedirectUrl
				);
			}

			if ($tos_enabled && !$accept_tos) {
				Minz_Request::bad(
					_t('user.tos.feedback.invalid'),
					$badRedirectUrl
				);
			}

			$ok = self::createUser($new_user_name, $email, $passwordPlain, array(
				'language' => Minz_Request::param('new_user_language', FreshRSS_Context::$user_conf->language),
				'is_admin' => Minz_Request::paramBoolean('new_user_is_admin'),
				'enabled' => true,
			));
			Minz_Request::_param('new_user_passwordPlain');	//Discard plain-text password ASAP
			$_POST['new_user_passwordPlain'] = '';
			invalidateHttpCache();

			// If the user has admin access, it means he's already logged in
			// and we don't want to login with the new account. Otherwise, the
			// user just created its account himself so he probably wants to
			// get started immediately.
			if ($ok && !FreshRSS_Auth::hasAccess('admin')) {
				$user_conf = get_user_configuration($new_user_name);
				Minz_Session::_params([
					'currentUser' => $new_user_name,
					'passwordHash' => $user_conf->passwordHash,
					'csrf' => false,
				]);
				FreshRSS_Auth::giveAccess();
			}

			if ($ok) {
				Minz_Request::setGoodNotification(_t('feedback.user.created', $new_user_name));
			} else {
				Minz_Request::setBadNotification(_t('feedback.user.created.error', $new_user_name));
			}
		}

		$redirect_url = urldecode(Minz_Request::param('r', false, true));
		if (!$redirect_url) {
			$redirect_url = array('c' => 'user', 'a' => 'manage');
		}
		Minz_Request::forward($redirect_url, true);
	}

	public static function deleteUser($username) {
		$ok = self::checkUsername($username);
		if ($ok) {
			$default_user = FreshRSS_Context::$system_conf->default_user;
			$ok &= (strcasecmp($username, $default_user) !== 0);	//It is forbidden to delete the default user
		}
		$user_data = join_path(DATA_PATH, 'users', $username);
		$ok &= is_dir($user_data);
		if ($ok) {
			FreshRSS_fever_Util::deleteKey($username);
			$oldUserDAO = FreshRSS_Factory::createUserDao($username);
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

			if ($ok) {
				Minz_Request::setGoodNotification(_t('feedback.user.deleted', $username));
			} else {
				Minz_Request::setBadNotification(_t('feedback.user.deleted.error', $username));
			}
		}

		Minz_Request::forward($redirect_url, true);
	}

	public function promoteAction() {
		$this->toggleAction('is_admin', true);
	}

	public function demoteAction() {
		$this->toggleAction('is_admin', false);
	}

	public function enableAction() {
		$this->toggleAction('enabled', true);
	}

	public function disableAction() {
		$this->toggleAction('enabled', false);
	}

	private function toggleAction($field, $value) {
		if (!FreshRSS_Auth::hasAccess('admin')) {
			Minz_Error::error(403);
		}

		if (!Minz_Request::isPost()) {
			Minz_Error::error(403);
		}

		$username = Minz_Request::param('username');
		if (!FreshRSS_UserDAO::exists($username)) {
			Minz_Error::error(404);
		}

		if (null === $userConfig = get_user_configuration($username)) {
			Minz_Error::error(500);
		}

		$userConfig->_param($field, $value);

		$ok = $userConfig->save();
		FreshRSS_UserDAO::touch($username);

		if ($ok) {
			Minz_Request::good(_t('feedback.user.updated', $username), array('c' => 'user', 'a' => 'manage'));
		} else {
			Minz_Request::bad(_t('feedback.user.updated.error', $username),
							  array('c' => 'user', 'a' => 'manage'));
		}
	}

	public function detailsAction() {
		if (!FreshRSS_Auth::hasAccess('admin')) {
			Minz_Error::error(403);
		}

		$username = Minz_Request::param('username');
		if (!FreshRSS_UserDAO::exists($username)) {
			Minz_Error::error(404);
		}

		$this->view->username = $username;
		$this->view->details = $this->retrieveUserDetails($username);
	}

	private function retrieveUserDetails($username) {
		$feedDAO = FreshRSS_Factory::createFeedDao($username);
		$entryDAO = FreshRSS_Factory::createEntryDao($username);
		$databaseDAO = FreshRSS_Factory::createDatabaseDAO($username);

		$userConfiguration = get_user_configuration($username);

		return array(
			'feed_count' => $feedDAO->count(),
			'article_count' => $entryDAO->count(),
			'database_size' => $databaseDAO->size(),
			'language' => $userConfiguration->language,
			'mail_login' => $userConfiguration->mail_login,
			'enabled' => $userConfiguration->enabled,
			'is_admin' => $userConfiguration->is_admin,
			'last_user_activity' => date('c', FreshRSS_UserDAO::mtime($username)),
			'is_default' => FreshRSS_Context::$system_conf->default_user === $username,
		);
	}
}
