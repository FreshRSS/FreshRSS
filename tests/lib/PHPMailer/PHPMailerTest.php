<?php
declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;

class PHPMailerTest extends PHPUnit\Framework\TestCase
{
	public function testPHPMailerClassExists(): void {
		self::assertTrue(class_exists(PHPMailer::class));
	}
}
