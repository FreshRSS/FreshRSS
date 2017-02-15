<?php

require('../constants.php');
require(LIB_PATH . '/favicons.php');
require(LIB_PATH . '/http-conditional.php');

function show_default_favicon($cacheSeconds = 3600) {
	global $default_favicon;

	header('Content-Disposition: inline; filename="default_favicon.ico"');

	$default_mtime = @filemtime($default_favicon);
	if (!httpConditional($default_mtime, $cacheSeconds, 2)) {
		readfile($default_favicon);
	}
}


$id = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '0';
if (!ctype_xdigit($id)) {
	$id = '0';
}

$txt = $favicons_dir . $id . '.txt';
$ico = $favicons_dir . $id . '.ico';

$ico_mtime = @filemtime($ico);
$txt_mtime = @filemtime($txt);

header('Content-Type: image/x-icon');

if ($ico_mtime == false || $ico_mtime < $txt_mtime || ($ico_mtime < time() - (rand(15, 20) * 86400))) {
	if ($txt_mtime == false) {
		show_default_favicon(1800);
		exit();
	}

	// no ico file or we should download a new one.
	$url = file_get_contents($txt);
	if (!download_favicon($url, $ico)) {
		// Download failed
		if ($ico_mtime == false) {
			show_default_favicon(86400);
			exit();
		} else {
			touch($ico);
		}
	}
}

header('Content-Disposition: inline; filename="' . $id . '.ico"');

if (!httpConditional($ico_mtime, rand(14, 21) * 86400, 2)) {
	readfile($ico);
}
