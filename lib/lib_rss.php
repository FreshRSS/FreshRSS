<?php
declare(strict_types=1);

if (version_compare(PHP_VERSION, FRESHRSS_MIN_PHP_VERSION, '<')) {
	die(sprintf('FreshRSS error: FreshRSS requires PHP %s+!', FRESHRSS_MIN_PHP_VERSION));
}

if (!function_exists('array_is_list')) {
	/**
	 * Polyfill for PHP <8.1
	 * https://php.net/array-is-list#127044
	 * @param array<mixed> $array
	 */
	function array_is_list(array $array): bool {
		$i = -1;
		foreach ($array as $k => $v) {
			++$i;
			if ($k !== $i) {
				return false;
			}
		}
		return true;
	}
}

if (!function_exists('mb_strcut')) {
	function mb_strcut(string $str, int $start, ?int $length = null, string $encoding = 'UTF-8'): string {
		return substr($str, $start, $length) ?: '';
	}
}

if (!function_exists('str_starts_with')) {
	/** Polyfill for PHP <8.0 */
	function str_starts_with(string $haystack, string $needle): bool {
		return strncmp($haystack, $needle, strlen($needle)) === 0;
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
	if (strpos($class, 'FreshRSS') === 0) {
		$components = explode('_', $class);
		switch (count($components)) {
			case 1:
				include(APP_PATH . '/' . $components[0] . '.php');
				return;
			case 2:
				include(APP_PATH . '/Models/' . $components[1] . '.php');
				return;
			case 3:	//Controllers, Exceptions
				include(APP_PATH . '/' . $components[2] . 's/' . $components[1] . $components[2] . '.php');
				return;
		}
	} elseif (strpos($class, 'Minz') === 0) {
		include(LIB_PATH . '/' . str_replace('_', '/', $class) . '.php');
	} elseif (strpos($class, 'SimplePie') === 0) {
		include(LIB_PATH . '/SimplePie/' . str_replace('_', '/', $class) . '.php');
	} elseif (str_starts_with($class, 'Gt\\CssXPath\\')) {
		$prefix = 'Gt\\CssXPath\\';
		$base_dir = LIB_PATH . '/phpgt/cssxpath/src/';
		$relative_class_name = substr($class, strlen($prefix));
		require $base_dir . str_replace('\\', '/', $relative_class_name) . '.php';
	} elseif (str_starts_with($class, 'marienfressinaud\\LibOpml\\')) {
		$prefix = 'marienfressinaud\\LibOpml\\';
		$base_dir = LIB_PATH . '/marienfressinaud/lib_opml/src/LibOpml/';
		$relative_class_name = substr($class, strlen($prefix));
		require $base_dir . str_replace('\\', '/', $relative_class_name) . '.php';
	} elseif (str_starts_with($class, 'PHPMailer\\PHPMailer\\')) {
		$prefix = 'PHPMailer\\PHPMailer\\';
		$base_dir = LIB_PATH . '/phpmailer/phpmailer/src/';
		$relative_class_name = substr($class, strlen($prefix));
		require $base_dir . str_replace('\\', '/', $relative_class_name) . '.php';
	}
}

spl_autoload_register('classAutoloader');
//</Auto-loading>

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

function idn_to_puny(string $url): string {
	if (function_exists('idn_to_ascii')) {
		$idn = parse_url($url, PHP_URL_HOST);
		if (is_string($idn) && $idn != '') {
			// https://wiki.php.net/rfc/deprecate-and-remove-intl_idna_variant_2003
			if (defined('INTL_IDNA_VARIANT_UTS46')) {
				$puny = idn_to_ascii($idn, IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
			} elseif (defined('INTL_IDNA_VARIANT_2003')) {
				$puny = idn_to_ascii($idn, IDNA_DEFAULT, INTL_IDNA_VARIANT_2003);
			} else {
				$puny = idn_to_ascii($idn);
			}
			$pos = strpos($url, $idn);
			if ($puny != false && $pos !== false) {
				$url = substr_replace($url, $puny, $pos, strlen($idn));
			}
		}
	}
	return $url;
}

/**
 * @return string|false
 */
function checkUrl(string $url, bool $fixScheme = true) {
	$url = trim($url);
	if ($url == '') {
		return '';
	}
	if ($fixScheme && preg_match('#^https?://#i', $url) !== 1) {
		$url = 'https://' . ltrim($url, '/');
	}

	$url = idn_to_puny($url);	//PHP bug #53474 IDN
	$urlRelaxed = str_replace('_', 'z', $url);	//PHP discussion #64948 Underscore

	if (is_string(filter_var($urlRelaxed, FILTER_VALIDATE_URL))) {
		return $url;
	} else {
		return false;
	}
}

function safe_ascii(?string $text): string {
	return $text === null ? '' : (filter_var($text, FILTER_DEFAULT, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH) ?: '');
}

if (function_exists('mb_convert_encoding')) {
	function safe_utf8(string $text): string {
		return mb_convert_encoding($text, 'UTF-8', 'UTF-8') ?: '';
	}
} elseif (function_exists('iconv')) {
	function safe_utf8(string $text): string {
		return iconv('UTF-8', 'UTF-8//IGNORE', $text) ?: '';
	}
} else {
	function safe_utf8(string $text): string {
		return $text;
	}
}

function escapeToUnicodeAlternative(string $text, bool $extended = true): string {
	$text = htmlspecialchars_decode($text, ENT_QUOTES);

	//Problematic characters
	$problem = array('&', '<', '>');
	//Use their fullwidth Unicode form instead:
	$replace = array('＆', '＜', '＞');

	// https://raw.githubusercontent.com/mihaip/google-reader-api/master/wiki/StreamId.wiki
	if ($extended) {
		$problem += array("'", '"', '^', '?', '\\', '/', ',', ';');
		$replace += array("’", '＂', '＾', '？', '＼', '／', '，', '；');
	}

	return trim(str_replace($problem, $replace, $text));
}

/** @param int|float $n */
function format_number($n, int $precision = 0): string {
	// number_format does not seem to be Unicode-compatible
	return str_replace(' ', ' ',	// Thin non-breaking space
		number_format((float)$n, $precision, '.', ' ')
	);
}

function format_bytes(int $bytes, int $precision = 2, string $system = 'IEC'): string {
	if ($system === 'IEC') {
		$base = 1024;
		$units = array('B', 'KiB', 'MiB', 'GiB', 'TiB');
	} elseif ($system === 'SI') {
		$base = 1000;
		$units = array('B', 'KB', 'MB', 'GB', 'TB');
	} else {
		return format_number($bytes, $precision);
	}
	$bytes = max(intval($bytes), 0);
	$pow = $bytes === 0 ? 0 : floor(log($bytes) / log($base));
	$pow = min($pow, count($units) - 1);
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
function sensitive_log($log) {
	if (is_array($log)) {
		foreach ($log as $k => $v) {
			if (in_array($k, ['api_key', 'Passwd', 'T'], true)) {
				$log[$k] = '██';
			} elseif (is_array($v) || is_string($v)) {
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

/**
 * @param array<string,mixed> $attributes
 * @param array<int,mixed> $curl_options
 * @throws FreshRSS_Context_Exception
 */
function customSimplePie(array $attributes = [], array $curl_options = []): SimplePie {
	$limits = FreshRSS_Context::systemConf()->limits;
	$simplePie = new SimplePie();
	$simplePie->set_useragent(FRESHRSS_USERAGENT);
	$simplePie->set_syslog(FreshRSS_Context::systemConf()->simplepie_syslog_enabled);
	$simplePie->set_cache_name_function('sha1');
	$simplePie->set_cache_location(CACHE_PATH);
	$simplePie->set_cache_duration($limits['cache_duration']);
	$simplePie->enable_order_by_date(false);

	$feed_timeout = empty($attributes['timeout']) || !is_numeric($attributes['timeout']) ? 0 : (int)$attributes['timeout'];
	$simplePie->set_timeout($feed_timeout > 0 ? $feed_timeout : $limits['timeout']);

	$curl_options = array_replace(FreshRSS_Context::systemConf()->curl_options, $curl_options);
	if (isset($attributes['ssl_verify'])) {
		$curl_options[CURLOPT_SSL_VERIFYHOST] = $attributes['ssl_verify'] ? 2 : 0;
		$curl_options[CURLOPT_SSL_VERIFYPEER] = (bool)$attributes['ssl_verify'];
		if (!$attributes['ssl_verify']) {
			$curl_options[CURLOPT_SSL_CIPHER_LIST] = 'DEFAULT@SECLEVEL=1';
		}
	}
	if (!empty($attributes['curl_params']) && is_array($attributes['curl_params'])) {
		foreach ($attributes['curl_params'] as $co => $v) {
			$curl_options[$co] = $v;
		}
	}
	$simplePie->set_curl_options($curl_options);

	$simplePie->strip_comments(true);
	$simplePie->strip_htmltags([
		'base', 'blink', 'body', 'doctype', 'embed',
		'font', 'form', 'frame', 'frameset', 'html',
		'link', 'input', 'marquee', 'meta', 'noscript',
		'object', 'param', 'plaintext', 'script', 'style',
		'svg',	//TODO: Support SVG after sanitizing and URL rewriting of xlink:href
	]);
	$simplePie->rename_attributes(['id', 'class']);
	$simplePie->strip_attributes(array_merge($simplePie->strip_attributes, [
		'autoplay', 'class', 'onload', 'onunload', 'onclick', 'ondblclick', 'onmousedown', 'onmouseup',
		'onmouseover', 'onmousemove', 'onmouseout', 'onfocus', 'onblur',
		'onkeypress', 'onkeydown', 'onkeyup', 'onselect', 'onchange', 'seamless', 'sizes', 'srcset']));
	$simplePie->add_attributes([
		'audio' => ['controls' => 'controls', 'preload' => 'none'],
		'iframe' => [
			'allow' => 'accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share',
			'sandbox' => 'allow-scripts allow-same-origin',
		],
		'video' => ['controls' => 'controls', 'preload' => 'none'],
	]);
	$simplePie->set_url_replacements([
		'a' => 'href',
		'area' => 'href',
		'audio' => 'src',
		'blockquote' => 'cite',
		'del' => 'cite',
		'form' => 'action',
		'iframe' => 'src',
		'img' => [
			'longdesc',
			'src'
		],
		'input' => 'src',
		'ins' => 'cite',
		'q' => 'cite',
		'source' => 'src',
		'track' => 'src',
		'video' => [
			'poster',
			'src',
		],
	]);
	$https_domains = [];
	$force = @file(FRESHRSS_PATH . '/force-https.default.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	if (is_array($force)) {
		$https_domains = array_merge($https_domains, $force);
	}
	$force = @file(DATA_PATH . '/force-https.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	if (is_array($force)) {
		$https_domains = array_merge($https_domains, $force);
	}
	$simplePie->set_https_domains($https_domains);
	return $simplePie;
}

function sanitizeHTML(string $data, string $base = '', ?int $maxLength = null): string {
	if ($data === '' || ($maxLength !== null && $maxLength <= 0)) {
		return '';
	}
	if ($maxLength !== null) {
		$data = mb_strcut($data, 0, $maxLength, 'UTF-8');
	}
	static $simplePie = null;
	if ($simplePie == null) {
		$simplePie = customSimplePie();
		$simplePie->init();
	}
	$result = html_only_entity_decode($simplePie->sanitize->sanitize($data, SIMPLEPIE_CONSTRUCT_HTML, $base));
	if ($maxLength !== null && strlen($result) > $maxLength) {
		//Sanitizing has made the result too long so try again shorter
		$data = mb_strcut($result, 0, (2 * $maxLength) - strlen($result) - 2, 'UTF-8');
		return sanitizeHTML($data, $base, $maxLength);
	}
	return $result;
}

function cleanCache(int $hours = 720): void {
	// N.B.: GLOB_BRACE is not available on all platforms
	$files = array_merge(
		glob(CACHE_PATH . '/*.html', GLOB_NOSORT) ?: [],
		glob(CACHE_PATH . '/*.json', GLOB_NOSORT) ?: [],
		glob(CACHE_PATH . '/*.spc', GLOB_NOSORT) ?: [],
		glob(CACHE_PATH . '/*.xml', GLOB_NOSORT) ?: []);
	foreach ($files as $file) {
		if (substr($file, -10) === 'index.html') {
			continue;
		}
		$cacheMtime = @filemtime($file);
		if ($cacheMtime !== false && $cacheMtime < time() - (3600 * $hours)) {
			unlink($file);
		}
	}
}

/**
 * Remove the charset meta information of an HTML document, e.g.:
 * `<meta charset="..." />`
 * `<meta http-equiv="Content-Type" content="text/html; charset=...">`
 */
function stripHtmlMetaCharset(string $html): string {
	return preg_replace('/<meta\s[^>]*charset\s*=\s*[^>]+>/i', '', $html, 1) ?? '';
}

/**
 * Set an XML preamble to enforce the HTML content type charset received by HTTP.
 * @param string $html the raw downloaded HTML content
 * @param string $contentType an HTTP Content-Type such as 'text/html; charset=utf-8'
 * @return string an HTML string with XML encoding information for DOMDocument::loadHTML()
 */
function enforceHttpEncoding(string $html, string $contentType = ''): string {
	$httpCharset = preg_match('/\bcharset=([0-9a-z_-]{2,12})$/i', $contentType, $matches) === 1 ? $matches[1] : '';
	if ($httpCharset == '') {
		// No charset defined by HTTP
		if (preg_match('/<meta\s[^>]*charset\s*=[\s\'"]*UTF-?8\b/i', substr($html, 0, 2048))) {
			// Detect UTF-8 even if declared too deep in HTML for DOMDocument
			$httpCharset = 'UTF-8';
		} else {
			// Do nothing
			return $html;
		}
	}
	$httpCharsetNormalized = SimplePie_Misc::encoding($httpCharset);
	if (in_array($httpCharsetNormalized, ['windows-1252', 'US-ASCII'], true)) {
		// Default charset for HTTP, do nothing
		return $html;
	}
	if (substr($html, 0, 3) === "\xEF\xBB\xBF" || // UTF-8 BOM
		substr($html, 0, 2) === "\xFF\xFE" || // UTF-16 Little Endian BOM
		substr($html, 0, 2) === "\xFE\xFF" || // UTF-16 Big Endian BOM
		substr($html, 0, 4) === "\xFF\xFE\x00\x00" || // UTF-32 Little Endian BOM
		substr($html, 0, 4) === "\x00\x00\xFE\xFF") { // UTF-32 Big Endian BOM
		// Existing byte order mark, do nothing
		return $html;
	}
	if (preg_match('/^<[?]xml[^>]+encoding\b/', substr($html, 0, 64))) {
		// Existing XML declaration, do nothing
		return $html;
	}
	if ($httpCharsetNormalized !== 'UTF-8') {
		// Try to change encoding to UTF-8 using mbstring or iconv or intl
		$utf8 = SimplePie_Misc::change_encoding($html, $httpCharsetNormalized, 'UTF-8');
		if (is_string($utf8)) {
			$html = stripHtmlMetaCharset($utf8);
			$httpCharsetNormalized = 'UTF-8';
		}
	}
	if ($httpCharsetNormalized === 'UTF-8') {
		// Save encoding information as XML declaration
		return '<' . '?xml version="1.0" encoding="' . $httpCharsetNormalized . '" ?' . ">\n" . $html;
	}
	// Give up
	return $html;
}

/**
 * @param string $type {html,json,opml,xml}
 * @param array<string,mixed> $attributes
 * @param array<int,mixed> $curl_options
 */
function httpGet(string $url, string $cachePath, string $type = 'html', array $attributes = [], array $curl_options = []): string {
	$limits = FreshRSS_Context::systemConf()->limits;
	$feed_timeout = empty($attributes['timeout']) || !is_numeric($attributes['timeout']) ? 0 : intval($attributes['timeout']);

	$cacheMtime = @filemtime($cachePath);
	if ($cacheMtime !== false && $cacheMtime > time() - intval($limits['cache_duration'])) {
		$body = @file_get_contents($cachePath);
		if ($body != false) {
			syslog(LOG_DEBUG, 'FreshRSS uses cache for ' . SimplePie_Misc::url_remove_credentials($url));
			return $body;
		}
	}

	if (mt_rand(0, 30) === 1) {	// Remove old entries once in a while
		cleanCache(CLEANCACHE_HOURS);
	}

	if (FreshRSS_Context::systemConf()->simplepie_syslog_enabled) {
		syslog(LOG_INFO, 'FreshRSS GET ' . $type . ' ' . SimplePie_Misc::url_remove_credentials($url));
	}

	$accept = '*/*;q=0.8';
	switch ($type) {
		case 'json':
			$accept = 'application/json,application/feed+json,application/javascript;q=0.9,text/javascript;q=0.8,*/*;q=0.7';
			break;
		case 'opml':
			$accept = 'text/x-opml,text/xml;q=0.9,application/xml;q=0.9,*/*;q=0.8';
			break;
		case 'xml':
			$accept = 'application/xml,application/xhtml+xml,text/xml;q=0.9,*/*;q=0.8';
			break;
		case 'html':
		default:
			$accept = 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
			break;
	}

	// TODO: Implement HTTP 1.1 conditional GET If-Modified-Since
	$ch = curl_init();
	curl_setopt_array($ch, [
		CURLOPT_URL => $url,
		CURLOPT_HTTPHEADER => array('Accept: ' . $accept),
		CURLOPT_USERAGENT => FRESHRSS_USERAGENT,
		CURLOPT_CONNECTTIMEOUT => $feed_timeout > 0 ? $feed_timeout : $limits['timeout'],
		CURLOPT_TIMEOUT => $feed_timeout > 0 ? $feed_timeout : $limits['timeout'],
		CURLOPT_MAXREDIRS => 4,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_ENCODING => '',	//Enable all encodings
		//CURLOPT_VERBOSE => 1,	// To debug sent HTTP headers
	]);

	curl_setopt_array($ch, FreshRSS_Context::systemConf()->curl_options);

	if (isset($attributes['curl_params']) && is_array($attributes['curl_params'])) {
		curl_setopt_array($ch, $attributes['curl_params']);
	}

	if (isset($attributes['ssl_verify'])) {
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $attributes['ssl_verify'] ? 2 : 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, (bool)$attributes['ssl_verify']);
		if (!$attributes['ssl_verify']) {
			curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
		}
	}

	curl_setopt_array($ch, $curl_options);

	$body = curl_exec($ch);
	$c_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$c_content_type = '' . curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
	$c_error = curl_error($ch);
	curl_close($ch);

	if ($c_status != 200 || $c_error != '' || $body === false) {
		Minz_Log::warning('Error fetching content: HTTP code ' . $c_status . ': ' . $c_error . ' ' . $url);
		$body = '';
		// TODO: Implement HTTP 410 Gone
	} elseif (!is_string($body) || strlen($body) === 0) {
		$body = '';
	} else {
		$body = trim($body, " \n\r\t\v");	// Do not trim \x00 to avoid breaking a BOM
		if ($type !== 'json') {
			$body = enforceHttpEncoding($body, $c_content_type);
		}
	}

	if (file_put_contents($cachePath, $body) === false) {
		Minz_Log::warning("Error saving cache $cachePath for $url");
	}

	return $body;
}

/**
 * Validate an email address, supports internationalized addresses.
 *
 * @param string $email The address to validate
 * @return bool true if email is valid, else false
 */
function validateEmailAddress(string $email): bool {
	$mailer = new PHPMailer\PHPMailer\PHPMailer();
	$mailer->CharSet = 'utf-8';
	$punyemail = $mailer->punyencodeAddress($email);
	return PHPMailer\PHPMailer\PHPMailer::validateAddress($punyemail, 'html5');
}

/**
 * Add support of image lazy loading
 * Move content from src attribute to data-original
 * @param string $content is the text we want to parse
 */
function lazyimg(string $content): string {
	return preg_replace([
			'/<((?:img|iframe)[^>]+?)src="([^"]+)"([^>]*)>/i',
			"/<((?:img|iframe)[^>]+?)src='([^']+)'([^>]*)>/i",
		], [
			'<$1src="' . Minz_Url::display('/themes/icons/grey.gif') . '" data-original="$2"$3>',
			"<$1src='" . Minz_Url::display('/themes/icons/grey.gif') . "' data-original='$2'$3>",
		],
		$content
	) ?? '';
}

/** @return numeric-string */
function uTimeString(): string {
	$t = @gettimeofday();
	$result = $t['sec'] . str_pad('' . $t['usec'], 6, '0', STR_PAD_LEFT);
	/** @var numeric-string @result */
	return $result;
}

function invalidateHttpCache(string $username = ''): bool {
	if (!FreshRSS_user_Controller::checkUsername($username)) {
		Minz_Session::_param('touch', uTimeString());
		$username = Minz_User::name() ?? Minz_User::INTERNAL_USER;
	}
	return FreshRSS_UserDAO::ctouch($username);
}

/**
 * @return array<string>
 */
function listUsers(): array {
	$final_list = array();
	$base_path = join_path(DATA_PATH, 'users');
	$dir_list = array_values(array_diff(
		scandir($base_path) ?: [],
		['..', '.', Minz_User::INTERNAL_USER]
	));
	foreach ($dir_list as $file) {
		if ($file[0] !== '.' && is_dir(join_path($base_path, $file)) && file_exists(join_path($base_path, $file, 'config.php'))) {
			$final_list[] = $file;
		}
	}
	return $final_list;
}


/**
 * Return if the maximum number of registrations has been reached.
 * Note a max_registrations of 0 means there is no limit.
 *
 * @return bool true if number of users >= max registrations, false else.
 */
function max_registrations_reached(): bool {
	$limit_registrations = FreshRSS_Context::systemConf()->limits['max_registrations'];
	$number_accounts = count(listUsers());

	return $limit_registrations > 0 && $number_accounts >= $limit_registrations;
}


/**
 * Register and return the configuration for a given user.
 *
 * Note this function has been created to generate temporary configuration
 * objects. If you need a long-time configuration, please don't use this function.
 *
 * @param string $username the name of the user of which we want the configuration.
 * @return FreshRSS_UserConfiguration|null object, or null if the configuration cannot be loaded.
 * @throws Minz_ConfigurationNamespaceException
 */
function get_user_configuration(string $username): ?FreshRSS_UserConfiguration {
	if (!FreshRSS_user_Controller::checkUsername($username)) {
		return null;
	}
	$namespace = 'user_' . $username;
	try {
		FreshRSS_UserConfiguration::register($namespace,
			USERS_PATH . '/' . $username . '/config.php',
			FRESHRSS_PATH . '/config-user.default.php');
	} catch (Minz_FileNotExistException $e) {
		Minz_Log::warning($e->getMessage(), ADMIN_LOG);
		return null;
	}

	$user_conf = FreshRSS_UserConfiguration::get($namespace);
	return $user_conf;
}

/**
 * Converts an IP (v4 or v6) to a binary representation using inet_pton
 *
 * @param string $ip the IP to convert
 * @return string a binary representation of the specified IP
 */
function ipToBits(string $ip): string {
	$binaryip = '';
	foreach (str_split(inet_pton($ip) ?: '') as $char) {
		$binaryip .= str_pad(decbin(ord($char)), 8, '0', STR_PAD_LEFT);
	}
	return $binaryip;
}

/**
 * Check if an ip belongs to the provided range (in CIDR format)
 *
 * @param string $ip the IP that we want to verify (ex: 192.168.16.1)
 * @param string $range the range to check against (ex: 192.168.16.0/24)
 * @return bool true if the IP is in the range, otherwise false
 */
function checkCIDR(string $ip, string $range): bool {
	$binary_ip = ipToBits($ip);
	$split = explode('/', $range);

	$subnet = $split[0] ?? '';
	if ($subnet == '') {
		return false;
	}
	$binary_subnet = ipToBits($subnet);

	$mask_bits = $split[1] ?? '';
	$mask_bits = (int)$mask_bits;
	if ($mask_bits === 0) {
		$mask_bits = null;
	}

	$ip_net_bits = substr($binary_ip, 0, $mask_bits);
	$subnet_bits = substr($binary_subnet, 0, $mask_bits);
	return $ip_net_bits === $subnet_bits;
}

/**
 * Use CONN_REMOTE_ADDR (if available, to be robust even when using Apache mod_remoteip) or REMOTE_ADDR environment variable to determine the connection IP.
 */
function connectionRemoteAddress(): string {
	$remoteIp = $_SERVER['CONN_REMOTE_ADDR'] ?? '';
	if ($remoteIp == '') {
		$remoteIp = $_SERVER['REMOTE_ADDR'] ?? '';
	}
	if ($remoteIp == 0) {
		$remoteIp = '';
	}
	return $remoteIp;
}

/**
 * Check if the client (e.g. last proxy) is allowed to send unsafe headers.
 * This uses the `TRUSTED_PROXY` environment variable or the `trusted_sources` configuration option to get an array of the authorized ranges,
 * The connection IP is obtained from the `CONN_REMOTE_ADDR` (if available, to be robust even when using Apache mod_remoteip) or `REMOTE_ADDR` environment variables.
 * @return bool true if the sender’s IP is in one of the ranges defined in the configuration, else false
 */
function checkTrustedIP(): bool {
	if (!FreshRSS_Context::hasSystemConf()) {
		return false;
	}
	$remoteIp = connectionRemoteAddress();
	if ($remoteIp === '') {
		return false;
	}
	$trusted = getenv('TRUSTED_PROXY');
	if ($trusted != 0 && is_string($trusted)) {
		$trusted = preg_split('/\s+/', $trusted, -1, PREG_SPLIT_NO_EMPTY);
	}
	if (!is_array($trusted) || empty($trusted)) {
		$trusted = FreshRSS_Context::systemConf()->trusted_sources;
	}
	foreach ($trusted as $cidr) {
		if (checkCIDR($remoteIp, $cidr)) {
			return true;
		}
	}
	return false;
}

function httpAuthUser(bool $onlyTrusted = true): string {
	if (!empty($_SERVER['REMOTE_USER'])) {
		return $_SERVER['REMOTE_USER'];
	}
	if (!empty($_SERVER['REDIRECT_REMOTE_USER'])) {
		return $_SERVER['REDIRECT_REMOTE_USER'];
	}
	if (!$onlyTrusted || checkTrustedIP()) {
		if (!empty($_SERVER['HTTP_REMOTE_USER'])) {
			return $_SERVER['HTTP_REMOTE_USER'];
		}
		if (!empty($_SERVER['HTTP_X_WEBAUTH_USER'])) {
			return $_SERVER['HTTP_X_WEBAUTH_USER'];
		}
	}
	return '';
}

function cryptAvailable(): bool {
	$hash = '$2y$04$usesomesillystringfore7hnbRJHxXVLeakoG8K30oukPsA.ztMG';
	return $hash === @crypt('password', $hash);
}


/**
 * Check PHP and its extensions are well-installed.
 *
 * @return array<string,bool> of tested values.
 */
function check_install_php(): array {
	$pdo_mysql = extension_loaded('pdo_mysql');
	$pdo_pgsql = extension_loaded('pdo_pgsql');
	$pdo_sqlite = extension_loaded('pdo_sqlite');
	return array(
		'php' => version_compare(PHP_VERSION, FRESHRSS_MIN_PHP_VERSION) >= 0,
		'curl' => extension_loaded('curl'),
		'pdo' => $pdo_mysql || $pdo_sqlite || $pdo_pgsql,
		'pcre' => extension_loaded('pcre'),
		'ctype' => extension_loaded('ctype'),
		'fileinfo' => extension_loaded('fileinfo'),
		'dom' => class_exists('DOMDocument'),
		'json' => extension_loaded('json'),
		'mbstring' => extension_loaded('mbstring'),
		'zip' => extension_loaded('zip'),
	);
}

/**
 * Check different data files and directories exist.
 * @return array<string,bool> of tested values.
 */
function check_install_files(): array {
	return [
		'data' => is_dir(DATA_PATH) && touch(DATA_PATH . '/index.html'),	// is_writable() is not reliable for a folder on NFS
		'cache' => is_dir(CACHE_PATH) && touch(CACHE_PATH . '/index.html'),
		'users' => is_dir(USERS_PATH) && touch(USERS_PATH . '/index.html'),
		'favicons' => is_dir(DATA_PATH) && touch(DATA_PATH . '/favicons/index.html'),
		'tokens' => is_dir(DATA_PATH) && touch(DATA_PATH . '/tokens/index.html'),
	];
}

/**
 * Check database is well-installed.
 *
 * @return array<string,bool> of tested values.
 */
function check_install_database(): array {
	$status = array(
		'connection' => true,
		'tables' => false,
		'categories' => false,
		'feeds' => false,
		'entries' => false,
		'entrytmp' => false,
		'tag' => false,
		'entrytag' => false,
	);

	try {
		$dbDAO = FreshRSS_Factory::createDatabaseDAO();

		$status['tables'] = $dbDAO->tablesAreCorrect();
		$status['categories'] = $dbDAO->categoryIsCorrect();
		$status['feeds'] = $dbDAO->feedIsCorrect();
		$status['entries'] = $dbDAO->entryIsCorrect();
		$status['entrytmp'] = $dbDAO->entrytmpIsCorrect();
		$status['tag'] = $dbDAO->tagIsCorrect();
		$status['entrytag'] = $dbDAO->entrytagIsCorrect();
	} catch (Minz_PDOConnectionException $e) {
		$status['connection'] = false;
	}

	return $status;
}

/**
 * Remove a directory recursively.
 * From http://php.net/rmdir#110489
 */
function recursive_unlink(string $dir): bool {
	if (!is_dir($dir)) {
		return true;
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

/**
 * Remove queries where $get is appearing.
 * @param string $get the get attribute which should be removed.
 * @param array<int,array<string,string|int>> $queries an array of queries.
 * @return array<int,array<string,string|int>> without queries where $get is appearing.
 */
function remove_query_by_get(string $get, array $queries): array {
	$final_queries = array();
	foreach ($queries as $key => $query) {
		if (empty($query['get']) || $query['get'] !== $get) {
			$final_queries[$key] = $query;
		}
	}
	return $final_queries;
}

function _i(string $icon, int $type = FreshRSS_Themes::ICON_DEFAULT): string {
	return FreshRSS_Themes::icon($icon, $type);
}


const SHORTCUT_KEYS = [
			'0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
			'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
			'F1', 'F2', 'F3', 'F4', 'F5', 'F6', 'F7', 'F8', 'F9', 'F10', 'F11', 'F12',
			'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowUp', 'Backspace', 'Delete',
			'End', 'Enter', 'Escape', 'Home', 'Insert', 'PageDown', 'PageUp', 'Space', 'Tab',
		];

/**
 * @param array<string> $shortcuts
 * @return array<string>
 */
function getNonStandardShortcuts(array $shortcuts): array {
	$standard = strtolower(implode(' ', SHORTCUT_KEYS));

	$nonStandard = array_filter($shortcuts, static function (string $shortcut) use ($standard) {
		$shortcut = trim($shortcut);
		return $shortcut !== '' && stripos($standard, $shortcut) === false;
	});

	return $nonStandard;
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

	header("Content-Security-Policy: default-src 'self'");

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
