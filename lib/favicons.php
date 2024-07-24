<?php
declare(strict_types=1);

const FAVICONS_DIR = DATA_PATH . '/favicons/';
const DEFAULT_FAVICON = PUBLIC_PATH . '/themes/icons/default_favicon.ico';

function isImgMime(string $content): bool {
	//Based on https://github.com/ArthurHoaro/favicon/blob/3a4f93da9bb24915b21771eb7873a21bde26f5d1/src/Favicon/Favicon.php#L311-L319
	if ($content == '') {
		return false;
	}
	if (!extension_loaded('fileinfo')) {
		return true;
	}
	$isImage = true;
	/** @var finfo $fInfo */
	$fInfo = finfo_open(FILEINFO_MIME_TYPE);
	/** @var string $content */
	$content = finfo_buffer($fInfo, $content);
	$isImage = strpos($content, 'image') !== false;
	finfo_close($fInfo);
	return $isImage;
}

/** @param array<int,int|bool> $curlOptions */
function downloadHttp(string &$url, array $curlOptions = []): string {
	syslog(LOG_INFO, 'FreshRSS Favicon GET ' . $url);
	$url = checkUrl($url);
	if ($url == false) {
		return '';
	}
	/** @var CurlHandle $ch */
	$ch = curl_init($url);
	curl_setopt_array($ch, [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => 15,
			CURLOPT_USERAGENT => FRESHRSS_USERAGENT,
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ENCODING => '',	//Enable all encodings
			//CURLOPT_VERBOSE => 1,	// To debug sent HTTP headers
		]);

	FreshRSS_Context::initSystem();
	if (FreshRSS_Context::hasSystemConf()) {
		curl_setopt_array($ch, FreshRSS_Context::systemConf()->curl_options);
	}

	curl_setopt_array($ch, $curlOptions);

	$response = curl_exec($ch);
	if (!is_string($response)) {
		$response = '';
	}
	$info = curl_getinfo($ch);
	curl_close($ch);
	if (!empty($info['url'])) {
		$url2 = checkUrl($info['url']);
		if ($url2 != '') {
			$url = $url2;	//Possible redirect
		}
	}
	return $info['http_code'] == 200 ? $response : '';
}

function searchFavicon(string &$url): string {
	$dom = new DOMDocument();
	$html = downloadHttp($url);

	if ($html == '' || !@$dom->loadHTML($html, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING)) {
		return '';
	}

	$xpath = new DOMXPath($dom);
	$links = $xpath->query('//link[@href][translate(@rel, "ABCDEFGHIJKLMNOPQRSTUVWXYZ", "abcdefghijklmnopqrstuvwxyz")="shortcut icon"'
		. ' or translate(@rel, "ABCDEFGHIJKLMNOPQRSTUVWXYZ", "abcdefghijklmnopqrstuvwxyz")="icon"]');

	if (!($links instanceof DOMNodeList)) {
		return '';
	}

	// Use the base element for relative paths, if there is one
	$baseElements = $xpath->query('//base[@href]');
	$baseElement = ($baseElements !== false && $baseElements->length > 0) ? $baseElements->item(0) : null;
	$baseUrl = ($baseElement instanceof DOMElement) ? $baseElement->getAttribute('href') : $url;

	foreach ($links as $link) {
		if (!$link instanceof DOMElement) {
			continue;
		}
		$href = trim($link->getAttribute('href'));
		$urlParts = parse_url($url);

		// Handle protocol-relative URLs by adding the current URL's scheme
		if (substr($href, 0, 2) === '//') {
			$href = ($urlParts['scheme'] ?? 'https') . ':' . $href;
		}

		$href = SimplePie_IRI::absolutize($baseUrl, $href);
		if ($href == false) {
			return '';
		}

		$iri = $href->get_iri();
		$favicon = downloadHttp($iri, array(CURLOPT_REFERER => $url));
		if (isImgMime($favicon)) {
			return $favicon;
		}
	}
	return '';
}

function download_favicon(string $url, string $dest): bool {
	$url = trim($url);
	$favicon = searchFavicon($url);
	if ($favicon == '') {
		$rootUrl = preg_replace('%^(https?://[^/]+).*$%i', '$1/', $url);
		if ($rootUrl != $url) {
			$url = $rootUrl;
			$favicon = searchFavicon($url);
		}
		if ($favicon == '') {
			$link = $rootUrl . 'favicon.ico';
			$favicon = downloadHttp($link, array(
					CURLOPT_REFERER => $url,
				));
			if (!isImgMime($favicon)) {
				$favicon = '';
			}
		}
	}
	return ($favicon != '' && file_put_contents($dest, $favicon) > 0) ||
		@copy(DEFAULT_FAVICON, $dest);
}

function contentType(string $ico): string {
	$ico_content_type = 'image/x-icon';
	if (function_exists('mime_content_type')) {
		$ico_content_type = mime_content_type($ico) ?: $ico_content_type;
	}
	switch ($ico_content_type) {
		case 'image/svg':
			$ico_content_type = 'image/svg+xml';
			break;
	}
	return $ico_content_type;
}
