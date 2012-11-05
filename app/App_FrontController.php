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
	}
	
	private function loadLibs () {
		require (LIB_PATH . '/lib_rss.php');
		require (LIB_PATH . '/lib_simplepie.php');
	}
	
	private function loadModels () {
		include (APP_PATH . '/models/RSSConfiguration.php');
		include (APP_PATH . '/models/Category.php');
		include (APP_PATH . '/models/Feed.php');
		include (APP_PATH . '/models/Entry.php');
	}
	
	private function loadStylesAndScripts () {
		View::prependStyle (Url::display ('/theme/base.css'));
		View::appendScript ('https://login.persona.org/include.js');
		View::appendScript (Url::display ('/scripts/jquery.js'));
		View::appendScript (Url::display ('/scripts/notification.js'));
	}
	
	private function loadParamsView () {
		View::_param ('conf', Session::param ('conf', new RSSConfiguration ()));
		
		$entryDAO = new EntryDAO ();
		View::_param ('nb_not_read', $entryDAO->countNotRead ());
	}
	
	private function loadNotifications () {
		$notif = Session::param ('notification');
		if ($notif) {
			View::_param ('notification', $notif);
			Session::_param ('notification');
		}
	}
}
