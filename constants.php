<?php
define('FRESHRSS_VERSION', '1.2.0');
define('FRESHRSS_WEBSITE', 'http://freshrss.org');
define('FRESHRSS_WIKI', 'http://doc.freshrss.org');

// PHP text output compression http://php.net/ob_gzhandler (better to do it at Web server level)
define('PHP_COMPRESSION', false);

// Constantes de chemins
define('FRESHRSS_PATH', dirname(__FILE__));

	define('PUBLIC_PATH', FRESHRSS_PATH . '/p');
		define('PUBLIC_TO_INDEX_PATH', '/i');
		define('INDEX_PATH', PUBLIC_PATH . PUBLIC_TO_INDEX_PATH);
		define('PUBLIC_RELATIVE', '..');

	define('DATA_PATH', FRESHRSS_PATH . '/data');
		define('UPDATE_FILENAME', DATA_PATH . '/update.php');
		define('USERS_PATH', DATA_PATH . '/users');
		define('CACHE_PATH', DATA_PATH . '/cache');
		define('PSHB_PATH', DATA_PATH . '/PubSubHubbub');

	define('LIB_PATH', FRESHRSS_PATH . '/lib');
	define('APP_PATH', FRESHRSS_PATH . '/app');
	define('EXTENSIONS_PATH', FRESHRSS_PATH . '/extensions');

define('TMP_PATH', sys_get_temp_dir());
