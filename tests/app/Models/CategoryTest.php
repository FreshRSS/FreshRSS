<?php

class CategoryTest extends PHPUnit\Framework\TestCase {

	public function test__construct_whenNoParameters_createsObjectWithDefaultValues(): void {
		$category = new FreshRSS_Category();
		$this->assertEquals(0, $category->id());
		$this->assertEquals('', $category->name());
	}

	/**
	 * @dataProvider provideValidNames
	 */
	public function test_name_whenValidValue_storesModifiedValue(string $input, string $expected): void {
		$category = new FreshRSS_Category($input);
		$this->assertEquals($expected, $category->name());
	}

	/** @return array<array{string,string}> */
	public function provideValidNames(): array {
		return array(
			array('', ''),
			array('this string does not need trimming', 'this string does not need trimming'),
			array('  this string needs trimming on left', 'this string needs trimming on left'),
			array('this string needs trimming on right  ', 'this string needs trimming on right'),
			array('  this string needs trimming on both ends  ', 'this string needs trimming on both ends'),
			array(str_repeat('This string needs to be shortened because its length is way too long. ', 4),
				str_repeat('This string needs to be shortened because its length is way too long. ', 3) . 'This string needs to be shortened because its'),
		);
	}

	public function test_feedOrdering(): void {
		$feed_1 = $this->getMockBuilder(FreshRSS_Feed::class)
			->disableOriginalConstructor()
			->getMock();
		$feed_1->expects($this->any())
			->method('name')
			->willReturn('AAA');

		$feed_2 = $this->getMockBuilder(FreshRSS_Feed::class)
			->disableOriginalConstructor()
			->getMock();
		$feed_2->expects($this->any())
			->method('name')
			->willReturn('ZZZ');

		$feed_3 = $this->getMockBuilder(FreshRSS_Feed::class)
			->disableOriginalConstructor()
			->getMock();
		$feed_3->expects($this->any())
			->method('name')
			->willReturn('lll');

		$category = new FreshRSS_Category('test', [
			$feed_1,
			$feed_2,
			$feed_3,
		]);
		$feeds = $category->feeds();

		$this->assertCount(3, $feeds);
		$this->assertEquals('AAA', $feeds[0]->name());
		$this->assertEquals('lll', $feeds[1]->name());
		$this->assertEquals('ZZZ', $feeds[2]->name());

		$feed_4 = $this->getMockBuilder(FreshRSS_Feed::class)
			->disableOriginalConstructor()
			->getMock();
		$feed_4->expects($this->any())
			->method('name')
			->willReturn('BBB');

		$category->addFeed($feed_4);
		$feeds = $category->feeds();

		$this->assertCount(4, $feeds);
		$this->assertEquals('AAA', $feeds[0]->name());
		$this->assertEquals('BBB', $feeds[1]->name());
		$this->assertEquals('lll', $feeds[2]->name());
		$this->assertEquals('ZZZ', $feeds[3]->name());
	}
}
