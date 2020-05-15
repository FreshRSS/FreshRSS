#!/usr/bin/php
<?php
require(__DIR__ . '/../cli/_cli.php');

/**
 * Writes to FreshRSS admin log, and if it is not already done by default,
 * writes to syslog (only if simplepie_syslog_enabled in FreshRSS configuration) and to STDERR
 */
function notice($message) {
	Minz_Log::notice($message, ADMIN_LOG);
	if (!COPY_LOG_TO_SYSLOG && SIMPLEPIE_SYSLOG_ENABLED) {
		syslog(LOG_NOTICE, $message);
	}
	if (defined('STDERR') && !COPY_SYSLOG_TO_STDERR) {
		fwrite(STDERR, $message . "\n");	//Unbuffered
	}
}

session_cache_limiter('');
ob_implicit_flush(false);
ob_start();
echo 'Results: ', "\n";	//Buffered

$begin_date = date_create('now');

// Set the header params ($_GET) to call the FRSS application.
$_GET['c'] = 'feed';
$_GET['a'] = 'actualize';
$_GET['ajax'] = 1;
$_GET['force'] = true;
$_SERVER['HTTP_HOST'] = '';

$app = new FreshRSS();

$system_conf = Minz_Configuration::get('system');
$system_conf->auth_type = 'none';  // avoid necessity to be logged in (not saved!)
define('SIMPLEPIE_SYSLOG_ENABLED', $system_conf->simplepie_syslog_enabled);

notice('FreshRSS starting feeds actualization at ' . $begin_date->format('c'));

// make sure the PHP setup of the CLI environment is compatible with FreshRSS as well
performRequirementCheck($system_conf->db['type']);

// Create the list of users to actualize.
// Users are processed in a random order but always start with default user
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
		notice('FreshRSS skip inactive user ' . $user);
		continue;
	}

	Minz_Session::_param('currentUser', $user);
	new Minz_ModelPdo($user);	//TODO: FIXME: Quick-fix while waiting for a better FreshRSS() constructor/init
	FreshRSS_Auth::giveAccess();
	$app->init();
	notice('FreshRSS actualize ' . $user . '...');
	echo $user, ' ';	//Buffered
	$app->run();

	if (!invalidateHttpCache()) {
		Minz_Log::warning('FreshRSS write access problem in ' . join_path(USERS_PATH, $user, 'log.txt'), ADMIN_LOG);
		if (defined('STDERR')) {
			fwrite(STDERR, 'FreshRSS write access problem in ' . join_path(USERS_PATH, $user, 'log.txt') . "\n");
		}
	}

	Minz_Session::_param('currentUser', '_');
	Minz_Session::_param('loginOk');
	gc_collect_cycles();
}

$end_date = date_create('now');
$duration = date_diff($end_date, $begin_date);
notice('FreshRSS actualization done for ' . count($users) .
	' users, using ' . format_bytes(memory_get_peak_usage(true)) . ' of memory, in ' .
	$duration->format('%a day(s), %h hour(s), %i minute(s) and %s seconds.'));

echo 'End.', "\n";
ob_end_flush();
