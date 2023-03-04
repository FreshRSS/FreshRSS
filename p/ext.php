<?php

require(__DIR__ . '/../constants.php');

// Supported types with their associated content type
const SUPPORTED_TYPES = [
	'css' => 'text/css; charset=UTF-8',
	'js' => 'application/javascript; charset=UTF-8',
	'png' => 'image/png',
	'jpeg' => 'image/jpeg',
	'jpg' => 'image/jpeg',
	'gif' => 'image/gif',
	'svg' => 'image/svg+xml',
];

function get_absolute_filename(string $file_name): string {
	$core_extension = realpath(CORE_EXTENSIONS_PATH . '/' . $file_name);
	if (false !== $core_extension) {
		return $core_extension;
	}

	$extension = realpath(EXTENSIONS_PATH . '/' . $file_name);
	if (false !== $extension) {
		return $extension;
	}

	$third_party_extension = realpath(THIRDPARTY_EXTENSIONS_PATH . '/' . $file_name);
	if (false !== $third_party_extension) {
		return $third_party_extension;
	}

	$user = realpath(USERS_PATH . '/' . $file_name);
	if (false !== $user) {
		return $user;
	}

	return '';
}

function is_valid_path_extension(string $path, string $extensionPath, bool $isStatic = true): bool {
	// It must be under the extension path.
	$real_ext_path = realpath($extensionPath);
	if ($real_ext_path == false) {
		return false;
	}

	//Windows compatibility
	$real_ext_path = str_replace('\\', '/', $real_ext_path);
	$path = str_replace('\\', '/', $path);

	$in_ext_path = (substr($path, 0, strlen($real_ext_path)) === $real_ext_path);
	if (!$in_ext_path) {
		return false;
	}

	// User files do not need further validations
	if (!$isStatic) {
		return true;
	}

	// Static files to serve must be under a `ext_dir/static/` directory.
	$path_relative_to_ext = substr($path, strlen($real_ext_path) + 1);
	list(, $static, $file) = sscanf($path_relative_to_ext, '%[^/]/%[^/]/%s') ?? [null, null, null];
	if (null === $file || 'static' !== $static) {
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
 * @param string $path the path to the file we want to serve.
 * @return bool true if it can be served, false otherwise.
 *
 */
function is_valid_path(string $path): bool {
	return is_valid_path_extension($path, CORE_EXTENSIONS_PATH) || is_valid_path_extension($path, THIRDPARTY_EXTENSIONS_PATH)
		|| is_valid_path_extension($path, USERS_PATH, false);
}

/** @return never */
function sendBadRequestResponse(string $message = null) {
	header('HTTP/1.1 400 Bad Request');
	die($message);
}

/** @return never */
function sendNotFoundResponse() {
	header('HTTP/1.1 404 Not Found');
	die();
}

if (!isset($_GET['f']) ||
	!isset($_GET['t'])) {
	sendBadRequestResponse('Query string is incomplete.');
}

$file_name = urldecode($_GET['f']);
$file_type = $_GET['t'];
if (empty(SUPPORTED_TYPES[$file_type]) ||
	empty(SUPPORTED_TYPES[pathinfo($file_name, PATHINFO_EXTENSION)])) {
	sendBadRequestResponse('File type is not supported.');
}

$absolute_filename = get_absolute_filename($file_name);
if (!is_valid_path($absolute_filename)) {
	sendBadRequestResponse('File is not supported.');
}

$content_type = SUPPORTED_TYPES[$file_type];
header("Content-Type: {$content_type}");
header("Content-Disposition: inline; filename='{$file_name}'");

$mtime = @filemtime($absolute_filename);
if ($mtime === false) {
	sendNotFoundResponse();
}

require(LIB_PATH . '/http-conditional.php');

if (!httpConditional($mtime, 604800, 2)) {
	readfile($absolute_filename);
}
