<?php
require(__DIR__.'/../vendor/autoload.php');

FreshRSS_Context::initSystem();
Minz_Request::forward(['c' => 'index', 'a' => 'index'], true);
