<?php
declare(strict_types=1);

final class FeedDAOTest extends \PHPUnit\Framework\TestCase {
	public static function test_ttl_min(): void {
		$feed = new FreshRSS_Feed('https://example.net/', false);
		$feed->_ttl(-5);
		self::assertSame(-5, $feed->ttl(true));
		self::assertTrue($feed->mute());
	}

	/**
	 * Sidebar ordering has to follow `ORDER BY name`, including when titles mix CJK and ASCII.
	 * @return list<string>
	 */
	private static function mixedScriptNames(): array {
		return [
			'5 中文标题示例',
			'5 English-Title-Example',
			'NHK',
			'朝日新聞',
			'Ábaco',
			'banana',
			'lll',
			'ZZZ',
			'feed10',
			'feed2',
		];
	}

	/** @param list<string> $names */
	private static function createNamedFeeds(Minz_PdoSqlite $pdo, array $names, int $category = 3): FreshRSS_FeedDAO {
		$pdo->exec('CREATE TABLE feed (id INTEGER PRIMARY KEY, name TEXT NOT NULL, category INTEGER, url TEXT)');
		$insert = $pdo->prepare('INSERT INTO feed (id, name, category, url) VALUES (?, ?, ?, ?)');
		self::assertNotFalse($insert);
		foreach ($names as $i => $name) {
			self::assertTrue($insert->execute([$i + 1, $name, $category, 'https://example.net/' . $i]));
		}
		return new FreshRSS_FeedDAO(null, $pdo);
	}

	/** @return list<string> */
	private static function sqlNames(Minz_PdoSqlite $pdo, int $category = 3): array {
		$statement = $pdo->query('SELECT name FROM feed WHERE category = ' . $category . ' ORDER BY name');
		self::assertNotFalse($statement);
		$names = $statement->fetchAll(PDO::FETCH_COLUMN);
		self::assertIsArray($names);
		/** @var list<string> $names */
		return $names;
	}

	public function test_listByCategory_ordersLikeSql(): void {
		$pdo = new Minz_PdoSqlite('sqlite::memory:');
		$dao = self::createNamedFeeds($pdo, self::mixedScriptNames());
		$actual = [];
		foreach ($dao->listByCategory(3) as $feed) {
			$actual[] = $feed->name();
		}
		self::assertSame(self::sqlNames($pdo), $actual);
	}
}
