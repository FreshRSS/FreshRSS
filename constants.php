<?php
define('FRESHRSS_VERSION', '0.8.0');
define('FRESHRSS_WEBSITE', 'http://freshrss.org');
define('FRESHRSS_UPDATE_WEBSITE', 'https://update.freshrss.org?v=' . FRESHRSS_VERSION);
define('FRESHRSS_WIKI', 'http://doc.freshrss.org');

// PHP text output compression http://php.net/ob_gzhandler (better to do it at Web server level)
define('PHP_COMPRESSION', false);

// Constantes de chemins
define('FRESHRSS_PATH', dirname(__FILE__));

	define('PUBLIC_PATH', FRESHRSS_PATH . '/p');
		define('INDEX_PATH', PUBLIC_PATH . '/i');
		define('PUBLIC_RELATIVE', '..');

	define('DATA_PATH', FRESHRSS_PATH . '/data');
		define('UPDATE_FILENAME', DATA_PATH . '/update.php');
		define('LOG_PATH', DATA_PATH . '/log');
		define('CACHE_PATH', DATA_PATH . '/cache');

	define('LIB_PATH', FRESHRSS_PATH . '/lib');
		define('APP_PATH', FRESHRSS_PATH . '/app');

define('TMP_PATH', sys_get_temp_dir());
