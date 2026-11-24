<?php
declare(strict_types=1);

use FreshRss\Minz\PdoSqlite;
use FreshRss\Minz\Translate;
use FreshRss\Models\CategoryDAO;
use FreshRss\Models\CategoryDAOSQLite;
use PHPUnit\Framework\Attributes\DataProvider;

final class CategoryDAOTest extends \PHPUnit\Framework\TestCase {

	#[DataProvider('provideLanguages')]
	public function test_searchByName_resolvesLocalisedDefaultCategory(string $language): void {
		$previousLanguage = Translate::language();
		Translate::init($language);
		try {
			$pdo = new PdoSqlite('sqlite::memory:');
			$pdo->exec('CREATE TABLE category (id INTEGER PRIMARY KEY, name TEXT, kind INTEGER DEFAULT 0)');
			$pdo->exec("INSERT INTO category (id, name) VALUES (1, 'Uncategorized'), (2, 'Архив с пробелами')");
			$dao = new CategoryDAOSQLite(currentPdo: $pdo);

			$defaultCategory = $dao->searchById(CategoryDAO::DEFAULTCATEGORYID);
			self::assertNotNull($defaultCategory);
			self::assertSame(CategoryDAO::DEFAULTCATEGORYID, $dao->searchByName($defaultCategory->name())?->id());
			self::assertSame(CategoryDAO::DEFAULTCATEGORYID, $dao->searchByName(CategoryDAO::DEFAULT_CATEGORY_NAME)?->id());
			self::assertSame(2, $dao->searchByName('Архив с пробелами')?->id());
			self::assertNull($dao->searchByName('Missing category'));
		} finally {
			Translate::init($previousLanguage);
		}
	}

	/** @return list<array{string}> */
	public static function provideLanguages(): array {
		return [['en'], ['ru'], ['fr']];
	}
}
