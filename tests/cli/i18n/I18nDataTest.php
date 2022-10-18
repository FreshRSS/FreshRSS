<?php

require_once __DIR__ . '/../../../cli/i18n/I18nData.php';
require_once __DIR__ . '/../../../cli/i18n/I18nValue.php';

class I18nDataTest extends PHPUnit\Framework\TestCase {
	private $referenceData;
	private $value;

	public function setUp(): void {
		$this->value = $this->getMockBuilder(I18nValue::class)
			->disableOriginalConstructor()
			->getMock();

		$this->referenceData = [
			'en' => [
				'file1.php' => [
					'file1.l1.l2.k1' => $this->value,
					'file1.l1.l2.k2' => $this->value,
				],
				'file2.php' => [
					'file2.l1.l2._' => $this->value,
					'file2.l1.l2.k1' => $this->value,
					'file2.l1.l2.k2' => $this->value,
				],
				'file3.php' => [
					'file3.l1.l2._' => $this->value,
					'file3.l1.l2.k1' => $this->value,
				],
			],
		];
	}

	public function testConstructWhenReferenceOnly() {
		$data = new I18nData($this->referenceData);
		$this->assertEquals($this->referenceData, $data->getData());
	}

	public function testConstructorWhenLanguageIsMissingFile() {
		$rawData = array_merge($this->referenceData, [
			'fr' => [
				'file1.php' => [
					'file1.l1.l2.k1' => $this->value,
				],
			],
		]);
		$data = new I18nData($rawData);
		$this->assertEquals([
			'en' => [
				'file1.php' => [
					'file1.l1.l2.k1' => $this->value,
					'file1.l1.l2.k2' => $this->value,
				],
				'file2.php' => [
					'file2.l1.l2._' => $this->value,
					'file2.l1.l2.k1' => $this->value,
					'file2.l1.l2.k2' => $this->value,
				],
				'file3.php' => [
					'file3.l1.l2._' => $this->value,
					'file3.l1.l2.k1' => $this->value,
				],
			],
			'fr' => [
				'file1.php' => [
					'file1.l1.l2.k1' => $this->value,
					'file1.l1.l2.k2' => $this->value,
				],
				'file2.php' => [
					'file2.l1.l2._' => $this->value,
					'file2.l1.l2.k1' => $this->value,
					'file2.l1.l2.k2' => $this->value,
				],
				'file3.php' => [
					'file3.l1.l2._' => $this->value,
					'file3.l1.l2.k1' => $this->value,
				],
			],
		], $data->getData());
	}

	public function testConstructorWhenLanguageIsMissingKeys() {
		$rawData = array_merge($this->referenceData, [
			'fr' => [
				'file1.php' => [
					'file1.l1.l2.k1' => $this->value,
				],
				'file2.php' => [
					'file2.l1.l2.k1' => $this->value,
				],
			],
		]);
		$data = new I18nData($rawData);
		$this->assertEquals([
			'en' => [
				'file1.php' => [
					'file1.l1.l2.k1' => $this->value,
					'file1.l1.l2.k2' => $this->value,
				],
				'file2.php' => [
					'file2.l1.l2._' => $this->value,
					'file2.l1.l2.k1' => $this->value,
					'file2.l1.l2.k2' => $this->value,
				],
				'file3.php' => [
					'file3.l1.l2._' => $this->value,
					'file3.l1.l2.k1' => $this->value,
				],
			],
			'fr' => [
				'file1.php' => [
					'file1.l1.l2.k1' => $this->value,
					'file1.l1.l2.k2' => $this->value,
				],
				'file2.php' => [
					'file2.l1.l2._' => $this->value,
					'file2.l1.l2.k1' => $this->value,
					'file2.l1.l2.k2' => $this->value,
				],
				'file3.php' => [
					'file3.l1.l2._' => $this->value,
					'file3.l1.l2.k1' => $this->value,
				],
			],
		], $data->getData());
	}

