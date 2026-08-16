<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

require_once LIB_PATH . '/favicons.php';

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

	#[DataProvider('provideForceHttpsUrls')]
	public function testForceHttps(string $url, string $expected): void {
		self::assertSame($expected, FreshRSS_http_Util::forceHttps($url));
	}

	/** @return list<array{string,string}> */
	public static function provideForceHttpsUrls(): array {
		return [
			['http://github.com/FreshRSS/FreshRSS', 'https://github.com/FreshRSS/FreshRSS'],
			['http://www.github.com/FreshRSS/FreshRSS', 'https://www.github.com/FreshRSS/FreshRSS'],
			['http://GitHub.com/FreshRSS/FreshRSS', 'https://GitHub.com/FreshRSS/FreshRSS'],
			['https://github.com/FreshRSS/FreshRSS', 'https://github.com/FreshRSS/FreshRSS'],
			['http://notgithub.com/FreshRSS/FreshRSS', 'http://notgithub.com/FreshRSS/FreshRSS'],
			['http://github.com.example/FreshRSS/FreshRSS', 'http://github.com.example/FreshRSS/FreshRSS'],
		];
	}

	public function testFaviconCacheUsesForcedHttpsUrl(): void {
		$url = 'http://github.com/FreshRSS/FreshRSS';
		self::assertSame(
			CACHE_PATH . '/' . sha1('https://github.com/FreshRSS/FreshRSS') . '.ico',
			faviconCachePath($url)
		);
	}

	public function testHttpGetUsesForcedHttpsUrlBeforeCache(): void {
		FreshRSS_Context::initSystem();
		$cachePath = tempnam(sys_get_temp_dir(), 'freshrss-force-https-');
		if ($cachePath === false) {
			self::fail('Could not create a temporary cache file');
		}
		try {
			file_put_contents($cachePath, 'cached');
			$response = FreshRSS_http_Util::httpGet('http://github.com/FreshRSS/FreshRSS', $cachePath);
			self::assertSame('https://github.com/FreshRSS/FreshRSS', $response['effective_url']);
			self::assertSame(-200, $response['status']);
		} finally {
			@unlink($cachePath);
		}
	}
}
