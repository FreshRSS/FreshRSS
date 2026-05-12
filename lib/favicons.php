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
	$fInfo = finfo_open(FILEINFO_MIME_TYPE);
	if ($fInfo === false) {
		return true;
	}
	$content = finfo_buffer($fInfo, $content);
	$isImage = str_contains($content ?: '', 'image');
	return $isImage;
}

function faviconCachePath(string $url): string {
	return CACHE_PATH . '/' . sha1($url) . '.ico';
}

/**
 * @param list<string> $linkHrefs candidate favicon URLs (relative or absolute), in document order
 */
function tryFaviconLinks(array $linkHrefs, string $baseUrl, string $effective_url): string {
	foreach ($linkHrefs as $href) {
		$href = trim($href);
		$urlParts = parse_url($effective_url);

		// Handle protocol-relative URLs by adding the current URL's scheme
		if (substr($href, 0, 2) === '//') {
			$href = ($urlParts['scheme'] ?? 'https') . ':' . $href;
		}

		$href = \SimplePie\IRI::absolutize($baseUrl, $href);
		if ($href == false) {
			return '';
		}

		$iri = $href->get_iri();
		if ($iri == false) {
			continue;
		}
		$iri = FreshRSS_http_Util::checkUrl($iri, fixScheme: false);
		if (!is_string($iri) || $iri === '') {
			continue;
		}
		$favicon = FreshRSS_http_Util::httpGet($iri, faviconCachePath($iri), 'ico', curl_options: [
			CURLOPT_REFERER => $effective_url,
		])['body'];
		if (isImgMime($favicon)) {
			return $favicon;
		}
	}
	return '';
}

function searchFavicon(string $url): string {
	$url = trim($url);
	if ($url === '') {
		return '';
	}
	['body' => $html, 'effective_url' => $effective_url, 'fail' => $fail] =
		FreshRSS_http_Util::httpGet($url, cachePath: CACHE_PATH . '/' . sha1($url) . '.html', type: 'html');
	if ($fail || $html === '') {
		return '';
	}

	$linkXPath = '//link[@href][translate(@rel, "ABCDEFGHIJKLMNOPQRSTUVWXYZ", "abcdefghijklmnopqrstuvwxyz")="shortcut icon"'
		. ' or translate(@rel, "ABCDEFGHIJKLMNOPQRSTUVWXYZ", "abcdefghijklmnopqrstuvwxyz")="icon"]';

	if (class_exists('Dom\HTMLDocument')) {	// PHP 8.4+
		// HTML_NO_DEFAULT_NS keeps elements in no namespace, so existing XPath queries (e.g. //link) still match.
		$dom = Dom\HTMLDocument::createFromString($html, LIBXML_NOERROR | Dom\HTML_NO_DEFAULT_NS);
		$xpath = new Dom\XPath($dom);
		$linkHrefs = [];
		foreach ($xpath->query($linkXPath) as $link) {
			if ($link instanceof Dom\Element) {
				$linkHrefs[] = $link->getAttribute('href');
			}
		}
		$baseUrl = $effective_url;
		$baseElement = $xpath->query('//base[@href]')->item(0);
		if ($baseElement instanceof Dom\Element) {
			$baseUrl = $baseElement->getAttribute('href');
		}
		return tryFaviconLinks($linkHrefs, $baseUrl, $effective_url);
	}

	// PHP < 8.4
	$dom = new DOMDocument();
	if (!@$dom->loadHTML($html, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING)) {
		return '';
	}

	$xpath = new DOMXPath($dom);
	$links = $xpath->query($linkXPath);
	if (!($links instanceof DOMNodeList)) {
		return '';
	}

	// Use the base element for relative paths, if there is one
	$baseElements = $xpath->query('//base[@href]');
	$baseElement = ($baseElements !== false && $baseElements->length > 0) ? $baseElements->item(0) : null;
	$baseUrl = ($baseElement instanceof DOMElement) ? $baseElement->getAttribute('href') : $effective_url;

	$linkHrefs = [];
	foreach ($links as $link) {
		if ($link instanceof DOMElement) {
			$linkHrefs[] = $link->getAttribute('href');
		}
	}
	return tryFaviconLinks($linkHrefs, $baseUrl, $effective_url);
}

/**
 * Downloads a favicon directly from a known image URL (e.g. from a feed's <image><url> or icon field).
 * Returns false without any fallback if the URL does not point to a valid image.
 */
function download_favicon_from_image_url(string $imageUrl, string $dest): bool {
	$imageUrl = FreshRSS_http_Util::checkUrl($imageUrl);
	if (!is_string($imageUrl) || $imageUrl === '') {
		return false;
	}
	$favicon = FreshRSS_http_Util::httpGet($imageUrl, faviconCachePath($imageUrl), 'ico')['body'];
	if (!isImgMime($favicon)) {
		return false;
	}
	return file_put_contents($dest, $favicon) > 0;
}

function download_favicon(string $url, string $dest): bool {
	$url = FreshRSS_http_Util::checkUrl($url);
	if (!is_string($url) || $url === '') {
		return @copy(DEFAULT_FAVICON, $dest);
	}
	$favicon = searchFavicon($url);
	if ($favicon == '') {
		$rootUrl = preg_replace('%^(https?://[^/]+).*$%i', '$1/', $url) ?? $url;
		if ($rootUrl != $url) {
			$url = $rootUrl;
			$favicon = searchFavicon($url);
		}
		if ($favicon == '') {
			$link = FreshRSS_http_Util::checkUrl($rootUrl . 'favicon.ico', fixScheme: false) ?: '';
			$favicon = $link === '' ? '' : FreshRSS_http_Util::httpGet($link, faviconCachePath($link), 'ico', curl_options: [
				CURLOPT_REFERER => $url,
			])['body'];
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
