<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

final class EntryDAOTest extends \PHPUnit\Framework\TestCase {
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

	/** @return iterable<string,array{int,?string,int,list<int>,bool}> */
	public static function provideMarkReadTag(): iterable {
		yield 'title search in one label' => [1, 'intitle:needle', 0, [1], true];
		yield 'text search in one label' => [1, 'needle', 0, [1, 6], true];
		yield 'content search in one label' => [1, 'intext:needle', 0, [6], true];
		yield 'search in all labels' => [0, 'needle', 0, [1, 3, 6], true];
		yield 'favourite state without search' => [1, null, FreshRSS_Entry::STATE_FAVORITE, [1], true];
		yield 'search and unread state' => [1, 'needle', FreshRSS_Entry::STATE_NOT_READ, [1, 6], true];
		yield 'no search or state filter' => [1, null, 0, [1, 2, 6], true];
		yield 'mark matching read entries unread' => [1, 'needle', FreshRSS_Entry::STATE_READ, [1, 6], false];
	}

	/** @param list<int> $changedIds */
	#[DataProvider('provideMarkReadTag')]
	public function testMarkReadTag(int $tag, ?string $search, int $state, array $changedIds, bool $isRead): void {
		$dsn = getenv('FRESHRSS_TEST_DSN') ?: 'sqlite::memory:';
		$username = getenv('FRESHRSS_TEST_USER') ?: null;
		$password = getenv('FRESHRSS_TEST_PASSWORD') ?: null;
		$pdo = match (explode(':', $dsn, 2)[0]) {
			'sqlite' => new Minz_PdoSqlite($dsn),
			'pgsql' => new Minz_PdoPgsql($dsn, $username, $password),
			'mysql' => new Minz_PdoMysql($dsn, $username, $password),
			default => throw new InvalidArgumentException('Unsupported test database DSN'),
		};
		$pdo->setPrefix('test_');
		$dao = match ($pdo->dbType()) {
			'sqlite' => new FreshRSS_EntryDAOSQLite(currentPdo: $pdo),
			'pgsql' => new FreshRSS_EntryDAOPGSQL(currentPdo: $pdo),
			default => new FreshRSS_EntryDAO(currentPdo: $pdo),
		};
		// Temporary tables are private to this connection and are removed when it closes.
		$pdo->exec(<<<'SQL'
			CREATE TEMPORARY TABLE `_entry` (id BIGINT PRIMARY KEY, id_feed INTEGER, title TEXT, content TEXT,
				is_read SMALLINT DEFAULT 0, is_favorite SMALLINT DEFAULT 0, `lastUserModified` BIGINT DEFAULT 0)
			SQL);
		$pdo->exec('CREATE INDEX entry_feed_read_index ON `_entry` (id_feed, is_read)');
		$pdo->exec('CREATE TEMPORARY TABLE `_entrytag` (id_tag INTEGER, id_entry BIGINT)');
		$pdo->exec('CREATE TEMPORARY TABLE `_feed` (id INTEGER PRIMARY KEY, `cache_nbUnreads` INTEGER)');
		$pdo->exec('INSERT INTO `_feed` VALUES (1, 6)');
		$pdo->exec(<<<'SQL'
			INSERT INTO `_entry` (id, id_feed, title, content, is_read, is_favorite) VALUES
				(1, 1, 'needle', '', 0, 1),
				(2, 1, 'other', '', 0, 0),
				(3, 1, 'needle', '', 0, 0),
				(4, 1, 'needle', '', 0, 0),
				(5, 1, 'needle', '', 1, 1),
				(6, 1, 'body match', 'needle', 0, 0),
				(7, 1, 'needle', '', 0, 1)
			SQL);
		$pdo->exec('INSERT INTO `_entrytag` VALUES (1, 1), (2, 1), (1, 2), (2, 3), (1, 5), (1, 6), (1, 7)');
		if ($dao::isCompressed()) {
			$pdo->exec('ALTER TABLE `_entry` ADD content_bin MEDIUMBLOB');
			$pdo->exec('UPDATE `_entry` SET content_bin = COMPRESS(content)');
			$pdo->exec('ALTER TABLE `_entry` DROP COLUMN content');
		}
		if (!$isRead) {
			$pdo->exec('UPDATE `_entry` SET is_read = 1 - is_read');
			$pdo->exec('UPDATE `_feed` SET `cache_nbUnreads` = 1');
		}
		$filters = $search === null ? null : new FreshRSS_BooleanSearch($search);

		// Only change matching entries in the requested labels, up to the displayed page's maximum ID.
		self::assertSame(count($changedIds), $dao->markReadTag($tag, '6', $filters, $state, $isRead));
		$rows = $pdo->query('SELECT id, is_read, `lastUserModified` FROM `_entry` ORDER BY id');
		self::assertNotFalse($rows);
		foreach ($rows->fetchAll(PDO::FETCH_ASSOC) as $row) {
			self::assertIsArray($row);
			self::assertIsInt($row['lastUserModified']);
			$changed = in_array($row['id'], $changedIds, true);
			$expectedRead = $changed || $row['id'] === 5 ? $isRead : !$isRead;
			self::assertSame($expectedRead ? 1 : 0, $row['is_read']);
			self::assertSame($changed, $row['lastUserModified'] > 0);
		}
		$cache = $pdo->query('SELECT `cache_nbUnreads` FROM `_feed` WHERE id = 1');
		self::assertNotFalse($cache);
		self::assertSame($isRead ? 6 - count($changedIds) : 1 + count($changedIds), $cache->fetchColumn());
		$cache->closeCursor();
		self::assertSame(0, $dao->markReadTag($tag, '6', $filters, $state, $isRead));
	}
}
