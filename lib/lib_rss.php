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

// tiré de Shaarli de Seb Sauvage	//Format RFC 4648 base64url
function small_hash ($txt) {
	$t = rtrim (base64_encode (hash ('crc32', $txt, true)), '=');
	return strtr ($t, '+/', '-_');
}

function formatBytes($bytes, $precision = 2, $system = 'IEC') {
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
	return round($bytes, $precision) . ' ' . $units[$pow];
}

function timestamptodate ($t, $hour = true) {
	$month = Minz_Translate::t (date('M', $t));
	if ($hour) {
		$date = Minz_Translate::t ('format_date_hour', $month);
	} else {
		$date = Minz_Translate::t ('format_date', $month);
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

function sanitizeHTML($data) {
	static $simplePie = null;
	if ($simplePie == null) {
		$simplePie = new SimplePie();
	}
	return html_only_entity_decode($simplePie->sanitize->sanitize($data, SIMPLEPIE_CONSTRUCT_MAYBE_HTML));
}

/* permet de récupérer le contenu d'un article pour un flux qui n'est pas complet */
function get_content_by_parsing ($url, $path) {
	require_once (LIB_PATH . '/lib_phpQuery.php');

	$html = file_get_contents ($url);

	if ($html) {
		$doc = phpQuery::newDocument ($html);
		$content = $doc->find ($path);
		$content->find ('*')->removeAttr ('style')
		                    ->removeAttr ('id')
		                    ->removeAttr ('class')
		                    ->removeAttr ('onload')
		                    ->removeAttr ('target');
		$content->removeAttr ('style')
		        ->removeAttr ('id')
		        ->removeAttr ('class')
		        ->removeAttr ('onload')
		        ->removeAttr ('target');
		return $content->__toString ();
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
		'/<img([^>]+?)src=[\'"]([^"\']+)[\'"]([^>]*)>/i',
		'<img$1src="' . Minz_Url::display('/themes/icons/grey.gif') . '" data-original="$2"$3>',
		$content
	);
}

function lazyIframe($content) {
	return preg_replace(
		'/<iframe([^>]+?)src=[\'"]([^"\']+)[\'"]([^>]*)>/i',
		'<iframe$1src="about:blank" data-original="$2"$3>',
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

function invalidateHttpCache($currentUser = '') {	//TODO: Make multi-user compatible
	file_put_contents(DATA_PATH . '/touch.txt', uTimeString());
}

function usernameFromPath($userPath) {
	if (preg_match('%/([a-z0-9]{1,16})_user\.php$%', $userPath, $matches)) {
		return $matches[1];
	} else {
		return '';
	}
}

function isValidUser($user) {
	return $user != '' && ctype_alnum($user) && file_exists(DATA_PATH . '/' . $user . '_user.php');
}

function listUsers() {
	return array_map('usernameFromPath', glob(DATA_PATH . '/*_user.php'));
}

function httpAuthUser() {
	return isset($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'] : '';
}
