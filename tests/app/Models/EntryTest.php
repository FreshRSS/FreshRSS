<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

final class EntryTest extends \PHPUnit\Framework\TestCase {

	#[\Override]
	protected function setUp(): void {
		if (!FreshRSS_Context::hasSystemConf()) {
			FreshRSS_Context::initSystem();
		}
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

	/** ZIP/JSON export/import */
	public function test_toGReaderFreshRssExportRoundTripsEncoding(): void {
		$feed = new FreshRSS_Feed('http://example.net/feed.xml', validate: false);
		$feed->_id(1);
		$feed->_name('Feed &amp; me');

		$entry = new FreshRSS_Entry(1, 'tag:example.net,2026:1', 'A &amp; B', 'B &amp; C', 'Hello', 'https://example.net/post-1', 1731312000);
		$entry->_id('1731312000000000');
		$entry->_feed($feed);

		$item = $entry->toGReader('freshrss');
		self::assertSame('A &amp; B', $item['title']);
		self::assertSame('B &amp; C', $item['author']);
	}

	/** Above PHP_INT_MAX, an integer literal is a float on 32-bit platforms, so an entry ID is only ever a string */
	public function test_idRejectsAFloat(): void {
		$entry = new FreshRSS_Entry(1, 'guid-1', 'Title', '', '', 'https://example.net/1', 1700000000);
		$this->expectException(\TypeError::class);
		// @phpstan-ignore argument.type
		$entry->_id(1700000000000001.0);
	}

	/** @return array<string,array{string,string,string|null}> Content, expected, delimiter (null for the legacy markers) */
	public static function provideFullContent(): array {
		$start = '<!-- FULLCONTENT start //-->';
		$end = '<!-- FULLCONTENT end //-->';
		// Original content with copies of the legacy markers inside attribute values, as serialised by libxml2
		$original = '<p title="' . $start . '">Original</p> &amp; <b title=\'' . $end . '\'>content</b>';
		$cleanOriginal = '<p>Original</p> &amp; <b>content</b>';
		$cases = [];
		foreach ([null, '0123456789abcdef0123456789abcdef'] as $delimiter) {
			$label = $delimiter === null ? 'legacy' : 'delimited';
			$separator = $delimiter === null ? '' : " {$delimiter}";
			$full = "<!-- FULLCONTENT{$separator} start //--><p>Full</p><!-- FULLCONTENT{$separator} end //-->";
			$unpairedStart = "<!-- FULLCONTENT{$separator} start //-->Full";
			$cases = $cases + [
				"none $label" => [$cleanOriginal, $cleanOriginal, $delimiter],
				"prepend $label" => [$full . $original, $original, $delimiter],
				"append $label" => [$cleanOriginal . $full, $cleanOriginal, $delimiter],
				"replace $label" => [$full, '', $delimiter],
				// A lone start marker must not trigger an unsafe cut
				"unpaired start $label" => [$unpairedStart, $unpairedStart, $delimiter],
			];
			// (Delimited only) A legacy end comment cannot close a delimited start
			if ($delimiter !== null) {
				$cases["legacy end inside $label span"] = [
					"<!-- FULLCONTENT {$delimiter} start //-->Full" . $end . 'x' . "<!-- FULLCONTENT {$delimiter} end //-->",
					'',
					$delimiter,
				];
			}
		}
		return $cases;
	}

	#[DataProvider('provideFullContent')]
	public function test_originalContent_removesFullContent(string $content, string $expected, ?string $delimiter): void {
		$entry = new FreshRSS_Entry(1, 'guid', 'Title', '', $content, 'https://example.net/article');
		if ($delimiter !== null) {
			$entry->_attribute('full_content_delimiter', $delimiter);
		}
		self::assertSame($expected, $entry->originalContent());
	}

	/**
	 * Legacy full-content of legacy entries (unsafe) already in database.
	 */
	public function test_loadEntries_withMarkerEchoesInAttributesOfFeed(): void {
		$rss = <<<'XML'
			<?xml version="1.0" encoding="UTF-8"?>
			<rss version="2.0">
				<channel>
					<title>Feed</title>
					<link>https://example.net/</link>
					<item>
						<title>Article</title>
						<link>https://example.net/article</link>
						<guid isPermaLink="false">fullcontent-001</guid>
						<description><![CDATA[<p title="<!-- FULLCONTENT start //-->">Hello</p>
							<b title='<!-- FULLCONTENT end //-->" <!--="x"><form><button>x</button></form>-->'>bold</b>]]></description>
					</item>
				</channel>
			</rss>
			XML;

		$entries = self::entriesFromRss($rss);
		self::assertCount(1, $entries);

		// The legacy markers echoed in attribute values are still detected and cut at ingest
		self::assertStringNotContainsString('<!-- FULLCONTENT', $entries[0]->content(withEnclosures: false));
	}

	/**
	 * Test security of full-content markers for new content updates.
	 */
	public function test_originalContent_withForgedMarkersInNewContentUpdate(): void {
		$delimiter = bin2hex(random_bytes(16));

		// Attacker-forged content echoing the legacy markers inside attribute values, as serialised by libxml2
		$forged = '<p title="<!-- FULLCONTENT start //-->">Hello</p> &amp; ' .
			'<b title=\'<!-- FULLCONTENT end //-->" <!--="x"><form><button>x</button></form>-->\'>bold</b>';
		// Freshly fetched content wrapped by loadCompleteContent(), prepended to the original content
			$full = "<!-- FULLCONTENT {$delimiter} start //--><p>Full</p><!-- FULLCONTENT {$delimiter} end //-->";
		$entry = new FreshRSS_Entry(1, 'guid', 'Title', '', $full . $forged, 'https://example.net/article');
		$entry->_attribute('full_content_delimiter', $delimiter);

		// Only the span of the secret unique delimiter is cut; the forged markers are inert
		self::assertSame($forged, $entry->originalContent());

		// Re-parsing the remaining content must not enable any forged element
		$doc = new DOMDocument();
		self::assertTrue($doc->loadHTML('<meta charset="UTF-8">' . $forged, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING));
		self::assertCount(0, $doc->getElementsByTagName('form'));
		self::assertSame('p', $doc->getElementsByTagName('p')->item(0)?->nodeName);
	}
}
