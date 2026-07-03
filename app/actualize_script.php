#!/usr/bin/env php
<?php
declare(strict_types=1);
require dirname(__DIR__) . '/cli/_cli.php';

session_cache_limiter('');
ob_implicit_flush(false);
ob_start();

$begin_date = date_create('now');

// Optional feed ID argument.
// If none given, all feeds are updated.
$feedId = null;
if ($argc > 2) {
	fwrite(STDERR, "actualize_script.php takes at most one feed ID as an argument, aborting\n");
	die();
}
if ($argc == 2) {
	$feedId = filter_var($argv[1], FILTER_VALIDATE_INT, [
		'options' => ['min_range' => 1],
	]);

	if (!$feedId) {
		fwrite(STDERR, 'Invalid feed ID ' . $argv[1] . "\n");
		die();
	}
}

// Set the header params ($_GET) to call the FRSS application.
if ($feedId) {
	$_GET['id'] = $feedId;
	$_GET['maxFeeds'] = 1;
} else {
	$_GET['maxFeeds'] = PHP_INT_MAX;
}
$_GET['c'] = 'feed';
$_GET['a'] = 'actualize';
$_GET['ajax'] = 1;
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
$mutexFile = actualize_mutex_file(TMP_PATH, DATA_PATH);
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
$users = FreshRSS_user_Controller::listUsers();
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

	/**
	 * Count new and updated articles per feed, to report them on the output
	 * @var array<int,array{name:string,new:int,updated:int}> $feedStatistics
	 */
	$feedStatistics = [];

	Minz_ExtensionManager::addHook(Minz_HookType::FeedBeforeActualize, static function (FreshRSS_Feed $feed) use ($mutexFile, &$feedStatistics) {
		touch($mutexFile);
		$feedStatistics[$feed->id()] = [
			'name' => $feed->name() ?: $feed->url(false),
			'new' => 0,
			'updated' => 0,
		];
		return $feed;
	});
	Minz_ExtensionManager::addHook(Minz_HookType::EntryBeforeAdd, static function (FreshRSS_Entry $entry) use (&$feedStatistics) {
		if (isset($feedStatistics[$entry->feedId()])) {
			$feedStatistics[$entry->feedId()]['new'] = $feedStatistics[$entry->feedId()]['new'] + 1;
		}
		return $entry;
	});
	Minz_ExtensionManager::addHook(Minz_HookType::EntryBeforeUpdate, static function (FreshRSS_Entry $entry) use (&$feedStatistics) {
		if (isset($feedStatistics[$entry->feedId()])) {
			$feedStatistics[$entry->feedId()]['updated'] = $feedStatistics[$entry->feedId()]['updated'] + 1;
		}
		return $entry;
	});

	notice('FreshRSS actualize ' . $user . '…');
	echo $user, ' ';	//Buffered
	$app->run();

	// Sort by descending total number of articles, then alphabetically by feed name
	usort($feedStatistics, static fn(array $a, array $b): int =>
		(($b['new'] + $b['updated']) <=> ($a['new'] + $a['updated'])) ?: strcasecmp($a['name'], $b['name']));
	foreach ($feedStatistics as $row) {
		$parts = [];
		if ($row['new'] > 0) {
			$parts[] = $row['new'] . ' new';
		}
		if ($row['updated'] > 0) {
			$parts[] = $row['updated'] . ' updated';
		}
		if (!empty($parts)) {
			notice(implode(', ', $parts) . ' article(s) from feed: ' . $row['name']);
		}
	}

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
