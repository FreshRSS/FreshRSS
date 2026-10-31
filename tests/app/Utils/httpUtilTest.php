<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

/**
 * Tests for FreshRSS_http_Util
 */
final class httpUtilTest extends \PHPUnit\Framework\TestCase {

	#[DataProvider('provideUrlsIgnoringHttps')]
	public function test_compareUrlIgnoringHttps(string $url1, string $url2, bool $expected): void {
		self::assertEquals($expected, FreshRSS_http_Util::compareUrlIgnoringHttps($url1, $url2) === 0);
	}

	#[\Override]
	protected function tearDown(): void {
		FreshRSS_Context::initSystem(reload: true);	// Restore the default internal host allowlist
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

	#[DataProvider('providePrivateSubnets')]
	public function test_getCurlResolveInfoRejectsPrivateSubnets(string $ip): void {
		FreshRSS_Context::initSystem();
		$resolveOk = new ReflectionProperty(FreshRSS_http_Util::class, 'resolve_ok');
		$resolveOk->setValue(null, ['example.test' => [$ip]]);
		self::assertNull(FreshRSS_http_Util::getCurlResolveInfo('https://example.test/feed'));
	}

	/** @return array<string,array{string}> */
	public static function providePrivateSubnets(): array {
		return [
			// One example per range, ensuring FILTER_FLAG_GLOBAL_RANGE and custom checks are sufficient
			'127.0.0.0/8' => ['127.0.0.1'],	// RFC1700 (Loopback)
			'10.0.0.0/8' => ['10.0.0.5'],	// RFC1918
			'192.168.0.0/16' => ['192.168.1.5'],	// RFC1918
			'172.16.0.0/12' => ['172.16.5.5'],	// RFC1918
			'169.254.0.0/16' => ['169.254.5.5'],	// RFC3927
			'0.0.0.0/8' => ['0.0.0.5'],	// RFC5735
			'240.0.0.0/4' => ['240.0.0.5'],	// RFC1112
			'100.64.0.0/10' => ['100.64.5.5'],	// RFC6598 (Shared Address Space of Carrier-Grade NAT)
			'::1/128' => ['::1'],	// Loopback
			'fc00::/7' => ['fc00::5'],	// Unique Local Address
			'fe80::/10' => ['fe80::5'],	// Link Local Address
			'::ffff:0:0/96' => ['::ffff:10.0.0.5'],	// IPv4 translations
			'64:ff9b::/96' => ['64:ff9b::a9fe:a9fe'],	// RFC6052 (IPv4/IPv6 Translator, NAT64)
			'64:ff9b:1::/48' => ['64:ff9b:1::c000:4260'],	// RFC8215 (Local-Use IPv4/IPv6 Translation Prefix)
			'::/128' => ['::'],	// Unspecified address
		];
	}

	/** Socks schemes default to port 1080, and an IP address proxy produces no resolve entry */
	public function test_getCurlResolveInfoForProxyAddress(): void {
		FreshRSS_Context::initSystem();
		// A proxy on a private address is rejected by default
		self::assertNull(FreshRSS_http_Util::getCurlResolveInfo('socks5h://127.0.0.1:1080'));

		// Once the proxy is allowlisted, no resolve override is needed for an IP address
		FreshRSS_Context::systemConf()->internal_host_allowlist = ['127.0.0.1:1080'];
		self::assertSame([], FreshRSS_http_Util::getCurlResolveInfo('socks5h://127.0.0.1:1080'));

		// Other proxy ports need their own entry
		FreshRSS_Context::systemConf()->internal_host_allowlist = ['127.0.0.1:8080'];
		self::assertNull(FreshRSS_http_Util::getCurlResolveInfo('socks5h://127.0.0.1:1080'));
		self::assertSame([], FreshRSS_http_Util::getCurlResolveInfo('https://127.0.0.1:8080'));
	}

	/** For a hostname proxy, the resolved IP of the proxy is pinned with a resolve entry, to prevent DNS rebinding */
	public function test_getCurlResolveInfoForProxyHostname(): void {
		FreshRSS_Context::initSystem();
		$resolveOk = new ReflectionProperty(FreshRSS_http_Util::class, 'resolve_ok');
		$resolveOk->setValue(null, ['proxy.example.test' => ['198.51.100.7']]);
		FreshRSS_Context::systemConf()->internal_host_allowlist = ['198.51.100.7:1080'];

		self::assertSame(
			['proxy.example.test:1080:198.51.100.7'],
			FreshRSS_http_Util::getCurlResolveInfo('socks5h://proxy.example.test:1080')
		);

		// Applications must not emit resolve entries for an address that is not guaranteed public.
		// TEST-NET-2 is a reserved range, so without an allowlist entry, no entry is produced.
		FreshRSS_Context::systemConf()->internal_host_allowlist = [];
		self::assertNull(FreshRSS_http_Util::getCurlResolveInfo('socks5h://proxy.example.test:1080'));

		// A genuinely public address produces an entry without allowlisting
		$resolveOk->setValue(null, ['public-proxy.example.test' => ['8.8.8.8']]);
		self::assertSame(
			['public-proxy.example.test:1080:8.8.8.8'],
			FreshRSS_http_Util::getCurlResolveInfo('socks5h://public-proxy.example.test:1080')
		);

		// A proxy resolving to a private address is rejected unless allowlisted
		$resolveOk->setValue(null, ['proxy.example.test' => ['192.168.1.1']]);
		self::assertNull(FreshRSS_http_Util::getCurlResolveInfo('socks5h://proxy.example.test:1080'));
		FreshRSS_Context::systemConf()->internal_host_allowlist = ['192.168.1.1:1080'];
		self::assertSame(
			['proxy.example.test:1080:192.168.1.1'],
			FreshRSS_http_Util::getCurlResolveInfo('socks5h://proxy.example.test:1080')
		);
	}
}
