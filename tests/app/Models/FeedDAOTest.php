<?php
declare(strict_types=1);

use FreshRss\Models\Feed;
use PHPUnit\Framework\TestCase;

final class FeedDAOTest extends TestCase {
	public static function test_ttl_min(): void {
		$feed = new Feed('https://example.net/', false);
		$feed->_ttl(-5);
		self::assertSame(-5, $feed->ttl(true));
		self::assertTrue($feed->mute());
	}
}
