<?php
declare(strict_types=1);

if (!function_exists('mb_strcut')) {
	function mb_strcut(string $str, int $start, ?int $length = null, string $encoding = 'UTF-8'): string {
		return substr($str, $start, $length) ?: '';
	}
}

if (!function_exists('syslog')) {
	if (COPY_SYSLOG_TO_STDERR && !defined('STDERR')) {
		define('STDERR', fopen('php://stderr', 'w'));
	}
	function syslog(int $priority, string $message): bool {
		if (COPY_SYSLOG_TO_STDERR && defined('STDERR') && is_resource(STDERR)) {
			return fwrite(STDERR, $message . "\n") != false;
		}
		return false;
	}
}

if (function_exists('openlog')) {
	if (COPY_SYSLOG_TO_STDERR) {
		openlog('FreshRSS', LOG_CONS | LOG_ODELAY | LOG_PID | LOG_PERROR, LOG_USER);
	} else {
		openlog('FreshRSS', LOG_CONS | LOG_ODELAY | LOG_PID, LOG_USER);
	}
}

/**
 * Build a directory path by concatenating a list of directory names.
 *
 * @param string ...$path_parts a list of directory names
 * @return string corresponding to the final pathname
 */
function join_path(...$path_parts): string {
	return join(DIRECTORY_SEPARATOR, $path_parts);
}

//<Auto-loading>
function classAutoloader(string $class): void {
	if (str_starts_with($class, 'FreshRSS')) {
		$components = explode('_', $class);
		switch (count($components)) {
			case 1:
				include APP_PATH . '/' . $components[0] . '.php';
				return;
			case 2:
				include APP_PATH . '/Models/' . $components[1] . '.php';
				return;
			case 3:	//Controllers, Exceptions
				include APP_PATH . '/' . $components[2] . 's/' . $components[1] . $components[2] . '.php';
				return;
		}
	} elseif (str_starts_with($class, 'Minz')) {
		include LIB_PATH . '/' . str_replace('_', '/', $class) . '.php';
	} elseif (str_starts_with($class, 'SimplePie\\')) {
		$prefix = 'SimplePie\\';
		$base_dir = LIB_PATH . '/simplepie/simplepie/src/';
		$relative_class_name = substr($class, strlen($prefix));
		include $base_dir . str_replace('\\', '/', $relative_class_name) . '.php';
	} elseif (str_starts_with($class, 'Gt\\CssXPath\\')) {
		$prefix = 'Gt\\CssXPath\\';
		$base_dir = LIB_PATH . '/phpgt/cssxpath/src/';
		$relative_class_name = substr($class, strlen($prefix));
		include $base_dir . str_replace('\\', '/', $relative_class_name) . '.php';
	} elseif (str_starts_with($class, 'marienfressinaud\\LibOpml\\')) {
		$prefix = 'marienfressinaud\\LibOpml\\';
		$base_dir = LIB_PATH . '/marienfressinaud/lib_opml/src/LibOpml/';
		$relative_class_name = substr($class, strlen($prefix));
		include $base_dir . str_replace('\\', '/', $relative_class_name) . '.php';
	} elseif (str_starts_with($class, 'PHPMailer\\PHPMailer\\')) {
		$prefix = 'PHPMailer\\PHPMailer\\';
		$base_dir = LIB_PATH . '/phpmailer/phpmailer/src/';
		$relative_class_name = substr($class, strlen($prefix));
		include $base_dir . str_replace('\\', '/', $relative_class_name) . '.php';
	}
}

spl_autoload_register('classAutoloader');
//</Auto-loading>

/**
 * @param array<mixed,mixed> $array
 * @phpstan-assert-if-true array<string,mixed> $array
 */
function is_array_keys_string(array $array): bool {
	foreach ($array as $key => $value) {
		if (!is_string($key)) {
			return false;
		}
	}
	return true;
}

/**
 * @param array<mixed,mixed> $array
 * @phpstan-assert-if-true array<mixed,string> $array
 */
function is_array_values_string(array $array): bool {
	foreach ($array as $value) {
		if (!is_string($value)) {
			return false;
		}
	}
	return true;
}

/**
 * Memory efficient replacement of `echo json_encode(...)`
 * @param array<mixed>|mixed $json
 * @param int $optimisationDepth Number of levels for which to perform memory optimisation
 * before calling the faster native JSON serialisation.
 * Set to negative value for infinite depth.
 */
