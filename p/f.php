<?php
declare(strict_types=1);
require dirname(__DIR__) . '/constants.php';
require LIB_PATH . '/lib_rss.php';	//Includes class autoloader
require LIB_PATH . '/favicons.php';
require LIB_PATH . '/http-conditional.php';

header("Content-Security-Policy: default-src 'none'; frame-ancestors 'none'; sandbox");
header('X-Content-Type-Options: nosniff');

$no_cache = file_exists(DATA_PATH . '/no-cache.txt');

function show_default_favicon(int $cacheSeconds = 3600): void {
	global $no_cache;
	$default_mtime = @filemtime(DEFAULT_FAVICON) ?: 0;
	if ($no_cache || !httpConditional($default_mtime, $cacheSeconds, 2)) {
		header('Content-Type: image/x-icon');
		header('Content-Disposition: inline; filename="default_favicon.ico"');
		readfile(DEFAULT_FAVICON);
	}
}

$id = $_GET['h'] ?? '0';
if (!is_string($id) || !ctype_xdigit($id)) {
	$id = '0';
}

$txt = FAVICONS_DIR . $id . '.txt';
$ico = FAVICONS_DIR . $id . '.ico';

$ico_mtime = @filemtime($ico) ?: 0;
$txt_mtime = @filemtime($txt) ?: 0;

$is_custom_favicon = $ico_mtime != false && $txt_mtime == false;

if (($ico_mtime == false || $ico_mtime < $txt_mtime || ($ico_mtime < time() - (mt_rand(15, 20) * 86400))) && !$is_custom_favicon) {
	if ($txt_mtime == false) {
		show_default_favicon(1800);
		exit();
	}

	// no ico file or we should download a new one.
	$url = file_get_contents($txt);
	if ($url === false) {
		show_default_favicon(1800);
		exit();
	}

	FreshRSS_Context::initSystem();
	if (!FreshRSS_Context::hasSystemConf()) {
		header('HTTP/1.1 500 Internal Server Error');
		die('Invalid system init!');
	}
	if (!download_favicon($url, $ico)) {
		// Download failed
		if ($ico_mtime == false) {
			show_default_favicon(86400);
			exit();
		}

		touch($ico);
	}
}

if ($no_cache || !httpConditional($ico_mtime, mt_rand(14, 21) * 86400, 2)) {
	$ico_content_type = contentType($ico);
	header('Content-Type: ' . $ico_content_type);
	header('Content-Disposition: inline; filename="' . $id . '.ico"');
	if (!$no_cache && isset($_GET['t'])) {
		header('Cache-Control: immutable');
	}
	readfile($ico);
}
