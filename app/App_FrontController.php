<?php
/** 
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/
require ('FrontController.php');

class App_FrontController extends FrontController {
	public function init () {
		$this->loadLibs ();
		$this->loadModels ();

		Session::init ();
		RSSThemes::init ();
		Translate::init ();

		$this->loadParamsView ();
		$this->loadStylesAndScripts ();
		$this->loadNotifications ();
	}

	private function loadLibs () {
		require (LIB_PATH . '/lib_phpQuery.php');
		require (LIB_PATH . '/lib_rss.php');
		require (LIB_PATH . '/SimplePie_autoloader.php');
	}

	private function loadModels () {
		include (APP_PATH . '/models/Exception/FeedException.php');
		include (APP_PATH . '/models/Exception/EntriesGetterException.php');
		include (APP_PATH . '/models/RSSConfiguration.php');
		include (APP_PATH . '/models/RSSThemes.php');
		include (APP_PATH . '/models/Days.php');
		include (APP_PATH . '/models/Category.php');
		include (APP_PATH . '/models/Feed.php');
		include (APP_PATH . '/models/Entry.php');
		include (APP_PATH . '/models/EntriesGetter.php');
		include (APP_PATH . '/models/RSSPaginator.php');
		include (APP_PATH . '/models/Log_Model.php');
	}

	private function loadParamsView () {
		try {
			$this->conf = Session::param ('conf', new RSSConfiguration ());
		} catch(MinzException $e) {
			// Permission denied or conf file does not exist
			// it's critical!
			print $e->getMessage();
			exit();
		}

		View::_param ('conf', $this->conf);

		$entryDAO = new EntryDAO ();
		View::_param ('nb_not_read', $entryDAO->countNotRead ());

		Session::_param ('language', $this->conf->language ());

		$output = Request::param ('output');
		if(!$output) {
			$output = $this->conf->viewMode();
			Request::_param ('output', $output);
		}
	}

	private function loadStylesAndScripts () {
		$theme = RSSThemes::get_infos($this->conf->theme());
		if ($theme) {
			foreach($theme["files"] as $file) {
				View::appendStyle (Url::display ('/themes/' . $theme['path'] . '/' . $file . '?' . @filemtime(PUBLIC_PATH . '/themes/' . $theme['path'] . '/' . $file)));
			}
		}
		View::appendStyle (Url::display ('/themes/printer/style.css?' . @filemtime(PUBLIC_PATH . '/themes/printer/style.css')), 'print');

		if (login_is_conf ($this->conf)) {
			View::appendScript ('https://login.persona.org/include.js');
		}
		$includeLazyLoad = $this->conf->lazyload () === 'yes' && ($this->conf->displayPosts () === 'yes' || Request::param ('output') === 'reader');
		View::appendScript (Url::display ('/scripts/jquery.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/jquery.min.js')), false, !$includeLazyLoad, !$includeLazyLoad);
		if ($includeLazyLoad) {
			View::appendScript (Url::display ('/scripts/jquery.lazyload.min.js?' . @filemtime(PUBLIC_PATH . '/scripts/jquery.lazyload.min.js')));
		}
		View::appendScript (Url::display ('/scripts/main.js?' . @filemtime(PUBLIC_PATH . '/scripts/main.js')));
	}

	private function loadNotifications () {
		$notif = Session::param ('notification');
		if ($notif) {
			View::_param ('notification', $notif);
			Session::_param ('notification');
		}
	}
}
