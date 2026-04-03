<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

final class TranslateTest extends \PHPUnit\Framework\TestCase {
	/**
	 * @return list<array{string,int,string}>
	 */
	public static function providePluralTranslations(): array {
		return [
			['en', 1, '1 day'],
			['en', 2, '2 days'],
			['fr', 0, '0 jour'],
			['fr', 2, '2 jours'],
			['id', 5, '5 hari'],
			['lv', 0, '0 dienu'],
			['lv', 1, '1 diena'],
			['lv', 2, '2 dienas'],
			['he', 2, '2 ימים'],
			['ru', 5, '5 дней'],
			['zh-CN', 3, '3天'],
		];
	}

	#[DataProvider('providePluralTranslations')]
	public function testPluralUsesLocalePluralForms(string $language, int $value, string $expected): void {
		Minz_Translate::init($language);

		self::assertSame($expected, Minz_Translate::plural('gen.interval.day', $value));
	}

	public function testTimeagoUsesPluralCatalogues(): void {
		Minz_Translate::init('ru');

		self::assertSame('5 минут назад', timeago(0, 5 * 60));

		Minz_Translate::reset('fr');
		self::assertSame('il y a 2 jours', timeago(0, 2 * 86400));
	}
}
