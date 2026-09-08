<?php
declare(strict_types=1);

final class EntryTest extends \PHPUnit\Framework\TestCase {

	#[\Override]
	public static function setUpBeforeClass(): void {
		FreshRSS_Context::initSystem();
	}

	/**
	 * Parse a raw RSS payload through the real feed processing pipeline.
	 * @return list<FreshRSS_Entry>
	 */
	private static function entriesFromRss(string $rss): array {
		$feed = new FreshRSS_Feed('http://example.net/feed.xml', validate: false);
		$feed->_id(1);
		$simplePie = new FreshRSS_SimplePieCustom();
		$simplePie->enable_cache(false);
		$simplePie->set_raw_data($rss);
		self::assertTrue($simplePie->init());
		return array_values(iterator_to_array($feed->loadEntries($simplePie)));
	}

	public function test_content_dropsUnsafeEnclosureUrls(): void {
		$rss = <<<XML
			<?xml version="1.0" encoding="UTF-8"?>
			<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/">
				<channel>
					<title>Malicious feed</title>
					<link>https://example.net/</link>
					<description>Feed with malicious enclosure URLs</description>
					<item>
						<title>Victim Article</title>
						<link>https://example.net/article</link>
						<guid isPermaLink="false">poc-001</guid>
						<pubDate>Tue, 14 Nov 2023 20:13:20 +0000</pubDate>
						<description>Hello</description>
						<enclosure url="javascript:alert(document.domain)//" length="0" type="application/octet-stream" />
						<enclosure url="https://example.com/podcast.mp3" length="1234" type="audio/mpeg" />
						<media:content url="https://example.com/pic.jpg" type="image/jpeg">
							<media:thumbnail url="javascript:alert(1)" />
							<media:thumbnail url="https://example.com/thumb.jpg" />
						</media:content>
						<media:thumbnail url="javascript:alert(2)" />
					</item>
				</channel>
			</rss>
			XML;

		$entries = self::entriesFromRss($rss);
		self::assertCount(1, $entries);
		$entry = $entries[0];
		self::assertSame('Victim Article', $entry->title());

		// The malicious enclosure must not even be stored as an attribute
		$enclosureUrls = array_column($entry->attributeArray('enclosures') ?? [], 'url');
		self::assertNotContains('javascript:alert(document.domain)//', $enclosureUrls);
		self::assertContains('https://example.com/podcast.mp3', $enclosureUrls);

		$html = $entry->content();

		self::assertStringNotContainsString('javascript:', $html);
		self::assertStringContainsString('href="https://example.com/podcast.mp3"', $html);
		self::assertStringContainsString('src="https://example.com/thumb.jpg"', $html);
		self::assertStringContainsString('Hello', $html);
	}

	public function test_content_dropsUnsafeThumbnailAttribute(): void {
		$rss = <<<XML
			<?xml version="1.0" encoding="UTF-8"?>
			<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/">
				<channel>
					<title>Malicious feed</title>
					<link>https://example.net/</link>
					<description>Feed with a malicious thumbnail URL</description>
					<item>
						<title>Victim Article</title>
						<link>https://example.net/article</link>
						<guid isPermaLink="false">poc-002</guid>
						<pubDate>Tue, 14 Nov 2023 20:13:20 +0000</pubDate>
						<description>Hello</description>
						<media:thumbnail url="javascript:alert(2)" />
					</item>
				</channel>
			</rss>
			XML;

		$entries = self::entriesFromRss($rss);
		self::assertCount(1, $entries);
		$entry = $entries[0];

		// The malicious thumbnail must not be stored as an attribute
		self::assertNull($entry->attributeArray('thumbnail'));

		$html = $entry->content();

		self::assertStringNotContainsString('javascript:', $html);
		self::assertStringContainsString('Hello', $html);
	}
}
