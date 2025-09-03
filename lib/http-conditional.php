<?php
declare(strict_types=1);

/*
 Enable support for HTTP/1.x conditional requests in PHP.
 Goal: Optimisation
 - If the client sends a HEAD request, avoid transferring data and return the correct headers.
 - If the client already has the same version in its cache, avoid transferring data again (304 Not Modified).
 - Possibility to control cache for client and proxies (public or private policy, life time).
 - When $feedMode is set to true, in the case of a RSS/ATOM feed,
   it puts a timestamp in the global variable $clientCacheDate to allow the sending of only the articles newer than the client’s cache.
 - When $compression is set to true, compress the data before sending it to the client and persistent connections are allowed.
 - When $session is set to true, automatically checks if $_SESSION has been modified during the last generation the document.

 Typical use:

```php
<?php
	require_once('http-conditional.php');
	//Date of the last modification of the content (Unix Timestamp format).
	//Examples: query the database, or last modification of a static file.
	$dateLastModification = ...;
	if (httpConditional($dateLastModification)) {
		... //Close database connections, and other cleaning.
		exit(); //No need to send anything
	}
	//Do not send any text to the client before this line.
	... //Rest of the script, just as you would do normally.
?>
```

 Version 1.10, 2024-12-22, https://alexandre.alapetite.fr/doc-alex/php-http-304/

 ------------------------------------------------------------------
 Written by Alexandre Alapetite in 2004, https://alexandre.alapetite.fr/cv/

 Copyright 2004-2023, Licence: Creative Commons "Attribution-ShareAlike 2.0 France" BY-SA (FR),
 https://creativecommons.org/licenses/by-sa/2.0/fr/
 https://alexandre.alapetite.fr/divers/apropos/#by-sa
 - Attribution. You must give the original author credit
 - Share Alike. If you alter, transform, or build upon this work,
   you may distribute the resulting work only under a license identical to this one
   (Can be included in GPL/LGPL projects)
 - The French law is authoritative
 - Any of these conditions can be waived if you get permission from Alexandre Alapetite
 - Please send to Alexandre Alapetite the modifications you make,
   in order to improve this file for the benefit of everybody

 If you want to distribute this code, please do it as a link to:
 https://alexandre.alapetite.fr/doc-alex/php-http-304/
*/

/**
 * In RSS/ATOM feedMode, contains the date of the clients last update.
 * Global public variable because PHP4 did not allow conditional arguments by reference
 * @var int
 */
$clientCacheDate = 0;

/**
 * Global private variable
 * @var bool
 */
$_sessionMode = false;

/**
 * RFC2616 HTTP/1.1: https://www.w3.org/Protocols/rfc2616/rfc2616.html
 * RFC1945 HTTP/1.0: https://www.w3.org/Protocols/rfc1945/rfc1945.txt
 * Credits: https://alexandre.alapetite.fr/doc-alex/php-http-304/
 *
 * @param int $UnixTimeStamp: Date of the last modification of the data to send to the client (Unix Timestamp format).
 * @param int $cacheSeconds (default 0) Lifetime in seconds of the document. If $cacheSeconds<0, cache is disabled.
 *	If $cacheSeconds==0, the document will be revalidated each time it is accessed. If $cacheSeconds>0, the document will be cashed and not revalidated against the server for this delay.
 * @phpstan-param 0|1|2 $cachePrivacy
 * @param int $cachePrivacy (default 0) 0=private, 1=normal (public), 2=forced public. When public, it allows a cashed document ($cacheSeconds>0) to be shared by several users.
 * @param bool $feedMode (default false) Special RSS/ATOM feeds.
 *	When true, it sets $cachePrivacy to 0 (private), does not use the modification time of the script itself, and puts the date of the client’s cache (or a old date from 1980) in the global variable $clientCacheDate.
 * @param bool $compression (default false) Enable the compression and allows persistent connections (automatic detection of the capacities of the client).
 * @param bool $session (default false) To be turned on when sessions are used. Checks if the data contained in $_SESSION has been modified during the last generation the document.
 * @return bool True if the connection can be closed (e.g.: the client has already the latest version), false if the new content has to be send to the client.
 */
