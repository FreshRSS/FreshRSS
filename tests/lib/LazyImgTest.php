<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

/**
 * Tests for the lazyimg() function of lib_rss.php
 */
class LazyImgTest extends \PHPUnit\Framework\TestCase {

	#[DataProvider('provideContents')]
	public function test_lazyimg(string $content, string $expected): void {
		self::assertSame($expected, lazyimg($content));
	}

	/** @return list<array{string,string}> */
	public static function provideContents(): array {
		return [
			// Adds loading="lazy" to images and iframes
			['<img src="a.jpg">', '<img loading="lazy" src="a.jpg">'],
			["<img src='a.jpg'>", "<img loading=\"lazy\" src='a.jpg'>"],
			['<IMG SRC="a.jpg">', '<IMG loading="lazy" SRC="a.jpg">'],
			['<iframe src="https://example.com/"></iframe>', '<iframe loading="lazy" src="https://example.com/"></iframe>'],

			// Does not duplicate an existing loading attribute
			['<img loading="eager" src="a.jpg">', '<img loading="eager" src="a.jpg">'],
			['<img src="a.jpg" loading="lazy">', '<img src="a.jpg" loading="lazy">'],

			// data-loading is not mistaken for the loading attribute
			['<img data-loading="x" src="a.jpg">', '<img loading="lazy" data-loading="x" src="a.jpg">'],

			// Native loading is only for img/iframe: video/track are left untouched
			['<video poster="p.jpg"></video>', '<video poster="p.jpg"></video>'],
			['<track src="s.vtt">', '<track src="s.vtt">'],

			// Multiple tags in a fragment, mixed states
			[
				'<p>text <img src="a.jpg"> and <img loading="eager" src="b.jpg"></p>',
				'<p>text <img loading="lazy" src="a.jpg"> and <img loading="eager" src="b.jpg"></p>',
			],

			// No image/iframe: content is returned unchanged
			['<p>no media here</p>', '<p>no media here</p>'],
			['', ''],
		];
	}
}
