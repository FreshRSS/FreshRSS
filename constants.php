<?php
//NB: Do not edit; use ./constants.local.php instead.

//<Not customisable>
define('FRESHRSS_VERSION', '1.13.0');
define('FRESHRSS_WEBSITE', 'https://freshrss.org');
define('FRESHRSS_WIKI', 'https://freshrss.github.io/FreshRSS/');

define('FRESHRSS_PATH', __DIR__);
define('PUBLIC_PATH', FRESHRSS_PATH . '/p');
define('PUBLIC_TO_INDEX_PATH', '/i');
define('INDEX_PATH', PUBLIC_PATH . PUBLIC_TO_INDEX_PATH);
define('PUBLIC_RELATIVE', '..');
define('LIB_PATH', FRESHRSS_PATH . '/lib');
define('APP_PATH', FRESHRSS_PATH . '/app');
define('EXTENSIONS_PATH', FRESHRSS_PATH . '/extensions');
//</Not customisable>

function safe_define($name, $value) {
	if (!defined($name)) {
		return define($name, $value);
	}
}

if (file_exists(__DIR__ . '/constants.local.php')) {
	//Include custom / local settings:
	include(__DIR__ . '/constants.local.php');
}

safe_define('FRESHRSS_USERAGENT', 'FreshRSS/' . FRESHRSS_VERSION . ' (' . PHP_OS . '; ' . FRESHRSS_WEBSITE . ')');

// PHP text output compression http://php.net/ob_gzhandler (better to do it at Web server level)
safe_define('PHP_COMPRESSION', false);

// Maximum log file size in Bytes, before it will be divided by two
safe_define('MAX_LOG_SIZE', 1048576);

//This directory must be writable
safe_define('DATA_PATH', FRESHRSS_PATH . '/data');

safe_define('UPDATE_FILENAME', DATA_PATH . '/update.php');
safe_define('USERS_PATH', DATA_PATH . '/users');
safe_define('ADMIN_LOG', USERS_PATH . '/_/log.txt');
safe_define('API_LOG', USERS_PATH . '/_/log_api.txt');
safe_define('CACHE_PATH', DATA_PATH . '/cache');
safe_define('PSHB_LOG', USERS_PATH . '/_/log_pshb.txt');
safe_define('PSHB_PATH', DATA_PATH . '/PubSubHubbub');

//Directory used for feed mutex with *.freshrss.lock files. Must be writable.
safe_define('TMP_PATH', sys_get_temp_dir());
