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

	/**
	 * Test malformed HTML.
	 * Legacy `DOMDocument` cannot properly handle some unclosed tags,
	 * but PHP 8.4+ native `Dom\HTMLDocument` parser can.
	 */
	#[DataProvider('provideUnclosedDivInListItem')]
	public static function test_sanitizeHTML_whenUnclosedDivInListItem_keepsListItemsAsSiblings(string $input, string $listTag): void {
		if (PHP_VERSION_ID < 80400 || get_parent_class(\Dom\HTMLDocument::class) === \DOMDocument::class) {
			self::markTestSkipped('Requires the HTML5 parser of a native `Dom\HTMLDocument` (PHP 8.4+)');
		}
		$sanitized = FreshRSS_SimplePieCustom::sanitizeHTML($input);
		// Embed the result in a minimal page-like context to detect stray closing tags.
		// Fragment of a page, so prefix with `<!DOCTYPE html>`
		$document = \Dom\HTMLDocument::createFromString(
			'<!DOCTYPE html><div class="box">' . $sanitized . '<p id="fragmark">MARK</p></div>',
			\Dom\HTML_NO_DEFAULT_NS);
		$list = $document->querySelector($listTag);
		self::assertNotNull($list, 'The list wrapper must be preserved');
		$listItems = 0;
		foreach ($list->childNodes as $child) {
			if ($child instanceof \Dom\Element && $child->localName === 'li') {
				$listItems++;
			}
		}
		self::assertSame(2, $listItems, 'Both list items must be direct children of their list');
		$mark = $document->querySelector('#fragmark');
		self::assertInstanceOf(\Dom\Element::class, $mark);
		$markParent = $mark->parentNode;
		self::assertInstanceOf(\Dom\Element::class, $markParent);
		self::assertSame('box', $markParent->getAttribute('class'), 'The content after the fragment must stay inside its page container');
	}

	/** @return Traversable<string,array{string,string}> */
	public static function provideUnclosedDivInListItem(): Traversable {
		yield 'Footnote list' => [<<<'HTML'
			<p>In the end.</p><ol class="footnotes">
			<li id="footnote_0" class="footnote">First footnote. The full article follows: <hr><div class='footnote'></p>
			<p><hr></li><li id="footnote_3" class="footnote">Second footnote.</li></ol>
			HTML, 'ol'];
		// Unclosed `<div>` inside a list item
		yield 'Unclosed div in list item' => [<<<'HTML'
			<ul><li>Text within the first item.<div class="info"></li>
			<li>Text within the next item.</li></ul>
			<p>Text after the list.</p>
			HTML, 'ul'];
		// In HTML5, an `<li>` start tag must close the previous `<li>`, despite the still-open `<div>`
		yield 'Minimal unclosed div' => [<<<'HTML'
			<ul><li>a<div></li><li>b</li></ul>
			HTML, 'ul'];
	}
}
