<?php
declare(strict_types=1);

final class FeedDAOTest extends \PHPUnit\Framework\TestCase {
	public static function test_ttl_min(): void {
		$feed = new FreshRSS_Feed('https://example.net/', false);
		$feed->_ttl(-5);
		self::assertSame(-5, $feed->ttl(true));
		self::assertTrue($feed->mute());
	}
}
