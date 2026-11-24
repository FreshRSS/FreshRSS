<?php
declare(strict_types=1);

use FreshRss\Minz\Url;
use PHPUnit\Framework\Attributes\DataProvider;

final class LibRssTest extends \PHPUnit\Framework\TestCase {

	#[DataProvider('provideLazyimg')]
	public function test_lazyimg(string $content, string $expected): void {
		self::assertSame($expected, lazyimg($content));
	}

	public function test_lazyimg_regex_failure_preserves_content(): void {
		// Simulate the failure of PCRE on potentially large documents, e.g. because of backtracking limits
		$limit = ini_get('pcre.backtrack_limit');
		self::assertIsString($limit);
		ini_set('pcre.backtrack_limit', '1');
		try {
			$input = '<video poster="p.jpg"><img src="a.png"></video>';
			self::assertSame($input, lazyimg($input));
		} finally {
			ini_set('pcre.backtrack_limit', $limit);
		}
	}

	public function test_lazyimg_overlong_tags_are_skipped(): void {
		// Tags with more than 1000 characters of attributes are expected to be skipped (eager loading)
		$overlong = str_repeat('a', 1001);
		self::assertSame('<img alt="' . $overlong . '" src="a.png">', lazyimg('<img alt="' . $overlong . '" src="a.png">'));
		self::assertSame('<video data-x="' . $overlong . '" poster="p.jpg"></video>',
			lazyimg('<video data-x="' . $overlong . '" poster="p.jpg"></video>'));

		// Under the limit, the work is still bounded and lazy loading is applied
		$atLimit = str_repeat('a', 980);	// 6 + 980 + 13 = 999 characters of attributes
		$placeholder = Url::display('/themes/icons/grey.gif');
		self::assertSame('<img loading="lazy" alt="' . $atLimit . '" src="a.png">',
			lazyimg('<img alt="' . $atLimit . '" src="a.png">'));
		self::assertSame('<video data-x="' . $atLimit . '" poster="' . $placeholder . '" data-original="p.jpg"></video>',
			lazyimg('<video data-x="' . $atLimit . '" poster="p.jpg"></video>'));
	}

	/** @return array<string,array{string,string}> */
	public static function provideLazyimg(): array {
		$placeholder = Url::display('/themes/icons/grey.gif');
		return [
			'ordinary image' => ['<img src="a.png">', '<img loading="lazy" src="a.png">'],
			'multiple tags' => ['<img src="1.png"><iframe src="2.html" width="9"></iframe>',
				'<img loading="lazy" src="1.png"><iframe loading="lazy" src="2.html" width="9"></iframe>'],
			'video poster' => ['<video poster="p.jpg"></video>', '<video poster="' . $placeholder . '" data-original="p.jpg"></video>'],
			'video poster with other attributes' => ['<video poster="p.jpg" width="9"></video>',
				'<video poster="' . $placeholder . '" data-original="p.jpg" width="9"></video>'],
			'video without poster untouched' => ['<video src="v.mp4"></video>', '<video src="v.mp4"></video>'],
			'track element' => ['<track src="t.vtt">', '<track src="' . $placeholder . '" data-original="t.vtt">'],
			'video and track elements' => ['<video poster="p.jpg" width="9"><track src="t.vtt" srclang="en"></video>',
				'<video poster="' . $placeholder . '" data-original="p.jpg" width="9">'
					. '<track src="' . $placeholder . '" data-original="t.vtt" srclang="en"></video>'],
			'track data-src is not rewritten' => ['<track data-src="x.vtt">', '<track data-src="x.vtt">'],
			'poster inside attribute value untouched' => ['<video title="poster=" src="v.mp4"></video>',
				'<video title="poster=" src="v.mp4"></video>'],
			'legacy video data-original untouched' => ['<video data-original="p.jpg" poster="p.jpg"></video>',
				'<video data-original="p.jpg" poster="p.jpg"></video>'],
			'case insensitive' => ['<IMG SRC="A.PNG">', '<IMG loading="lazy" SRC="A.PNG">'],

			'already lazy' => ['<img loading="lazy" src="a.png">', '<img loading="lazy" src="a.png">'],
			'deliberate eager opt-out kept' => ['<img loading="eager" src="a.png">', '<img loading="eager" src="a.png">'],
			'legacy data-original untouched' => ['<iframe data-original="x.pdf" src="alias.pdf">',
				'<iframe data-original="x.pdf" src="alias.pdf">'],
			'tag name boundary' => ['<imgish src="a.png">', '<imgish src="a.png">'],
			'end tag untouched' => ['</img src="a.png">', '</img src="a.png">'],

			'iframe data-src is not rewritten' => ['<iframe data-src="javascript:x()">', '<iframe loading="lazy" data-src="javascript:x()">'],

			'src inside a title value' => [
				'<iframe title="src=" data-x=" srcdoc=\'<p>doc</p>\' sandbox=\'allow-scripts allow-same-origin allow-forms\' " src="doc.pdf">',
				'<iframe loading="lazy" title="src=" data-x=" srcdoc=\'<p>doc</p>\' sandbox=\'allow-scripts allow-same-origin allow-forms\' " src="doc.pdf">',
			],
			'value holding a comment and a tag' => [
				'<img alt="src=" title=" <!-- ><a href=x>t</a><i title=--> " src="u.png">',
				'<img loading="lazy" alt="src=" title=" <!-- ><a href=x>t</a><i title=--> " src="u.png">',
			],
			'single quote look-alike' => [
				'<img alt=\'" src=\' title="x\' onerror=\'e()\' data-x=" src="u.png">',
				'<img loading="lazy" alt=\'" src=\' title="x\' onerror=\'e()\' data-x=" src="u.png">',
			],

			'processing instruction' => ['<?pi <img title="?><p title=" src="u.png">',
				'<?pi <img loading="lazy" title="?><p title=" src="u.png">'],
		];
	}
}
