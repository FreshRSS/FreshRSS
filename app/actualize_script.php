<?php
require(dirname(__FILE__) . '/../constants.php');

$_GET['c'] = 'feed';
$_GET['a'] = 'actualize';
$_GET['force'] = true;
$_SERVER['HTTP_HOST'] = '';

require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader

$front_controller = new FreshRSS ();
$front_controller->init ();
Minz_Session::_param('mail', true); // permet de se passer de la phase de connexion
$front_controller->run ();
invalidateHttpCache();
