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

function searchFavicon(string $url): string {
	$dom = new DOMDocument();
	['body' => $html, 'effective_url' => $effective_url, 'fail' => $fail] = httpGet($url, cachePath: CACHE_PATH . '/' . sha1($url) . '.html', type: 'html');
	if ($fail || $html === '' || !@$dom->loadHTML($html, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING)) {
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
	$baseUrl = ($baseElement instanceof DOMElement) ? $baseElement->getAttribute('href') : $effective_url;

	foreach ($links as $link) {
		if (!$link instanceof DOMElement) {
			continue;
		}
		$href = trim($link->getAttribute('href'));
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
			return '';
		}
		$favicon = httpGet($iri, faviconCachePath($iri), 'ico', curl_options: [
			CURLOPT_REFERER => $effective_url,
		])['body'];
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
		$rootUrl = preg_replace('%^(https?://[^/]+).*$%i', '$1/', $url) ?? $url;
		if ($rootUrl != $url) {
			$url = $rootUrl;
			$favicon = searchFavicon($url);
		}
		if ($favicon == '') {
			$link = $rootUrl . 'favicon.ico';
			$favicon = httpGet($link, faviconCachePath($link), 'ico', curl_options: [
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
