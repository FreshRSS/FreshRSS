<?php

// Return a $_GET param, $default if it's not existing.
function param($key, $default = false) {
	if (isset($_GET[$key])) {
		return htmlspecialchars($_GET[$key], ENT_COMPAT, 'UTF-8');
	} else {
		return $default;
	}
}


// We return a simple text file (script).
header('Content-Type: text/plain; charset=utf-8');


$versions = require('versions.php');
$version = param('v', false);

// No version specified! You must do it with thê $_GET['v'] param.
if ($version === false) {
	echo 'NO_VERSION_SPECIFIED';
	return;
}

// Version specified is not in the versions array, so it is not supported!
if (!array_key_exists($version, $versions)) {
	echo 'INVALID_VERSION ' . $version;
	return;
}


$update_version = $versions[$version];
$filename_update = 'scripts/update_to_' . $update_version . '.php';

// Current version have no update because not specified or script doesn't exist.
if (is_null($update_version) || !file_exists($filename_update)) {
	echo 'NO_UPDATE ' . $version;
	return;
}


$content_util = file_get_contents('scripts/update_util.php');
$content = file_get_contents($filename_update);

// First line gives the version number, others correspond to the script.
echo 'UPDATE ' . $update_version . "\n";
echo $content_util;
echo $content;
