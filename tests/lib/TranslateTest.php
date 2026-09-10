<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

final class TranslateTest extends \PHPUnit\Framework\TestCase {
	/**
	 * @return list<array{string,int,string}>
	 */
	public static function providePluralTranslations(): array {
		return [
			['en', 1, '1 day ago'],
			['en', 2, '2 days ago'],
			['fr', 0, 'il y a 0 jour'],
			['fr', 2, 'il y a 2 jours'],
			['id', 5, '5 hari yang lalu'],
			['lv', 0, 'pirms 0 dienu'],
			['lv', 1, 'pirms 1 diena'],
			['lv', 2, 'pirms 2 dienas'],
			['he', 2, 'לפני 2 ימים'],
			['ru', 5, '5 дней назад'],
			['zh-CN', 3, '3天前'],
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

	public function testCompiledPluralFileProvidesRuntimeCallable(): void {
		$pluralData = include APP_PATH . '/i18n/cs/plurals.php';

		self::assertIsArray($pluralData);
		self::assertSame(3, $pluralData['nplurals']);
		self::assertInstanceOf(Closure::class, $pluralData['plural']);
		self::assertSame(1, $pluralData['plural'](3));
	}
}
