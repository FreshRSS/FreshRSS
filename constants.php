<?php
//NB: Do not edit; use ./constants.local.php instead.

//<Not customisable>
define('FRESHRSS_MIN_PHP_VERSION', '5.6.0');
define('FRESHRSS_VERSION', '1.18.2-dev');
define('FRESHRSS_WEBSITE', 'https://freshrss.org');
define('FRESHRSS_WIKI', 'https://freshrss.github.io/FreshRSS/');

define('APP_NAME', 'FreshRSS');

define('FRESHRSS_PATH', __DIR__);
define('PUBLIC_PATH', FRESHRSS_PATH . '/p');
define('PUBLIC_TO_INDEX_PATH', '/i');
define('INDEX_PATH', PUBLIC_PATH . PUBLIC_TO_INDEX_PATH);
define('PUBLIC_RELATIVE', '..');
define('LIB_PATH', FRESHRSS_PATH . '/lib');
define('APP_PATH', FRESHRSS_PATH . '/app');
define('CORE_EXTENSIONS_PATH', LIB_PATH . '/core-extensions');
define('TESTS_PATH', FRESHRSS_PATH . '/tests');
//</Not customisable>

if (file_exists(__DIR__ . '/constants.local.php')) {
	//Include custom / local settings:
	include(__DIR__ . '/constants.local.php');
}

defined('FRESHRSS_USERAGENT') or define('FRESHRSS_USERAGENT', 'FreshRSS/' . FRESHRSS_VERSION . ' (' . PHP_OS . '; ' . FRESHRSS_WEBSITE . ')');

// PHP text output compression http://php.net/ob_gzhandler (better to do it at Web server level)
defined('PHP_COMPRESSION') or define('PHP_COMPRESSION', false);

defined('COPY_LOG_TO_SYSLOG') or define('COPY_LOG_TO_SYSLOG', filter_var(getenv('COPY_LOG_TO_SYSLOG'), FILTER_VALIDATE_BOOLEAN));
// For cases when syslog is not available
defined('COPY_SYSLOG_TO_STDERR') or define('COPY_SYSLOG_TO_STDERR', filter_var(getenv('COPY_SYSLOG_TO_STDERR'), FILTER_VALIDATE_BOOLEAN));

// Maximum log file size in Bytes, before it will be divided by two
defined('MAX_LOG_SIZE') or define('MAX_LOG_SIZE', 1048576);

//This directory must be writable
defined('DATA_PATH') or define('DATA_PATH', FRESHRSS_PATH . '/data');

defined('UPDATE_FILENAME') or define('UPDATE_FILENAME', DATA_PATH . '/update.php');
defined('USERS_PATH') or define('USERS_PATH', DATA_PATH . '/users');
defined('ADMIN_LOG') or define('ADMIN_LOG', USERS_PATH . '/_/log.txt');
defined('API_LOG') or define('API_LOG', USERS_PATH . '/_/log_api.txt');
defined('CACHE_PATH') or define('CACHE_PATH', DATA_PATH . '/cache');
defined('PSHB_LOG') or define('PSHB_LOG', USERS_PATH . '/_/log_pshb.txt');
defined('PSHB_PATH') or define('PSHB_PATH', DATA_PATH . '/PubSubHubbub');
defined('EXTENSIONS_DATA') or define('EXTENSIONS_DATA', DATA_PATH . '/extensions-data');
defined('THIRDPARTY_EXTENSIONS_PATH') or define('THIRDPARTY_EXTENSIONS_PATH', FRESHRSS_PATH . '/extensions');

//Deprecated constants
defined('EXTENSIONS_PATH') or define('EXTENSIONS_PATH', FRESHRSS_PATH . '/extensions');

//Directory used for feed mutex with *.freshrss.lock files. Must be writable.
defined('TMP_PATH') or define('TMP_PATH', sys_get_temp_dir());
