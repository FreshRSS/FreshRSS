<?php
declare(strict_types=1);
use FreshRss\Minz\ExtensionManager;
use FreshRss\Minz\HookSignature;
use FreshRss\Minz\HookType;
use PHPUnit\Framework\TestCase;

class HookTypeTest extends TestCase
{
	public static function testEntriesReadHookUsesPassArgumentsSignature(): void {
		self::assertSame(HookSignature::PassArguments, HookType::EntriesRead->signature());
	}

	public static function testEntriesReadHookPassesIdsAndReadState(): void {
		$actual_ids = [];
		$actual_is_read = null;

		ExtensionManager::addHook(
			HookType::EntriesRead,
			static function (array $ids, bool $is_read) use (&$actual_ids, &$actual_is_read): void {
				$actual_ids = $ids;
				$actual_is_read = $is_read;
			}
		);

		ExtensionManager::callHook(HookType::EntriesRead, ['123', '456'], false);

		self::assertSame(['123', '456'], $actual_ids);
		self::assertFalse($actual_is_read);
	}
}
