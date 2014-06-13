<?php
class FreshRSS extends Minz_FrontController {
	public function init() {
		if (!isset($_SESSION)) {
			Minz_Session::init('FreshRSS');
		}
		$loginOk = $this->accessControl(Minz_Session::param('currentUser', ''));
		$this->loadParamsView();
		$this->loadStylesAndScripts($loginOk);	//TODO: Do not load that when not needed, e.g. some Ajax requests
		$this->loadNotifications();
	}

	private function accessControl($currentUser) {
		if ($currentUser == '') {
			switch (Minz_Configuration::authType()) {
				case 'form':
					$currentUser = Minz_Configuration::defaultUser();
					Minz_Session::_param('passwordHash');
					$loginOk = false;
					break;
				case 'http_auth':
					$currentUser = httpAuthUser();
					$loginOk = $currentUser != '';
					break;
				case 'persona':
					$loginOk = false;
					$email = filter_var(Minz_Session::param('mail'), FILTER_VALIDATE_EMAIL);
					if ($email != '') {	//TODO: Remove redundancy with indexController
						$personaFile = DATA_PATH . '/persona/' . $email . '.txt';
						if (($currentUser = @file_get_contents($personaFile)) !== false) {
							$currentUser = trim($currentUser);
							$loginOk = true;
						}
					}
					if (!$loginOk) {
						$currentUser = Minz_Configuration::defaultUser();
					}
					break;
				case 'none':
					$currentUser = Minz_Configuration::defaultUser();
					$loginOk = true;
					break;
				default:
					$currentUser = Minz_Configuration::defaultUser();
					$loginOk = false;
					break;
			}
		} else {
			$loginOk = true;
		}

		if (!ctype_alnum($currentUser)) {
			Minz_Session::_param('currentUser', '');
			die('Invalid username [' . $currentUser . ']!');
		}

		try {
			$this->conf = new FreshRSS_Configuration($currentUser);
			Minz_View::_param ('conf', $this->conf);
			Minz_Session::_param('currentUser', $currentUser);
		} catch (Minz_Exception $me) {
			$loginOk = false;
			try {
				$this->conf = new FreshRSS_Configuration(Minz_Configuration::defaultUser());
				Minz_Session::_param('currentUser', Minz_Configuration::defaultUser());
				Minz_View::_param('conf', $this->conf);
				$notif = array(
					'type' => 'bad',
					'content' => 'Invalid configuration for user [' . $currentUser . ']!',
				);
				Minz_Session::_param ('notification', $notif);
				Minz_Log::record ($notif['content'] . ' ' . $me->getMessage(), Minz_Log::WARNING);
				Minz_Session::_param('currentUser', '');
			} catch (Exception $e) {
				die($e->getMessage());
			}
		}

		if ($loginOk) {
			switch (Minz_Configuration::authType()) {
				case 'form':
					$loginOk = Minz_Session::param('passwordHash') === $this->conf->passwordHash;
					break;
				case 'http_auth':
					$loginOk = strcasecmp($currentUser, httpAuthUser()) === 0;
					break;
				case 'persona':
					$loginOk = strcasecmp(Minz_Session::param('mail'), $this->conf->mail_login) === 0;
					break;
				case 'none':
					$loginOk = true;
					break;
				default:
					$loginOk = false;
					break;
			}
		}
		Minz_View::_param ('loginOk', $loginOk);
		return $loginOk;
	}

	private function loadParamsView () {
		Minz_Session::_param ('language', $this->conf->language);
		Minz_Translate::init();
		$output = Minz_Request::param ('output', '');
		if (($output === '') || ($output !== 'normal' && $output !== 'rss' && $output !== 'reader' && $output !== 'global')) {
			$output = $this->conf->view_mode;
			Minz_Request::_param ('output', $output);
		}
	}

	private function loadStylesAndScripts ($loginOk) {
		$theme = FreshRSS_Themes::load($this->conf->theme);
		if ($theme) {
			foreach($theme['files'] as $file) {
				Minz_View::appendStyle (Minz_Url::display ('/themes/' . $theme['id'] . '/' . $file . '?' . @filemtime(PUBLIC_PATH . '/themes/' . $theme['id'] . '/' . $file)));
			}
		}

		switch (Minz_Configuration::authType()) {
			case 'form':
				if (!$loginOk) {
					Minz_View::appendScript(Minz_Url::display ('/scripts/bcrypt.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/bcrypt.min.js')));
				}
				break;
			case 'persona':
				Minz_View::appendScript('https://login.persona.org/include.js');
				break;
		}
		$includeLazyLoad = $this->conf->lazyload && ($this->conf->display_posts || Minz_Request::param ('output') === 'reader');
		Minz_View::appendScript (Minz_Url::display ('/scripts/jquery.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/jquery.min.js')), false, !$includeLazyLoad, !$includeLazyLoad);
		if ($includeLazyLoad) {
			Minz_View::appendScript (Minz_Url::display ('/scripts/jquery.lazyload.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/jquery.lazyload.min.js')));
		}
		Minz_View::appendScript (Minz_Url::display ('/scripts/shortcut.js?' . @filemtime(PUBLIC_PATH . '/scripts/shortcut.js')));
		Minz_View::appendScript (Minz_Url::display ('/scripts/main.js?' . @filemtime(PUBLIC_PATH . '/scripts/main.js')));
	}

	private function loadNotifications () {
		$notif = Minz_Session::param ('notification');
		if ($notif) {
			Minz_View::_param ('notification', $notif);
			Minz_Session::_param ('notification');
		}
	}
}
