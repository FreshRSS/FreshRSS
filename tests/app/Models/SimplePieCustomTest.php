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

	/** @return list<array{string,string}> */
	public static function provideMaliciousHtml(): array {
		return [
			// script tag is removed
			['<script>alert(1)</script>Hello', '<script'],
			// inline event handler is removed
			['<img src="x" onerror="alert(1)">', 'onerror'],
			// javascript: URL is neutralised
			['<a href="javascript:alert(1)">click</a>', 'href="javascript:'],
			// style tag is removed
			['<style>body{display:none}</style>Hello', '<style'],
		];
	}

	public static function test_sanitizeHTML_whenSafeHtml_keepsAllowedTags(): void {
		$result = FreshRSS_SimplePieCustom::sanitizeHTML('<p>Hello <b>world</b></p>');
		self::assertSame('<p>Hello <b>world</b></p>', $result);
	}

	public static function test_sanitizeHTML_whenMaxLengthIsZeroOrNegative_returnsEmptyString(): void {
		self::assertSame('', FreshRSS_SimplePieCustom::sanitizeHTML('<p>Hello world</p>', '', 0));
		self::assertSame('', FreshRSS_SimplePieCustom::sanitizeHTML('<p>Hello world</p>', '', -1));
	}

	public static function test_sanitizeHTML_whenResultFitsWithinMaxLength_isUnaffected(): void {
		$result = FreshRSS_SimplePieCustom::sanitizeHTML('<p>Hello world</p>', '', 100);
		self::assertSame('<p>Hello world</p>', $result);
	}

	/**
	 * Regression test: sanitizing can grow a truncated fragment (e.g. `<p>He` gets auto-closed into
	 * `<p>He</p>`), which used to make sanitizeHTML() recurse on itself without ever converging,
	 * causing an infinite loop / stack overflow. It must always terminate and respect maxLength.
	 */
	#[DataProvider('provideMaxLengthInputs')]
	public static function test_sanitizeHTML_whenMaxLengthForcesReSanitizing_terminatesWithinBound(string $input, int $maxLength): void {
		$result = FreshRSS_SimplePieCustom::sanitizeHTML($input, '', $maxLength);
		self::assertLessThanOrEqual($maxLength, strlen($result));
	}

	/** @return list<array{string,int}> */
	public static function provideMaxLengthInputs(): array {
		return [
			// unclosed tag grows back when auto-closed
			['<p>Hello world</p>', 5],
			// repeated short tags near the boundary
			[str_repeat('<b>x</b> ', 50), 20],
			// single character budget
			['<p>Hello world</p>', 1],
		];
	}
}
