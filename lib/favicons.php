<?php

include(LIB_PATH . '/Favicon/FaviconDLType.php');
include(LIB_PATH . '/Favicon/DataAccess.php');
include(LIB_PATH . '/Favicon/Favicon.php');

$favicons_dir = DATA_PATH . '/favicons/';
$default_favicon = PUBLIC_PATH . '/themes/icons/default_favicon.ico';

function download_favicon($website, $dest) {
	global $default_favicon;

	syslog(LOG_INFO, 'FreshRSS Favicon discovery GET ' . $website);
	$favicon_getter = new \Favicon\Favicon();
	$tmpPath = realpath(TMP_PATH);
	$favicon_getter->setCacheDir($tmpPath);
	$favicon_path = $favicon_getter->get($website, \Favicon\FaviconDLType::DL_FILE_PATH);

	return ($favicon_path != false && @rename($tmpPath . '/' . $favicon_path, $dest)) ||
		@copy($default_favicon, $dest);
}