function echoJson($json, int $optimisationDepth = -1): void {
	if ($optimisationDepth === 0 || !is_array($json)) {
		echo json_encode($json, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		return;
	}
	$first = true;
	if (array_is_list($json)) {
		echo '[';
		foreach ($json as $item) {
			if ($first) {
				$first = false;
			} else {
				echo ',';
			}
			echoJson($item, $optimisationDepth - 1);
		}
		echo ']';
	} else {
		echo '{';
		foreach ($json as $key => $value) {
			if ($first) {
				$first = false;
			} else {
				echo ',';
			}
			echo json_encode($key, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), ':';
			echoJson($value, $optimisationDepth - 1);
		}
		echo '}';
	}
}

function safe_ascii(?string $text): string {
	return $text === null ? '' : (filter_var($text, FILTER_DEFAULT, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH) ?: '');
}

if (function_exists('mb_convert_encoding')) {
	function safe_utf8(?string $text): string {
		return $text === null ? '' : (mb_convert_encoding($text, 'UTF-8', 'UTF-8') ?: '');
	}
} elseif (function_exists('iconv')) {
	function safe_utf8(?string $text): string {
		return $text === null ? '' : (iconv('UTF-8', 'UTF-8//IGNORE', $text) ?: '');
	}
} else {
	function safe_utf8(?string $text): string {
		return $text ?? '';
	}
}

function escapeToUnicodeAlternative(string $text, bool $extended = true): string {
	$text = htmlspecialchars_decode($text, ENT_QUOTES);

	//Problematic characters
	$problem = ['&', '<', '>'];
	//Use their fullwidth Unicode form instead:
	$replace = ['＆', '＜', '＞'];

	// https://raw.githubusercontent.com/mihaip/google-reader-api/master/wiki/StreamId.wiki
	if ($extended) {
		$problem += ["'", '"', '^', '?', '\\', '/', ',', ';'];
		$replace += ["’", '＂', '＾', '？', '＼', '／', '，', '；'];
	}

	return trim(str_replace($problem, $replace, $text));
}

function format_number(int|float $n, int $precision = 0): string {
	// number_format does not seem to be Unicode-compatible
	return str_replace(' ', ' ',	// Thin non-breaking space
		number_format((float)$n, $precision, '.', ' ')
	);
}

function format_bytes(int $bytes, int $precision = 2, string $system = 'IEC'): string {
	if ($system === 'IEC') {
		$base = 1024;
		$units = ['B', 'KiB', 'MiB', 'GiB', 'TiB'];
	} elseif ($system === 'SI') {
		$base = 1000;
		$units = ['B', 'KB', 'MB', 'GB', 'TB'];
	} else {
		return format_number($bytes, $precision);
	}
	$bytes = max(intval($bytes), 0);
	$pow = $bytes === 0 ? 0 : (int)floor(log($bytes) / log($base));
	$pow = min(max(0, $pow), count($units) - 1);
	$bytes /= pow($base, $pow);
	return format_number($bytes, $precision) . ' ' . $units[$pow];
}

function timestamptodate(int $t, bool $hour = true): string {
	$month = _t('gen.date.' . date('M', $t));
	if ($hour) {
		$date = _t('gen.date.format_date_hour', $month);
	} else {
		$date = _t('gen.date.format_date', $month);
	}

	return @date($date, $t) ?: '';
}

/**
 * Decode HTML entities but preserve XML entities.
 */
function html_only_entity_decode(?string $text): string {
	/** @var array<string,string>|null $htmlEntitiesOnly */
	static $htmlEntitiesOnly = null;
	if ($htmlEntitiesOnly === null) {
		$htmlEntitiesOnly = array_flip(array_diff(
			get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES, 'UTF-8'),	//Decode HTML entities
			get_html_translation_table(HTML_SPECIALCHARS, ENT_NOQUOTES, 'UTF-8')	//Preserve XML entities
		));
	}
	return $text == null ? '' : strtr($text, $htmlEntitiesOnly);
}

/**
 * Remove passwords in FreshRSS logs.
 * See also ../cli/sensitive-log.sh for Web server logs.
 * @param array<string,mixed>|string $log
 * @return array<string,mixed>|string
 */
function sensitive_log(array|string $log): array|string {
	if (is_array($log)) {
		foreach ($log as $k => $v) {
			if (in_array($k, ['api_key', 'Passwd', 'T'], true)) {
				$log[$k] = '██';
			} elseif ((is_array($v) && is_array_keys_string($v)) || is_string($v)) {
				$log[$k] = sensitive_log($v);
			} else {
				return '';
			}
		}
	} elseif (is_string($log)) {
		$log = preg_replace([
				'/\b(auth=.*?\/)[^&]+/i',
				'/\b(Passwd=)[^&]+/i',
				'/\b(Authorization)[^&]+/i',
			], '$1█', $log) ?? '';
	}
	return $log;
}

