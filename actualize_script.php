<?php

// Constantes de chemins
define ('PUBLIC_PATH', realpath (dirname (__FILE__) . '/public'));
define ('LIB_PATH', realpath (PUBLIC_PATH . '/../lib'));
define ('APP_PATH', realpath (PUBLIC_PATH . '/../app'));
define ('LOG_PATH', realpath (PUBLIC_PATH . '/../log'));
define ('CACHE_PATH', realpath (PUBLIC_PATH . '/../cache'));

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

require (APP_PATH . '/App_FrontController.php');

$front_controller = new App_FrontController ();
$front_controller->init ();
Session::_param('mail', true); // permet de se passer de la phase de connexion
$front_controller->run ();
