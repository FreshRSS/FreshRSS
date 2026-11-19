<?php
declare(strict_types=1);

require_once LIB_PATH . '/lib_install.php';

use PHPUnit\Framework\Attributes\DataProvider;

final class InstallTest extends \PHPUnit\Framework\TestCase {
	/**
	 * @return list<array{int,bool,'ok'|'ko'|null}>
	 */
	public static function provideGmpRequirementStatus(): array {
		return [
			[8, false, null],
			[4, true, 'ok'],
			[4, false, 'ko'],
		];
	}

	#[DataProvider('provideGmpRequirementStatus')]
	public function testGmpRequirementStatus(int $integerSize, bool $gmpLoaded, ?string $expected): void {
		self::assertSame($expected, gmpRequirementStatus($integerSize, $gmpLoaded));
	}
}
