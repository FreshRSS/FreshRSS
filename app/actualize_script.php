#!/usr/bin/env php
<?php
// declare(strict_types=1);	// Need to wait for PHP 8+ due to https://php.net/ob-implicit-flush
require(__DIR__ . '/../cli/_cli.php');

session_cache_limiter('');
ob_implicit_flush(false);
ob_start();

$begin_date = date_create('now');

// Set the header params ($_GET) to call the FRSS application.
$_GET['c'] = 'feed';
$_GET['a'] = 'actualize';
$_GET['ajax'] = 1;
$_GET['maxFeeds'] = PHP_INT_MAX;
$_SERVER['HTTP_HOST'] = '';

$app = new FreshRSS();

FreshRSS_Context::initSystem();
FreshRSS_Context::systemConf()->auth_type = 'none';  // avoid necessity to be logged in (not saved!)
define('SIMPLEPIE_SYSLOG_ENABLED', FreshRSS_Context::systemConf()->simplepie_syslog_enabled);

/**
 * Writes to FreshRSS admin log, and if it is not already done by default,
 * writes to syslog (only if simplepie_syslog_enabled in FreshRSS configuration) and to STDOUT
 */
function notice(string $message): void {
	Minz_Log::notice($message, ADMIN_LOG);
	if (!COPY_LOG_TO_SYSLOG && SIMPLEPIE_SYSLOG_ENABLED) {
		syslog(LOG_NOTICE, $message);
	}
	if (defined('STDOUT') && !COPY_SYSLOG_TO_STDERR) {
		fwrite(STDOUT, $message . "\n");	//Unbuffered
	}
}

// <Mutex>
// Avoid having multiple actualization processes at the same time
$mutexFile = TMP_PATH . '/actualize.freshrss.lock';
$mutexTtl = 900; // seconds (refreshed before each new feed)
if (file_exists($mutexFile) && ((time() - (@filemtime($mutexFile) ?: 0)) > $mutexTtl)) {
	unlink($mutexFile);
}

if (($handle = @fopen($mutexFile, 'x')) === false) {
	notice('FreshRSS feeds actualization was already running, so aborting new run at ' . $begin_date->format('c'));
	die();
}
fclose($handle);

register_shutdown_function(static function () use ($mutexFile) {
	unlink($mutexFile);
});
// </Mutex>

notice('FreshRSS starting feeds actualization at ' . $begin_date->format('c'));

// make sure the PHP setup of the CLI environment is compatible with FreshRSS as well
echo 'Failed requirements!', "\n";
performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');
ob_clean();

echo 'Results: ', "\n";	//Buffered

// Create the list of users to actualize.
// Users are processed in a random order but always start with default user
$users = listUsers();
shuffle($users);
if (FreshRSS_Context::systemConf()->default_user !== '') {
	array_unshift($users, FreshRSS_Context::systemConf()->default_user);
	$users = array_unique($users);
}

$limits = FreshRSS_Context::systemConf()->limits;
$min_last_activity = time() - $limits['max_inactivity'];
foreach ($users as $user) {
	FreshRSS_Context::initUser($user);
	if (!FreshRSS_Context::hasUserConf()) {
		notice('Invalid user ' . $user);
		continue;
	}
	if (!FreshRSS_Context::userConf()->enabled) {
		notice('FreshRSS skip disabled user ' . $user);
		continue;
	}
	if (($user !== FreshRSS_Context::systemConf()->default_user) &&
			(FreshRSS_UserDAO::mtime($user) < $min_last_activity)) {
		notice('FreshRSS skip inactive user ' . $user);
		continue;
	}

	FreshRSS_Auth::giveAccess();

	// NB: Extensions and hooks are reinitialised there
	$app->init();

	Minz_ExtensionManager::addHook('feed_before_actualize', static function (FreshRSS_Feed $feed) use ($mutexFile) {
		touch($mutexFile);
		return $feed;
	});

	notice('FreshRSS actualize ' . $user . '…');
	echo $user, ' ';	//Buffered
	$app->run();

	if (!invalidateHttpCache()) {
		Minz_Log::warning('FreshRSS write access problem in ' . join_path(USERS_PATH, $user, LOG_FILENAME), ADMIN_LOG);
		if (defined('STDERR')) {
			fwrite(STDERR, 'FreshRSS write access problem in ' . join_path(USERS_PATH, $user, LOG_FILENAME) . "\n");
		}
	}

	gc_collect_cycles();
}

$end_date = date_create('now');
$duration = date_diff($end_date, $begin_date);
notice('FreshRSS actualization done for ' . count($users) .
	' users, using ' . format_bytes(memory_get_peak_usage(true)) . ' of memory, in ' .
	$duration->format('%a day(s), %h hour(s), %i minute(s) and %s seconds.'));

echo 'End.', "\n";
ob_end_flush();
