<?php
declare(strict_types=1);

final class httpUtilTest extends \PHPUnit\Framework\TestCase {

	public function testForceHttpsRewritesListedDomain(): void {
		// `github.com` is in `force-https.default.txt`
		self::assertSame(
			'https://github.com/foo',
			FreshRSS_http_Util::forceHttps('http://github.com/foo')
		);
	}

	public function testForceHttpsRewritesSubdomainOfListedDomain(): void {
		// `wikipedia.org` is in the default list -> any subdomain matches
		self::assertSame(
			'https://en.wikipedia.org/wiki/Test',
			FreshRSS_http_Util::forceHttps('http://en.wikipedia.org/wiki/Test')
		);
	}

	public function testForceHttpsLeavesUnlistedDomainUntouched(): void {
		self::assertSame(
			'http://example.invalid/foo',
			FreshRSS_http_Util::forceHttps('http://example.invalid/foo')
		);
	}

	public function testForceHttpsLeavesAlreadyHttpsUrlUntouched(): void {
		self::assertSame(
			'https://github.com/foo',
			FreshRSS_http_Util::forceHttps('https://github.com/foo')
		);
	}

	public function testForceHttpsLeavesNonHttpSchemeUntouched(): void {
		self::assertSame(
			'ftp://github.com/foo',
			FreshRSS_http_Util::forceHttps('ftp://github.com/foo')
		);
	}

	public function testForceHttpsNormalisesUppercaseHost(): void {
		// RFC 3986 §3.2.2: host is case-insensitive. The match must
		// succeed regardless of how the URL was capitalised upstream.
		self::assertSame(
			'https://github.com/Foo/Bar',
			FreshRSS_http_Util::forceHttps('http://GitHub.com/Foo/Bar')
		);
		// Path/query case must be preserved.
		self::assertSame(
			'https://www.youtube.com/watch?v=AbC123',
			FreshRSS_http_Util::forceHttps('http://WWW.YouTube.com/watch?v=AbC123')
		);
	}

	public function testForceHttpsHandlesUrlWithCredentials(): void {
		self::assertSame(
			'https://user:pw@github.com/x',
			FreshRSS_http_Util::forceHttps('http://user:pw@github.com/x')
		);
	}

	/**
	 * Regression for the cache-poisoning symptom in
	 * https://github.com/FreshRSS/FreshRSS/discussions/7252
	 * Callers in lib/favicons.php now derive sha1 cache keys from the
	 * rewritten URL, so an existing http-keyed cache entry no longer shadows
	 * a successful https fetch.
	 */
	public function testCacheKeyDerivedFromRewrittenUrlBypassesPoisonedHttpEntry(): void {
		$httpUrl = 'http://github.com/freshrss-test-cache-bypass';
		$rewritten = FreshRSS_http_Util::forceHttps($httpUrl);
		self::assertSame('https://github.com/freshrss-test-cache-bypass', $rewritten);

		$poisonedKey = sha1($httpUrl);
		$rewrittenKey = sha1($rewritten);
		self::assertNotSame($poisonedKey, $rewrittenKey,
			'sha1 of the rewritten URL must differ from sha1 of the original http URL');
	}

	public function testLoadForceHttpsDomainsContainsExpectedDefaults(): void {
		$domains = FreshRSS_http_Util::loadForceHttpsDomains();
		self::assertContains('github.com', $domains);
		self::assertContains('wikipedia.org', $domains);
		// Comments and blank lines must not appear as entries
		self::assertNotContains('', $domains);
		// All entries must be lower-case (RFC 3986 §3.2.2)
		foreach ($domains as $d) {
			self::assertSame(strtolower($d), $d, "Domain entry must be lower-cased: {$d}");
			self::assertDoesNotMatchRegularExpression('/[#;\\s]/', $d);
		}
	}

	public function testLoadForceHttpsDomainsRereadsOnEveryCall(): void {
		// No static cache: an admin edit to data/force-https.txt must take
		// effect immediately, including mid-run for long CLI processes.
		$override = DATA_PATH . '/force-https.txt';
		self::assertFileDoesNotExist($override, 'precondition: no override file present');
		self::assertNotContains('unique-test-domain.example', FreshRSS_http_Util::loadForceHttpsDomains());

		try {
			file_put_contents($override, "unique-test-domain.example\n");
			self::assertContains('unique-test-domain.example', FreshRSS_http_Util::loadForceHttpsDomains(),
				'override must be visible on the next call');
			self::assertSame(
				'https://unique-test-domain.example/x',
				FreshRSS_http_Util::forceHttps('http://unique-test-domain.example/x')
			);
		} finally {
			@unlink($override);
		}

		self::assertNotContains('unique-test-domain.example', FreshRSS_http_Util::loadForceHttpsDomains(),
			'removing the override must also be picked up immediately');
	}

	public function testIsForceHttpsHostWhenContextNotInitialised(): void {
		// Outside a request (e.g. early bootstrap) the system config is
		// not loaded; the helper must fail closed and return false rather
		// than throw.
		self::assertFalse(FreshRSS_http_Util::isForceHttpsHost('http://github.com/x'));
	}
}
