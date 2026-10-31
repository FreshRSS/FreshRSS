<?php
declare(strict_types=1);

final class rssViewTest extends \PHPUnit\Framework\TestCase {

	#[\Override]
	public static function setUpBeforeClass(): void {
		// `FreshRSS_View` needs a system configuration; the shipped defaults are enough to render a feed.
		Minz_Configuration::register('system', FRESHRSS_PATH . '/config.default.php', FRESHRSS_PATH . '/config.default.php');
	}

	/** @param array<string,mixed> $enclosure */
	private static function renderEntryWithEnclosure(array $enclosure): string {
		$entry = new FreshRSS_Entry(1, 'guid', 'Title', '', 'Content', 'https://example.net/article', 1700000000);
		$entry->_attribute('enclosures', [$enclosure]);

		$view = new FreshRSS_View();
		$view->_path('index/rss.phtml');
		$view->internal_rendering = true;
		$view->rss_title = 'Test';
		$view->rss_url = 'https://example.net/rss';
		$view->html_url = 'https://example.net/';
		$view->description = 'Test';
		$view->entries = [$entry];

		return $view->renderToString();
	}

	/** An enclosure with several `<media:credit>` must keep them all, see https://github.com/FreshRSS/FreshRSS/issues/5066 */
	public function test_rss_multipleEnclosureCredits(): void {
		$rss = self::renderEntryWithEnclosure([
			'url' => 'https://example.net/audio.mp3',
			'type' => 'audio/mpeg',
			'credit' => ['Alice', 'Bob', 'Carol'],
		]);
		self::assertStringContainsString(
			'<media:credit>Alice</media:credit><media:credit>Bob</media:credit><media:credit>Carol</media:credit>', $rss);
	}

	/** Entries older than FreshRSS 1.24 store a single credit as a string instead of an array */
	public function test_rss_legacySingleEnclosureCredit(): void {
		$rss = self::renderEntryWithEnclosure([
			'url' => 'https://example.net/audio.mp3',
			'type' => 'audio/mpeg',
			'credit' => 'Alice',
		]);
		self::assertStringContainsString('<media:credit>Alice</media:credit>', $rss);
	}
}
