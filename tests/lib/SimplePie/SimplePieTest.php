<?php
declare(strict_types=1);

final class SimplePieTest extends PHPUnit\Framework\TestCase
{
	public function testSimplePieClassExists(): void {
		self::assertTrue(class_exists(\SimplePie\SimplePie::class));
	}

	public function testSimplePieMiscClassExists(): void {
		self::assertTrue(class_exists(\SimplePie\Misc::class));
	}

	public function testPsr0SimplePieClassExists(): void {
		self::assertTrue(class_exists('SimplePie'));
	}

	public function testPsr0SimplePieMiscClassExists(): void {
		self::assertTrue(class_exists('SimplePie_Misc'));
	}
}
