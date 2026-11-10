<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

final class CategoryTest extends \PHPUnit\Framework\TestCase {

	public static function test__construct_whenNoParameters_createsObjectWithDefaultValues(): void {
		$category = new FreshRSS_Category();
		self::assertSame(0, $category->id());
		self::assertSame('', $category->name());
	}

	#[DataProvider('provideValidNames')]
	public static function test_name_whenValidValue_storesModifiedValue(string $input, string $expected): void {
		$category = new FreshRSS_Category($input);
		self::assertSame($expected, $category->name());
	}

	/** @return list<array{string,string}> */
	public static function provideValidNames(): array {
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
		$feed_1->method('id')->withAnyParameters()->willReturn(1);
		$feed_1->expects(self::any())
			->method('name')
			->willReturn('AAA');

		$feed_2 = $this->getMockBuilder(FreshRSS_Feed::class)
			->disableOriginalConstructor()
			->getMock();
		$feed_2->method('id')->withAnyParameters()->willReturn(2);
		$feed_2->expects(self::any())
			->method('name')
			->willReturn('ZZZ');

		$feed_3 = $this->getMockBuilder(FreshRSS_Feed::class)
			->disableOriginalConstructor()
			->getMock();
		$feed_3->method('id')->withAnyParameters()->willReturn(3);
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
		self::assertSame('AAA', $feed->name());
		$feed = next($feeds) ?: FreshRSS_Feed::default();
		self::assertSame('lll', $feed->name());
		$feed = next($feeds) ?: FreshRSS_Feed::default();
		self::assertSame('ZZZ', $feed->name());

		/** @var FreshRSS_Feed&PHPUnit\Framework\MockObject\MockObject */
		$feed_4 = $this->getMockBuilder(FreshRSS_Feed::class)
			->disableOriginalConstructor()
			->getMock();
		$feed_4->method('id')->withAnyParameters()->willReturn(4);
		$feed_4->expects(self::any())
			->method('name')
			->willReturn('BBB');
		$feed_4->method('id')->withAnyParameters()->willReturn(5);

		$category->addFeed($feed_4);
		$feeds = $category->feeds();

		self::assertCount(4, $feeds);
		$feed = reset($feeds) ?: FreshRSS_Feed::default();
		self::assertSame('AAA', $feed->name());
		$feed = next($feeds) ?: FreshRSS_Feed::default();
		self::assertSame('BBB', $feed->name());
		$feed = next($feeds) ?: FreshRSS_Feed::default();
		self::assertSame('lll', $feed->name());
		$feed = next($feeds) ?: FreshRSS_Feed::default();
		self::assertSame('ZZZ', $feed->name());
	}
}
