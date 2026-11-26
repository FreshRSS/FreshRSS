<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

final class DatabaseDAOTest extends \PHPUnit\Framework\TestCase {
	public function test_tablesAreCorrect_withPostgreSQL(): void {
		$dsn = getenv('FRESHRSS_TEST_PGSQL_DSN');
		if ($dsn === false || $dsn === '') {
			self::markTestSkipped('FRESHRSS_TEST_PGSQL_DSN is not configured.');
		}

		// A gateway login need not match the PostgreSQL role that owns the tables:
		// the DAO relies on grants to the visible tables, not on its own ownership.
		$pdo = new Minz_PdoPgsql($dsn, null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
		$pdo->setPrefix('test_');
		$pdo->beginTransaction();
		try {
			$pdo->exec(<<<'SQL'
				CREATE ROLE freshrss_test_app NOLOGIN;
				CREATE SCHEMA freshrss_test_visible;
				CREATE SCHEMA freshrss_test_hidden;
				SET LOCAL search_path TO freshrss_test_visible;
				GRANT USAGE ON SCHEMA freshrss_test_visible, freshrss_test_hidden TO freshrss_test_app;
				SQL);
			$pdo->exec(<<<'SQL'
				CREATE TABLE test_category (id integer);
				CREATE TABLE test_feed (id integer);
				CREATE TABLE test_entry (id integer);
				CREATE TABLE test_entrytmp (id integer);
				CREATE TABLE test_tag (id integer);
				CREATE TABLE test_entrytag (id integer);
				CREATE TABLE another_users_feed (id integer);
				GRANT SELECT ON ALL TABLES IN SCHEMA freshrss_test_visible TO freshrss_test_app;
				SET LOCAL ROLE freshrss_test_app;
				SQL);
			$dao = new FreshRSS_DatabaseDAOPGSQL('test', $pdo);
			self::assertTrue($dao->tablesAreCorrect(), 'Visible tables may belong to another role.');

			$pdo->exec(<<<'SQL'
				RESET ROLE;
				ALTER TABLE test_feed SET SCHEMA freshrss_test_hidden;
				SET LOCAL ROLE freshrss_test_app;
				SQL);
			self::assertFalse($dao->tablesAreCorrect(), 'A table outside search_path must not hide a missing table.');

			$pdo->exec(<<<'SQL'
				RESET ROLE;
				CREATE VIEW test_feed AS SELECT * FROM freshrss_test_hidden.test_feed;
				SET LOCAL ROLE freshrss_test_app;
				SQL);
			self::assertFalse($dao->tablesAreCorrect(), 'A view must not count as a table.');
		} finally {
			$pdo->rollBack();
		}
	}

	/** @return list<array{string,string,bool,bool}> */
	public static function provideStrilikeCommon(): array {
		return [
			['abc', 'abc', false, true],
			['AbC', 'aBc', false, true],
			['zabc', 'abc', false, false],
			['abcd', 'abc', false, false],
			['aéc', 'ac', false, false],
			['abcd', 'bc', true, true],
			['abcd', 'BC', true, true],
			['aßc', 'ß', true, true],
			['aéc', 'é', true, true],
			['Été', 'Ét', true, true],
			['aßc', 'ac', true, false],
			['ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz', false, true],
			['abcdefghijklmnopqrstuvwxyz', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', true, true],
		];
	}

	/** @return list<array{string,string,bool,bool}> */
	public static function provideStrilikeAccents(): array {
		return [
			['café', 'cafè', false, false],
			['Été', 'Eté', false, false],
			['Été', 'Et', true, false],
		];
	}

	/** @return list<array{string,string,bool,bool}> */
	public static function provideStrilikeNoAccents(): array {
		return [
			['café', 'cafè', false, true],
			['Été', 'Eté', false, true],
			['Été', 'Et', true, true],
		];
	}

	/** @return list<array{string,string,bool,bool}> */
	public static function provideStrilikeAccentsCasing(): array {
		return [
			['Été', 'été', false, true],
			['AÎNÉE', 'aîné', true, true],
			['AÎNÉ', 'aine', false, false],
			['AÎNÉE', 'aine', true, false],
		];
	}

	/** @return list<array{string,string,bool,bool}> */
	public static function provideStrilikeUnicodeCasing(): array {
		return [
			['ČĆĐŠŽ', 'čćđšž', false, true],	// Croatian
			['ÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ', 'áčďéěíňóřšťúůýž', false, true],	// Czech
			['ÆØÅ', 'æøå', false, true],	// Danish
			['ŠŽÕÄÖÜ', 'šžõäöü', false, true],	// Estonian
			['ÄÖ', 'äö', false, true],	// Finnish
			['ÀÂÆÇÈÉÊËÎÏÔŒÙÛÜŸ', 'àâæçèéêëîïôœùûüÿ', false, true],	// French
			['ÄÖÜ', 'äöü', false, true],	// German
			['ΑΆΒΓΔΕΈΖΗΉΘΙΊΪΚΛΜΝΞΟΌΠΡΣΤΥΎΫΦΧΨΩΏ', 'αάβγδεέζηήθιίϊκλμνξοόπρστυύϋφχψωώ', false, true],	// Greek
			['ÁÉÍÓÖŐÚÜŰ', 'áéíóöőúüű', false, true],	// Hungarian
			['ÁÉÍÓÚ', 'áéíóú', false, true],	// Irish
			['ÀÈÉÌÒÓÙ', 'àèéìòóù', false, true],	// Italian
			['ĀČĒĢĪĶĻŅŠŪŽ', 'āčēģīķļņšūž', false, true],	// Latvian
			['ĄČĘĖĮŠŲŪŽ', 'ąčęėįšųūž', false, true],	// Lithuanian
			['ĊĠĦŻ', 'ċġħż', false, true],	// Maltese
			['ĄĆĘŁŃÓŚŹŻ', 'ąćęłńóśźż', false, true],	// Polish
			['ÁÂÃÇÉÍÓÕÚ', 'áâãçéíóõú', false, true],	// Portuguese
			['ĂÂÎȘȚ', 'ăâîșț', false, true],	// Romanian
			['ÁÄČĎÉÍĹĽŇÓÔŔŠŤÚÝŽ', 'áäčďéíĺľňóôŕšťúýž', false, true],	// Slovak
			['ČŠŽ', 'čšž', false, true],	// Slovenian
			['ÁÉÍÑÓÚÜ', 'áéíñóúü', false, true],	// Spanish
			['ÅÄÖ', 'åäö', false, true],	// Swedish
		];
	}

	/** @return list<array{string,string,bool,bool}> */
	public static function provideStrilikeNoUnicodeCasing(): array {
		return [
			['café', 'cafè', false, false],
			['café', 'Café', true, true],
			['Été', 'été', true, false],
		];
	}

	#[DataProvider('provideStrilikeCommon')]
	#[DataProvider('provideStrilikeNoAccents')]
	#[DataProvider('provideStrilikeUnicodeCasing')]
	public static function test_strilike_MySQL(string $haystack, string $needle, bool $contains, bool $expected): void {
		if (!function_exists('transliterator_transliterate') && str_contains($haystack, 'α')) {
			self::markTestSkipped('transliterator_transliterate function not available to handle e.g. Greek.');
			return;	// @phpstan-ignore deadCode.unreachable
		}
		self::assertSame($expected, FreshRSS_DatabaseDAO::strilike($haystack, $needle, $contains));
	}

	#[DataProvider('provideStrilikeCommon')]
	#[DataProvider('provideStrilikeAccents')]
	#[DataProvider('provideStrilikeAccentsCasing')]
	#[DataProvider('provideStrilikeUnicodeCasing')]
	public static function test_strilike_PGSQL(string $haystack, string $needle, bool $contains, bool $expected): void {
		self::assertSame($expected, FreshRSS_DatabaseDAOPGSQL::strilike($haystack, $needle, $contains));
	}

	#[DataProvider('provideStrilikeCommon')]
	#[DataProvider('provideStrilikeAccents')]
	#[DataProvider('provideStrilikeNoUnicodeCasing')]
	public static function test_strilike_SQLite(string $haystack, string $needle, bool $contains, bool $expected): void {
		self::assertSame($expected, FreshRSS_DatabaseDAOSQLite::strilike($haystack, $needle, $contains));
	}

	/** @return list<array{int,int,bool}> */
	public static function provideSizeWithinLimit(): array {
		return [
			// [size in bytes, max size in bytes, expected]
			[0, 100, true],
			[100, 100, true],
			[101, 100, false],
			[100, 0, false],		// A max size of 0 (or less) always disallows.
			[100, -1, false],
			[-1, 100, false],		// A negative (unknown) size is never considered within limit.
		];
	}

	#[DataProvider('provideSizeWithinLimit')]
	public static function test_sizeWithinLimit(int $sizeBytes, int $maxSizeBytes, bool $expected): void {
		self::assertSame($expected, FreshRSS_DatabaseDAO::sizeWithinLimit($sizeBytes, $maxSizeBytes));
	}
}
