<?php
class FreshRSS extends Minz_FrontController {
	public function init() {
		if (!isset($_SESSION)) {
			Minz_Session::init('FreshRSS');
		}

		FreshRSS_Auth::init();
		$this->loadConfiguration();
		$this->loadParamsView();
		if (Minz_Request::isPost() && !is_referer_from_same_domain()) {
			//Basic protection against XSRF attacks
			FreshRSS_Auth::removeAccess();
			Minz_Error::error(
				403,
				array('error' => array(_t('access_denied') . ' [HTTP_REFERER=' .
				      htmlspecialchars(empty($_SERVER['HTTP_REFERER']) ? '' : $_SERVER['HTTP_REFERER']) . ']'))
			);
		}
		$this->loadStylesAndScripts();
		$this->loadNotifications();
		$this->loadExtensions();
	}

	private function loadConfiguration() {
		$current_user = Minz_Session::param('currentUser');
		try {
			$this->conf = new FreshRSS_Configuration($current_user);
			Minz_View::_param('conf', $this->conf);
		} catch(Minz_Exception $e) {
			Minz_Log::error('Cannot load configuration file of user `' . $current_user . '`');
			die($e->getMessage());
		}
	}

	private function loadParamsView() {
		Minz_Session::_param('language', $this->conf->language);
		Minz_Translate::init();
		$output = Minz_Request::param('output', '');
		if (($output === '') || ($output !== 'normal' && $output !== 'rss' && $output !== 'reader' && $output !== 'global')) {
			$output = $this->conf->view_mode;
			Minz_Request::_param('output', $output);
		}
	}

	private function loadStylesAndScripts() {
		$theme = FreshRSS_Themes::load($this->conf->theme);
		if ($theme) {
			foreach($theme['files'] as $file) {
				if ($file[0] === '_') {
					$theme_id = 'base-theme';
					$filename = substr($file, 1);
				} else {
					$theme_id = $theme['id'];
					$filename = $file;
				}
				$filetime = @filemtime(PUBLIC_PATH . '/themes/' . $theme_id . '/' . $filename);
				Minz_View::appendStyle(Minz_Url::display(
					'/themes/' . $theme_id . '/' . $filename . '?' . $filetime
				));
			}
		}

		Minz_View::appendScript(Minz_Url::display('/scripts/jquery.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/jquery.min.js')));
		Minz_View::appendScript(Minz_Url::display('/scripts/shortcut.js?' . @filemtime(PUBLIC_PATH . '/scripts/shortcut.js')));
		Minz_View::appendScript(Minz_Url::display('/scripts/main.js?' . @filemtime(PUBLIC_PATH . '/scripts/main.js')));
	}

	private function loadNotifications() {
		$notif = Minz_Session::param('notification');
		if ($notif) {
			Minz_View::_param('notification', $notif);
			Minz_Session::_param('notification');
		}
	}

	private function loadExtensions() {
		$extensionPath = FRESHRSS_PATH . '/extensions/';
		//TODO: Add a preference to load only user-selected extensions
		foreach (scandir($extensionPath) as $key => $extension) {
			if (ctype_alpha($extension)) {
				$mtime = @filemtime($extensionPath . $extension . '/style.css');
				if ($mtime !== false) {
					Minz_View::appendStyle(Minz_Url::display('/ext.php?c&amp;e=' . $extension . '&amp;' . $mtime));
				}
				$mtime = @filemtime($extensionPath . $extension . '/script.js');
				if ($mtime !== false) {
					Minz_View::appendScript(Minz_Url::display('/ext.php?j&amp;e=' . $extension . '&amp;' . $mtime));
				}
				if (file_exists($extensionPath . $extension . '/module.php')) {
					//TODO: include
				} 
			}
		}
	}
}
