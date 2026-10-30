<?php
declare(strict_types=1);

/**
 * Tests for the database-specific `INSERT ... ON DUPLICATE` variants used when tagging entries.
 */
final class TagDAOTest extends \PHPUnit\Framework\TestCase {
	private const SQL = 'INSERT INTO `_entrytag`(id_tag, id_entry) VALUES(:id_tag, :id_entry)';

	public function test_sqlIgnoreConflict_forMySQL(): void {
		self::assertSame(
			'INSERT IGNORE INTO `_entrytag`(id_tag, id_entry) VALUES(:id_tag, :id_entry)',
			FreshRSS_TagDAO::sqlIgnoreConflict(self::SQL),
		);
	}

	public function test_sqlIgnoreConflict_forSQLite(): void {
		self::assertSame(
			'INSERT OR IGNORE INTO `_entrytag`(id_tag, id_entry) VALUES(:id_tag, :id_entry)',
			FreshRSS_TagDAOSQLite::sqlIgnoreConflict(self::SQL),
		);
	}

	public function test_sqlIgnoreConflict_forPostgreSQL(): void {
		self::assertSame(
			'INSERT INTO `_entrytag`(id_tag, id_entry) VALUES(:id_tag, :id_entry) ON CONFLICT DO NOTHING',
			FreshRSS_TagDAOPGSQL::sqlIgnoreConflict(self::SQL),
		);
	}
}
