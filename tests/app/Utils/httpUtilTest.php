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

	#[DataProvider('provideCurlProxyValues')]
	public function test_sanitizeCurlParamsRejectsMalformedProxy(string $proxy, bool $shouldSurvive): void {
		$sanitized = FreshRSS_http_Util::sanitizeCurlParams([CURLOPT_PROXY => $proxy, CURLOPT_PROXYTYPE => CURLPROXY_HTTP]);
		if ($shouldSurvive) {
			self::assertSame($proxy, $sanitized[CURLOPT_PROXY] ?? null);
		} else {
			self::assertArrayNotHasKey(CURLOPT_PROXY, $sanitized);
		}
	}

	/** @return array<string,array{string,bool}> */
	public static function provideCurlProxyValues(): array {
		return [
			// A second `://` would otherwise be reduced by a greedy scheme-strip to this
			// trailing "decoy" host for the allowlist/DNS-pinning check, while cURL still
			// received the original, unstripped value as CURLOPT_PROXY.
			'rejects scheme-prefixed decoy host' => ['http://127.0.0.1:8080/://8.8.8.8', false],
			'rejects scheme-less decoy host' => ['127.0.0.1:8080/://198.51.100.10', false],
			// The scheme comes from CURLOPT_PROXYTYPE, not the value itself -- a scheme-containing
			// value is rejected outright rather than normalised.
			'rejects a value carrying its own scheme' => ['http://proxy.example.com:3128', false],
			// cURL treats "host:port/path" as a Unix domain socket for SOCKS proxies and ignores the
			// port, so an allowlisted host:port could otherwise be smuggled into connecting to an
			// arbitrary local socket.
			'rejects a SOCKS Unix-domain-socket path' => ['localhost:9050/path/to.sock', false],
			'accepts bare host:port' => ['127.0.0.1:8080', true],
			'accepts hostname:port' => ['proxy.example.com:3128', true],
			'accepts host:port with credentials' => ['user:pass@203.0.113.5:1080', true],
			'accepts an IPv6 proxy' => ['[::1]:8080', true],
		];
	}

	#[DataProvider('provideUrlsForCheckUrl')]
	public function test_checkUrl(string $url, string|false $expected): void {
		self::assertSame($expected, FreshRSS_http_Util::checkUrl($url));
	}

	/** @return Traversable<string,array{string,string|false}> */
	public static function provideUrlsForCheckUrl(): Traversable {
		yield 'plain' => ['https://example.net/feed?a=1&amp;b=2', 'https://example.net/feed?a=1&amp;b=2'];
		yield 'underscore' => ['https://ex_ample.net/', 'https://ex_ample.net/'];
		yield 'IPv6' => ['https://[2001:db8::1]/feed', 'https://[2001:db8::1]/feed'];
		if (function_exists('idn_to_ascii')) {
			yield 'IDN' => ['https://bücher.example/feed', 'https://xn--bcher-kva.example/feed'];
			yield 'IDN with ideographic full stop' => ['https://日本語。example/', 'https://xn--wgv71a119e.example/'];
		}
		// IDNA (UTS #46) maps fullwidth punctuation to ASCII: must not produce characters absent from the (possibly HTML-encoded) input
		yield 'fullwidth markup in host' => ['https://example.net／＂＞＜b＞', false];
		yield 'fullwidth path and query in host' => ['https://example.net／path？a＝1＆b＝2', false];
		yield 'fullwidth userinfo in host' => ['https://example.net＠example.org/', false];
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

	#[DataProvider('provideUtf8Html')]
	public function test_enforceHtmlBase_keepsUtf8InScripts(string $html): void {
		$enforceHtmlBase = new ReflectionMethod(FreshRSS_http_Util::class, 'enforceHtmlBase');
		$result = $enforceHtmlBase->invoke(null, $html, 'https://example.net/page');
		self::assertIsString($result);
		self::assertStringContainsString('<base href="https://example.net/page">', $result);
		self::assertStringContainsString('<script type="application/json">{"title":"Café’s menu — 日本"}</script>', $result);
		if (str_starts_with($html, "\xEF\xBB\xBF")) {
			self::assertStringStartsWith("\xEF\xBB\xBF", $result);
		}
	}

	/** @return Traversable<string,array{string}> */
	public static function provideUtf8Html(): Traversable {
		$head = '<html><head><title>T</title></head>';
		$body = '<body><p>Café’s menu — 日本</p><script type="application/json">{"title":"Café’s menu — 日本"}</script></body></html>';
		yield 'meta charset' => ['<!DOCTYPE html><html><head><meta charset="utf-8"><title>T</title></head>' . $body];
		yield 'byte order mark' => ["\xEF\xBB\xBF" . '<!DOCTYPE html>' . $head . $body];
		yield 'byte order mark, late <html>' => ["\xEF\xBB\xBF" . '<!DOCTYPE html>' . str_repeat('<!-- padding -->', 40) . $head . $body];
		yield 'meta http-equiv' => ['<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>T</title></head>' . $body];
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
			'0.0.0.0/8' => ['0.0.0.5'],	// RFC5735
			'3fff::/20' => ['3fff::1'],	// RFC9637 (Documentation)
			'5f00::/16' => ['5f00::1'],	// RFC9602 (SRv6 SIDs)
			'10.0.0.0/8' => ['10.0.0.5'],	// RFC1918
			'64:ff9b:1::/48' => ['64:ff9b:1::c000:4260'],	// RFC8215 (Local-Use IPv4/IPv6 Translation Prefix)
			'64:ff9b::/96' => ['64:ff9b::a9fe:a9fe'],	// RFC6052 (IPv4/IPv6 Translator, NAT64)
			'64:ff9b::/96 embedded 6to4 anycast' => ['64:ff9b::c058:6301'],
			'64:ff9b::/96 embedded multicast' => ['64:ff9b::e000:1'],
			'64:ff9b::/96 embedded wire server' => ['64:ff9b::a83f:8110'],
			'100.64.0.0/10' => ['100.64.5.5'],	// RFC6598 (Shared Address Space of Carrier-Grade NAT)
			'100:0:0:1::/64' => ['100:0:0:1::1'],	// RFC9780 (Dummy IPv6 Prefix)
			'127.0.0.0/8' => ['127.0.0.1'],	// RFC1700 (Loopback)
			'168.63.129.16/32' => ['168.63.129.16'],	// Azure wire server
			'169.254.0.0/16' => ['169.254.5.5'],	// RFC3927
			'172.16.0.0/12' => ['172.16.5.5'],	// RFC1918
			'192.0.0.0/24' => ['192.0.0.170'],	// RFC6890 (IETF Protocol Assignments)
			'192.0.2.0/24' => ['192.0.2.1'],	// RFC5737 (TEST-NET-1)
			'192.88.99.0/24' => ['192.88.99.1'],	// RFC7526 (deprecated 6to4 anycast)
			'192.88.99.2/32' => ['192.88.99.2'],	// RFC6751 (6a44-relay anycast)
			'192.168.0.0/16' => ['192.168.1.5'],	// RFC1918
			'198.18.0.0/15' => ['198.18.0.1'],	// RFC2544 (Benchmarking)
			'198.18.0.0/15 upper' => ['198.19.255.255'],
			'198.51.100.0/24' => ['198.51.100.1'],	// RFC5737 (TEST-NET-2)
			'203.0.113.0/24' => ['203.0.113.1'],	// RFC5737 (TEST-NET-3)
			'224.0.0.0/4' => ['224.0.0.1'],	// RFC1112 (IPv4 multicast)
			'224.0.0.0/4 upper' => ['239.255.255.255'],
			'240.0.0.0/4' => ['240.0.0.5'],	// RFC1112
			'2001::/32' => ['2001::1'],	// RFC4380 (Teredo)
			'2002::/16' => ['2002::1'],	// RFC3056 (6to4)
			'2002::/16 upper' => ['2002:ffff:ffff:ffff:ffff:ffff:ffff:ffff'],
			'::/128' => ['::'],	// Unspecified address
			'::1/128' => ['::1'],	// Loopback
			'::ffff:0:0/96' => ['::ffff:10.0.0.5'],	// IPv4 translations
			'fc00::/7' => ['fc00::5'],	// Unique Local Address
			'fe80::/10' => ['fe80::5'],	// Link Local Address
			'fec0::/10' => ['fec0::1'],	// RFC3879 (deprecated site-local)
			'fec0::/10 upper' => ['feff::1'],
			'ff00::/8' => ['ff02::1'],	// RFC4291 (IPv6 multicast)
		];
	}

	#[DataProvider('providePublicAddresses')]
	public function test_getCurlResolveInfoAcceptsPublicAddresses(string $ip): void {
		FreshRSS_Context::initSystem();
		$url = str_contains($ip, ':') ? "https://[$ip]/feed" : "https://$ip/feed";
		self::assertSame([], FreshRSS_http_Util::getCurlResolveInfo($url));
	}

	/** @return array<string,array{string}> */
	public static function providePublicAddresses(): array {
		return [
			'public IPv4 alternate' => ['1.1.1.1'],
			'public IPv4' => ['8.8.8.8'],
			'below Azure wire server' => ['168.63.129.15'],
			'above Azure wire server' => ['168.63.129.17'],
			'below deprecated 6to4 anycast' => ['192.88.98.1'],
			'above deprecated 6to4 anycast' => ['192.88.100.1'],
			'below IPv4 multicast' => ['223.255.255.255'],
			'public IPv6' => ['2001:4860:4860::8888'],
			'outside 6to4' => ['2003::1'],
			'outside documentation prefix' => ['3fff:1000::1'],
			'outside SRv6 prefix' => ['5f01::1'],
			'outside dummy IPv6 prefix' => ['100:0:0:2::1'],
			'public NAT64' => ['64:ff9b::c000:4260'],	// RFC6052 embedding 192.0.66.96
		];
	}

	/** cURL would rewrite these hosts, and contact another name or address than the one checked and pinned */
	#[DataProvider('provideHostsRewrittenByCurl')]
	public function test_getCurlResolveInfoRejectsHostsRewrittenByCurl(string $host): void {
		FreshRSS_Context::initSystem();
		$resolveOk = new ReflectionProperty(FreshRSS_http_Util::class, 'resolve_ok');
		$resolveOk->setValue(null, [strtolower($host) => ['192.0.66.96']]);
		self::assertFalse(FreshRSS_http_Util::getCurlResolveInfo("http://$host/feed"));
		self::assertFalse(FreshRSS_http_Util::getCurlResolveInfo("socks5h://$host:1080"));
	}

	/** @return array<string,array{string}> */
	public static function provideHostsRewrittenByCurl(): array {
		return [
			'percent-encoded underscore' => ['a%5F.example.test'],	// cURL resolves a_.example.test
			'percent-encoded UTF-8' => ['%C3%A9.example.test'],	// cURL resolves xn--9ca.example.test
			'non-ASCII' => ['é.example.test'],	// cURL resolves xn--9ca.example.test
			'IPv4 as one number' => ['2130706433'],	// cURL connects to 127.0.0.1
			'IPv4 as hexadecimal' => ['0x7f.1'],	// cURL connects to 127.0.0.1
			'IPv4 as octal' => ['0177.0.0.1'],	// cURL connects to 127.0.0.1
			'IPv4 with fewer parts' => ['127.1'],	// cURL connects to 127.0.0.1
		];
	}

	/** Ordinary host names are still resolved and pinned as written */
	public function test_getCurlResolveInfoAcceptsHostsUsedAsWrittenByCurl(): void {
		FreshRSS_Context::initSystem();
		$resolveOk = new ReflectionProperty(FreshRSS_http_Util::class, 'resolve_ok');
		foreach (['a_b-c.example.test', 'xn--9ca.example.test', '1.example.test', 'example.7z', 'example.test.'] as $host) {
			$resolveOk->setValue(null, [$host => ['192.0.66.96']]);
			self::assertSame(["$host:80:192.0.66.96"], FreshRSS_http_Util::getCurlResolveInfo("http://$host/feed"));
		}
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
