<?php

require_once __DIR__ . '/../../../cli/i18n/I18nData.php';
require_once __DIR__ . '/../../../cli/i18n/I18nValue.php';

class I18nDataTest extends PHPUnit\Framework\TestCase {
	/** @var array<string,array<string,array<string,I18nValue>>> */
	private array $referenceData;
	/** @var I18nValue&PHPUnit\Framework\MockObject\MockObject */
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

	public function testConstructWhenReferenceOnly(): void {
		$data = new I18nData($this->referenceData);
		self::assertEquals($this->referenceData, $data->getData());
	}

	public function testConstructorWhenLanguageIsMissingFile(): void {
		$rawData = array_merge($this->referenceData, [
			'fr' => [
				'file1.php' => [
					'file1.l1.l2.k1' => $this->value,
				],
			],
		]);
		$data = new I18nData($rawData);
		self::assertEquals([
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

	public function testConstructorWhenLanguageIsMissingKeys(): void {
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
		self::assertEquals([
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

	public function testConstructorWhenLanguageHasExtraKeys(): void {
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
		self::assertEquals([
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

	public function testConstructorWhenValueIsIdenticalAndIsMarkedAsIgnore(): void {
		$value = $this->getMockBuilder(I18nValue::class)
			->disableOriginalConstructor()
			->getMock();
		$value->expects(self::exactly(2))
			->method('isIgnore')
			->willReturn(true);
		$value->expects(self::never())
			->method('markAsTodo');
		$value->expects(self::exactly(3))
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

	public function testConstructorWhenValueIsIdenticalAndIsNotMarkedAsIgnore(): void {
		$value = $this->getMockBuilder(I18nValue::class)
			->disableOriginalConstructor()
			->getMock();
		$value->expects(self::exactly(2))
			->method('isIgnore')
			->willReturn(false);
		$value->expects(self::exactly(2))
			->method('markAsTodo');
		$value->expects(self::exactly(2))
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

	public function testConstructorWhenValueIsDifferentAndIsMarkedAsToDo(): void {
		$value = $this->getMockBuilder(I18nValue::class)
			->disableOriginalConstructor()
			->getMock();
		$value->expects(self::once())
			->method('isTodo')
			->willReturn(true);
		$value->expects(self::once())
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

	public function testConstructorWhenValueIsDifferentAndIsNotMarkedAsTodo(): void {
		$value = $this->getMockBuilder(I18nValue::class)
			->disableOriginalConstructor()
			->getMock();
		$value->expects(self::once())
			->method('isTodo')
			->willReturn(false);
		$value->expects(self::never())
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

	public function testGetAvailableLanguagesWhenTheyAreSorted(): void {
		$rawData = array_merge($this->referenceData, [
			'fr' => [],
			'nl' => [],
		]);
		$data = new I18nData($rawData);
		self::assertEquals([
			'en',
			'fr',
			'nl',
		], $data->getAvailableLanguages());
	}

	public function testGetAvailableLanguagesWhenTheyAreNotSorted(): void {
		$rawData = array_merge($this->referenceData, [
			'nl' => [],
			'fr' => [],
			'de' => [],
		]);
		$data = new I18nData($rawData);
		self::assertEquals([
			'de',
			'en',
			'fr',
			'nl',
		], $data->getAvailableLanguages());
	}

	public function testAddLanguageWhenLanguageExists(): void {
		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('The selected language already exist.');
		$data = new I18nData($this->referenceData);
		$data->addLanguage('en');
	}

	public function testAddLanguageWhenNoReferenceProvided(): void {
		$data = new I18nData($this->referenceData);
		$data->addLanguage('fr');
		self::assertEquals([
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

	public function testAddLanguageWhenUnknownReferenceProvided(): void {
		$data = new I18nData($this->referenceData);
		$data->addLanguage('fr', 'unknown');
		self::assertEquals([
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

	public function testAddLanguageWhenKnownReferenceProvided(): void {
		$data = new I18nData($this->referenceData);
		$data->addLanguage('fr', 'en');
		self::assertEquals([
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

	public function testIsKnownWhenKeyExists(): void {
		$data = new I18nData($this->referenceData);
		self::assertTrue($data->isKnown('file2.l1.l2.k2'));
	}

	public function testIsKnownWhenKeyDoesNotExist(): void {
		$data = new I18nData($this->referenceData);
		self::assertFalse($data->isKnown('file2.l1.l2.k3'));
	}

	public function testAddKeyWhenKeyExists(): void {
		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('The selected key already exist.');
		$data = new I18nData($this->referenceData);
		$data->addKey('file2.l1.l2.k1', 'value');
	}

	public function testAddKeyWhenParentKeyExists(): void {
		$rawData = array_merge($this->referenceData, [
			'fr' => [],
		]);

		$data = new I18nData($rawData);
		self::assertTrue($data->isKnown('file2.l1.l2.k1'));
		self::assertFalse($data->isKnown('file2.l1.l2.k1._'));
		self::assertFalse($data->isKnown('file2.l1.l2.k1.sk1'));
		$data->addKey('file2.l1.l2.k1.sk1', 'value');
		self::assertFalse($data->isKnown('file2.l1.l2.k1'));
		self::assertTrue($data->isKnown('file2.l1.l2.k1._'));
		self::assertTrue($data->isKnown('file2.l1.l2.k1.sk1'));
	}

	public function testAddKeyWhenKeyIsParent(): void {
		$rawData = array_merge($this->referenceData, [
			'fr' => [],
		]);

		$data = new I18nData($rawData);
		self::assertFalse($data->isKnown('file1.l1.l2._'));
		self::assertTrue($data->isKnown('file1.l1.l2.k1'));
		self::assertTrue($data->isKnown('file1.l1.l2.k2'));
		$data->addKey('file1.l1.l2', 'value');
		self::assertTrue($data->isKnown('file1.l1.l2._'));
		self::assertTrue($data->isKnown('file1.l1.l2.k1'));
		self::assertTrue($data->isKnown('file1.l1.l2.k2'));
	}

	public function testAddKey(): void {
		$getTargetedValue = static function (I18nData $data, string $language) {
			return $data->getData()[$language]['file2.php']['file2.l1.l2.k3'];
		};

		$rawData = array_merge($this->referenceData, [
			'fr' => [],
		]);

		$data = new I18nData($rawData);
		self::assertFalse($data->isKnown('file2.l1.l2.k3'));
		$data->addKey('file2.l1.l2.k3', 'value');
		self::assertTrue($data->isKnown('file2.l1.l2.k3'));

		$enValue = $getTargetedValue($data, 'en');
		$frValue = $getTargetedValue($data, 'fr');
		self::assertInstanceOf(I18nValue::class, $enValue);
		self::assertEquals('value', $enValue->getValue());
		self::assertTrue($enValue->isTodo());
		self::assertEquals($frValue, $enValue);
	}

	public function testAddValueWhenLanguageDoesNotExist(): void {
		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('The selected language does not exist.');
		$data = new I18nData($this->referenceData);
		$data->addValue('file2.l1.l2.k2', 'new value', 'fr');
	}

	public function testAddValueWhenKeyDoesNotExist(): void {
		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('The selected key does not exist for the selected language.');
		$data = new I18nData($this->referenceData);
		$data->addValue('unknown key', 'new value', 'en');
	}

	public function testAddValueWhenLanguageIsReferenceAndValueInOtherLanguageHasNotChange(): void {
		$getTargetedValue = static function (I18nData $data, string $language) {
			return $data->getData()[$language]['file2.php']['file2.l1.l2.k2'];
		};

		$this->value->expects(self::atLeast(2))
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

		self::assertEquals($this->value, $beforeEnValue);
		self::assertEquals($this->value, $beforeFrValue);
		self::assertInstanceOf(I18nValue::class, $afterEnValue);
		self::assertEquals('new value', $afterEnValue->getValue());
		self::assertInstanceOf(I18nValue::class, $afterFrValue);
		self::assertEquals('new value', $afterFrValue->getValue());
	}

	public function testAddValueWhenLanguageIsReferenceAndValueInOtherLanguageHasChange(): void {
		$getTargetedValue = static function (I18nData $data, string $language) {
			return $data->getData()[$language]['file2.php']['file2.l1.l2.k2'];
		};

		$this->value->expects(self::any())
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

		self::assertEquals($this->value, $beforeEnValue);
		self::assertEquals($value, $beforeFrValue);
		self::assertInstanceOf(I18nValue::class, $afterEnValue);
		self::assertEquals('new value', $afterEnValue->getValue());
		self::assertEquals($value, $afterFrValue);
	}

	public function testAddValueWhenLanguageIsNotReference(): void {
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

		self::assertEquals($this->value, $beforeEnValue);
		self::assertEquals($this->value, $beforeFrValue);
		self::assertEquals($this->value, $afterEnValue);
		self::assertInstanceOf(I18nValue::class, $afterFrValue);
		self::assertEquals('new value', $afterFrValue->getValue());
	}

	public function testRemoveKeyWhenKeyDoesNotExist(): void {
		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('The selected key does not exist.');
		$data = new I18nData($this->referenceData);
		$data->removeKey('Unknown key');
	}

	public function testRemoveKeyWhenKeyHasNoEmptySibling(): void {
		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('The selected key does not exist.');
		$data = new I18nData($this->referenceData);
		$data->removeKey('file1.l1.l2');
	}

	public function testRemoveKeyWhenKeyIsEmptySibling(): void {
		$rawData = array_merge($this->referenceData, [
			'fr' => [],
		]);
		$data = new I18nData($rawData);
		$data->removeKey('file2.l1.l2');
		self::assertEquals([
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

	public function testRemoveKeyWhenKeyIsTheOnlyChild(): void {
		$rawData = array_merge($this->referenceData, [
			'fr' => [],
		]);
		$data = new I18nData($rawData);
		$data->removeKey('file3.l1.l2.k1');
		self::assertEquals([
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

	public function testIgnore(): void {
		$value = $this->getMockBuilder(I18nValue::class)
			->disableOriginalConstructor()
			->getMock();
		$value->expects(self::exactly(2))
			->method('unmarkAsIgnore');
		$value->expects(self::once())
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

	public function testIgnoreUnmodified(): void {
		$value = $this->getMockBuilder(I18nValue::class)
			->disableOriginalConstructor()
			->getMock();
		$value->expects(self::exactly(2))
			->method('unmarkAsIgnore');
			$value->expects(self::once())
			->method('markAsIgnore');

		$this->value->expects(self::atLeast(2))
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

	public function testGetLanguage(): void {
		$rawData = array_merge($this->referenceData, [
			'fr' => [],
			'nl' => [],
		]);
		$data = new I18nData($rawData);
		self::assertEquals($this->referenceData['en'], $data->getLanguage('en'));
	}

	public function testGetReferenceLanguage(): void {
		$rawData = array_merge($this->referenceData, [
			'fr' => [],
			'nl' => [],
		]);
		$data = new I18nData($rawData);
		self::assertEquals($this->referenceData['en'], $data->getReferenceLanguage());
	}
}
