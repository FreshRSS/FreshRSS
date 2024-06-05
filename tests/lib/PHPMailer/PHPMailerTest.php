<?php
declare(strict_types=1);

class PHPMailerTest extends PHPUnit\Framework\TestCase
{
	public function testPHPMailerClassExists(): void {
		self::assertTrue(class_exists('PHPMailer\\PHPMailer\\PHPMailer'));
	}
}
