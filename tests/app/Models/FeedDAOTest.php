<?php
declare(strict_types=1);

class FeedDAOTest extends PHPUnit\Framework\TestCase {
	public function test_ttl_min(): void {
		$feed = new FreshRSS_Feed('https://example.net/', false);
		$feed->_ttl(-5);
		self::assertEquals(-5, $feed->ttl(true));
		self::assertEquals(true, $feed->mute());
	}
}