function httpConditional(int $UnixTimeStamp, int $cacheSeconds = 0, int $cachePrivacy = 0, bool $feedMode = false, bool $compression = false, bool $session = false): bool {
	if (headers_sent()) return false;

	if (is_string($_SERVER['SCRIPT_FILENAME'] ?? null)) $scriptName = $_SERVER['SCRIPT_FILENAME'];
	elseif (is_string($_SERVER['PATH_TRANSLATED'] ?? null)) $scriptName = $_SERVER['PATH_TRANSLATED'];
	else return false;

	if ((!$feedMode) && (($modifScript = (int)filemtime($scriptName)) > $UnixTimeStamp))
		$UnixTimeStamp = $modifScript;
	$UnixTimeStamp = (int)min($UnixTimeStamp, time());
	$is304 = true;
	$is412 = false;
	$nbCond = 0;

	//rfc2616-sec3.html#sec3.3.1
	$dateLastModif = gmdate('D, d M Y H:i:s \G\M\T', $UnixTimeStamp);
	$dateCacheClient = 'Thu, 10 Jan 1980 20:30:40 GMT';

	//rfc2616-sec14.html#sec14.19 //='"0123456789abcdef0123456789abcdef"'
	if (is_string($_SERVER['QUERY_STRING'] ?? null)) $myQuery = '?' . $_SERVER['QUERY_STRING'];
	else $myQuery = '';
	if ($session && isset($_SESSION)) {
		global $_sessionMode;
		$_sessionMode = $session;
		$myQuery .= print_r($_SESSION, true) . session_name() . '=' . session_id();
	}
	$etagServer = '"' . md5($scriptName . $myQuery . '#' . $dateLastModif) . '"';

	// @phpstan-ignore booleanNot.alwaysTrue
	if ((!$is412) && is_string($_SERVER['HTTP_IF_MATCH'] ?? null)) { //rfc2616-sec14.html#sec14.24
		$etagsClient = stripslashes($_SERVER['HTTP_IF_MATCH']);
		$etagsClient = str_ireplace('-gzip', '', $etagsClient);
		$is412 = (($etagsClient !== '*') && (strpos($etagsClient, $etagServer) === false));
	}
	// @phpstan-ignore booleanAnd.leftAlwaysTrue
	if ($is304 && is_string($_SERVER['HTTP_IF_MODIFIED_SINCE'] ?? null)) { //rfc2616-sec14.html#sec14.25 //rfc1945.txt
		$nbCond++;
		$dateCacheClient = $_SERVER['HTTP_IF_MODIFIED_SINCE'];
		$p = strpos($dateCacheClient, ';');
		if ($p !== false)
			$dateCacheClient = substr($dateCacheClient, 0, $p);
		$is304 = ($dateCacheClient == $dateLastModif);
	}
	if ($is304 && is_string($_SERVER['HTTP_IF_NONE_MATCH'] ?? null)) { //rfc2616-sec14.html#sec14.26
		$nbCond++;
		$etagClient = stripslashes($_SERVER['HTTP_IF_NONE_MATCH']);
		$etagClient = str_ireplace('-gzip', '', $etagClient);
		$is304 = (($etagClient === $etagServer) || ($etagClient === '*'));
	}
	if ((!$is412) && is_string($_SERVER['HTTP_IF_UNMODIFIED_SINCE'] ?? null)) { //rfc2616-sec14.html#sec14.28
		$dateCacheClient = $_SERVER['HTTP_IF_UNMODIFIED_SINCE'];
		$p = strpos($dateCacheClient, ';');
		if ($p !== false)
			$dateCacheClient = substr($dateCacheClient, 0, $p);
		$is412 = ($dateCacheClient !== $dateLastModif);
	}
	if ($feedMode) { //Special RSS/ATOM
		global $clientCacheDate;
		$clientCacheDate = @strtotime($dateCacheClient);
		$cachePrivacy = 0;
	}

	if ($is412) { //rfc2616-sec10.html#sec10.4.13
		header('HTTP/1.1 412 Precondition Failed');
		header('Cache-Control: private, max-age=0, must-revalidate');
		header('Content-Type: text/plain');
		echo "HTTP/1.1 Error 412 Precondition Failed: Precondition request failed positive evaluation\n";
		return true;
	} elseif ($is304 && ($nbCond > 0)) { //rfc2616-sec10.html#sec10.3.5
		header('HTTP/1.0 304 Not Modified');
		header('Etag: ' . $etagServer);
		if ($feedMode) header('Connection: close'); //Comment this line under IIS
		return true;
	} else { //rfc2616-sec10.html#sec10.2.1
		//rfc2616-sec14.html#sec14.3
		if ($compression) ob_start('_httpConditionalCallBack'); //Will check HTTP_ACCEPT_ENCODING
		//header('HTTP/1.0 200 OK');
		if ($cacheSeconds < 0) {
			$cache = 'private, no-cache, no-store, must-revalidate';
			//header('Expires: 0');
			header('Pragma: no-cache');
		} else {
			if ($cacheSeconds === 0) {
				$cache = 'private, must-revalidate, ';
				//header('Expires: 0');
			} elseif ($cachePrivacy === 0) $cache = 'private, ';
			elseif ($cachePrivacy === 2) $cache = 'public, ';
			else $cache = '';
			$cache .= 'max-age=' . floor($cacheSeconds);
		}
		//header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T',time()+$cacheSeconds)); //HTTP/1.0 //rfc2616-sec14.html#sec14.21
		header('Cache-Control: ' . $cache); //rfc2616-sec14.html#sec14.9
		header('Last-Modified: ' . $dateLastModif);
		header('Etag: ' . $etagServer);
		if ($feedMode) header('Connection: close'); //rfc2616-sec14.html#sec14.10 //Comment this line under IIS
		return $_SERVER['REQUEST_METHOD'] === 'HEAD'; //rfc2616-sec9.html#sec9.4
	}
}

