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
		
		View::prependStyle (Url::display ('/theme/base.css'));
		View::_param ('conf', Session::param ('conf', new RSSConfiguration ()));
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
}
