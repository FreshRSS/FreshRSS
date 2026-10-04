<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

final class FeedTest extends \PHPUnit\Framework\TestCase {

	#[DataProvider('provideStoredAndRequestedUrls')]
	public function test_load_obeysRetryAfter(string $storedUrl, string $requestedUrl): void {
		$getRetryAfterFile = new ReflectionMethod(FreshRSS_http_Util::class, 'getRetryAfterFile');
		$file = $getRetryAfterFile->invoke(null, $requestedUrl, '');
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

	/** @return array<string,array{string,string}> */
	public static function provideStoredAndRequestedUrls(): array {
		// On a local network, where Retry-After is per URL
		return [
			'HTML-encoded' => ['http://192.168.1.2/?action=display&amp;bridge=Example', 'http://192.168.1.2/?action=display&bridge=Example'],
			'force_feed' => ['http://192.168.1.2/feed#force_feed', 'http://192.168.1.2/feed'],
		];
	}
}
