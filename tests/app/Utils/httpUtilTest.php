<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

/**
 * Tests for FreshRSS_http_Util
 */
class httpUtilTest extends \PHPUnit\Framework\TestCase {

	#[DataProvider('provideUrlsIgnoringHttps')]
	public function test_compareUrlIgnoringHttps(string $url1, string $url2, bool $expected): void {
		self::assertEquals($expected, FreshRSS_http_Util::compareUrlIgnoringHttps($url1, $url2) === 0);
	}

	/** @return list<array{string,string,bool}> */
	public static function provideUrlsIgnoringHttps(): array {
		return [
			// Only the scheme differs → equal
			['http://www.blogger.com/feeds/1/posts', 'https://www.blogger.com/feeds/1/posts', true],
			['https://example.net/feed.xml?a=1&b=2', 'http://example.net/feed.xml?a=1&b=2', true],
			['HTTP://Example.net/Feed', 'https://Example.net/Feed', true],
			['HTTPS://Example.net/Feed', 'http://Example.net/Feed', true],

			// Fully identical → equal
			['https://example.net/feed', 'https://example.net/feed', true],
			['', '', true],

			// Path differs → not equal (scheme-only tolerance must not hide real mismatches)
			['http://example.net/a', 'https://example.net/b', false],
			// Trailing slash is a path difference → not equal
			['http://example.net/', 'https://example.net', false],
			// Host differs → not equal
			['http://a.example.net/feed', 'https://b.example.net/feed', false],
			// Query differs → not equal
			['https://example.net/feed?a=1', 'http://example.net/feed?a=2', false],
			// Non-http(s) schemes are compared as-is
			['ftp://example.net/feed', 'https://example.net/feed', false],
		];
	}

	/**
	 * @param array<mixed> $curlParams
	 * @param array<mixed> $expected
	 */
	#[DataProvider('provideCurlParamsToSanitize')]
	public function test_sanitizeCurlParams(array $curlParams, array $expected): void {
		self::assertSame($expected, FreshRSS_http_Util::sanitizeCurlParams($curlParams));
	}

	/** @return list<array{array<mixed>,array<mixed>}> */
	public static function provideCurlParamsToSanitize(): array {
		return [
			// Allowed options are kept as-is
			[[CURLOPT_USERAGENT => 'FreshRSS'], [CURLOPT_USERAGENT => 'FreshRSS']],
			[[CURLOPT_MAXREDIRS => 5], [CURLOPT_MAXREDIRS => 5]],
			[[], []],

			// Options outside the allowlist are dropped, whatever else is present
			[[CURLOPT_USERPWD => 'user:password'], []],
			[[CURLOPT_COOKIEJAR => '/tmp/evil'], []],
			[[CURLOPT_USERAGENT => 'FreshRSS', CURLOPT_USERPWD => 'user:password'], [CURLOPT_USERAGENT => 'FreshRSS']],
			// Non-integer keys are never valid cURL options
			[['CURLOPT_USERAGENT' => 'FreshRSS'], []],

			// The cookie file is only ever enabled, never given a path
			[[CURLOPT_COOKIEFILE => '/etc/passwd'], [CURLOPT_COOKIEFILE => '']],

			// Headers granting authentication are removed, the others are kept
			[[CURLOPT_HTTPHEADER => ['Accept: application/atom+xml', 'Remote-User: admin']],
				[CURLOPT_HTTPHEADER => [0 => 'Accept: application/atom+xml']]],
			[[CURLOPT_HTTPHEADER => ['X-WebAuth-User: admin', 'remote_user: admin', 'X-Custom: 1']],
				[CURLOPT_HTTPHEADER => [2 => 'X-Custom: 1']]],

			// The legacy proxy type 3 (NONE) is normalised to -1
			[[CURLOPT_PROXYTYPE => 3], [CURLOPT_PROXYTYPE => -1]],
			[[CURLOPT_PROXYTYPE => CURLPROXY_SOCKS5], [CURLOPT_PROXYTYPE => CURLPROXY_SOCKS5]],

			// Options declaring accepted values reject anything else
			[[CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V6], [CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V6]],
			[[CURLOPT_IPRESOLVE => 42], []],
			[[CURLOPT_IPRESOLVE => '1'], []],
		];
	}
}
