<?php
define('FRESHRSS_VERSION', '0.7-dev');
define('FRESHRSS_WEBSITE', 'http://marienfressinaud.github.io/FreshRSS/');

// Constantes de chemins
define ('FRESHRSS_PATH', realpath (dirname (__FILE__)));
define ('PUBLIC_PATH', FRESHRSS_PATH . '/public');
define ('DATA_PATH', FRESHRSS_PATH . '/data');
define ('LIB_PATH', FRESHRSS_PATH . '/lib');
define ('APP_PATH', FRESHRSS_PATH . '/app');

define ('LOG_PATH', DATA_PATH . '/log');
define ('CACHE_PATH', DATA_PATH . '/cache');
