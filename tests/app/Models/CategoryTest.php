<?php

class CategoryTest extends PHPUnit\Framework\TestCase {

	public function test__construct_whenNoParameters_createsObjectWithDefaultValues() {
		$category = new Category();
		$this->assertEquals(0, $category->id());
		$this->assertEquals('', $category->name());
	}

	/**
	 * @param string $input
	 * @param string $expected
	 * @dataProvider provideValidNames
	 */
	public function test_name_whenValidValue_storesModifiedValue($input, $expected) {
		$category = new Category($input);
		$this->assertEquals($expected, $category->name());
	}

	public function provideValidNames() {
		return array(
			array('', ''),
			array('this string does not need trimming', 'this string does not need trimming'),
			array('  this string needs trimming on left', 'this string needs trimming on left'),
			array('this string needs trimming on right  ', 'this string needs trimming on right'),
			array('  this string needs trimming on both ends  ', 'this string needs trimming on both ends'),
			array(str_repeat('This string needs to be shortened because its length is way too long. ', 4), str_repeat('This string needs to be shortened because its length is way too long. ', 3) . 'This string needs to be shortened because its'),
		);
	}

}
