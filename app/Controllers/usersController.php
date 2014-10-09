<?php

class FreshRSS_users_Controller extends Minz_ActionController {

	const BCRYPT_COST = 9;	//Will also have to be computed client side on mobile devices, so do not use a too high cost

	public function firstAction() {
		if (!$this->view->loginOk) {
			Minz_Error::error(
				403,
				array('error' => array(Minz_Translate::t('access_denied')))
			);
		}
	}

	public function authAction() {
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
				$this->view->conf->_passwordHash($passwordHash);
			}
			Minz_Session::_param('passwordHash', $this->view->conf->passwordHash);

			$passwordPlain = Minz_Request::param('apiPasswordPlain', '', true);
			if ($passwordPlain != '') {
				if (!function_exists('password_hash')) {
					include_once(LIB_PATH . '/password_compat.php');
				}
				$passwordHash = password_hash($passwordPlain, PASSWORD_BCRYPT, array('cost' => self::BCRYPT_COST));
				$passwordPlain = '';
				$passwordHash = preg_replace('/^\$2[xy]\$/', '\$2a\$', $passwordHash);	//Compatibility with bcrypt.js
				$ok &= ($passwordHash != '');
				$this->view->conf->_apiPasswordHash($passwordHash);
			}

			if (Minz_Configuration::isAdmin(Minz_Session::param('currentUser', '_'))) {
				$this->view->conf->_mail_login(Minz_Request::param('mail_login', '', true));
			}
			$email = $this->view->conf->mail_login;
			Minz_Session::_param('mail', $email);

			$ok &= $this->view->conf->save();

			if ($email != '') {
				$personaFile = DATA_PATH . '/persona/' . $email . '.txt';
				@unlink($personaFile);
				$ok &= (file_put_contents($personaFile, Minz_Session::param('currentUser', '_')) !== false);
			}

			if (Minz_Configuration::isAdmin(Minz_Session::param('currentUser', '_'))) {
				$current_token = $this->view->conf->token;
				$token = Minz_Request::param('token', $current_token);
				$this->view->conf->_token($token);
				$ok &= $this->view->conf->save();

				$anon = Minz_Request::param('anon_access', false);
				$anon = ((bool)$anon) && ($anon !== 'no');
				$anon_refresh = Minz_Request::param('anon_refresh', false);
				$anon_refresh = ((bool)$anon_refresh) && ($anon_refresh !== 'no');
				$auth_type = Minz_Request::param('auth_type', 'none');
				$unsafe_autologin = Minz_Request::param('unsafe_autologin', false);
				$api_enabled = Minz_Request::param('api_enabled', false);
				if ($anon != Minz_Configuration::allowAnonymous() ||
					$auth_type != Minz_Configuration::authType() ||
					$anon_refresh != Minz_Configuration::allowAnonymousRefresh() ||
					$unsafe_autologin != Minz_Configuration::unsafeAutologinEnabled() ||
					$api_enabled != Minz_Configuration::apiEnabled()) {

					Minz_Configuration::_authType($auth_type);
					Minz_Configuration::_allowAnonymous($anon);
					Minz_Configuration::_allowAnonymousRefresh($anon_refresh);
					Minz_Configuration::_enableAutologin($unsafe_autologin);
					Minz_Configuration::_enableApi($api_enabled);
					$ok &= Minz_Configuration::writeFile();
				}
			}

			invalidateHttpCache();

			$notif = array(
				'type' => $ok ? 'good' : 'bad',
				'content' => Minz_Translate::t($ok ? 'configuration_updated' : 'error_occurred')
			);
			Minz_Session::_param('notification', $notif);
		}
		Minz_Request::forward(array('c' => 'configure', 'a' => 'users'), true);
	}

	public function createAction() {
		if (Minz_Request::isPost() && Minz_Configuration::isAdmin(Minz_Session::param('currentUser', '_'))) {
			$db = Minz_Configuration::dataBase();
			require_once(APP_PATH . '/SQL/install.sql.' . $db['type'] . '.php');

			$new_user_language = Minz_Request::param('new_user_language', $this->view->conf->language);
			if (!in_array($new_user_language, $this->view->conf->availableLanguages())) {
				$new_user_language = $this->view->conf->language;
			}

			$new_user_name = Minz_Request::param('new_user_name');
			$ok = ($new_user_name != '') && ctype_alnum($new_user_name);

			if ($ok) {
				$ok &= (strcasecmp($new_user_name, Minz_Configuration::defaultUser()) !== 0);	//It is forbidden to alter the default user

				$ok &= !in_array(strtoupper($new_user_name), array_map('strtoupper', listUsers()));	//Not an existing user, case-insensitive

				$configPath = DATA_PATH . '/' . $new_user_name . '_user.php';
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
					$personaFile = DATA_PATH . '/persona/' . $new_user_email . '.txt';
					@unlink($personaFile);
					$ok &= (file_put_contents($personaFile, $new_user_name) !== false);
				}
			}
			if ($ok) {
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
				'content' => Minz_Translate::t($ok ? 'user_created' : 'error_occurred', $new_user_name)
			);
			Minz_Session::_param('notification', $notif);
		}
		Minz_Request::forward(array('c' => 'configure', 'a' => 'users'), true);
	}

	public function deleteAction() {
		if (Minz_Request::isPost() && Minz_Configuration::isAdmin(Minz_Session::param('currentUser', '_'))) {
			$db = Minz_Configuration::dataBase();
			require_once(APP_PATH . '/SQL/install.sql.' . $db['type'] . '.php');

			$username = Minz_Request::param('username');
			$ok = ctype_alnum($username);

			if ($ok) {
				$ok &= (strcasecmp($username, Minz_Configuration::defaultUser()) !== 0);	//It is forbidden to delete the default user
			}
			if ($ok) {
				$configPath = DATA_PATH . '/' . $username . '_user.php';
				$ok &= file_exists($configPath);
			}
			if ($ok) {
				$userDAO = new FreshRSS_UserDAO();
				$ok &= $userDAO->deleteUser($username);
				$ok &= unlink($configPath);
				//TODO: delete Persona file
			}
			invalidateHttpCache();

			$notif = array(
				'type' => $ok ? 'good' : 'bad',
				'content' => Minz_Translate::t($ok ? 'user_deleted' : 'error_occurred', $username)
			);
			Minz_Session::_param('notification', $notif);
		}
		Minz_Request::forward(array('c' => 'configure', 'a' => 'users'), true);
	}
}
