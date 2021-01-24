<?php
if (version_compare(PHP_VERSION, FRESHRSS_MIN_PHP_VERSION, '<')) {
	die(sprintf('FreshRSS error: FreshRSS requires PHP %s+!', FRESHRSS_MIN_PHP_VERSION));
}

if (!function_exists('mb_strcut')) {
	function mb_strcut($str, $start, $length = null, $encoding = 'UTF-8') {
		return substr($str, $start, $length);
	}
}

if (COPY_SYSLOG_TO_STDERR) {
	openlog('FreshRSS', LOG_CONS | LOG_ODELAY | LOG_PID | LOG_PERROR, LOG_USER);
} else {
	openlog('FreshRSS', LOG_CONS | LOG_ODELAY | LOG_PID, LOG_USER);
}

/**
 * Build a directory path by concatenating a list of directory names.
 *
 * @param $path_parts a list of directory names
 * @return a string corresponding to the final pathname
 */
function join_path() {
	$path_parts = func_get_args();
	return join(DIRECTORY_SEPARATOR, $path_parts);
}

//<Auto-loading>
function classAutoloader($class) {
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
	} elseif (strpos($class, 'PHPMailer') === 0) {
		include(LIB_PATH . '/' . str_replace('\\', '/', $class) . '.php');
	}
}

spl_autoload_register('classAutoloader');
//</Auto-loading>

