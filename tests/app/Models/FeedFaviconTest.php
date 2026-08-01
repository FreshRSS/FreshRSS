<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

/**
 * Tests for favicon proxy persistence in Feed::faviconPrepare() and Feed::faviconDelete()
 * Covers the fix for issue #8976: favicons were not fetched using the per-feed proxy.
 */
final class FeedFaviconTest extends \PHPUnit\Framework\TestCase {
	private string $tmpDir = '';

	protected function setUp(): void {
		// Create a temporary directory to act as FAVICONS_DIR for tests that write files directly
		$this->tmpDir = sys_get_temp_dir() . '/freshrss_favicon_test_' . uniqid();
		mkdir($this->tmpDir, 0777, true);

		// Point the FAVICONS_DIR constant to our temp dir by patching the data path
		// We test the proxy file logic via the actual DATA_PATH/favicons directory
		if (!is_dir(DATA_PATH . '/favicons')) {
			mkdir(DATA_PATH . '/favicons', 0777, true);
		}

		// Ensure a minimal system conf is available (needed by hashFavicon -> salt)
		if (!FreshRSS_Context::hasSystemConf()) {
			FreshRSS_Context::$system_conf = FreshRSS_SystemConfiguration::init(
				FRESHRSS_PATH . '/config.default.php',
				FRESHRSS_PATH . '/config.default.php'
			);
		}
	}

	protected function tearDown(): void {
		// Clean up temp dir
		foreach (glob($this->tmpDir . '/*') ?: [] as $file) {
			@unlink($file);
		}
		@rmdir($this->tmpDir);
	}

	// -------------------------------------------------------------------------
	// faviconPrepare: .proxy file management
	// -------------------------------------------------------------------------

	public function test_faviconPrepare_withProxy_writesProxyFile(): void {
		$feed = new FreshRSS_Feed('https://example.net/feed', false);
		$feed->_website('https://example.net/');
		$feed->_attribute('curl_params', [CURLOPT_PROXY => 'http://proxy.example.com:3128']);

		$feed->faviconPrepare();

		$proxyFile = FAVICONS_DIR . $feed->hashFavicon() . '.proxy';
		self::assertFileExists($proxyFile, '.proxy file should be created when curl_params has a proxy');

		$decoded = json_decode((string) file_get_contents($proxyFile), true);
		self::assertIsArray($decoded);
		self::assertArrayHasKey(CURLOPT_PROXY, $decoded);
		self::assertSame('http://proxy.example.com:3128', $decoded[CURLOPT_PROXY]);

		// Cleanup
		@unlink($proxyFile);
		@unlink(FAVICONS_DIR . $feed->hashFavicon() . '.txt');
	}

	public function test_faviconPrepare_withoutProxy_doesNotWriteProxyFile(): void {
		$feed = new FreshRSS_Feed('https://no-proxy.example.net/feed', false);
		$feed->_website('https://no-proxy.example.net/');

		$feed->faviconPrepare();

		$proxyFile = FAVICONS_DIR . $feed->hashFavicon() . '.proxy';
		self::assertFileDoesNotExist($proxyFile, '.proxy file should NOT be created when no curl_params');

		// Cleanup
		@unlink(FAVICONS_DIR . $feed->hashFavicon() . '.txt');
	}

	public function test_faviconPrepare_removesStaleProxyFile_whenProxyCleared(): void {
		$feed = new FreshRSS_Feed('https://stale-proxy.example.net/feed', false);
		$feed->_website('https://stale-proxy.example.net/');
		$feed->_attribute('curl_params', [CURLOPT_PROXY => 'http://old-proxy.example.com:3128']);

		// First prepare — creates .proxy
		$feed->faviconPrepare();
		$hash = $feed->hashFavicon();
		$proxyFile = FAVICONS_DIR . $hash . '.proxy';
		self::assertFileExists($proxyFile);

		// Remove proxy from feed attributes — hash will change because proxyParam() changes
		// so we test stale removal by manually placing a .proxy and then calling with empty curl_params
		$feedNoProxy = new FreshRSS_Feed('https://stale-proxy2.example.net/feed', false);
		$feedNoProxy->_website('https://stale-proxy2.example.net/');
		// Pre-plant a stale .proxy file at the hash location for this no-proxy feed
		$staleProxyFile = FAVICONS_DIR . $feedNoProxy->hashFavicon() . '.proxy';
		file_put_contents($staleProxyFile, '{"' . CURLOPT_PROXY . '":"http://old.com:80"}');

		$feedNoProxy->faviconPrepare();

		self::assertFileDoesNotExist($staleProxyFile, 'Stale .proxy file should be removed when feed has no proxy');

		// Cleanup
		@unlink($proxyFile);
		@unlink(FAVICONS_DIR . $hash . '.txt');
		@unlink(FAVICONS_DIR . $feedNoProxy->hashFavicon() . '.txt');
	}

