<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class FeedTest extends TestCase {

	#[\Override]
	protected function setUp(): void {
		FreshRSS_Context::initSystem();
	}

	private static function feedXml(string $itemInner): string {
		return <<<XML
			<?xml version="1.0" encoding="UTF-8"?>
			<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/">
				<channel>
					<title>Test feed</title>
					<link>https://example.net/</link>
					<item>
						<title>Test item</title>
						<link>https://example.net/article</link>
						<guid>https://example.net/article</guid>
						{$itemInner}
					</item>
				</channel>
			</rss>
			XML;
	}

	/** @return list<array<mixed>> */
	private static function loadEnclosures(string $xml): array {
		$simplePie = new FreshRSS_SimplePieCustom();
		$simplePie->enable_cache(false);
		$simplePie->set_raw_data($xml);
		$simplePie->init();

		$feed = new FreshRSS_Feed('https://example.net/feed.xml');
		$enclosures = null;
		foreach ($feed->loadEntries($simplePie) as $entry) {
			$enclosures = $entry->attributeArray('enclosures');
			break;
		}
		self::assertIsArray($enclosures);
		$result = [];
		foreach ($enclosures as $enclosure) {
			self::assertIsArray($enclosure);
			$result[] = $enclosure;
		}
		return $result;
	}

	public function test_loadEntries_mediaGroup_keepsOnlyDefaultContent(): void {
		$enclosures = self::loadEnclosures(self::feedXml(<<<XML
			<media:group>
				<media:content type="video/mp4" medium="video" height="1080" url="https://example.net/video-1080.mp4" isDefault="false"/>
				<media:content type="video/mp4" medium="video" height="720" url="https://example.net/video-720.mp4" isDefault="true"/>
				<media:content type="video/mp4" medium="video" height="480" url="https://example.net/video-480.mp4" isDefault="false"/>
			</media:group>
			XML));
		self::assertCount(1, $enclosures);
		self::assertSame('https://example.net/video-720.mp4', $enclosures[0]['url']);
	}

	public function test_loadEntries_mediaGroup_keepsFirstContentWhenNoDefault(): void {
		$enclosures = self::loadEnclosures(self::feedXml(<<<XML
			<media:group>
				<media:content type="video/mp4" medium="video" height="1080" url="https://example.net/video-1080.mp4"/>
				<media:content type="video/mp4" medium="video" height="720" url="https://example.net/video-720.mp4"/>
			</media:group>
			XML));
		self::assertCount(1, $enclosures);
		self::assertSame('https://example.net/video-1080.mp4', $enclosures[0]['url']);
	}

	public function test_loadEntries_mediaGroup_keepsSingleContent(): void {
		$enclosures = self::loadEnclosures(self::feedXml(<<<XML
			<media:group>
				<media:content type="video/mp4" medium="video" url="https://example.net/video.mp4"/>
			</media:group>
			XML));
		self::assertCount(1, $enclosures);
		self::assertSame('https://example.net/video.mp4', $enclosures[0]['url']);
	}

	public function test_loadEntries_mediaGroup_keepsIndependentEnclosures(): void {
		$enclosures = self::loadEnclosures(self::feedXml(<<<XML
			<enclosure url="https://example.net/podcast.mp3" length="1234" type="audio/mpeg"/>
			<media:group>
				<media:content type="video/mp4" medium="video" url="https://example.net/video-1080.mp4" isDefault="true"/>
				<media:content type="video/mp4" medium="video" url="https://example.net/video-720.mp4"/>
			</media:group>
			XML));
		$urls = array_column($enclosures, 'url');
		sort($urls);
		self::assertSame(['https://example.net/podcast.mp3', 'https://example.net/video-1080.mp4'], $urls);
	}
}
