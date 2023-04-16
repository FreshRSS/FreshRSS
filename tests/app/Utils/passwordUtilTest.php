<?php

class passwordUtilTest extends PHPUnit\Framework\TestCase {
	public function testCheck(): void {
		$password = '1234567';

		$ok = FreshRSS_password_Util::check($password);

		$this->assertTrue($ok);
	}

	public function testCheckReturnsFalseIfEmpty(): void {
		$password = '';

		$ok = FreshRSS_password_Util::check($password);

		$this->assertFalse($ok);
	}

	public function testCheckReturnsFalseIfLessThan7Characters(): void {
		$password = '123456';

		$ok = FreshRSS_password_Util::check($password);

		$this->assertFalse($ok);
	}
}
