<?php

require('../constants.php');

include(LIB_PATH . '/Favicon/Favicon.php');
include(LIB_PATH . '/Favicon/DataAccess.php');
require(LIB_PATH . '/http-conditional.php');


$favicons_dir = DATA_PATH . '/favicons/';
$default_favicon = PUBLIC_PATH . '/themes/icons/default_favicon.ico';


/* Télécharge le favicon d'un site et le place sur le serveur */
function download_favicon($website, $dest) {
	global $favicons_dir, $default_favicon;

	$favicon_getter = new \Favicon\Favicon();
	$favicon_getter->setCacheDir($favicons_dir);
	$favicon_url = $favicon_getter->get($website);

	if ($favicon_url === false) {
		return @copy($default_favicon, $dest);
	}

	$c = curl_init($favicon_url);
	curl_setopt($c, CURLOPT_HEADER, false);
	curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($c, CURLOPT_BINARYTRANSFER, true);
	$img_raw = curl_exec($c);
	$status_code = curl_getinfo($c, CURLINFO_HTTP_CODE);
	curl_close($c);

	if ($status_code === 200) {
		$file = fopen($dest, 'w');
		if ($file !== false) {
			fwrite($file, $img_raw);
			fclose($file);
			return true;
		}
	}

	return false;
}


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

if ($ico_mtime == false || $txt_mtime > $ico_mtime) {
	if ($txt_mtime == false) {
		show_default_favicon(1800);
		return;
	}

	// no ico file or we should download a new one.
	$url = file_get_contents($txt);
	if (!download_favicon($url, $ico)) {
		// Download failed, show the default favicon
		show_default_favicon(86400);
		return;
	}
}

header('Content-Disposition: inline; filename="' . $id . '.ico"');

if (!httpConditional($ico_mtime, 2592000, 2)) {
	readfile($ico);
}
