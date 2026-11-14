<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

final class DatabaseDAOTest extends \PHPUnit\Framework\TestCase {
	public function test_tablesAreCorrect_withPostgreSQL(): void {
		$dsn = getenv('FRESHRSS_TEST_PGSQL_DSN');
		if ($dsn === false || $dsn === '') {
			self::markTestSkipped('FRESHRSS_TEST_PGSQL_DSN is not configured.');
		}

		$pdo = new Minz_PdoPgsql($dsn, null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
		$pdo->setPrefix('test_');
		$pdo->beginTransaction();
		FreshRSS_Context::initSystem();
		$db = FreshRSS_Context::systemConf()->db;
		try {
			// A gateway login need not match the PostgreSQL role that owns the tables.
			$config = $db;
			$config['user'] = 'freshrss_test_app.routing';
			FreshRSS_Context::systemConf()->db = $config;
			$pdo->exec('CREATE ROLE freshrss_test_app NOLOGIN');
			$pdo->exec('CREATE SCHEMA freshrss_test_visible');
			$pdo->exec('CREATE SCHEMA freshrss_test_hidden');
			$pdo->exec('SET LOCAL search_path TO freshrss_test_visible');
			foreach (['category', 'feed', 'entry', 'entrytmp', 'tag', 'entrytag'] as $table) {
				$pdo->exec('CREATE TABLE test_' . $table . ' (id integer)');
			}
			$pdo->exec('CREATE TABLE another_users_feed (id integer)');
			$pdo->exec('GRANT USAGE ON SCHEMA freshrss_test_visible, freshrss_test_hidden TO freshrss_test_app');
			$pdo->exec('GRANT SELECT ON ALL TABLES IN SCHEMA freshrss_test_visible TO freshrss_test_app');
			$pdo->exec('SET LOCAL ROLE freshrss_test_app');
			$dao = new FreshRSS_DatabaseDAOPGSQL('test', $pdo);
			self::assertTrue($dao->tablesAreCorrect(), 'Visible tables may belong to another role.');

			$pdo->exec('RESET ROLE');
			$pdo->exec('ALTER TABLE test_feed SET SCHEMA freshrss_test_hidden');
			$pdo->exec('SET LOCAL ROLE freshrss_test_app');
			self::assertFalse($dao->tablesAreCorrect(), 'A table outside search_path must not hide a missing table.');

			$pdo->exec('RESET ROLE');
			$pdo->exec('CREATE VIEW test_feed AS SELECT * FROM freshrss_test_hidden.test_feed');
			$pdo->exec('SET LOCAL ROLE freshrss_test_app');
			self::assertFalse($dao->tablesAreCorrect(), 'A view must not count as a table.');
		} finally {
			$pdo->rollBack();
			FreshRSS_Context::systemConf()->db = $db;
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
}
