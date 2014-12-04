<?php
if (!isset($_GET['f']) ||
		!isset($_GET['t'])) {
	header('HTTP/1.1 400 Bad Request');
	die();
}

require('../constants.php');

$file_name = urldecode($_GET['f']);
$file_type = $_GET['t'];

$absolute_filename = EXTENSIONS_PATH . '/' . $file_name;

switch ($file_type) {
case 'css':
	header('Content-Type: text/css; charset=UTF-8');
	header('Content-Disposition: inline; filename="' . $file_name . '"');
	break;
case 'js':
	header('Content-Type: application/javascript; charset=UTF-8');
	header('Content-Disposition: inline; filename="' . $file_name . '"');
	break;
default:
	header('HTTP/1.1 400 Bad Request');
	die();
}

$mtime = @filemtime($absolute_filename);
if ($mtime === false) {
	header('HTTP/1.1 404 Not Found');
	die();
}

require(LIB_PATH . '/http-conditional.php');

if (!httpConditional($mtime, 604800, 2)) {
	readfile($absolute_filename);
}
