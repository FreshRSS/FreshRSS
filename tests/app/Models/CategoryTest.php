<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

final class CategoryTest extends \PHPUnit\Framework\TestCase {
	private ?FreshRSS_UserConfiguration $previousUserConf = null;

	#[\Override]
	protected function setUp(): void {
		$this->previousUserConf = FreshRSS_Context::hasUserConf() ? FreshRSS_Context::userConf() : null;
		$userConf = $this->previousUserConf instanceof FreshRSS_UserConfiguration ?
			clone $this->previousUserConf : clone FreshRSS_UserConfiguration::default();
		FreshRSS_Context::setUserConf($userConf);
	}

	#[\Override]
	protected function tearDown(): void {
		FreshRSS_Context::setUserConf($this->previousUserConf);
	}

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
		FreshRSS_Context::userConf()->sidebar_sort_feeds_by = 'alpha';

		$feed_1 = $this->mockFeed(1, 'AAA');
		$feed_2 = $this->mockFeed(2, 'ZZZ');
		$feed_3 = $this->mockFeed(3, 'lll');

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

		$feed_4 = $this->mockFeed(4, 'BBB');

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

	public function test_feedOrderingByUnreadCount(): void {
		FreshRSS_Context::userConf()->sidebar_sort_feeds_by = 'unread';

		$category = new FreshRSS_Category('test', 0, [
			$this->mockFeed(1, 'CCC', 3),
			$this->mockFeed(2, 'AAA', 8),
			$this->mockFeed(3, 'BBB', 8),
			$this->mockFeed(4, 'DDD', 0),
		]);
		$feeds = $category->feeds();

		self::assertCount(4, $feeds);
		self::assertSame('AAA', (reset($feeds) ?: FreshRSS_Feed::default())->name());
		self::assertSame('BBB', (next($feeds) ?: FreshRSS_Feed::default())->name());
		self::assertSame('CCC', (next($feeds) ?: FreshRSS_Feed::default())->name());
		self::assertSame('DDD', (next($feeds) ?: FreshRSS_Feed::default())->name());
	}

	/** @return FreshRSS_Feed&PHPUnit\Framework\MockObject\MockObject */
	private function mockFeed(int $id, string $name, int $nbNotRead = 0): FreshRSS_Feed {
		$feed = $this->getMockBuilder(FreshRSS_Feed::class)
			->disableOriginalConstructor()
			->getMock();
		$feed->method('id')->withAnyParameters()->willReturn($id);
		$feed->expects(self::any())
			->method('name')
			->willReturn($name);
		$feed->expects(self::any())
			->method('nbNotRead')
			->willReturn($nbNotRead);

		return $feed;
	}
}
