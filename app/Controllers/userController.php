<?php

/**
 * Controller to handle user actions.
 */
class FreshRSS_user_Controller extends FreshRSS_ActionController {
	/**
	 * The username is also used as folder name, file name, and part of SQL table name.
	 * '_' is a reserved internal username.
	 */
	public const USERNAME_PATTERN = '([0-9a-zA-Z_][0-9a-zA-Z_.@-]{1,38}|[0-9a-zA-Z])';

	public static function checkUsername(string $username): bool {
		return preg_match('/^' . self::USERNAME_PATTERN . '$/', $username) === 1;
	}

	public static function userExists(string $username): bool {
		return @file_exists(USERS_PATH . '/' . $username . '/config.php');
	}

	/** @param array<string,mixed> $userConfigUpdated */
	public static function updateUser(string $user, ?string $email, string $passwordPlain, array $userConfigUpdated = []): bool {
		$userConfig = get_user_configuration($user);
		if ($userConfig === null) {
			return false;
		}

		if ($email !== null && $userConfig->mail_login !== $email) {
			$userConfig->mail_login = $email;

			if (FreshRSS_Context::$system_conf->force_email_validation) {
				$salt = FreshRSS_Context::$system_conf->salt;
				$userConfig->email_validation_token = sha1($salt . uniqid('' . mt_rand(), true));
				$mailer = new FreshRSS_User_Mailer();
				$mailer->send_email_need_validation($user, $userConfig);
			}
		}

		if ($passwordPlain != '') {
			$passwordHash = FreshRSS_password_Util::hash($passwordPlain);
			$userConfig->passwordHash = $passwordHash;
		}

		foreach ($userConfigUpdated as $configName => $configValue) {
			if ($configValue !== null) {
				$userConfig->_param($configName, $configValue);
			}
		}

		$ok = $userConfig->save();
		return $ok;
	}

	public function updateAction(): void {
		if (!FreshRSS_Auth::hasAccess('admin')) {
			Minz_Error::error(403);
		}

		if (Minz_Request::isPost()) {
			$passwordPlain = Minz_Request::paramString('newPasswordPlain', true);
			Minz_Request::_param('newPasswordPlain');	//Discard plain-text password ASAP
			$_POST['newPasswordPlain'] = '';

			$username = Minz_Request::paramString('username');
			$ok = self::updateUser($username, null, $passwordPlain, [
				'token' => Minz_Request::paramString('token') ?: null,
			]);

			if ($ok) {
				$isSelfUpdate = Minz_User::name() === $username;
				if ($passwordPlain == '' || !$isSelfUpdate) {
					Minz_Request::good(_t('feedback.user.updated', $username), ['c' => 'user', 'a' => 'manage']);
				} else {
					Minz_Request::good(_t('feedback.profile.updated'), ['c' => 'index', 'a' => 'index']);
				}
			} else {
				Minz_Request::bad(_t('feedback.user.updated.error', $username), ['c' => 'user', 'a' => 'manage']);
			}
		}
	}

	/**
	 * This action displays the user profile page.
	 */
	public function profileAction(): void {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}

		$email_not_verified = FreshRSS_Context::$user_conf->email_validation_token != '';
		$this->view->disable_aside = false;
		if ($email_not_verified) {
			$this->view->_layout('simple');
			$this->view->disable_aside = true;
		}

		FreshRSS_View::prependTitle(_t('conf.profile.title') . ' · ');

