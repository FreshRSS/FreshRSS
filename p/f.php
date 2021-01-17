<?php
require(__DIR__ . '/../constants.php');
require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader
require(LIB_PATH . '/favicons.php');
require(LIB_PATH . '/http-conditional.php');

function show_default_favicon($cacheSeconds = 3600) {
	$default_mtime = @filemtime(DEFAULT_FAVICON);
	if (!httpConditional($default_mtime, $cacheSeconds, 2)) {
		header('Content-Type: image/x-icon');
		header('Content-Disposition: inline; filename="default_favicon.ico"');
		readfile(DEFAULT_FAVICON);
	}
}

$id = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '0';
if (!ctype_xdigit($id)) {
	$id = '0';
}

$txt = FAVICONS_DIR . $id . '.txt';
$ico = FAVICONS_DIR . $id . '.ico';

$ico_mtime = @filemtime($ico);
$txt_mtime = @filemtime($txt);

if ($ico_mtime == false || $ico_mtime < $txt_mtime || ($ico_mtime < time() - (mt_rand(15, 20) * 86400))) {
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

if (!httpConditional($ico_mtime, mt_rand(14, 21) * 86400, 2)) {
	$ico_content_type = 'image/x-icon';
	if (function_exists('mime_content_type')) {
		$ico_content_type = mime_content_type($ico);
	}
	switch ($ico_content_type) {
		case 'image/svg':
			$ico_content_type = 'image/svg+xml';
			break;
	}
	header('Content-Type: ' . $ico_content_type);
	header('Content-Disposition: inline; filename="' . $id . '.ico"');
	readfile($ico);
}
