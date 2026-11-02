<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

/**
 * FreshRSS_SimplePieCustom::sanitizeHTML() is the XSS defence applied to all untrusted feed
 * content (entry content, entry/feed descriptions) before it is stored or displayed.
 */
final class SimplePieCustomTest extends \PHPUnit\Framework\TestCase {

	#[\Override]
	protected function setUp(): void {
		if (!FreshRSS_Context::hasSystemConf()) {
			FreshRSS_Context::initSystem();
		}
	}

	public static function test_sanitizeHTML_whenEmptyString_returnsEmptyString(): void {
		self::assertSame('', FreshRSS_SimplePieCustom::sanitizeHTML(''));
	}

	public static function test_sanitizeHTML_whenPlainText_returnsUnchanged(): void {
		self::assertSame('plain text', FreshRSS_SimplePieCustom::sanitizeHTML('plain text'));
	}

	#[DataProvider('provideMaliciousHtml')]
	public static function test_sanitizeHTML_whenMaliciousInput_stripsDangerousContent(string $input, string $mustNotContain): void {
		$result = FreshRSS_SimplePieCustom::sanitizeHTML($input);
		self::assertStringNotContainsString($mustNotContain, $result);
	}

	/** @return Traversable<string,array{string,string}> */
	public static function provideMaliciousHtml(): Traversable {
		yield 'script tag' => ['<script>alert(1)</script>Hello', '<script'];
		yield 'inline event handler' => ['<img src="x" onerror="alert(1)">', 'onerror'];
		yield 'JavaScript URL' => ['<a href="javascript:alert(1)">click</a>', 'href="javascript:'];
		yield 'style tag' => ['<style>body{display:none}</style>Hello', '<style'];
		yield 'data:text/html URL in link' => ['<a href="data:text/html,<script>alert(1)</script>">click</a>', 'href="data:'];
		yield 'data:text/html URL in iframe' => ['<iframe src="data:text/html,<script>alert(1)</script>"></iframe>', 'src="data:'];
		yield 'data:text/html URL in image' => ['<img src="data:text/html,<script>alert(1)</script>">', 'src="data:'];
		yield 'data:image URL in link' => ['<a href="data:image/png;base64,iVBORw0KGgo=">click</a>', 'href="data:'];
	}

	public static function test_sanitizeHTML_whenSafeHtml_keepsAllowedTags(): void {
		$result = FreshRSS_SimplePieCustom::sanitizeHTML('<p>Hello <b>world</b></p>');
		self::assertSame('<p>Hello <b>world</b></p>', $result);
	}

	public static function test_sanitizeHTML_whenUnsafeAttributeIsRemoved_keepsAllowedTag(): void {
		self::assertSame('Hello <br>', FreshRSS_SimplePieCustom::sanitizeHTML('Hello <br onclick="x">'));
		self::assertSame('Hello <br>', FreshRSS_SimplePieCustom::sanitizeHTML('Hello <br onclick="x">', maxLength: 100));
	}

	public static function test_sanitizeHTML_whenMaxLengthIsZeroOrNegative_returnsEmptyString(): void {
		self::assertSame('', FreshRSS_SimplePieCustom::sanitizeHTML('<p>Hello world</p>', maxLength: 0));
		self::assertSame('', FreshRSS_SimplePieCustom::sanitizeHTML('<p>Hello world</p>', maxLength: -1));
	}

	public static function test_sanitizeHTML_whenResultFitsWithinMaxLength_isUnaffected(): void {
		$result = FreshRSS_SimplePieCustom::sanitizeHTML('<p>Hello world</p>', maxLength: 100);
		self::assertSame('<p>Hello world</p>', $result);
	}

	public static function test_sanitizeHTML_whenUnsafePrefixExceedsMaxLength_keepsSafeText(): void {
		self::assertSame('text', FreshRSS_SimplePieCustom::sanitizeHTML('<script>NOK</script><p>text', maxLength: 5));
	}

	/**
	 * Sanitizing can grow a truncated fragment (e.g. `<p>He` gets sanitized into `<p>He</p>`)
	 */
	#[DataProvider('provideMaxLengthInputs')]
	public static function test_sanitizeHTML_whenMaxLengthForcesReSanitizing_terminatesWithinBound(string $input, int $maxLength): void {
		$result = FreshRSS_SimplePieCustom::sanitizeHTML($input, maxLength: $maxLength);
		self::assertLessThanOrEqual($maxLength, strlen($result));
	}

