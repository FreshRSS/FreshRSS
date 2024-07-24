<?php
declare(strict_types=1);
require_once __DIR__ . '/../../../cli/i18n/I18nValue.php';
require_once __DIR__ . '/../../../cli/i18n/I18nUsageValidator.php';

class I18nUsageValidatorTest extends PHPUnit\Framework\TestCase {

	private I18nValue $value;

	#[\Override]
	public function setUp(): void {
		$this->value = $this->getMockBuilder(I18nValue::class)
			->disableOriginalConstructor()
			->getMock();
	}

	public function testDisplayReport(): void {
		$validator = new I18nUsageValidator([], []);

		self::assertEquals("There is no data.\n", $validator->displayReport());

		$reflectionTotalEntries = new ReflectionProperty(I18nUsageValidator::class, 'totalEntries');
		$reflectionTotalEntries->setAccessible(true);
		$reflectionTotalEntries->setValue($validator, 100);

		self::assertEquals("  0.0% of translation keys are unused.\n", $validator->displayReport());

		$reflectionFailedEntries = new ReflectionProperty(I18nUsageValidator::class, 'failedEntries');
		$reflectionFailedEntries->setAccessible(true);
		$reflectionFailedEntries->setValue($validator, 25);

		self::assertEquals(" 25.0% of translation keys are unused.\n", $validator->displayReport());

		$reflectionFailedEntries->setValue($validator, 100);

		self::assertEquals("100.0% of translation keys are unused.\n", $validator->displayReport());

		$reflectionFailedEntries->setValue($validator, 200);

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('The number of unused strings cannot be higher than the number of strings');
		$validator->displayReport();
	}

	public function testValidateWhenNoData(): void {
		$validator = new I18nUsageValidator([], []);
		self::assertTrue($validator->validate());
		self::assertEquals('', $validator->displayResult());
	}

	public function testValidateWhenParentKeyExistsWithoutTransformation(): void {
		$validator = new I18nUsageValidator([
			'file1' => [
				'file1.l1.l2._' => $this->value,
			],
			'file2' => [
				'file2.l1.l2._' => $this->value,
			],
		], [
			'file1.l1.l2._',
			'file2.l1.l2._',
		]);
		self::assertTrue($validator->validate());
		self::assertEquals('', $validator->displayResult());
	}

	public function testValidateWhenParentKeyExistsWithTransformation(): void {
		$validator = new I18nUsageValidator([
			'file1' => [
				'file1.l1.l2._' => $this->value,
			],
			'file2' => [
				'file2.l1.l2._' => $this->value,
			],
		], [
			'file1.l1.l2',
			'file2.l1.l2',
		]);
		self::assertTrue($validator->validate());
		self::assertEquals('', $validator->displayResult());
	}

	public function testValidateWhenParentKeyDoesNotExist(): void {
		$validator = new I18nUsageValidator([
			'file1' => [
				'file1.l1.l2._' => $this->value,
			],
			'file2' => [
				'file2.l1.l2._' => $this->value,
			],
		], []);
		self::assertFalse($validator->validate());
		self::assertEquals("Unused key file1.l1.l2._ - \nUnused key file2.l1.l2._ - \n", $validator->displayResult());
	}

	public function testValidateWhenChildKeyExists(): void {
		$validator = new I18nUsageValidator([
			'file1' => [
				'file1.l1.l2.k1' => $this->value,
			],
			'file2' => [
				'file2.l1.l2.k1' => $this->value,
			],
		], [
			'file1.l1.l2.k1',
			'file2.l1.l2.k1',
		]);
		self::assertTrue($validator->validate());
		self::assertEquals('', $validator->displayResult());
	}

	public function testValidateWhenChildKeyDoesNotExist(): void {
		$validator = new I18nUsageValidator([
			'file1' => [
				'file1.l1.l2.k1' => $this->value,
			],
			'file2' => [
				'file2.l1.l2.k1' => $this->value,
			],
		], []);
		self::assertFalse($validator->validate());
		self::assertEquals("Unused key file1.l1.l2.k1 - \nUnused key file2.l1.l2.k1 - \n", $validator->displayResult());
	}
}
