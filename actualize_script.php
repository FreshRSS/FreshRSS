<?php
require('constants.php');

$_GET['c'] = 'feed';
$_GET['a'] = 'actualize';
$_GET['force'] = true;
$_SERVER['HTTP_HOST'] = '';

set_include_path (get_include_path ()
		 . PATH_SEPARATOR
		 . LIB_PATH
		 . PATH_SEPARATOR
		 . LIB_PATH . '/minz'
		 . PATH_SEPARATOR
		 . APP_PATH);

require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader

$front_controller = new FreshRSS ();
$front_controller->init ();
Minz_Session::_param('mail', true); // permet de se passer de la phase de connexion
$front_controller->run ();
invalidateHttpCache();
