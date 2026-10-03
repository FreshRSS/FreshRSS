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

	#[\Override]
	protected function tearDown(): void {
		$resolveOk = new ReflectionProperty(FreshRSS_http_Util::class, 'resolve_ok');
		$resolveOk->setValue(null, []);	// Restore the default empty cache
	}

	#[DataProvider('provideUrlsForRetryAfter')]
	public function test_getRetryAfterFile(string $url1, string $url2, bool $sameFile): void {
		$getRetryAfterFile = new ReflectionMethod(FreshRSS_http_Util::class, 'getRetryAfterFile');
		self::assertSame($sameFile, $getRetryAfterFile->invoke(null, $url1, '') === $getRetryAfterFile->invoke(null, $url2, ''));
	}

	/** @return array<string,array{string,string,bool}> */
	public static function provideUrlsForRetryAfter(): array {
		return [
			// A public server waits as a whole, per port
			'public server' => ['https://198.51.100.7/feed1', 'https://198.51.100.7/feed2?a=1&b=2', true],
			'public server, other port' => ['https://198.51.100.7/feed', 'https://198.51.100.7:8443/feed', false],
			// A server on a local network waits URL by URL
			'local IP address' => ['http://192.168.1.2/feed1', 'http://192.168.1.2/feed2', false],
			'local domain' => ['http://rss-bridge.lan/?bridge=A', 'http://rss-bridge.lan/?bridge=B', false],
			'local, same URL' => ['http://192.168.1.2/feed', 'http://192.168.1.2/feed', true],
		];
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

	public function test_getCurlResolveInfoAcceptsPublicNat64Address(): void {
		FreshRSS_Context::initSystem();
		$resolveOk = new ReflectionProperty(FreshRSS_http_Util::class, 'resolve_ok');
		$resolveOk->setValue(null, [
			'example.test' => [
				'192.0.66.96',
				'64:ff9b::c000:4260',
			],
		]);

		self::assertSame(
			['example.test:443:192.0.66.96,[64:ff9b::c000:4260]'],
			FreshRSS_http_Util::getCurlResolveInfo('https://example.test/feed')
		);
	}

	public function test_getCurlResolveInfoRejectsPrivateNat64Address(): void {
		FreshRSS_Context::initSystem();
		$resolveOk = new ReflectionProperty(FreshRSS_http_Util::class, 'resolve_ok');
		$resolveOk->setValue(null, [
			'example.test' => [
				'64:ff9b::a9fe:a9fe',
			],
		]);

		self::assertNull(
			FreshRSS_http_Util::getCurlResolveInfo('https://example.test/feed')
		);
	}
}