	public function testConstructorWhenLanguageHasExtraKeys() {
		$rawData = array_merge($this->referenceData, [
			'fr' => [
				'file1.php' => [
					'file1.l1.l2.k1' => $this->value,
					'file1.l1.l2.k2' => $this->value,
					'file1.l1.l2.k3' => $this->value,
				],
				'file2.php' => [
					'file2.l1.l2.k1' => $this->value,
					'file2.l1.l2.k2' => $this->value,
					'file2.l1.l2.k3' => $this->value,
				],
				'file3.php' => [
					'file3.l1.l2._' => $this->value,
					'file3.l1.l2.k1' => $this->value,
				],
			],
		]);
		$data = new I18nData($rawData);
		$this->assertEquals([
			'en' => [
				'file1.php' => [
					'file1.l1.l2.k1' => $this->value,
					'file1.l1.l2.k2' => $this->value,
				],
				'file2.php' => [
					'file2.l1.l2._' => $this->value,
					'file2.l1.l2.k1' => $this->value,
					'file2.l1.l2.k2' => $this->value,
				],
				'file3.php' => [
					'file3.l1.l2._' => $this->value,
					'file3.l1.l2.k1' => $this->value,
				],
			],
			'fr' => [
				'file1.php' => [
					'file1.l1.l2.k1' => $this->value,
					'file1.l1.l2.k2' => $this->value,
				],
				'file2.php' => [
					'file2.l1.l2._' => $this->value,
					'file2.l1.l2.k1' => $this->value,
					'file2.l1.l2.k2' => $this->value,
				],
				'file3.php' => [
					'file3.l1.l2._' => $this->value,
					'file3.l1.l2.k1' => $this->value,
				],
			],
		], $data->getData());
	}

	public function testConstructorWhenValueIsIdenticalAndIsMarkedAsIgnore() {
		$value = $this->getMockBuilder(I18nValue::class)
			->disableOriginalConstructor()
			->getMock();
		$value->expects($this->exactly(2))
			->method('isIgnore')
			->willReturn(true);
		$value->expects($this->never())
			->method('markAsTodo');
		$value->expects($this->exactly(3))
			->method('equal')
			->with($value)
			->willReturn(true);

		$rawData = array_merge($this->referenceData, [
			'fr' => [
				'file2.php' => [
					'file2.l1.l2.k1' => $value,
				],
			],
		]);
		$rawData['en']['file2.php']['file2.l1.l2.k1'] = $value;
		new I18nData($rawData);
	}

	public function testConstructorWhenValueIsIdenticalAndIsNotMarkedAsIgnore() {
		$value = $this->getMockBuilder(I18nValue::class)
			->disableOriginalConstructor()
			->getMock();
		$value->expects($this->exactly(2))
			->method('isIgnore')
			->willReturn(false);
		$value->expects($this->exactly(2))
			->method('markAsTodo');
		$value->expects($this->exactly(2))
			->method('equal')
			->with($value)
			->willReturn(true);

		$rawData = array_merge($this->referenceData, [
			'fr' => [
				'file2.php' => [
					'file2.l1.l2.k1' => $value,
				],
			],
		]);
		$rawData['en']['file2.php']['file2.l1.l2.k1'] = $value;
		new I18nData($rawData);
	}

	public function testConstructorWhenValueIsDifferentAndIsMarkedAsToDo() {
		$value = $this->getMockBuilder(I18nValue::class)
			->disableOriginalConstructor()
			->getMock();
		$value->expects($this->once())
			->method('isTodo')
			->willReturn(true);
		$value->expects($this->once())
			->method('markAsDirty');

		$rawData = array_merge($this->referenceData, [
			'fr' => [
				'file2.php' => [
					'file2.l1.l2.k1' => $value,
				],
			],
		]);
		new I18nData($rawData);
	}

	public function testConstructorWhenValueIsDifferentAndIsNotMarkedAsTodo() {
		$value = $this->getMockBuilder(I18nValue::class)
			->disableOriginalConstructor()
			->getMock();
		$value->expects($this->once())
			->method('isTodo')
			->willReturn(false);
		$value->expects($this->never())
			->method('markAsDirty');

		$rawData = array_merge($this->referenceData, [
			'fr' => [
				'file2.php' => [
					'file2.l1.l2.k1' => $value,
				],
			],
		]);
		new I18nData($rawData);
	}

