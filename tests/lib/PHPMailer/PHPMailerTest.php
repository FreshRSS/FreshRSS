<?php

class PHPMailerTest extends PHPUnit\Framework\TestCase
{
	public function testPHPMailerClassExists(): void {
		$this->assertTrue(class_exists('PHPMailer\\PHPMailer\\PHPMailer'));
	}
}