function cleanCache(int $hours = 720): void {
	// N.B.: GLOB_BRACE is not available on all platforms
	$files = glob(CACHE_PATH . '/*.*', GLOB_NOSORT) ?: [];
	foreach ($files as $file) {
		if (str_ends_with($file, 'index.html')) {
			continue;
		}
		$cacheMtime = @filemtime($file);
		if ($cacheMtime !== false && $cacheMtime < time() - (3600 * $hours)) {
			unlink($file);
		}
	}
}

/**
 * Add support of image lazy loading
 * Move content from src/poster attribute to data-original
 * @param string $content is the text we want to parse
 */
function lazyimg(string $content): string {
	return preg_replace([
			'/<((?:img|image|iframe|track)[^>]+?)src="([^"]+)"([^>]*)>/i',
			"/<((?:img|image|iframe|track)[^>]+?)src='([^']+)'([^>]*)>/i",
			'/<((?:video)[^>]+?)poster="([^"]+)"([^>]*)>/i',
			"/<((?:video)[^>]+?)poster='([^']+)'([^>]*)>/i",
		], [
			'<$1src="' . Minz_Url::display('/themes/icons/grey.gif') . '" data-original="$2"$3>',
			"<$1src='" . Minz_Url::display('/themes/icons/grey.gif') . "' data-original='$2'$3>",
			'<$1poster="' . Minz_Url::display('/themes/icons/grey.gif') . '" data-original="$2"$3>',
			"<$1poster='" . Minz_Url::display('/themes/icons/grey.gif') . "' data-original='$2'$3>",
		],
		$content
	) ?? '';
}

/** @return numeric-string */
function uTimeString(): string {
	$t = gettimeofday();
	// @phpstan-ignore return.type
	return ((string)$t['sec']) . str_pad((string)$t['usec'], 6, '0', STR_PAD_LEFT);
}

function invalidateHttpCache(string $username = ''): bool {
	if (!FreshRSS_user_Controller::checkUsername($username)) {
		Minz_Session::_param('touch', uTimeString());
		$username = Minz_User::name() ?? Minz_User::INTERNAL_USER;
	}
	return FreshRSS_UserDAO::ctouch($username);
}

#[Deprecated('Use Minz_Request::connectionRemoteAddress() instead.')]
function connectionRemoteAddress(): string {
	return Minz_Request::connectionRemoteAddress();
}

#[Deprecated('Use FreshRSS_http_Util::checkTrustedIP() instead.')]
function checkTrustedIP(): bool {
	return FreshRSS_http_Util::checkTrustedIP();
}

/**
 * Remove a directory recursively.
 * From http://php.net/rmdir#110489
 */
function recursive_unlink(string $dir): bool {
	if (!is_dir($dir)) {
		return true;
	}

	if (is_link($dir)) {
		if (PHP_OS_FAMILY === "Windows") {
			return rmdir($dir);
		}

		return unlink($dir);
	}

	$files = array_diff(scandir($dir) ?: [], ['.', '..']);
	foreach ($files as $filename) {
		$filename = $dir . '/' . $filename;
		if (is_dir($filename)) {
			@chmod($filename, 0777);
			recursive_unlink($filename);
		} else {
			unlink($filename);
		}
	}

	return rmdir($dir);
}

function _i(string $icon, int $type = FreshRSS_Themes::ICON_DEFAULT): string {
	return FreshRSS_Themes::icon($icon, $type);
}

function errorMessageInfo(string $errorTitle, string $error = ''): string {
	$errorTitle = htmlspecialchars($errorTitle, ENT_NOQUOTES, 'UTF-8');

	$message = '';
	$details = '';
	$error = trim($error);
	// Prevent empty tags by checking if error is not empty first
	if ($error !== '') {
		$error = htmlspecialchars($error, ENT_NOQUOTES, 'UTF-8') . "\n";

		// First line is the main message, other lines are the details
		list($message, $details) = explode("\n", $error, 2);

		$message = "<h2>{$message}</h2>";
		$details = "<pre>{$details}</pre>";
	}

	header("Content-Security-Policy: default-src 'self'; frame-ancestors " .
		(FreshRSS_Context::systemConf()->attributeString('csp.frame-ancestors') ?? "'none'"));
	header('Referrer-Policy: same-origin');

	return <<<MSG
	<!DOCTYPE html><html><header><title>HTTP 500: {$errorTitle}</title></header><body>
	<h1>HTTP 500: {$errorTitle}</h1>
	{$message}
	{$details}
	<hr />
	<small>For help see the documentation: <a href="https://freshrss.github.io/FreshRSS/en/admins/logs_and_errors.html" target="_blank">
	https://freshrss.github.io/FreshRSS/en/admins/logs_and_errors.html</a></small>
	</body></html>
MSG;
}
