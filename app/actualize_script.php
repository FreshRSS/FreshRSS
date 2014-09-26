<?php
require(dirname(__FILE__) . '/../constants.php');
require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader

session_cache_limiter('');
ob_implicit_flush(false);
ob_start();
echo 'Results: ', "\n";	//Buffered

Minz_Configuration::init();

$users = listUsers();
shuffle($users);	//Process users in random order
array_unshift($users, Minz_Configuration::defaultUser());	//But always start with admin
$users = array_unique($users);

foreach ($users as $myUser) {
	syslog(LOG_INFO, 'FreshRSS actualize ' . $myUser);
	if (defined('STDOUT')) {
		fwrite(STDOUT, 'Actualize ' . $myUser . "...\n");	//Unbuffered
	}
	echo $myUser, ' ';	//Buffered

	$_GET['c'] = 'feed';
	$_GET['a'] = 'actualize';
	$_GET['ajax'] = 1;
	$_GET['force'] = true;
	$_SERVER['HTTP_HOST'] = '';

	$freshRSS = new FreshRSS();

	Minz_Configuration::_authType('none');

	Minz_Session::init('FreshRSS');
	Minz_Session::_param('currentUser', $myUser);

	$freshRSS->init();
	$freshRSS->run();

	if (!invalidateHttpCache()) {
		syslog(LOG_NOTICE, 'FreshRSS write access problem in ' . LOG_PATH . '/*.log!');
		if (defined('STDERR')) {
			fwrite(STDERR, 'Write access problem in ' . LOG_PATH . '/*.log!' . "\n");
		}
	}
	Minz_Session::unset_session(true);
	Minz_ModelPdo::clean();
}
syslog(LOG_INFO, 'FreshRSS actualize done.');
if (defined('STDOUT')) {
	fwrite(STDOUT, 'Done.' . "\n");
}
echo 'End.', "\n";
ob_end_flush();
