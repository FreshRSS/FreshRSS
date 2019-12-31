#!/usr/bin/php
<?php
require(__DIR__ . '/../cli/_cli.php');

session_cache_limiter('');
ob_implicit_flush(false);
ob_start();
echo 'Results: ', "\n";	//Buffered

if (defined('STDOUT')) {
	$begin_date = date_create('now');
	fwrite(STDOUT, 'Starting feed actualization at ' . $begin_date->format('c') . "\n");	//Unbuffered
}

syslog(LOG_INFO, 'FreshRSS Start feeds actualization...');

// Set the header params ($_GET) to call the FRSS application.
$_GET['c'] = 'feed';
$_GET['a'] = 'actualize';
$_GET['ajax'] = 1;
$_GET['force'] = true;
$_SERVER['HTTP_HOST'] = '';

$app = new FreshRSS();

$system_conf = Minz_Configuration::get('system');
$system_conf->auth_type = 'none';  // avoid necessity to be logged in (not saved!)

// make sure the PHP setup of the CLI environment is compatible with FreshRSS as well
performRequirementCheck($system_conf->db['type']);

// Create the list of users to actualize.
// Users are processed in a random order but always start with admin
$users = listUsers();
shuffle($users);
if ($system_conf->default_user !== '') {
	array_unshift($users, $system_conf->default_user);
	$users = array_unique($users);
}

$limits = $system_conf->limits;
$min_last_activity = time() - $limits['max_inactivity'];
foreach ($users as $user) {
	if (($user !== $system_conf->default_user) &&
			(FreshRSS_UserDAO::mtime($user) < $min_last_activity)) {
		Minz_Log::notice('FreshRSS skip inactive user ' . $user, ADMIN_LOG);
		if (defined('STDOUT')) {
			fwrite(STDOUT, 'FreshRSS skip inactive user ' . $user . "\n");	//Unbuffered
		}
		continue;
	}
	Minz_Log::notice('FreshRSS actualize ' . $user, ADMIN_LOG);
	if (defined('STDOUT')) {
		fwrite(STDOUT, 'Actualize ' . $user . "...\n");	//Unbuffered
	}
	echo $user, ' ';	//Buffered


	Minz_Session::_param('currentUser', $user);
	new Minz_ModelPdo($user);	//TODO: FIXME: Quick-fix while waiting for a better FreshRSS() constructor/init
	FreshRSS_Auth::giveAccess();
	$app->init();
	$app->run();


	if (!invalidateHttpCache()) {
		Minz_Log::warning('FreshRSS write access problem in ' . join_path(USERS_PATH, $user, 'log.txt'), ADMIN_LOG);
		if (defined('STDERR')) {
			fwrite(STDERR, 'FreshRSS write access problem in ' . join_path(USERS_PATH, $user, 'log.txt') . "\n");
		}
	}
}

Minz_Log::notice('FreshRSS actualize done.', ADMIN_LOG);
if (defined('STDOUT')) {
	fwrite(STDOUT, 'Done.' . "\n");
	$end_date = date_create('now');
	$duration = date_diff($end_date, $begin_date);
	fwrite(STDOUT, 'Ending feed actualization at ' . $end_date->format('c') . "\n");	//Unbuffered
	fwrite(STDOUT, 'Feed actualizations took ' . $duration->format('%a day(s), %h hour(s), %i minute(s) and %s seconds') . ' for ' . count($users) . " users\n");	//Unbuffered
}
echo 'End.', "\n";
ob_end_flush();
syslog(LOG_INFO, 'FreshRSS feeds actualization done.');