function idn_to_puny($url) {
	if (function_exists('idn_to_ascii')) {
		$idn = parse_url($url, PHP_URL_HOST);
		if ($idn != '') {
			// https://wiki.php.net/rfc/deprecate-and-remove-intl_idna_variant_2003
			if (defined('INTL_IDNA_VARIANT_UTS46')) {
				$puny = idn_to_ascii($idn, IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
			} elseif (defined('INTL_IDNA_VARIANT_2003')) {
				$puny = idn_to_ascii($idn, IDNA_DEFAULT, INTL_IDNA_VARIANT_2003);
			} else {
				$puny = idn_to_ascii($idn);
			}
			$pos = strpos($url, $idn);
			if ($puny != '' && $pos !== false) {
				$url = substr_replace($url, $puny, $pos, strlen($idn));
			}
		}
	}
	return $url;
}

function checkUrl($url, $fixScheme = true) {
	$url = trim($url);
	if ($url == '') {
		return '';
	}
	if ($fixScheme && !preg_match('#^https?://#i', $url)) {
		$url = 'https://' . ltrim($url, '/');
	}

	$url = idn_to_puny($url);	//PHP bug #53474 IDN
	$urlRelaxed = str_replace('_', 'z', $url);	//PHP discussion #64948 Underscore

	if (filter_var($urlRelaxed, FILTER_VALIDATE_URL)) {
		return $url;
	} else {
		return false;
	}
}

function safe_ascii($text) {
	return filter_var($text, FILTER_DEFAULT, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
}

if (function_exists('mb_convert_encoding')) {
	function safe_utf8($text) { return mb_convert_encoding($text, 'UTF-8', 'UTF-8'); }
} elseif (function_exists('iconv')) {
	function safe_utf8($text) { return iconv('UTF-8', 'UTF-8//IGNORE', $text); }
} else {
	function safe_utf8($text) { return $text; }
}

function escapeToUnicodeAlternative($text, $extended = true) {
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

function format_number($n, $precision = 0) {
	// number_format does not seem to be Unicode-compatible
	return str_replace(' ', ' ',  //Espace fine insécable
		number_format($n, $precision, '.', ' ')
	);
}

function format_bytes($bytes, $precision = 2, $system = 'IEC') {
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

function timestamptodate ($t, $hour = true) {
	$month = _t('gen.date.' . date('M', $t));
	if ($hour) {
		$date = _t('gen.date.format_date_hour', $month);
	} else {
		$date = _t('gen.date.format_date', $month);
	}

	return @date ($date, $t);
}

function html_only_entity_decode($text) {
	static $htmlEntitiesOnly = null;
	if ($htmlEntitiesOnly === null) {
		$htmlEntitiesOnly = array_flip(array_diff(
			get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES, 'UTF-8'),	//Decode HTML entities
			get_html_translation_table(HTML_SPECIALCHARS, ENT_NOQUOTES, 'UTF-8')	//Preserve XML entities
		));
	}
	return strtr($text, $htmlEntitiesOnly);
}

function customSimplePie($attributes = array()) {
	$limits = FreshRSS_Context::$system_conf->limits;
	$simplePie = new SimplePie();
	$simplePie->set_useragent(FRESHRSS_USERAGENT);
	$simplePie->set_syslog(FreshRSS_Context::$system_conf->simplepie_syslog_enabled);
	$simplePie->set_cache_location(CACHE_PATH);
	$simplePie->set_cache_duration($limits['cache_duration']);

	$feed_timeout = empty($attributes['timeout']) ? 0 : intval($attributes['timeout']);
	$simplePie->set_timeout($feed_timeout > 0 ? $feed_timeout : $limits['timeout']);

	$curl_options = FreshRSS_Context::$system_conf->curl_options;
	if (isset($attributes['ssl_verify'])) {
		$curl_options[CURLOPT_SSL_VERIFYHOST] = $attributes['ssl_verify'] ? 2 : 0;
		$curl_options[CURLOPT_SSL_VERIFYPEER] = $attributes['ssl_verify'] ? true : false;
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
	$simplePie->strip_htmltags(array(
		'base', 'blink', 'body', 'doctype', 'embed',
		'font', 'form', 'frame', 'frameset', 'html',
		'link', 'input', 'marquee', 'meta', 'noscript',
		'object', 'param', 'plaintext', 'script', 'style',
		'svg',	//TODO: Support SVG after sanitizing and URL rewriting of xlink:href
	));
	$simplePie->strip_attributes(array_merge($simplePie->strip_attributes, array(
		'autoplay', 'class', 'onload', 'onunload', 'onclick', 'ondblclick', 'onmousedown', 'onmouseup',
		'onmouseover', 'onmousemove', 'onmouseout', 'onfocus', 'onblur',
		'onkeypress', 'onkeydown', 'onkeyup', 'onselect', 'onchange', 'seamless', 'sizes', 'srcset')));
	$simplePie->add_attributes(array(
		'audio' => array('controls' => 'controls', 'preload' => 'none'),
		'iframe' => array('sandbox' => 'allow-scripts allow-same-origin'),
		'video' => array('controls' => 'controls', 'preload' => 'none'),
	));
	$simplePie->set_url_replacements(array(
		'a' => 'href',
		'area' => 'href',
		'audio' => 'src',
		'blockquote' => 'cite',
		'del' => 'cite',
		'form' => 'action',
		'iframe' => 'src',
		'img' => array(
			'longdesc',
			'src'
		),
		'input' => 'src',
		'ins' => 'cite',
		'q' => 'cite',
		'source' => 'src',
		'track' => 'src',
		'video' => array(
			'poster',
			'src',
		),
	));
	$https_domains = array();
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

function sanitizeHTML($data, $base = '', $maxLength = false) {
	if (!is_string($data) || ($maxLength !== false && $maxLength <= 0)) {
		return '';
	}
	if ($maxLength !== false) {
		$data = mb_strcut($data, 0, $maxLength, 'UTF-8');
	}
	static $simplePie = null;
	if ($simplePie == null) {
		$simplePie = customSimplePie();
		$simplePie->init();
	}
	$result = html_only_entity_decode($simplePie->sanitize->sanitize($data, SIMPLEPIE_CONSTRUCT_HTML, $base));
	if ($maxLength !== false && strlen($result) > $maxLength) {
		//Sanitizing has made the result too long so try again shorter
		$data = mb_strcut($result, 0, (2 * $maxLength) - strlen($result) - 2, 'UTF-8');
		return sanitizeHTML($data, $base, $maxLength);
	}
	return $result;
}

/**
 * Validate an email address, supports internationalized addresses.
 *
 * @param string $email The address to validate
 *
 * @return bool true if email is valid, else false
 */
function validateEmailAddress($email) {
	$mailer = new PHPMailer\PHPMailer\PHPMailer();
	$mailer->Charset = 'utf-8';
	$punyemail = $mailer->punyencodeAddress($email);
	return PHPMailer\PHPMailer\PHPMailer::validateAddress($punyemail, 'html5');
}

/**
 * Add support of image lazy loading
 * Move content from src attribute to data-original
 * @param content is the text we want to parse
 */
function lazyimg($content) {
	return preg_replace(
		'/<((?:img|iframe)[^>]+?)src=[\'"]([^"\']+)[\'"]([^>]*)>/i',
		'<$1src="' . Minz_Url::display('/themes/icons/grey.gif') . '" data-original="$2"$3>',
		$content
	);
}

function uTimeString() {
	$t = @gettimeofday();
	return $t['sec'] . str_pad($t['usec'], 6, '0', STR_PAD_LEFT);
}

function invalidateHttpCache($username = '') {
	if (!FreshRSS_user_Controller::checkUsername($username)) {
		Minz_Session::_param('touch', uTimeString());
		$username = Minz_Session::param('currentUser', '_');
	}
	$ok = @touch(DATA_PATH . '/users/' . $username . '/log.txt');
	//if (!$ok) {
		//TODO: Display notification error on front-end
	//}
	return $ok;
}

function listUsers() {
	$final_list = array();
	$base_path = join_path(DATA_PATH, 'users');
	$dir_list = array_values(array_diff(
		scandir($base_path),
		array('..', '.', '_')
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
 *
 * Note a max_regstrations of 0 means there is no limit.
 *
 * @return true if number of users >= max registrations, false else.
 */
function max_registrations_reached() {
	$limit_registrations = FreshRSS_Context::$system_conf->limits['max_registrations'];
	$number_accounts = count(listUsers());

	return $limit_registrations > 0 && $number_accounts >= $limit_registrations;
}


/**
 * Register and return the configuration for a given user.
 *
 * Note this function has been created to generate temporary configuration
 * objects. If you need a long-time configuration, please don't use this function.
 *
 * @param $username the name of the user of which we want the configuration.
 * @return a Minz_Configuration object, null if the configuration cannot be loaded.
 */
function get_user_configuration($username) {
	if (!FreshRSS_user_Controller::checkUsername($username)) {
		return null;
	}
	$namespace = 'user_' . $username;
	try {
		Minz_Configuration::register($namespace,
		                             join_path(USERS_PATH, $username, 'config.php'),
		                             join_path(FRESHRSS_PATH, 'config-user.default.php'));
	} catch (Minz_ConfigurationNamespaceException $e) {
		// namespace already exists, do nothing.
		Minz_Log::warning($e->getMessage(), USERS_PATH . '/_/log.txt');
	} catch (Minz_FileNotExistException $e) {
		Minz_Log::warning($e->getMessage(), USERS_PATH . '/_/log.txt');
		return null;
	}

	return Minz_Configuration::get($namespace);
}


function httpAuthUser() {
	if (!empty($_SERVER['REMOTE_USER'])) {
		return $_SERVER['REMOTE_USER'];
	} elseif (!empty($_SERVER['REDIRECT_REMOTE_USER'])) {
		return $_SERVER['REDIRECT_REMOTE_USER'];
	} elseif (!empty($_SERVER['HTTP_X_WEBAUTH_USER'])) {
		return $_SERVER['HTTP_X_WEBAUTH_USER'];
	}
	return '';
}

function cryptAvailable() {
	try {
		$hash = '$2y$04$usesomesillystringfore7hnbRJHxXVLeakoG8K30oukPsA.ztMG';
		return $hash === @crypt('password', $hash);
	} catch (Exception $e) {
		Minz_Log::warning($e->getMessage());
	}
	return false;
}

function is_referer_from_same_domain() {
	if (empty($_SERVER['HTTP_REFERER'])) {
		return true;	//Accept empty referer while waiting for good support of meta referrer same-origin policy in browsers
	}
	$host = parse_url(((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://') .
		(empty($_SERVER['HTTP_HOST']) ? $_SERVER['SERVER_NAME'] : $_SERVER['HTTP_HOST']));
	$referer = parse_url($_SERVER['HTTP_REFERER']);
	if (empty($host['host']) || empty($referer['host']) || $host['host'] !== $referer['host']) {
		return false;
	}
	//TODO: check 'scheme', taking into account the case of a proxy
	if ((isset($host['port']) ? $host['port'] : 0) !== (isset($referer['port']) ? $referer['port'] : 0)) {
		return false;
	}
	return true;
}


/**
 * Check PHP and its extensions are well-installed.
 *
 * @return array of tested values.
 */
function check_install_php() {
	$pdo_mysql = extension_loaded('pdo_mysql');
	$pdo_pgsql = extension_loaded('pdo_pgsql');
	$pdo_sqlite = extension_loaded('pdo_sqlite');
	return array(
		'php' => version_compare(PHP_VERSION, FRESHRSS_MIN_PHP_VERSION) >= 0,
		'minz' => file_exists(LIB_PATH . '/Minz'),
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
 *
 * @return array of tested values.
 */
function check_install_files() {
	return array(
		'data' => DATA_PATH && is_writable(DATA_PATH),
		'cache' => CACHE_PATH && is_writable(CACHE_PATH),
		'users' => USERS_PATH && is_writable(USERS_PATH),
		'favicons' => is_writable(DATA_PATH . '/favicons'),
		'tokens' => is_writable(DATA_PATH . '/tokens'),
	);
}


/**
 * Check database is well-installed.
 *
 * @return array of tested values.
 */
function check_install_database() {
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
	} catch(Minz_PDOConnectionException $e) {
		$status['connection'] = false;
	}

	return $status;
}

/**
 * Remove a directory recursively.
 *
 * From http://php.net/rmdir#110489
 *
 * @param $dir the directory to remove
 */
function recursive_unlink($dir) {
	if (!is_dir($dir)) {
		return true;
	}

	$files = array_diff(scandir($dir), array('.', '..'));
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
 * @param $get the get attribute which should be removed.
 * @param $queries an array of queries.
 * @return the same array whithout those where $get is appearing.
 */
function remove_query_by_get($get, $queries) {
	$final_queries = array();
	foreach ($queries as $key => $query) {
		if (empty($query['get']) || $query['get'] !== $get) {
			$final_queries[$key] = $query;
		}
	}
	return $final_queries;
}

//RFC 4648
function base64url_encode($data) {
	return strtr(rtrim(base64_encode($data), '='), '+/', '-_');
}
//RFC 4648
function base64url_decode($data) {
	return base64_decode(strtr($data, '-_', '+/'));
}

function _i($icon, $url_only = false) {
	return FreshRSS_Themes::icon($icon, $url_only);
}


const SHORTCUT_KEYS = [
			'0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
			'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
			'F1', 'F2', 'F3', 'F4', 'F5', 'F6', 'F7', 'F8', 'F9', 'F10', 'F11', 'F12',
			'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowUp', 'Backspace', 'Delete',
			'End', 'Enter', 'Escape', 'Home', 'Insert', 'PageDown', 'PageUp', 'Space', 'Tab',
		];

function validateShortcutList($shortcuts) {
	$legacy = array(
			'down' => 'ArrowDown', 'left' => 'ArrowLeft', 'page_down' => 'PageDown', 'page_up' => 'PageUp',
			'right' => 'ArrowRight', 'up' => 'ArrowUp',
		);
	$upper = null;
	$shortcuts_ok = array();

	foreach ($shortcuts as $key => $value) {
		if ('' === $value) {
			$shortcuts_ok[$key] = $value;
		} elseif (in_array($value, SHORTCUT_KEYS)) {
			$shortcuts_ok[$key] = $value;
		} elseif (isset($legacy[$value])) {
			$shortcuts_ok[$key] = $legacy[$value];
		} else {	//Case-insensitive search
			if ($upper === null) {
				$upper = array_map('strtoupper', SHORTCUT_KEYS);
			}
			$i = array_search(strtoupper($value), $upper);
			if ($i !== false) {
				$shortcuts_ok[$key] = SHORTCUT_KEYS[$i];
			}
		}
	}
	return $shortcuts_ok;
}