		FreshRSS_View::appendScript(Minz_Url::display('/scripts/bcrypt.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/bcrypt.min.js')));

		if (Minz_Request::isPost()) {
			$system_conf = FreshRSS_Context::$system_conf;
			$user_config = FreshRSS_Context::$user_conf;
			$old_email = $user_config->mail_login;

			$email = Minz_Request::paramString('email');
			$passwordPlain = Minz_Request::paramString('newPasswordPlain', true);
			Minz_Request::_param('newPasswordPlain');	//Discard plain-text password ASAP
			$_POST['newPasswordPlain'] = '';

			if ($system_conf->force_email_validation && empty($email)) {
				Minz_Request::bad(
					_t('user.email.feedback.required'),
					['c' => 'user', 'a' => 'profile']
				);
			}

			if (!empty($email) && !validateEmailAddress($email)) {
				Minz_Request::bad(
					_t('user.email.feedback.invalid'),
					['c' => 'user', 'a' => 'profile']
				);
			}

			$ok = self::updateUser(
				Minz_User::name(),
				$email,
				$passwordPlain,
				[
					'token' => Minz_Request::paramString('token') ?: null,
				]
			);

			Minz_Session::_param('passwordHash', FreshRSS_Context::$user_conf->passwordHash);

			if ($ok) {
				if ($system_conf->force_email_validation && $email !== $old_email) {
					Minz_Request::good(_t('feedback.profile.updated'), ['c' => 'user', 'a' => 'validateEmail']);
				} elseif ($passwordPlain == '') {
					Minz_Request::good(_t('feedback.profile.updated'), ['c' => 'user', 'a' => 'profile']);
				} else {
					Minz_Request::good(_t('feedback.profile.updated'), ['c' => 'index', 'a' => 'index']);
				}
			} else {
				Minz_Request::bad(_t('feedback.profile.error'), ['c' => 'user', 'a' => 'profile']);
			}
		}
	}

	public function purgeAction(): void {
		if (!FreshRSS_Auth::hasAccess('admin')) {
			Minz_Error::error(403);
		}

		if (Minz_Request::isPost()) {
			$username = Minz_Request::paramString('username');

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
	public function manageAction(): void {
		if (!FreshRSS_Auth::hasAccess('admin')) {
			Minz_Error::error(403);
		}

		FreshRSS_View::prependTitle(_t('admin.user.title') . ' · ');

		if (Minz_Request::isPost()) {
			$action = Minz_Request::paramString('action');
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
		$this->view->current_user = Minz_Request::paramString('u');

		foreach (listUsers() as $user) {
			$this->view->users[$user] = $this->retrieveUserDetails($user);
		}
	}

	/** @param array<string,mixed> $userConfigOverride */
	public static function createUser(string $new_user_name, ?string $email, string $passwordPlain,
		array $userConfigOverride = [], bool $insertDefaultFeeds = true): bool {
		$userConfig = [];

		$customUserConfigPath = join_path(DATA_PATH, 'config-user.custom.php');
		if (file_exists($customUserConfigPath)) {
			$customUserConfig = include($customUserConfigPath);
			if (is_array($customUserConfig)) {
				$userConfig = $customUserConfig;
			}
		}

		$userConfig = array_merge($userConfig, $userConfigOverride);

		$ok = self::checkUsername($new_user_name);
		$homeDir = join_path(DATA_PATH, 'users', $new_user_name);
		$configPath = '';

		if ($ok) {
			$languages = Minz_Translate::availableLanguages();
			if (empty($userConfig['language']) || !in_array($userConfig['language'], $languages, true)) {
				$userConfig['language'] = 'en';
			}

			$ok &= !in_array(strtoupper($new_user_name), array_map('strtoupper', listUsers()), true);	//Not an existing user, case-insensitive

			$configPath = join_path($homeDir, 'config.php');
			$ok &= !file_exists($configPath);
		}
		if ($ok) {
			if (!is_dir($homeDir)) {
				mkdir($homeDir, 0770, true);
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
		return (bool)$ok;
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
	 */
	public function createAction(): void {
		if (!FreshRSS_Auth::hasAccess('admin') && max_registrations_reached()) {
			Minz_Error::error(403);
		}

		if (Minz_Request::isPost()) {
			$system_conf = FreshRSS_Context::$system_conf;

			$new_user_name = Minz_Request::paramString('new_user_name');
			$email = Minz_Request::paramString('new_user_email');
			$passwordPlain = Minz_Request::paramString('new_user_passwordPlain', true);
			$badRedirectUrl = [
				'c' => Minz_Request::paramString('originController') ?: 'auth',
				'a' => Minz_Request::paramString('originAction') ?: 'register',
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

			$tos_enabled = file_exists(TOS_FILENAME);
			$accept_tos = Minz_Request::paramBoolean('accept_tos');

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

			$ok = self::createUser($new_user_name, $email, $passwordPlain, [
				'language' => Minz_Request::paramString('new_user_language') ?: FreshRSS_Context::$user_conf->language,
				'timezone' => Minz_Request::paramString('new_user_timezone'),
				'is_admin' => Minz_Request::paramBoolean('new_user_is_admin'),
				'enabled' => true,
			]);
			Minz_Request::_param('new_user_passwordPlain');	//Discard plain-text password ASAP
			$_POST['new_user_passwordPlain'] = '';
			invalidateHttpCache();

			// If the user has admin access, it means he’s already logged in
			// and we don’t want to login with the new account. Otherwise, the
			// user just created its account himself so he probably wants to
			// get started immediately.
			if ($ok && !FreshRSS_Auth::hasAccess('admin')) {
				$user_conf = get_user_configuration($new_user_name);
				Minz_Session::_params([
					Minz_User::CURRENT_USER => $new_user_name,
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

		$redirect_url = ['c' => 'user', 'a' => 'manage'];
		Minz_Request::forward($redirect_url, true);
	}

	public static function deleteUser(string $username): bool {
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
			$filenames = glob(PSHB_PATH . '/feeds/*/' . $username . '.txt');
			if (!empty($filenames)) {
				array_map('unlink', $filenames);
			}
		}
		return (bool)$ok;
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
	 * it’s ok.
	 *
	 * It returns 404 error if `force_email_validation` is disabled or if the
	 * user doesn’t exist.
	 *
	 * It returns 403 if user isn’t logged in and `username` param isn’t passed.
	 */
	public function validateEmailAction(): void {
		if (!FreshRSS_Context::$system_conf->force_email_validation) {
			Minz_Error::error(404);
		}

		FreshRSS_View::prependTitle(_t('user.email.validation.title') . ' · ');
		$this->view->_layout('simple');

		$username = Minz_Request::paramString('username');
		$token = Minz_Request::paramString('token');

		if ($username !== '') {
			$user_config = get_user_configuration($username);
		} elseif (FreshRSS_Auth::hasAccess()) {
			$user_config = FreshRSS_Context::$user_conf;
		} else {
			Minz_Error::error(403);
			return;
		}

		if (!FreshRSS_UserDAO::exists($username) || $user_config === null) {
			Minz_Error::error(404);
			return;
		}

		if ($user_config->email_validation_token === '') {
			Minz_Request::good(
				_t('user.email.validation.feedback.unnecessary'),
				['c' => 'index', 'a' => 'index']
			);
		}

		if ($token != '') {
			if ($user_config->email_validation_token !== $token) {
				Minz_Request::bad(
					_t('user.email.validation.feedback.wrong_token'),
					['c' => 'user', 'a' => 'validateEmail']
				);
			}

			$user_config->email_validation_token = '';
			if ($user_config->save()) {
				Minz_Request::good(
					_t('user.email.validation.feedback.ok'),
					['c' => 'index', 'a' => 'index']
				);
			} else {
				Minz_Request::bad(
					_t('user.email.validation.feedback.error'),
					['c' => 'user', 'a' => 'validateEmail']
				);
			}
		}
	}

	/**
	 * This action resends a validation email to the current user.
	 *
	 * It only acts on POST requests but doesn’t require any param (except the
	 * CSRF token).
	 *
	 * It returns 403 error if the user is not logged in or 404 if request is
	 * not POST. Else it redirects silently to the index if user has already
	 * validated its email, or to the user#validateEmail route.
	 */
	public function sendValidationEmailAction(): void {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}

		if (!Minz_Request::isPost()) {
			Minz_Error::error(404);
		}

		$username = Minz_User::name();
		$user_config = FreshRSS_Context::$user_conf;

		if ($user_config->email_validation_token === '') {
			Minz_Request::forward([
				'c' => 'index',
				'a' => 'index',
			], true);
		}

		$mailer = new FreshRSS_User_Mailer();
		$ok = $mailer->send_email_need_validation($username, $user_config);

		$redirect_url = ['c' => 'user', 'a' => 'validateEmail'];
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
	public function deleteAction(): void {
		$username = Minz_Request::paramString('username');
		$self_deletion = Minz_User::name() === $username;

		if (!FreshRSS_Auth::hasAccess('admin') && !$self_deletion) {
			Minz_Error::error(403);
		}

		$redirect_url = ['c' => 'user', 'a' => 'manage'];

		if (Minz_Request::isPost()) {
			$ok = true;
			if ($self_deletion) {
				// We check the password if it’s a self-destruction
				$nonce = Minz_Session::param('nonce', '');
				$challenge = Minz_Request::paramString('challenge');

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
				$redirect_url = ['c' => 'index', 'a' => 'index'];
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

	public function promoteAction(): void {
		$this->toggleAction('is_admin', true);
	}

	public function demoteAction(): void {
		$this->toggleAction('is_admin', false);
	}

	public function enableAction(): void {
		$this->toggleAction('enabled', true);
	}

	public function disableAction(): void {
		$this->toggleAction('enabled', false);
	}

	private function toggleAction(string $field, bool $value): void {
		if (!FreshRSS_Auth::hasAccess('admin')) {
			Minz_Error::error(403);
		}

		if (!Minz_Request::isPost()) {
			Minz_Error::error(403);
		}

		$username = Minz_Request::paramString('username');
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
			Minz_Request::good(_t('feedback.user.updated', $username), ['c' => 'user', 'a' => 'manage']);
		} else {
			Minz_Request::bad(
				_t('feedback.user.updated.error', $username),
				['c' => 'user', 'a' => 'manage']
			);
		}
	}

	public function detailsAction(): void {
		if (!FreshRSS_Auth::hasAccess('admin')) {
			Minz_Error::error(403);
		}

		$username = Minz_Request::paramString('username');
		if (!FreshRSS_UserDAO::exists($username)) {
			Minz_Error::error(404);
		}

		if (Minz_Request::paramBoolean('ajax')) {
			$this->view->_layout(null);
		}

		$this->view->username = $username;
		$this->view->details = $this->retrieveUserDetails($username);
		FreshRSS_View::prependTitle($username . ' · ' . _t('gen.menu.user_management') . ' · ');
	}

	/** @return array{'feed_count':int,'article_count':int,'database_size':int,'language':string,'mail_login':string,'enabled':bool,'is_admin':bool,'last_user_activity':string,'is_default':bool} */
	private function retrieveUserDetails(string $username): array {
		$feedDAO = FreshRSS_Factory::createFeedDao($username);
		$entryDAO = FreshRSS_Factory::createEntryDao($username);
		$databaseDAO = FreshRSS_Factory::createDatabaseDAO($username);

		$userConfiguration = get_user_configuration($username);

		return [
			'feed_count' => $feedDAO->count(),
			'article_count' => $entryDAO->count(),
			'database_size' => $databaseDAO->size(),
			'language' => $userConfiguration->language,
			'mail_login' => $userConfiguration->mail_login,
			'enabled' => $userConfiguration->enabled,
			'is_admin' => $userConfiguration->is_admin,
			'last_user_activity' => date('c', FreshRSS_UserDAO::mtime($username)) ?: '',
			'is_default' => FreshRSS_Context::$system_conf->default_user === $username,
		];
	}
}