	public function testGetAvailableLanguagesWhenTheyAreSorted() {
		$rawData = array_merge($this->referenceData, [
			'fr' => [],
			'nl' => [],
		]);
		$data = new I18nData($rawData);
		$this->assertEquals([
			'en',
			'fr',
			'nl',
		], $data->getAvailableLanguages());
	}

	public function testGetAvailableLanguagesWhenTheyAreNotSorted() {
		$rawData = array_merge($this->referenceData, [
			'nl' => [],
			'fr' => [],
			'de' => [],
		]);
		$data = new I18nData($rawData);
		$this->assertEquals([
			'de',
			'en',
			'fr',
			'nl',
		], $data->getAvailableLanguages());
	}

	public function testAddLanguageWhenLanguageExists() {
		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('The selected language already exist.');
		$data = new I18nData($this->referenceData);
		$data->addLanguage('en');
	}

	public function testAddLanguageWhenNoReferenceProvided() {
		$data = new I18nData($this->referenceData);
		$data->addLanguage('fr');
		$this->assertEquals([
			'en' => [
				'file1.php' => [
					'file1.l1.l2.k1' => $this->value,
					'file1.l1.l2.k2' => $this->value,
				],
				'file2.php' => [
					'file2.l1.l2._' => $this->value,
					'file2.l1.l2.k1' => $this->value,
					'file2.l1.l2.k2' => $this->value,
				],
				'file3.php' => [
					'file3.l1.l2._' => $this->value,
					'file3.l1.l2.k1' => $this->value,
				],
			],
			'fr' => [
				'file1.php' => [
					'file1.l1.l2.k1' => $this->value,
					'file1.l1.l2.k2' => $this->value,
				],
				'file2.php' => [
					'file2.l1.l2._' => $this->value,
					'file2.l1.l2.k1' => $this->value,
					'file2.l1.l2.k2' => $this->value,
				],
				'file3.php' => [
					'file3.l1.l2._' => $this->value,
					'file3.l1.l2.k1' => $this->value,
				],
			],
		], $data->getData());
	}

	public function testAddLanguageWhenUnknownReferenceProvided() {
		$data = new I18nData($this->referenceData);
		$data->addLanguage('fr', 'unknown');
		$this->assertEquals([
			'en' => [
				'file1.php' => [
					'file1.l1.l2.k1' => $this->value,
					'file1.l1.l2.k2' => $this->value,
				],
				'file2.php' => [
					'file2.l1.l2._' => $this->value,
					'file2.l1.l2.k1' => $this->value,
					'file2.l1.l2.k2' => $this->value,
				],
				'file3.php' => [
					'file3.l1.l2._' => $this->value,
					'file3.l1.l2.k1' => $this->value,
				],
			],
			'fr' => [
				'file1.php' => [
					'file1.l1.l2.k1' => $this->value,
					'file1.l1.l2.k2' => $this->value,
				],
				'file2.php' => [
					'file2.l1.l2._' => $this->value,
					'file2.l1.l2.k1' => $this->value,
					'file2.l1.l2.k2' => $this->value,
				],
				'file3.php' => [
					'file3.l1.l2._' => $this->value,
					'file3.l1.l2.k1' => $this->value,
				],
			],
		], $data->getData());
	}

	public function testAddLanguageWhenKnownReferenceProvided() {
		$data = new I18nData($this->referenceData);
		$data->addLanguage('fr', 'en');
		$this->assertEquals([
			'en' => [
				'file1.php' => [
					'file1.l1.l2.k1' => $this->value,
					'file1.l1.l2.k2' => $this->value,
				],
				'file2.php' => [
					'file2.l1.l2._' => $this->value,
					'file2.l1.l2.k1' => $this->value,
					'file2.l1.l2.k2' => $this->value,
				],
				'file3.php' => [
					'file3.l1.l2._' => $this->value,
					'file3.l1.l2.k1' => $this->value,
				],
			],
			'fr' => [
				'file1.php' => [
					'file1.l1.l2.k1' => $this->value,
					'file1.l1.l2.k2' => $this->value,
				],
				'file2.php' => [
					'file2.l1.l2._' => $this->value,
					'file2.l1.l2.k1' => $this->value,
					'file2.l1.l2.k2' => $this->value,
				],
				'file3.php' => [
					'file3.l1.l2._' => $this->value,
					'file3.l1.l2.k1' => $this->value,
				],
			],
		], $data->getData());
	}

