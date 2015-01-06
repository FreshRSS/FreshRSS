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


// Set the header params ($_GET) to call the FRSS application.
$_GET['c'] = 'feed';
$_GET['a'] = 'actualize';
$_GET['ajax'] = 1;
$_GET['force'] = true;
$_SERVER['HTTP_HOST'] = '';


$app = new FreshRSS();
$app->init();

$system_conf = Minz_Configuration::get('system');
$system_conf->auth_type = 'none';  // avoid necessity to be logged in (not saved!)

// Create the list of users to actualize.
// Users are processed in a random order but always start with admin
$users = listUsers();
shuffle($users);
if ($system_conf->default_user !== ''){
	array_unshift($users, $system_conf->default_user);
	$users = array_unique($users);
}


$limits = $system_conf->limits;
$minLastActivity = time() - $limits['max_inactivity'];
foreach ($users as $myUser) {
	if (($myUser !== $system_conf->default_user) &&
			(FreshRSS_UserDAO::mtime($myUser) < $minLastActivity)) {
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


	Minz_Session::_param('currentUser', $myUser);
	FreshRSS_Auth::giveAccess();
	$app->run();


	if (!invalidateHttpCache()) {
		syslog(LOG_NOTICE, 'FreshRSS write access problem in ' . join_path(USERS_PATH, $myUser, 'log.txt'));
		if (defined('STDERR')) {
			fwrite(STDERR, 'Write access problem in ' . join_path(USERS_PATH, $myUser, 'log.txt') . "\n");
		}
	}
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
