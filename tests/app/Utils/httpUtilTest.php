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

	#[DataProvider('provideUrlsForComparison')]
	public function test_normalizeUrlForComparison(string $url1, string $url2, bool $expected): void {
		self::assertEquals($expected, FreshRSS_http_Util::normalizeUrlForComparison($url1) === FreshRSS_http_Util::normalizeUrlForComparison($url2));
	}

	/** @return list<array{string,string,bool}> */
	public static function provideUrlsForComparison(): array {
		return [
			// Only the scheme differs → equal
			['http://example.net/feed', 'https://example.net/feed', true],
			// Only the host case differs → equal
			['https://Example.net/feed', 'https://example.net/feed', true],
			// Only a trailing slash differs → equal
			['https://example.net/feed/', 'https://example.net/feed', true],
			// Scheme, host case, and trailing slash all differ → still equal
			['HTTP://Example.NET/feed/', 'https://example.net/feed', true],

			// Fully identical → equal
			['https://example.net/feed', 'https://example.net/feed', true],

			// Path differs → not equal
			['https://example.net/feed-a', 'https://example.net/feed-b', false],
			// Host differs → not equal
			['https://a.example.net/feed', 'https://b.example.net/feed', false],
			// Query differs → not equal
			['https://example.net/feed?a=1', 'https://example.net/feed?a=2', false],
			// The URL fragment is intentionally ignored (e.g. FreshRSS's #force_feed convention) → equal
			['https://example.net/feed#force_feed', 'https://example.net/feed', true],
		];
	}
}
