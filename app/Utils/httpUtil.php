<?php
declare(strict_types=1);

final class FreshRSS_http_Util {

	private const RETRY_AFTER_PATH = DATA_PATH . '/Retry-After/';

	private static function getRetryAfterFile(string $url, string $proxy): string {
		$domain = parse_url($url, PHP_URL_HOST);
		if (!is_string($domain) || $domain === '') {
			return '';
		}
		$domainWide = Minz_Request::serverIsPublic($domain);
		$port = parse_url($url, PHP_URL_PORT);
		if (is_int($port)) {
			$domain .= ':' . $port;
		}
		return self::RETRY_AFTER_PATH . urlencode($domain) .
			($domainWide ? '' : '_' . hash('sha256', $url)) .
			(empty($proxy) ? '' : '_' . urlencode($proxy)) . '.txt';
	}

	/**
	 * Clean up old Retry-After files
	 */
	private static function cleanRetryAfters(): void {
		if (!is_dir(self::RETRY_AFTER_PATH)) {
			return;
		}
		$files = glob(self::RETRY_AFTER_PATH . '*.txt', GLOB_NOSORT);
		if ($files === false) {
			return;
		}
		foreach ($files as $file) {
			if (@filemtime($file) < time()) {
				@unlink($file);
			}
		}
	}

	/**
	 * Check whether the URL needs to wait for a Retry-After period.
	 * @return int The timestamp of when the Retry-After expires, or 0 if not set.
	 */
	public static function getRetryAfter(string $url, string $proxy): int {
		if (rand(0, 30) === 1) {	// Remove old files once in a while
			self::cleanRetryAfters();
		}
		$txt = self::getRetryAfterFile($url, $proxy);
		if ($txt === '') {
			return 0;
		}
		$retryAfter = @filemtime($txt) ?: 0;
		if ($retryAfter <= 0) {
			return 0;
		}
		if ($retryAfter < time()) {
			@unlink($txt);
			return 0;
		}
		return $retryAfter;
	}

	/**
	 * Store the HTTP Retry-After header value of an HTTP `429 Too Many Requests` or `503 Service Unavailable` response.
	 */
	public static function setRetryAfter(string $url, string $proxy, string $retryAfter): int {
		$txt = self::getRetryAfterFile($url, $proxy);
		if ($txt === '') {
			return 0;
		}

		$limits = FreshRSS_Context::systemConf()->limits;
		if (ctype_digit($retryAfter)) {
			$retryAfter = time() + (int)$retryAfter;
		} else {
			$retryAfter = \SimplePie\Misc::parse_date($retryAfter) ?:
				(time() + max(600, $limits['retry_after_default'] ?? 0));
		}
		$retryAfter = min($retryAfter, time() + max(3600, $limits['retry_after_max'] ?? 0));

		@mkdir(self::RETRY_AFTER_PATH);
		if (!touch($txt, $retryAfter)) {
			Minz_Log::error('Failed to set Retry-After for ' . $url);
			return 0;
		}
		return $retryAfter;
	}

	/**
	 * @param array<mixed> $curl_params
	 * @return array<mixed>
	 */
	public static function sanitizeCurlParams(array $curl_params): array {
		$safe_params = [
			CURLOPT_COOKIE,
			CURLOPT_COOKIEFILE,
			CURLOPT_FOLLOWLOCATION,
			CURLOPT_HTTPHEADER,
			CURLOPT_MAXREDIRS,
			CURLOPT_POST,
			CURLOPT_POSTFIELDS,
			CURLOPT_PROXY,
			CURLOPT_PROXYTYPE,
			CURLOPT_USERAGENT,
		];
		foreach ($curl_params as $k => $_) {
			if (!in_array($k, $safe_params, true)) {
				unset($curl_params[$k]);
				continue;
			}
			// Allow only an empty value just to enable the libcurl cookie engine
			if ($k === CURLOPT_COOKIEFILE) {
				$curl_params[$k] = '';
			}
		}
		return $curl_params;
	}

	private static function idn_to_puny(string $url): string {
		if (function_exists('idn_to_ascii')) {
			$idn = parse_url($url, PHP_URL_HOST);
			if (is_string($idn) && $idn != '') {
				$puny = idn_to_ascii($idn);
				$pos = strpos($url, $idn);
				if ($puny != false && $pos !== false) {
					$url = substr_replace($url, $puny, $pos, strlen($idn));
				}
			}
		}
		return $url;
	}

