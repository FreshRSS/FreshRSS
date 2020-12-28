<?php

use Cli\I18n\I18nValue;

class I18nValueTest extends PHPUnit\Framework\TestCase {
	public function testConstructorWithoutState() {
		$value = new I18nValue('some value');
		$this->assertEquals('some value', $value->getValue());
		$this->assertFalse($value->isIgnore());
		$this->assertFalse($value->isTodo());
	}

	public function testConstructorWithUnknownState() {
		$value = new I18nValue('some value -> unknown');
		$this->assertEquals('some value', $value->getValue());
		$this->assertFalse($value->isIgnore());
		$this->assertFalse($value->isTodo());
	}

	public function testConstructorWithTodoState() {
		$value = new I18nValue('some value -> todo');
		$this->assertEquals('some value', $value->getValue());
		$this->assertFalse($value->isIgnore());
		$this->assertTrue($value->isTodo());
	}

	public function testConstructorWithIgnoreState() {
		$value = new I18nValue('some value -> ignore');
		$this->assertEquals('some value', $value->getValue());
		$this->assertTrue($value->isIgnore());
		$this->assertFalse($value->isTodo());
	}

	public function testClone() {
		$value = new I18nValue('some value');
		$clonedValue = clone $value;
		$this->assertEquals('some value', $value->getValue());
		$this->assertEquals('some value', $clonedValue->getValue());
		$this->assertFalse($value->isIgnore());
		$this->assertFalse($clonedValue->isIgnore());
		$this->assertFalse($value->isTodo());
		$this->assertTrue($clonedValue->isTodo());
	}

	public function testEqualWhenValueIsIdentical() {
		$value = new I18nValue('some value');
		$clonedValue = clone $value;
		$this->assertTrue($value->equal($clonedValue));
		$this->assertTrue($clonedValue->equal($value));
	}

	public function testEqualWhenValueIsDifferent() {
		$value = new I18nValue('some value');
		$otherValue = new I18nValue('some other value');
		$this->assertFalse($value->equal($otherValue));
		$this->assertFalse($otherValue->equal($value));
	}

	public function testStates() {
		$reflectionProperty = new ReflectionProperty(I18nValue::class, 'state');
		$reflectionProperty->setAccessible(true);

		$value = new I18nValue('some value');
		$this->assertNull($reflectionProperty->getValue($value));
		$value->markAsDirty();
		$this->assertEquals('dirty', $reflectionProperty->getValue($value));
		$value->unmarkAsIgnore();
		$this->assertEquals('dirty', $reflectionProperty->getValue($value));
		$value->markAsIgnore();
		$this->assertEquals('ignore', $reflectionProperty->getValue($value));
		$value->unmarkAsIgnore();
		$this->assertNull($reflectionProperty->getValue($value));
		$value->markAsTodo();
		$this->assertEquals('todo', $reflectionProperty->getValue($value));
	}

	public function testToString() {
		$value = new I18nValue('some value');
		$this->assertEquals('some value', $value->__toString());
		$value->markAsTodo();
		$this->assertEquals('some value -> todo', $value->__toString());
	}
}