	public function testIsKnownWhenKeyExists() {
		$data = new I18nData($this->referenceData);
		$this->assertTrue($data->isKnown('file2.l1.l2.k2'));
	}

	public function testIsKnownWhenKeyDoesNotExist() {
		$data = new I18nData($this->referenceData);
		$this->assertFalse($data->isKnown('file2.l1.l2.k3'));
	}

	public function testAddKeyWhenKeyExists() {
		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('The selected key already exist.');
		$data = new I18nData($this->referenceData);
		$data->addKey('file2.l1.l2.k1', 'value');
	}

	public function testAddKeyWhenParentKeyExists() {
		$rawData = array_merge($this->referenceData, [
			'fr' => [],
		]);

		$data = new I18nData($rawData);
		$this->assertTrue($data->isKnown('file2.l1.l2.k1'));
		$this->assertFalse($data->isKnown('file2.l1.l2.k1._'));
		$this->assertFalse($data->isKnown('file2.l1.l2.k1.sk1'));
		$data->addKey('file2.l1.l2.k1.sk1', 'value');
		$this->assertFalse($data->isKnown('file2.l1.l2.k1'));
		$this->assertTrue($data->isKnown('file2.l1.l2.k1._'));
		$this->assertTrue($data->isKnown('file2.l1.l2.k1.sk1'));
	}

	public function testAddKeyWhenKeyIsParent() {
		$rawData = array_merge($this->referenceData, [
			'fr' => [],
		]);

		$data = new I18nData($rawData);
		$this->assertFalse($data->isKnown('file1.l1.l2._'));
		$this->assertTrue($data->isKnown('file1.l1.l2.k1'));
		$this->assertTrue($data->isKnown('file1.l1.l2.k2'));
		$data->addKey('file1.l1.l2', 'value');
		$this->assertTrue($data->isKnown('file1.l1.l2._'));
		$this->assertTrue($data->isKnown('file1.l1.l2.k1'));
		$this->assertTrue($data->isKnown('file1.l1.l2.k2'));
	}

	public function testAddKey() {
		$getTargetedValue = static function (I18nData $data, string $language) {
			return $data->getData()[$language]['file2.php']['file2.l1.l2.k3'];
		};

		$rawData = array_merge($this->referenceData, [
			'fr' => [],
		]);

		$data = new I18nData($rawData);
		$this->assertFalse($data->isKnown('file2.l1.l2.k3'));
		$data->addKey('file2.l1.l2.k3', 'value');
		$this->assertTrue($data->isKnown('file2.l1.l2.k3'));

		$enValue = $getTargetedValue($data, 'en');
		$frValue = $getTargetedValue($data, 'fr');
		$this->assertInstanceOf(I18nValue::class, $enValue);
		$this->assertEquals('value', $enValue->getValue());
		$this->assertTrue($enValue->isTodo());
		$this->assertEquals($frValue, $enValue);
	}

	public function testAddValueWhenLanguageDoesNotExist() {
		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('The selected language does not exist.');
		$data = new I18nData($this->referenceData);
		$data->addValue('file2.l1.l2.k2', 'new value', 'fr');
	}

	public function testAddValueWhenKeyDoesNotExist() {
		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('The selected key does not exist for the selected language.');
		$data = new I18nData($this->referenceData);
		$data->addValue('unknown key', 'new value', 'en');
	}

