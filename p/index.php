<?php
declare(strict_types=1);

use FreshRss\Minz\Request;
use FreshRss\Models\Context;

require dirname(__DIR__) . '/constants.php';
require LIB_PATH . '/lib_rss.php';	//Includes class autoloader

Context::initSystem();
Request::forward(['c' => 'index', 'a' => 'index'], true);
