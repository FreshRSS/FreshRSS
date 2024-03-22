<?php
declare(strict_types=1);

class CssXPathTest extends PHPUnit\Framework\TestCase
{
	public function testCssXPathTranslatorClassExists(): void {
		self::assertTrue(class_exists('Gt\\CssXPath\\Translator'));
	}
}