	public function testAddValueWhenLanguageIsReferenceAndValueInOtherLanguageHasNotChange() {
		$getTargetedValue = static function (I18nData $data, string $language) {
			return $data->getData()[$language]['file2.php']['file2.l1.l2.k2'];
		};

		$this->value->expects($this->atLeast(2))
			->method('equal')
			->with($this->value)
			->willReturn(true);

		$rawData = array_merge($this->referenceData, [
			'fr' => [],
		]);
		$data = new I18nData($rawData);
		$beforeEnValue = $getTargetedValue($data, 'en');
		$beforeFrValue = $getTargetedValue($data, 'fr');
		$data->addValue('file2.l1.l2.k2', 'new value', 'en');
		$afterEnValue = $getTargetedValue($data, 'en');
		$afterFrValue = $getTargetedValue($data, 'fr');

		$this->assertEquals($this->value, $beforeEnValue);
		$this->assertEquals($this->value, $beforeFrValue);
		$this->assertInstanceOf(I18nValue::class, $afterEnValue);
		$this->assertEquals('new value', $afterEnValue->getValue());
		$this->assertInstanceOf(I18nValue::class, $afterFrValue);
		$this->assertEquals('new value', $afterFrValue->getValue());
	}

	public function testAddValueWhenLanguageIsReferenceAndValueInOtherLanguageHasChange() {
		$getTargetedValue = static function (I18nData $data, string $language) {
			return $data->getData()[$language]['file2.php']['file2.l1.l2.k2'];
		};

		$this->value->expects($this->any())
			->method('equal')
			->with($this->value)
			->willReturn(true);

		$value = $this->getMockBuilder(I18nValue::class)
			->disableOriginalConstructor()
			->getMock();

		$rawData = array_merge($this->referenceData, [
			'fr' => [
				'file2.php' => [
					'file2.l1.l2.k2' => $value,
				]
			],
		]);
		$data = new I18nData($rawData);
		$beforeEnValue = $getTargetedValue($data, 'en');
		$beforeFrValue = $getTargetedValue($data, 'fr');
		$data->addValue('file2.l1.l2.k2', 'new value', 'en');
		$afterEnValue = $getTargetedValue($data, 'en');
		$afterFrValue = $getTargetedValue($data, 'fr');

		$this->assertEquals($this->value, $beforeEnValue);
		$this->assertEquals($value, $beforeFrValue);
		$this->assertInstanceOf(I18nValue::class, $afterEnValue);
		$this->assertEquals('new value', $afterEnValue->getValue());
		$this->assertEquals($value, $afterFrValue);
	}

	public function testAddValueWhenLanguageIsNotReference() {
		$getTargetedValue = static function (I18nData $data, string $language) {
			return $data->getData()[$language]['file2.php']['file2.l1.l2.k2'];
		};

		$rawData = array_merge($this->referenceData, [
			'fr' => [],
		]);
		$data = new I18nData($rawData);
		$beforeEnValue = $getTargetedValue($data, 'en');
		$beforeFrValue = $getTargetedValue($data, 'fr');
		$data->addValue('file2.l1.l2.k2', 'new value', 'fr');
		$afterEnValue = $getTargetedValue($data, 'en');
		$afterFrValue = $getTargetedValue($data, 'fr');

		$this->assertEquals($this->value, $beforeEnValue);
		$this->assertEquals($this->value, $beforeFrValue);
		$this->assertEquals($this->value, $afterEnValue);
		$this->assertInstanceOf(I18nValue::class, $afterFrValue);
		$this->assertEquals('new value', $afterFrValue->getValue());
	}

	public function testRemoveKeyWhenKeyDoesNotExist() {
		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('The selected key does not exist.');
		$data = new I18nData($this->referenceData);
		$data->removeKey('Unknown key');
	}

	public function testRemoveKeyWhenKeyHasNoEmptySibling() {
		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('The selected key does not exist.');
		$data = new I18nData($this->referenceData);
		$data->removeKey('file1.l1.l2');
	}

