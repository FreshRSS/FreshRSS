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

	#[DataProvider('provideTrustedSources')]
	public function test_isTrustedSource(string $ip, string $source, bool $expected): void {
		self::assertSame($expected, FreshRSS_http_Util::isTrustedSource($ip, $source));
	}

	/** @return list<array{string,string,bool}> */
	public static function provideTrustedSources(): array {
		return [
			// Bare IPv4 matches exactly, with an implicit /32 prefix
			['192.168.1.1', '192.168.1.1', true],
			['192.168.1.2', '192.168.1.1', false],
			// Explicit IPv4 CIDR
			['192.168.1.42', '192.168.1.0/24', true],
			['192.168.2.42', '192.168.1.0/24', false],
			['192.168.1.42', '192.168.1.0/32', false],
			// Bare IPv6 matches exactly, with an implicit /128 prefix
			['2001:db8::1', '2001:db8::1', true],
			['2001:db8::2', '2001:db8::1', false],
			// Explicit IPv6 CIDR
			['fe80::1234', 'fe80::/10', true],
			['fec0::1234', 'fe80::/10', false],
			// IPv4 and IPv6 ranges are not mixed
			['192.168.1.1', '192.168.1.1/128', false],
			['2001:db8::1', '2001:db8::1/32', true],
			['2001:db9::1', '2001:db8::/32', false],
			// Hostname entries resolve to their addresses (localhost is in /etc/hosts)
			['127.0.0.1', 'localhost', true],
			['127.0.0.2', 'localhost', false],
			// Unresolvable hostname matches nothing
			['127.0.0.1', 'nonexistent-host.invalid', false],
			// Invalid entries match nothing
			['192.168.1.1', '', false],
			['192.168.1.1', '   ', false],
			['192.168.1.1', '256.256.256.256', false],
			['192.168.1.1', '192.168.1.0/33', false],
			['192.168.1.1', '192.168.1.0/abc', false],
		];
	}
}