/**
 * Private function automatically called at the end of the script when compression is enabled.
 * One can adjust the level of compression with zlib.output_compression_level in php.ini
 * Reference rfc2616-sec14.html#sec14.11
 */
function _httpConditionalCallBack(string $buffer, int $mode = 5): string {
	if (extension_loaded('zlib') && (ini_get('zlib.output_compression') == false)) {
		$buffer2 = ob_gzhandler($buffer, $mode) ?: ''; //Will check HTTP_ACCEPT_ENCODING and put correct headers such as Vary //rfc2616-sec14.html#sec14.44
		if (strlen($buffer2) > 1) //When ob_gzhandler succeeded
			$buffer = $buffer2;
	}
	header('Content-Length: ' . strlen($buffer)); //Allows persistent connections //rfc2616-sec14.html#sec14.13
	return $buffer;
}

/**
 * Update HTTP headers if the content has just been modified by the client’s request.
 * See an example on https://alexandre.alapetite.fr/doc-alex/compteur/
 */
function httpConditionalRefresh(int $UnixTimeStamp): void {
	if (headers_sent()) return;

	if (is_string($_SERVER['SCRIPT_FILENAME'] ?? null)) $scriptName = $_SERVER['SCRIPT_FILENAME'];
	elseif (is_string($_SERVER['PATH_TRANSLATED'] ?? null)) $scriptName = $_SERVER['PATH_TRANSLATED'];
	else return;

	$dateLastModif = gmdate('D, d M Y H:i:s \G\M\T', $UnixTimeStamp);

	if (is_string($_SERVER['QUERY_STRING'] ?? null)) $myQuery = '?' . $_SERVER['QUERY_STRING'];
	else $myQuery = '';
	global $_sessionMode;
	if ($_sessionMode && isset($_SESSION))
		$myQuery .= print_r($_SESSION, true) . session_name() . '=' . session_id();
	$etagServer = '"' . md5($scriptName . $myQuery . '#' . $dateLastModif) . '"';

	header('Last-Modified: ' . $dateLastModif);
	header('Etag: ' . $etagServer);
}
