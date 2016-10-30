<?php

include(LIB_PATH . '/Favicon/Favicon.php');
include(LIB_PATH . '/Favicon/DataAccess.php');

$favicons_dir = DATA_PATH . '/favicons/';
$default_favicon = PUBLIC_PATH . '/themes/icons/default_favicon.ico';

function download_favicon($website, $dest) {
	global $favicons_dir, $default_favicon;

	syslog(LOG_DEBUG, 'FreshRSS Favicon discovery GET ' . $website);
	$favicon_getter = new \Favicon\Favicon();
	$favicon_getter->setCacheDir($favicons_dir);
	$favicon_url = $favicon_getter->get($website);

	if ($favicon_url === false) {
		return @copy($default_favicon, $dest);
	}

	syslog(LOG_DEBUG, 'FreshRSS Favicon GET ' . $favicon_url);
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
