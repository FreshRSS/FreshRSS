<?php
require(dirname(__FILE__) . '/../constants.php');

//<Mutex>
$lock = DATA_PATH . '/actualize.lock.txt';
if (file_exists($lock) && ((time() - @filemtime($lock)) > 3600)) {
	@unlink($lock);
}
if (($handle = @fopen($lock, 'x')) === false) {
	syslog(LOG_INFO, 'FreshRSS actualize already running?');
	return;
}
register_shutdown_function('unlink', $lock);
//Could use http://php.net/function.pcntl-signal.php to catch interruptions
@fclose($handle);
//</Mutex>

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
	fwrite(STDOUT, 'Actualize ' . $myUser . "...\n");	//Unbuffered
	echo $myUser, ' ';	//Buffered

	$_GET['c'] = 'feed';
	$_GET['a'] = 'actualize';
	$_GET['ajax'] = 1;
	$_GET['force'] = true;
	$_SERVER['HTTP_HOST'] = '';

	$freshRSS = new FreshRSS();
	$freshRSS->_useOb(false);

	Minz_Session::init('FreshRSS');
	Minz_Session::_param('currentUser', $myUser);

	$freshRSS->init();
	$freshRSS->run();

	invalidateHttpCache();
	Minz_Session::unset_session(true);
	Minz_ModelPdo::clean();
}
syslog(LOG_INFO, 'FreshRSS actualize done.');
ob_end_flush();
fwrite(STDOUT, 'Done.' . "\n");
