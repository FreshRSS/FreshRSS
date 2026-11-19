<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

class HookTypeTest extends TestCase
{
	public static function testEntriesReadHookUsesPassArgumentsSignature(): void {
		self::assertSame(Minz_HookSignature::PassArguments, Minz_HookType::EntriesRead->signature());
	}

	public static function testEntriesReadHookPassesIdsAndReadState(): void {
		$actual_ids = [];
		$actual_is_read = null;

		Minz_ExtensionManager::addHook(
			Minz_HookType::EntriesRead,
			static function (array $ids, bool $is_read) use (&$actual_ids, &$actual_is_read): void {
				$actual_ids = $ids;
				$actual_is_read = $is_read;
			}
		);

		Minz_ExtensionManager::callHook(Minz_HookType::EntriesRead, ['123', '456'], false);

		self::assertSame(['123', '456'], $actual_ids);
		self::assertFalse($actual_is_read);
	}

	public static function testFeedsAfterActualizeHookUsesPassArgumentsSignature(): void {
		self::assertSame(Minz_HookSignature::PassArguments, Minz_HookType::FeedsAfterActualize->signature());
	}

	public static function testFeedsAfterActualizeHookPassesFeedsAndNewArticleCount(): void {
		$actual_feeds = null;
		$actual_count = null;
		$feed = new FreshRSS_Feed('https://example.net/feed.xml');

		Minz_ExtensionManager::addHook(
			Minz_HookType::FeedsAfterActualize,
			static function (array $feeds, int $nbNewArticles) use (&$actual_feeds, &$actual_count): void {
				$actual_feeds = $feeds;
				$actual_count = $nbNewArticles;
			}
		);

		Minz_ExtensionManager::callHook(Minz_HookType::FeedsAfterActualize, [$feed], 3);

		self::assertSame([$feed], $actual_feeds);
		self::assertSame(3, $actual_count);
	}
}
