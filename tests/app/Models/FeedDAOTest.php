<?php
declare(strict_types=1);

final class FeedDAOTest extends \PHPUnit\Framework\TestCase {
	public static function test_ttl_min(): void {
		$feed = new FreshRSS_Feed('https://example.net/', false);
		$feed->_ttl(-5);
		self::assertSame(-5, $feed->ttl(true));
		self::assertTrue($feed->mute());
	}

	public static function test_muteFeedByCategory(): void {
		$pdo = new Minz_PdoSqlite('sqlite::memory:');
		$pdo->exec('CREATE TABLE feed (id INTEGER PRIMARY KEY, category INTEGER, ttl INTEGER)');
		// Category 2: default refresh interval, custom refresh interval, muted with custom refresh interval, muted with default refresh interval
		$pdo->exec('INSERT INTO feed (id, category, ttl) VALUES (1, 2, 0), (2, 2, 7200), (3, 2, -1800), (4, 2, -3600), (5, 3, 900)');
		$dao = new FreshRSS_FeedDAOSQLite(currentPdo: $pdo);
		$ttls = static function () use ($pdo): array {
			$stm = $pdo->query('SELECT id, ttl FROM feed ORDER BY id');
			self::assertNotFalse($stm);
			return $stm->fetchAll(PDO::FETCH_KEY_PAIR);
		};

		self::assertSame(2, $dao->muteFeedByCategory(2, true, 3600));
		self::assertSame([1 => -3600, 2 => -7200, 3 => -1800, 4 => -3600, 5 => 900], $ttls());

		self::assertSame(4, $dao->muteFeedByCategory(2, false, 3600));
		self::assertSame([1 => 0, 2 => 7200, 3 => 1800, 4 => 0, 5 => 900], $ttls());

		self::assertSame(0, $dao->muteFeedByCategory(2, false, 3600));
	}
}
