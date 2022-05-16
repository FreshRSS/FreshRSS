<?php

class SimplePieTest extends PHPUnit\Framework\TestCase
{
	public function testPsr0SimplePieClassExists() {
		$this->assertTrue(class_exists('SimplePie'));
	}

	public function testPsr0SimplePieMiscClassExists() {
		$this->assertTrue(class_exists('SimplePie_Misc'));
	}
}
