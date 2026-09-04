<?php
declare(strict_types=1);

final class CssSelectorTest extends \PHPUnit\Framework\TestCase {
	public static function testQuerySelectorAllFallsBackToCssXPath(): void {
		$document = new DOMDocument();
		$document->loadHTML('<div class="post"><p class="remove">Remove</p><p>Keep</p></div>');

		$nodes = iterator_to_array(FreshRSS_CssSelector::querySelectorAll($document, 'div.post > .remove'));

		self::assertCount(1, $nodes);
		self::assertInstanceOf(DOMElement::class, $nodes[0]);
		self::assertSame('p', $nodes[0]->nodeName);
		self::assertSame('remove', $nodes[0]->getAttribute('class'));
	}

	public static function testFallbackSelectorIncludesTheContextNode(): void {
		$document = new DOMDocument();
		$document->loadHTML('<div class="post"><p>Keep</p></div>');
		$context = FreshRSS_CssSelector::querySelector($document, 'div.post');

		self::assertInstanceOf(DOMElement::class, $context);
		$nodes = iterator_to_array(FreshRSS_CssSelector::querySelectorAll($document, 'div.post', $context));

		self::assertSame([$context], $nodes);
	}

	public static function testQuerySelectorAllUsesNativeDomWhenAvailable(): void {
		if (!FreshRSS_CssSelector::nativeSelectorsAvailable()) {
			self::markTestSkipped('Native DOM CSS selectors require PHP 8.4.');
		}

		$document = FreshRSS_CssSelector::loadHtml('<div class="post"><p class="remove">Remove</p><p>Keep</p></div>');

		self::assertIsObject($document);
		self::assertTrue(FreshRSS_CssSelector::isNativeDocument($document));
		$nodes = iterator_to_array(FreshRSS_CssSelector::querySelectorAll($document, 'div.post > .remove'));

		self::assertCount(1, $nodes);
		self::assertTrue(FreshRSS_CssSelector::matches($nodes[0], 'p.remove'));
		self::assertSame('remove', FreshRSS_CssSelector::getAttribute($nodes[0], 'class'));
	}
}
