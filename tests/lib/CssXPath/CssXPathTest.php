<?php
declare(strict_types=1);

final class CssXPathTest extends \PHPUnit\Framework\TestCase
{
	public static function testCssXPathTranslatorClassExists(): void {
		self::assertTrue(class_exists('GT\\CssXPath\\Translator'));
	}

	/**
	 * Test case-insensitive attribute flag, e.g. `link[href][rel~="icon" i]`
	 */
	public static function testCssXPathAttributeCaseFlag(): void {
		$doc = \Dom\HTMLDocument::createFromString(<<<'HTML'
			<!DOCTYPE html>
			<html><body>
				<link rel="ICON" href="a.ico" />
				<link rel="shortcut icon" href="b.ico" />
				<link rel="alternate" href="c.xml" />
			</body></html>
			HTML, LIBXML_NOERROR | Dom\HTML_NO_DEFAULT_NS);
		$xpath = new \Dom\XPath($doc);

		$links = $xpath->query((string)new \GT\CssXPath\Translator('link[href][rel~="icon" i]', './/'));
		self::assertSame(2, $links->length);
		$link0 = $links->item(0);
		$link1 = $links->item(1);
		self::assertInstanceOf(Dom\Element::class, $link0);
		self::assertInstanceOf(Dom\Element::class, $link1);
		self::assertSame('a.ico', $link0->getAttribute('href'));
		self::assertSame('b.ico', $link1->getAttribute('href'));
	}
}