	public function testRemoveKeyWhenKeyIsEmptySibling() {
		$rawData = array_merge($this->referenceData, [
			'fr' => [],
		]);
		$data = new I18nData($rawData);
		$data->removeKey('file2.l1.l2');
		$this->assertEquals([
			'en' => [
				'file1.php' => [
					'file1.l1.l2.k1' => $this->value,
					'file1.l1.l2.k2' => $this->value,
				],
				'file2.php' => [
					'file2.l1.l2.k1' => $this->value,
					'file2.l1.l2.k2' => $this->value,
				],
				'file3.php' => [
					'file3.l1.l2._' => $this->value,
					'file3.l1.l2.k1' => $this->value,
				],
			],
			'fr' => [
				'file1.php' => [
					'file1.l1.l2.k1' => $this->value,
					'file1.l1.l2.k2' => $this->value,
				],
				'file2.php' => [
					'file2.l1.l2.k1' => $this->value,
					'file2.l1.l2.k2' => $this->value,
				],
				'file3.php' => [
					'file3.l1.l2._' => $this->value,
					'file3.l1.l2.k1' => $this->value,
				],
			],
		], $data->getData());
	}

	public function testRemoveKeyWhenKeyIsTheOnlyChild() {
		$rawData = array_merge($this->referenceData, [
			'fr' => [],
		]);
		$data = new I18nData($rawData);
		$data->removeKey('file3.l1.l2.k1');
		$this->assertEquals([
			'en' => [
				'file1.php' => [
					'file1.l1.l2.k1' => $this->value,
					'file1.l1.l2.k2' => $this->value,
				],
				'file2.php' => [
					'file2.l1.l2._' => $this->value,
					'file2.l1.l2.k1' => $this->value,
					'file2.l1.l2.k2' => $this->value,
				],
				'file3.php' => [
					'file3.l1.l2' => $this->value,
				],
			],
			'fr' => [
				'file1.php' => [
					'file1.l1.l2.k1' => $this->value,
					'file1.l1.l2.k2' => $this->value,
				],
				'file2.php' => [
					'file2.l1.l2._' => $this->value,
					'file2.l1.l2.k1' => $this->value,
					'file2.l1.l2.k2' => $this->value,
				],
				'file3.php' => [
					'file3.l1.l2' => $this->value,
				],
			],
		], $data->getData());
	}

	public function testIgnore() {
		$value = $this->getMockBuilder(I18nValue::class)
			->disableOriginalConstructor()
			->getMock();
		$value->expects($this->exactly(2))
			->method('unmarkAsIgnore');
		$value->expects($this->once())
			->method('markAsIgnore');

		$rawData = array_merge($this->referenceData, [
			'fr' => [
				'file1.php' => [
					'file1.l1.l2.k1' => $value,
				],
			],
		]);
		$data = new I18nData($rawData);
		$data->ignore('file1.l1.l2.k1', 'fr');
		$data->ignore('file1.l1.l2.k1', 'fr', true);
		$data->ignore('file1.l1.l2.k1', 'fr', false);
	}

	public function testIgnoreUnmodified() {
		$value = $this->getMockBuilder(I18nValue::class)
			->disableOriginalConstructor()
			->getMock();
		$value->expects($this->exactly(2))
			->method('unmarkAsIgnore');
			$value->expects($this->once())
			->method('markAsIgnore');

		$this->value->expects($this->atLeast(2))
			->method('equal')
			->with($value)
			->willReturn(true);

		$rawData = array_merge($this->referenceData, [
			'fr' => [
				'file1.php' => [
					'file1.l1.l2.k1' => $value,
				],
			],
		]);
		$data = new I18nData($rawData);
		$data->ignore_unmodified('fr');
		$data->ignore_unmodified('fr', true);
		$data->ignore_unmodified('fr', false);
	}

	public function testGetLanguage() {
		$rawData = array_merge($this->referenceData, [
			'fr' => [],
			'nl' => [],
		]);
		$data = new I18nData($rawData);
		$this->assertEquals($this->referenceData['en'], $data->getLanguage('en'));
	}

	public function testGetReferenceLanguage() {
		$rawData = array_merge($this->referenceData, [
			'fr' => [],
			'nl' => [],
		]);
		$data = new I18nData($rawData);
		$this->assertEquals($this->referenceData['en'], $data->getReferenceLanguage());
	}
}
