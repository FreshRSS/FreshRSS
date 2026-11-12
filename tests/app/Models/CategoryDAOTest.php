<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

final class CategoryDAOTest extends \PHPUnit\Framework\TestCase {

	#[DataProvider('provideLanguages')]
	public function test_searchByName_resolvesLocalisedDefaultCategory(string $language): void {
		$previousLanguage = Minz_Translate::language();
		Minz_Translate::init($language);
		try {
			$pdo = new Minz_PdoSqlite('sqlite::memory:');
			$pdo->exec('CREATE TABLE category (id INTEGER PRIMARY KEY, name TEXT, kind INTEGER DEFAULT 0)');
			$pdo->exec("INSERT INTO category (id, name) VALUES (1, 'Uncategorized'), (2, 'Архив с пробелами')");
			$dao = new FreshRSS_CategoryDAOSQLite(currentPdo: $pdo);

			$defaultCategory = $dao->searchById(FreshRSS_CategoryDAO::DEFAULTCATEGORYID);
			self::assertNotNull($defaultCategory);
			self::assertSame(FreshRSS_CategoryDAO::DEFAULTCATEGORYID, $dao->searchByName($defaultCategory->name())?->id());
			self::assertSame(FreshRSS_CategoryDAO::DEFAULTCATEGORYID, $dao->searchByName(FreshRSS_CategoryDAO::DEFAULT_CATEGORY_NAME)?->id());
			self::assertSame(2, $dao->searchByName('Архив с пробелами')?->id());
			self::assertNull($dao->searchByName('Missing category'));
		} finally {
			Minz_Translate::init($previousLanguage);
		}
	}

	/** @return list<array{string}> */
	public static function provideLanguages(): array {
		return [['en'], ['ru'], ['fr']];
	}
}
