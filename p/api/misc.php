<?php
declare(strict_types=1);
/**
 * API entry point for FreshRSS extensions on
 * `/api/misc.php/Extension%20name/` or `/api/misc.php?ext=Extension%20name`
 */

require dirname(__DIR__, 2) . '/constants.php';
require LIB_PATH . '/lib_rss.php';	//Includes class autoloader

function badRequest(): never {
	header('HTTP/1.1 400 Bad Request');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Bad Request!');
}

function serviceUnavailable(): never {
	header('HTTP/1.1 503 Service Unavailable');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Service Unavailable!');
}

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
	badRequest();
}

Minz_Session::init('FreshRSS', volatile: true);

FreshRSS_Context::initSystem();
if (
	!FreshRSS_Context::hasSystemConf() ||
	!FreshRSS_Context::systemConf()->api_enabled ||
	empty(FreshRSS_Context::systemConf()->extensions_enabled[$extensionName])
) {
	serviceUnavailable();
}

// Only enable the extension that is being called
FreshRSS_Context::systemConf()->extensions_enabled = [$extensionName => true];
Minz_ExtensionManager::init();

Minz_Translate::init();

if (!Minz_ExtensionManager::callHookUnique(Minz_HookType::ApiMisc)) {
	serviceUnavailable();
}
