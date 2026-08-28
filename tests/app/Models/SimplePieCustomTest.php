<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

/**
 * FreshRSS_SimplePieCustom::sanitizeHTML() is the XSS defence applied to all untrusted feed
 * content (entry content, entry/feed descriptions) before it is stored or displayed.
 */
final class SimplePieCustomTest extends \PHPUnit\Framework\TestCase {

	#[\Override]
	public static function setUpBeforeClass(): void {
		FreshRSS_Context::initSystem();
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
}