	// -------------------------------------------------------------------------
	// faviconDelete: cleans up .proxy alongside .ico and .txt
	// -------------------------------------------------------------------------

	public function test_faviconDelete_removesProxyFile(): void {
		// Plant fake files
		$hash = str_pad('abcdef01', 8, '0');
		$base = DATA_PATH . '/favicons/' . $hash;
		file_put_contents($base . '.ico', 'fake');
		file_put_contents($base . '.txt', 'https://example.net/');
		file_put_contents($base . '.proxy', '{}');

		FreshRSS_Feed::faviconDelete($hash);

		self::assertFileDoesNotExist($base . '.ico');
		self::assertFileDoesNotExist($base . '.txt');
		self::assertFileDoesNotExist($base . '.proxy');
	}

	public function test_faviconDelete_invalidHash_doesNothing(): void {
		// Should not throw or error on invalid hash
		FreshRSS_Feed::faviconDelete('../../../etc/passwd');
		FreshRSS_Feed::faviconDelete('');
		self::assertTrue(true); // just verifying no exception
	}

	// -------------------------------------------------------------------------
	// favicons.php functions accept $curl_params parameter
	// -------------------------------------------------------------------------

	public function test_download_favicon_from_image_url_acceptsCurlParams(): void {
		require_once LIB_PATH . '/favicons.php';

		// Function must accept $curl_params without error
		// We pass an invalid URL so it returns false without making HTTP calls
		$result = download_favicon_from_image_url('not-a-valid-url', $this->tmpDir . '/test.ico', [CURLOPT_PROXY => 'http://proxy:3128']);
		self::assertFalse($result, 'Should return false for invalid URL');
	}

	public function test_download_favicon_acceptsCurlParams(): void {
		require_once LIB_PATH . '/favicons.php';

		$dest = $this->tmpDir . '/favicon_proxy_test.ico';
		// Pass an empty string URL — should copy default favicon and return true (or false if DEFAULT_FAVICON not readable)
		// Either way, the function must not throw on receiving $curl_params
		try {
			download_favicon('', $dest, [CURLOPT_PROXY => 'http://proxy:3128']);
			self::assertTrue(true);
		} catch (\Throwable $e) {
			self::fail('download_favicon() should accept $curl_params without throwing: ' . $e->getMessage());
		}
	}

	public function test_searchFavicon_acceptsCurlParams(): void {
		require_once LIB_PATH . '/favicons.php';

		// Empty URL returns '' immediately, so this just verifies the signature
		$result = searchFavicon('', [CURLOPT_PROXY => 'http://proxy:3128']);
		self::assertSame('', $result);
	}

	// -------------------------------------------------------------------------
	// p/f.php proxy loading logic (unit test for the JSON decode pattern)
	// -------------------------------------------------------------------------

	public function test_proxyFileJson_roundtrip(): void {
		// Verify that the JSON written by faviconPrepare can be read back and sanitized
		$curl_params = FreshRSS_http_Util::sanitizeCurlParams([CURLOPT_PROXY => 'http://proxy.test:8080']);

		$proxyFile = $this->tmpDir . '/roundtrip.proxy';
		$encoded = json_encode($curl_params, JSON_UNESCAPED_SLASHES);
		self::assertIsString($encoded);
		file_put_contents($proxyFile, $encoded);

		// Simulate what p/f.php does
		$proxy_raw = file_get_contents($proxyFile);
		self::assertIsString($proxy_raw);
		$decoded = json_decode($proxy_raw, true);
		self::assertIsArray($decoded);
		$restored = FreshRSS_http_Util::sanitizeCurlParams($decoded);

		self::assertArrayHasKey(CURLOPT_PROXY, $restored);
		self::assertSame('http://proxy.test:8080', $restored[CURLOPT_PROXY]);
	}

	public function test_proxyFileJson_emptyFile_yieldsEmptyArray(): void {
		$proxy_raw = '';
		$curl_params = [];
		if (is_string($proxy_raw) && $proxy_raw !== '') {
			$decoded = json_decode($proxy_raw, true);
			if (is_array($decoded)) {
				$curl_params = FreshRSS_http_Util::sanitizeCurlParams($decoded);
			}
		}
		self::assertSame([], $curl_params);
	}
}
