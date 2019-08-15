<?php

/**
 * Controller to handle user actions.
 */
class FreshRSS_user_Controller extends Minz_ActionController {
	// Will also have to be computed client side on mobile devices,
	// so do not use a too high cost
	const BCRYPT_COST = 9;

	/**
	 * This action is called before every other action in that class. It is
	 * the common boiler plate for every action. It is triggered by the
	 * underlying framework.
	 *
	 * @todo clean up the access condition.
	 */
	public function firstAction() {
		if (!FreshRSS_Auth::hasAccess() && !(
				Minz_Request::actionName() === 'create' &&
				!max_registrations_reached()
		)) {
			Minz_Error::error(403);
		}
	}

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

	public static function updateUser($user, $passwordPlain, $apiPasswordPlain, $userConfigUpdated = array()) {
		$userConfig = get_user_configuration($user);
		if ($userConfig === null) {
			return false;
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
			$ok = self::updateUser($username, $passwordPlain, $apiPasswordPlain, array(
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
		Minz_View::prependTitle(_t('conf.profile.title') . ' · ');

		Minz_View::appendScript(Minz_Url::display('/scripts/bcrypt.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/bcrypt.min.js')));

		if (Minz_Request::isPost()) {
			$passwordPlain = Minz_Request::param('newPasswordPlain', '', true);
			Minz_Request::_param('newPasswordPlain');	//Discard plain-text password ASAP
			$_POST['newPasswordPlain'] = '';

			$apiPasswordPlain = Minz_Request::param('apiPasswordPlain', '', true);

			$ok = self::updateUser(Minz_Session::param('currentUser'), $passwordPlain, $apiPasswordPlain, array(
					'token' => Minz_Request::param('token', null),
				));

			Minz_Session::_param('passwordHash', FreshRSS_Context::$user_conf->passwordHash);

			if ($ok) {
				if ($passwordPlain == '') {
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

	public static function createUser($new_user_name, $passwordPlain, $apiPasswordPlain, $userConfigOverride = array(), $insertDefaultFeeds = true) {
		if (!is_array(userConfigOverride)) {
			$userConfigOverride = array();
		}
		$userConfig = Minz_Configuration::load(join_path(DATA_PATH, 'config-user.php'));
		$userConfig = array_merge($userConfig, $userConfigOverride);

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
			$ok &= self::updateUser($new_user_name, $passwordPlain, $apiPasswordPlain);
		}
		return $ok;
	}

	/**
	 * This action creates a new user.
	 *
	 * Request parameters are:
	 *   - new_user_language
	 *   - new_user_name
	 *   - new_user_passwordPlain
	 *   - r (i.e. a redirection url, optional)
	 *
	 * @todo clean up this method. Idea: write a method to init a user with basic information.
	 * @todo handle r redirection in Minz_Request::forward directly?
	 */
	public function createAction() {
		if (Minz_Request::isPost() && (
				FreshRSS_Auth::hasAccess('admin') ||
				!max_registrations_reached()
		)) {
			$new_user_name = Minz_Request::param('new_user_name');
			$passwordPlain = Minz_Request::param('new_user_passwordPlain', '', true);
			$new_user_language = Minz_Request::param('new_user_language', FreshRSS_Context::$user_conf->language);

			$ok = self::createUser($new_user_name, $passwordPlain, '', array('language' => $new_user_language));
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
	 * This action delete an existing user.
	 *
	 * Request parameter is:
	 *   - username
	 *
	 * @todo clean up this method. Idea: create a User->clean() method.
	 */
	public function deleteAction() {
		$username = Minz_Request::param('username');
		$redirect_url = urldecode(Minz_Request::param('r', false, true));
		if (!$redirect_url) {
			$redirect_url = array('c' => 'user', 'a' => 'manage');
		}

		$self_deletion = Minz_Session::param('currentUser', '_') === $username;

		if (Minz_Request::isPost() && (
				FreshRSS_Auth::hasAccess('admin') ||
				$self_deletion
		)) {
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
