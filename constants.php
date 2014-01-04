<?php
define('FRESHRSS_VERSION', '0.8-dev');
define('FRESHRSS_WEBSITE', 'http://freshrss.org');

// Constantes de chemins
define('FRESHRSS_PATH', dirname(__FILE__));

	define('PUBLIC_PATH', FRESHRSS_PATH . '/p');
		define('INDEX_PATH', PUBLIC_PATH . '/i');
		define('PUBLIC_RELATIVE', '..');

	define('DATA_PATH', FRESHRSS_PATH . '/data');
		define('LOG_PATH', DATA_PATH . '/log');
		define('CACHE_PATH', DATA_PATH . '/cache');

	define('LIB_PATH', FRESHRSS_PATH . '/lib');
		define('APP_PATH', FRESHRSS_PATH . '/app');
