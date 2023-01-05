<?php

use Cli\I18n\I18nValue;
use Cli\I18n\I18nUsageValidator;

class I18nUsageValidatorTest extends PHPUnit\Framework\TestCase {
	private $value;

	public function setUp(): void {
		$this->value = $this->getMockBuilder(I18nValue::class)
			->disableOriginalConstructor()
			->getMock();
	}

	public function testDisplayReport() {
		$validator = new I18nUsageValidator([], []);

		$this->assertEquals("There is no data.\n", $validator->displayReport());

		$reflectionTotalEntries = new ReflectionProperty(I18nUsageValidator::class, 'totalEntries');
		$reflectionTotalEntries->setAccessible(true);
		$reflectionTotalEntries->setValue($validator, 100);

		$this->assertEquals("  0.0% of translation keys are unused.\n", $validator->displayReport());

		$reflectionFailedEntries = new ReflectionProperty(I18nUsageValidator::class, 'failedEntries');
		$reflectionFailedEntries->setAccessible(true);
		$reflectionFailedEntries->setValue($validator, 25);

		$this->assertEquals(" 25.0% of translation keys are unused.\n", $validator->displayReport());

		$reflectionFailedEntries->setValue($validator, 100);

		$this->assertEquals("100.0% of translation keys are unused.\n", $validator->displayReport());

		$reflectionFailedEntries->setValue($validator, 200);

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('The number of unused strings cannot be higher than the number of strings');
		$validator->displayReport();
	}

	public function testValidateWhenNoData() {
		$validator = new I18nUsageValidator([], []);
		$this->assertTrue($validator->validate());
		$this->assertEquals('', $validator->displayResult());
	}

	public function testValidateWhenParentKeyExistsWithoutTransformation() {
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
		$this->assertTrue($validator->validate());
		$this->assertEquals('', $validator->displayResult());
	}

	public function testValidateWhenParentKeyExistsWithTransformation() {
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
		$this->assertTrue($validator->validate());
		$this->assertEquals('', $validator->displayResult());
	}

	public function testValidateWhenParentKeyDoesNotExist() {
		$validator = new I18nUsageValidator([
			'file1' => [
				'file1.l1.l2._' => $this->value,
			],
			'file2' => [
				'file2.l1.l2._' => $this->value,
			],
		], []);
		$this->assertFalse($validator->validate());
		$this->assertEquals("Unused key file1.l1.l2._ - \nUnused key file2.l1.l2._ - \n", $validator->displayResult());
	}

	public function testValidateWhenChildKeyExists() {
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
		$this->assertTrue($validator->validate());
		$this->assertEquals('', $validator->displayResult());
	}

	public function testValidateWhenChildKeyDoesNotExist() {
		$validator = new I18nUsageValidator([
			'file1' => [
				'file1.l1.l2.k1' => $this->value,
			],
			'file2' => [
				'file2.l1.l2.k1' => $this->value,
			],
		], []);
		$this->assertFalse($validator->validate());
		$this->assertEquals("Unused key file1.l1.l2.k1 - \nUnused key file2.l1.l2.k1 - \n", $validator->displayResult());
	}
}
