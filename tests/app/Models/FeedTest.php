<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

final class FeedTest extends \PHPUnit\Framework\TestCase {

	#[\Override]
	protected function setUp(): void {
		FreshRSS_Context::initSystem(reload: true);
	}

	#[\Override]
	protected function tearDown(): void {
		FreshRSS_Context::initSystem(reload: true);	// Restore the default curl_options
	}

	#[DataProvider('provideStoredAndRequestedUrls')]
	public function test_load_obeysRetryAfter(string $storedUrl, string $requestedUrl, string $systemProxy = ''): void {
		if ($systemProxy !== '') {
			FreshRSS_Context::systemConf()->_attribute('curl_options', [CURLOPT_PROXY => $systemProxy]);
		}
		$getRetryAfterFile = new ReflectionMethod(FreshRSS_http_Util::class, 'getRetryAfterFile');
		$file = $getRetryAfterFile->invoke(null, $requestedUrl, $systemProxy);
		self::assertIsString($file);
		self::assertTrue(touch($file, time() + 600));
		try {
			(new FreshRSS_Feed($storedUrl, validate: false))->load();
			self::fail('The feed was loaded during its Retry-After');
		} catch (FreshRSS_Feed_Exception $e) {
			self::assertStringContainsString('will first retry after', $e->getMessage());
		} finally {
			unlink($file);
		}
	}

	/** @return array<string,array{0:string,1:string,2?:string}> */
	public static function provideStoredAndRequestedUrls(): array {
		// On a local network, where Retry-After is per URL
		return [
			'HTML-encoded' => ['http://192.168.1.2/?action=display&amp;bridge=Example', 'http://192.168.1.2/?action=display&bridge=Example'],
			'force_feed' => ['http://192.168.1.2/feed#force_feed', 'http://192.168.1.2/feed'],
			'system proxy' => ['http://192.168.1.2/feed', 'http://192.168.1.2/feed', 'proxy.example.test:3128'],
		];
	}

	public function test_hashFavicon_isKeyedBySalt(): void {
		FreshRSS_Context::initSystem();
		$salt = FreshRSS_Context::systemConf()->salt;

		$feed = new FreshRSS_Feed('http://example.net/feed.xml', validate: false);
		$feed->_website('https://example.com/', validate: false);

		// Keyed hash (MAC), not an unkeyed checksum: users must not be able to compute
		// the favicon cache key of other users' feeds without the secret salt.
		$hash = $feed->hashFavicon();
		self::assertMatchesRegularExpression('/^[0-9a-f]{16}$/', $hash);
		self::assertSame(substr(hash_hmac('sha256', 'https://example.com/' . $feed->proxyParam(), $salt), 0, 16), $hash);

		$feed->_website('https://example.org/', validate: false);
		self::assertNotSame($hash, $feed->hashFavicon());
	}
}
