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

	public function test_content_dropsUnsafeEnclosureAndThumbnailUrls(): void {
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
						<enclosure url="//cdn.example.com/podcast2.mp3" length="1234" type="audio/mpeg" />
						<media:content url="https://example.com/pic.jpg" type="image/jpeg">
							<media:thumbnail url="javascript:alert(1)" />
							<media:thumbnail url="https://example.com/thumb.jpg" />
							<media:thumbnail url="//cdn.example.com/thumb2.jpg" />
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

		// The malicious `<media:thumbnail>` of the item must not be stored as an attribute
		self::assertNull($entry->attributeArray('thumbnail'));

		// The malicious enclosure must not even be stored as an attribute
		$enclosureUrls = array_column($entry->attributeArray('enclosures') ?? [], 'url');
		self::assertNotContains('javascript:alert(document.domain)//', $enclosureUrls);
		self::assertContains('https://example.com/podcast.mp3', $enclosureUrls);
		// SimplePie must absolutise protocol-relative URLs against the feed URL
		self::assertContains('https://cdn.example.com/podcast2.mp3', $enclosureUrls);

		$html = $entry->content();

		self::assertStringNotContainsString('javascript:', $html);
		self::assertStringContainsString('href="https://example.com/podcast.mp3"', $html);
		self::assertStringContainsString('src="https://example.com/thumb.jpg"', $html);
		self::assertStringContainsString('href="https://cdn.example.com/podcast2.mp3"', $html);
		self::assertStringContainsString('src="https://cdn.example.com/thumb2.jpg"', $html);
		self::assertStringContainsString('Hello', $html);
	}

	public function test_content_dropsUnsafeUrlsFromLegacyAttributes(): void {
		$entry = new FreshRSS_Entry(1, 'poc-003', 'Victim Article', '', 'Hello', 'https://example.net/article');
		$entry->_attributes([
			'thumbnail' => ['url' => 'javascript:alert(1)'],
			'enclosures' => [
				['url' => 'javascript:alert(2)', 'title' => 'evil'],
				['url' => 'https://example.com/podcast.mp3', 'thumbnails' => ['javascript:alert(3)', 'https://example.com/thumb.jpg']],
			],
		]);

		$html = $entry->content();

		self::assertStringNotContainsString('javascript:', $html);
		self::assertStringContainsString('href="https://example.com/podcast.mp3"', $html);
		self::assertStringContainsString('src="https://example.com/thumb.jpg"', $html);
		self::assertStringContainsString('Hello', $html);
	}
}
