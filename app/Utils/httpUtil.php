<?php
declare(strict_types=1);

final class FreshRSS_http_Util {

	private const RETRY_AFTER_PATH = DATA_PATH . '/Retry-After/';

	private static function getRetryAfterFile(string $url): string {
		$domain = parse_url($url, PHP_URL_HOST);
		if (!is_string($domain) || $domain === '') {
			return '';
		}
		$port = parse_url($url, PHP_URL_PORT);
		if (is_int($port)) {
			$domain .= ':' . $port;
		}
		return self::RETRY_AFTER_PATH . urlencode($domain) . '.txt';
	}

	/**
	 * Clean up old Retry-After files
	 */
	private static function cleanRetryAfters(): void {
		if (!is_dir(self::RETRY_AFTER_PATH)) {
			return;
		}
		$files = glob(self::RETRY_AFTER_PATH . '*.txt', GLOB_NOSORT);
		if ($files === false) {
			return;
		}
		foreach ($files as $file) {
			if (@filemtime($file) < time()) {
				@unlink($file);
			}
		}
	}

	/**
	 * Check whether the URL needs to wait for a Retry-After period.
	 * @return int The timestamp of when the Retry-After expires, or 0 if not set.
	 */
	public static function getRetryAfter(string $url): int {
		if (rand(0, 30) === 1) {	// Remove old files once in a while
			self::cleanRetryAfters();
		}
		$txt = self::getRetryAfterFile($url);
		if ($txt === '') {
			return 0;
		}
		$retryAfter = @filemtime($txt) ?: 0;
		if ($retryAfter <= 0) {
			return 0;
		}
		if ($retryAfter < time()) {
			@unlink($txt);
			return 0;
		}
		return $retryAfter;
	}

	/**
	 * Store the HTTP Retry-After header value of an HTTP `429 Too Many Requests` or `503 Service Unavailable` response.
	 */
	public static function setRetryAfter(string $url, string $retryAfter): int {
		$txt = self::getRetryAfterFile($url);
		if ($txt === '') {
			return 0;
		}

		$limits = FreshRSS_Context::systemConf()->limits;
		if (ctype_digit($retryAfter)) {
			$retryAfter = time() + (int)$retryAfter;
		} else {
			$retryAfter = \SimplePie\Misc::parse_date($retryAfter) ?:
				(time() + max(600, $limits['retry_after_default'] ?? 0));
		}
		$retryAfter = min($retryAfter, time() + max(3600, $limits['retry_after_max'] ?? 0));

		@mkdir(self::RETRY_AFTER_PATH);
		if (!touch($txt, $retryAfter)) {
			Minz_Log::error('Failed to set Retry-After for ' . $url);
			return 0;
		}
		return $retryAfter;
	}
}
