<?php

function param($key, $default = false) {
	if (isset($_GET[$key])) {
		return htmlspecialchars($_GET[$key], ENT_COMPAT, 'UTF-8');
	} else {
		return $default;
	}
}

$versions = require('versions.php');
$version = param('v', false);


header('Content-Type: text/plain; charset=utf-8');


if ($version === false) {
	echo 'NO_VERSION_SPECIFIED';
	return;
}

if (!array_key_exists($version, $versions)) {
	echo 'INVALID_VERSION ' . $version;
	return;
}

$update_version = $versions[$version];
$filename_update = 'scripts/update_to_' . $update_version . '.php';

if (is_null($update_version) || !file_exists($filename_update)) {
	echo 'NO_UPDATE ' . $version;
	return;
}

$content_util = file_get_contents('scripts/update_util.php');
$content = file_get_contents($filename_update);

echo 'UPDATE ' . $update_version . "\n";
echo $content_util;
echo $content;
