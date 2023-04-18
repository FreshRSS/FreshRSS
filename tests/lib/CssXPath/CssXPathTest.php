<?php

class CssXPathTest extends PHPUnit\Framework\TestCase
{
	public function testCssXPathTranslatorClassExists(): void {
		$this->assertTrue(class_exists('Gt\\CssXPath\\Translator'));
	}
}
