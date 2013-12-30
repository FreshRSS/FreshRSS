<?php
class FreshRSS extends Minz_FrontController {
	public function init($currentUser = null) {
		Minz_Session::init('FreshRSS');
		$this->accessControl($currentUser);
		$this->loadParamsView();
		$this->loadStylesAndScripts();
		$this->loadNotifications();
	}

	private function accessControl($currentUser) {
		if ($currentUser === null) {
			switch (Minz_Configuration::authType()) {
				case 'http_auth':
					$currentUser = httpAuthUser();
					$loginOk = $currentUser != '';
					break;
				case 'persona':
					$currentUser = Minz_Configuration::defaultUser();
					$loginOk = Minz_Session::param('mail') != '';
					break;
				case 'none':
					$currentUser = Minz_Configuration::defaultUser();
					$loginOk = true;
					break;
				default:
					$loginOk = false;
					break;
			}
		} elseif ((PHP_SAPI === 'cli') && (Minz_Request::actionName() === 'actualize')) {	//Command line
			Minz_Configuration::_authType('none');
			$loginOk = true;
		}

		if (!$loginOk || !isValidUser($currentUser)) {
			$currentUser = Minz_Configuration::defaultUser();
			$loginOk = false;
		}
		Minz_Configuration::_currentUser($currentUser);
		Minz_View::_param ('loginOk', $loginOk);

		try {
			$this->conf = new FreshRSS_Configuration($currentUser);
		} catch (Minz_Exception $e) {
			// Permission denied or conf file does not exist
			die($e->getMessage());
		}
		Minz_View::_param ('conf', $this->conf);
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
