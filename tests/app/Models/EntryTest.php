<?php
declare(strict_types=1);

final class EntryTest extends \PHPUnit\Framework\TestCase {
	private static function fixedImageSrc(string $imgHtml): string {
		$doc = new DOMDocument();
		$doc->loadHTML('<!DOCTYPE html><html><body>' . $imgHtml . '</body></html>', LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);
		$xpath = new DOMXPath($doc);
		$body = $doc->getElementsByTagName('body')->item(0);
		self::assertInstanceOf(DOMElement::class, $body);
		FreshRSS_Entry::replaceLazyLoadedImagePlaceholders($xpath, $body);
		$image = $doc->getElementsByTagName('img')->item(0);
		self::assertInstanceOf(DOMElement::class, $image);
		return $image->getAttribute('src');
	}

	public static function testReplaceLazyLoadedImagePlaceholdersUsesDataSrcWhenSrcIsEmpty(): void {
		self::assertSame(
			'https://example.net/real.jpg',
			self::fixedImageSrc('<img src="" data-src="https://example.net/real.jpg">'),
		);
	}

	public static function testReplaceLazyLoadedImagePlaceholdersUsesDataSrcWhenSrcIsDataUrl(): void {
		self::assertSame(
			'https://example.net/real.jpg',
			self::fixedImageSrc('<img src="data:image/gif;base64,R0lGODlh" data-src="https://example.net/real.jpg">'),
		);
	}

	public static function testReplaceLazyLoadedImagePlaceholdersUsesDataSrcWhenSrcIsOnePixelSpacer(): void {
		self::assertSame(
			'https://example.net/real.jpg',
			self::fixedImageSrc('<img src="/assets/1x1-spacer.gif" data-src="https://example.net/real.jpg">'),
		);
	}

	public static function testReplaceLazyLoadedImagePlaceholdersLeavesRealSrcUntouched(): void {
		self::assertSame(
			'https://example.net/real.jpg',
			self::fixedImageSrc('<img src="https://example.net/real.jpg" data-src="https://example.net/other.jpg">'),
		);
	}

	public static function testReplaceLazyLoadedImagePlaceholdersFallsBackThroughAttributesInOrder(): void {
		self::assertSame(
			'https://example.net/from-original.jpg',
			self::fixedImageSrc('<img src="" data-src-template="" data-original="https://example.net/from-original.jpg">'),
		);
	}

	public static function testReplaceLazyLoadedImagePlaceholdersRejectsJavascriptScheme(): void {
		self::assertSame(
			'',
			self::fixedImageSrc('<img src="" data-src="javascript:alert(1)">'),
		);
	}

	public static function testReplaceLazyLoadedImagePlaceholdersRejectsJavascriptSchemeSplitByTab(): void {
		self::assertSame(
			'',
			self::fixedImageSrc("<img src=\"\" data-src=\"java\tscript:alert(1)\">"),
		);
	}

	public static function testReplaceLazyLoadedImagePlaceholdersRejectsJavascriptSchemeSplitByNewline(): void {
		self::assertSame(
			'',
			self::fixedImageSrc("<img src=\"\" data-src=\"java\nscript:alert(1)\">"),
		);
	}

	public static function testReplaceLazyLoadedImagePlaceholdersAcceptsProtocolRelativeUrl(): void {
		self::assertSame(
			'//example.net/real.jpg',
			self::fixedImageSrc('<img src="" data-src="//example.net/real.jpg">'),
		);
	}
}
