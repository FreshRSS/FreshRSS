<?php
require(dirname(__FILE__) . '/../constants.php');

//TODO: check if already running

$_GET['c'] = 'feed';
$_GET['a'] = 'actualize';
$_GET['force'] = true;
$_SERVER['HTTP_HOST'] = '';

require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader

$freshRSS = new FreshRSS ();

$users = listUsers();
shuffle($users);

foreach ($users as $user) {
	Minz_Session::init('FreshRSS');
	Minz_Session::_param('currentUser', $user);
	$freshRSS->init();
	$freshRSS->run();
	//invalidateHttpCache();
	touch(LOG_PATH . '/' . $user . '.log');
	Minz_Session::unset_session(true);
}
