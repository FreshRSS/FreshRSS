<?php
declare(strict_types=1);

use FreshRss\Utils\PasswordUtil;
use PHPUnit\Framework\TestCase;

final class passwordUtilTest extends TestCase {
	public function testCheck(): void {
		$password = '1234567';

		$ok = PasswordUtil::check($password);

		self::assertTrue($ok);
	}

	public function testCheckReturnsFalseIfEmpty(): void {
		$password = '';

		$ok = PasswordUtil::check($password);

		self::assertFalse($ok);
	}

	public function testCheckReturnsFalseIfLessThan7Characters(): void {
		$password = '123456';

		$ok = PasswordUtil::check($password);

		self::assertFalse($ok);
	}
}
