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

	public static function testFeedHtmlAttributesHookUsesAccumulateStringSignature(): void {
		self::assertSame(Minz_HookSignature::AccumulateString, Minz_HookType::FeedHtmlAttributes->signature());
	}

	public static function testFeedHtmlAttributesHookPassesFeedAndAccumulatesAttributesFromMultipleExtensions(): void {
		$feed = new FreshRSS_Feed('https://example.net/', false);
		$seen_feeds = [];

		Minz_ExtensionManager::addHook(
			Minz_HookType::FeedHtmlAttributes,
			static function (FreshRSS_Feed $feed, string $attributes) use (&$seen_feeds): string {
				$seen_feeds[] = $feed;
				return trim($attributes . ' data-one="1"');
			}
		);
		Minz_ExtensionManager::addHook(
			Minz_HookType::FeedHtmlAttributes,
			static function (FreshRSS_Feed $feed, string $attributes) use (&$seen_feeds): string {
				$seen_feeds[] = $feed;
				return trim($attributes . ' data-two="2"');
			}
		);

		$result = Minz_ExtensionManager::callHook(Minz_HookType::FeedHtmlAttributes, $feed);

		self::assertSame([$feed, $feed], $seen_feeds);
		self::assertSame('data-one="1" data-two="2"', $result);
	}

	public static function testCategoryHtmlAttributesHookUsesAccumulateStringSignature(): void {
		self::assertSame(Minz_HookSignature::AccumulateString, Minz_HookType::CategoryHtmlAttributes->signature());
	}

	public static function testCategoryHtmlAttributesHookPassesCategoryAndAccumulatesAttributesFromMultipleExtensions(): void {
		$category = new FreshRSS_Category('Example category');
		$seen_categories = [];

		Minz_ExtensionManager::addHook(
			Minz_HookType::CategoryHtmlAttributes,
			static function (FreshRSS_Category $category, string $attributes) use (&$seen_categories): string {
				$seen_categories[] = $category;
				return trim($attributes . ' data-one="1"');
			}
		);
		Minz_ExtensionManager::addHook(
			Minz_HookType::CategoryHtmlAttributes,
			static function (FreshRSS_Category $category, string $attributes) use (&$seen_categories): string {
				$seen_categories[] = $category;
				return trim($attributes . ' data-two="2"');
			}
		);

		$result = Minz_ExtensionManager::callHook(Minz_HookType::CategoryHtmlAttributes, $category);

		self::assertSame([$category, $category], $seen_categories);
		self::assertSame('data-one="1" data-two="2"', $result);
	}
}
