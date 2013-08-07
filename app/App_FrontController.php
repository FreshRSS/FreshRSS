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

		Session::init (); // lancement de la session doit se faire après chargement des modèles sinon bug (pourquoi ?)

		$this->loadParamsView ();
		$this->loadStylesAndScripts ();
		$this->loadNotifications ();

		Translate::init ();
	}

	private function loadLibs () {
		require (LIB_PATH . '/lib_phpQuery.php');
		require (LIB_PATH . '/lib_rss.php');
		require (LIB_PATH . '/SimplePie_autoloader.php');
		require (LIB_PATH . '/lib_text.php');
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
		include (APP_PATH . '/models/Log.php');
	}

	private function loadParamsView () {
		$this->conf = Session::param ('conf', new RSSConfiguration ());
		View::_param ('conf', $this->conf);

		$entryDAO = new EntryDAO ();
		View::_param ('nb_not_read', $entryDAO->countNotRead ());

		Session::_param ('language', $this->conf->language ());
	}

	private function loadStylesAndScripts () {
		$theme = $this->conf->theme();
		View::appendStyle (Url::display ('/themes/' . $theme . '/style.css'));
		if (login_is_conf ($this->conf)) {
			View::appendScript ('https://login.persona.org/include.js');
		}
		View::appendScript (Url::display ('/scripts/jquery.js'));
		View::appendScript (Url::display ('/scripts/jquery.lazyload.min.js'));
		View::appendScript (Url::display ('/scripts/notification.js'));
	}

	private function loadNotifications () {
		$notif = Session::param ('notification');
		if ($notif) {
			View::_param ('notification', $notif);
			Session::_param ('notification');
		}
	}
}
