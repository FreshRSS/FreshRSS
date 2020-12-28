<?php

use Cli\I18n\I18nCompletionValidator;
use Cli\I18n\I18nValue;

class I18nCompletionValidatorTest extends PHPUnit\Framework\TestCase {
	private $value;

	public function setUp(): void {
		$this->value = $this->getMockBuilder(I18nValue::class)
			->disableOriginalConstructor()
			->getMock();
	}

	public function testDisplayReport() {
		$validator = new I18nCompletionValidator([], []);

		$this->assertEquals("There is no data.\n", $validator->displayReport());

		$reflectionTotalEntries = new ReflectionProperty(I18nCompletionValidator::class, 'totalEntries');
		$reflectionTotalEntries->setAccessible(true);
		$reflectionTotalEntries->setValue($validator, 100);

		$this->assertEquals("Translation is   0.0% complete.\n", $validator->displayReport());

		$reflectionPassEntries = new ReflectionProperty(I18nCompletionValidator::class, 'passEntries');
		$reflectionPassEntries->setAccessible(true);
		$reflectionPassEntries->setValue($validator, 25);

		$this->assertEquals("Translation is  25.0% complete.\n", $validator->displayReport());

		$reflectionPassEntries->setValue($validator, 100);

		$this->assertEquals("Translation is 100.0% complete.\n", $validator->displayReport());

		$reflectionPassEntries->setValue($validator, 200);

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('The number of translated strings cannot be higher than the number of strings');
		$validator->displayReport();
	}

	public function testValidateWhenNoData() {
		$validator = new I18nCompletionValidator([], []);
		$this->assertTrue($validator->validate());
		$this->assertEquals('', $validator->displayResult());
	}

	public function testValidateWhenKeyIsMissing() {
		$validator = new I18nCompletionValidator([
			'file1.php' => [
				'file1.l1.l2.k1' => $this->value,
			],
			'file2.php' => [
				'file2.l1.l2.k1' => $this->value,
			],
		], []);

		$this->assertFalse($validator->validate());
		$this->assertEquals("Missing key file1.l1.l2.k1\nMissing key file2.l1.l2.k1\n", $validator->displayResult());
	}

	public function testValidateWhenKeyIsIgnored() {
		$this->value->expects($this->exactly(2))
			->method('isIgnore')
			->willReturn(true);

		$validator = new I18nCompletionValidator([
			'file1.php' => [
				'file1.l1.l2.k1' => $this->value,
			],
			'file2.php' => [
				'file2.l1.l2.k1' => $this->value,
			],
		], [
			'file1.php' => [
				'file1.l1.l2.k1' => $this->value,
			],
			'file2.php' => [
				'file2.l1.l2.k1' => $this->value,
			],
		]);

		$this->assertTrue($validator->validate());
		$this->assertEquals('', $validator->displayResult());
	}

	public function testValidateWhenValueIsEqual() {
		$this->value->expects($this->exactly(2))
			->method('isIgnore')
			->willReturn(false);
		$this->value->expects($this->exactly(2))
			->method('equal')
			->willReturn(true);

		$validator = new I18nCompletionValidator([
			'file1.php' => [
				'file1.l1.l2.k1' => $this->value,
			],
			'file2.php' => [
				'file2.l1.l2.k1' => $this->value,
			],
		], [
			'file1.php' => [
				'file1.l1.l2.k1' => $this->value,
			],
			'file2.php' => [
				'file2.l1.l2.k1' => $this->value,
			],
		]);

		$this->assertFalse($validator->validate());
		$this->assertEquals("Untranslated key file1.l1.l2.k1 - \nUntranslated key file2.l1.l2.k1 - \n", $validator->displayResult());
	}

	public function testValidateWhenValueIsDifferent() {
		$this->value->expects($this->exactly(2))
			->method('isIgnore')
			->willReturn(false);
		$this->value->expects($this->exactly(2))
			->method('equal')
			->willReturn(false);

		$validator = new I18nCompletionValidator([
			'file1.php' => [
				'file1.l1.l2.k1' => $this->value,
			],
			'file2.php' => [
				'file2.l1.l2.k1' => $this->value,
			],
		], [
			'file1.php' => [
				'file1.l1.l2.k1' => $this->value,
			],
			'file2.php' => [
				'file2.l1.l2.k1' => $this->value,
			],
		]);

		$this->assertTrue($validator->validate());
		$this->assertEquals('', $validator->displayResult());
	}
}
