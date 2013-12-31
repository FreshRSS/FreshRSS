<?php

class FreshRSS_users_Controller extends Minz_ActionController {
	public function firstAction() {
		if (!$this->view->loginOk) {
			Minz_Error::error(
				403,
				array('error' => array(Minz_Translate::t('access_denied')))
			);
		}
	}

	public function idAction() {
		if (Minz_Request::isPost()) {
			$ok = true;
			$mail = Minz_Request::param('mail_login', false);
			$this->view->conf->_mail_login($mail);
			$ok &= $this->view->conf->save();

			$email = $this->view->conf->mail_login;
			Minz_Session::_param('mail', $email);

			if ($email != '') {
				$personaFile = DATA_PATH . '/persona/' . $email . '.txt';
				@unlink($personaFile);
				$ok &= (file_put_contents($personaFile, Minz_Session::param('currentUser', '_')) !== false);
			}
			invalidateHttpCache();

			//TODO: use $ok
			$notif = array(
				'type' => 'good',
				'content' => Minz_Translate::t('configuration_updated')
			);
			Minz_Session::_param('notification', $notif);

			Minz_Request::forward(array('c' => 'configure', 'a' => 'users'), true);
		}
	}

	public function authAction() {
		if (Minz_Request::isPost() && Minz_Configuration::isAdmin(Minz_Session::param('currentUser', '_'))) {
			$ok = true;
			$current_token = $this->view->conf->token;
			$token = Minz_Request::param('token', $current_token);
			$this->view->conf->_token($token);
			$ok &= $this->view->conf->save();

			$anon = Minz_Request::param('anon_access', false);
			$anon = ((bool)$anon) && ($anon !== 'no');
			$auth_type = Minz_Request::param('auth_type', 'none');
			if ($anon != Minz_Configuration::allowAnonymous() ||
				$auth_type != Minz_Configuration::authType()) {
				Minz_Configuration::_allowAnonymous($anon);
				Minz_Configuration::_authType($auth_type);
				$ok &= Minz_Configuration::writeFile();
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
			require_once(APP_PATH . '/sql.php');

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
				$new_user_email = filter_var($_POST['new_user_email'], FILTER_VALIDATE_EMAIL);
				if (empty($new_user_email)) {
					$new_user_email = '';
					$ok &= Minz_Configuration::authType() !== 'persona';
				} else {
					$personaFile = DATA_PATH . '/persona/' . $new_user_email . '.txt';
					@unlink($personaFile);
					$ok &= (file_put_contents($personaFile, $new_user_name) !== false);
				}
			}
			if ($ok) {
				$config_array = array(
					'language' => $new_user_language,
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
			require_once(APP_PATH . '/sql.php');

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
