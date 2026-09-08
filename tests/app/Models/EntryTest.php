<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

final class EntryTest extends \PHPUnit\Framework\TestCase {

	/** @return list<array{string,bool}> */
	public static function provideUrlSchemes(): array {
		return [
			['https://example.com/podcast.mp3', true],
			['HTTPS://EXAMPLE.com/a.mp3', true],
			['http://example.com/a.mp3', true],
			['javascript:alert(document.domain)//', false],
			['JAVASCRIPT:alert(1)', false],
			["java\tscript:alert(1)", false],
			['java\nscript:alert(1)', false],
			['vbscript:msgbox(1)', false],
			['data:image/png;base64,AAAA', false],
			['file:///etc/passwd', false],
			['relative/path.mp3', false],
			['', false],
		];
	}

	#[DataProvider('provideUrlSchemes')]
	public function test_isAllowedUrlScheme(string $url, bool $expected): void {
		self::assertSame($expected, \SimplePie\Misc::is_remote_uri($url));
	}

	public function test_content_dropsUnsafeEnclosureUrls(): void {
		$entry = new FreshRSS_Entry(1, 'poc-001', 'Victim Article', '', 'Hello', '', 1700000000);
		$entry->_attribute('enclosures', [
			['url' => 'javascript:alert(document.domain)//', 'type' => 'application/octet-stream'],
			['url' => 'https://example.com/podcast.mp3', 'type' => 'audio/mpeg'],
			['url' => 'https://example.com/pic.jpg', 'thumbnails' => [
				'javascript:alert(1)',
				'https://example.com/thumb.jpg',
			]],
		]);
		$entry->_attribute('thumbnail', ['url' => 'javascript:alert(2)']);

		$html = $entry->content();

		self::assertStringNotContainsString('javascript:', $html);
		self::assertStringContainsString('href="https://example.com/podcast.mp3"', $html);
		self::assertStringContainsString('src="https://example.com/thumb.jpg"', $html);
		self::assertStringContainsString('Hello', $html);
	}

	public function test_content_dropsUnsafeThumbnailAttribute(): void {
		$entry = new FreshRSS_Entry(1, 'poc-002', 'Victim Article', '', 'Hello', '', 1700000000);
		$entry->_attribute('thumbnail', ['url' => 'javascript:alert(2)']);

		$html = $entry->content();

		self::assertStringNotContainsString('javascript:', $html);
		self::assertStringContainsString('Hello', $html);
	}
}
