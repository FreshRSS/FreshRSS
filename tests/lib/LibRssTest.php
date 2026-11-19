<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

final class LibRssTest extends \PHPUnit\Framework\TestCase {

	#[DataProvider('provideLazyimg')]
	public function test_lazyimg(string $content, string $expected): void {
		self::assertSame($expected, lazyimg($content));
	}

	/** @return array<string,array{string,string}> */
	public static function provideLazyimg(): array {
		return [
			'ordinary image' => ['<img src="a.png">', '<img loading="lazy" src="a.png">'],
			'multiple tags' => ['<img src="1.png"><iframe src="2.html" width="9"></iframe>',
				'<img loading="lazy" src="1.png"><iframe loading="lazy" src="2.html" width="9"></iframe>'],
			'video poster' => ['<video poster="p.jpg"></video>', '<video loading="lazy" poster="p.jpg"></video>'],
			'track element' => ['<track src="t.vtt">', '<track loading="lazy" src="t.vtt">'],
			'case insensitive' => ['<IMG SRC="A.PNG">', '<IMG loading="lazy" SRC="A.PNG">'],

			'already lazy' => ['<img loading="lazy" src="a.png">', '<img loading="lazy" src="a.png">'],
			'deliberate eager opt-out kept' => ['<img loading="eager" src="a.png">', '<img loading="eager" src="a.png">'],
			'legacy data-original untouched' => ['<iframe data-original="x.pdf" src="alias.pdf">',
				'<iframe data-original="x.pdf" src="alias.pdf">'],
			'tag name boundary' => ['<imgish src="a.png">', '<imgish src="a.png">'],
			'end tag untouched' => ['</img src="a.png">', '</img src="a.png">'],

			'data-src is not rewritten' => ['<iframe data-src="javascript:x()">', '<iframe loading="lazy" data-src="javascript:x()">'],

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
