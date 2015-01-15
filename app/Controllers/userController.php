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
	 */
	public function firstAction() {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}
	}

	/**
	 * This action displays the user profile page.
	 */
	public function profileAction() {
		Minz_View::prependTitle(_t('conf.profile.title') . ' · ');

		if (Minz_Request::isPost()) {
			$ok = true;

			$passwordPlain = Minz_Request::param('passwordPlain', '', true);
			if ($passwordPlain != '') {
				Minz_Request::_param('passwordPlain');	//Discard plain-text password ASAP
				$_POST['passwordPlain'] = '';
				if (!function_exists('password_hash')) {
					include_once(LIB_PATH . '/password_compat.php');
				}
				$passwordHash = password_hash($passwordPlain, PASSWORD_BCRYPT, array('cost' => self::BCRYPT_COST));
				$passwordPlain = '';
				$passwordHash = preg_replace('/^\$2[xy]\$/', '\$2a\$', $passwordHash);	//Compatibility with bcrypt.js
				$ok &= ($passwordHash != '');
				FreshRSS_Context::$user_conf->passwordHash = $passwordHash;
			}
			Minz_Session::_param('passwordHash', FreshRSS_Context::$user_conf->passwordHash);

			$passwordPlain = Minz_Request::param('apiPasswordPlain', '', true);
			if ($passwordPlain != '') {
				if (!function_exists('password_hash')) {
					include_once(LIB_PATH . '/password_compat.php');
				}
				$passwordHash = password_hash($passwordPlain, PASSWORD_BCRYPT, array('cost' => self::BCRYPT_COST));
				$passwordPlain = '';
				$passwordHash = preg_replace('/^\$2[xy]\$/', '\$2a\$', $passwordHash);	//Compatibility with bcrypt.js
				$ok &= ($passwordHash != '');
				FreshRSS_Context::$user_conf->apiPasswordHash = $passwordHash;
			}

			// TODO: why do we need of hasAccess here?
			if (FreshRSS_Auth::hasAccess('admin')) {
				FreshRSS_Context::$user_conf->mail_login = Minz_Request::param('mail_login', '', true);
			}
			$email = FreshRSS_Context::$user_conf->mail_login;
			Minz_Session::_param('mail', $email);

			$ok &= FreshRSS_Context::$user_conf->save();

			if ($email != '') {
				$personaFile = DATA_PATH . '/persona/' . $email . '.txt';
				@unlink($personaFile);
				$ok &= (file_put_contents($personaFile, Minz_Session::param('currentUser', '_')) !== false);
			}

			if ($ok) {
				Minz_Request::good(_t('feedback.profile.updated'),
				                   array('c' => 'user', 'a' => 'profile'));
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

		// Get the correct current user.
		$username = Minz_Request::param('u', Minz_Session::param('currentUser'));
		if (!FreshRSS_UserDAO::exist($username)) {
			$username = Minz_Session::param('currentUser');
		}
		$this->view->current_user = $username;

		// Get information about the current user.
		$entryDAO = FreshRSS_Factory::createEntryDao($this->view->current_user);
		$this->view->nb_articles = $entryDAO->count();
		$this->view->size_user = $entryDAO->size();
	}

	public function createAction() {
		if (Minz_Request::isPost() && FreshRSS_Auth::hasAccess('admin')) {
			$db = FreshRSS_Context::$system_conf->db;
			require_once(APP_PATH . '/SQL/install.sql.' . $db['type'] . '.php');

			$new_user_language = Minz_Request::param('new_user_language', FreshRSS_Context::$user_conf->language);
			$languages = Minz_Translate::availableLanguages();
			if (!isset($languages[$new_user_language])) {
				$new_user_language = FreshRSS_Context::$user_conf->language;
			}

			$new_user_name = Minz_Request::param('new_user_name');
			$ok = ($new_user_name != '') && ctype_alnum($new_user_name);

			if ($ok) {
				$default_user = FreshRSS_Context::$system_conf->default_user;
				$ok &= (strcasecmp($new_user_name, $default_user) !== 0);	//It is forbidden to alter the default user

				$ok &= !in_array(strtoupper($new_user_name), array_map('strtoupper', listUsers()));	//Not an existing user, case-insensitive

				$configPath = join_path(DATA_PATH, 'users', $new_user_name, 'config.php');
				$ok &= !file_exists($configPath);
			}
			if ($ok) {
				$passwordPlain = Minz_Request::param('new_user_passwordPlain', '', true);
				$passwordHash = '';
				if ($passwordPlain != '') {
					Minz_Request::_param('new_user_passwordPlain');	//Discard plain-text password ASAP
					$_POST['new_user_passwordPlain'] = '';
					if (!function_exists('password_hash')) {
						include_once(LIB_PATH . '/password_compat.php');
					}
					$passwordHash = password_hash($passwordPlain, PASSWORD_BCRYPT, array('cost' => self::BCRYPT_COST));
					$passwordPlain = '';
					$passwordHash = preg_replace('/^\$2[xy]\$/', '\$2a\$', $passwordHash);	//Compatibility with bcrypt.js
					$ok &= ($passwordHash != '');
				}
				if (empty($passwordHash)) {
					$passwordHash = '';
				}

				$new_user_email = filter_var($_POST['new_user_email'], FILTER_VALIDATE_EMAIL);
				if (empty($new_user_email)) {
					$new_user_email = '';
				} else {
					$personaFile = join_path(DATA_PATH, 'persona', $new_user_email . '.txt');
					@unlink($personaFile);
					$ok &= (file_put_contents($personaFile, $new_user_name) !== false);
				}
			}
			if ($ok) {
				mkdir(join_path(DATA_PATH, 'users', $new_user_name));
				$config_array = array(
					'language' => $new_user_language,
					'passwordHash' => $passwordHash,
					'mail_login' => $new_user_email,
				);
				$ok &= (file_put_contents($configPath, "<?php\n return " . var_export($config_array, true) . ';') !== false);
			}
			if ($ok) {
				$userDAO = new FreshRSS_UserDAO();
				$ok &= $userDAO->createUser($new_user_name);
			}
			invalidateHttpCache();

			$notif = array(
				'type' => $ok ? 'good' : 'bad',
				'content' => _t('feedback.user.created' . (!$ok ? '.error' : ''), $new_user_name)
			);
			Minz_Session::_param('notification', $notif);
		}

		Minz_Request::forward(array('c' => 'user', 'a' => 'manage'), true);
	}

	public function deleteAction() {
		if (Minz_Request::isPost() && FreshRSS_Auth::hasAccess('admin')) {
			$db = FreshRSS_Context::$system_conf->db;
			require_once(APP_PATH . '/SQL/install.sql.' . $db['type'] . '.php');

			$username = Minz_Request::param('username');
			$ok = ctype_alnum($username);
			$user_data = join_path(DATA_PATH, 'users', $username);

			if ($ok) {
				$default_user = FreshRSS_Context::$system_conf->default_user;
				$ok &= (strcasecmp($username, $default_user) !== 0);	//It is forbidden to delete the default user
			}
			if ($ok) {
				$ok &= is_dir($user_data);
			}
			if ($ok) {
				$userDAO = new FreshRSS_UserDAO();
				$ok &= $userDAO->deleteUser($username);
				$ok &= recursive_unlink($user_data);
				//TODO: delete Persona file
			}
			invalidateHttpCache();

			$notif = array(
				'type' => $ok ? 'good' : 'bad',
				'content' => _t('feedback.user.deleted' . (!$ok ? '.error' : ''), $username)
			);
			Minz_Session::_param('notification', $notif);
		}

		Minz_Request::forward(array('c' => 'user', 'a' => 'manage'), true);
	}
}
