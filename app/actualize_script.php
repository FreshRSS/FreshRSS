<?php
require(dirname(__FILE__) . '/../constants.php');
require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader

session_cache_limiter('');
ob_implicit_flush(false);
ob_start();
echo 'Results: ', "\n";	//Buffered

if (defined('STDOUT')) {
	$begin_date = date_create('now');
	fwrite(STDOUT, 'Starting feed actualization at ' . $begin_date->format('c') . "\n");	//Unbuffered
}

Minz_Configuration::init();

$users = listUsers();
shuffle($users);	//Process users in random order

if (Minz_Configuration::defaultUser() !== ''){
	array_unshift($users, Minz_Configuration::defaultUser());	//But always start with admin
	$users = array_unique($users);
}

$limits = Minz_Configuration::limits();
$minLastActivity = time() - $limits['max_inactivity'];

foreach ($users as $myUser) {
	if (($myUser !== Minz_Configuration::defaultUser()) && (FreshRSS_UserDAO::mtime($myUser) < $minLastActivity)) {
		syslog(LOG_INFO, 'FreshRSS skip inactive user ' . $myUser);
		if (defined('STDOUT')) {
			fwrite(STDOUT, 'FreshRSS skip inactive user ' . $myUser . "\n");	//Unbuffered
		}
		continue;
	}
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
	$end_date = date_create('now');
	$duration = date_diff($end_date, $begin_date);
	fwrite(STDOUT, 'Ending feed actualization at ' . $end_date->format('c') . "\n");	//Unbuffered
	fwrite(STDOUT, 'Feed actualizations took ' . $duration->format('%a day(s), %h hour(s),  %i minute(s) and %s seconds') . ' for ' . count($users) . " users\n");	//Unbuffered
}
echo 'End.', "\n";
ob_end_flush();
