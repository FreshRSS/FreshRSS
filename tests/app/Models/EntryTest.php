<?php
declare(strict_types=1);

final class EntryTest extends \PHPUnit\Framework\TestCase {
	public static function testLoadCompleteContentFiltersContentWithCssSelector(): void {
		$feed = new FreshRSS_Feed('https://example.net/', false);
		$feed->_attribute('path_entries_filter', '.remove');
		$entry = new FreshRSS_Entry(0, 'guid', 'Title', '', '<div><p class="remove">Remove</p><p>Keep</p></div>');
		$entry->_feed($feed);

		self::assertTrue($entry->loadCompleteContent());
		self::assertStringNotContainsString('Remove', $entry->content(false));
		self::assertStringContainsString('Keep', $entry->content(false));
	}
}
