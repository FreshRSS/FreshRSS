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

	#[DataProvider('provideCidrRanges')]
	public function test_checkCIDR(string $ip, string $range, bool $expected): void {
		$checkCIDR = new ReflectionMethod(FreshRSS_http_Util::class, 'checkCIDR');
		self::assertEquals($expected, $checkCIDR->invoke(null, $ip, $range));
	}

	/** @return list<array{string,string,bool}> */
	public static function provideCidrRanges(): array {
		return [
			// A range without a subnet is a single address
			['192.168.1.1', '192.168.1.1', true],
			['192.168.1.2', '192.168.1.1', false],
			['2001:db8::1', '2001:db8::1', true],
			['2001:db8::2', '2001:db8::1', false],

			// An explicit subnet keeps working
			['192.168.1.1', '192.168.1.1/32', true],
			['192.168.1.42', '192.168.1.0/24', true],
			['192.168.2.42', '192.168.1.0/24', false],
			['192.168.1.1', '0.0.0.0/0', true],
			['2001:db8::1', '2001:db8::/32', true],

			// Invalid input is still rejected
			['192.168.1.1', '', false],
			['192.168.1.1', '192.168.1.1/', false],
			['192.168.1.1', '192.168.1.1/33', false],
			['192.168.1.1', '192.168.1.1/abc', false],
			['192.168.1.1', 'gateway.localdomain', false],
			['192.168.1.1', '2001:db8::1', false],
			['not-an-ip', '192.168.1.1', false],
		];
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
			// Bare IPs and CIDR ranges delegate to checkCIDR()
			['192.168.1.1', '192.168.1.1', true],
			['192.168.1.2', '192.168.1.1', false],
			['192.168.1.42', '192.168.1.0/24', true],
			['2001:db8::1', '2001:db8::1', true],
			// Hostname entries resolve to their addresses (localhost is in /etc/hosts)
			['127.0.0.1', 'localhost', true],
			['127.0.0.2', 'localhost', false],
			// Unresolvable hostname matches nothing
			['127.0.0.1', 'nonexistent-host.invalid', false],
			// Empty and invalid entries match nothing
			['192.168.1.1', '', false],
			['192.168.1.1', '   ', false],
			['192.168.1.1', '256.256.256.256', false],
		];
	}
}
