<?php
require('../constants.php');
$favicons_dir = DATA_PATH . '/favicons/';

/* Télécharge le favicon d'un site et le place sur le serveur */
function download_favicon ($website, $dest) {
	$ok = false;
	$url = 'http://g.etfv.co/' . $website;

	$c = curl_init ($url);
	curl_setopt ($c, CURLOPT_HEADER, false);
	curl_setopt ($c, CURLOPT_RETURNTRANSFER, true);
	curl_setopt ($c, CURLOPT_BINARYTRANSFER, true);
	$imgRaw = curl_exec ($c);

	if (curl_getinfo ($c, CURLINFO_HTTP_CODE) == 200) {
		$file = fopen ($dest, 'w');
		if ($file !== false) {
			fwrite ($file, $imgRaw);
			fclose ($file);
			$ok = true;
		}
	}
	curl_close ($c);
	if (!$ok) {
		header('Location: ' . $url);
		return false;
	}
	return true;
}

$id = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '0';

if (!ctype_xdigit($id)) {
	$id = '0';
}

$txt = $favicons_dir . $id . '.txt';
$ico = $favicons_dir . $id . '.ico';

$icoMTime = @filemtime($ico);
$txtMTime = @filemtime($txt);

if (($icoMTime == false) || ($txtMTime > $icoMTime)) {
	if ($txtMTime == false) {
		header('HTTP/1.1 404 Not Found');
		header('Content-Type: image/gif');
		readfile(PUBLIC_PATH . '/themes/icons/grey.gif');	//TODO: Better 404 favicon
		die();
	}
	$url = file_get_contents($txt);
	if (!download_favicon($url, $ico)) {
		die();
	}
}

require(LIB_PATH . '/http-conditional.php');

header('Content-Type: image/x-icon');
header('Content-Disposition: inline; filename="' . $id . '.ico"');

if (!httpConditional($icoMTime, 2592000, 2)) {
	readfile($ico);
}
