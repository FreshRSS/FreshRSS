<?php

class PHPMailerTest extends PHPUnit\Framework\TestCase
{
	public function testPHPMailerClassExists() {
		$this->assertTrue(class_exists('PHPMailer\\PHPMailer\\PHPMailer'));
	}
}