	public static function checkUrl(string $url, bool $fixScheme = true): string|false {
		$url = trim($url);
		if ($url == '') {
			return '';
		}
		if ($fixScheme && preg_match('#^https?://#i', $url) !== 1) {
			$url = 'https://' . ltrim($url, '/');
		}

		$url = self::idn_to_puny($url);	// https://bugs.php.net/bug.php?id=53474
		$urlRelaxed = str_replace('_', 'z', $url);	//PHP discussion #64948 Underscore

		if (is_string(filter_var($urlRelaxed, FILTER_VALIDATE_URL))) {
			return $url;
		} else {
			return false;
		}
	}

	/**
	 * Remove the charset meta information of an HTML document, e.g.:
	 * `<meta charset="..." />`
	 * `<meta http-equiv="Content-Type" content="text/html; charset=...">`
	 */
	private static function stripHtmlMetaCharset(string $html): string {
		return preg_replace('/<meta\s[^>]*charset\s*=\s*[^>]+>/i', '', $html, 1) ?? '';
	}

	/**
	 * Set an XML preamble to enforce the HTML content type charset received by HTTP.
	 * @param string $html the raw downloaded HTML content
	 * @param string $contentType an HTTP Content-Type such as 'text/html; charset=utf-8'
	 * @return string an HTML string with XML encoding information for DOMDocument::loadHTML()
	 */
	private static function enforceHttpEncoding(string $html, string $contentType = ''): string {
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
		$httpCharsetNormalized = \SimplePie\Misc::encoding($httpCharset);
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
			$utf8 = \SimplePie\Misc::change_encoding($html, $httpCharsetNormalized, 'UTF-8');
			if (is_string($utf8)) {
				$html = self::stripHtmlMetaCharset($utf8);
				$httpCharsetNormalized = 'UTF-8';
			}
		}
		if ($httpCharsetNormalized === 'UTF-8') {
			// Save encoding information as Unicode BOM
			return "\xEF\xBB\xBF" . $html;
		}
		// Give up
		return $html;
	}

	/**
	 * Set an HTML base URL to the HTML content if there is none.
	 * @param string $html the raw downloaded HTML content
	 * @param string $href the HTML base URL
	 * @return string an HTML string
	 */
	private static function enforceHtmlBase(string $html, string $href): string {
		$doc = new DOMDocument();
		$doc->loadHTML($html, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);
		if ($doc->documentElement === null) {
			return '';
		}
		$xpath = new DOMXPath($doc);
		$bases = $xpath->evaluate('//base');
		if (!($bases instanceof DOMNodeList) || $bases->length === 0) {
			$base = $doc->createElement('base');
			if ($base === false) {
				return $html;
			}
			$base->setAttribute('href', $href);
			$head = null;
			$heads = $xpath->evaluate('//head');
			if ($heads instanceof DOMNodeList && $heads->length > 0) {
				$head = $heads->item(0);
			}
			if ($head instanceof DOMElement) {
				$head->insertBefore($base, $head->firstChild);
			} else {
				$doc->documentElement->insertBefore($base, $doc->documentElement->firstChild);
			}
		}

		// Save the start of HTML because libxml2 saveHTML() risks scrambling it
		$htmlPos = stripos($html, '<html');
		$htmlStart = $htmlPos === false || $htmlPos > 512 ? '' : substr($html, 0, $htmlPos);

		$html = $doc->saveHTML() ?: $html;
		if ($htmlStart !== '' && !str_starts_with($html, $htmlStart)) {
			// libxml2 saveHTML() risks removing Unicode BOM and XML declaration,
			// which affects future detection of charset encoding, so manually restore it
			$htmlPos = stripos($html, '<html');
			$html = $htmlPos === false || $htmlPos > 512 ? $html : $htmlStart . substr($html, $htmlPos);
		}
		return $html;
	}

	/**
	 * @param non-empty-string $url
	 * @param string $type {html,ico,json,opml,xml}
	 * @param array<string,mixed> $attributes
	 * @param array<int,mixed> $curl_options
	 * @return array{body:string,effective_url:string,redirect_count:int,fail:bool}
	 */
	public static function httpGet(string $url, string $cachePath, string $type = 'html', array $attributes = [], array $curl_options = []): array {
		$limits = FreshRSS_Context::systemConf()->limits;
		$feed_timeout = empty($attributes['timeout']) || !is_numeric($attributes['timeout']) ? 0 : intval($attributes['timeout']);

		$cacheMtime = @filemtime($cachePath);
		if ($cacheMtime !== false && $cacheMtime > time() - intval($limits['cache_duration'])) {
			$body = @file_get_contents($cachePath);
			if ($body != false) {
				syslog(LOG_DEBUG, 'FreshRSS uses cache for ' . \SimplePie\Misc::url_remove_credentials($url));
				return ['body' => $body, 'effective_url' => $url, 'redirect_count' => 0, 'fail' => false];
			}
		}

		if (rand(0, 30) === 1) {	// Remove old cache once in a while
			cleanCache(CLEANCACHE_HOURS);
		}

		$options = [];
		$accept = '';
		$proxy = is_string(FreshRSS_Context::systemConf()->curl_options[CURLOPT_PROXY] ?? null) ? FreshRSS_Context::systemConf()->curl_options[CURLOPT_PROXY] : '';
		if (is_array($attributes['curl_params'] ?? null)) {
			$options = self::sanitizeCurlParams($attributes['curl_params']);
			$proxy = is_string($options[CURLOPT_PROXY] ?? null) ? $options[CURLOPT_PROXY] : '';
			if (is_array($options[CURLOPT_HTTPHEADER] ?? null)) {
				// Remove headers problematic for security
				$options[CURLOPT_HTTPHEADER] = array_filter($options[CURLOPT_HTTPHEADER],
					fn($header) => is_string($header) && !preg_match('/^(Remote-User|X-WebAuth-User)\\s*:/i', $header));
				// Add Accept header if it is not set
				if (preg_grep('/^Accept\\s*:/i', $options[CURLOPT_HTTPHEADER]) === false) {
					$options[CURLOPT_HTTPHEADER][] = 'Accept: ' . $accept;
				}
			}
		}

		if (($retryAfter = FreshRSS_http_Util::getRetryAfter($url, $proxy)) > 0) {
			Minz_Log::warning('For that domain, will first retry after ' . date('c', $retryAfter) . '. ' . \SimplePie\Misc::url_remove_credentials($url));
			return ['body' => '', 'effective_url' => $url, 'redirect_count' => 0, 'fail' => true];
		}

		if (FreshRSS_Context::systemConf()->simplepie_syslog_enabled) {
			syslog(LOG_INFO, 'FreshRSS GET ' . $type . ' ' . \SimplePie\Misc::url_remove_credentials($url));
		}

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
			case 'ico':
				$accept = 'image/x-icon,image/vnd.microsoft.icon,image/ico,image/png,image/svg+xml,image/*;q=0.8,*/*;q=0.1';
				break;
			case 'html':
			default:
				$accept = 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
				break;
		}

		// TODO: Implement HTTP 1.1 conditional GET If-Modified-Since
		$ch = curl_init();
		if ($ch === false) {
			return ['body' => '', 'effective_url' => '', 'redirect_count' => 0, 'fail' => true];
		}
		curl_setopt_array($ch, [
			CURLOPT_URL => $url,
			CURLOPT_HTTPHEADER => ['Accept: ' . $accept],
			CURLOPT_USERAGENT => FRESHRSS_USERAGENT,
			CURLOPT_CONNECTTIMEOUT => $feed_timeout > 0 ? $feed_timeout : $limits['timeout'],
			CURLOPT_TIMEOUT => $feed_timeout > 0 ? $feed_timeout : $limits['timeout'],
			CURLOPT_MAXREDIRS => 4,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ACCEPT_ENCODING => '',	//Enable all encodings
			//CURLOPT_VERBOSE => 1,	// To debug sent HTTP headers
		]);

		curl_setopt_array($ch, $options);
		curl_setopt_array($ch, FreshRSS_Context::systemConf()->curl_options);

		$responseHeaders = '';
		curl_setopt($ch, CURLOPT_HEADERFUNCTION, function (\CurlHandle $ch, string $header) use (&$responseHeaders) {
			if (trim($header) !== '') {	// Skip e.g. separation with trailer headers
				$responseHeaders .= $header;
			}
			return strlen($header);
		});

		if (isset($attributes['ssl_verify'])) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, empty($attributes['ssl_verify']) ? 0 : 2);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, (bool)$attributes['ssl_verify']);
			if (empty($attributes['ssl_verify'])) {
				curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
			}
		}

		curl_setopt_array($ch, $curl_options);

		$body = curl_exec($ch);
		$c_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$c_content_type = '' . curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
		$c_effective_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
		$c_redirect_count = curl_getinfo($ch, CURLINFO_REDIRECT_COUNT);
		$c_error = curl_error($ch);

		$headers = [];
		if ($body !== false) {
			assert($c_redirect_count >= 0);
			$responseHeaders = \SimplePie\HTTP\Parser::prepareHeaders($responseHeaders, $c_redirect_count + 1);
			$parser = new \SimplePie\HTTP\Parser($responseHeaders);
			if ($parser->parse()) {
				$headers = $parser->headers;
			}
		}

		$fail = $c_status != 200 || $c_error != '' || $body === false;
		if ($fail) {
			$body = '';
			Minz_Log::warning('Error fetching content: HTTP code ' . $c_status . ': ' . $c_error . ' ' . $url);
			if (in_array($c_status, [429, 503], true)) {
				$retryAfter = FreshRSS_http_Util::setRetryAfter($url, $proxy, $headers['retry-after'] ?? '');
				if ($c_status === 429) {
					$errorMessage = 'HTTP 429 Too Many Requests! [' . \SimplePie\Misc::url_remove_credentials($url) . ']';
				} elseif ($c_status === 503) {
					$errorMessage = 'HTTP 503 Service Unavailable! [' . \SimplePie\Misc::url_remove_credentials($url) . ']';
				}
				if ($retryAfter > 0) {
					$errorMessage .= ' We may retry after ' . date('c', $retryAfter);
				}
			}
			// TODO: Implement HTTP 410 Gone
		} elseif (!is_string($body) || strlen($body) === 0) {
			$body = '';
		} else {
			if (in_array($type, ['html', 'json', 'opml', 'xml'], true)) {
				$body = trim($body, " \n\r\t\v");	// Do not trim \x00 to avoid breaking a BOM
			}
			if (in_array($type, ['html', 'xml', 'opml'], true)) {
				$body = self::enforceHttpEncoding($body, $c_content_type);
			}
			if (in_array($type, ['html'], true)) {
				if (stripos($c_content_type, 'text/plain') !== false) {
					// Plain text to be displayed as preformatted text. Prefixed with UTF-8 BOM
					$body = "\xEF\xBB\xBF" . '<pre class="text-plain">' . htmlspecialchars($body, ENT_NOQUOTES, 'UTF-8') . '</pre>';
				} else {
					$body = self::enforceHtmlBase($body, $c_effective_url);
				}
			}
		}

		if (file_put_contents($cachePath, $body) === false) {
			Minz_Log::warning("Error saving cache $cachePath for $url");
		}

		return ['body' => $body, 'effective_url' => $c_effective_url, 'redirect_count' => $c_redirect_count, 'fail' => $fail];
	}

	/**
	 * Converts an IP (v4 or v6) to a binary representation using inet_pton
	 *
	 * @param string $ip the IP to convert
	 * @return string a binary representation of the specified IP
	 */
	private static function ipToBits(string $ip): string {
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
	private static function checkCIDR(string $ip, string $range): bool {
		$binary_ip = self::ipToBits($ip);
		$split = explode('/', $range);

		$subnet = $split[0] ?? '';
		if ($subnet == '') {
			return false;
		}
		$binary_subnet = self::ipToBits($subnet);

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
	 * Check if the client (e.g. last proxy) is allowed to send unsafe headers.
	 * This uses the `TRUSTED_PROXY` environment variable or the `trusted_sources` configuration option to get an array of the authorized ranges,
	 * The connection IP is obtained from the `CONN_REMOTE_ADDR`
	 * (if available, to be robust even when using Apache mod_remoteip) or `REMOTE_ADDR` environment variables.
	 * @return bool true if the sender’s IP is in one of the ranges defined in the configuration, else false
	 */
	public static function checkTrustedIP(): bool {
		if (!FreshRSS_Context::hasSystemConf()) {
			return false;
		}
		$remoteIp = Minz_Request::connectionRemoteAddress();
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
			if (self::checkCIDR($remoteIp, $cidr)) {
				return true;
			}
		}
		return false;
	}

	public static function httpAuthUser(bool $onlyTrusted = true): string {
		$auths = array_unique(
			array_intersect_key($_SERVER, ['REMOTE_USER' => '', 'REDIRECT_REMOTE_USER' => '', 'HTTP_REMOTE_USER' => '', 'HTTP_X_WEBAUTH_USER' => ''])
		);
		if (count($auths) > 1) {
			Minz_Log::warning('Multiple HTTP authentication headers!');
			return '';
		}

		if (!empty($_SERVER['REMOTE_USER']) && is_string($_SERVER['REMOTE_USER'])) {
			return $_SERVER['REMOTE_USER'];
		}
		if (!empty($_SERVER['REDIRECT_REMOTE_USER']) && is_string($_SERVER['REDIRECT_REMOTE_USER'])) {
			return $_SERVER['REDIRECT_REMOTE_USER'];
		}
		if (!$onlyTrusted || self::checkTrustedIP()) {
			if (!empty($_SERVER['HTTP_REMOTE_USER']) && is_string($_SERVER['HTTP_REMOTE_USER'])) {
				return $_SERVER['HTTP_REMOTE_USER'];
			}
			if (!empty($_SERVER['HTTP_X_WEBAUTH_USER']) && is_string($_SERVER['HTTP_X_WEBAUTH_USER'])) {
				return $_SERVER['HTTP_X_WEBAUTH_USER'];
			}
		}
		return '';
	}
}
