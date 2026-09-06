<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

final class EntryDAOSQLiteTest extends \PHPUnit\Framework\TestCase {
	private string $username;
	private ?string $previousUser;

	#[\Override]
	protected function setUp(): void {
		$this->previousUser = Minz_User::name();
		$this->username = 'test-' . bin2hex(random_bytes(8));
		mkdir(USERS_PATH . '/' . $this->username);
		Minz_User::change($this->username);
	}

	#[\Override]
	protected function tearDown(): void {
		Minz_User::change($this->previousUser ?? '');
		foreach (glob(USERS_PATH . '/' . $this->username . '/*') ?: [] as $file) {
			unlink($file);
		}
		rmdir(USERS_PATH . '/' . $this->username);
	}

	/** @return iterable<string,array{int,?string,int,list<int>}> */
	public static function provideMarkReadTag(): iterable {
		yield 'title search in one label' => [1, 'intitle:needle', 0, [1]];
		yield 'text search in one label' => [1, 'needle', 0, [1, 6]];
		yield 'content search in one label' => [1, 'intext:needle', 0, [6]];
		yield 'search in all labels' => [0, 'needle', 0, [1, 3, 6]];
		yield 'favourite state without search' => [1, null, FreshRSS_Entry::STATE_FAVORITE, [1]];
		yield 'search and unread state' => [1, 'needle', FreshRSS_Entry::STATE_NOT_READ, [1, 6]];
		yield 'no search or state filter' => [1, null, 0, [1, 2, 6]];
	}

	/** @param list<int> $changedIds */
	#[DataProvider('provideMarkReadTag')]
	public function testMarkReadTag(int $tag, ?string $search, int $state, array $changedIds): void {
		$pdo = new Minz_PdoSqlite('sqlite::memory:');
		$pdo->exec(<<<'SQL'
			CREATE TABLE entry (id INTEGER PRIMARY KEY, id_feed INTEGER, title TEXT, content TEXT,
				is_read INTEGER DEFAULT 0, is_favorite INTEGER DEFAULT 0, lastUserModified INTEGER DEFAULT 0);
			CREATE TABLE entrytag (id_tag INTEGER, id_entry INTEGER);
			CREATE TABLE feed (id INTEGER PRIMARY KEY, cache_nbUnreads INTEGER);
			INSERT INTO feed VALUES (1, 6);
			INSERT INTO entry (id, id_feed, title, content, is_read, is_favorite) VALUES
				(1, 1, 'needle', '', 0, 1),
				(2, 1, 'other', '', 0, 0),
				(3, 1, 'needle', '', 0, 0),
				(4, 1, 'needle', '', 0, 0),
				(5, 1, 'needle', '', 1, 1),
				(6, 1, 'body match', 'needle', 0, 0),
				(7, 1, 'needle', '', 0, 1);
			INSERT INTO entrytag VALUES (1, 1), (2, 1), (1, 2), (2, 3), (1, 5), (1, 6), (1, 7);
			SQL);
		$dao = new FreshRSS_EntryDAOSQLite(currentPdo: $pdo);
		$filters = $search === null ? null : new FreshRSS_BooleanSearch($search);

		// Keep other labels, unlabelled entries, and entries newer than the displayed page untouched.
		self::assertSame(count($changedIds), $dao->markReadTag($tag, '6', $filters, $state));
		$rows = $pdo->query('SELECT id, is_read, lastUserModified FROM entry ORDER BY id');
		self::assertNotFalse($rows);
		foreach ($rows->fetchAll(PDO::FETCH_ASSOC) as $row) {
			self::assertIsArray($row);
			self::assertIsInt($row['lastUserModified']);
			$changed = in_array($row['id'], $changedIds, true);
			self::assertSame($changed || $row['id'] === 5 ? 1 : 0, $row['is_read']);
			self::assertSame($changed, $row['lastUserModified'] > 0);
		}
		$cache = $pdo->query('SELECT cache_nbUnreads FROM feed WHERE id = 1');
		self::assertNotFalse($cache);
		self::assertSame(6 - count($changedIds), $cache->fetchColumn());
		self::assertSame(0, $dao->markReadTag($tag, '6', $filters, $state));
	}
}
