<?php
//NB: Do not edit; use ./constants.local.php instead.

//<Not customisable>
define('FRESHRSS_VERSION', '1.8.1-dev');
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

if (file_exists(__DIR__ . '/constants.local.php')) {
	//Include custom / local settings:
	include(__DIR__ . '/constants.local.php');
}

if (!defined('FRESHRSS_USERAGENT')) {
	define('FRESHRSS_USERAGENT', 'FreshRSS/' . FRESHRSS_VERSION . ' (' . PHP_OS . '; ' . FRESHRSS_WEBSITE . ')');
}
if (!defined('PHP_COMPRESSION')) {
	// PHP text output compression http://php.net/ob_gzhandler (better to do it at Web server level)
	define('PHP_COMPRESSION', false);
}
if (!defined('MAX_LOG_SIZE')) {
	// Maximum log file size in Bytes, before it will be divided by two
	define('MAX_LOG_SIZE', 1048576);
}
if (!defined('DATA_PATH')) {
	//This directory must be writable
	define('DATA_PATH', FRESHRSS_PATH . '/data');
}
if (!defined('UPDATE_FILENAME')) {
	define('UPDATE_FILENAME', DATA_PATH . '/update.php');
}
if (!defined('USERS_PATH')) {
	define('USERS_PATH', DATA_PATH . '/users');
}
if (!defined('ADMIN_LOG')) {
	define('ADMIN_LOG', USERS_PATH . '/_/log.txt');
}
if (!defined('API_LOG')) {
	define('API_LOG', USERS_PATH . '/_/log_api.txt');
}
if (!defined('CACHE_PATH')) {
	define('CACHE_PATH', DATA_PATH . '/cache');
}
if (!defined('PSHB_LOG')) {
	define('PSHB_LOG', USERS_PATH . '/_/log_pshb.txt');
}
if (!defined('PSHB_PATH')) {
	define('PSHB_PATH', DATA_PATH . '/PubSubHubbub');
}
if (!defined('TMP_PATH')) {
	//This directory must be writable
	//Used for feed mutex with *.freshrss.lock files
	define('TMP_PATH', sys_get_temp_dir());
}
