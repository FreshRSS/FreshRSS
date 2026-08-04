<?php
declare(strict_types=1);

use FreshRss\Models\Category;
use FreshRss\Models\DatabaseDAO;
use FreshRss\Models\Feed;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class CategoryTest extends TestCase {

	public static function test__construct_whenNoParameters_createsObjectWithDefaultValues(): void {
		$category = new Category();
		self::assertSame(0, $category->id());
		self::assertSame('', $category->name());
	}

	#[DataProvider('provideValidNames')]
	public static function test_name_whenValidValue_storesModifiedValue(string $input, string $expected): void {
		$category = new Category($input);
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
			[str_repeat('X', 512), str_repeat('X', DatabaseDAO::LENGTH_INDEX_UNICODE)],    // max length
		];
	}

	public function test_feedOrdering(): void {
		$feed_1 = $this->getMockBuilder(Feed::class)
			->disableOriginalConstructor()
			->getMock();
		$feed_1->method('id')->withAnyParameters()->willReturn(1);
		$feed_1->expects(self::any())
			->method('name')
			->willReturn('AAA');

		$feed_2 = $this->getMockBuilder(Feed::class)
			->disableOriginalConstructor()
			->getMock();
		$feed_2->method('id')->withAnyParameters()->willReturn(2);
		$feed_2->expects(self::any())
			->method('name')
			->willReturn('ZZZ');

		$feed_3 = $this->getMockBuilder(Feed::class)
			->disableOriginalConstructor()
			->getMock();
		$feed_3->method('id')->withAnyParameters()->willReturn(3);
		$feed_3->expects(self::any())
			->method('name')
			->willReturn('lll');

		$category = new Category('test', 0, [
			$feed_1,
			$feed_2,
			$feed_3,
		]);
		$feeds = $category->feeds();

		self::assertCount(3, $feeds);
		$feed = reset($feeds) ?: Feed::default();
		self::assertSame('AAA', $feed->name());
		$feed = next($feeds) ?: Feed::default();
		self::assertSame('lll', $feed->name());
		$feed = next($feeds) ?: Feed::default();
		self::assertSame('ZZZ', $feed->name());

		/** @var Feed&PHPUnit\Framework\MockObject\MockObject */
		$feed_4 = $this->getMockBuilder(Feed::class)
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
		$feed = reset($feeds) ?: Feed::default();
		self::assertSame('AAA', $feed->name());
		$feed = next($feeds) ?: Feed::default();
		self::assertSame('BBB', $feed->name());
		$feed = next($feeds) ?: Feed::default();
		self::assertSame('lll', $feed->name());
		$feed = next($feeds) ?: Feed::default();
		self::assertSame('ZZZ', $feed->name());
	}
}
