<?php
if (!isset($_GET['f']) ||
		!isset($_GET['t'])) {
	header('HTTP/1.1 400 Bad Request');
	die();
}

require(__DIR__ . '/../constants.php');

function is_valid_path_extension($path, $extensionPath) {
	// It must be under the extension path.
	$real_ext_path = realpath($extensionPath);

	//Windows compatibility
	$real_ext_path = str_replace('\\', '/', $real_ext_path);
	$path = str_replace('\\', '/', $path);

	$in_ext_path = (substr($path, 0, strlen($real_ext_path)) === $real_ext_path);
	if (!$in_ext_path) {
		return false;
	}

	// File to serve must be under a `ext_dir/static/` directory.
	$path_relative_to_ext = substr($path, strlen($real_ext_path) + 1);
	$path_splitted = explode('/', $path_relative_to_ext);
	if (count($path_splitted) < 3 || $path_splitted[1] !== 'static') {
		return false;
	}

	return true;
}

/**
 * Check if a file can be served by ext.php. A valid file is under a
 * CORE_EXTENSIONS_PATH/extension_name/static/ or THIRDPARTY_EXTENSIONS_PATH/extension_name/static/ directory.
 *
 * You should sanitize path by using the realpath() function.
 *
 * @param $path the path to the file we want to serve.
 * @return true if it can be served, false otherwise.
 *
 */
function is_valid_path($path) {
	return is_valid_path_extension($path, CORE_EXTENSIONS_PATH) || is_valid_path_extension($path, THIRDPARTY_EXTENSIONS_PATH);
}

$file_name = urldecode($_GET['f']);
$file_type = $_GET['t'];

$absolute_filename = realpath(EXTENSIONS_PATH . '/' . $file_name);

if (!is_valid_path($absolute_filename)) {
	header('HTTP/1.1 400 Bad Request');
	die();
}

switch ($file_type) {
case 'css':
	header('Content-Type: text/css; charset=UTF-8');
	header('Content-Disposition: inline; filename="' . $file_name . '"');
	break;
case 'js':
	header('Content-Type: application/javascript; charset=UTF-8');
	header('Content-Disposition: inline; filename="' . $file_name . '"');
	break;
case 'png':
	header('Content-Type: image/png');
	header('Content-Disposition: inline; filename="' . $file_name . '"');
	break;
case 'jpeg':
case 'jpg':
	header('Content-Type: image/jpeg');
	header('Content-Disposition: inline; filename="' . $file_name . '"');
	break;
case 'gif':
	header('Content-Type: image/gif');
	header('Content-Disposition: inline; filename="' . $file_name . '"');
	break;
case 'svg':
	header('Content-Type: image/svg+xml');
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
