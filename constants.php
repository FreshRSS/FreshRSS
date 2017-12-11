<?php
define('FRESHRSS_VERSION', '1.8.1-dev');
define('FRESHRSS_WEBSITE', 'https://freshrss.org');
define('FRESHRSS_WIKI', 'https://freshrss.github.io/FreshRSS/');

define('FRESHRSS_USERAGENT', 'FreshRSS/' . FRESHRSS_VERSION . ' (' . PHP_OS . '; ' . FRESHRSS_WEBSITE . ')');

// PHP text output compression http://php.net/ob_gzhandler (better to do it at Web server level)
define('PHP_COMPRESSION', false);

// Maximum log file size in Bytes, before it will be divided by two
define('MAX_LOG_SIZE', 1048576);

// Constantes de chemins
define('FRESHRSS_PATH', dirname(__FILE__));

	define('PUBLIC_PATH', FRESHRSS_PATH . '/p');
		define('PUBLIC_TO_INDEX_PATH', '/i');
		define('INDEX_PATH', PUBLIC_PATH . PUBLIC_TO_INDEX_PATH);
		define('PUBLIC_RELATIVE', '..');

	define('DATA_PATH', FRESHRSS_PATH . '/data');
		define('UPDATE_FILENAME', DATA_PATH . '/update.php');
		define('USERS_PATH', DATA_PATH . '/users');
		define('ADMIN_LOG', USERS_PATH . '/_/log.txt');
		define('API_LOG', USERS_PATH . '/_/log_api.txt');
		define('CACHE_PATH', DATA_PATH . '/cache');
		define('PSHB_LOG', USERS_PATH . '/_/log_pshb.txt');
		define('PSHB_PATH', DATA_PATH . '/PubSubHubbub');

	define('LIB_PATH', FRESHRSS_PATH . '/lib');
	define('APP_PATH', FRESHRSS_PATH . '/app');
	define('EXTENSIONS_PATH', FRESHRSS_PATH . '/extensions');

define('TMP_PATH', sys_get_temp_dir());
