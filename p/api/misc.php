<?php
declare(strict_types=1);
/**
 * API entry point for FreshRSS extensions on
 * `/api/misc.php/Extension%20name/` or `/api/misc.php?ext=Extension%20name`
 */

require dirname(__DIR__, 2) . '/constants.php';
require LIB_PATH . '/lib_rss.php';	//Includes class autoloader

$extensionName = is_string($_GET['ext'] ?? null) ? $_GET['ext'] : '';

if ($extensionName === '') {
	$pathInfo = '';
	if (empty($_SERVER['PATH_INFO']) || !is_string($_SERVER['PATH_INFO'] ?? null)) {
		if (!empty($_SERVER['ORIG_PATH_INFO']) && is_string($_SERVER['ORIG_PATH_INFO'])) {
			// Compatibility https://php.net/reserved.variables.server
			$pathInfo = $_SERVER['ORIG_PATH_INFO'];
		}
	} else {
		$pathInfo = $_SERVER['PATH_INFO'];
	}
	$pathInfo = rawurldecode($pathInfo);
	$pathInfo = preg_replace('%^(/api)?(/misc\.php)?%', '', $pathInfo);	//Discard common errors
	if ($pathInfo !== '' && is_string($pathInfo)) {
		$pathInfos = explode('/', $pathInfo, limit: 3);
		if (count($pathInfos) > 1) {
			$extensionName = $pathInfos[1];
		}
	}
}

if ($extensionName === '') {
	header('HTTP/1.1 400 Bad Request');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Bad Request!');
}

Minz_Session::init('FreshRSS', volatile: true);

FreshRSS_Context::initSystem();
if (!FreshRSS_Context::hasSystemConf()) {
	header('HTTP/1.1 500 Internal Server Error');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Internal Server Error!');
}

if (!FreshRSS_Context::systemConf()->api_enabled) {
	header('HTTP/1.1 503 Service Unavailable');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Service Unavailable!');
}

if (empty(FreshRSS_Context::systemConf()->extensions_enabled[$extensionName])) {
	header('HTTP/1.1 404 Not Found');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Not Found!');
}

// Only enable the extension that is being called
FreshRSS_Context::systemConf()->extensions_enabled = [$extensionName => true];
Minz_ExtensionManager::init();

Minz_Translate::init();

if (!Minz_ExtensionManager::callHookUnique(Minz_HookType::ApiMisc)) {
	header('HTTP/1.1 501 Not Implemented');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Not Implemented!');
}