	/** @return Traversable<string,array{string,int}> */
	public static function provideMaxLengthInputs(): Traversable {
		yield 'unclosed tag' => ['<p>Hello world</p>', 5];
		yield 'repeated short tags' => [str_repeat('<b>x</b> ', 50), 20];
		yield 'single-character budget' => ['<p>Hello world</p>', 1];
	}

	#[DataProvider('provideIncompleteTagsOrEntities')]
	public static function test_sanitizeHTML_Cases(string $input, int $maxLength, string $expected): void {
		$result = FreshRSS_SimplePieCustom::sanitizeHTML($input, maxLength: $maxLength);
		self::assertLessThanOrEqual($maxLength, strlen($result));
		self::assertSame(trim($expected), trim($result));
	}

	/** @return Traversable<string,array{string,int,string}> */
	public static function provideIncompleteTagsOrEntities(): Traversable {
		yield 'unclosed tag not fitting' => ['<span>Hello</span> <span>World', 31, '<span>Hello</span>'];
		yield 'unclosed entity' => ['Hello&#8230;', 9, 'Hello'];
		yield 'double unclosed tag' => ['<b> <b>x', 10, 'x'];
		yield 'triple unclosed tag' => [' <b><b><b>y', 20, 'y'];
	}

	/**
	 * Inline `data:image/...` URIs are inert in `<img>` and widely used by feeds, so they must survive
	 * while `data:` is blocked on navigational/framing attributes (see provideMaliciousHtml()).
	 */
	public static function test_sanitizeHTML_whenDataImageUri_keepsItOnImageElements(): void {
		$png = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';
		self::assertSame('<img src="' . $png . '" alt="">', FreshRSS_SimplePieCustom::sanitizeHTML('<img src="' . $png . '" alt="">'));
		self::assertStringContainsString('poster="' . $png . '"', FreshRSS_SimplePieCustom::sanitizeHTML('<video poster="' . $png . '"></video>'));
	}

	public static function test_sanitizeHTML_whenDisallowedScheme_prefixesUnsafe(): void {
		$result = FreshRSS_SimplePieCustom::sanitizeHTML('<a href="data:text/html,x">click</a>');
		self::assertStringContainsString('href="unsafe:data:text/html,x"', $result);
	}

	public function test_sanitizeHTML_picksSmallestSrcsetWidthWhenSrcIsDataUri(): void {
		// `src` is a fallback for clients that can't honour `srcset`; the smallest
		// entry is the safest by bandwidth and never larger than browser pick.
		$html = '<img srcset="https://example.com/s.jpg 80w, https://example.com/m.jpg 350w, https://example.com/l.jpg 2000w" '
			. 'src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" alt="x">';
		$out = FreshRSS_SimplePieCustom::sanitizeHTML($html);
		self::assertStringContainsString('src="https://example.com/s.jpg"', $out);
		self::assertStringNotContainsString('data:image/gif', $out);
	}

	public function test_sanitizeHTML_recognisesGifPlaceholderRegardlessOfLength(): void {
		// The R0lGODlh prefix is the de-facto universal 1x1 transparent GIF
		// marker; treat it as a placeholder even if padded past the 128-char threshold.
		$gif = 'data:image/gif;base64,R0lGODlh' . str_repeat('A', 200);
		$html = '<img src="' . $gif . '" srcset="https://example.com/real.jpg 500w" alt="x">';
		$out = FreshRSS_SimplePieCustom::sanitizeHTML($html);
		self::assertStringContainsString('src="https://example.com/real.jpg"', $out);
		self::assertStringNotContainsString('R0lGODlh', $out);
	}

	public function test_sanitizeHTML_retainsSrcsetAttribute(): void {
		$html = '<img src="data:image/gif;base64,xxx" srcset="https://example.com/a.jpg 100w, https://example.com/b.jpg 500w" alt="x">';
		$out = FreshRSS_SimplePieCustom::sanitizeHTML($html);
		self::assertStringContainsString('srcset=', $out);
		self::assertStringContainsString('https://example.com/a.jpg 100w', $out);
		self::assertStringContainsString('https://example.com/b.jpg 500w', $out);
	}

	public function test_sanitizeHTML_retainsSizesAttribute(): void {
		$html = '<img src="https://example.com/x.jpg" '
			. 'srcset="https://example.com/a.jpg 100w, https://example.com/b.jpg 500w" '
			. 'sizes="(max-width: 800px) 100vw, 800px" alt="x">';
		$out = FreshRSS_SimplePieCustom::sanitizeHTML($html);
		self::assertStringContainsString('sizes="(max-width: 800px) 100vw, 800px"', $out);
	}

