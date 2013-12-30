<?php
class FreshRSS extends Minz_FrontController {
	public function init() {
		if (!isset($_SESSION)) {
			Minz_Session::init('FreshRSS');
		}
		$this->accessControl(Minz_Session::param('currentUser', ''));
		$this->loadParamsView();
		$this->loadStylesAndScripts();
		$this->loadNotifications();
	}

	private function accessControl($currentUser) {
		if ($currentUser == '') {
			switch (Minz_Configuration::authType()) {
				case 'http_auth':
					$currentUser = httpAuthUser();
					$loginOk = $currentUser != '';
					break;
				case 'persona':
					$currentUser = Minz_Configuration::defaultUser();	//TODO: Make Persona compatible with multi-user
					$loginOk = Minz_Session::param('mail') != '';
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
		} catch (Minz_Exception $e) {
			Minz_Session::_param('currentUser', '');
			die('Invalid configuration for user [' . $currentUser . ']! ' . $e->getMessage());	//Permission denied or conf file does not exist
		}
		Minz_View::_param ('conf', $this->conf);
		Minz_Session::_param('currentUser', $currentUser);

		if ($loginOk) {
			switch (Minz_Configuration::authType()) {
				case 'http_auth':
					$loginOk = $currentUser === httpAuthUser();
					break;
				case 'persona':
					$loginOk = Minz_Session::param('mail') === $this->conf->mail_login;
					break;
				case 'none':
					$loginOk = true;
					break;
				default:
					$loginOk = false;
					break;
			}
			if ((!$loginOk) && (PHP_SAPI === 'cli') && (Minz_Request::actionName() === 'actualize')) {	//Command line
				Minz_Configuration::_authType('none');
				$loginOk = true;
			}
		}
		Minz_View::_param ('loginOk', $loginOk);
	}

	private function loadParamsView () {
		Minz_Session::_param ('language', $this->conf->language);
		Minz_Translate::init();
		$output = Minz_Request::param ('output');
		if (!$output) {
			$output = $this->conf->view_mode;
			Minz_Request::_param ('output', $output);
		}
	}

	private function loadStylesAndScripts () {
		$theme = FreshRSS_Themes::get_infos($this->conf->theme);
		if ($theme) {
			foreach($theme['files'] as $file) {
				Minz_View::appendStyle (Minz_Url::display ('/themes/' . $theme['path'] . '/' . $file . '?' . @filemtime(PUBLIC_PATH . '/themes/' . $theme['path'] . '/' . $file)));
			}
		}

		if (Minz_Configuration::authType() === 'persona') {
			Minz_View::appendScript ('https://login.persona.org/include.js');
		}
		$includeLazyLoad = $this->conf->lazyload && ($this->conf->display_posts || Minz_Request::param ('output') === 'reader');
		Minz_View::appendScript (Minz_Url::display ('/scripts/jquery.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/jquery.min.js')), false, !$includeLazyLoad, !$includeLazyLoad);
		if ($includeLazyLoad) {
			Minz_View::appendScript (Minz_Url::display ('/scripts/jquery.lazyload.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/jquery.lazyload.min.js')));
		}
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
