<?php
if (!function_exists('json_decode')) {
	require_once('JSON.php');
	function json_decode($var) {
		$JSON = new Services_JSON;
		return (array)($JSON->decode($var));
	}
}

if (!function_exists('json_encode')) {
	require_once('JSON.php');
	function json_encode($var) {
		$JSON = new Services_JSON;
		return $JSON->encodeUnsafe($var);
	}
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
				@include(APP_PATH . '/' . $components[2] . 's/' . $components[1] . $components[2] . '.php');
				return;
		}
	} elseif (strpos($class, 'Minz') === 0) {
		include(LIB_PATH . '/' . str_replace('_', '/', $class) . '.php');
	} elseif (strpos($class, 'SimplePie') === 0) {
		include(LIB_PATH . '/SimplePie/' . str_replace('_', '/', $class) . '.php');
	}
}

spl_autoload_register('classAutoloader');
//</Auto-loading>

function checkUrl($url) {
	if (empty ($url)) {
		return '';
	}
	if (!preg_match ('#^https?://#i', $url)) {
		$url = 'http://' . $url;
	}
	if (filter_var($url, FILTER_VALIDATE_URL) ||
		(version_compare(PHP_VERSION, '5.3.3', '<') && (strpos($url, '-') > 0) &&	//PHP bug #51192
		 ($url === filter_var($url, FILTER_SANITIZE_URL)))) {
		return $url;
	} else {
		return false;
	}
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
	}
	$bytes = max(intval($bytes), 0);
	$pow = $bytes === 0 ? 0 : floor(log($bytes) / log($base));
	$pow = min($pow, count($units) - 1);
	$bytes /= pow($base, $pow);
	return format_number($bytes, $precision) . ' ' . $units[$pow];
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
		if (version_compare(PHP_VERSION, '5.3.4') >= 0) {
			$htmlEntitiesOnly = array_flip(array_diff(
				get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES, 'UTF-8'),	//Decode HTML entities
				get_html_translation_table(HTML_SPECIALCHARS, ENT_NOQUOTES, 'UTF-8')	//Preserve XML entities
			));
		} else {
			$htmlEntitiesOnly = array_map('utf8_encode', array_flip(array_diff(
				get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES),	//Decode HTML entities
				get_html_translation_table(HTML_SPECIALCHARS, ENT_NOQUOTES)	//Preserve XML entities
			)));
		}
	}
	return strtr($text, $htmlEntitiesOnly);
}

