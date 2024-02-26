<?php
declare(strict_types=1);

class CategoryTest extends PHPUnit\Framework\TestCase {

	public function test__construct_whenNoParameters_createsObjectWithDefaultValues(): void {
		$category = new FreshRSS_Category();
		self::assertEquals(0, $category->id());
		self::assertEquals('', $category->name());
	}

	/**
	 * @dataProvider provideValidNames
	 */
	public function test_name_whenValidValue_storesModifiedValue(string $input, string $expected): void {
		$category = new FreshRSS_Category($input);
		self::assertEquals($expected, $category->name());
	}

	/** @return array<array{string,string}> */
	public function provideValidNames(): array {
		return [
			['', ''],
			['this string does not need trimming', 'this string does not need trimming'],
			['  this string needs trimming on left', 'this string needs trimming on left'],
			['this string needs trimming on right  ', 'this string needs trimming on right'],
			['  this string needs trimming on both ends  ', 'this string needs trimming on both ends'],
			[str_repeat('X', 512), str_repeat('X', FreshRSS_DatabaseDAO::LENGTH_INDEX_UNICODE)],    // max length
		];
	}

	public function test_feedOrdering(): void {
		$feed_1 = $this->getMockBuilder(FreshRSS_Feed::class)
			->disableOriginalConstructor()
			->getMock();
		$feed_1->expects(self::any())
			->method('name')
			->willReturn('AAA');

		$feed_2 = $this->getMockBuilder(FreshRSS_Feed::class)
			->disableOriginalConstructor()
			->getMock();
		$feed_2->expects(self::any())
			->method('name')
			->willReturn('ZZZ');

		$feed_3 = $this->getMockBuilder(FreshRSS_Feed::class)
			->disableOriginalConstructor()
			->getMock();
		$feed_3->expects(self::any())
			->method('name')
			->willReturn('lll');

		$category = new FreshRSS_Category('test', 0, [
			$feed_1,
			$feed_2,
			$feed_3,
		]);
		$feeds = $category->feeds();

		self::assertCount(3, $feeds);
		$feed = reset($feeds) ?: FreshRSS_Feed::default();
		self::assertEquals('AAA', $feed->name());
		$feed = next($feeds) ?: FreshRSS_Feed::default();
		self::assertEquals('lll', $feed->name());
		$feed = next($feeds) ?: FreshRSS_Feed::default();
		self::assertEquals('ZZZ', $feed->name());

		/** @var FreshRSS_Feed&PHPUnit\Framework\MockObject\MockObject */
		$feed_4 = $this->getMockBuilder(FreshRSS_Feed::class)
			->disableOriginalConstructor()
			->getMock();
		$feed_4->expects(self::any())
			->method('name')
			->willReturn('BBB');

		$category->addFeed($feed_4);
		$feeds = $category->feeds();

		self::assertCount(4, $feeds);
		$feed = reset($feeds) ?: FreshRSS_Feed::default();
		self::assertEquals('AAA', $feed->name());
		$feed = next($feeds) ?: FreshRSS_Feed::default();
		self::assertEquals('BBB', $feed->name());
		$feed = next($feeds) ?: FreshRSS_Feed::default();
		self::assertEquals('lll', $feed->name());
		$feed = next($feeds) ?: FreshRSS_Feed::default();
		self::assertEquals('ZZZ', $feed->name());
	}
}
