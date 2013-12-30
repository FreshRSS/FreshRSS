<?php
require(dirname(__FILE__) . '/../constants.php');

//TODO: check if already running

$_GET['c'] = 'feed';
$_GET['a'] = 'actualize';
$_GET['force'] = true;
$_SERVER['HTTP_HOST'] = '';

require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader

$front_controller = new FreshRSS ();

$users = listUsers();
shuffle($users);

foreach ($users as $user) {
	$front_controller->init($user);
	$front_controller->run();
	invalidateHttpCache($user);
}