function customSimplePie() {
	$system_conf = Minz_Configuration::get('system');
	$limits = $system_conf->limits;
	$simplePie = new SimplePie();
	$simplePie->set_useragent(_t('gen.freshrss') . '/' . FRESHRSS_VERSION . ' (' . PHP_OS . '; ' . FRESHRSS_WEBSITE . ') ' . SIMPLEPIE_NAME . '/' . SIMPLEPIE_VERSION);
	$simplePie->set_cache_location(CACHE_PATH);
	$simplePie->set_cache_duration($limits['cache_duration']);
	$simplePie->set_timeout($limits['timeout']);
	$simplePie->strip_htmltags(array(
		'base', 'blink', 'body', 'doctype', 'embed',
		'font', 'form', 'frame', 'frameset', 'html',
		'link', 'input', 'marquee', 'meta', 'noscript',
		'object', 'param', 'plaintext', 'script', 'style',
	));
	$simplePie->strip_attributes(array_merge($simplePie->strip_attributes, array(
		'autoplay', 'onload', 'onunload', 'onclick', 'ondblclick', 'onmousedown', 'onmouseup',
		'onmouseover', 'onmousemove', 'onmouseout', 'onfocus', 'onblur',
		'onkeypress', 'onkeydown', 'onkeyup', 'onselect', 'onchange', 'seamless')));
	$simplePie->add_attributes(array(
		'img' => array('lazyload' => '', 'postpone' => ''),	//http://www.w3.org/TR/resource-priorities/
		'audio' => array('lazyload' => '', 'postpone' => '', 'preload' => 'none'),
		'iframe' => array('lazyload' => '', 'postpone' => '', 'sandbox' => 'allow-scripts allow-same-origin'),
		'video' => array('lazyload' => '', 'postpone' => '', 'preload' => 'none'),
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
	return $simplePie;
}

function sanitizeHTML($data, $base = '') {
	static $simplePie = null;
	if ($simplePie == null) {
		$simplePie = customSimplePie();
		$simplePie->init();
	}
	return html_only_entity_decode($simplePie->sanitize->sanitize($data, SIMPLEPIE_CONSTRUCT_HTML, $base));
}

/* permet de récupérer le contenu d'un article pour un flux qui n'est pas complet */
function get_content_by_parsing ($url, $path) {
	require_once (LIB_PATH . '/lib_phpQuery.php');

	Minz_Log::notice('FreshRSS GET ' . url_remove_credentials($url));
	$html = file_get_contents ($url);

	if ($html) {
		$doc = phpQuery::newDocument ($html);
		$content = $doc->find ($path);
		return sanitizeHTML($content->__toString(), $url);
	} else {
		throw new Exception ();
	}
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
	return $t['sec'] . str_pad($t['usec'], 6, '0');
}

function uSecString() {
	$t = @gettimeofday();
	return str_pad($t['usec'], 6, '0');
}

function invalidateHttpCache() {
	Minz_Session::_param('touch', uTimeString());
	return touch(join_path(DATA_PATH, 'users', Minz_Session::param('currentUser', '_'), 'log.txt'));
}

function listUsers() {
	$final_list = array();
	$base_path = join_path(DATA_PATH, 'users');
	$dir_list = array_values(array_diff(
		scandir($base_path),
		array('..', '.', '_')
	));

	foreach ($dir_list as $file) {
		if (is_dir(join_path($base_path, $file))) {
			$final_list[] = $file;
		}
	}

	return $final_list;
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
	$namespace = 'user_' . $username;
	try {
		Minz_Configuration::register($namespace,
		                             join_path(USERS_PATH, $username, 'config.php'),
		                             join_path(USERS_PATH, '_', 'config.default.php'));
	} catch (Minz_ConfigurationNamespaceException $e) {
		// namespace already exists, do nothing.
	} catch (Minz_FileNotExistException $e) {
		Minz_Log::warning($e->getMessage());
		return null;
	}

	return Minz_Configuration::get($namespace);
}


function httpAuthUser() {
	return isset($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'] : '';
}

function cryptAvailable() {
	if (version_compare(PHP_VERSION, '5.3.3', '>=')) {
		try {
			$hash = '$2y$04$usesomesillystringfore7hnbRJHxXVLeakoG8K30oukPsA.ztMG';
			return $hash === @crypt('password', $hash);
		} catch (Exception $e) {
		}
	}
	return false;
}

function is_referer_from_same_domain() {
	if (empty($_SERVER['HTTP_REFERER'])) {
		return false;
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
	$pdo_sqlite = extension_loaded('pdo_sqlite');
	return array(
		'php' => version_compare(PHP_VERSION, '5.2.1') >= 0,
		'minz' => file_exists(LIB_PATH . '/Minz'),
		'curl' => extension_loaded('curl'),
		'pdo' => $pdo_mysql || $pdo_sqlite,
		'pcre' => extension_loaded('pcre'),
		'ctype' => extension_loaded('ctype'),
		'dom' => class_exists('DOMDocument'),
		'json' => extension_loaded('json'),
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
		'persona' => is_writable(DATA_PATH . '/persona'),
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
	);

	try {
		$dbDAO = FreshRSS_Factory::createDatabaseDAO();

		$status['tables'] = $dbDAO->tablesAreCorrect();
		$status['categories'] = $dbDAO->categoryIsCorrect();
		$status['feeds'] = $dbDAO->feedIsCorrect();
		$status['entries'] = $dbDAO->entryIsCorrect();
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


/**
 * Add a value in an array and take care it is unique.
 * @param $array the array in which we add the value.
 * @param $value the value to add.
 */
function array_push_unique(&$array, $value) {
	$found = array_search($value, $array) !== false;
	if (!$found) {
		$array[] = $value;
	}
}


/**
 * Remove a value from an array.
 * @param $array the array from wich value is removed.
 * @param $value the value to remove.
 */
function array_remove(&$array, $value) {
	$array = array_diff($array, array($value));
}


/**
 * Sanitize a URL by removing HTTP credentials.
 * @param $url the URL to sanitize.
 * @return the same URL without HTTP credentials.
 */
function url_remove_credentials($url) {
	return preg_replace('/[^\/]*:[^:]*@/', '', $url);
}
