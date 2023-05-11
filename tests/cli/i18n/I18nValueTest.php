<?php

require_once __DIR__ . '/../../../cli/i18n/I18nValue.php';

class I18nValueTest extends PHPUnit\Framework\TestCase {
	public function testConstructorWithoutState(): void {
		$value = new I18nValue('some value');
		self::assertEquals('some value', $value->getValue());
		self::assertFalse($value->isIgnore());
		self::assertFalse($value->isTodo());
	}

	public function testConstructorWithUnknownState(): void {
		$value = new I18nValue('some value -> unknown');
		self::assertEquals('some value', $value->getValue());
		self::assertFalse($value->isIgnore());
		self::assertFalse($value->isTodo());
	}

	public function testConstructorWithTodoState(): void {
		$value = new I18nValue('some value -> todo');
		self::assertEquals('some value', $value->getValue());
		self::assertFalse($value->isIgnore());
		self::assertTrue($value->isTodo());
	}

	public function testConstructorWithIgnoreState(): void {
		$value = new I18nValue('some value -> ignore');
		self::assertEquals('some value', $value->getValue());
		self::assertTrue($value->isIgnore());
		self::assertFalse($value->isTodo());
	}

	public function testClone(): void {
		$value = new I18nValue('some value');
		$clonedValue = clone $value;
		self::assertEquals('some value', $value->getValue());
		self::assertEquals('some value', $clonedValue->getValue());
		self::assertFalse($value->isIgnore());
		self::assertFalse($clonedValue->isIgnore());
		self::assertFalse($value->isTodo());
		self::assertTrue($clonedValue->isTodo());
	}

	public function testEqualWhenValueIsIdentical(): void {
		$value = new I18nValue('some value');
		$clonedValue = clone $value;
		self::assertTrue($value->equal($clonedValue));
		self::assertTrue($clonedValue->equal($value));
	}

	public function testEqualWhenValueIsDifferent(): void {
		$value = new I18nValue('some value');
		$otherValue = new I18nValue('some other value');
		self::assertFalse($value->equal($otherValue));
		self::assertFalse($otherValue->equal($value));
	}

	public function testStates(): void {
		$reflectionProperty = new ReflectionProperty(I18nValue::class, 'state');
		$reflectionProperty->setAccessible(true);

		$value = new I18nValue('some value');
		self::assertNull($reflectionProperty->getValue($value));
		$value->markAsDirty();
		self::assertEquals('dirty', $reflectionProperty->getValue($value));
		$value->unmarkAsIgnore();
		self::assertEquals('dirty', $reflectionProperty->getValue($value));
		$value->markAsIgnore();
		self::assertEquals('ignore', $reflectionProperty->getValue($value));
		$value->unmarkAsIgnore();
		self::assertNull($reflectionProperty->getValue($value));
		$value->markAsTodo();
		self::assertEquals('todo', $reflectionProperty->getValue($value));
	}

	public function testToString(): void {
		$value = new I18nValue('some value');
		self::assertEquals('some value', $value->__toString());
		$value->markAsTodo();
		self::assertEquals('some value -> todo', $value->__toString());
	}
}