	public function test_sanitizeHTML_absolutisesRelativeSrcsetUrls(): void {
		$html = '<img src="" srcset="/img/a.jpg 100w, /img/b.jpg 500w" alt="x">';
		$out = FreshRSS_SimplePieCustom::sanitizeHTML($html, 'https://example.com/articles/page');
		self::assertStringContainsString('https://example.com/img/a.jpg 100w', $out);
		self::assertStringContainsString('https://example.com/img/b.jpg 500w', $out);
		self::assertStringNotContainsString('srcset="/img/', $out);
	}

	public function test_sanitizeHTML_emptySrcWithBaseStillGetsSrcsetFallback(): void {
		// An empty `src` must not be resolved to the document base before the
		// placeholder check, or `src` ends up pointing at the article page.
		$html = '<img src="" srcset="/img/a.jpg 100w, /img/b.jpg 500w" alt="x">';
		$out = FreshRSS_SimplePieCustom::sanitizeHTML($html, 'https://example.com/articles/page');
		self::assertStringContainsString('src="https://example.com/img/a.jpg"', $out);
		self::assertStringNotContainsString('src="https://example.com/articles/page"', $out);
	}

	public function test_sanitizeHTML_keepsLegitimateImgSrc(): void {
		$html = '<img src="https://example.com/real.jpg" srcset="https://example.com/a.jpg 100w, https://example.com/b.jpg 500w" alt="x">';
		$out = FreshRSS_SimplePieCustom::sanitizeHTML($html);
		self::assertStringContainsString('src="https://example.com/real.jpg"', $out);
	}

	public function test_sanitizeHTML_fallsBackToLowestDensityWhenNoWidthEntries(): void {
		// No Nw entries: clients that only read src would keep the placeholder,
		// so fall back to the lowest-density entry instead.
		$html = '<img src="" srcset="https://example.com/b.jpg 2x, https://example.com/a.jpg 1x" alt="x">';
		$out = FreshRSS_SimplePieCustom::sanitizeHTML($html);
		self::assertStringContainsString('src="https://example.com/a.jpg"', $out);
	}

	public function test_sanitizeHTML_prefersWidthOverDensityForFallbackSrc(): void {
		$html = '<img src="" srcset="https://example.com/d.jpg 1x, https://example.com/w.jpg 300w" alt="x">';
		$out = FreshRSS_SimplePieCustom::sanitizeHTML($html);
		self::assertStringContainsString('src="https://example.com/w.jpg"', $out);
	}

	public function test_sanitizeHTML_absolutisesDensityOnlySrcsetUrls(): void {
		$html = '<img src="" srcset="/img/a.jpg 1x, /img/a@2x.jpg 2x" alt="x">';
		$out = FreshRSS_SimplePieCustom::sanitizeHTML($html, 'https://example.com/page');
		self::assertStringContainsString('https://example.com/img/a.jpg 1x', $out);
		self::assertStringContainsString('https://example.com/img/a@2x.jpg 2x', $out);
	}

	public function test_sanitizeHTML_keepsDensityEntriesWhenMixedWithWidthEntries(): void {
		$html = '<img src="data:image/gif;base64,xxx" '
			. 'srcset="https://example.com/a.jpg 100w, https://example.com/b.jpg 500w, https://example.com/c@2x.jpg 2x" alt="x">';
		$out = FreshRSS_SimplePieCustom::sanitizeHTML($html);
		self::assertStringContainsString('https://example.com/a.jpg 100w', $out);
		self::assertStringContainsString('https://example.com/b.jpg 500w', $out);
		self::assertStringContainsString('https://example.com/c@2x.jpg 2x', $out);
	}

	public function test_sanitizeHTML_doesNotDoubleEncodeAmpersandFromSrcset(): void {
		$html = '<img src="" srcset="https://example.com/img?w=80&amp;v=1 80w, https://example.com/img?w=500&amp;v=1 500w" alt="x">';
		$out = FreshRSS_SimplePieCustom::sanitizeHTML($html);
		self::assertStringNotContainsString('&amp;amp;', $out);
	}

	public function test_sanitizeHTML_noOpOnImgWithoutSrcset(): void {
		$html = '<img src="https://example.com/x.jpg" alt="x">';
		$out = FreshRSS_SimplePieCustom::sanitizeHTML($html);
		self::assertStringContainsString('src="https://example.com/x.jpg"', $out);
	}

