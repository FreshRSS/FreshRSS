<?php
declare(strict_types=1);
require dirname(__DIR__) . '/constants.php';
require LIB_PATH . '/lib_rss.php';	//Includes class autoloader

function get_absolute_filename(string $file_name): string {
	$core_extension = realpath(CORE_EXTENSIONS_PATH . '/' . $file_name);
	if (false !== $core_extension) {
		return $core_extension;
	}

	$third_party_extension = realpath(THIRDPARTY_EXTENSIONS_PATH . '/' . $file_name);
	if (false !== $third_party_extension) {
		$original_dir = THIRDPARTY_EXTENSIONS_PATH . '/' . explode('/', $file_name)[0];
		if (is_link($original_dir)) {
			return THIRDPARTY_EXTENSIONS_PATH . '/' . $file_name;
		}

		return $third_party_extension;
	}

	return '';
}

function is_valid_path_extension(string $path, string $extensionPath): bool {
	// It must be under the extension path.
	$real_ext_path = realpath($extensionPath);
	if ($real_ext_path == false) {
		return false;
	}

	//Windows compatibility
	$real_ext_path = str_replace('\\', '/', $real_ext_path);
	$path = str_replace('\\', '/', $path);

	$in_ext_path = (str_starts_with($path, $real_ext_path));
	if (!$in_ext_path) {
		return false;
	}

	// Static files to serve must be under a `ext_dir/static/` directory.
	$path_relative_to_ext = substr($path, strlen($real_ext_path) + 1);
	[, $static, $file] = sscanf($path_relative_to_ext, '%[^/]/%[^/]/%s') ?? [null, null, null];
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
 */
function is_valid_path(string $path): bool {
	return is_valid_path_extension($path, CORE_EXTENSIONS_PATH) || is_valid_path_extension($path, THIRDPARTY_EXTENSIONS_PATH);
}

function sendBadRequestResponse(?string $message = null): never {
	header('HTTP/1.1 400 Bad Request');
	die($message ?? 'Bad Request!');
}

function sendNotFoundResponse(): never {
	header('HTTP/1.1 404 Not Found');
	die('Not Found!');
}

if (!is_string($_GET['f'] ?? null)) {
	sendBadRequestResponse('Query string is incomplete.');
}

$file_name = urldecode($_GET['f']);
$file_type = pathinfo($file_name, PATHINFO_EXTENSION);
if (empty(FreshRSS_extension_Controller::MIME_TYPES[$file_type])) {
	sendBadRequestResponse('File type is not supported.');
}

// Forbid absolute paths and path traversal
if (str_contains($file_name, '..') || str_starts_with($file_name, '/') || str_starts_with($file_name, '\\')) {
	sendBadRequestResponse('File is not supported.');
}

$absolute_filename = get_absolute_filename($file_name);
if (!is_valid_path($absolute_filename)) {
	sendBadRequestResponse('File is not supported.');
}

$content_type = FreshRSS_extension_Controller::MIME_TYPES[$file_type];
header("Content-Type: {$content_type}");
header("Content-Disposition: inline; filename='{$file_name}'");
header("Content-Security-Policy: default-src 'self'; frame-ancestors 'none'");
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: same-origin');

$mtime = @filemtime($absolute_filename);
if ($mtime === false) {
	sendNotFoundResponse();
}

require LIB_PATH . '/http-conditional.php';

if (file_exists(DATA_PATH . '/no-cache.txt') || !httpConditional($mtime, 604800, 2)) {
	readfile($absolute_filename);
}
