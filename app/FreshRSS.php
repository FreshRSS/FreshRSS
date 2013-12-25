<?php
class FreshRSS extends Minz_FrontController {
	public function init () {
		Minz_Session::init ('FreshRSS');
		Minz_Translate::init ();

		$this->loadParamsView ();
		$this->loadStylesAndScripts ();
		$this->loadNotifications ();
	}

	private function loadParamsView () {
		try {
			$this->conf = Minz_Session::param ('conf', new FreshRSS_Configuration ());
		} catch (Minz_Exception $e) {
			// Permission denied or conf file does not exist
			// it's critical!
			print $e->getMessage();
			exit();
		}

		Minz_View::_param ('conf', $this->conf);
		Minz_Session::_param ('language', $this->conf->language ());

		$output = Minz_Request::param ('output');
		if(!$output) {
			$output = $this->conf->viewMode();
			Minz_Request::_param ('output', $output);
		}
	}

	private function loadStylesAndScripts () {
		$theme = FreshRSS_Themes::get_infos($this->conf->theme());
		if ($theme) {
			foreach($theme["files"] as $file) {
				Minz_View::appendStyle (Minz_Url::display ('/themes/' . $theme['path'] . '/' . $file . '?' . @filemtime(PUBLIC_PATH . '/themes/' . $theme['path'] . '/' . $file)));
			}
		}

		if (login_is_conf ($this->conf)) {
			Minz_View::appendScript ('https://login.persona.org/include.js');
		}
		$includeLazyLoad = $this->conf->lazyload () === 'yes' && ($this->conf->displayPosts () === 'yes' || Minz_Request::param ('output') === 'reader');
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