	public function test_sanitizeHTML_preservesBareSrcsetEntryWithoutDescriptor(): void {
		$html = '<img src="data:image/gif;base64,xxx" srcset="https://example.com/a.jpg" alt="x">';
		$out = FreshRSS_SimplePieCustom::sanitizeHTML($html);
		self::assertStringContainsString('srcset="https://example.com/a.jpg"', $out);
		self::assertStringNotContainsString('https://example.com/a.jpg 1x', $out);
	}

	public function test_sanitizeHTML_rewritesSourceSrcsetInPicture(): void {
		$html = '<picture>'
			. '<source srcset="/img/a.jpg 500w, /img/b.jpg 1500w" sizes="100vw">'
			. '<img src="/img/fallback.jpg" alt="x">'
			. '</picture>';
		$out = FreshRSS_SimplePieCustom::sanitizeHTML($html, 'https://example.com/page');
		self::assertStringContainsString('<source ', $out);
		self::assertStringContainsString('https://example.com/img/a.jpg 500w', $out);
		self::assertStringContainsString('https://example.com/img/b.jpg 1500w', $out);
		self::assertStringContainsString('sizes="100vw"', $out);
		// <source> does not have a src attribute even if the img placeholder logic considered it.
		self::assertDoesNotMatchRegularExpression('/<source[^>]*\ssrc=/', $out);
	}

	public function test_sanitizeHTML_preservesLongInlineBase64Src(): void {
		$big = 'data:image/png;base64,' . str_repeat('A', 300);
		$html = '<img src="' . $big . '" srcset="https://example.com/a.jpg 500w" alt="x">';
		$out = FreshRSS_SimplePieCustom::sanitizeHTML($html);
		self::assertStringContainsString('src="' . $big . '"', $out);
	}

	public function test_sanitizeHTML_preservesMidSizedInlineBase64Src(): void {
		// ~150 chars: comfortably larger than typical 1x1 placeholders but small
		// enough that a loose threshold would have misclassified it.
		$mid = 'data:image/png;base64,' . str_repeat('A', 150);
		$html = '<img src="' . $mid . '" srcset="https://example.com/a.jpg 500w" alt="x">';
		$out = FreshRSS_SimplePieCustom::sanitizeHTML($html);
		self::assertStringContainsString('src="' . $mid . '"', $out);
	}

	public function test_sanitizeHTML_keepsCommasInsideSrcsetUrls(): void {
		// Cloudinary-style transformation URLs contain unencoded commas;
		// splitting on every comma would corrupt them.
		$html = '<img src="" srcset="'
			. 'https://res.example.com/upload/w_300,c_scale/a.jpg 300w, '
			. 'https://res.example.com/upload/w_600,c_scale/a.jpg 600w" alt="x">';
		$out = FreshRSS_SimplePieCustom::sanitizeHTML($html);
		self::assertStringContainsString('https://res.example.com/upload/w_300,c_scale/a.jpg 300w', $out);
		self::assertStringContainsString('https://res.example.com/upload/w_600,c_scale/a.jpg 600w', $out);
		self::assertStringContainsString('src="https://res.example.com/upload/w_300,c_scale/a.jpg"', $out);
	}

	public function test_sanitizeHTML_parsesSrcsetEntriesSeparatedByCommaWithoutSpace(): void {
		$html = '<img src="" srcset="https://example.com/a.jpg 100w,https://example.com/b.jpg 500w" alt="x">';
		$out = FreshRSS_SimplePieCustom::sanitizeHTML($html);
		self::assertStringContainsString('https://example.com/a.jpg 100w', $out);
		self::assertStringContainsString('https://example.com/b.jpg 500w', $out);
		self::assertStringContainsString('src="https://example.com/a.jpg"', $out);
	}

	public function test_sanitizeHTML_dropsDisallowedSchemesFromSrcset(): void {
		// The srcset rewrite runs after replace_urls, so a disallowed scheme
		// must not survive in srcset nor be written into the src fallback.
		$html = '<img src="" srcset="javascript:alert(1) 100w, https://example.com/a.jpg 500w" alt="x">';
		$out = FreshRSS_SimplePieCustom::sanitizeHTML($html);
		self::assertStringNotContainsString('javascript:', $out);
		self::assertStringContainsString('src="https://example.com/a.jpg"', $out);
	}

	public function test_sanitizeHTML_removesSrcsetWhenAllEntriesDisallowed(): void {
		$html = '<img src="https://example.com/x.jpg" srcset="javascript:alert(1) 100w" alt="x">';
		$out = FreshRSS_SimplePieCustom::sanitizeHTML($html);
		self::assertStringNotContainsString('srcset', $out);
		self::assertStringContainsString('src="https://example.com/x.jpg"', $out);
	}
}
