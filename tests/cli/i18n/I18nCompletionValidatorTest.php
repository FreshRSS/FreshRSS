<?php
declare(strict_types=1);
require_once __DIR__ . '/../../../cli/i18n/I18nCompletionValidator.php';
require_once __DIR__ . '/../../../cli/i18n/I18nValue.php';

class I18nCompletionValidatorTest extends PHPUnit\Framework\TestCase {
	/** @var I18nValue&PHPUnit\Framework\MockObject\MockObject */
	private $value;

	#[\Override]
	public function setUp(): void {
		$this->value = $this->getMockBuilder(I18nValue::class)
			->disableOriginalConstructor()
			->getMock();
	}

	public function testDisplayReport(): void {
		$validator = new I18nCompletionValidator([], []);

		self::assertEquals("There is no data.\n", $validator->displayReport());

		$reflectionTotalEntries = new ReflectionProperty(I18nCompletionValidator::class, 'totalEntries');
		$reflectionTotalEntries->setAccessible(true);
		$reflectionTotalEntries->setValue($validator, 100);

		self::assertEquals("Translation is   0.0% complete.\n", $validator->displayReport());

		$reflectionPassEntries = new ReflectionProperty(I18nCompletionValidator::class, 'passEntries');
		$reflectionPassEntries->setAccessible(true);
		$reflectionPassEntries->setValue($validator, 25);

		self::assertEquals("Translation is  25.0% complete.\n", $validator->displayReport());

		$reflectionPassEntries->setValue($validator, 100);

		self::assertEquals("Translation is 100.0% complete.\n", $validator->displayReport());

		$reflectionPassEntries->setValue($validator, 200);

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('The number of translated strings cannot be higher than the number of strings');
		$validator->displayReport();
	}

	public function testValidateWhenNoData(): void {
		$validator = new I18nCompletionValidator([], []);
		self::assertTrue($validator->validate());
		self::assertEquals('', $validator->displayResult());
	}

	public function testValidateWhenKeyIsMissing(): void {
		$validator = new I18nCompletionValidator([
			'file1.php' => [
				'file1.l1.l2.k1' => $this->value,
			],
			'file2.php' => [
				'file2.l1.l2.k1' => $this->value,
			],
		], []);

		self::assertFalse($validator->validate());
		self::assertEquals("Missing key file1.l1.l2.k1\nMissing key file2.l1.l2.k1\n", $validator->displayResult());
	}

	public function testValidateWhenKeyIsIgnored(): void {
		$this->value->expects(self::exactly(2))
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

		self::assertTrue($validator->validate());
		self::assertEquals('', $validator->displayResult());
	}

	public function testValidateWhenValueIsEqual(): void {
		$this->value->expects(self::exactly(2))
			->method('isIgnore')
			->willReturn(false);
		$this->value->expects(self::exactly(2))
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

		self::assertFalse($validator->validate());
		self::assertEquals("Untranslated key file1.l1.l2.k1 - \nUntranslated key file2.l1.l2.k1 - \n", $validator->displayResult());
	}

	public function testValidateWhenValueIsDifferent(): void {
		$this->value->expects(self::exactly(2))
			->method('isIgnore')
			->willReturn(false);
		$this->value->expects(self::exactly(2))
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

		self::assertTrue($validator->validate());
		self::assertEquals('', $validator->displayResult());
	}
}
