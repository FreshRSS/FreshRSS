<?php
declare(strict_types=1);

final class SimplePieCustomTest extends \PHPUnit\Framework\TestCase {

	#[\Override]
	public static function setUpBeforeClass(): void {
		FreshRSS_Context::initSystem();
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

	public function test_sanitizeHTML_keepsLegitimateImgSrc(): void {
		$html = '<img src="https://example.com/real.jpg" srcset="https://example.com/a.jpg 100w, https://example.com/b.jpg 500w" alt="x">';
		$out = FreshRSS_SimplePieCustom::sanitizeHTML($html);
		self::assertStringContainsString('src="https://example.com/real.jpg"', $out);
	}

	public function test_sanitizeHTML_skipsSrcsetWithDensityOnlyDescriptors(): void {
		$html = '<img src="" srcset="https://example.com/a.jpg 1x, https://example.com/b.jpg 2x" alt="x">';
		$out = FreshRSS_SimplePieCustom::sanitizeHTML($html);
		// No Nw entries -> we don't touch src; srcset is left intact for the browser.
		self::assertStringNotContainsString('src="https://example.com/a.jpg"', $out);
		self::assertStringNotContainsString('src="https://example.com/b.jpg"', $out);
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
}
