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

	public function test_sanitizeCurlParams_whenKeyNotAllowlisted_removesIt(): void {
		$result = FreshRSS_http_Util::sanitizeCurlParams([CURLOPT_URL => 'https://example.net/']);
		self::assertSame([], $result);
	}

	public function test_sanitizeCurlParams_whenCookiefileSet_forcesEmptyValue(): void {
		$result = FreshRSS_http_Util::sanitizeCurlParams([CURLOPT_COOKIEFILE => '/etc/passwd']);
		self::assertSame('', $result[CURLOPT_COOKIEFILE]);
	}

	public function test_sanitizeCurlParams_whenHttpHeaderHasAuthOverrides_stripsThem(): void {
		$result = FreshRSS_http_Util::sanitizeCurlParams([
			CURLOPT_HTTPHEADER => ['Remote-User: admin', 'X-WebAuth-User: admin', 'x_webauth_user: admin', 'Accept: text/xml'],
		]);
		self::assertIsArray($result[CURLOPT_HTTPHEADER]);
		self::assertSame(['Accept: text/xml'], array_values($result[CURLOPT_HTTPHEADER]));
	}

	public function test_sanitizeCurlParams_whenHttpHeaderNotArray_passesThroughUnchanged(): void {
		$result = FreshRSS_http_Util::sanitizeCurlParams([CURLOPT_HTTPHEADER => 'not-an-array']);
		self::assertSame('not-an-array', $result[CURLOPT_HTTPHEADER]);
	}

	public function test_sanitizeCurlParams_whenAllowlistedKeyHasNoSpecialCase_keepsValueAsIs(): void {
		$result = FreshRSS_http_Util::sanitizeCurlParams([
			CURLOPT_USERAGENT => 'my-agent/1.0',
			CURLOPT_MAXREDIRS => 3,
			CURLOPT_PROXY => 'http://proxy.example.net:8080',
		]);
		self::assertSame('my-agent/1.0', $result[CURLOPT_USERAGENT]);
		self::assertSame(3, $result[CURLOPT_MAXREDIRS]);
		self::assertSame('http://proxy.example.net:8080', $result[CURLOPT_PROXY]);
	}
}
