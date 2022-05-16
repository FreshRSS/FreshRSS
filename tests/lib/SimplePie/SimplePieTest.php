<?php

class SimplePieTest extends PHPUnit\Framework\TestCase
{
	public function testSimplePieClassExists() {
		$this->markTestIncomplete('This test has not been implemented yet.');

		$this->assertTrue(class_exists('SimplePie\SimplePie'));
	}

	public function testPsr0SimplePieClassExists() {
		$this->assertTrue(class_exists('SimplePie'));
	}

	public function testPsr0SimplePieMiscClassExists() {
		$this->assertTrue(class_exists('SimplePie_Misc'));
	}
}
