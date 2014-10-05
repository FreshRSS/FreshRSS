<?php
if (!isset($_GET['e'])) {
	header('HTTP/1.1 400 Bad Request');
	die();
}
$extension = substr($_GET['e'], 0, 64);
if (!ctype_alpha($extension)) {
	header('HTTP/1.1 400 Bad Request');
	die();
}

require('../constants.php');
$filename = FRESHRSS_PATH . '/extensions/' . $extension . '/';

if (isset($_GET['j'])) {
	header('Content-Type: application/javascript; charset=UTF-8');
	header('Content-Disposition: inline; filename="script.js"');
	$filename .= 'script.js';
} elseif (isset($_GET['c'])) {
	header('Content-Type: text/css; charset=UTF-8');
	header('Content-Disposition: inline; filename="style.css"');
	$filename .= 'style.css';
}

$mtime = @filemtime($filename);
if ($mtime == false) {
	header('HTTP/1.1 404 Not Found');
	die();
}

require(LIB_PATH . '/http-conditional.php');

if (!httpConditional($mtime, 604800, 2)) {
	readfile($filename);
}
