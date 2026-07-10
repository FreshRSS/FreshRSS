<?php
declare(strict_types=1);

/**
 * Tests for the duplicate-feed detection used by FreshRSS_feed_Controller::addAction()
 * before showing the user a confirmation warning (issue #7648).
 */
final class feedControllerTest extends \PHPUnit\Framework\TestCase {

	/**
	 * FreshRSS_feed_Controller::findLikelyDuplicateFeed() is private static; it has no
	 * dependency on the database, session, or request, so it can be exercised directly
	 * through reflection without bootstrapping a full controller/HTTP request.
	 *
	 * @param array<int,FreshRSS_Feed> $feeds
	 */
	private static function findLikelyDuplicateFeed(string $url, array $feeds): ?FreshRSS_Feed {
		$method = new ReflectionMethod(FreshRSS_feed_Controller::class, 'findLikelyDuplicateFeed');
		$method->setAccessible(true);
		/** @var FreshRSS_Feed|null */
		return $method->invoke(null, $url, $feeds);
	}

	public function test_findLikelyDuplicateFeed_whenNearDuplicateUrl_returnsExistingFeed(): void {
		$existing = new FreshRSS_Feed('https://example.net/feed', false);

		$duplicate = self::findLikelyDuplicateFeed('https://Example.net/feed/', [$existing]);

		self::assertSame($existing, $duplicate);
	}

	public function test_findLikelyDuplicateFeed_whenByteIdenticalUrl_returnsNull(): void {
		// A byte-identical URL is already handled by addFeed()'s own FreshRSS_AlreadySubscribed_Exception
		// with a clearer, single-step error, so it must not also trigger the softer "looks similar" warning.
		$existing = new FreshRSS_Feed('https://example.net/feed', false);

		$duplicate = self::findLikelyDuplicateFeed('https://example.net/feed', [$existing]);

		self::assertNull($duplicate);
	}

	public function test_findLikelyDuplicateFeed_whenNoMatch_returnsNull(): void {
		$existing = new FreshRSS_Feed('https://example.net/feed', false);

		$duplicate = self::findLikelyDuplicateFeed('https://example.net/other-feed', [$existing]);

		self::assertNull($duplicate);
	}

	/**
	 * Reproduces issue #7648's regression scenario: an exact-match feed and a near-duplicate
	 * feed both already exist (e.g. the near-duplicate was deliberately kept side-by-side after
	 * a prior confirmation). Resubmitting the byte-identical URL must short-circuit to null so
	 * addFeed()'s clean "already subscribed" error fires for the exact match, instead of
	 * continuing the scan and surfacing the unrelated near-duplicate as a "looks similar" warning.
	 */
	public function test_findLikelyDuplicateFeed_whenByteIdenticalMatchAlongsideNearDuplicate_returnsNullRegardlessOfOrder(): void {
		$exactMatch = new FreshRSS_Feed('https://example.net/feed', false);
		$nearDuplicate = new FreshRSS_Feed('https://example.net/feed/', false);

		// Exact match encountered before the near-duplicate in the scan.
		self::assertNull(self::findLikelyDuplicateFeed('https://example.net/feed', [$exactMatch, $nearDuplicate]));

		// Exact match encountered after the near-duplicate in the scan: must still short-circuit
		// to null rather than returning the near-duplicate found earlier in the loop.
		self::assertNull(self::findLikelyDuplicateFeed('https://example.net/feed', [$nearDuplicate, $exactMatch]));
	}
}
