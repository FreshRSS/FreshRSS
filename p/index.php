<?php
require(__DIR__ . '/../constants.php');
require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader

FreshRSS_Context::initSystem();
Minz_Request::forward(['c' => 'index', 'a' => 'index'], true);
