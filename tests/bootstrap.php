<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

const COPY_LOG_TO_SYSLOG = false;

require(__DIR__ . '/../constants.php');
require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader
